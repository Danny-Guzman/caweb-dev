<?php
/**
 * Main Options File
 *
 * @package ODWPI
 */

add_action('admin_menu', 'odwpi_dev_plugin_menu');
add_action('network_admin_menu', 'odwpi_dev_plugin_menu');

/**
 * CAWeb NetAdmin Administration Menu Setup
 * Fires before the administration menu loads in the admin.
 *
 * @link https://developer.wordpress.org/reference/hooks/admin_menu/
 * @return void
 */
function odwpi_dev_plugin_menu() {

	add_menu_page("ODWPI Dev", 'ODWPI Dev', 'manage_options', 'odwpi-dev', 'odwpi_dev_main_page', '');
	add_submenu_page('odwpi-dev', 'Development', 'Developer Panel', 'manage_options', 'odwpi-dev', 'odwpi_dev_main_page');
}

/**
 * Setup Main Options Page
 *
 * @return void
 */
function odwpi_dev_main_page(){
	require_once(ODWPI_DEV_PLUGIN_DIR ."/partials/dev-panel.php");
}

/**
 * Save Plugin Settings
 *
 * @return void
 */

function odwpi_dev_update_settings() {
	$verified = isset( $_POST['caweb_netadmin_settings_nonce'] ) &&
		wp_verify_nonce( sanitize_key( $_POST['caweb_netadmin_settings_nonce'] ), 'caweb_netadmin_settings' );

	$devUsers = isset($_POST['devUsers']) ? $_POST['devUsers'] : array();
	$dev = array();

	foreach($devUsers as $i => $d){
		$id = substr($d, strrpos($d, '-') + 1 );
		$user = substr($d, 0, strrpos($d, '-'));

		$dev[$id] = $user;

	}
	update_site_option('odwpi_dev_users', $dev);
}
