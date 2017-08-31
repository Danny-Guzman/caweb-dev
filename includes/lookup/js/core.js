 $ = jQuery.noConflict();

$(document).ready(function(){
			
	$('#lookie_search').click(function(){
			var site = document.getElementById("site_list");
			var site_name = site.options[site.selectedIndex].text;	
			var site_id = site.options[site.selectedIndex].value;	
		
			var page = document.getElementById("page_list");
			var page_id = page.options[page.selectedIndex].value;	
		
			var result = document.getElementById("search_results");
			var keyword = document.getElementById("search_phrase").value;
			var published = document.getElementById("publish_page_status").checked;
			var draft = document.getElementById("draft_page_status").checked;
			//var revision = document.getElementById("revision_page_status").checked;
			var page = document.getElementById("page_type").checked;
			var post = document.getElementById("post_type").checked;
		
			var match_case = document.getElementById("match_case").checked;
			var regex = document.getElementById("regex").checked;
			
			result.innerHTML = '<h3>Searching for Results...</h3>';
			//				'revision' : Boolean(revision),
			var data = {
				'action': 'lookie_search',
				'site_name' : site_name,
				'site_id' : site_id,
				'page_id' : page_id,
				'keyword' : keyword,
				'published' : Boolean(published),
				'draft' : Boolean(draft),
				'page' : Boolean(page),
				'post' : Boolean(post),				
				'match_case' : Boolean(match_case),
				'regex' : Boolean(regex),						
				
			};

		jQuery.post(ajaxurl, data, function(response) {	
			result.innerHTML = response;
			
		});		

		})
		
		$('#site_list').change(refresh_posts_combobox)
		$('#refresh_posts').click(refresh_posts_combobox)
	
		function refresh_posts_combobox(){
				var site = document.getElementById("site_list");
				var site_id = site.options[site.selectedIndex].value;		
				
				var published = document.getElementById("publish_page_status").checked;
				var draft = document.getElementById("draft_page_status").checked;
				//var revision = document.getElementById("revision_page_status").checked;
				var page = document.getElementById("page_type").checked;
				var post = document.getElementById("post_type").checked;
			
				var page_list = document.getElementById("page_list");
				page_list.innerHTML = '<option>Searching for pages/posts...</option>';
			
					var data = {
					'action': 'search_site_changed',
					'site_id': site_id,
					'published' : Boolean(published),
					'draft' : Boolean(draft),
					'page' : Boolean(page),
					'post' : Boolean(post),				
				};
	
			jQuery.post(ajaxurl, data, function(response) {	
						page_list.innerHTML = response;
			});		
		
		}
		
});