<?php
/**
 * Plugin Name:     CTD Google Analytics
 * Description:     Adds Google Analytics code to each page.
 * Version:         1.0
 * Author:          Chris Taylor
 * Author URI:      https://christaylordeveloper.co.uk
 */

function ctd_settings_init() {
	register_setting( 'ctd', 'ctd_opt_google_tag' );

	add_settings_section(
		'ctd_section_developers',
		'CTD Google Analytics',
        'ctd_section_developers_callback',
		'ctd'
	);

	add_settings_field(
		'ctd_field_analytics',
        'The Google Tag',
		'ctd_field_tag_cb',
		'ctd',
		'ctd_section_developers'
	);
}
add_action( 'admin_init', 'ctd_settings_init' );

function ctd_section_developers_callback() {
	?><p><?php esc_html_e( 'Settings for interaction with Google Analytics', 'ctd' ); ?></p><?php
}

function ctd_field_tag_cb() {
	$options = get_option( 'ctd_opt_google_tag' );
	?>
    <textarea rows="4" cols="50" name="ctd_opt_google_tag"><?php echo isset( $options ) ? esc_attr( $options ) : ''; ?></textarea>
	<p class="description">
		<?php esc_html_e( 'The Google Analytics Tag, to appear in the head of each page.', 'ctd' ); ?>
	</p>
	<?php
}

function ctd_options_page() {
	add_menu_page(
		'CTD Analytics',
		'CTD Analytics',
		'manage_options',
		'ctd',
		'ctd_analytics_opts_page_html'
	);
}
add_action( 'admin_menu', 'ctd_options_page' );

function ctd_analytics_opts_page_html() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( isset( $_GET['settings-updated'] ) ) {
		add_settings_error( 'ctd_messages', 'ctd_message', 'Settings Saved', 'updated' );
	}

	settings_errors( 'ctd_messages' );
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'ctd' );
			do_settings_sections( 'ctd' );
			submit_button( 'Save Settings' );
			?>
		</form>
	</div>
	<?php
}

function ctd_wp_body_open() {
    $setting = get_option('ctd_opt_google_tag');
    echo isset( $setting ) ? $setting : '';
}
add_action( 'wp_body_open', 'ctd_wp_body_open' );