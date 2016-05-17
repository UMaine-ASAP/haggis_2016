<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();
	
	//if user is a student, redirect to login
	if($_SESSION['user']->userType == 'Student')
	{
		header("location:login.php");
	}
	echo $twig->render('evaluation_create.html', [
		"username"        => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName
	]);
?>