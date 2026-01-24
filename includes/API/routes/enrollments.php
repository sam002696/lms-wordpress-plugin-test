<?php

use MyLMS\API\EnrollmentsController;

$enrollments = new EnrollmentsController();

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
