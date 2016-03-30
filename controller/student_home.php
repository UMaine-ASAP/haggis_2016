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
	// Clicking on a class should pass the class id.

	//get assignments for each class
	$assignments = Array();
	foreach ($classes as $class) {
		$assignments[] = $class->GetAssignments();
	}

	//echo '<br>' . $assignments[0][0][0]->title; this is the assignment title
	//echo '<br>' . $assignments[0][0][1];		  this is the assignment due date

	//setup table for assignments
	$assignmentInfo = "<table><thead><tr><th>Assignments</tr></thead>";
	
	if($assignments != array()){
		foreach($assignments[0] as $assignment){
				
			$assignmentInfo .= "<tr><td>"; 
			$assignmentInfo .= '<form method="post" action="assignment_controller.php">';
			$assignmentInfo .= '<button type="submit" value="' . $assignment[0]->assignmentID . '" name="assignmentID" ';
			$assignmentInfo .= 'formaction="assignment_controller.php"> ';
			$assignmentInfo .= "{$assignment[0]->title}</button> Due: ".$assignment[1]."</td>";
			// $assignmentInfo .=  "<td>{$assignment[1]}</td></tr>";
		}
	}
	$assignmentInfo .= "</table>";

	//get evaluations for student
	$evaluations = $_SESSION['user']->GetEvaluations();

	//setup table for evaluations to do
	$evaluationsToDo = "<table><thead><tr><th>Evaluations To Do</tr></thead>";

	if($evaluations != array()){
		foreach($evaluations as $eval){
			//This may not be a significant way of telling whether or not the evaluation is finished or not.
			// There should probably be a function to determine if any criteria within the evaluation do not have a filled rating. 
			if($eval->done == 0){
				$u = new User($eval->target_userID);
				$evaluationsToDo .= "<tr><td>"; 
				$evaluationsToDo .= '<form method="post" action="evaluation_submit.php">';
				$evaluationsToDo .= '<button type="submit" value="' . $eval->evaluationID . '" name="evaluationID"';
				$evaluationsToDo .= ' formaction="evaluation_submit.php"> ';
				$evaluationsToDo .= "Evaluation for {$u->firstName}</button></td></tr>";
			}
		}
	}
	$evaluationsToDo .= "</table>";

	//get received evaluations
	$rec_evaluations = $_SESSION['user']->GetReceivedEvaluations();

	//setup table for assignments
	$evaluationsReceived = "<table><thead><tr><th>Evaluations Received</tr></thead>";

	if($rec_evaluations != array()){
		foreach($rec_evaluations as $eval){
			$e = new Evaluation($eval->evaluationID);
			$u = $e->GetUser();
			$evaluationsReceived .= "<tr><td>"; 
			$evaluationsReceived .= '<form method="post" action="evaluation_view.php">';
			$evaluationsReceived .= '<button type="submit" value="' . $eval->evaluationID . '" name="evaluationID" ';
			$evaluationsReceived .= 'formaction="evaluation_view.php"> ';

			// if($e->evaluation_type == "group")
			$evaluationsReceived .= $e->GetAssignment()->title." ";
			$evaluationsReceived .= $e->evaluation_type." evaluation";

			//[assignment] [group/peer] evaluation
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