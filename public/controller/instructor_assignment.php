<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	//grab assignment info
	if(isset($_POST['assignmentID'])){
		$_SESSION['assignmentID'] =  $_POST['assignmentID'];
		$assignmentID = $_POST['assignmentID'];
		$assignment = new Assignment($assignmentID);
		$master_evaluation = $assignment->GetEvaluation();
	}
	else
		$assignmentID = $_SESSION['assignmentID'];
	

	$evalsTotal = -1; // will allow for creation of parent evaluation if this is -1
	//get all child evaluations done and count how many
	$all_evals = $master_evaluation->GetChildEvaluations();
	$evalsTotal = count($all_evals);

	$instructor = $_SESSION['user']->userID;

	echo $twig->render("instructor_assignment.html",
		[
			"username"        => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
			"assignmentName" => $assignment->title,
			"assignmentDescription" => $assignment->description,
			"evalsTotal" => $evalsTotal,
			"assignmentID" => $_SESSION['assignmentID'],
			"evaluationID" => $master_evaluation->evaluationID
		]);

?>