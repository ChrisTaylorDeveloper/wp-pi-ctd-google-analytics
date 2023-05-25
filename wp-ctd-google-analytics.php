<?php
/**
 * Plugin Name: WP CTD Google Analytics
 * Description: Adds Google Analytics code to each page.
 * Author: Chris Taylor
 * Author URI: https://christaylordeveloper.co.uk
 */

function wp_ctd_settings_init() {
	register_setting('general', 'wp_ctd_google_code');

	add_settings_section(
		'wp_ctd_google_analytics_settings_section',
		'CTD Google Analytics', 'wp_ctd_google_analytics_settings_section_callback',
		'general'
	);

	add_settings_field(
		'wporg_settings_field',
		'Google Tag code', 'wp_ctd_setting_field',
		'general',
		'wp_ctd_google_analytics_settings_section'
	);
}

add_action('admin_init', 'wp_ctd_settings_init');

function wp_ctd_google_analytics_settings_section_callback() {
	echo '<p>CTD Google Analytics Section Introduction.</p>';
}

function wp_ctd_setting_field() {
	$setting = get_option('wp_ctd_google_code');
	?>
    <textarea rows="4" cols="50" name="wp_ctd_google_code"><?php echo isset( $setting ) ? esc_attr( $setting ) : ''; ?></textarea>';
    <?php
}

function wp_ctd_body_open() {
     echo "xxxxxxxxxxxxxxxxxxxxxxxxxxxx";
}
add_action( 'wp_body_open', 'wp_ctd_body_open' );
