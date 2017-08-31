<?php

define('LOOKIESEARCHURL', plugin_dir_url(__FILE__)  );
define('LOOKIESEARCHDIR', plugin_dir_path( __FILE__ )  );


include(LOOKIESEARCHDIR . '/options.php');
include(LOOKIESEARCHDIR . '/functions/lookie-ajax.php');

// Add Main Menu
function lookie_menu() {

	// Place under Caweb Dev Menu
		add_submenu_page( 'caweb-dev', 'Lookie', 'Lookie','manage_network_options', 'lookie', 'lookie_page' );

}
add_action( 'network_admin_menu', 'lookie_menu' );


// Administration Initialization
function lookie_init(){
	// enable admin notices for CAWeb
	//settings_errors('caweb_dev_plugin_options');


	register_setting('lookie', 'lookie_dev');

}
add_action( 'admin_init', 'lookie_init' );


function lookie_enqueue_scripts_styles($hook){
	
	$pages = array( 'toplevel_page_lookie', 'caweb-dev_page_lookie');
	
		// Load only on ?page=mypluginname
    if( in_array($hook , $pages) ){
			//wp_enqueue_style( 'caweb_dev_css', LOOKIESEARCHURL . '/css/core.css' );


			wp_register_script('lookie_script',LOOKIESEARCHURL. '/js/core.js', array('jquery'), '1.0' );

			wp_enqueue_script( 'lookie_script' );
    }
	
}
add_action( 'admin_enqueue_scripts', 'lookie_enqueue_scripts_styles' );

?>