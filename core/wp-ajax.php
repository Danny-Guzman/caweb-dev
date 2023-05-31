<?php
/**
 * WP Ajax
 *
 * @see https://codex.wordpress.org/AJAX_in_Plugins
 * @package ODWPI
 */

add_action( 'wp_ajax_odwpi_dev_code', 'odwpi_dev_code' );
add_action( 'wp_ajax_odwpi_dev_download_post_shortcode', 'odwpi_dev_download_post_shortcode' );
add_action( 'wp_ajax_odwpi_dev_export', 'odwpi_dev_export' );
add_action( 'wp_ajax_odwpi_dev_import', 'odwpi_dev_import' );

/**
 * Print output of evaluated code
 *
 * @link https://www.php.net/manual/en/function.eval.php
 * 
 * @return void
 */
function odwpi_dev_code() {

	if ( ! isset( $_POST['odwpi_dev_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['odwpi_dev_nonce'] ), 'odwpi_dev_nonce' ) ) {
		wp_die();
	}

	$code = isset( $_POST['odwpi_dev_coding_string'] ) ? wp_unslash( $_POST['odwpi_dev_coding_string'] ) : '';
	$mode = isset( $_POST['odwpi_dev_coding_mode'] ) ? wp_unslash( $_POST['odwpi_dev_coding_mode'] ) : '';

	try {
		if( 'php' === $mode ){

			
			/**
			 * The code must not be wrapped in opening and closing PHP tags, i.e. 'echo "Hi!";' must be passed instead of '<?php echo "Hi!"; ?>'. 
			 * It is still possible to leave and re-enter PHP mode though using the appropriate PHP tags, 
			 * e.g. 'echo "In PHP mode!"; ?>In HTML mode!<?php echo "Back in PHP mode!";'.
			 * 
			 * We automatically close the code by prepending '?>', this will prevent errors if the user starts code with opening PHP tags.
			 * 
			 * @link https://www.php.net/manual/en/function.eval.php
			 */

			$code = "?>$code";

			eval( $code );
		} elseif ( 'sql' === $mode ){
			global $wpdb;

			$results = $wpdb->get_results( $code, OBJECT );

			print_r( ! empty( $results ) ? $results : 'No Results' );
		}
	} catch ( Error $e ) {
		/**
		 * @see https://www.php.net/manual/en/language.exceptions.php
		 * @see https://www.php.net/manual/en/language.errors.php7.php
		 * @see https://www.php.net/manual/en/ref.errorfunc.php
		 */
		printf( 'Caught Error: %1$s on line %2$d%3$s%4$s', 
			esc_html( $e->getMessage() ), 
			esc_html( $e->getLine() + 1 ),
			PHP_EOL,
			$e->getTraceAsString()
		);
	}	

	wp_die();
}

/**
 * Downloads Post/Page post content.
 *
 * @return void
 */
function odwpi_dev_download_post_shortcode() {
	try {
		$nonce    = wp_create_nonce( 'odwpi_dev_download_post_shortcode' );
		$verified = wp_verify_nonce( sanitize_key( $nonce ), 'odwpi_dev_download_post_shortcode' );

		$id = isset( $_GET['id'] ) ? sanitize_text_field( wp_unslash( $_GET['id'] ) ) : 0;
		$post = get_post( $id );

		if ( $post ) {

			$title   = isset( $post->post_title ) ? str_replace( ' ', '-', strtolower( $post->post_title ) ) : 'no-title';
			$content = isset( $post->post_content ) ? $post->post_content : 'No Post Content Found.';

			header( 'Content-type: text/plain' );
			header( 'Content-Disposition: attachment; filename="' . $title . '.txt"' );
			header( 'Content-Length: ' . strlen( $content ) );

			print wp_kses( $content, 'post' );
		} else {
			print 'Invalid Post/Page ID.';
		}
	} catch ( Exception $e ) {
		print 'Caught exception: ' . esc_html( $e->getMessage() ) . "\n";
	}
	wp_die();
}


function odwpi_dev_export(){

	
	if ( ! isset( $_POST['odwpi_dev_export_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['odwpi_dev_export_nonce'] ), 'odwpi_dev_export_nonce' ) ) {
		wp_die();
	}
	
	$nav_selection = isset( $_POST['nav-selection'] ) ? wp_unslash( $_POST['nav-selection'] ) : '';
	
	try {
		$menus = array();

		if( ! empty( $nav_selection ) ){
			$navs = array();
			$registered_nav_locations = get_nav_menu_locations();

			// get all navigation menus.
			if( 'all-navs' === $nav_selection ){
				$navs = wp_get_nav_menus();
			}else{
				$nav_locations = isset( $_POST['nav-selection'] ) ? array_map( 'sanitize_text_field', wp_unslash( $_POST['nav-location'] ) ) : array();

				foreach( $nav_locations as $location ){
					$m = wp_nav_menu( array(
						'echo' => false,
  						'theme_location' => $location
					) );
					
					if( is_object( $m ) ) {
						$navs[] = $m->menu;
					}
				}
			}

			foreach( $navs as $nav ){	
				$obj = array();
				$term_id = $nav->term_id;

				// Set navigation name.
				$obj['name'] = $nav->name;

				// set navigation location.
				if( in_array( $term_id, $registered_nav_locations, true ) ){
					$obj['theme_location'] = array_search( $term_id, $registered_nav_locations );
				}

				// get menu items.
				$menuitems = wp_get_nav_menu_items( $term_id, array( 'order' => 'DESC' ) );

				// If a top level nav item, menu_item_parent = 0.
				if ( ! $caweb_item->menu_item_parent ) {
				
				}

				// iterate over menut items.
				foreach( $menuitems as $item ){
					// get menu item post meta.
					$item->meta = get_post_meta( $item->ID );


				}

				$obj['menu'] = $menuitems;

				$menus[] = (object)$obj;
			}
		}

		$output = json_encode( array(
			'navigation' => $menus
		) );

		print_r( $output );
		
		wp_die();
		
	} catch ( Error $e ) {
		/**
		 * @see https://www.php.net/manual/en/language.exceptions.php
		 * @see https://www.php.net/manual/en/language.errors.php7.php
		 * @see https://www.php.net/manual/en/ref.errorfunc.php
		 */
		printf( 'Caught Error: %1$s on line %2$d%3$s%4$s', 
			esc_html( $e->getMessage() ), 
			esc_html( $e->getLine() + 1 ),
			PHP_EOL,
			$e->getTraceAsString()
		);
	}	

	wp_die();

}

function odwpi_dev_import(){
	
	if ( ! isset( $_POST['odwpi_dev_import_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['odwpi_dev_import_nonce'] ), 'odwpi_dev_import_nonce' ) ) {
		wp_die();
	}

	$export = file_get_contents( $_FILES['file-0']['tmp_name'] );

	try{
		print_r( json_decode($export) );

	} catch ( Error $e ) {
		/**
		 * @see https://www.php.net/manual/en/language.exceptions.php
		 * @see https://www.php.net/manual/en/language.errors.php7.php
		 * @see https://www.php.net/manual/en/ref.errorfunc.php
		 */
		printf( 'Caught Error: %1$s on line %2$d%3$s%4$s', 
			esc_html( $e->getMessage() ), 
			esc_html( $e->getLine() + 1 ),
			PHP_EOL,
			$e->getTraceAsString()
		);
	}	

	wp_die();
}