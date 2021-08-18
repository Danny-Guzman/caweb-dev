<?php
/**
 * Main Options File
 *
 * @package ODWPI
 */

add_action( 'admin_menu', 'odwpi_dev_plugin_menu' );
add_action( 'network_admin_menu', 'odwpi_dev_plugin_menu' );

/**
 * CAWeb NetAdmin Administration Menu Setup
 * Fires before the administration menu loads in the admin.
 *
 * @link https://developer.wordpress.org/reference/hooks/admin_menu/
 * @return void
 */
function odwpi_dev_plugin_menu() {
	$cap = is_multisite() ? 'manage_network_options' : 'manage_options';

	add_menu_page( 'ODWPI Dev', 'ODWPI Dev', $cap, 'odwpi-dev', 'odwpi_dev_main_page', '' );

	add_submenu_page( 'odwpi-dev', 'PHP', 'PHP', $cap, 'odwpi-dev-php', 'odwpi_dev_main_page' );
	add_submenu_page( 'odwpi-dev', 'SQL', 'SQL', $cap, 'odwpi-dev-sql', 'odwpi_dev_main_page' );
	add_submenu_page( 'odwpi-dev', 'GitHub', 'GitHub', $cap, 'odwpi-dev-github', 'odwpi_dev_main_page' );

	add_submenu_page( 'odwpi-dev', 'Settings', 'Settings', $cap, 'odwpi-dev-settings', 'odwpi_dev_main_page' );

}

/**
 * Setup Main Options Page
 *
 * @return void
 */
function odwpi_dev_main_page() {
	require_once ODWPI_DEV_PLUGIN_DIR . '/partials/dev-panel.php';
}

/**
 * Save Plugin Settings
 *
 * @return void
 */
function odwpi_dev_update_settings() {
	$verified = isset( $_POST['odwpi_dev_settings_nonce'] ) &&
		wp_verify_nonce( sanitize_key( $_POST['odwpi_dev_settings_nonce'] ), 'odwpi_dev_settings' );

	$dev_users = isset( $_POST['dev_users'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['dev_users'] ) ) : array();
	$dev       = array();

	foreach ( $dev_users as $i => $d ) {
		$id   = substr( $d, strrpos( $d, '-' ) + 1 );
		$user = substr( $d, 0, strrpos( $d, '-' ) );

		$dev[ $id ] = $user;

	}
	update_site_option( 'odwpi_dev_users', $dev );
}
