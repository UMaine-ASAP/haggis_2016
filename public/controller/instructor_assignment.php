<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	//grab assignment info
	if(isset($_POST['assignmentID'])){
		$_SESSION['assignmentID'] =  $_POST['assignmentID'];
		$assignmentID = $_POST['assignmentID'];
		$assignment = new Assignment($assignmentID);
		$evaluations = $assignment->GetEvaluations();

		$master_group = -1;
		$master_groupID = -1;
		$master_peer = -1;
		$master_peerID = -1;
		if(count($evaluations > 0)){
			foreach ($evaluations as $eval) {
				if($eval->evaluation_type == 'Peer' AND $eval->target_userID == 0 AND $eval->groupID == 0){
					$master_peer = $eval;
				}
				else if($eval->evaluation_type == 'Group' AND $eval->target_userID == 0 AND $eval->groupID == 0){
					$master_group = $eval;
				}
			}
		}
	}
	else
		$assignmentID = $_SESSION['assignmentID'];

	$evalsTotal = 0;
	//get all child evaluations done and count how many
	$all_group_evals = array();
	$all_peer_evals  = array();
	if($master_group != -1){
		$all_group_evals = $master_group->GetChildEvaluations();
		$master_groupID = $master_group->evaluationID;
	}
	if($master_peer != -1){
		$all_peer_evals = $master_peer->GetChildEvaluations();
		$master_peerID = $master_peer->evaluationID;
	}

	$evalsTotal += count($all_group_evals);
	$evalsTotal += count($all_peer_evals);

	$instructor = $_SESSION['user']->userID;

	echo $twig->render("instructor_assignment.html",
		[	
			"username"      	    => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
			"assignmentName" 		=> $assignment->title,
			"assignmentDescription" => $assignment->description,
			"evalsTotal" 			=> $evalsTotal,
			"assignmentID" 			=> $_SESSION['assignmentID'],
			"groupEvaluationID" 	=> $master_groupID,
			"peerEvaluationID" 		=> $master_peerID
		]);

?>