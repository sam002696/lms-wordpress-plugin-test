<?php

use MyLMS\API\AuthController;

$auth = new AuthController();

register_rest_route('my-lms/v1', '/auth/register', [
	'methods'  => 'POST',
	'callback' => [$auth, 'register'],
]);

register_rest_route('my-lms/v1', '/auth/login', [
	'methods'  => 'POST',
	'callback' => [$auth, 'login'],
]);

register_rest_route('my-lms/v1', '/auth/logout', [
	'methods'  => 'POST',
	'callback' => [$auth, 'logout'],
]);

register_rest_route('my-lms/v1', '/auth/me', [
	'methods'  => 'GET',
	'callback' => [$auth, 'me'],
]);
