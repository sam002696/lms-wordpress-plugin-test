<?php

namespace MyLMS\API;

use MyLMS\API\CoursesController;

class RestController {

	public static function register(): void {

		require_once __DIR__ . '/routes/courses.php';
		require_once __DIR__ . '/routes/lessons.php';
		require_once __DIR__ . '/routes/enrollments.php';

	}
}
