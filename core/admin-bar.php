<?php
/**
 * CAWeb Dev Admin Bar
 *
 * @link https://developer.wordpress.org/reference/classes/wp_admin_bar/
 * @package CAWeb Dev 
 */

add_action( 'admin_bar_menu', 'caweb_dev_admin_bar_menu', 1000 );

/**
 * Load all necessary CAWeb Dev Admin Bar items.
 *
 * @param  WP_Admin_Bar $wp_admin_bar WP_Admin_Bar instance, passed by reference.
 *
 * @return void
 */
function caweb_dev_admin_bar_menu( $wp_admin_bar ) {
	global $pagenow;

	if ( current_user_can( 'manage_options' ) &&
		( is_singular( array( 'post', 'page' ) ) || 'post.php' === $pagenow )
		) {
		/* Add CAWeb Dev WP Admin Bar Nodes */
		$wp_admin_bar->add_node(
			array(
				'id'     => 'caweb-dev-download-post-shortcode',
				'title'  => 'Download Post Shortcode',
				'href'   => admin_url( 'admin-ajax.php?action=caweb_dev_download_post_shortcode&id=' . get_the_ID() ),
			)
		);
	}
}
