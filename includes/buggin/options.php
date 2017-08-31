<?php


function buggin_debug_log_page(){
?>
	<form id="caweb_form" action="admin.php?page=buggin-debug-log" method="POST">
    <?php
		if(isset($_POST['submit']))
		buggin_debug_log_update_network_options();

		settings_fields('buggin');


?>

            <h2>Capture Error Types:</h2>
				<ul class="error_types" id="buggin_error_types[]" name="buggin_error_types[]">
					<?php
							$types = buggin_get_error_types();
							$capTypes = get_site_option('buggin_error_types', array());

							foreach($types as $t=>$n){
								printf('<li><input type="checkbox" name="buggin_error_types[]" value="%1$s" %3$s/>%2$s</li>',$t, $n, (in_array($t, $capTypes) ? 'checked="checked"': ''));
							}
					?>
						</ul>
						<h2>Display Errors: <input type="checkbox" name="buggin_error_display" id="buggin_error_display" <?= (get_site_option('buggin_error_display', false) ? 'checked="checked"' : '') ?>/></h2>
						<input type="submit" name="submit" id="submit"  class="button button-primary" value="<?php _e('Save Changes'); ?>"/>
				</form>
				<table>
            <tr>
                <h2>Logged Errors</h2>
                <select>
                <?php
										$errors = get_site_option('buggin_errors');
                    $types = array();

										foreach($errors as $e){
												if( !in_array($e->errname, $types) ){
                        	$types[] = $e->errname;
                          printf('<option>%1$s</option>', $e->errname);
                        }
                    }
	
										if( empty($errors) ){
											printf('<option>No Errors</option>');
										}
                ?>
								</select>
                </tr>
					<?php if( !empty($errors) ) : ?>
                <tr>
										<th>Date</th>
                    <th>Site</th>
                    <th>Message</th>
                </tr>
                <tr>
								<td>
								<ul>
									<?php foreach($errors as $e){ 
									printf('<li>%1$s</li>', $e->date);
									?>
							</ul>
							</td>
							<td>
							<ul>
								<?php 	printf('<li>%1$s</li>', $e->site->site_name); 	?>
							</ul>
							</td>
							<td>
							<ul>
								<?php printf('<li>%1$s</li>', $e->to_String()); ?>
							</ul>	
								<?php } ?>
							</td>
							</tr>
					<?php endif; ?>
						</table>

<?php
}


/**
 * This function here is hooked up to a special action and necessary to process
 * the saving of the options. This is the big difference with a normal options
 * page.
 */
//add_action('network_admin_edit_buggin_debug_log_update_network_options',  'buggin_debug_log_update_network_options');
function buggin_debug_log_update_network_options() {
  // Make sure we are posting from our options page. There's a little surprise
  // here, on the options page we used the 'post3872_network_options_page'
  // slug when calling 'settings_fields' but we must add the '-options' postfix
  // when we check the referer.
	//check_admin_referer('/wp-admin/network/admin.php?page=buggin-debug-log');

  // This is the list of registered options.
  global $new_whitelist_options;
  $options = $new_whitelist_options['buggin'];

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

	update_site_option('dev',$_POST['buggin_error_types']);
  // At last we redirect back to our options page.
	//wp_redirect(add_query_arg(array('page' => buggin-debug-log',  'updated' => 'true'), network_admin_url('admin.php')));
	//exit;
}

?>
