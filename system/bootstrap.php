<!--Importing chart and setting global chart variables-->
<script src="chart.js"></script>

<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/helpers.php';

// OLD Load models
/*require_once __DIR__ . "/../models/user.php";
require_once __DIR__ . "/../models/assignment.php";
require_once __DIR__ . "/../models/class.php";
require_once __DIR__ . "/../models/criteria.php";
require_once __DIR__ . "/../models/evaluation.php";
require_once __DIR__ . "/../models/student_group.php";
require_once __DIR__ . "/../models/selection.php";*/

// NEW Load models
require_once __DIR__ . "/../models2/user.php";
require_once __DIR__ . "/../models2/course.php";
require_once __DIR__ . "/../models2/class.php";

// Load .env file
$dotenv = new Dotenv\Dotenv(__DIR__ . "/..");
$dotenv->load();

// Load the application
$loader = new Twig_Loader_Filesystem(__DIR__ . '/../views/');
$twig = new Twig_Environment($loader);
if (getenv('WEB_ROOT') != null) {
	$twig->addGlobal('WEB_ROOT', getenv('WEB_ROOT'));
}

function myErrorHandler($errno, $errstr, $errfile, $errline) {

    echo "<b>error:</b> [$errno] $errstr<br>";
    echo "Error on line $errline in $errfile<br>";
    //Because it will only catch one error before the error handling doesn't work
    die();
}

set_error_handler("myErrorHandler");

// Start session
session_start();