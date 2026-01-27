<?php


use MyLMS\Core\Plugin;

require_once __DIR__ . '/API/middleware.php';


require_once __DIR__ . '/Core/Plugin.php';
require_once __DIR__ . '/Core/Shortcodes.php';
require_once __DIR__ . '/API/RestController.php';
require_once __DIR__ . '/Database/Migrations.php';


require_once __DIR__ . '/Database/Tables.php';

require_once __DIR__ . '/Models/Course.php';
require_once __DIR__ . '/Models/Lesson.php';
require_once __DIR__ . '/Models/Enrollment.php';

// Services
require_once __DIR__ . '/Services/CourseService.php';
require_once __DIR__ . '/Services/LessonService.php';
require_once __DIR__ . '/Services/EnrollmentService.php';
require_once __DIR__ . '/Services/AuthService.php';

require_once __DIR__ . '/Helpers/Response.php';

// Controllers
require_once __DIR__ . '/API/CoursesController.php';
require_once __DIR__ . '/API/LessonsController.php';
require_once __DIR__ . '/API/EnrollmentsController.php';
require_once __DIR__ . '/API/AuthController.php';
require_once __DIR__ . '/API/RestController.php';

require_once __DIR__ . '/Core/Plugin.php';


Plugin::init();
