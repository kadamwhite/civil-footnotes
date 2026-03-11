<?php
/**
 * Plugin Name:  Civil Footnotes
 * Plugin URI:   https://github.com/kadamwhite/civil-footnotes
 * Version:      2.2
 * Description:  Add footnotes to your site using a simple, easy-to-read syntax ((by wrapping footnote content with double-parentheses)).
 * Author:       K. Adam White, Austin Sweeney
 * Author URI:   https://www.kadamwhite.com
 * License:      GPL v2 or later
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Requires PHP: 8.2
 */

define( 'CIVIL_FOOTNOTES_VERSION', '2.2' );

require_once plugin_dir_path( __FILE__ ) . 'inc/namespace.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/formats.php';
Civil_Footnotes\setup();
