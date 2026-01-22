<?php

namespace MyLMS\Database;

class Tables {

	public static function courses(): string {
		global $wpdb;

		return $wpdb->prefix . 'lms_courses';
	}
}