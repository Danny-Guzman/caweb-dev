<?php
/**
 * ODWPI Helper Functions
 *
 * @package ODWPI
 */

/**
 * Load Minified Version of a file
 *
 * @param  string $f File to load.
 * @param  mixed  $ext Extension of file, default css.
 *
 * @return string
 */
function odwpi_dev_get_min_file( $f, $ext = 'css' ) {
	// if a minified version exists.
	if ( false && file_exists( ODWPI_DEV_PLUGIN_DIR . str_replace( ".$ext", ".min.$ext", $f ) ) ) {
		return ODWPI_DEV_PLUGIN_URL . str_replace( ".$ext", ".min.$ext", $f );
	} else {
		return ODWPI_DEV_PLUGIN_URL . $f;
	}
}

/**
 * Return array of all tables in the database.
 *
 * @return array
 */
function odwpi_dev_get_database_tables() {
	global $wpdb;
	$sql     = '';
	$results = $wpdb->get_results( 'show tables' );

	return $results;
}
