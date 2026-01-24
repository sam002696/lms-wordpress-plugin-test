<?php

namespace MyLMS\API;

use MyLMS\Services\EnrollmentService;
use MyLMS\Helpers\Response;
use WP_REST_Request;

class EnrollmentsController {

	public function enroll(WP_REST_Request $request): \WP_REST_Response {
		$result = EnrollmentService::enroll((int) $request['id']);

		if (is_wp_error($result)) {
			return Response::error($result->get_error_message(), $result->get_error_data()['status']);
		}

		return Response::success(['enrolled' => true], 201);
	}

	public function myCourses(): \WP_REST_Response {
		$result = EnrollmentService::myCourses();

		if (is_wp_error($result)) {
			return Response::error($result->get_error_message(), $result->get_error_data()['status']);
		}

		return Response::success($result);
	}
}
