<?php

/*
 * Plugin Name: Jetpack Extra Options Panel
 * Plugin URI: http://github.com/automattic/jetpack-extra-options-panel
 * Description: Make it easier to modify settings and options in Jetpack without the need for custom code, or cluttering up the core plugin with extra options.
 * Author: Automattic
 * Version: 0.1-alpha
 * Author URI: http://jetpack.me
 * License: GPL2+
 * Text Domain: jetpack-op
 * Domain Path: /languages/
 */

class Jetpack_Extra_Options_Panel {

	static function init() {
		if ( ! class_exists( 'Jetpack' ) ) {
			return;
		}

		include( plugin_dir_path( __FILE__ ) . 'general.php' );

		// Each module's extra options should go in a file dedicated to that module.
		// As such, we shouldn't present options for modules that aren't active.
		foreach ( Jetpack::get_active_modules() as $module ) {
			$module = sanitize_file_name( $module );
			$file = plugin_dir_path( __FILE__ ) . "modules/{$module}.php";
			if ( is_readable( $file ) ) {
				include_once( $file );
			}
		}

		add_action( 'jetpack_admin_menu', array( __CLASS__, 'jetpack_admin_menu' ) );
	}

	static function jetpack_admin_menu() {
		$hook = add_submenu_page( 'jetpack', __( 'Extra Jetpack Options', 'jetpack-op' ), __( 'Extra Options', 'jetpack' ), 'manage_options', 'jetpack_extra_options', array( __CLASS__, 'admin_page_extra_options' ) );
	}

	static function admin_page_extra_options() {
		?>
		<div class="wrap" id="jetpack-settings">
			<h2><?php esc_html_e( 'Extra Jetpack Options', 'jetpack-op' ); ?></h2>
			<form method="post" action="options.php">
				<?php settings_fields( 'jetpack-extra-options' ); ?>
				<?php do_settings_sections( 'jetpack-extra-options' ); ?>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}

}

add_action( 'init', array( 'Jetpack_Extra_Options_Panel', 'init' ) );
