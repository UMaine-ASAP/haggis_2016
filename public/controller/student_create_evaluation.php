<?php
	ini_set('display_errors', 1);
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	$_SESSION['assignmentID'] = $_POST['assignmentID'];
	//Get the peers in the user's group
	$user = $_SESSION['user'];
	$group = $user->GetGroup();
	$peer_results = array();
	$group_results = array();

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