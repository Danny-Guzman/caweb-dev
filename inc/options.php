<?php
/**
 * Main Options File
 *
 * @package ODWPI
 */

add_action(is_multisite() ? 'network_admin_menu' : 'admin_menu', 'odwpi_dev_plugin_menu');

/**
 * CAWeb NetAdmin Administration Menu Setup
 * Fires before the administration menu loads in the admin.
 *
 * @link https://developer.wordpress.org/reference/hooks/admin_menu/
 * @return void
 */
function odwpi_dev_plugin_menu() {
	$cap = is_multisite() ? 'manage_network_options' : 'manage_options';

	$dev_allowed =  true; //odwpi_dev_allowed();

	$setup = $dev_allowed ? 'odwpi_dev_main_page' : 'odwpi_dev_settings_page';
	$page = $dev_allowed ? 'dev' : 'settings';

	add_menu_page("ODWPI Dev", 'ODWPI Dev', $cap, "odwpi-$page", $setup, '');

	// Add Main Menu
	if ($dev_allowed) {
		add_submenu_page('odwpi-dev', 'Development', 'Developer Panel', $cap, 'odwpi-dev', 'odwpi_dev_main_page');
	}

	// Add Settings Menu
	//add_submenu_page('odwpi-dev', 'Settings', 'Settings', $cap, 'odwpi-settings', 'odwpi_dev_settings_page');
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

/**
 * Options save message hook
 *
 * @param  mixed $error If there were any errors.
 *
 * @return void
 */
function odwpi_dev_mime_option_notices( $error = false ) {
	if ( true === $error ) {
		print '<div class="notice notice-error is-dismissible"><p><strong>ODWPI</strong> some changes could not be saved.</p>
			<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
	} else {
		print '<div class="notice notice-success is-dismissible"><p><strong>ODWPI</strong> changes updated successfully.</p>
			<button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
	}
}
