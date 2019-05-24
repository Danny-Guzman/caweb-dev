<?php


if(isset($_POST['odwpi_settings_submit']))
    odwpi_dev_update_settings();

$selected_tab = ! empty($_POST['tab_selected']) ? $_POST['tab_selected'] : 'dev';

$users = get_users(  array( 'blog_id' => 0, 'fields' => array('ID', 'display_name' ) ) );
$devUsers = get_site_option('odwpi_dev_users', array());
?>
<div class="wrap option-titles" >
	
	<h1 >Settings</h1>
	
	<h2 class="nav-tab-wrapper wp-clearfix">
		
        <a href="#devSettings" class="odwpi-nav-tab nav-tab <?php print 'dev' == $selected_tab ? 'nav-tab-active' : '' ?>">Developers</a>

        <a href="#testSettings" class="odwpi-nav-tab nav-tab <?php print 'test' == $selected_tab ? 'nav-tab-active' : '' ?>">Test</a>
		
	</h2>
</div>
<form id="odwpi_form" action="admin.php?page=odwpi-settings" method="POST">
	<input type="hidden" id="tab_selected" name="tab_selected" value="<?php print $selected_tab ?>">
    
    <div id="devSettings" class="container-fluid<?php print 'dev' == $selected_tab ? '' : ' hidden' ?>">
                
        <h1 class="option">Developers</h1>
        <p>Select all users that are developers.</p>
        <div class="row no-gutters">
            <!-- All Users Column -->
            <div class="col-3">
                <label class="d-block" for="allUsers"><strong>All Users</strong></label>
                <select multiple id="allUsers" class="form-control form-control-md">
                <?php
                    foreach($users as $u => $data){
                        if( ! array_key_exists($data->ID, $devUsers) )
                            printf('<option name="%1$s" value="%1$s-%2$s">%1$s</option>', $data->display_name, $data->ID);
                    }
                ?>
                </select>
            </div>
            <!-- User Control Column -->
            <div class="mx-5 pt-4 align-self-center">
                <div class="mb-2">
                  <button id="addDev" class="btn btn-primary btn-block"><span class="dashicons dashicons-arrow-right-alt"></span></button>
                </div>
                <div>
                    <button id="removeDev" class="btn btn-primary btn-block"><span class="dashicons dashicons-arrow-left-alt"></span></button>
                </div>
            </div>
            <!-- Dev User Column -->
            <div class="col-3">
                <label class="d-block" for="devUsers"><strong>Developers</strong></label>
                <select multiple id="devUsers" name="devUsers[]" class="form-control form-control-md">
                <?php
                    foreach($devUsers as $u => $data){
                        printf('<option name="%1$s" value="%1$s-%2$s">%1$s</option>', $data, $u);
                    }
                ?>
                </select>
            </div>
        </div>
    </div>
    <div id="testSettings" class="container-fluid<?php print 'test' == $selected_tab ? '' : ' hidden' ?>">
                
        <h1 class="option">Test</h1>
        <div class="row no-gutter">
            <pre><?php print_r( get_site_option('odwpi_dev_users') ); ?></pre>
        </div>
    </div>
    <div class="container-fluid mt-3">
        <div class="row no-gutters">
            <input type="submit" name="odwpi_settings_submit" class="btn btn-primary" value="<?php _e('Save Changes') ?>">
        </div>
    </div>

</form>