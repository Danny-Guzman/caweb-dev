<?php



function get_caweb_dev_plugin_options(){
	$options = array(  'dev' , 'caweb_debugger_enabled', 'caweb_plugin_search_enabled', 'caweb_lookup_enabled');


	return $options;
}
/*
		CAWeb Panel Page
*/
function caweb_dev_display_database_tables(){
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


function caweb_dev_main_page(){


?>

<table id="dev_info_table"><tr><td><?php echo caweb_dev_display_database_tables(); ?></td></tr></table>
<form id="caweb_panel_form" action="admin.php?page=caweb-dev" method="POST">
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



function caweb_dev_settings_page(){


?>
<form id="caweb_form" action="admin.php?page=caweb-settings" method="POST">
	    <?php
	if(isset($_POST['submit']))
				caweb_dev_update_network_options();

					settings_fields('caweb_dev');


			?>
		<h3>Enable Debugger: <input type="checkbox" name="caweb_debugger_enabled" id="caweb_debugger_enabled" <?= (get_site_option('caweb_debugger_enabled', false) ? 'checked="checked"' : '') ?>/></h3>
		<h3>Plugin Search: <input type="checkbox" name="caweb_plugin_search_enabled" id="caweb_plugin_search_enabled" <?= (get_site_option('caweb_plugin_search_enabled', false) ? 'checked="checked"' : '') ?>/></h3>
	<h3>Lookup: <input type="checkbox" name="caweb_lookup_enabled" id="caweb_lookup_enabled" <?= (get_site_option('caweb_lookup_enabled', false) ? 'checked="checked"' : '') ?>/></h3>


						<input type="submit" name="submit" id="submit"  class="button button-primary" value="<?php _e('Save Changes') ?>"/>
</form>
<?php
}




/**
 * This function here is hooked up to a special action and necessary to process
 * the saving of the options. This is the big difference with a normal options
 * page.
 */
function caweb_dev_update_network_options() {

  // This is the list of registered options.
  global $new_whitelist_options;
  $options = $new_whitelist_options['caweb_dev'];

  // Go through the posted data and save only our options. This is a generic
  // way to do this, but you may want to address the saving of each option
  // individually.
	foreach ($options as $option) {
    if (isset($_POST[$option])) {
      // Save our option with the site's options.
      // If we registered a callback function to sanitizes the option's
      // value it will be called here (see register_setting).
			update_site_option($option, $_POST[$option]);

    } else {
      // If the option is not here then delete it. It depends on how you
      // want to manage your defaults however.
			update_site_option($option, '');
    }
  }
	//update_site_option('dev',$_POST['caweb_error_types']);
  // At last we redirect back to our options page.
	//wp_redirect(add_query_arg( array('page' => 'caweb-settings',  'updated' => 'true') , network_admin_url('admin.php') ) );
	//exit;
}


// End of File
?>
