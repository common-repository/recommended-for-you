<?php
/**
 * Description: Shows "Recomended for you"
 * Version: 1.1
 * Author: Mukul Lodhi
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.htmls
 *
 * Display Recommended Posts.
 *
 * @package     Recommended_For_You
 * @author      Mukul Lodhi
 * @license     GPL-2.0+
 */

if ( ! function_exists( 'rfy_settings' ) ) {

	/** Function admin menu */
	function rfy_settings() {
		add_menu_page( 'RFY', 'Recommended for You', 'manage_options', RFY_SLUG, 'rfy_settings_page' );
	}
}

add_action( 'admin_menu', 'rfy_settings' );

if ( ! function_exists( 'rfy_settings_page' ) ) {

	/** Function Admin page */
	function rfy_settings_page() {
		rfy_update_values();
		$rfy_settings = get_option( 'rfy_settings' );
		?>
		<div class="wrap">		
			<h2>Recommended for You </h2>
			<hr>
			<form method="post" id="rfy__frm">
				<table class="form-table">
					<tr>
						<th scope="row"><label for="rfy_enable">Enabled:</label></th>
						<td>
							<input type="radio" name="rfy_enable" id="rfy_enable_yes" value="yes" <?php checked( $rfy_settings['enabled'], 'yes' ); ?> ><label for="rfy_enable_yes">Yes</label> <br>
							<input type="radio" name="rfy_enable" id="rfy_enable_no"  value="no" <?php checked( $rfy_settings['enabled'], 'no' ); ?>><label for="rfy_enable_no">No</label> 
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="rfy_enable_btn">Show Close Button:</label></th>
						<td>
							<input type="radio" name="rfy_enable_btn" id="rfy_enable_btn_yes" value="yes" <?php checked( $rfy_settings['enabled_btn'], 'yes' ); ?> ><label for="rfy_enable_btn_yes">Yes</label> <br>
							<input type="radio" name="rfy_enable_btn" id="rfy_enable_btn_no"  value="no" <?php checked( $rfy_settings['enabled_btn'], 'no' ); ?>><label for="rfy_enable_btn_no">No</label> 
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="rfy_mobile_enable">Enable for Mobile:</label></th>
						<td>
							<input type="radio" name="rfy_mobile_enable" id="rfy_mobile_enable_yes" value="yes" <?php checked( $rfy_settings['mobile_enabled'], 'yes' ); ?> ><label for="rfy_mobile_enable_yes">Yes</label> <br>
							<input type="radio" name="rfy_mobile_enable" id="rfy_mobile_enable_no"  value="no" <?php checked( $rfy_settings['mobile_enabled'], 'no' ); ?>><label for="rfy_mobile_enable_no">No</label> 
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="rfy_enable_heading">Enable Heading:</label></th>
						<td>
							<input type="radio" name="rfy_enable_heading" id="rfy_enable_heading_yes" value="yes" <?php checked( $rfy_settings['enable_heading'], 'yes' ); ?> ><label for="rfy_enable_heading_yes">Yes</label> <br>
							<input type="radio" name="rfy_enable_heading" id="rfy_enable_heading_no"  value="no" <?php checked( $rfy_settings['enable_heading'], 'no' ); ?>><label for="rfy_enable_heading_no">No</label> 
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="rfy_heading">Heading:</label></th>
						<td>
							<input type="text" name="rfy_heading" id="rfy_heading" value="<?php echo esc_html( $rfy_settings['rfy_heading'] ); ?>">
						</td>
					</tr>
					<tr>
						<th scope="row"> <input name="rfy_submit_update" type="submit" class="button button-primary " /></th>
					</tr>  
					<?php wp_nonce_field( 'rfy_nonce_action', 'rfy_nonce' ); ?>
				</table>
			</form>
		</div>
		<?php
	}
}

if ( ! function_exists( 'rfy_update_values' ) ) {

	/** Function update settings */
	function rfy_update_values() {

		global $rfy_settings;

		if ( isset( $_POST['rfy_nonce'] ) ) {

			$nonce = sanitize_text_field( wp_unslash( $_POST['rfy_nonce'] ) );

			if ( ! wp_verify_nonce( $nonce, 'rfy_nonce_action' ) ) {

				die( 'Nonce value cannot be verified.' );

			} else {

				$rfy_enable         = sanitize_text_field( wp_unslash( isset( $_POST['rfy_enable'] ) ? $_POST['rfy_enable'] : null ) );
				$rfy_enable_btn     = sanitize_text_field( wp_unslash( isset( $_POST['rfy_enable_btn'] ) ? $_POST['rfy_enable_btn'] : null ) );
				$rfy_mobile_enable  = sanitize_text_field( wp_unslash( isset( $_POST['rfy_mobile_enable'] ) ? $_POST['rfy_mobile_enable'] : null ) );
				$rfy_enable_heading = sanitize_text_field( wp_unslash( isset( $_POST['rfy_enable_heading'] ) ? $_POST['rfy_enable_heading'] : null ) );
				$rfy_heading        = sanitize_text_field( wp_unslash( isset( $_POST['rfy_heading'] ) ? $_POST['rfy_heading'] : null ) );

				$rfy_settings['enabled']        = $rfy_enable;
				$rfy_settings['enabled_btn']    = $rfy_enable_btn;
				$rfy_settings['mobile_enabled'] = $rfy_mobile_enable;
				$rfy_settings['enable_heading'] = $rfy_enable_heading;
				$rfy_settings['rfy_heading']    = $rfy_heading;

				update_option( 'rfy_settings', $rfy_settings );
			}
		}
	}
}
