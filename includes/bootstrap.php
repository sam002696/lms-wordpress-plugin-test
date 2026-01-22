<?php


use MyLMS\Core\Plugin;

require_once __DIR__ . '/Core/Plugin.php';
require_once __DIR__ . '/Core/Shortcodes.php';
require_once __DIR__ . '/API/RestController.php';
require_once __DIR__ . '/Database/Migrations.php';


require_once __DIR__ . '/Database/Tables.php';

require_once __DIR__ . '/Models/Course.php';

require_once __DIR__ . '/Services/CourseService.php';

require_once __DIR__ . '/Helpers/Response.php';

require_once __DIR__ . '/API/CoursesController.php';
require_once __DIR__ . '/API/RestController.php';

require_once __DIR__ . '/Core/Plugin.php';


Plugin::init();
