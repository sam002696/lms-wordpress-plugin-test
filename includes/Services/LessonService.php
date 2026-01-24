<?php

namespace MyLMS\Services;

use MyLMS\Models\Lesson;
use MyLMS\Models\Course;
use WP_Error;

class LessonService {

	public static function listByCourse(int $course_id): array|WP_Error {
		if (!Course::find($course_id)) {
			return new WP_Error('not_found', 'Course not found', ['status' => 404]);
		}

		return Lesson::byCourse($course_id);
	}

	public static function create(array $data): array|WP_Error {
		if (empty($data['course_id']) || empty($data['title'])) {
			return new WP_Error('invalid', 'Course and title required', ['status' => 400]);
		}

		$id = Lesson::create($data);

		return Lesson::byCourse($data['course_id']);
	}
}
