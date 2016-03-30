<?php
	//get user file
	require_once dirname(__FILE__) . "/../models/user.php";
	
	session_start();
	if($_SESSION['sessionCheck'] != 'true' OR $_SESSION['user']->userType == 'Student'){
			session_destroy();
			header("location:login.php");
	}

	$page = file_get_contents(dirname(__FILE__) . '/../views/add_students.html');

	$class = 0;



?>