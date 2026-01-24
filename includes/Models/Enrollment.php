<?php

namespace MyLMS\Models;

use MyLMS\Database\Tables;

class Enrollment {

	public static function enroll(int $user_id, int $course_id): bool {
		global $wpdb;

		return (bool) $wpdb->insert(
			Tables::enrollments(),
			[
				'user_id'   => $user_id,
				'course_id'=> $course_id,
				'status'   => 'active',
			]
		);
	}

	public static function isEnrolled(int $user_id, int $course_id): bool {
		global $wpdb;

		return (bool) $wpdb->get_var(
			$wpdb->prepare(
				"SELECT id FROM " . Tables::enrollments() . " WHERE user_id = %d AND course_id = %d",
				$user_id,
				$course_id
			)
		);
	}

	public static function byUser(int $user_id): array {
		global $wpdb;

		return $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM " . Tables::enrollments() . " WHERE user_id = %d",
				$user_id
			),
			ARRAY_A
		);
	}
}
