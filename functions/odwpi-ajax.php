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

add_action( 'wp_ajax_odwpi_github_api_test', 'odwpi_github_api_test');
function odwpi_github_api_test(){
	try{
		foreach($_POST as $key => $val){
			$$key = $val;
		}
	
		$gitView = ! empty($gitView) ? "/$gitView" : "";

		$url = ! empty( $gitRepo ) ? "https://api.github.com/repos/$gitUser/$gitRepo$gitView" : "https://api.github.com/users/$gitUser/repos";
	
		if( "true" === $gitPrivateRepo )
			$url .= "?access_token=$gitToken";

		$args = array(
			'headers' => array(
				'Accept' => 'application/vnd.github.v3+json'
			),
		);

		$res = wp_remote_get( $url, $args );
			
		if( 200 == wp_remote_retrieve_response_code($res) ){
			$response['git_request_url'] = $url;
			$response['git_request_headers'] = $res['headers'];
			$response['git_request_body'] = json_decode( wp_remote_retrieve_body( $res ) );

			wp_send_json( $response );

		}

	}catch (Exception $e) {
		print 'Caught exception: ' .  $e->getMessage() . "\n";
	}
	
	wp_die(); // this is required to terminate immediately and return a proper response
}
?>