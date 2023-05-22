<?php
/**
 * Plugin Name: ODWPI Developer Tool
 * Plugin URI: ""
 * Description: Code in realtime and query against the database.
 * Author: Jesus D. Guzman
 * Version: 2.0.0
 *
 * @package ODWPI
 */

define( 'ODWPI_DEV_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'ODWPI_DEV_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

add_action( 'init', 'odwpi_dev_init' );
add_action( 'admin_enqueue_scripts', 'odwpi_dev_admin_enqueue_scripts_styles' );

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
function odwpi_dev_init() {
	/* Include ODWPI Functionality */
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
function odwpi_dev_admin_enqueue_scripts_styles( $hook ) {
	$additional_pages = array( 'ide', 'port' );

	$pages = array( 'toplevel_page_odwpi-dev' );

	foreach ( $additional_pages as $p ) {
		$pages[] = 'odwpi-dev_page_odwpi-dev-' . $p;
	}

	$ver = get_plugin_data( __FILE__ )['Version'];

	if ( ! in_array( $hook, $pages, true ) ) {
		return;
	}

	$admin_js  = odwpi_dev_get_min_file( 'dist/admin.js', 'js' );

	// Enqueue Core Script.
	wp_enqueue_script( 'odwpi-dev-core-js', $admin_js, array( 'jquery' ), $ver, false );


}
