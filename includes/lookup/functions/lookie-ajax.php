<?php

add_action( 'wp_ajax_lookie_search', 'lookie_search' );

function lookie_search() {
	if( empty($_POST['keyword'] ) ){
		print '<h3 style="color: red;">Please enter a phrase to search for.</h3>';
		wp_die(); // this is required to terminate immediately and return a proper response
	}


	$searchstring = $_POST['keyword'] ;
	$site_name = ( isset($_POST['site_name']) ? sprintf('<h3>%1$s</h3>', $_POST['site_name']) : '') ;
	$site_id = ( isset($_POST['site_id']) ? (int) $_POST['site_id'] : -1) ;
	$page_id = ( isset($_POST['page_id']) ? (int) $_POST['page_id'] : -1 );

	$opts[] =  ("true" === $_POST['match_case'] ? true : false) ;
	$opts[] =  ("true" === $_POST['regex'] ? true : false) ;

	$published =  ("true" === $_POST['published'] ? '"publish"' : '') ;
	$draft =  ("true" === $_POST['draft'] ? '"draft"' : '') ;
	//$revision =  ("true" === $_POST['revision'] ? '"revision"' : '') ;
	$post_status = array_filter( array($published, $draft) ) ;
	$post_status = sprintf('post_status in(%1$s)', implode(',', $post_status) );


	$page =  ("true" === $_POST['page'] ? '"page"' : '') ;
	$post =  ("true" === $_POST['post'] ? '"post"' : '') ;
	$post_type = array_filter( array($page, $post) );
	$post_type = sprintf('post_type in(%1$s)', implode(',', $post_type) );

	$clause = array($post_status, $post_type);
	$results = array();

	if( strpos($searchstring, ',') !== false ){
		$searchstring =  explode(',', $searchstring);		
	}else{
		$searchstring =  array( $searchstring );	
	}
	
	foreach($searchstring as $search){
			$results[] = caweb_find_shortcode_in_content($site_id, $page_id, $search , $clause, true ) ;
		//$results[] = $rows;	
		}
	for($r = 0; $r < count($results); $r++){
		$results[$r] = array_filter($results[$r]);
	}
	
	$list = '';
	
	for($i = 0; $i < count($results); $i++){
			if( empty($results[$i]) ){
				$list .= sprintf('<li><h3>%1$s Not Found</h3></li><hr />', $searchstring[$i] );

				}else{
				$list .= sprintf('<li><h3>%1$s Found</h3></li><hr />', $searchstring[$i] );			
				foreach(array_count_values ($results[$i]) as $j => $r){
					$list .= sprintf('<li>%1$s %2$s occurrences</li>', $j, $r );
				}
			}

	}

	printf('<ul style="float: left;">%1$s%2$s</ul>', $site_name ,$list);
	//(empty($list) ? print '<li><h3>No Results</h3></li>' : printf('<li><h3>Results</h3></li>%1$s', $list) );

	wp_die(); // this is required to terminate immediately and return a proper response
}
add_action( 'wp_ajax_search_site_changed', 'search_site_changed' );

function search_site_changed() {

	$site_id = ( isset($_POST['site_id']) ? (int) $_POST['site_id'] : -1) ;
	$pages = '<option value="-1">Search All Pages</option>';

	if(-1 !== $site_id) {
		$published =  ("true" === $_POST['published'] ? '"publish"' : '') ;
		$draft =  ("true" === $_POST['draft'] ? '"draft"' : '') ;
		//$revision =  ("true" === $_POST['revision'] ? '"revision"' : '') ;
		$post_status = array_filter( array($published, $draft) ) ;
		$post_status = sprintf('post_status  in(%1$s)', implode(',', $post_status) );


		$page =  ("true" === $_POST['page'] ? '"page"' : '') ;
		$post =  ("true" === $_POST['post'] ? '"post"' : '') ;
		$post_type = array_filter( array($page, $post) );
		$post_type = sprintf('post_type in(%1$s)', implode(',', $post_type) );

		$clauses = array($post_status, $post_type);


		$all_pages = caweb_query_database('ID, post_title', 'wp_'.$site_id.'_posts', $clauses )  ;

		foreach($all_pages as $p => $pg){
				$pages .= sprintf('<option value="%1$s">%2$s</option>', $pg->ID,$pg->post_title);
		}
	}

	print $pages;
	wp_die(); // this is required to terminate immediately and return a proper response
}

?>
