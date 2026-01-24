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

		$courses_table   = Tables::courses();
		$lessons_table = Tables::lessons();
		$enrollments_table = Tables::enrollments();
		$charset = $wpdb->get_charset_collate();

		// COURSES TABLE
		$sql = "CREATE TABLE {$courses_table} (
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

		// LESSONS TABLE
		$sql = "
			CREATE TABLE {$lessons_table} (
				id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				course_id BIGINT UNSIGNED NOT NULL,
				title VARCHAR(255) NOT NULL,
				content LONGTEXT NULL,
				position INT DEFAULT 0,
				status ENUM('draft','published') DEFAULT 'draft',
				created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
				updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				KEY course_id (course_id)
			) $charset;
		";

		dbDelta($sql);

		// ENROLLMENTS TABLE
		$sql = "CREATE TABLE {$enrollments_table} (
			id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
				user_id BIGINT UNSIGNED NOT NULL,
				course_id BIGINT UNSIGNED NOT NULL,
				status ENUM('active','completed','cancelled') DEFAULT 'active',
				enrolled_at DATETIME DEFAULT CURRENT_TIMESTAMP,
				completed_at DATETIME NULL,
				UNIQUE KEY user_course (user_id, course_id),
				KEY course_id (course_id),
				KEY user_id (user_id)
			) $charset;
			";

		dbDelta($sql);
	}
}

