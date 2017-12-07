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
?>

<h2>Tables</h2>
<select>
	
	<?php
		foreach($results as $tbl){
			//printf('<option>%1$s</option>', ((array) $tbl)[sprintf('Tables_in_%1$s', DB_NAME)]  );
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
			<textarea id="coding_string" name="coding_string"></textarea>
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