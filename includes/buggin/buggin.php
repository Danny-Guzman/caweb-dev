<?php


define('BUGGINPLUGINURL', plugin_dir_url(__FILE__)  );
define('BUGGINPLUGINDIR', plugin_dir_path( __FILE__ )  );

include(BUGGINPLUGINDIR . '/functions/error.php');
include(BUGGINPLUGINDIR . '/options.php');

// Add Main Menu
function buggin_plugin_menu() {
	// Place under Buggin Menu
	//add_menu_page( "Buggin'", "Buggin'", 'manage_network_options', 'buggin', 'buggin_main_page' );
	//add_submenu_page( 'buggin', 'Debug Log', 'Debug Log','manage_network_options', 'buggin-debug-log', 'buggin_debug_log_page' );

	// Place under Caweb Dev Menu
	add_submenu_page( 'caweb-dev', 'Debug Log', 'Debug Log','manage_network_options', 'buggin-debug-log', 'buggin_debug_log_page' );

}
add_action( 'network_admin_menu', 'buggin_plugin_menu' );

// Administration Initialization
function buggin_plugin_init(){
	// enable admin notices for CAWeb
	//settings_errors('caweb_dev_plugin_options');


	register_setting('buggin', 'buggin_dev');
	
	register_setting('buggin', 'buggin_errors');
	register_setting('buggin', 'buggin_error_display');
	register_setting('buggin', 'buggin_error_types');

}
add_action( 'admin_init', 'buggin_plugin_init' );


?>
