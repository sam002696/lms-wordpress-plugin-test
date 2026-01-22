<?php

namespace MyLMS\API;

use MyLMS\Services\CourseService;
use MyLMS\Helpers\Response;
use WP_REST_Request;

class CoursesController {

	public function register(): void {

		register_rest_route( 'my-lms/v1', '/courses', [
			[
				'methods'  => 'GET',
				'callback' => [ $this, 'index' ],
			],
			[
				'methods'  => 'POST',
				'callback' => [ $this, 'store' ],
			],
		] );

		register_rest_route( 'my-lms/v1', '/courses/(?P<id>\d+)', [
			[
				'methods'  => 'PUT',
				'callback' => [ $this, 'update' ],
			],
			[
				'methods'  => 'DELETE',
				'callback' => [ $this, 'destroy' ],
			],
		] );
	}

	public function index(): \WP_REST_Response {
		return Response::success(
			CourseService::getAll()
		);
	}

	public function store( WP_REST_Request $request ): \WP_REST_Response {
		$result = CourseService::create( $request->get_json_params() );

		if ( is_wp_error( $result ) ) {
			return Response::error( $result->get_error_message(), $result->get_error_data()['status'] );
		}

		return Response::success( $result, 201 );
	}

	public function update( WP_REST_Request $request ): \WP_REST_Response {
		$result = CourseService::update(
			(int) $request['id'],
			$request->get_json_params()
		);

		if ( is_wp_error( $result ) ) {
			return Response::error( $result->get_error_message(), $result->get_error_data()['status'] );
		}

		return Response::success( $result );
	}

	public function destroy( WP_REST_Request $request ): \WP_REST_Response {
		$result = CourseService::delete( (int) $request['id'] );

		if ( is_wp_error( $result ) ) {
			return Response::error( $result->get_error_message(), $result->get_error_data()['status'] );
		}

		return Response::success( null, 204 );
	}
}
