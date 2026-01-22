<?php

namespace MyLMS\Services;

use MyLMS\Models\Course;
use WP_Error;

class CourseService {

	public static function getAll(): array {
		return Course::all();
	}

	public static function create( array $data ): WP_Error|array|null {
		if ( empty( $data['title'] ) ) {
			return new WP_Error( 'invalid_title', 'Course title is required', [ 'status' => 400 ] );
		}

		$id = Course::create( $data );

		return Course::find( $id );
	}

	public static function update( int $id, array $data ): WP_Error|array|null {
		if ( ! Course::find( $id ) ) {
			return new WP_Error( 'not_found', 'Course not found', [ 'status' => 404 ] );
		}

		Course::update( $id, $data );

		return Course::find( $id );
	}

	public static function delete( int $id ): bool|WP_Error {
		if ( ! Course::find( $id ) ) {
			return new WP_Error( 'not_found', 'Course not found', [ 'status' => 404 ] );
		}

		Course::delete( $id );

		return true;
	}
}

