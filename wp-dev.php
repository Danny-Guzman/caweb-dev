<?php

/*
Plugin Name: ODWPI Developer Tool
Plugin URI: ""
Author: Jesus D. Guzman
Version: 1.0.1
Author URI: ""
 */

define('ODWPIDEVPLUGINURL', plugins_url('', __FILE__));
define('ODWPIDEVPLUGINDIR', dirname(__FILE__));

include(ODWPIDEVPLUGINDIR . '/options.php');
include(ODWPIDEVPLUGINDIR . '/functions/additional_functions.php');
include(ODWPIDEVPLUGINDIR . '/functions/odwpi-ajax.php');
include(ODWPIDEVPLUGINDIR . '/functions/odwpi-post.php');

function odwpi_dev_allowed() {
	$developers = get_site_option('odwpi_dev_users', array());

	return array_key_exists(get_current_user_id(), $developers);
}

// Menu Setup
add_action(is_multisite() ? 'network_admin_menu' : 'admin_menu', 'odwpi_dev_plugin_menu', 9);
function odwpi_dev_plugin_menu() {
	$cap = is_multisite() ? 'manage_network_options' : 'manage_options';

	$dev_allowed =  odwpi_dev_allowed();

	$setup = $dev_allowed ? 'odwpi_dev_main_page' : 'odwpi_dev_settings_page';
	$page = $dev_allowed ? 'dev' : 'settings';

	add_menu_page("ODWPI Dev", 'ODWPI Dev', $cap, "odwpi-$page", $setup, '');

	// Add Main Menu
	if ($dev_allowed) {
		add_submenu_page('odwpi-dev', 'Development', 'Developer Panel', $cap, 'odwpi-dev', 'odwpi_dev_main_page');
	}

	// Add Settings Menu
	add_submenu_page('odwpi-dev', 'Settings', 'Settings', $cap, 'odwpi-settings', 'odwpi_dev_settings_page');
}

function odwpi_dev_enqueue_scripts_styles($hook) {
	$pages = array('toplevel_page_odwpi-dev', 'toplevel_page_odwpi-settings', 'odwpi-dev_page_odwpi-settings');

	$ver = get_plugin_data(__FILE__, false, false)['Version'];

	if ( ! in_array($hook, $pages)) {
		return;
	}

	// Enqueue Bootstrap 4.3.1 CSS
	wp_enqueue_style('odwpi_dev_bootstrap_css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css', array(), '4.3.1');

	// Enqueue Core CSS
	wp_enqueue_style('odwpi_dev_css', ODWPIDEVPLUGINURL . '/css/core.css', array(), $ver);

	// Register Bootstrap 4.3.1 and Popper 1.14.7
	wp_register_script('odwpi_dev_popper_js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', array('jquery'), '1.14.7', true);
	wp_register_script('odwpi_dev_bootstrap_js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js', array('jquery'), '4.3.1', true);

	// Register Helper Script
	wp_register_script('odwpi_dev_helper_script', ODWPIDEVPLUGINURL . '/js/helper.js', array('jquery'), $ver);

	// Enqueue Core Script along with Helper, Popper, and Bootstrap
	wp_enqueue_script('odwpi_dev_core_script', ODWPIDEVPLUGINURL . '/js/core.js', array('jquery', 'odwpi_dev_helper_script', 'odwpi_dev_popper_js', 'odwpi_dev_bootstrap_js'), $ver);
}
add_action('admin_enqueue_scripts', 'odwpi_dev_enqueue_scripts_styles');

// End of File

?>