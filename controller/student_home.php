<?php
	//get user file
	require_once dirname(__FILE__) . "/../models/user.php";
	require_once dirname(__FILE__) . "/../models/assignment.php";
	require_once dirname(__FILE__) . "/../models/class.php";
	session_start();
	if($_SESSION['sessionCheck'] != 'true'){
			session_destroy();
			header("location:login.php");
		}

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
	
	if($assignments != array()){
		foreach($assignments[0] as $assignment){
				
			$assignmentInfo .= "<tr><th>"; 
			$assignmentInfo .= '<form method="post" action="assignment_controller.php">';
			$assignmentInfo .= '<button type="submit" value="' . $assignment[0]->assignmentID . '" name="assignmentID" ';
			$assignmentInfo .= 'formaction="assignment_controller.php"> ';
			$assignmentInfo .= "{$assignment[0]->title}</button></th>";
			$assignmentInfo .=  "<th>{$assignment[1]}</th></tr>";
		}
	}
	$assignmentInfo .= "</table>";

	//get evaluations for student
	$evaluations = $_SESSION['user']->GetEvaluations();

	//setup table for evaluations to do
	$evaluationsToDo = "<br><table border='1' style='width:100'><tr><th>Evaluations To Do</th></tr>";

	if($evaluations != array()){
		foreach($evaluations as $eval){
			if($eval->rating == 0){
				$u = new User($eval->evaluatorID);
				$evaluationsToDo .= "<tr><th>"; 
				$evaluationsToDo .= '<form method="post" action="evaluation_submit.php">';
				$evaluationsToDo .= '<button type="submit" value="' . $eval->evaluationID . '" name="evaluationID"';
				$evaluationsToDo .= ' formaction="evaluation_submit.php"> ';
				$evaluationsToDo .= "Evaluation for {$u->firstName}</button></th></tr>";
			}
		}
	}
	$evaluationsToDo .= "</table>";

	//get received evaluations
	$rec_evaluations = $_SESSION['user']->GetReceivedEvaluations();

	//setup table for assignments
	$evaluationsReceived = "<br><table border='1' style='width:100'><tr><th>Evaluations Received</th></tr>";

	if($rec_evaluations != array()){
		foreach($rec_evaluations as $eval){
			$e = new Evaluation($eval->evaluationID);
			$u = $e->GetUser();
			$evaluationsReceived .= "<tr><th>"; 
			$evaluationsReceived .= '<form method="post" action="evaluation_view.php">';
			$evaluationsReceived .= '<button type="submit" value="' . $eval->evaluationID . '" name="evaluationID" ';
			$evaluationsReceived .= 'formaction="evaluation_view.php"> ';
			$evaluationsReceived .= "Evaluation from {$u->firstName}</button></th></tr>";
		}
	}
	$evaluationsReceived .= "</table>";

	//replace the values in the html with needed sections
	$page = str_replace('$firstName', $_SESSION['user']->firstName, $page);
	$page = str_replace('$assignmentInfo', $assignmentInfo, $page);
	$page = str_replace('$evaluationsToDo', $evaluationsToDo, $page);
	$page = str_replace('$evaluationsReceived', $evaluationsReceived, $page);
	echo $page;
?>