<?php

if ( $_POST["wpghlw_location_update"]  ) {

    $wpghlw_location_id 	= sanitize_text_field( $_POST['wpghlw_location_id'] );
    $wpghlw_api_key 	= sanitize_text_field( $_POST['wpghlw_api_key'] );

    // Save data
    update_option( 'wpghlw_location_id', $wpghlw_location_id );
    update_option( 'wpghlw_api_key', $wpghlw_api_key );
    update_option( 'wpghlw_location_setting', 1 );

    // delete old transient (if exists any)
    delete_transient('wpghlw_location_tags');

    wp_redirect('admin.php?page=wpghlw');
}

$wpghlw_location_setting	= get_option( 'wpghlw_location_setting', WPGHLW_LOCATION_SETTING );
$wpghlw_location_id 			= get_option( 'wpghlw_location_id' );
$wpghlw_api_key 		= get_option( 'wpghlw_api_key' );
?>

<div id="wpghlw">
<h1> <?php _e('Location With GHL', 'wpghlw'); ?> </h1>
<hr />

<form id="wpghlw-settings-form" method="POST">

    <?php wp_nonce_field('wpghlw'); ?>

    <input type="hidden" name="action" value="wpghlw_admin_settings">

    <table class="form-table" role="presentation">

        <tbody>

            <tr>
                <th scope="row">
                    <label> <?php _e( 'Location ID (Optional)', 'wpghlw' ); ?> </label>
                </th>
                <td>
                    <input type="text" name="wpghlw_location_id"placeholder='optional' value="<?php esc_html_e( $wpghlw_location_id ); ?>">
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label> <?php _e( 'API Key (Required)', 'wpghlw' ); ?> </label>
                </th>
                <td>
                    <input type="password" name="wpghlw_api_key" placeholder='required' required value="<?php esc_html_e( $wpghlw_api_key ); ?>">
                </td>
            </tr>

        </tbody>
    </table>

    <div>
        <?php submit_button('Update','primary','wpghlw_location_update'); ?>
    </div>

</form>
</div>