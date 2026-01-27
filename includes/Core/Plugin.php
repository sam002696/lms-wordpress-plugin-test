<?php


namespace MyLMS\Core;


use MyLMS\API\RestController;
use MyLMS\Database\Migrations;

class Plugin {

	public static function init(): void {
		register_activation_hook(
			MY_LMS_PATH . 'my-lms.php',
			[ Migrations::class, 'run' ]
		);

		add_action( 'rest_api_init', [ RestController::class, 'register' ] );

		add_action( 'init', [ Shortcodes::class, 'register' ] );


		add_filter( 'wp_new_user_notification_email', '__return_false' );
		add_filter( 'wp_new_user_notification_email_admin', '__return_false' );


	}
}
