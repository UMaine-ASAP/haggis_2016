<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	$evaluations = $_SESSION['user']->GetEvaluations();
	$assignmentGlobal = new Assignment($_POST['assignmentID']);

	$relevantAssignments = array();

	function receiveEvaluationsForAssignment()
	{
		$allEvalsReceivedForUser = $_SESSION['user']->GetEvaluations();
		foreach ($allEvalsReceivedForUser as $eval)
		{
			$placeHolderID = $eval->GetAssignment()->assignmentID;
			global $assignmentGlobal;
			if($placeHolderID == $assignmentGlobal->assignmentID)
			{
				global $relevantAssignments;
				array_push($relevantAssignments, $eval);
			}
			else
			{

			}
		}
	}

	receiveEvaluationsForAssignment();

	// var_dump($relevantAssignments);

	$evaluationsReceived = "<table><thead><tr><th>Evaluations Received</tr></thead>";

	if($relevantAssignments != array()){
		foreach($relevantAssignments as $eval){
			//This may not be a significant way of telling whether or not the evaluation is finished or not.
			// There should probably be a function to determine if any criteria within the evaluation do not have a filled rating.
			if($eval->done != 0){
				$e = new Evaluation($eval->evaluationID);
				$u = $e->GetUser();
				$evaluationsReceived .= "<tr><td>";
				$evaluationsReceived .= '<form method="post" action="evaluation_view.php">';
				$evaluationsReceived .= '<button type="submit" value="' . $eval->evaluationID . '" name="evaluationID" ';
				$evaluationsReceived .= 'formaction="evaluation_view.php"> ';

				// if($e->evaluation_type == "group")
				$evaluationsReceived .= $e->GetAssignment()->title." ";
				$evaluationsReceived .= $e->evaluation_type." evaluation</button></td></tr>";
			}
		}
	}

	$evaluationsReceived .= "</table>";

	//setup table for evaluations to do
	$evaluationsToDo = "<table><thead><tr><th>Evaluations To Do</tr></thead>";

	if($relevantAssignments != array()){
		foreach($relevantAssignments as $eval){
			//This may not be a significant way of telling whether or not the evaluation is finished or not.
			// There should probably be a function to determine if any criteria within the evaluation do not have a filled rating.
			if($eval->done == 0){
				$e = new Evaluation($eval->evaluationID);
				if($eval->target_userID != 0){
					$u = new User($eval->target_userID);
				}
				$evaluationsToDo .= "<tr><td>";
				$evaluationsToDo .= '<form method="post" action="evaluation_submit.php">';
				$evaluationsToDo .= '<button type="submit" value="' . $eval->evaluationID . '" name="evaluationID"';
				$evaluationsToDo .= ' formaction="evaluation_submit.php"> ';

				$evaluationsToDo .= $e->GetAssignment()->title." ";

				$type= $e->evaluation_type;
				if($type=='Peer'){
					$evaluationsToDo .= "Peer " . $u->firstName;
				}
				else{
					$evaluationsToDo .= $e->GetGroup()->name;
				}
				$evaluationsToDo .=  " </button></td></tr>";
			}
		}
	}

	$evaluationsToDo .= "</table>";

	//get assignment
	$assignment = new Assignment($_POST['assignmentID']);
	//get the html page ready to be displayed
	// $page = file_get_contents(dirname(__FILE__) . '/../views/assignment_view.html');
	// $page = str_replace('$assignmentName', $assignmentGlobal->title, $page);
	// $page = str_replace('$firstName', $_SESSION['user']->firstName, $page);
	// $page = str_replace('$assignmentDescription', $assignmentGlobal->description, $page);
	// $page = str_replace('$evaluationsToDo', $evaluationsToDo, $page);
	// $page = str_replace('$evaluationsReceived', $evaluationsReceived, $page);
	// echo $page;



	//build received evaluations
	$evaluationReceived_results = [];
	$rec_evaluations = $_SESSION['user']->GetReceivedEvaluations();
	foreach($rec_evaluations as $eval){
		if($eval->done == 1){
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