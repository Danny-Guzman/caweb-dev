<?php

add_action( 'wp_ajax_odwpi_dev_code', 'odwpi_dev_code' );
function odwpi_dev_code() {
	try{
		print eval(  stripcslashes($_POST['coding_string']) ) ;
	}catch (Exception $e) {
		print 'Caught exception: ' .  $e->getMessage() . "\n";
	}
	wp_die(); // this is required to terminate immediately and return a proper response
}

add_action( 'wp_ajax_odwpi_dev_query', 'odwpi_dev_query' );
function odwpi_dev_query() {
	global $wpdb;
 	$sql = $_POST['query_string'];

	$results = $wpdb->get_results( 	stripcslashes ($sql));
	print_r ( !empty($results) ? $results : 'No Results');
	wp_die(); // this is required to terminate immediately and return a proper response

}

?>