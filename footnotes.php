<?php
/*
Plugin Name: Civil Footnotes
Plugin URI: https://defomicron.net/projects/civil_footnotes
Version: 1.3.1
Description: Parses and displays footnotes. Based on <a href="http://elvery.net/drzax/wordpress-footnotes-plugin">WP-Foonotes</a> by <a href="http://elvery.net">Simon Elvery</a>, and the footnote syntax pioneered by <a href="http://daringfireball.net/2005/07/footnotes">John Gruber</a>.
Author: <a href="https://defomicron.net/colophon">Austin Sweeney</a>
*/

// If you’d like to edit the output, scroll down to the
// “Display the footnotes” section near the end of this file.

// Some important constants
define( 'WP_FOOTNOTES_OPEN', ' ((' );
define( 'WP_FOOTNOTES_CLOSE', '))' );
define( 'WP_FOOTNOTES_VERSION', '1.3.1' );

require_once plugin_dir_path( __FILE__ ) . 'inc/class-swas-wp-footnotes.php';

// Instantiate the class
$swas_wp_footnotes = new swas_wp_footnotes();
