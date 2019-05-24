<?php


?>
<div class="wrap option-titles" >
	
	<h1 >Developer Panel</h1>
	
	<h2 class="nav-tab-wrapper wp-clearfix">
	
        <a href="#phpTab" class="odwpi-nav-tab nav-tab nav-tab-active">PHP</a>
		
        <a href="#sqlTab" class="odwpi-nav-tab nav-tab">SQL</a>
	</h2>
</div>
<div class="container-fluid">
    <div id="phpTab" class="row no-gutters w-50 mx-0 d-inline-block">
        <!-- PHP Column -->
        <div class="col">
            <label class="d-inline-block mt-2"><strong>Test Code:</strong> <button id="odwpi_php_coding" class="btn btn-primary">Run Code</button></label>
            <textarea id="odwpi_coding_string" name="odwpi_coding_string" class="d-block w-100"></textarea>
        </div>
    </div>
    <div id="sqlTab" class="hidden row no-gutters w-50 mx-0 d-inline-block">
        <!-- SQL Column -->
        <div class="col">
            <label class="d-block mt-2"><strong>Database Tables:</strong> <?php echo odwpi_dev_display_database_tables(); ?></label>
            <label class="d-inline-block mt-2"><strong>Run a Query:</strong> <button id="odwpi_sql_query" class="btn btn-primary">Run Query</button></label>
            <textarea id="odwpi_query_string" name="odwpi_query_string" class="d-block w-100"></textarea>
        </div>
    </div>
    <div class="row no-gutters w-50 mx-0 d-inline-block float-right pl-5">
        <!-- Output Column -->
        <div class="col">
            <label class="d-inline-block mt-2"><strong>Output:</strong></label>
            <pre id="odwpi_output_screen" class="border"></pre>
        </div>
    </div>
    
</div>