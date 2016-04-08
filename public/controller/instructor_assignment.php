<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	//grab assignment info
	if(isset($_POST['assignmentID'])){
		$_SESSION['assignmentID'] =  $_POST['assignmentID'];
		$assignmentID = $_POST['assignmentID'];
		$assignment = new Assignment($assignmentID);
		$master_evaluations = $assignment->GetEvaluations();
	}
	else
		$assignmentID = $_SESSION['assignmentID'];
	

	$evalsTotal = -1; // will allow for creation of parent evaluation if this is -1
	//get all child evaluations done and count how many
	$all_group_evals = $master_evaluations[0]->GetChildEvaluations();
	$all_peer_evals = $master_evaluations[1]->GetChildEvaluations();
	$evalsTotal = count($all_group_evals);
	$evalsTotal += count($all_peer_evals);
	$students = 

	$instructor = $_SESSION['user']->userID;

	echo $twig->render("instructor_assignment.html",
		[
			"username"        => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
			"assignmentName" => $assignment->title,
			"assignmentDescription" => $assignment->description,
			"evalsTotal" => $evalsTotal,
			"assignmentID" => $_SESSION['assignmentID'],
			"groupEvaluationID" => $master_evaluations[0]->evaluationID,
			"peerEvaluationID" => $master_evaluations[1]->evaluationID,
			"students"			=>   					,
			"groups"			=> 
		]);

?>