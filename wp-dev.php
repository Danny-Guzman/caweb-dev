<?php

/*
Plugin Name: ODWPI Developer Tool
Plugin URI: ""
Author: Jesus D. Guzman
Version: 1.0.1
Author URI: ""
*/

define('ODWPIDEVPLUGINURL', plugin_dir_url(__FILE__)   );
define('ODWPIDEVPLUGINDIR', plugin_dir_path( __FILE__ )  );

include(ODWPIDEVPLUGINDIR . '/functions/additional_functions.php');	
include(ODWPIDEVPLUGINDIR . '/options.php');	
include(ODWPIDEVPLUGINDIR . '/functions/odwpi-ajax.php');

//require_once(ODWPIDEVPLUGINDIR. '/core/update.php');



function odwpi_dev_allowed(){
		$developers = array(13);

		return true;
		return ( in_array(get_current_user_id(), $developers ) );
}


function odwpi_dev_enqueue_scripts_styles($hook){
	$pages = array( 'toplevel_page_odwpi-dev', 'odwpi-dev_page_odwpi-settings');

	if( !odwpi_dev_allowed() || !in_array($hook , $pages) )	
		return;

	wp_enqueue_style( 'odwpi_dev_css', ODWPIDEVPLUGINURL . '/css/core.css' );
	wp_register_script('odwpi_dev_script',ODWPIDEVPLUGINURL. '/js/core.js', array('jquery'), '1.0' );
	wp_enqueue_script( 'odwpi_dev_script' );
}

add_action( 'admin_enqueue_scripts', 'odwpi_dev_enqueue_scripts_styles' );

function odwpi_dev_plugin_menu() {

	if( !odwpi_dev_allowed() )	
		return;

	// Add Main Menu
	add_menu_page( "ODWPI Dev", 'ODWPI Dev', 'manage_network_options', 'odwpi-dev', 'odwpi_dev_main_page', sprintf('%1$s/odwpi_logo.png', ODWPIDEVPLUGINURL) );
	add_submenu_page( 'odwpi-dev', 'Development', 'Developer Panel','manage_network_options', 'odwpi-dev', 'odwpi_dev_main_page' );
	
	// Add Settings Menu
	add_submenu_page( 'odwpi-dev', 'Settings', 'Settings','manage_network_options', 'odwpi-settings', 'odwpi_dev_settings_page' );
}
add_action( 'network_admin_menu', 'odwpi_dev_plugin_menu', 9 );

/* End of File */

?>