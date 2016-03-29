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
	$page = file_get_contents(dirname(__FILE__) . '/../views/instructor_class.html');


	//get user's classes
	$classes = $_SESSION['user']->GetClasses();

	//get assignments for each class
	$assignments = Array();
	foreach ($classes as $class) {
		$assignments[] = $class->GetAssignments();
	}

	//setup table for assignments
	
	if($assignments != array()){
		foreach($assignments[0] as $assignment){
				
			$assignmentInfo = "<tr><th>"; 
			$assignmentInfo .= '<form method="post" action="">';
			$assignmentInfo .= '<button type="submit" value="' . $assignment[0]->assignmentID . '" name="assignmentID" ';
			$assignmentInfo .= 'formaction="assignment_controller.php"> ';
			$assignmentInfo .= "{$assignment[0]->title}</button></th>";
			$assignmentInfo .=  "<th>{$assignment[1]}</th></tr>";
		}
	}

	//get evaluations for instructor
	$evaluations = $_SESSION['user']->GetEvaluations();

	//setup table for evaluations assigned

	if($evaluations != array()){
		foreach($evaluations as $eval){
			if($eval->rating == 0){
				$u = new User($eval->evaluatorID);
				$evaluations = "<tr><th>"; 
				$evaluations .= '<form method="post" action="">';
				$evaluations .= '<button type="submit" value="' . $eval->evaluationID . '" name="evaluationID"';
				$evaluations .= ' formaction=""> ';
				$evaluations .= "Evaluation for {$u->firstName}</button></th></tr>";
			}
		}
	}


	$students = $_SESSION['user']->getStudents();

	//setup table for Students in class

	if($evaluations != array()){
		foreach($evaluations as $eval){
			if($eval->rating == 0){
				$u = new User($eval->evaluatorID);
				$evaluations = "<tr><th>"; 
				$evaluations .= '<form method="post" action="">';
				$evaluations .= '<button type="submit" value="' . $eval->evaluationID . '" name="userID"';
				$evaluations .= ' formaction=""> ';
				$evaluations .= "Evaluation for {$u->firstName}</button></th></tr>";
			}
		}
	}
	/*



	*/

	//replace the values in the html with needed sections
	$page = str_replace('$firstName', $_SESSION['user']->firstName, $page);
	$page = str_replace('$assinments', $assignmentInfo, $page);
	$page = str_replace('$evaluations', $evaluationsToDo, $page);
	echo $page;
?>