<?php

add_thickbox();

?>
<div class="wrap option-titles" >
	
	<h1 >Developer Panel</h1>
	
	<h2 class="nav-tab-wrapper wp-clearfix">
	
        <a href="#phpTab" class="odwpi-nav-tab nav-tab nav-tab-active">PHP</a>
		
        <a href="#sqlTab" class="odwpi-nav-tab nav-tab">SQL</a>
	</h2>
</div>
<div class="container-fluid">
    <div class="row d-block">


        <!-- PHP Column -->
        <div id="phpTab" class="d-inline-block w-50">
            <label class="mt-2">
                <strong>Test Code:</strong>
                <button id="odwpi_php_coding" class="btn btn-primary">Run Code</button>
            </label>
            <textarea id="odwpi_coding_string" name="odwpi_coding_string" class="d-block w-100"></textarea>
        </div>

        <!-- SQL Column -->
        <div id="sqlTab" class="d-inline-block w-50 hidden">
            <label class="mt-2">
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

        <!-- Output Column -->
        <div class="w-50 float-right px-3">
            <label class="mt-2 mb-4">
                <strong>Output:</strong>
            </label>
            <pre id="odwpi_output_screen" class="border"></pre>
        </div>
    </div>
</div>