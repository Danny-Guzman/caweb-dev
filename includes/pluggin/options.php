<?php 

function pluggin_page(){
	
?>
<style>
	.plugin_by_choice{
		display: flex;
		margin-bottom: 0px;
	}
	.plugin_by_choice li{
		float: left;
    margin-right: 40px;
	}
</style>
<form id="caweb_form" action="admin.php?page=pluggin" method="POST">
	<div style="margin-bottom: 20px;">
		<h3 style="margin-bottom: 0px;">View Active Plugins By:</h3>
		<ul class="plugin_by_choice">
	<li>Site <input id="by_site" name="plugin_by_choice" type="radio" checked="true"/></li>
			<li>Plugin <input id="by_plugin" name="plugin_by_choice"  type="radio" /></li>
		</ul>
	<label id="network_allowed"><input id="network_plugins_allowed" type="checkbox" checked="true">Include Network Active Plugins</label>
	</div>
	
	<select id="site_list">
	<?php
			$tmp = caweb_get_sites( );

			foreach($tmp as $s){
				printf('<option value="%2$d">%1$s</option>',$s->blogname, $s->blog_id);
			}
	?>
	</select>
	<ul id="site_active_plugin_list">
	<?php
		$site_plugins = caweb_get_plugins_for_blog(caweb_get_sites()[0]->blog_id, true);
		if( !empty($site_plugins) ){
			foreach($site_plugins as $s => $p){
				printf('<li>%1$s</li>',$p->Name);
			}
		}
	?>
					</ul>
</form>
<?php

}
