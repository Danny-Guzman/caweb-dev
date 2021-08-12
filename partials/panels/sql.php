<?php
/**
 * SQL Panel
 *
 * @package ODWPI-Dev
 */

$odwpi_dev_db_tables = odwpi_dev_get_database_tables();

?>
<div id="sql" class="col-5">
	<strong>Enter Query:</strong>
	<button id="odwpi_sql_query" class="btn btn-primary mb-2">Execute</button>
	<a href="#TB_inline?&inlineId=odwpi_dev_db_info" class="text-decoration-none dashicons dashicons-warning thickbox align-middle text-primary pl-1"></a>
	<div id="odwpi_dev_db_info" class="hidden">
		<strong class="mr-1 align-middle">Database Tables:</strong>
		<select>
		<?php

		if ( empty( $odwpi_dev_db_tables ) ) :
			?>
			<option>No Tables Found</option>
			<?php
			else :
				foreach ( $odwpi_dev_db_tables as $odwpi_dev_table => $odwpi_dev_tbl ) :
					$odwpi_dev_tbl = (array) $odwpi_dev_tbl;
					?>
			<option><?php print esc_html( array_shift( $odwpi_dev_tbl ) ); ?></option>
					<?php
			endforeach;
			endif;
			?>
		</select>
	</div>

	<textarea id="odwpi_dev_query_string" name="odwpi_dev_query_string">-- SQL Query</textarea>
</div>
