<?php

namespace MyLMS\API;

use MyLMS\API\CoursesController;

class RestController {

	public static function register(): void {

		$courses = new CoursesController();
		$lessons     = new LessonsController();
		$enrollments = new EnrollmentsController();

		// Courses routes
		register_rest_route( 'my-lms/v1', '/courses', [
			[
				'methods'  => 'GET',
				'callback' => [ $courses, 'index' ],
			],
			[
				'methods'  => 'POST',
				'callback' => [ $courses, 'store' ],
			],
		] );

		register_rest_route( 'my-lms/v1', '/courses/(?P<id>\d+)', [
			[
				'methods'  => 'PUT',
				'callback' => [ $courses, 'update' ],
			],
			[
				'methods'  => 'DELETE',
				'callback' => [ $courses, 'destroy' ],
			],
		] );

		// Lessons routes
		register_rest_route( 'my-lms/v1', '/courses/(?P<id>\d+)/lessons', [
			[
				'methods'  => 'GET',
				'callback' => [ $lessons, 'index' ],
			],
			[
				'methods'  => 'POST',
				'callback' => [ $lessons, 'store' ],
			],
		] );


		// Enrollments
		register_rest_route( 'my-lms/v1', '/courses/(?P<id>\d+)/enroll', [
			[
				'methods'  => 'POST',
				'callback' => [ $enrollments, 'enroll' ],
			],
		] );

		register_rest_route( 'my-lms/v1', '/me/enrollments', [
			[
				'methods'  => 'GET',
				'callback' => [ $enrollments, 'myCourses' ],
			],
		] );

	}
}
