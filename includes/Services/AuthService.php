<?php

namespace MyLMS\Services;

use WP_Error;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthService {

	public static function register( array $data ): array|WP_Error {

		// Validate required fields
		$required = [ 'email', 'password', 'first_name', 'last_name' ];

		foreach ( $required as $field ) {
			if ( empty( $data[ $field ] ) ) {
				return new WP_Error(
					'missing_field',
					ucfirst( $field ) . ' is required',
					[ 'status' => 422 ]
				);
			}
		}

		if ( ! is_email( $data['email'] ) ) {
			return new WP_Error( 'invalid_email', 'Invalid email', [ 'status' => 422 ] );
		}

		if ( email_exists( $data['email'] ) ) {
			return new WP_Error( 'email_exists', 'Email already registered', [ 'status' => 409 ] );
		}

		// Create user
		$user_id = wp_insert_user( [
			'user_login'   => $data['email'],
			'user_email'   => $data['email'],
			'user_pass'    => $data['password'],
			'display_name' => $data['first_name'] . ' ' . $data['last_name'],
			'role'         => 'subscriber',
		] );

		if ( is_wp_error( $user_id ) ) {
			return $user_id;
		}

		// Save extra fields in usermeta
		$meta_fields = [
			'first_name',
			'last_name',
			'phone',
			'organization',
			'country',
			'role_type',
		];

		foreach ( $meta_fields as $field ) {
			if ( isset( $data[ $field ] ) ) {
				update_user_meta( $user_id, $field, sanitize_text_field( $data[ $field ] ) );
			}
		}

		// Return clean response
		return [
			'id'           => $user_id,
			'email'        => $data['email'],
			'name'         => $data['first_name'] . ' ' . $data['last_name'],
			'country'      => $data['country'] ?? null,
			'organization' => $data['organization'] ?? null,
			'role'         => $data['role_type'] ?? null,
		];
	}


	public static function login( array $data ): WP_Error|array {

		if ( empty( $data['email'] ) || empty( $data['password'] ) ) {
			return new WP_Error( 'missing_fields', 'Email and password are required', [ 'status' => 422 ] );
		}

		$user = wp_authenticate( $data['email'], $data['password'] );

		if ( is_wp_error( $user ) ) {
			return new WP_Error( 'invalid_credentials', 'Invalid email or password', [ 'status' => 401 ] );
		}

		$payload = [
			'iss'     => get_site_url(),
			'iat'     => time(),
			'exp'     => time() + MY_LMS_JWT_TTL,
			'user_id' => $user->ID,
		];

		$token = JWT::encode( $payload, MY_LMS_JWT_SECRET, 'HS256' );

		return [
			'token' => $token,
			'user'  => [
				'id'    => $user->ID,
				'email' => $user->user_email,
				'name'  => $user->display_name,
				'roles' => $user->roles,
			]
		];
	}

	public static function logout(): true {
		wp_logout();

		return true;
	}

	public static function current_user(): WP_Error|array {
		$user = wp_get_current_user();

		if ( ! $user || ! $user->ID ) {
			return new WP_Error( 'unauthorized', 'Not authenticated', [ 'status' => 401 ] );
		}


		return [
			'id'      => $user->ID,
			'email'   => $user->user_email,
			'name'    => $user->display_name,
			'roles'   => $user->roles,
			'profile' => [
				'first_name' => get_user_meta( $user->ID, 'first_name', true ),
				'last_name'  => get_user_meta( $user->ID, 'last_name', true ),
				'phone'      => get_user_meta( $user->ID, 'phone', true ),
				'role_type'  => get_user_meta( $user->ID, 'role_type', true ),
			],
		];
	}
}
