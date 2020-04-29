<!-- SQL Column -->
<div id="sql" class="col collapse" data-parent="#odwpi-dev-settings">
	<strong>Enter Query:</strong>
    <button id="odwpi_sql_query" class="btn btn-primary">Execute</button>
    <a href="#TB_inline?&inlineId=odwpi_dev_db_info" class="text-decoration-none dashicons dashicons-warning thickbox align-middle text-primary pl-1"></a>
    <div id="odwpi_dev_db_info" class="hidden">
        <strong class="mr-1 align-middle">Database Tables:</strong>
        <select>
        <?php
            $tables = odwpi_dev_get_database_tables();
            
            if( empty( $tables ) ) :
            ?>
            <option>No Tables Found</option>
            <?php else: 
            foreach($tables as $t => $tbl ):
                $tbl = (array)$tbl;
            ?>
            <option><?php print array_shift($tbl); ?></option>
            <?php 
            endforeach;
            endif;
        ?>
        </select>
    </div>

    <textarea id="odwpi_dev_query_string" name="odwpi_dev_query_string" class="d-block w-100 mt-1"></textarea>
</div>