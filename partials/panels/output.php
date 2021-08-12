<?php
/**
 * Output Panel
 *
 * @package ODWPI-Dev
 */

?>
<div id="output" class="col-7 mt-3 overflow-auto">
	<strong>Output:</strong>
	<a id="git-info" class="dashicons dashicons-admin-generic thickbox align-middle text-primary mb-2<?php 'github' === $odwpi_dev_page ? ' hidden' : ''; ?>" href="#TB_inline?&amp;inlineId=odwpi_dev_git_info"></a>
	<div id="odwpi_dev_git_info" class="hidden">
		<strong>A request has not been made.</strong>
	</div>
	<div class="wmd-view-topscroll">
		<div class="scroll-div1">
		</div>
	</div>
	<div class="wmd-view border">
		<div class="scroll-div2">
			<pre id="odwpi_dev_output_screen" class="border p-1 mb-0 overflow-hidden"></pre>
		</div>
	</div>
</div>
