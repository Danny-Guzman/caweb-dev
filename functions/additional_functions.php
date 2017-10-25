<?php
if( !function_exists('caweb_get_sites') ){
	function caweb_get_sites($args = array()){
		$args['deleted'] = 0;
		$tmp = get_sites($args);
		usort($tmp, "sort_by_blogname");
		return $tmp;
	}
}
if( !function_exists('sort_by_blogname') ){
	function sort_by_blogname($a, $b)
	{
			return strcasecmp( $a->blogname, $b->blogname);
	}
}

if( !function_exists('caweb_find_shortcode_in_content') ){
	function caweb_find_shortcode_in_content($sID = -1, $pID = -1, $searchstring = '', $clauses = array() , $all_matches = false, &$result_container = array()){
		if( empty($searchstring) )
			return false;

			$sites = (0 < $sID ? $sID : caweb_get_sites(array('fields'=>'ids')) ) ;
		$results = array() ;
		$hold =  array() ;
			if($pID !== -1){
				if(is_array($pID)){
					$clauses[] = sprintf('ID in(%1$s)', implode(', ', $pID) );
				}else{
					$clauses[] = sprintf('ID in(%1$s)',  $pID );
				}
			}
		if( is_array($sites) ){
			foreach($sites as $site_id){
				$posts[$site_id] = caweb_query_database('ID, post_content, guid, post_title', 'wp_'.$site_id.'_posts', $clauses)  ;
				foreach($posts[$site_id] as $p){
					$hold = caweb_get_shortcode_from_content($p->post_content, $searchstring, $all_matches);
					if( !empty($hold) )
						$results .= sprintf('<a href="%1$s">%2$s</a>',$p->guid, $p->post_title);
					if( $all_matches ){
						if( !empty($hold) ){
								$result_container += $hold;
						}elseif(empty($hold) ){
							$result_container += array();
						}
				}
				}
			}
		}else{
      $posts = caweb_query_database('ID, post_content, guid, post_title', ($sID == 1 ? 'wp_posts' : 'wp_'.$sID.'_posts' ), $clauses )  ;
				foreach($posts as $p){
						$hold = caweb_get_shortcode_from_content($p->post_content, $searchstring, $all_matches);
					if( !empty($hold) ){
						foreach($hold as $result){
										$results[] = sprintf('<a href="%1$s">%2$s</a>',$p->guid, $p->post_title);
								if( $all_matches )
										$result_container[] = $result;
						}
					}else{
						$results[] = '';//sprintf('<li><a href="%1$s">%2$s</a></li>',$p->guid, $p->post_title);
						if( !$all_matches )
							$result_container[] = array();
					}
				}
		}
			return $results;

	}
}
if( !function_exists('caweb_get_shortcode_from_content') ){
	function caweb_get_shortcode_from_content($con = "", $tag = "", $all_matches = false){
	if( empty($con) || empty($tag) )
			return array();
		$content = array();
		// Get Shortcode Tag from Con and save it to Content
    $pattern = sprintf('/\[(%1$s)[\d\s\w\S]+?\[\/\1\]|\[(%1$s)[\d\s\w\S]+? \/\]/', $tag);
		preg_match_all($pattern, $con, $content );
    if(empty($content))
      return array();
      $matches = $content[0];
      $objects = array();
      foreach($matches as $match){
        $obj = array();
        $attr = array();
        $tmp = array();
        preg_match($pattern, $match, $tmp) ;

        if(2 == count($tmp)){
          preg_match(sprintf('/"\][\s\S]*\[\/%1$s/', $tag), $tmp[0], $obj['content']);
          $hold = substr($tmp[0], 1, strpos($tmp[0], $obj['content'][0]) );
           // Get Attributes from Shortcode
            preg_match_all('/\w*="[\w\s\d$:(),@?\'=+%!#\/\.\[\]\{\}-]*/', $hold, $attr);
            foreach($attr[0] as $a){
                preg_match('/\w*/', $a, $key);
              $obj[$key[0]] = urldecode( substr($a, strlen($key[0]) + 2 ) );
            }
          $obj['content'] = strip_tags( substr($obj['content'][0], 2, strlen($obj['content'][0]) - strlen($tag) - 4 ) );
        }else{
           // Get Attributes from Shortcode
            preg_match_all('/\w*="[\w\s\d$:(),@?\'=+%!#\/\.\[\]\{\}-]*/', $tmp[0], $attr);
            foreach($attr[0] as $a){
                preg_match('/\w*/', $a, $key);
              $obj[$key[0]] = urldecode(substr($a, strlen($key[0]) + 2 ) );
            }
          	$obj['content'] = '';
        }
        $objects[] =  (object) $obj ;
      }
      if($all_matches)
        return $objects;
		return (!empty($objects) ? $objects[0] : array() );
	}
}
if( !function_exists('caweb_find_in_post_content') ){
	function caweb_find_in_post_content($sID = -1, $pID = -1, $searchstring = '' , $clauses = array(), $search_options = array(0,0) ){
		$sites = (0 < $sID ? $sID : caweb_get_sites(array('fields'=>'ids')) ) ;
		$posts = array();
		$hold = array();

		if($pID !== -1){
			if(is_array($pID)){
				$clauses[] = sprintf('ID in(%1$s)', implode(', ', $pID) );
			}else{
				$clauses[] = sprintf('ID in(%1$s)',  $pID );
			}
		}
		if( empty($searchstring) )
			return array();

		if( is_array($sites) ){
			foreach($sites as $site_id){
				$posts[$site_id] = caweb_query_database('ID, post_content, guid, post_title', 'wp_'.$site_id.'_posts', $clauses)  ;
				foreach($posts[$site_id] as $p){
					$p->site_id = $site_id;
					$con = wp_remote_retrieve_body( wp_remote_get($p->guid) ) ;
					if($search_options[0]){
						$searchstring = strtolower($searchstring);
						$con = strtolower($con);
					}
					$con = html_entity_decode ($con, ENT_HTML5 );
					if( ($search_options[1] &&  preg_match(sprintf('/%1$s/', $searchstring) , $con ) ) ||
						(!$search_options[1] && strpos($con , $searchstring)) ){
						array_push($hold, $p);
					}
				}
			}
		}else{
			$posts = caweb_query_database('ID, post_content, guid, post_title', 'wp_'.$sID.'_posts', $clauses )  ;

			foreach($posts as $p){
				$con = wp_remote_retrieve_body( wp_remote_get($p->guid) ) ;
						if($search_options[0]){
							$searchstring = strtolower($searchstring);
							$con = strtolower($con);
						}
						$con = html_entity_decode ($con, ENT_HTML5 );

						if( ($search_options[1] &&  preg_match(sprintf('/%1$s/', $searchstring) , $con ) ) ||
								(!$search_options[1] && strpos($con , $searchstring) ) ){
							array_push($hold, $p);
						}
			}
		}
		return  $hold;
	}
}
function caweb_query_database($cols, $tbls, $clauses = array()){
	global $wpdb;
	if( !empty($cols) &&  is_array( $cols ) ) {
		$cols = implode(', ', $cols);
	}elseif(!empty($cols) && !is_string( $cols)){
		$cols = "*";
	}
	if( !empty($tbls) &&  is_array( $tbls ) ) {
		$tbls = implode(', ', $tbls);
	}elseif(!empty($tbls) && !is_string( $tbls)){
		return  "No Table Selected.";
	}
	if( !empty($clauses) &&  is_array( $clauses ) ) {
		$clauses = implode(' and ', $clauses);
	}elseif(!empty($tbls) && !is_string( $tbls)){
		$clauses = "";
	}
  $sql = sprintf('SELECT %1$s FROM %2$s %3$s',
								$cols,  $tbls, ( !empty($clauses) ? sprintf('WHERE %1$s' , $clauses) : '') );
	return $wpdb->get_results( $sql );
}
if( !function_exists('caweb_get_excerpt') ){
	function caweb_get_excerpt($con, $excerpt_length){
			if( empty($con) )
			return $con;
		if(count( explode(" ", $con) ) > $excerpt_length){
			$txt = explode(" ", $con);
			$excerpt = array_splice(  $txt, 0, $excerpt_length);
			$excerpt = implode(" ", $excerpt) . '...';
			return $excerpt;
		}else{
			return $con;
		}
	}
}
if(!function_exists('caweb_get_network_active_plugins')){
	function caweb_get_network_active_plugins(){
		$active = wp_get_active_network_plugins();
		$data = array();
		foreach($active as $i => $p){
			$data[str_replace( WP_PLUGIN_DIR . '/', '', $p)] =  (object) get_plugin_data($p);
			$data[str_replace( WP_PLUGIN_DIR . '/', '', $p)]->location = $p;
		}
		return $data;
	}
}
if(!function_exists('caweb_get_plugins_for_blog')){
	function caweb_get_plugins_for_blog($id, $network_allowed = false){
		$network_plugins = caweb_get_network_active_plugins();
		$network_plugins = (empty($network_plugins) ? array() : $network_plugins);
		$site_plugins = get_blog_option($id, 'active_plugins');
		$tmp = array();
		if( !empty($site_plugins) ){
			foreach($site_plugins as $sp=> $p){
				$tmp[$p] =  (object) get_plugin_data(sprintf('%1$s/%2$s', WP_PLUGIN_DIR, $p ));
				$tmp[$p]->location = sprintf('%1$s/%2$s', WP_PLUGIN_DIR, $p );
			}
		}
		if(!$network_allowed)
			return $tmp;
		return array_merge($network_plugins, $tmp);
	}
}
if(!function_exists('caweb_get_blogs_with_active_plugin')){
	function caweb_get_blogs_with_active_plugin($plugin_name){
		$site_ids = caweb_get_sites(array('fields'=>'ids') );
		$tmp = array();
		foreach( $site_ids as $s){
			$plugs = caweb_get_plugins_for_blog($s, true);
			if(array_key_exists($plugin_name, $plugs))
				$tmp[] = $s;
		}

		return caweb_get_sites(array('site__in' => $tmp));
	}
}
?>
