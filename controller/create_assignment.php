<?php
	//get user file
	require_once dirname(__FILE__) . "/../models/user.php";
	require_once dirname(__FILE__) . "/../models/class.php";
	require_once dirname(__FILE__) . "/../models/course.php";

	session_start();
	if($_SESSION['sessionCheck'] != 'true')
	{
		session_destroy();
		header("location:login.php");
	}

	if($_SESSION['user']->userType == 'Student')
	{
		header("location:login.php");
	}

	$course = new Course(1);
	$courseName = $course->title;
	$courseIdentifier = $course->courseID;

	function createAssignment()
	{

	}
	$AssignmentName = $_POST['postDueDate'];
	$AssignmentDueDate = $_POST['AssignmentDueDate'];
	

	$course = new Course(1);
	$courseIdentifier = $course->courseID;

	$class = new Period(0);

	$class->title = $AssignmentName;
	$class->time = $classTime;
	$class->description = $AssignmentDesc;

	$class->Save();
	$class->addUser($_SESSION['user']->userID, $_SESSION['user']->userType);

	if(isset($_POST['createAssignmentSubmit']))
	{
		createAssignment();
		header("location:instructor_home.php");
	}

	//get the html page ready to be displayed
	$page = file_get_contents(dirname(__FILE__) . '/../views/create_assignment.html');

	//replace the values in the html with needed sections
	$page = str_replace('$courseName', $courseName, $page);
	echo $page;
?>