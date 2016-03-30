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
	$page = file_get_contents(dirname(__FILE__) . '/../views/assignment_view.html');
	$page = str_replace('$assignmentName', $assignmentGlobal->title, $page);
	$page = str_replace('$firstName', $_SESSION['user']->firstName, $page);
	$page = str_replace('$assignmentDescription', $assignmentGlobal->description, $page);
	$page = str_replace('$evaluationsToDo', $evaluationsToDo, $page);
	$page = str_replace('$evaluationsReceived', $evaluationsReceived, $page);
	echo $page;

	//echo "assignment to view: " . $_POST['assignmentID'];
?>