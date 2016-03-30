<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/helpers.php';

// Load models
require_once __DIR__ . "/../models/user.php";
require_once __DIR__ . "/../models/assignment.php";
require_once __DIR__ . "/../models/class.php";


// Load the application
$loader = new Twig_Loader_Filesystem(__DIR__ . '/../views/');
$twig = new Twig_Environment($loader);

// Load .env file
$dotenv = new Dotenv\Dotenv(__DIR__ . "/..");
$dotenv->load();

// Start session
session_start();