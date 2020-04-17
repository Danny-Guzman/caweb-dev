<?php
/**
 * ODWPI Admin Bar
 *
 * @link https://developer.wordpress.org/reference/classes/wp_admin_bar/
 * @package ODWPI
 */

add_action( 'admin_bar_menu', 'odwpi_admin_bar_menu', 1000 );

/**
 * Load all necessary ODWPI Admin Bar items.
 *
 * @param  WP_Admin_Bar $wp_admin_bar WP_Admin_Bar instance, passed by reference.
 *
 * @return void
 */
function odwpi_admin_bar_menu( $wp_admin_bar ) {
	if ( current_user_can( 'manage_options' ) ) {
		/* Add ODWPI WP Admin Bar Nodes */
		$wp_admin_bar->add_node(
			array(
				'id'     => 'odwpi-download-post-shortcode',
				'title'  => 'Download Post Shortcode',
				'href'   => admin_url( 'admin-ajax.php?action=odwpi_download_post_shortcode&id=' . get_the_ID() ) ,
			)
		);
	}
}
