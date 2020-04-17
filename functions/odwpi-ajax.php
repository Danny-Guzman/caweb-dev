<?php

add_action('wp_ajax_odwpi_dev_code', 'odwpi_dev_code');
function odwpi_dev_code() {
	try {
		print eval(stripcslashes($_POST['odwpi_php_coding_string']));
	} catch (Exception $e) {
		print 'Caught exception: ' . $e->getMessage() . "\n";
	}
	wp_die(); // this is required to terminate immediately and return a proper response
}

add_action('wp_ajax_odwpi_dev_query', 'odwpi_dev_query');
function odwpi_dev_query() {
	global $wpdb;
	$sql = $_POST['odwpi_query_string'];

	$results = $wpdb->get_results(stripcslashes($sql));
	print_r( ! empty($results) ? $results : 'No Results');
	wp_die(); // this is required to terminate immediately and return a proper response
}

add_action('wp_ajax_odwpi_github_api_test', 'odwpi_github_api_test');
function odwpi_github_api_test() {
	try {
		foreach ($_POST as $key => $val) {
			$$key = $val;
		}

		$gitView = ! empty($gitView) ? "/$gitView" : "";

		$url = ! empty($gitRepo) ? "https://api.github.com/repos/$gitUser/$gitRepo$gitView" : "https://api.github.com/users/$gitUser/repos";

		if ("true" === $gitPrivateRepo) {
			$url .= "?access_token=$gitToken";
		}

		$args = array(
			'headers' => array(
				'Accept' => 'application/vnd.github.v3+json'
			),
		);

		$res = wp_remote_get($url, $args);
		$code = wp_remote_retrieve_response_code($res);
		$headers = wp_remote_retrieve_headers($res)->getAll();
		$body = json_decode(wp_remote_retrieve_body($res));

		$response['git_request_url'] = $url;
		$response['git_request_headers'] = $headers;
		$response['info'] = sprintf('<label class="mb-0"><strong>Requested URL:</strong></label><p><a href="%1$s">%1$s</a></p><label class="mb-0"><strong>Requested Headers:</strong></label><pre>%2$s</pre>', $url, print_r($headers, true));

		switch ($code) {
			case 200:
				$response['git_request_body'] =  $body;

				break;
			case 404:
				$response['git_request_body'] = "The User/Organization Name or Repository could not be found.";

				break;
			case 403:

				break;
			default:
				$plugin = get_plugin_data(ODWPIDEVPLUGINDIR . "/wp-dev.php", false, false);
				$email = 'danny.guzman@state.ca.gov';
				$subject = "Uncaught Response Code " . $code;
				$author = $plugin['Author'];

				$msg = sprintf('Error Message: %1$s%3$sDocumentation URL: %2$s%3$s%4$s%3$sPLEASE DO NOT EDIT ABOVE THIS LINE!!!%3$s%4$s%3$s%3$s', $body->message, $body->documentation_url, "%0D%0A", str_repeat("-", 55));

				$mailLink = sprintf('<a href="mailto:%1$s?subject=%2$s&body=%3$s">%4$s</a>', $email, $subject, htmlspecialchars($msg), $author);

				$response['git_request_body'] = "Please report this error along with the User/Organization, Repository to $mailLink";

				break;
		}
		wp_send_json($response);
	} catch (Exception $e) {
		print 'Caught exception: ' . $e->getMessage() . "\n";
	}

	wp_die(); // this is required to terminate immediately and return a proper response
}

add_action('wp_ajax_odwpi_download_post_shortcode', 'odwpi_download_post_shortcode');
function odwpi_download_post_shortcode() {
	try {
		$id = isset( $_GET['id'] ) ? $_GET['id'] : 0;
		
		if( $id ){
			$rev = wp_get_post_revisions( $id );
			$rev = array_shift( $rev );
			
			$title = isset( $rev->post_title ) ? str_replace( ' ', '-', strtolower( $rev->post_title ) ) : 'no-title';
			$content = isset( $rev->post_content ) ? $rev->post_content : 'No Post Content Found.';

			header( 'Content-type: text/plain' );
			header( 'Content-Disposition: attachment; filename="' . $title . '.txt"' );
			header( 'Content-Length: ' . strlen( $content ) );
			
			print $content;
		}else{
			print "Invalid Post/Page ID.";
		}
	} catch (Exception $e) {
		print 'Caught exception: ' . $e->getMessage() . "\n";
	}
	wp_die(); // this is required to terminate immediately and return a proper response
}
?>