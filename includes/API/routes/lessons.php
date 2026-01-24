<?php

use MyLMS\API\LessonsController;

$lessons = new LessonsController();

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
