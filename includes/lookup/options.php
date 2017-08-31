<?php 

function lookie_page(){
	
?>
<style>
	#caweb_form h3{
		margin-bottom: 5px;
	}
	#caweb_form select, #caweb_form ul{
		margin-top: 0px;
	}
	.search_options{
		margin-top: 0px;
	}
	.page_status,  .page_type, .search_options{
		display: flex;
		margin-bottom: 0px;
	}
	
	.page_status li, .page_type li, .search_options li{
		float: left;
    margin-right: 40px;
	}
</style>
<form id="caweb_form" action="admin.php?page=lookie" method="POST">
	<div>
	<h3>Select a Site</h3>
	<select id="site_list">		
		<!--option value="-1">Search All Sites</option-->
	<?php
			$tmp = caweb_get_sites( );

			foreach($tmp as $s){
				printf('<option value="%2$d">%1$s</option>',$s->blogname, $s->blog_id);
			}
	?>
	</select>
	</div>
	<div>
		<h3>Select a Page/Post</h3>
	<select id="page_list">
		<option value="-1">Search All Pages/Posts</option>
	</select>
		
	<input type="button" id="refresh_posts" class="button button-primary" value="Refresh"/>
	</div>
	<div style="float: left; margin-right: 50px;">		
		<h3>Page Type</h3>
	<ul class="page_type">
		<li><input id="page_type" type="checkbox" checked="true">Page</li>
		<li><input id="post_type" type="checkbox" checked="true">Post</li>
	</ul>
	</div>
	<div>
		<h3>Page Status</h3>
	<ul class="page_status">
		<li><input id="publish_page_status" type="checkbox" checked="true">Published</li>
		<li><input id="draft_page_status" type="checkbox" >Draft</li>
		<!--li><input id="revision_page_status" type="checkbox" >Revision</li-->
	</ul>
	</div>
	<h3>Enter Phrase</h3>
	<input id="search_phrase" size="100" type="text" />
	<input type="button" id="lookie_search" class="button button-primary" value="Search"/>
	<ul class="search_options">
		<li><input id="match_case" type="checkbox" checked="true">Match Case a/A</li>
		<li><input id="regex" type="checkbox" checked="true">/Regex/</li>
	</ul>
</form>

<div id="search_results">
	
</div>
<?php

}
