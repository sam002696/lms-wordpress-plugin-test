<?php

namespace MyLMS\API;

use MyLMS\Services\LessonService;
use MyLMS\Helpers\Response;
use WP_REST_Request;

class LessonsController {

	public function register(): void {
		register_rest_route('my-lms/v1', '/courses/(?P<id>\d+)/lessons', [
			[
				'methods'  => 'GET',
				'callback' => [$this, 'index'],
			],
			[
				'methods'  => 'POST',
				'callback' => [$this, 'store'],
			],
		]);
	}

	public function index(WP_REST_Request $request): \WP_REST_Response {
		$result = LessonService::listByCourse((int) $request['id']);

		if (is_wp_error($result)) {
			return Response::error($result->get_error_message(), $result->get_error_data()['status']);
		}

		return Response::success($result);
	}

	public function store(WP_REST_Request $request): \WP_REST_Response {
		$data = $request->get_json_params();
		$data['course_id'] = (int) $request['id'];

		$result = LessonService::create($data);

		if (is_wp_error($result)) {
			return Response::error($result->get_error_message(), $result->get_error_data()['status']);
		}

		return Response::success($result, 201);
	}
}
