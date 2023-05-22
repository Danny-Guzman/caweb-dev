<?php
/**
 * API's Page
 *
 * @package ODWPI-Dev
 */

?>


<div id="github" class="col-5 mt-3 pt-1">
	<div class="mb-2">
		<strong>User/Organization Name</strong>
		<input type="text" class="form-control" name="git_user" />
		<strong>Repository</strong>
		<input type="text" class="form-control" name="git_repo" />
	</div>
	<div class="form-group mb-2 git-private-group hidden">
		<strong>View Repositories</strong>
		<span><input type="radio" class="form-control" name="git_view" value="" checked>Info</span>
		<span><input type="radio" class="form-control" name="git_view" value="issues">Issues</span>
		<span><input type="radio" class="form-control" name="git_view" value="releases">Releases</span>
		<strong class="d-block">Is Private Repository? <input type="checkbox" name="git_private_repo" /></strong>
		<div class="hidden">
			<strong>Access Token</strong>
			<input type="text" class="form-control" name="git_token" />
		</div>
	</div>
	<button id="odwpi_dev_git_api" class="btn btn-primary">Test API</button>
</div>