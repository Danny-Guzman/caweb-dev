<?php
/**
 * WP Ajax
 *
 * @see https://codex.wordpress.org/AJAX_in_Plugins
 * @package ODWPI
 */

add_action( 'wp_ajax_odwpi_dev_code', 'odwpi_dev_code' );
add_action( 'wp_ajax_odwpi_dev_download_post_shortcode', 'odwpi_dev_download_post_shortcode' );

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
	} catch ( ParseError $e ) {
		printf( 'Caught exception: %1$s on line %2$d', esc_html( $e->getMessage() ), esc_html( $e->getLine() + 1 ) );
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