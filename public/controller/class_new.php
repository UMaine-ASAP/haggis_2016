<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	require_once __DIR__ . "/../../models/course.php";
	require_once __DIR__ . "/../../models/class.php";
	ensureLoggedIn();

	if($_SESSION['user']->userType == 'Student')
	{
		header("location:login.php");
	}

	$course = new Course(1);

	//This is the only course there is at this point in time, it is necessary to change it later, but that is on instructor_home.php's side, not mine, I will change it accordingly when we update by uncommenting the following line and commenting or removing the previous line.

	// $course = $_POST['courseID'];

	$courseName = $course->title;

	function createClass()
	{
		$className = $_POST['classTitle'];
		$classTime = $_POST['classTime'];
		$classDesc = $_POST['classDesc'];
		$classLoc = $_POST['classLoc'];

		global $course;
		$courseIdentifier = $course->courseID;

		$class = new Period(0);

		$class->title = $className;
		$class->courseID = $courseIdentifier;
		$class->time = $classTime;
		$class->description = $classDesc;
		$class->location = $classLoc;
		$class->Save();
		$class->addUser($_SESSION['user']->userID, $_SESSION['user']->userType);
	}

	if(isset($_POST['createClassSubmit']))
	{
		createClass();
		header("location:instructor_home.php");
	}

	//get the html page ready to be displayed
	// $page = file_get_contents(dirname(__FILE__) . '/../views/class_new.html');

	//replace the values in the html with needed sections
	echo $twig->render('class_new.html', [
		"username"        => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
		"courseName"         => $courseName,
		"courseID"			=> $course->courseCode
	]);
?>