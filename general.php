<?php

class Jetpack_Extra_Options_General {

	static function init() {
		add_action( 'admin_init', array( __CLASS__, 'admin_init' ) );
	}

	static function admin_init() {
		add_settings_section( 'eo-general', esc_html__( 'General', 'jetpack-eo' ), array( __CLASS__, 'settings_section' ), 'jetpack-extra-options' );

		add_settings_field(
				'jetpack_eo_general_dummy',
				sprintf( '<label for="jetpack_eo_general_dummy">%1$s</label>', __( 'Dummy Option', 'jetpack-eo' ) ),
				array( __CLASS__, 'jetpack_eo_general_dummy_cb' ),
				'jetpack-extra-options',
				'eo-general'
		);

		register_setting( 'jetpack-extra-options', 'jetpack_eo_general_dummy', 'sanitize_title' );
	}

	static function settings_section() {
		?>
		<p><?php _e( 'General Jetpack settings not specific to any particular module:', 'jetpack-eo' ); ?></p>
		<?php
	}

	static function jetpack_eo_general_dummy_cb() {
		$value = get_option( 'jetpack_eo_general_dummy' );
		?>
		<input class="regular-text" type="text" name="jetpack_eo_general_dummy" id="jetpack_eo_general_dummy" value="<?php echo esc_attr( $value ); ?>" />
		<?php
	}

}

Jetpack_Extra_Options_General::init();
