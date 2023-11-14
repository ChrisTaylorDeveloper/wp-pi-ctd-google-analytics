<?php
/**
 * Plugin Name: WP CTD Google Analytics
 * Description: Adds Google Analytics code to each page.
 * Author: Chris Taylor
 * Author URI: https://christaylordeveloper.co.uk
 */

function wporg_settings_init() {
	register_setting( 'wporg', 'wporg_options' );

	add_settings_section(
		'ctd_section_developers',
		'CTD Google Analytics', 'wporg_section_developers_callback',
		'wporg'
	);

	add_settings_field(
		'wporg_field_pill',
        'Pill',
		'ctd_field_tag_cb',
		'wporg',
		'ctd_section_developers'
	);
}
add_action( 'admin_init', 'wporg_settings_init' );

function wporg_section_developers_callback( $args ) {
	?>
	<p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Settings for interaction with Google Analytics', 'wporg' ); ?></p>
	<?php
}

function ctd_field_tag_cb() {
	$options = get_option( 'wporg_options' );
	?>
    <textarea rows="4" cols="50" name="wporg_options"><?php echo isset( $options ) ? esc_attr( $options ) : ''; ?></textarea>
	<p class="description">
		<?php esc_html_e( 'The Google Analytics Tag, to appear in the head of each page.', 'wporg' ); ?>
	</p>
	<?php
}

function wporg_options_page() {
	add_menu_page(
		'CTD Analytics',
		'CTD Analytics',
		'manage_options',
		'wporg',
		'wporg_options_page_html'
	);
}
add_action( 'admin_menu', 'wporg_options_page' );

function wporg_options_page_html() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( isset( $_GET['settings-updated'] ) ) {
		add_settings_error( 'wporg_messages', 'wporg_message', 'Settings Saved', 'updated' );
	}

	settings_errors( 'wporg_messages' );
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'wporg' );
			do_settings_sections( 'wporg' );
			submit_button( 'Save Settings' );
			?>
		</form>
	</div>
	<?php
}