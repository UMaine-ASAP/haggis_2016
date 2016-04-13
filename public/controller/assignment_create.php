<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	if($_SESSION['user']->userType == 'Student')
	{
		header("location:login.php");
	}
	if(empty($_POST['classID'])){
		header("location:instructor_home.php");
	}

	$_SESSION['classID'] = $_POST['classID'];
	
	echo $twig->render('assignment_create.html', [
		"username"        => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName
	]);

?>