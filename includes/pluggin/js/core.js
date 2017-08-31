 $ = jQuery.noConflict();

$(document).ready(function(){
	
			
	$('#site_list, #network_plugins_allowed').change(function(){
		if( document.getElementById('by_site').checked ){
				var site = document.getElementById("site_list");
				var site_id = site.options[site.selectedIndex].value;		
				var network_allowed = document.getElementById("network_plugins_allowed").checked;
			
				var active_plugin_list = document.getElementById("site_active_plugin_list");
				active_plugin_list.innerHTML = "Loading...";
	
				var data = {
					'action': 'site_active_plugins_selected',
					'site_id': site_id,
					'network_included' : Boolean(network_allowed)
				};
	
			jQuery.post(ajaxurl, data, function(response) {	
						active_plugin_list.innerHTML = response;
			});		
		}else{
				var plug = document.getElementById("site_list");
				var plugname = plug.options[plug.selectedIndex].value;		
			
				var active_plugin_list = document.getElementById("site_active_plugin_list");
				active_plugin_list.innerHTML = "Loading...";
	
				var data = {
					'action': 'plugin_active_sites_selected',
					'plugname': plugname,
				};
	
			jQuery.post(ajaxurl, data, function(response) {	
						active_plugin_list.innerHTML = response;
			});		
		
		}
		
		})
		
	$('#by_site').change(function(){
			var site = document.getElementById("site_list");
			var active_plugin_list = document.getElementById("site_active_plugin_list");		
			var network_allowed = document.getElementById("network_plugins_allowed").checked;
			
			site.innerHTML = '<option>Searching for Sites...</option>';
			active_plugin_list.innerHTML = "Loading...";
			document.getElementById("network_allowed").style = "display: visible;";
		
			var data = {
				'action': 'plugin_by_site',
        dataType:       "json",
				'network_included' : Boolean(network_allowed)
			};

		jQuery.post(ajaxurl, data, function(response) {
					site.innerHTML = JSON.parse(response)[0];
					active_plugin_list.innerHTML = JSON.parse(response)[1];
		});		

		})
		
	$('#by_plugin').change(function(){
			var site = document.getElementById("site_list");
			var active_plugin_list = document.getElementById("site_active_plugin_list");
			
			site.innerHTML = '<option>Searching for Plugins...</option>';
			active_plugin_list.innerHTML = "Loading...";
			document.getElementById("network_allowed").style = "display: none;";
		
			var data = {
				'action': 'plugin_by_name',
        dataType:       "json",
			};

		jQuery.post(ajaxurl, data, function(response) {	
					site.innerHTML = JSON.parse(response)[0];
					active_plugin_list.innerHTML = JSON.parse(response)[1];
		});		

		})
		
		
});