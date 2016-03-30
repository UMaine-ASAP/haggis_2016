<?php
	//get user file
	require_once dirname(__FILE__) . "/../models/user.php";
	
	session_start();
	if($_SESSION['sessionCheck'] != 'true' OR $_SESSION['user']->userType == 'Student'){
			session_destroy();
			header("location:login.php");
	}

	

?>