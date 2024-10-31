<?php
/**
 * Plugin Name: Recomended For You
 * Description: Shows posts that are "Recomended for you"
 * Requires at least: 5.5.3
 * Tested up to: 5.7
 * Version: 1.1
 * Author: Mukul Lodhi
 * Author URI: https://profiles.wordpress.org/mukkiee/
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.htmls
 *
 * Display Recommended Posts.
 *
 * @package     Recommended_For_You
 * @author      Mukul Lodhi
 * @license     GPL-2.0+
 */

define( 'RFY_SLUG', 'recommended-for-you' );
$rfy_settings = get_option( 'rfy_settings' );

if ( ! function_exists( 'rfy_activate' ) ) {

	/** Function to activate plugin */
	function rfy_activate() {

		global $rfy_settings;
		$defaults = array(

			'version'        => 1.1,
			'enabled'        => 'yes',
			'enabled_btn'    => 'yes',
			'mobile_enabled' => 'no',
			'enable_heading' => 'yes',
			'rfy_heading'    => 'Recommended For You.',

		);
		$rfy_settings = wp_parse_args( $rfy_settings, $defaults );
		update_option( 'rfy_settings', $rfy_settings );
	}
}

if ( ! function_exists( 'rfy_deactivate' ) ) {

	/** Function to deactivate plugin */
	function rfy_deactivate() {

		delete_option( 'rfy_settings' );
	}
}

register_activation_hook( __FILE__, 'rfy_activate' );

register_deactivation_hook( __FILE__, 'rfy_deactivate' );

register_uninstall_hook( __FILE__, 'rfy_deactivate' );

require plugin_dir_path( __FILE__ ) . 'rfy-functions.php';

require plugin_dir_path( __FILE__ ) . 'rfy-admin.php';

require plugin_dir_path( __FILE__ ) . 'rfy-front-end.php';

