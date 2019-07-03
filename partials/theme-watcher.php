<?php


if(isset($_POST['odwpi_tw_submit']))
    odwpi_dev_update_tw_settings();

$installed_themes = wp_get_themes();
$themes = array();
$watched_themes = get_site_option('odwpi_dev_watched_themes', array());

foreach($installed_themes as $slug => $data){
    $themes[$slug] = $data->get('Name');
}

$selected_tab = ! empty($_POST['tab_selected']) ? $_POST['tab_selected'] : 'themes';

?>
<div class="wrap option-titles" >
	
	<h1 >Theme Watcher</h1>
	
	<h2 class="nav-tab-wrapper wp-clearfix">
		
        <a href="#twSettings" class="odwpi-nav-tab nav-tab <?php print 'themes' == $selected_tab ? 'nav-tab-active' : '' ?>">Themes</a>

		
	</h2>
</div>
<form id="odwpi_form" action="admin.php?page=odwpi-tw" method="POST">
	<input type="hidden" id="tab_selected" name="tab_selected" value="<?php print $selected_tab ?>">
    
    <div id="twSettings" class="container-fluid<?php print 'themes' == $selected_tab ? '' : ' hidden' ?>">
                
                
        <div class="row no-gutters">
            <!-- Column -->
            <div class="col-3">
                <ul>
                    <?php foreach( $themes as $slug => $name): 
                            $checked = in_array($slug, $watched_themes) ? ' checked="checked"' : "";
                    ?>
                        <li><input name="watched_themes[]" type="checkbox" value="<?= $slug ?>"<?= $checked ?>/><?= $name ?></li>
                    <?php endforeach; ?>                    
                </ul>
            </div>
        </div>
    </div>
   
    <div class="container-fluid mt-3">
        <div class="row no-gutters">
            <input type="submit" name="odwpi_tw_submit" class="btn btn-primary btn-sm" value="<?php _e('Save Changes') ?>">
        </div>
    </div>
</form>