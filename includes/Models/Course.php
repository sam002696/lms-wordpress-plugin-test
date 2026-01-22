<?php

namespace MyLMS\Models;

use MyLMS\Database\Tables;

class Course {

	public static function all(): array {
		global $wpdb;

		return $wpdb->get_results(
			"SELECT * FROM " . Tables::courses(),
			ARRAY_A
		);
	}

	public static function find( int $id ): ?array {
		global $wpdb;

		$row = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM " . Tables::courses() . " WHERE id = %d",
				$id
			),
			ARRAY_A
		);

		return $row ?: null;
	}

	public static function create( array $data ): int {
		global $wpdb;

		$wpdb->insert(
			Tables::courses(),
			[
				'title'       => $data['title'],
				'description' => $data['description'] ?? '',
				'price'       => $data['price'] ?? 0,
				'status'      => $data['status'] ?? 'draft',
			]
		);

		return (int) $wpdb->insert_id;
	}

	public static function update( int $id, array $data ): bool {
		global $wpdb;

		return (bool) $wpdb->update(
			Tables::courses(),
			$data,
			[ 'id' => $id ]
		);
	}

	public static function delete( int $id ): bool {
		global $wpdb;

		return (bool) $wpdb->delete(
			Tables::courses(),
			[ 'id' => $id ]
		);
	}
}

