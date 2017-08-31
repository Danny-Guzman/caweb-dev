<?php


define('PLUGINSEARCHURL', plugin_dir_url(__FILE__)  );
define('PLUGINSEARCHDIR', plugin_dir_path( __FILE__ )  );

include(PLUGINSEARCHDIR . '/options.php');
include(PLUGINSEARCHDIR . '/functions/pluggin-ajax.php');

// Add Main Menu
function pluggin_menu() {

	// Place under Caweb Dev Menu
		add_submenu_page( 'caweb-dev', 'Plugins', 'Plugins','manage_network_options', 'pluggin', 'pluggin_page' );

}
add_action( 'network_admin_menu', 'pluggin_menu' );


// Administration Initialization
function pluggin_init(){
	// enable admin notices for CAWeb
	//settings_errors('caweb_dev_plugin_options');


	register_setting('pluggin', 'pluggin_dev');

}
add_action( 'admin_init', 'pluggin_init' );


function pluggin_enqueue_scripts_styles($hook){
	
	$pages = array( 'toplevel_page_pluggin', 'caweb-dev_page_pluggin');
	
		// Load only on ?page=mypluginname
    if( in_array($hook , $pages) ){
			//wp_enqueue_style( 'caweb_dev_css', PLUGINSEARCHURL . '/css/core.css' );


			wp_register_script('pluggin_script',PLUGINSEARCHURL. '/js/core.js', array('jquery'), '1.0' );

			wp_enqueue_script( 'pluggin_script' );
    }
	
}
add_action( 'admin_enqueue_scripts', 'pluggin_enqueue_scripts_styles' );
?>
