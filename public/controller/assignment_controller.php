<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();


	
	//build received evaluations
	$evaluationReceived_results = [];
	$rec_evaluations = $_SESSION['user']->GetReceivedEvaluations();
	foreach($rec_evaluations as $eval){
		if($eval->done == 1 && $eval->GetAssignment()->assignmentID == $_POST['assignmentID']){
			$e = new Evaluation($eval->evaluationID);

			$evaluationReceived_results[] = [
				"id"    => $eval->evaluationID,
				"title" =>  $e->evaluation_type." Evaluation"
			];
		}
	}



	//Get id of the assignment on page.
	$thisAssignmentID = $_POST['assignmentID'];
	// Get all of this user's evaluations.
	$allEvaluations = $_SESSION['user']->GetEvaluations();
	$evaluationsToDo = array();
	foreach($allEvaluations as $evaluation){
		// If the eval matches to this assignment id and it isn't done then add it to the todo array.
		if($evaluation->GetAssignment()->assignmentID == $thisAssignmentID && $evaluation->done == 0){
			
			$evaluationTitle = "";
			if($evaluation->evaluation_type == "Group"){
				$evaluationTitle .= "Group ".$evaluation->groupID;
			}else{
				$targetUser = new User($evaluation->target_userID);	
				$targetUserName = $targetUser->firstName." ".$targetUser->lastName;					
				$evaluationTitle .= "Peer- ".$targetUserName;
			}

			$evaluationsToDo[] = ["id"=>$evaluation->evaluationID, "title" => $evaluationTitle];

			
		}
	}



	//get assignment
	$assignment = new Assignment($_POST['assignmentID']);



	 $assignment = ["name" => $assignment->title, "description" => $assignment->description];
	 $user = ["name" => $_SESSION['user']->firstName." ".$_SESSION['user']->lastName];


	echo $twig->render("assignment_view.html", [
		"assignment"          => $assignment,
		"user"                => $user,
		"evaluationsToDo"     => $evaluationsToDo,
		"evaluationsForThisAssignment"     => $evaluationsToDo,
		"evaluationsReceived" => $evaluationReceived_results
		]);

	//echo "assignment to view: " . $_POST['assignmentID'];
?>