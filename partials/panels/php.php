<?php
/**
 * PHP Panel
 *
 * @package ODWPI-Dev
 */

$odwpi_dev_sample_header = "/*\n * For information: \n * https://www.php.net/\n * https://www.w3schools.com/php/\n */\n\n";
$odwpi_dev_sample_code   = "// Sample Code\n\$d = get_site_option('dev');\n\nprint_r( \$d );";

$odwpi_dev_opening = "<?php\n" . $odwpi_dev_sample_header . $odwpi_dev_sample_code;
?>

<!-- PHP Column -->
<div id="php" class="col-5">
	<strong>Test Code:</strong>
	<button id="odwpi_dev_php_coding" class="btn btn-primary mb-2">Run Code</button>
	<textarea id="odwpi_dev_php_coding_string" name="odwpi_dev_php_coding_string"><?php print esc_html( $odwpi_dev_opening ); ?></textarea>
</div>
