<?php

// Register Contact
if ( ! function_exists( 'wpghlw_v1_contact_create_data' ) ) {
    
    function wpghlw_v1_contact_create_data($data) {

    	// post contact data
		$wpghlw_api_key = get_option( 'wpghlw_api_key' );
		$endpoint = "https://rest.gohighlevel.com/v1/contacts/";

		$request_args = array(
			'body' 		=> $data,
			'headers' 	=> array(
				'Authorization' => "Bearer {$wpghlw_api_key}"
			),
		);

		$response = wp_remote_post( $endpoint, $request_args );
		$http_code = wp_remote_retrieve_response_code( $response );

		if ( 200 === $http_code || 201 === $http_code ) {

			$body = json_decode( wp_remote_retrieve_body( $response ) );
			$contact = $body->contact;

			return $contact;
		}

		return "";
    }
}