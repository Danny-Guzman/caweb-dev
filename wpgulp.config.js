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
		'node_modules/codemirror/lib/codemirror.css',
		'node_modules/codemirror/addon/fold/foldgutter.css',
		'assets/scss/admin.scss',
	],
	adminJS: [ // WP Backend Admin JS
		'assets/js/bootstrap/bootstrap.bundle.js',
		'node_modules/codemirror/lib/codemirror.js',
		'node_modules/codemirror/mode/clike/clike.js',
		'node_modules/codemirror/mode/css/css.js',
		'node_modules/codemirror/mode/htmlmixed/htmlmixed.js',
		'node_modules/codemirror/mode/javascript/javascript.js',
		'node_modules/codemirror/mode/php/php.js',
		'node_modules/codemirror/mode/sql/sql.js',
		'node_modules/codemirror/mode/xml/xml.js',
		'node_modules/codemirror/addon/edit/closebrackets.js',
		'node_modules/codemirror/addon/edit/closetag.js',
		'node_modules/codemirror/addon/fold/foldcode.js',
		'node_modules/codemirror/addon/fold/foldgutter.js',
		'node_modules/codemirror/addon/fold/brace-fold.js',
		'node_modules/codemirror/addon/fold/xml-fold.js',
		'assets/js/odwpi/helper.js',
		'assets/js/odwpi/dual_scrollbar.js',
		'assets/js/odwpi/admin.js',
	], 
	frontendCSS: [], // Frontend CSS
	frontendJS: [], // Frontend JS 
};
