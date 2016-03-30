<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	require_once __DIR__ . "/../../models/course.php";
	require_once __DIR__ . "/../../models/assignment.php";
	ensureLoggedIn();

	if($_SESSION['user']->userType == 'Student')
	{
		header("location:login.php");
	}

	$course = new Course(1);
	$courseName = $course->title;
	$courseIdentifier = $course->courseID;

	function createAssignment()
	{
		$AssignmentName = $_POST['postAssignmentName'];
		$AssignmentDueDate = $_POST['postDueDate'];
		$AssignmentCriteria = $_POST['postCriteriaDescription'];
		$AssignmentDescription = $_POST['postAssignDescription'];

		$assignmentToCreate = new Assignment(0);
		$assignmentToCreate->title = $AssignmentName;
		// $assignmentToCreate->description = 
		$assignmentToCreate->description = $AssignmentDescription;
		$assignmentToCreate->dueDate = $AssignmentDueDate;
		$assignmentToCreate->Save();
	}

	if(isset($_POST['createAssignmentSubmit']))
	{
		createAssignment();
		header("location:instructor_home.php");
	}

	//get the html page ready to be displayed
	echo $twig->render('create_assignment.html', [
		"username"        => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
		"courseName"         => $courseName,
		"courseID"			=> $course
	]);
?>