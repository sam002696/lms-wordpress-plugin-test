<?php

namespace MyLMS\Models;

use MyLMS\Database\Tables;

class Lesson {

	public static function byCourse(int $course_id): array {
		global $wpdb;

		return $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM " . Tables::lessons() . " WHERE course_id = %d ORDER BY position ASC",
				$course_id
			),
			ARRAY_A
		);
	}

	public static function create(array $data): int {
		global $wpdb;

		$wpdb->insert(
			Tables::lessons(),
			[
				'course_id' => $data['course_id'],
				'title'     => $data['title'],
				'content'   => $data['content'] ?? null,
				'position'  => $data['position'] ?? 0,
				'status'    => $data['status'] ?? 'draft',
			]
		);

		return (int) $wpdb->insert_id;
	}

	public static function deleteByCourse(int $course_id): void {
		global $wpdb;

		$wpdb->delete(
			Tables::lessons(),
			['course_id' => $course_id]
		);
	}
}
