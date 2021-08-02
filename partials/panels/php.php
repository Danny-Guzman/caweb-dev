<?php
/**
 * PHP Panel
 *
 * @package ODWPI-Dev
 */

$odwpi_dev_sample_code = "// Sample Code\n\$d = get_site_option('dev');\n\nprint_r( \$d );"
?>

<!-- PHP Column -->
<div id="php" class="col collapse show" data-parent="#odwpi-dev-settings">
	<strong>Test Code:</strong>
	<button id="odwpi_dev_php_coding" class="btn btn-primary">Run Code</button>
	<textarea id="odwpi_dev_php_coding_string" name="odwpi_dev_php_coding_string" class="d-block w-100 mt-1"><?php print esc_html( $odwpi_dev_sample_code ); ?></textarea>
</div>
