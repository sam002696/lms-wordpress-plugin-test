<?php

namespace MyLMS\API;

use WP_REST_Request;
use WP_REST_Response;
use MyLMS\Services\AuthService;

class AuthController {

	public function register(WP_REST_Request $request): WP_REST_Response {
		$result = AuthService::register($request->get_json_params());

		if (is_wp_error($result)) {
			return new WP_REST_Response([
				'success' => false,
				'message' => $result->get_error_message(),
			], $result->get_error_data()['status'] ?? 400);
		}

		return new WP_REST_Response([
			'success' => true,
			'data' => $result
		], 201);
	}

	public function login(WP_REST_Request $request): WP_REST_Response {
		$result = AuthService::login($request->get_json_params());

		if (is_wp_error($result)) {
			return new WP_REST_Response([
				'success' => false,
				'message' => $result->get_error_message(),
			], $result->get_error_data()['status'] ?? 401);
		}

		return new WP_REST_Response([
			'success' => true,
			'data' => $result
		]);
	}

	public function logout(): WP_REST_Response {
		AuthService::logout();

		return new WP_REST_Response([
			'success' => true
		]);
	}

	public function me(): WP_REST_Response {
		$result = AuthService::current_user();

		if (is_wp_error($result)) {
			return new WP_REST_Response([
				'success' => false,
				'message' => $result->get_error_message(),
			], 401);
		}

		return new WP_REST_Response([
			'success' => true,
			'data' => $result
		]);
	}
}
