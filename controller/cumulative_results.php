<?php
	//get required models to retreive information
	require_once dirname(__FILE__) . "/../models/user.php";
	require_once dirname(__FILE__) . "/../models/assignment.php";
	require_once dirname(__FILE__) . "/../models/class.php";

	session_start();
	if($_SESSION['sessionCheck'] != 'true'){
			session_destroy();
			header("location:login.php");
		}

	//get the html page ready to be displayed
	$page = file_get_contents(dirname(__FILE__) . '/../views/cumulative_results.html');


	// This controller should accept the class.




	// $class = $_POST["classID"];



	// Access a class
	$class = new Period(1); // This gets the class with ID equal to 1. NOTE that the name of the class is "Period", not "Class"




	// $page = str_replace('$evaluationsReceived', $evaluationsReceived, $page);
	echo $page;