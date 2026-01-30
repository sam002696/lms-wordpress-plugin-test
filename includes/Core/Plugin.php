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

		//  ADMIN PAGE
		add_action( 'admin_menu', [ self::class, 'add_admin_page' ] );

		//  ENQUEUE
		add_action( 'admin_enqueue_scripts', [ self::class, 'enqueue_scripts' ] );

		//  AJAX
		add_action( 'wp_ajax_get_coupon_details', [ self::class, 'get_coupon_details_callback' ] );
	}

	/* -----------------------------------------
	   ADMIN PAGE
	------------------------------------------ */
	public static function add_admin_page(): void {
		add_menu_page(
			'AJAX Demo',
			'AJAX Demo',
			'manage_options',
			'ajax-demo',
			[ self::class, 'ajax_demo_page' ]
		);
	}

	public static function ajax_demo_page(): void {
		require MY_LMS_PATH . 'views/admin/ajax-demo-page.php';
	}

	/* -----------------------------------------
	   ENQUEUE
	------------------------------------------ */
	public static function enqueue_scripts( $hook ): void {

		if ( $hook !== 'toplevel_page_ajax-demo' ) {
			return;
		}

		wp_enqueue_script(
			'ajax-demo-js',
			plugin_dir_url( MY_LMS_PATH . 'my-lms.php' ) . 'assets/js/ajax-demo.js',
			[ 'jquery' ],
			'1.0',
			true
		);

		wp_localize_script( 'ajax-demo-js', 'ajax_obj', [
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'coupon_nonce' )
		] );
	}

	/* -----------------------------------------
	   AJAX HANDLER
	------------------------------------------ */
	public static function get_coupon_details_callback(): void {

		check_ajax_referer( 'coupon_nonce', 'nonce' );

		if ( ! current_user_can( 'manage_options' ) ) {
			wp_send_json_error( 'Not allowed' );
		}

		$coupon_id = intval( $_POST['coupon_id'] );

		$coupons = [
			1 => '10%',
			2 => '20%',
			3 => '50%'
		];

		if ( isset( $coupons[ $coupon_id ] ) ) {
			wp_send_json_success( [
				'discount' => $coupons[ $coupon_id ]
			] );
		} else {
			wp_send_json_error( 'Coupon not found' );
		}
	}
}
