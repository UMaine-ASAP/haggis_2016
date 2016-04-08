<?php
	ini_set('display_errors', 1);
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();


	$_SESSION['assignmentID'] = $_POST['assignmentID'];
	//Get the peers in the user's group
	$user = $_SESSION['user'];

	$evaluations_made = $user->GetEvaluations();
	// $evaluations_made_IDs = array();
	// foreach($evaluations_made as $e){
	// 	$evaluations_made_IDs[] = $e->evaluationID;
	// }

	$groups = $user->GetGroups();
	$group = FALSE;
	foreach($groups as $g){
		if($g->assignmentID == $_SESSION['assignmentID']){
			$group = $g;
		}
	}

	$peer_results = array();
	$group_results = array();
	$peer_eval_results = array();
	$group_eval_results = array();

	$group_users = array();
	//get peers in the same group as user
	if($group != FALSE){

		$group_users = $group->GetUsers();
		foreach($group_users as $u){
			if($u->userID != $user->userID){
				$peer_results[] = [
					"name" => $u->firstName." ".$u->lastName,
					"userID" => $u->userID
				];
			}
		}
	}

	//get submitted evaluations for peers in this assignment
	foreach($group_users as $u){
		$peer_received_evals = $u->GetReceivedEvaluations();
		foreach($peer_received_evals as $peer_eval){
			$result = array_search($peer_eval, $evaluations_made);
			if(gettype($result) == 'integer'){
				$a = $evaluations_made[$result]->GetAssignment();
				if($a == $peer_eval->GetAssignment() AND $a->assignmentID == $_SESSION['assignmentID']){
					$peer_eval_results[] = [
						"name" => $u->firstName." ".$u->lastName,
						"id"   => $peer_eval->evaluationID
					];
				}
			}
		}
	}


	$other_groups = array();
	//get other groups besides this user's group
	if($group != FALSE){
		$other_groups = $group->GetOtherGroups();
		foreach($other_groups as $g){
			$group_results[] = [
				"number" => $g->groupNumber,
				"groupID" => $g->student_groupID
			];
		}
	}

	//get submitted evaluations for groups in this assignment
	foreach($other_groups as $g){
		$group_received_evals = $g->GetReceivedEvaluations();

		foreach($group_received_evals as $group_eval){
			$result = array_search($group_eval, $evaluations_made);
			if(gettype($result) == 'integer'){
				$a = $evaluations_made[$result]->GetAssignment();
				if($a == $group_eval->GetAssignment() AND $a->assignmentID == $_SESSION['assignmentID']){
					$group_eval_results[] = [
						"number" => $g->groupNumber,
						"id"   => $group_eval->evaluationID
					];
				}
			}
		}
	}

	// You need to send over the assignment id derived from the evaluation id so that the next view can
	// populate the dropdown with students/groups.
	// Of course for this to work by now the students need to be entered into their respective groups.
	echo $twig->render("student_create_evaluation.html",[
		"username"        => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
		"peers"		 	  => $peer_results,
		"groups"		  => $group_results,
		"peer_evals"	  => $peer_eval_results,
		"group_evals"	  => $group_eval_results
		]);
?>