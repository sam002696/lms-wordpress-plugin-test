<?php

namespace MyLMS\Services;

use MyLMS\Models\Enrollment;
use WP_Error;

class EnrollmentService {

	public static function enroll( int $course_id ): bool|WP_Error {
		$user_id = get_current_user_id();

		if ( ! $user_id ) {
			return new WP_Error( 'unauthorized', 'Login required', [ 'status' => 401 ] );
		}

		if ( Enrollment::isEnrolled( $user_id, $course_id ) ) {
			return new WP_Error( 'exists', 'Already enrolled', [ 'status' => 409 ] );
		}

		return Enrollment::enroll( $user_id, $course_id );
	}

	public static function myCourses(): array|WP_Error {
		$user = wp_get_current_user();

		$user_id = $user->ID;
		if ( ! $user_id ) {
			return new WP_Error( 'unauthorized', 'Login required', [ 'status' => 401 ] );
		}

		return Enrollment::byUser( $user_id );
	}
}
