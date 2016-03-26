<?php
	//get user file
	require_once dirname(__FILE__) . "/../models/user.php";
	require_once dirname(__FILE__) . "/../models/assignment.php";
	require_once dirname(__FILE__) . "/../models/class.php";
	session_start();


	//get the html page ready to be displayed
	$page = file_get_contents(dirname(__FILE__) . '/../views/student_home.html');


	//get user's classes
	$classes = $_SESSION['user']->GetClasses();

	//get assignments for each class
	$assignments = Array();
	foreach ($classes as $class) {
		$assignments[] = $class->GetAssignments();
	}

	//echo '<br>' . $assignments[0][0][0]->title; this is the assignment title
	//echo '<br>' . $assignments[0][0][1];		  this is the assignment due date

	//setup table for assignments
	$assignmentInfo = "<table border='1' style='width:100'><tr><th>Assignments</th><th>Due Date</th></tr>";
	foreach($assignments[0] as $assignment){
		$assignmentInfo .= "<tr><th>{$assignment[0]->title}</th><th>{$assignment[1]}</th></tr>";
	}

	//replace the values in the html with needed sections
	$page = str_replace('$firstName', $_SESSION['user']->firstName, $page);
	$page = str_replace('$assignmentInfo', $assignmentInfo, $page);
	echo $page;
?>