<?php

namespace MyLMS\Database;

class Tables {

	public static function courses(): string {
		global $wpdb;

		return $wpdb->prefix . 'lms_courses';
	}

	public static function lessons(): string {
		global $wpdb;
		return $wpdb->prefix . 'lms_lessons';
	}

	public static function enrollments(): string {
		global $wpdb;
		return $wpdb->prefix . 'lms_enrollments';
	}
}