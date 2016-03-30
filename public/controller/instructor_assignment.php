<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	$assignmentID = 3;// = $_POST['assignmentID'];
	$assignmentWorking = new Assignment($assignmentID);
	$assignmentName = $assignmentWorking->title;
	$assignmentDescription = $assignmentWorking->description;

	// $classID = 5;// = $_POST['classID'];//Get This SOme OTHEr Way
	// $classWorking = new Period($classID);

	// $masterEval = new Evaluation(0);

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

	

	foreach ($allEvaluationsInstructor as $eval)
	{
		foreach ($allEvaluationsAssignment as $evalCompared) {
			if($eval->evaluationID == $evalCompared->evaluationID)
				$matchedEval = $eval;
		}
	}

	function assignEvaluation()
	{
		global $classID, $courseID, $masterEvalID, $assignmentID;
	}
	
	function assignAssignment()
	{
		global $assignmentID, $courseID, $classID;
	}



	if(isset($_POST['postAssignMasterEval']))
	{

	}

	if(isset($_POST['postAssignAssignment']))
	{

	}

	echo $twig->render("instructor_assignment.html",
		[
			"assignmentName" => $assignmentName,
			"assignmentDescription" => $assignmentDescription,
			"evalsDone" => $evalsDone,
			"evalsTotal" => $evalsTotal,
			"evaluationData" => $matchedEval->evaluationID
		]);

?>