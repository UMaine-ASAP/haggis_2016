<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	$assignmentID = $_POST['assignmentID'];
	$assignmentWorking = new Assignment($assignmentID);
	$assignmentName = $assignmentWorking->title;
	$assignmentDescription = $assignmentWorking->description;

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

	
	$usersInClassAssignment = $assignmentWorking->GetClasses()[0]->GetUsers();
	foreach ($usersInClassAssignment as $user) {
		if($user->userType == 'Student')
			$studentsInClassAssignment[] = $user;
	}
	
	if(isset($matchedEval))
	{
		foreach ($studentsInClassAssignment as $student) {
			$student->AddEvaluation($matchedEval->evaluationID);
		}
		$_SESSION['assignmentKey'] = $matchedEval->evaluationID;
		$_SESSION['assignmentID'] = $_POST['assignmentID'];
	}
	$_SESSION['assignmentKey'] = $matchedEval->evaluationID;
	$_SESSION['assignmentID'] = $_POST['assignmentID'];

	header("location:instructor_assignment.php");
?>