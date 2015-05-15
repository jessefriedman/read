<?php
/*
Plugin Name: Read
Description: A free WordPress plugin that will mark posts read for individual users
Author: Jesse Friedman
Version: 0.1
License: GPLv2 or later
*/

class WP_Read {

	static $read;
	const VERSION = 0.1;
	var $current_read_options;

	function __construct() {
		add_action( 'admin_init', array( $this, 'read_admin_init' ) );
		add_action( 'admin_menu', array( $this, 'read_admin_menu' ) );
	}

	function read_admin_init() {
		register_setting( 'read-config-settings', 'read_config_settings' );
		add_settings_section( 'read_show', '', '__return_false', 'read-settings' );
		add_settings_field( 'read_show_id', __( 'Show Read circle?', 'read'), array( $this, 'read_options'), 'read-settings', 'read_show' );
	}

	function read_admin_menu() {
		$hook = add_options_page( __( 'Read', 'read' ), __( 'Read', 'read' ), 'manage_options', 'read', array( $this, 'read_build_options' ) );
	}

	function read_options() {
		isset( $this->current_read_options['read_show_id'] ) ? $current_read_show_id = $this->current_read_options['read_show_id'] : $current_read_show_id = 0;
		?>
		<p class="description">
			<input name="read_config_settings[read_show_id]" type="checkbox" id="read_show" value="1" <?php if( 1 == $current_read_show_id ) echo 'checked="checked"'; ?> >
			<?php _e( 'I want <strong>Forward</strong> to publish a post saved in the "Drafted Forward" category to keep me on point.', 'read' ); ?>
		</p>
	<?php
	}

	function read_build_options() {
	?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Forward', 'frwrd' ); ?></h2>

			<form action="options.php" method="post">
				<?php settings_fields( 'frwrd-config-settings' ); ?>
				<?php do_settings_sections( 'frwrd-config-settings' ); ?>
				<p class="submit"><input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ); ?>" /></p>
			</form>

		</div>
	<?php
	}
}
new WP_Read;