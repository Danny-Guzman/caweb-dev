<?php
/**
 * Plugin Name: CAWebPublishing Development Toolbox
 * Plugin URI: "https://github.com/CAWebPublishing/caweb-dev/"
 * Description: Code in realtime and query against the database using an IDE.
 * Author: Jesus D. Guzman
 * Version: 1.0.0
 * Requires at least: 6.2
 * Requires PHP: 8.2
 * 
 * @package CAWeb Dev
 */

define( 'CAWEB_DEV_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CAWEB_DEV_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );


add_action( 'init', 'caweb_dev_init' );
add_action( 'admin_enqueue_scripts', 'caweb_dev_admin_enqueue_scripts_styles', 99 );

register_activation_hook( __FILE__, 'caweb_dev_activate' );

/**
 * Run actions when this plugin is activated.
 *
 * @return void
 */
function caweb_dev_activate(){
	// only run if on local environment.
	if( ! defined('WP_ENVIRONMENT_TYPE') || 'local' !== WP_ENVIRONMENT_TYPE ){
		return;
	}

	$default_theme = defined('WP_DEFAULT_THEME') ? WP_DEFAULT_THEME : '';

	// switch to default theme if its set and exists.
	if( array_key_exists($default_theme, wp_get_themes() ) && ! empty( $default_theme ) ){
		switch_theme( $default_theme );
	}

}

/**
 * Initialization
 *
 * Triggered before any other hook when a user accesses the admin area.
 * Note, this does not just run on user-facing admin screens.
 * It runs on admin-ajax.php and admin-post.php as well.
 *
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/init
 * @return void
 */
function caweb_dev_init() {
	/* Include CAWeb Functionality */
	foreach ( glob( __DIR__ . '/core/*.php' ) as $file ) {
		require_once $file;
	}
}

/**
 * Admin Enqueue Scripts and Styles
 *
 * @link https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/
 * @param  string $hook The current admin page.
 *
 * @return void
 */
function caweb_dev_admin_enqueue_scripts_styles( $hook ) {
	$additional_pages = array( 'ide', 'port' );

	$pages = array( 'toplevel_page_caweb-dev' );

	foreach ( $additional_pages as $p ) {
		$pages[] = 'caweb-dev_page_caweb-dev-' . $p;
	}

	$ver = get_plugin_data( __FILE__ )['Version'];

	if ( ! in_array( $hook, $pages, true ) ) {
		return;
	}

	$admin_css  = caweb_dev_get_min_file( 'build/index.css' );
	$admin_js  = caweb_dev_get_min_file( 'build/index.js', 'js' );

	wp_register_script( 'caweb-dev-core', $admin_js, array( 'jquery' ), $ver, true );

	// Enqueue Core Script.
	wp_enqueue_script( 'caweb-dev-core' );
	wp_enqueue_style( 'caweb-dev-core', $admin_css, array(), $ver );


}
