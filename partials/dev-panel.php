<?php
/**
 * Development Panel
 *
 * @package ODWPI-Dev
 */

$odwpi_dev_panel_nonce = wp_create_nonce( 'odwpi_dev_panel' );

$odwpi_dev_page = wp_verify_nonce( $odwpi_dev_panel_nonce, 'odwpi_dev_panel' ) && isset( $_GET['page'] ) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';

$odwpi_dev_page = substr( $odwpi_dev_page, strrpos( $odwpi_dev_page, '-', -1 ) + 1 );

?>
<div class="container-fluid mt-4 d-grid">
	<input type="hidden" name="odwpi_dev_panel_nonce" value="<?php print esc_attr( $odwpi_dev_panel_nonce ); ?>" />
	<div id="odwpi-dev-settings" class="row py-3 mr-3 bg-white overflow-auto">
		<?php
		if ( file_exists( ODWPI_DEV_PLUGIN_DIR . "partials/panels/$odwpi_dev_page.php" ) ) {
			require_once "panels/$odwpi_dev_page.php";
		}

		if ( ! in_array( $odwpi_dev_page, array( 'dev', 'settings' ), true ) ) {
			require_once 'panels/output.php';
		}

		?>
	</div>
</div>
