<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	$assignmentID;
	$classID;//Classs Specific
	$courseID;
	$masterEvalID;

	function editEvaluation()
	{
		global $masterEvalID;
	}

	function assignEvaluation()
	{
		global $classID, $courseID, $masterEvalID, $assignmentID;
	}

	function viewResults()
	{
		global $classID, $courseID, $assignmentID;
	}

	function assignAssignment()
	{
		global $assignmentID, $courseID, $classID;
	}

	if(isset($_POST['']))

	echo $twig->render("instructor_assignment.html",
		[

		]);

?>