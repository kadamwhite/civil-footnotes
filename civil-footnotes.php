<?php
/**
 * Plugin Name:  Civil Footnotes
 * Plugin URI:   https://github.com/kadamwhite/civil-footnotes
 * Version:      2.1
 * Description:  Add footnotes to your site using a simple, easy-to-read syntax ((by wrapping footnote content with double-parentheses)).
 * Author:       K. Adam White, Austin Sweeney
 * Author URI:   https://www.kadamwhite.com
 * License:      GPL v2 or later
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Requires PHP: 7.0
 */

// We only support PHP 7 and up.
if ( version_compare( phpversion(), '7.0.0', '<' ) ) {
	add_action(
		'admin_notices',
		function() {
			$php_version_warning = sprintf(
				/* translators: Error message explaining PHP version is too low. %s: Current PHP version. */
				__( 'Civil Footnotes requires PHP 7 or higher; you are using %s. Please contact your host to upgrade your PHP version, or downgrade to Civil Footnotes version 1.3.1.' ),
				phpversion()
			);
			$deactivation_notice = __( 'The plugin has been deactivated.', 'civil-footnotes' );

			?>
		<div class="notice notice-error is-dismissible">
			<p><?php echo esc_html( $php_version_warning ); ?></p>
			<p><?php echo esc_html( $deactivation_notice ); ?></p>
		</div>
			<?php
		}
	);

	add_action(
		'admin_init',
		function() {
			deactivate_plugins( plugin_basename( __FILE__ ) );
		}
	);

	// Halt plugin initialization.
	return;
}

define( 'CIVIL_FOOTNOTES_VERSION', '1.3.1' );

require_once plugin_dir_path( __FILE__ ) . 'inc/namespace.php';
require_once plugin_dir_path( __FILE__ ) . 'inc/formats.php';
Civil_Footnotes\setup();
