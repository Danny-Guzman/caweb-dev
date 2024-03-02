<?php
/**
 * API's Page
 *
 * @package CAWeb Dev
 */

?>
<h3>Import</h3>
<div class="mb-3 d-flex">
	<div class="col-sm-10 col-md-6">
		<form id="caweb-dev-import" enctype="multipart/form-data" method="post" action="<?php print esc_url( admin_url( 'admin-ajax.php?action=caweb_dev_import' ) ); ?>">
			<?php wp_nonce_field( 'caweb_dev_import_nonce', 'caweb_dev_import_nonce' ); ?>
			<input class="form-control form-control-sm py-2 px-2" type="file" id="importFile">
		</form>
	</div>
 	<button class="btn btn-outline-secondary ms-2" id="import-file">Import</button>
</div>
<h3>Export</h3>
<form id="caweb-dev-export" method="post" action="<?php print esc_url( admin_url( 'admin-ajax.php?action=caweb_dev_export' ) ); ?>">
	<?php wp_nonce_field( 'caweb_dev_export_nonce', 'caweb_dev_export_nonce' ); ?>
	<h4>What would you like to export</h4>
	<ul id="export-options" class="list-group list-group-flush">
		<li class="list-group-item">
			<h5>Navigation</h5>
				<div class="form-check">
					<input checked class="form-check-input mt-2" type="radio" name="nav-selection" value="all" id="all-navs">
					<label class="form-check-label" for="all-navs">
						Select all navigation menus
					</label>
				</div>
				<div class="form-check">
					<input class="form-check-input mt-2" type="radio" name="nav-selection" value="theme-location" id="theme-location">
					<label class="form-check-label" for="theme-location">
						Select registered navigations menus
					</label>
				</div>
				<div id="registered-nav-locations" class="ps-3 ms-2 collapse">
				<?php foreach( get_registered_nav_menus() as $key => $value ): ?>
					<div class="form-check">
						<input class="form-check-input mt-2" type="checkbox" name="nav-location[]" value="<?php print esc_attr( $key ); ?>" id="<?php print esc_attr( $key ); ?>-nav-location">
						<label class="form-check-label" for="<?php print esc_attr( $key ); ?>-nav-location">
							<?php print esc_html( $value ); ?>
						</label>
					</div>
				<?php endforeach; ?>
				</div>
		</li>
	</ul>

	<button id="caweb-dev-export-submit" class="btn btn-primary">Export</button>
</form>

<div id="caweb-dev-modal" class="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
    	<div class="modal-header">
        	<h5 class="modal-title">Do not close this window!</h5>
      	</div>
      	<div class="modal-body text-center">
        	<h5>We are currently perfoming the export, this may take several minutes...</h5>
			<div class="spinner-border" role="status">
				<span class="visually-hidden">Exporting...</span>
			</div>
		</div>
      <div class="modal-footer d-none">
        <a id="download-export" class="btn btn-success">Download</a>
        <button class="btn btn-danger d-none" data-bs-dismiss="modal">Try Again</button>
      </div>
    </div>
  </div>
</div>
