<?php


use MyLMS\API\CoursesController;

$courses = new CoursesController();

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
