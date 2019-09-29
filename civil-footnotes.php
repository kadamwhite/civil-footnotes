<?php
/*
Plugin Name: Civil Footnotes
Plugin URI: https://defomicron.net/projects/civil_footnotes
Version: 1.3.1
Description: Parses and displays footnotes. Based on <a href="http://elvery.net/drzax/wordpress-footnotes-plugin">WP-Foonotes</a> by <a href="http://elvery.net">Simon Elvery</a>, and the footnote syntax pioneered by <a href="http://daringfireball.net/2005/07/footnotes">John Gruber</a>.
Author: <a href="https://defomicron.net/colophon">Austin Sweeney</a>
*/

// We only support PHP 7 and up.
if ( version_compare( phpversion(), '7.0.0', '<' ) ) {
	add_action( 'admin_notices', function() {
		/* translators: Error message explaining PHP version is too low. %s: Current PHP version. */
		$php_version_warning = sprintf(
			__( 'Civil Footnotes requires PHP 7 or higher; you are using %s. Please contact your host to upgrade your PHP version, or downgrade to Civil Footnotes version 1.3.1.' ),
			phversion()
		);
		$deactivation_notice = __( 'The plugin has been deactivated.', 'civil-footnotes' );

		?>
		<div class="notice notice-error is-dismissible">
			<p><?php esc_html( $php_version_warning ); ?></p>
			<p><?php esc_html( $deactivation_notice ); ?></p>
		</div>
		<?php
	} );

	deactivate_plugins( plugin_basename( __FILE__ ) );

	// Halt plugin initialization.
	return;
}

define( 'CIVIL_FOOTNOTES_VERSION', '1.3.1' );

require_once plugin_dir_path( __FILE__ ) . 'inc/namespace.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/formats.php';
Civil_Footnotes\setup();
