<?php

namespace MyLMS\Database;

class Migrations {

	public static function run(): void {

		$current_version = get_option('my_lms_db_version');

		if ($current_version === MY_LMS_DB_VERSION) {
			return;
		}

		self::create_or_update_tables();

		update_option('my_lms_db_version', MY_LMS_DB_VERSION);
	}

	private static function create_or_update_tables(): void {
		global $wpdb;

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$table   = Tables::courses();
		$charset = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE {$table} (
			id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
			title VARCHAR(255) NOT NULL,
			description LONGTEXT NULL,
			price DECIMAL(10,2) DEFAULT 0,
			status ENUM('draft','published') DEFAULT 'draft',
			level VARCHAR(50) DEFAULT NULL,
			duration INT DEFAULT 0,
			difficulty VARCHAR(20) DEFAULT 'beginner',
			created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
			updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
		) {$charset};";

		dbDelta($sql);
	}
}

