<?php

/**
 * Plugin Name: My LMS
 * Description: LMS plugin like Tutor LMS
 * Version: 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}


define( 'MY_LMS_DB_VERSION', '1.2.0' );
define( 'MY_LMS_PATH', plugin_dir_path( __FILE__ ) );
define( 'MY_LMS_URL', plugin_dir_url( __FILE__ ) );

define( 'MY_LMS_JWT_SECRET', AUTH_KEY );
define( 'MY_LMS_JWT_TTL', 60 * 60 * 24 ); // 24h


require_once MY_LMS_PATH . 'includes/bootstrap.php';