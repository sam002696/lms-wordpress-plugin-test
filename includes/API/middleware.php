<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

add_filter( 'rest_authentication_errors', function ( $result ) {

	if ( ! empty( $result ) ) {
		return $result;
	}

	$auth = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

	if ( ! $auth ) {
		return $result;
	} // public route

	if ( ! str_starts_with( $auth, 'Bearer ' ) ) {
		return new WP_Error( 'unauthorized', 'Token missing', [ 'status' => 401 ] );
	}

	$token = trim( str_replace( 'Bearer', '', $auth ) );

	try {
		$payload = JWT::decode( $token, new Key( MY_LMS_JWT_SECRET, 'HS256' ) );

		wp_set_current_user( $payload->user_id );

		return true;

	} catch ( Exception $e ) {
		return new WP_Error( 'unauthorized', 'Invalid or expired token', [ 'status' => 401 ] );
	}
} );