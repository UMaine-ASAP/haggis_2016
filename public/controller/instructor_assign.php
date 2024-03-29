<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	$assignment = new Assignment($_SESSION['assignmentID']); //get assignment object
	$class = $assignment->GetClasses()[0];					 //get class object

	$users = $class->GetUsers();							 //get users from class
	$master = new Evaluation($_POST['evaluationID']);		 
	$master_criteria = $master->GetCriteria();

	foreach($users as $u){
		if($u->userType == 'Student'){
			$evaluation = new Evaluation(0);
			$evaluation->done = 0;
			$evaluation->evaluation_type = $master->evaluation_type;
			$evaluation->criteriaID = 1;
			$evaluation->Save();
			$u->AddEvaluation($evaluation->evaluationID);
			foreach($master_criteria as $c){
				$evaluation->AddCriteria($c->criteriaID);
			}
			$current_assignment = new Assignment($_SESSION['assignmentID']);
			$current_assignment->AddEvaluation($evaluation->evaluationID);
		}
	}
	header("location:instructor_home.php");
?>