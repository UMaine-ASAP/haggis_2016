<?php
	require_once __DIR__ . "/../../system/bootstrap.php";

	ensureLoggedIn();

	if($_SESSION['user']->userType == 'Student')
	{
		header("location:login.php");
	}

	$course = $_POST['courseID'];

	function createClass()
	{
		$className = $_POST['classTitle'];
		$classTime = $_POST['classTime'];
		$classDesc = $_POST['classDesc'];
		$classLoc = $_POST['classLoc'];

		$class = new Period(0);

		$class->title = $className;
		$class->courseID = $courseIdentifier;
		$class->time = $classTime;
		$class->description = $classDesc;
		$class->location = $classLoc;
		$class->Save();
		$class->addUser($_SESSION['user']->userID, $_SESSION['user']->userType);
	}

	//get the html page ready to be displayed
	//copies all of the class_new.html file and converts it into a string 
	$page = file_get_contents(dirname(__FILE__) . '/../../views/class_new.html');

	//replace the values in the html with needed sections
	echo $twig->render('class_new.html', [
		"username"        => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
		//"courseName"         => $courseName,
		//"courseID"			=> $course
	]);
?>