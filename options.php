<?php

function get_odwpi_dev_plugin_options(){
	$options = array(  'dev' );

	return $options;
}

/*
	ODWPI Panel Page
*/

function odwpi_dev_display_database_tables(){
	global $wpdb;
	$sql = '';
	$results = $wpdb->get_results( 'show tables');
	$db_table = 'Tables_in_' . DB_NAME ;
?>

<h2>Tables</h2>
<select>

	<?php	
		foreach($results as $i => $tbl){
			printf('<option>%1$s</option>', ((array) $tbl)[$db_table]  );
		}
	?>
</select>

<?php

}

function odwpi_dev_main_page(){

?>

<table id="dev_info_table"><tr><td><?php echo odwpi_dev_display_database_tables(); ?></td></tr></table>
<form id="odwpi_panel_form" action="admin.php?page=odwpi-dev" method="POST">
	<table >
		<tr>
			<th><label for="querying">Run a query:</label> <input type="button" id="querying" name="querying" class="button button-primary" value="Run Query"/></th>
			<th><label for="coding">Test Code:</label> <input type="button" id="coding"  name="coding" class="button button-primary" value="Run Code"/></th>
		</tr>
	<tr>
		<td>
			<textarea id="query_string"  name="query_string"> </textarea>
		</td>
		<td>
			<textarea id="coding_string" name="coding_string">//delete_site_option('dev'); 
$d = get_site_option('dev');
				
print_r( $d );
			</textarea>
	</td>
		</tr>
		</table>
</form>

<table id="output">
	<tr>
		<th>Output:</th>
	</tr>
	<tr>
	<td >
		<pre id="output_screen"></pre>
	</td>
		</tr>
</table>

<?php

}


function odwpi_dev_settings_page(){

?>
<form id="odwpi_form" action="admin.php?page=odwpi-settings" method="POST">
	<?php
		if(isset($_POST['submit']))
			odwpi_dev_update_network_options();
	?>

	
<?php

}

function odwpi_dev_update_network_options() {
 
}

// End of File

?>