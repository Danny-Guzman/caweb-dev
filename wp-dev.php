<?php
/*
Plugin Name: CAWeb Developer's Tool
Plugin URI: ""
Author: Jesus D. Guzman
Version: 1.0.1
Author URI: ""
*/

define('CAWEBDEVPLUGINURL', plugin_dir_url(__FILE__)   );
define('CAWEBDEVPLUGINDIR', plugin_dir_path( __FILE__ )  );
	

include(CAWEBDEVPLUGINDIR . '/functions/additional_functions.php');	
include(CAWEBDEVPLUGINDIR . '/options.php');	
include(CAWEBDEVPLUGINDIR . '/functions/caweb-ajax.php');

//require_once(CAWEBDEVPLUGINDIR. '/core/update.php');

function caweb_dev_allowed(){
		$developers = array(13);
  return true;
		return ( in_array(get_current_user_id(), $developers ) );
}



// Administration Initialization
function caweb_dev_plugin_init(){
	// enable admin notices for CAWeb 
	//settings_errors('caweb_dev_plugin_options');
	$opts = get_caweb_dev_plugin_options();
	
	foreach($opts as $o){
		register_setting('caweb_dev', $o);
	}
	

}
add_action( 'admin_init', 'caweb_dev_plugin_init' );

function caweb_dev_enqueue_scripts_styles($hook){
	if( !caweb_dev_allowed() )	
		return;
		
	$pages = array( 'toplevel_page_caweb-dev', 'caweb-dev_page_caweb-settings');
	
		// Load only on ?page=mypluginname
    if( in_array($hook , $pages) ){
			wp_enqueue_style( 'caweb_dev_css', CAWEBDEVPLUGINURL . '/css/core.css' );


			wp_register_script('caweb_dev_script',CAWEBDEVPLUGINURL. '/js/core.js', array('jquery'), '1.0' );

			wp_enqueue_script( 'caweb_dev_script' );
    }
		
}
add_action( 'admin_enqueue_scripts', 'caweb_dev_enqueue_scripts_styles' );

function caweb_dev_plugin_menu() {

	if( !caweb_dev_allowed() )	
		return;
	
	// Add Main Menu
	add_menu_page( "CAWeb Dev", 'CAWeb Dev', 'manage_network_options', 'caweb-dev', 'caweb_dev_main_page', sprintf('%1$s/caweb_logo.png', CAWEBDEVPLUGINURL) );
	add_submenu_page( 'caweb-dev', 'Development', 'Developer Panel','manage_network_options', 'caweb-dev', 'caweb_dev_main_page' );
	
}
add_action( 'network_admin_menu', 'caweb_dev_plugin_menu', 9 );

function caweb_dev_settings_plugin_menu(){
	
	if( !caweb_dev_allowed() )	
		return;
	
	// Add Settings Menu
	add_submenu_page( 'caweb-dev', 'Settings', 'Settings','manage_network_options', 'caweb-settings', 'caweb_dev_settings_page' );
}
add_action( 'network_admin_menu', 'caweb_dev_settings_plugin_menu', 11 );



// Add Extra Features
if( get_site_option('caweb_debugger_enabled', false) )
		include(CAWEBDEVPLUGINDIR . '/includes/buggin/buggin.php');

if( get_site_option('caweb_plugin_search_enabled', false) )
		include(CAWEBDEVPLUGINDIR . '/includes/pluggin/pluggin.php');


if( get_site_option('caweb_lookup_enabled', false) )
		include(CAWEBDEVPLUGINDIR . '/includes/lookup/lookie.php');
/* End of File */
?>
