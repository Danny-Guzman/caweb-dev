/**
 * WPGulp Configuration File
 *
 * 1. Edit the variables as per your project requirements.
 * 2. In paths you can add <<glob or array of globs>>.
 *
 * @package WPGulp
 */


module.exports = {
	adminCSS:[ // WP Backend Admin CSS
		'assets/scss/admin.scss',
		'assets/scss/codemirror/codemirror.css',
	],
	adminJS: [ // WP Backend Admin JS
		'assets/js/bootstrap/bootstrap.bundle.js',
		'assets/js/odwpi/helper.js',
		'assets/js/odwpi/dual_scrollbar.js',
		'assets/js/codemirror/codemirror.js',
		'assets/js/odwpi/admin.js',
	], 
	frontendCSS: [], // Frontend CSS
	frontendJS: [], // Frontend JS 
};
