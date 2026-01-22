<?php

namespace MyLMS\Helpers;

use WP_REST_Response;

class Response {

	public static function success( $data = null, int $status = 200 ): WP_REST_Response {
		return new WP_REST_Response( [
			'success' => true,
			'data'    => $data,
		], $status );
	}

	public static function error( string $message, int $status = 400 ): WP_REST_Response {
		return new WP_REST_Response( [
			'success' => false,
			'message' => $message,
		], $status );
	}
}
