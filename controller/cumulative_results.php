<?php
	//get required models to retreive information
	require_once dirname(__FILE__) . "/../models/user.php";
	require_once dirname(__FILE__) . "/../models/assignment.php";
	require_once dirname(__FILE__) . "/../models/class.php";

	session_start();
	if($_SESSION['sessionCheck'] != 'true'){
			session_destroy();
			header("location:login.php");
		}

	//get the html page ready to be displayed
	$page = file_get_contents(dirname(__FILE__) . '/../views/cumulative_results.html');

	//get user's classes
	$classes = $_SESSION['user']->GetClasses();

	//get assignments for each class
	$assignments = Array();
	foreach ($classes as $class) {
		$assignments[] = $class->GetAssignments();
	}


	//get user evaluations
	$evaluations = $_SESSION['user']->GetEvaluations();

	//var_dump($evaluations);



	

	// // if they have assignments
	// if($assignments != array()){
	// 	// for each assignment
	// 	foreach($assignments[0] as $assignment){
	// 		$assignment_results = "<tr><td>".$assignment->title."<td>"
	// 		foreach(criteria of $assignment){
	// 			$assignment_results .= "<td>".$criteria->rating."<td>"
	// 		}

	// 		$assignment_results .= "</tr>"

	// 	}
	// }

	// $page = str_replace('$evaluationsReceived', $evaluationsReceived, $page);
	echo $page;