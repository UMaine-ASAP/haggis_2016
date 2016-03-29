<?php

	require_once dirname(__FILE__) . "/../models/user.php";
	require_once dirname(__FILE__) . "/../models/assignment.php";
	require_once dirname(__FILE__) . "/../models/class.php";

	session_start();
	if($_SESSION['sessionCheck'] != 'true'){
			session_destroy();
			header("location:login.php");
		}
	
    $page = file_get_contents(dirname(__FILE__) . '/../views/instructor_home.html');

    $classes = $_SESSION['user']->GetClasses();
    // var_dump($classes);
    $page = str_replace('$className', $classes[0]->title, $page);
    echo $page;
?>