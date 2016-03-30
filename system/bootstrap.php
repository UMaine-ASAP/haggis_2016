<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Load the application
$loader = new Twig_Loader_Filesystem(__DIR__ . '/../views/');
$twig = new Twig_Environment($loader);
