<?php
?>

<div id="wpghlw-options">
	<h1> <?php _e('Set Options', 'wpghlw'); ?> </h1>
	<hr />

	<form id="wpghlw-settings-form" method='POST' action="<?php echo admin_url('admin-post.php'); ?>">

		<?php wp_nonce_field('wpghlw'); ?>

		<input type="hidden" name="action" value="wpghlw_admin_settings">

		<table class="form-table" role="presentation">

			<tbody>

				<tr>
					<th scope="row">
						<label> <?php _e( 'Trigger will be fired when the WooCommerce order status is:', 'wpghlw' ); ?> </label>
					</th>
					<td>
						<select name='wpghlw_order_status'>
							<?php echo wpghlw_get_all_order_statuses(); ?>
						</select>
					</td>
				</tr>
			</tbody>
		</table>

		<div>
			<?php submit_button('Update'); ?>
		</div>

	</form>
</div>

<?php

function wpghlw_get_all_order_statuses() {

	$order_statuses = wc_get_order_statuses();
	$wpghlw_order_status = get_option('wpghlw_order_status');
	$selected = !empty($wpghlw_order_status) ? $wpghlw_order_status : 'wc-processing';

	$statuses = "";
	foreach ( $order_statuses as $key => $status ) {

		$selected_status = ( $selected == $key ) ? 'selected' : '';
		$statuses .= "<option value='{$key}' {$selected_status}> {$status} </option>";
	}

	return $statuses;
}