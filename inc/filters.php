<?php
/**
 * ODWPI Filters
 *
 * @package ODWPI
 */

/* WP Filters */
add_filter( 'wp_kses_allowed_html', 'odwpi_dev_allowed_html', 10, 2 );


/**
 * ODWPI Allowed HTML for wp_kses
 *
 * @link https://developer.wordpress.org/reference/functions/wp_kses/
 * @link https://developer.wordpress.org/reference/functions/wp_kses_allowed_html/
 *
 * @param  array        $allowedposttags HTML tags to include.
 * @param  string|array $context The context for which to retrieve tags. Allowed values are 'post', 'strip', 'data', 'entities', or the name of a field filter such as 'pre_user_description'.
 * @return array
 */
function odwpi_dev_allowed_html( $allowedposttags, $context ) {

	if ( 'post' !== $context ) {
		return $allowedposttags;
	}

	$specials = array(
		'aria-expanded' => true,
		'aria-haspopup' => true,
		'onkeydown'     => true,
		'onkeypress'    => true,
		'onkeyup'       => true,
		'onclick'       => true,
		'onfocus'       => true,
		'onfocusin'     => true,
		'onfocusout'    => true,
		'onmousedown'   => true,
		'onmouseup'     => true,
		'onmouseover'   => true,
	);

	foreach ( $allowedposttags as $tag => $data ) {
		$data = array_merge( $data, $specials );
		ksort( $data );
		$allowedposttags[ $tag ] = $data;
	}

	$allowedposttags['bold']   = $allowedposttags['strong'];
	$allowedposttags['style']  = array();
	$allowedposttags['script'] = array();

	$default_attrs = array(
		'aria-describedby' => true,
		'aria-details'     => true,
		'aria-expanded'    => true,
		'aria-label'       => true,
		'aria-labelledby'  => true,
		'aria-haspopup'    => true,
		'aria-hidden'      => true,
		'class'            => true,
		'data-*'           => true,
		'id'               => true,
		'role'             => true,
		'style'            => true,
		'title'            => true,
	);

	$input_attrs = array_merge(
		$default_attrs,
		array(
			'for'      => true,
			'type'     => true,
			'name'     => true,
			'value'    => true,
			'title'    => true,
			'checked'  => true,
			'selected' => true,
			'required' => true,
			'pattern'  => true,
		)
	);

	$allowedposttags['form'] = array_merge(
		$default_attrs,
		array(
			'action'         => true,
			'accept'         => true,
			'accept-charset' => true,
			'enctype'        => true,
			'method'         => true,
			'name'           => true,
			'novalidate'     => true,
			'target'         => true,
		)
	);

	$form_tags = array(
		'label'    => $input_attrs,
		'input'    => $input_attrs,
		'li'       => $input_attrs,
		'select'   => $input_attrs,
		'option'   => $input_attrs,
	);

	$allowedposttags = array_merge( $allowedposttags, $form_tags );

	ksort( $allowedposttags );

	add_filter( 'safe_style_css', 'odwpi_dev_safe_style_css' );

	return $allowedposttags;

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
