<?php
	require_once __DIR__ . "/../system/bootstrap.php";

		//get user file
	require_once dirname(__FILE__) . "/../models/user.php";
	require_once dirname(__FILE__) . "/../models/assignment.php";

	ensureLoggedIn();

	//get assignment
	$a = new Assignment($_POST['assignmentID']);
	//get the html page ready to be displayed
	$page = file_get_contents(dirname(__FILE__) . '/../views/assignment_view.html');
	$page = str_replace('$assignmentName', $a->title, $page);
	$page = str_replace('$assignmentDescription', $a->description, $page);
	echo $page;

	//echo "assignment to view: " . $_POST['assignmentID'];
?>