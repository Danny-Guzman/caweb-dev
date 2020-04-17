<?php

function odwpi_dev_display_database_tables(){
	global $wpdb;
	$sql = '';
	$results = $wpdb->get_results( 'show tables');
	$db_table = 'Tables_in_' . DB_NAME ;

	$output = '';
	foreach($results as $i => $tbl){
		$output .= sprintf('<option>%1$s</option>', ((array) $tbl)[$db_table]  );
	}

	$class = 'class="h-auto"';

	return "<select $class>$output</select>";
}

function odwpi_dev_main_page(){
	require_once(ODWPIDEVPLUGINDIR."/partials/panel.php");
}


function odwpi_dev_settings_page(){
	require_once(ODWPIDEVPLUGINDIR."/partials/settings.php");
}

function odwpi_dev_update_settings() {
	$devUsers = isset($_POST['devUsers']) ? $_POST['devUsers'] : array();
	$dev = array();

	foreach($devUsers as $i => $d){
		$id = substr($d, strrpos($d, '-') + 1 );
		$user = substr($d, 0, strrpos($d, '-'));

		$dev[$id] = $user;

	}
	update_site_option('odwpi_dev_users', $dev);
}

function odwpi_dev_update_tw_settings(){
	$watched_themes = isset($_POST['watched_themes']) ? $_POST['watched_themes'] : array();

	update_site_option('odwpi_dev_watched_themes', $watched_themes);
}
// End of File

?>