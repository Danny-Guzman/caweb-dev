<?php

add_thickbox();

$toolTip1 = "Leaving this blank with return information about all the Users/Organization Repositories.";
?>
<div class="wrap option-titles" >
	
	<h1 >Developer Panel</h1>
	
	<h2 class="nav-tab-wrapper wp-clearfix">
	
        <a href="#phpTab" class="odwpi-nav-tab nav-tab nav-tab-active">PHP</a>
		
        <a href="#sqlTab" class="odwpi-nav-tab nav-tab">SQL</a>

        <a href="#gitHubTab" class="odwpi-nav-tab nav-tab">GitHub</a>
        
        <a href="#tfsTab" class="odwpi-nav-tab nav-tab">TFS</a>
	</h2>
</div>
<div class="container-fluid">
    <div class="row d-block">


        <!-- PHP Column -->
        <div id="phpTab" class="d-inline-block mt-2 w-50">
            <label>
                <strong>Test Code:</strong>
                <button id="odwpi_php_coding" class="btn btn-primary">Run Code</button>
            </label>
            <textarea id="odwpi_coding_string" name="odwpi_coding_string" class="d-block w-100"></textarea>
        </div>

        <!-- SQL Column -->
        <div id="sqlTab" class="d-inline-block w-50 mt-2 hidden">
            <label>
                <strong>Run a Query:</strong>
                <button id="odwpi_sql_query" class="btn btn-primary">Run Query</button>
            </label>
            <a href="#TB_inline?&inlineId=odwpi_db_info" class="dashicons dashicons-warning thickbox align-middle text-primary pl-1"></a>
            <div id="odwpi_db_info" class="hidden">
                <label class="d-block mt-2">
                <strong>Database Tables:</strong>
                <?php echo odwpi_dev_display_database_tables(); ?>
                </label>
            </div>

            <textarea id="odwpi_query_string" name="odwpi_query_string" class="d-block w-100"></textarea>
        </div>

        <!-- gitHubTab Column -->
        <div id="gitHubTab" class="d-inline-block w-50 hidden mt-4">
            <div class="form-group mb-2">
                <label><a href="#" class="text-dark" data-toggle="tooltip" title="<?php print $toolTip1 ?>">User/Organization Name</a></label>
                <input type="text" class="form-control" name="gitUser"/>
            </div>
            <div class="form-group mb-2">
                <label>Repository</label>
                <input type="text" class="form-control" name="gitRepo"/>
                <label><input type="checkbox" name="gitPrivateRepo"/> Is Private Repository?</label>
            </div>
            <div class="form-group mb-2 git-private-group hidden">
                <label>Access Token</label>
                <input type="text" class="form-control" name="gitToken"/>
            </div>
            <button id="odwpi_git_api" class="btn btn-primary">Test API</button>
        </div>
        
        <!-- tfsTab Column -->
        <div id="tfsTab" class="d-inline-block w-50 hidden mt-2">
            
        
        </div>

        <!-- Output Column -->
        <div class="w-50 float-right px-3 mt-2">
            <label class="mb-4">
                <strong>Output:</strong>
            </label>
            <pre id="odwpi_output_screen" class="border"></pre>
        </div>
    </div>
</div>