<?php
/**
 * CAWeb Dev Helper Functions
 *
 * @package CAWeb Dev
 */

/**
 * Load Minified Version of a file
 *
 * @param  string $f File to load.
 * @param  mixed  $ext Extension of file, default css.
 *
 * @return string
 */
function caweb_dev_get_min_file( $f, $ext = 'css' ) {
	// if a minified version exists.
	if ( false && file_exists( CAWEB_DEV_PLUGIN_DIR . str_replace( ".$ext", ".min.$ext", $f ) ) ) {
		return CAWEB_DEV_PLUGIN_URL . str_replace( ".$ext", ".min.$ext", $f );
	} else {
		return CAWEB_DEV_PLUGIN_URL . $f;
	}
}

function caweb_dev_tools(){
	$tools = array(
		'codemirror' => array(
			'label' => 'CodeMirror',
			'version' => '6.0.1',
			'url' => 'https://codemirror.net/',
			'logo' => 'https://codemirror.net/style/logo.svg'
		),
		'bootstrap' => array(
			'label' => 'Bootstrap',
			'version' => '5.3.3',
			'url' => 'https://getbootstrap.com/docs/5.3/getting-started/introduction/',
			'icon' => 'bi bi-bootstrap-fill'
		)
	);

	return $tools;
}

/**
 * Return array of all tables in the database.
 *
 * @return array
 */
/*
function caweb_dev_get_database_tables() {
	global $wpdb;
	$sql     = '';
	$results = $wpdb->get_results( 'show tables' );

	return $results;
}
*/