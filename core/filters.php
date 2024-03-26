<?php
/**
 * CAWeb Dev Plugin Filters
 *
 * @package CAWeb Dev
 */
 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/* WP Filters */
add_filter( 'upload_mimes', 'caweb_dev_upload_mimes', 999999 );

/**
 * Add in our mime-types to the supplied array.
 *
 * @param  array $mimes Array of mimes.
 *
 * @return array
 */
function caweb_dev_upload_mimes( $mimes ) {
    $mimes_types = array(
        'ico' => 'image/vnd.microsoft.icon',
    );
    
	return array_merge( $mimes, $mimes_types );
}
