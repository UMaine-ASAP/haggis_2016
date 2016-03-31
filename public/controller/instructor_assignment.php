<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	if(isset($_POST['assignmentID'])){
		$_SESSION['assignmentID'] =  $_POST['assignmentID'];
		$assignmentID = $_POST['assignmentID'];
		$assignmentWorking = new Assignment($assignmentID);
		$assignmentName = $assignmentWorking->title;
		$assignmentDescription = $assignmentWorking->description;
		$evaluationsTotal = $assignmentWorking->GetEvaluations();
		$master_evaluation = $evaluationsTotal[0];
	}
	else
		$assignmentID = $_SESSION['assignmentID'];
	

	

	$evalsDone = 0;
	foreach ($evaluationsTotal as $eval) {
		if($eval->done == 1)
			$evalsDone = $evalsDone + 1;
	}

	$evalsTotal = count($evaluationsTotal);

	$instructor = $_SESSION['user']->userID;

	// $allEvaluationsInstructor = $instructor->GetEvaluations();
	// $allEvaluationsAssignment = $assignmentWorking->GetEvaluations();

	// $blankEval = new Evaluation(0);

	// foreach ($allEvaluationsInstructor as $eval)
	// {

	// 	$matchedEval = $blankEval;
	// 	foreach ($allEvaluationsAssignment as $evalCompared) {
	// 		if($eval->evaluationID == $evalCompared->evaluationID)
	// 			$matchedEval = $eval;
	// 	}
	// }

	// if(isset($_SESSION['assignmentKey']))
	// 	if($_SESSION['assignmentKey'] == $matchedEval->evaluationID)
	// 		$pushAssignmentButton = FALSE;
	// 	else
	// 	{
	// 		$pushAssignmentButton = TRUE;
	// 	}
	// else
	// 	$pushAssignmentButton = TRUE;

	echo $twig->render("instructor_assignment.html",
		[
			"username"        => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
			"assignmentName" => $assignmentName,
			"assignmentDescription" => $assignmentDescription,
			"evalsDone" => $evalsDone,
			"evalsTotal" => $evalsTotal,
			"assignmentID" => $_SESSION['assignmentID'],
			"evaluationID" => $master_evaluation->evaluationID
		]);

?>