<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	$assignment = new Assignment($_SESSION['assignmentID']);
	$class = $assignment->GetClasses()[0];

	$users = $class->GetUsers();
	$master = new Evaluation($_POST['evaluationID']);
	$master_criteria = $master->GetCriteria()[0];
	$master_selections = $master_criteria->GetSelections();

	foreach($users as $u){
		if($u->userType == 'Student'){
			$evaluation = new Evaluation(0);
			$evaluation->done = 0;
			$evaluation->evaluation_type = $master->evaluation_type;
			$evaluation->criteriaID = 1;
			$evaluation->Save();
			$u->AddEvaluation($evaluation->evaluationID);
			$evaluation->AddCriteria($master_criteria->criteriaID);
			$current_assignment = new Assignment($_SESSION['assignmentID']);
			$current_assignment->AddEvaluation($evaluation->evaluationID);
		}
	}
	header("location:instructor_home.php");
?>