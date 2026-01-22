<?php

namespace MyLMS\API;


class RestController
{

    public static function register()
    {
        register_rest_route('my-lms/v1', '/courses', [
            'methods' => 'GET',
            'callback' => [CoursesController::class, 'index'],
        ]);
    }
}
