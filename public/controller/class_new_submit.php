<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	if($_SESSION['user']->userType == 'Student')
	{
		header("location:login.php");
	}

	$className = $_POST['classTitle'];
	$classTime = $_POST['classTime'];
	$classDesc = $_POST['classDesc'];
	$classLoc = $_POST['classLoc'];
	$courseIdentifier = $_POST['courseIdentifier'];

	$class = new Period(0);

	$class->title = $className;
	$class->courseID = $courseIdentifier;
	$class->time = $classTime;
	$class->description = $classDesc;
	$class->location = $classLoc;
	$class->Save();

	// var_dump($class);
	$class->addUser($_SESSION['user']->userID, $_SESSION['user']->userType);

	header("location:instructor_home.php");
?>