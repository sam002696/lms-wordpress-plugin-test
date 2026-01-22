<?php

namespace MyLMS\Core;

class Shortcodes {

	public static function register(): void {
		add_shortcode( 'my_lms_app', [ self::class, 'render' ] );
	}

	public static function render(): string {
		return '<div id="my-lms-root"></div>';
	}
}
