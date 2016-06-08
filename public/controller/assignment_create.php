<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	//if user is a student, redirect to login
	if($_SESSION['user']->userType == 'Student')
	{
		header("location:login.php");
	}

	//if class id not posted
	if(empty($_GET['classID'])){
		header("location:instructor_home.php");
	}

	//set session variable of class id
	$_SESSION['classID'] = $_GET['classID'];
	
	echo $twig->render('assignment_create.html', [
		"username"        => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName
	]);

?>