<?php


add_action( 'wp_ajax_site_active_plugins_selected', 'site_active_plugins_selected' );

function site_active_plugins_selected() {
	$tmp = '';	
	$net =  ("true" === $_POST['network_included'] ? true : false) ;
	
	$site_plugins = caweb_get_plugins_for_blog($_POST['site_id'], $net );
		
	if( empty($site_plugins) ){
		print "No Active Plugins";
		
	}else{
		foreach($site_plugins as $s => $p){
			$tmp .= sprintf('<li>%1$s</li>',$p->Name);
		}
	}		
	
	print $tmp;
	wp_die(); // this is required to terminate immediately and return a proper response
}


add_action( 'wp_ajax_plugin_active_sites_selected', 'plugin_active_sites_selected' );

function plugin_active_sites_selected() {
	$site_plugins = caweb_get_blogs_with_active_plugin($_POST['plugname'] );
		
	if( empty($site_plugins) ){
		printf("No Sites Have Activated %1$s", $_POST['plugname']);
		
	}else{
		foreach($site_plugins as $s => $p){
			$tmp .= sprintf('<li>%1$s</li>',$p->blogname);
		}
	}		
	
	print $tmp;
	wp_die(); // this is required to terminate immediately and return a proper response
}



add_action( 'wp_ajax_plugin_by_site', 'plugin_by_site' );

function plugin_by_site() {
	// Get List of Sites
	$site = caweb_get_sites( array('deleted'=> 0) );
	
	foreach($site as $s){
		$hold .= sprintf('<option value="%2$d">%1$s</option>',$s->blogname, $s->blog_id);
	}
	
	// Get List of Plugins	
	$tmp = '';	
	$net =  ("true" === $_POST['network_included'] ? true : false) ;
	
	$site_plugins = caweb_get_plugins_for_blog($site[0]->blog_id, $net );
		
	if( empty($site_plugins) ){
		$tmp = "No Active Plugins";
		
	}else{
		foreach($site_plugins as $s => $p){
			$tmp .= sprintf('<li>%1$s</li>',$p->Name);
		}
	}		
	
	print_r( json_encode( array($hold, $tmp) ) );
	wp_die(); // this is required to terminate immediately and return a proper response
}


add_action( 'wp_ajax_plugin_by_name', 'plugin_by_name' );
function plugin_by_name() {
	// Get List of Plugins
	$plug = get_plugins( );
	
	foreach($plug as $s=> $p){
		$hold .= sprintf('<option value="%1$s">%2$s</option>',$s, $p['Name']);
	}
	
	// Get List of Sites	
	$tmp = '';	
	$net =  ("true" === $_POST['network_included'] ? true : false) ;
	
	$site_plugins = caweb_get_blogs_with_active_plugin( $plug[0]['Name'] );
		
	if( empty($site_plugins) ){
		$tmp = sprintf("No Sites Have Activated %1$s", $plug[0]['Name']);
		
	}else{
		foreach($site_plugins as $s => $p){
			$tmp .= sprintf('<li>%1$s</li>',$p->blogname);
		}
	}		
	
	print_r( json_encode( array($hold, $tmp) ) );
	wp_die(); // this is required to terminate immediately and return a proper response
}
?>