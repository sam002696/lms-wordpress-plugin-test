<?php

/**
 * Plugin Name: My LMS
 * Description: LMS plugin like Tutor LMS
 * Version: 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MY_LMS_DB_VERSION', '1.1.0' );
define( 'MY_LMS_PATH', plugin_dir_path( __FILE__ ) );
define( 'MY_LMS_URL', plugin_dir_url( __FILE__ ) );


require_once MY_LMS_PATH . 'includes/bootstrap.php';
