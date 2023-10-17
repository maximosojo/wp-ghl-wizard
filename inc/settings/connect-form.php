<?php

	if ( isset( $_GET['get_auth'] ) && $_GET['get_auth'] == 'success' ) {

		$wpghlw_access_token 	= sanitize_text_field( $_GET['atn'] );
		$wpghlw_refresh_token 	= sanitize_text_field( $_GET['rtn'] );
		$wpghlw_locationId 		= sanitize_text_field( $_GET['lid'] );
		$wpghlw_client_id 		= sanitize_text_field( $_GET['cid'] );
		$wpghlw_client_secret 	= sanitize_text_field( $_GET['cst'] );

		// Save data
	    update_option( 'wpghlw_access_token', $wpghlw_access_token );
	    update_option( 'wpghlw_refresh_token', $wpghlw_refresh_token );
	    update_option( 'wpghlw_locationId', $wpghlw_locationId );
	    update_option( 'wpghlw_client_id', $wpghlw_client_id );
	    update_option( 'wpghlw_client_secret', $wpghlw_client_secret );
	    update_option( 'wpghlw_location_connected', 1 );

	    // delete old transient (if exists any)
	    delete_transient('wpghlw_location_tags');
	    delete_transient('wpghlw_location_campaigns');
	    delete_transient('wpghlw_location_wokflow');

	    wp_redirect('admin.php?page=wpghlw');
	}



	$wpghlw_location_connected	= get_option( 'wpghlw_location_connected', WPGHLW_LOCATION_CONNECTED );
	$wpghlw_client_id 			= get_option( 'wpghlw_client_id' );
	$wpghlw_client_secret 		= get_option( 'wpghlw_client_secret' );
	$wpghlw_locationId 			= get_option( 'wpghlw_locationId' );
	$redirect_page 				= get_site_url(null, '/wp-admin/admin.php?page=wpghlw');
	$redirect_uri 				= get_site_url();
	$client_id_and_secret 		= '';

	$auth_end_point = 'https://marketplace.gohighlevel.com/oauth/chooselocation';
	$token_endpoint = 'https://api.msgsndr.com/oauth/token';
	$scopes = "workflows.readonly contacts.readonly contacts.write campaigns.readonly conversations/message.readonly conversations/message.write forms.readonly locations.readonly locations/customValues.readonly locations/customValues.write locations/customFields.readonly locations/customFields.write opportunities.readonly opportunities.write users.readonly links.readonly links.write surveys.readonly users.write locations/tasks.readonly locations/tasks.write locations/tags.readonly locations/tags.write locations/templates.readonly";

	$connect_url = "https://maximosojo.com/ghl-wizard?get_code=1&redirect_page={$redirect_page}";

	if ( ! empty( $wpghlw_client_id ) && ! str_contains( $wpghlw_client_id, 'l73d3ee1' ) ) {
		
		$connect_url = $auth_end_point . "?response_type=code&redirect_uri={$redirect_uri}&client_id={$wpghlw_client_id}&scope={$scopes}";
	}
?>

<div id="wpghlw">
	<h1> <?php _e('Conect With GHL', 'wpghlw'); ?> </h1>
	<hr />

	<form id="wpghlw-settings-form" method='POST' action="<?php echo admin_url('admin-post.php'); ?>">

		<?php wp_nonce_field('wpghlw'); ?>

		<input type="hidden" name="action" value="wpghlw_admin_settings">

		<table class="form-table" role="presentation">

			<tbody>

				<tr>
					<th scope="row">
						<label> <?php _e( 'Client ID (Optional)', 'wpghlw' ); ?> </label>
					</th>
					<td>
						<input type="password" name="wpghlw_client_id"placeholder='optional' value="<?php esc_html_e( $wpghlw_client_id ); ?>">
						<p>
							<a href="https://marketplace.gohighlevel.com/signup" target="_blank">Get client id from here</a>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label> <?php _e( 'Client Secret (Optional)', 'wpghlw' ); ?> </label>
					</th>
					<td>
						<input type="password" name="wpghlw_client_secret" placeholder='optional' value="<?php esc_html_e( $wpghlw_client_secret ); ?>">

						<p>
							<a href="https://marketplace.gohighlevel.com/signup" target="_blank">Get client secret from here</a>
						</p>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label> <?php _e( 'APP Redirect URI', 'wpghlw' ); ?> </label>
					</th>
					<td>
						<?php echo esc_url( $redirect_uri ); ?>			
						<p class="description">If you use your own 'cliend id' and 'client secret' set this url as the Redirect URL of your APP.</p>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label> <?php _e( 'Connect Your Location', 'wpghlw' ); ?> </label>
					</th>
					<td>
						<?php if( $wpghlw_location_connected ){ ?>
							<button class="button disabled">Connected</button>
							<p class="description">Location ID: <?php echo esc_html( $wpghlw_locationId ); ?></p>
							<a class="button" href="<?php echo esc_url( $connect_url ); ?>">Connect Another Location</a>
							<p class="description">Do it with caution. It may affect your previous data.</p>
						<?php } else { ?>

							<a class="button" href="<?php echo esc_url( $connect_url ); ?>">Connect Your Location</a>
							<p>If you use your own client_id and & client_secret, Please save the value first then click connect.</p>
						<?php } ?>
					</td>
				</tr>

			</tbody>
		</table>

		<div>
			<?php submit_button('Update'); ?>
		</div>

	</form>
</div>