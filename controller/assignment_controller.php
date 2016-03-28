<?php
		//get user file
	require_once dirname(__FILE__) . "/../models/user.php";
	require_once dirname(__FILE__) . "/../models/assignment.php";

	session_start();


	//get the html page ready to be displayed
	//$page = file_get_contents(dirname(__FILE__) . '/../views/student_home.html');


	if($_SESSION['sessionCheck'] != 'true'){
			session_destroy();
			header("location:login.php");
		}
	echo "evaluation to view: " . $_POST['assignmentID'];
?>