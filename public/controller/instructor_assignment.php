<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	if(isset($_POST['assignmentID']))
		$assignmentID = $_POST['assignmentID'];
	else
		$assignmentID = $_SESSION['assignmentID'];
	
	$assignmentWorking = new Assignment($assignmentID);
	$assignmentName = $assignmentWorking->title;
	$assignmentDescription = $assignmentWorking->description;

	

	$evaluationsTotal = $assignmentWorking->GetEvaluations();

	$evalsDone = 0;
	foreach ($evaluationsTotal as $eval) {
		if($eval->done == 1)
		$evalsDone = $evalsDone + 1;
	}

	$evalsTotal = 0;
	foreach ($evaluationsTotal as $eval) {
		$evalsTotal = $evalsTotal + 1;
	}

	$instructedID = $_SESSION['user']->userID;

	$instructor = new User($instructedID);

	$allEvaluationsInstructor = $instructor->GetEvaluations();
	$allEvaluationsAssignment = $assignmentWorking->GetEvaluations();

	$blankEval = new Evaluation(0);

	foreach ($allEvaluationsInstructor as $eval)
	{

		$matchedEval = $blankEval;
		foreach ($allEvaluationsAssignment as $evalCompared) {
			if($eval->evaluationID == $evalCompared->evaluationID)
				$matchedEval = $eval;
		}
	}

	if(isset($_SESSION['assignmentKey']))
		if($_SESSION['assignmentKey'] == $matchedEval->evaluationID)
			$pushAssignmentButton = FALSE;
		else
		{
			$pushAssignmentButton = TRUE;
		}
	else
		$pushAssignmentButton = TRUE;

	echo $twig->render("instructor_assignment.html",
		[
			"assignmentName" => $assignmentName,
			"assignmentDescription" => $assignmentDescription,
			"evalsDone" => $evalsDone,
			"evalsTotal" => $evalsTotal,
			"evaluationData" => $matchedEval->evaluationID,
			"assignmentID" => $assignmentID,
			"assignmentKey" => $pushAssignmentButton
		]);

?>