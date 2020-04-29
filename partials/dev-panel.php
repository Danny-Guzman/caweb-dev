<?php

$nonce = wp_create_nonce( 'odwpi_dev_panel_nonce' );

$sample_code = "//Sample Code\n\$d = get_site_option('dev');\n\nprint_r( \$d );";
$toolTip1 = "Leaving this field blank will return information about all the Users/Organization Repositories.";
?>

<div class="container-fluid mt-4 d-grid">
	<div class="row">
		<ul class="menu-list list-group list-group-horizontal">
    		<li class="list-group-item mb-0"><a href="#php" class="text-decoration-none odwpi-dev-nav-tab" data-toggle="collapse" aria-expanded="true">PHP</a></li>
			<li class="list-group-item mb-0"><a href="#sql" class="text-decoration-none odwpi-dev-nav-tab" data-toggle="collapse" aria-expanded="false">SQL</a></li>
			<li class="list-group-item mb-0"><a href="#github" class="text-decoration-none odwpi-dev-nav-tab" data-toggle="collapse" aria-expanded="false">GitHub</a></li>
			<!--<li class="list-group-item mb-0"><a href="#tfs" class="text-decoration-none" data-toggle="collapse" aria-expanded="false">TFS</a></li>-->
		</ul>
	</div>
	<div id="odwpi-dev-settings" class="row py-3 mr-3 bg-white overflow-auto">
        <?php require_once 'panels/php.php'; ?>
        <?php require_once 'panels/sql.php'; ?>
		<?php require_once 'panels/github.php'; ?>
		<?php require_once 'panels/tfs.php'; ?>
        <?php require_once 'panels/output.php'; ?>
	</div>
</div>
