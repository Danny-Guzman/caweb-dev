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

/**
 * Allowed HTML for wp_kses
 *
 * @link https://developer.wordpress.org/reference/functions/wp_kses/
 *
 * @param  array   $exclude HTML tags to exclude.
 * @param  boolean $form Whether or not to include form fields.
 * @return array
 */
function odwpi_dev_allowed_html( $exclude = array(), $form = false ) {
	$attr = array(
		'id'    => array(),
		'class' => array(),
		'style' => array(),
		'role'  => array(),
	);

	$anchors = array(
		'href'   => array(),
		'title'  => array(),
		'target' => array(),
	);

	$imgs = array(
		'src' => array(),
		'alt' => array(),
	);

	$aria = array(
		'aria-label'      => array(),
		'aria-labelledby' => array(),
		'aria-expanded'   => array(),
		'aria-haspopup'   => array(),
	);

	// Some of these are used by Bootstrap 4 Toggle Plugin.
	// https://gitbrent.github.io/bootstrap4-toggle/#api.
	$data = array(
		'data-toggle'   => array(),
		'data-target'   => array(),
		'data-on'       => array(),
		'data-off'      => array(),
		'data-onstyle'  => array(),
		'data-offstyle' => array(),
		'data-size'     => array(),
		'data-style'    => array(),
		'data-width'    => array(),
		'data-height'   => array(),
	);

	$tags = array(
		'div'    => array_merge( $attr, $aria, $data ),
		'nav'    => array_merge( $attr, $aria, $data ),
		'header' => array_merge( $attr, $aria, $data ),
		'footer' => array_merge( $attr, $aria, $data ),
		'p'      => $attr,
		'br'     => array(),
		'span'   => $attr,
		'a'      => array_merge( $attr, $anchors, $aria, $data ),
		'button' => array_merge( $attr, $aria, $data ),
		'img'    => array_merge( $attr, $imgs ),
		'strong' => $attr,
		'bold'   => $attr,
		'i'      => $attr,
		'h1'     => $attr,
		'h2'     => $attr,
		'h3'     => $attr,
		'h4'     => $attr,
		'h5'     => $attr,
		'h6'     => $attr,
		'ol'     => $attr,
		'ul'     => $attr,
		'li'     => $attr,
		'style'  => array(),
		'script' => array(),
	);

	// Whether to include form fields or not.
	if ( $form ) {
		$form_attrs = array(
			'action'     => array(),
			'method'     => array(),
			'enctype'    => array(),
			'novalidate' => array(),
		);

		$input_attrs = array(
			'for'      => array(),
			'type'     => array(),
			'name'     => array(),
			'value'    => array(),
			'title'    => array(),
			'checked'  => array(),
			'selected' => array(),
			'required' => array(),
			'pattern'  => array(),
		);

		$form_tags = array(
			'form'     => array_merge( $attr, $form_attrs ),
			'label'    => array_merge( $attr, $input_attrs, $aria, $data ),
			'input'    => array_merge( $attr, $input_attrs, $aria, $data ),
			'li'       => array_merge( $attr, $input_attrs, $aria, $data ),
			'select'   => array_merge( $attr, $input_attrs, $aria, $data ),
			'option'   => array_merge( $attr, $input_attrs, $aria, $data ),
		);

		$tags = array_merge( $tags, $form_tags );
	}

	add_filter( 'safe_style_css', 'odwpi_dev_safe_style_css' );

	return array_diff_key( $tags, array_flip( $exclude ) );
}

/**
 * Safe Style CSS
 *
 * @see https://developer.wordpress.org/reference/functions/safecss_filter_attr/
 *
 * @param  array $styles A string of CSS rules.
 * @return array
 */
function odwpi_dev_safe_style_css( $styles ) {
	$styles[] = 'list-style-position';

	return $styles;
}
