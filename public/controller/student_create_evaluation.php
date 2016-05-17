<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn(); //check if logged in

	if(!empty($_POST['assignmentID'])) $_SESSION['assignmentID'] = $_POST['assignmentID']; //set assignment session var
	$assignment = new Assignment($_SESSION['assignmentID']);	//set assignment object
	
	$user = $_SESSION['user']; //set user object

	$evaluations_made = $user->GetEvaluations(); //get all evaluations user has made

	//Get the peers in the user's group
	$groups = $user->GetGroups();
	$group = FALSE;	//initialize group var in case there are no groups

	//find group associated with this assignment
	foreach($groups as $g){
		if($g->assignmentID == $_SESSION['assignmentID']){
			$group = $g;
		}
	}

	//people in respective group/peer category
	$peer_results = array();
	$group_results = array();
	$individual_results = array();

	//previously made evaluations for this assignment
	//will allow user to edit these evaluations
	$peer_eval_results = array();
	$group_eval_results = array();
	$individual_eval_results = array();

	//used to find users in a group, then used to add to peer_results 
	$group_users = array();

	//get peers in the same group as user
	if($group != FALSE){

		$group_users = $group->GetUsers(); 		//users in a group
		foreach($group_users as $u){			//foreach user
			if($u->userID != $user->userID){	//if user is not current user
				$peer_results[] = [				//add to peer results
					"name" => $u->firstName." ".$u->lastName,	//peer name
					"userID" => $u->userID						//peer user ID
				];
			}
		}
	}

	//get submitted evaluations for peers in this assignment
	foreach($group_users as $u){									//foreach user in current user's group
		$peer_received_evals = $u->GetReceivedEvaluations();		//get received evaluations of user

		foreach($peer_received_evals as $peer_eval){				//foreach received eval
			$result = array_search($peer_eval, $evaluations_made);	//if peer eval is one of current user's previously made evals
			if(gettype($result) == 'integer'){						//check that index of array is given
				$a = $evaluations_made[$result]->GetAssignment();	//get assignment of eval

				//matching assignments and session assignment matches and eval is peer
				if($a == $peer_eval->GetAssignment() AND $a->assignmentID == $_SESSION['assignmentID'] and $peer_eval->evaluation_type == 'Peer'){
					$peer_eval_results[] = [						//add Twig result for peer
						"name" => $u->firstName." ".$u->lastName,	//student name
						"id"   => $peer_eval->evaluationID			//student ID
					];
				}
			}
		}
	}


	$other_groups = array();		//groups not apart of current user's group
	//get other groups besides this user's group
	if($group != FALSE){
		$other_groups = $group->GetOtherGroups(); 	//get other groups
		foreach($other_groups as $g){				//foreach other group
			$group_results[] = [					//add Twig variable
				"number" => $g->groupNumber,		//group number
				"groupID" => $g->student_groupID	//group ID
			];
		}
	}

	//get submitted evaluations for groups in this assignment
	foreach($other_groups as $g){										//foreach other group
		$group_received_evals = $g->GetReceivedEvaluations();			//get group's received evals

		foreach($group_received_evals as $group_eval){					//foreach eval received
			$result = array_search($group_eval, $evaluations_made);		//if user made the eval
			if(gettype($result) == 'integer'){
				$a = $evaluations_made[$result]->GetAssignment();		//get assignment

				//if matching assignment
				if($a == $group_eval->GetAssignment() AND $a->assignmentID == $_SESSION['assignmentID']){
					$group_eval_results[] = [				//add Twig varibale
						"number" => $g->groupNumber,		//group number
						"id"   => $group_eval->evaluationID	//group ID
					];
				}
			}
		}
	}

	//get students in the class to evaluate for individual assignment
	$class = $assignment->GetClasses()[0];		//get class, first index
	$users = $class->GetUsers();				//get class's students
	foreach($users as $u){						//for each student
		if($u->userType=="Student" and $u->userID != $_SESSION['user']->userID){	//if user is student and not current user
			$individual_results[] = [												//add Twig variable
				"userID" => $u->userID,												//user ID
				"name"   => $u->firstName . " " . $u->lastName						//user name
			];

			$rec_evals = $u->GetReceivedEvaluations();				//get user's received evals

			foreach($rec_evals as $eval){							//for each eval
				$result = array_search($eval, $evaluations_made);	//if current user made this eval
				if(gettype($result) == 'integer'){
					$a = $evaluations_made[$result]->GetAssignment();	//get assignment for eval

					//matching assignment and eval type is individual
					if($a == $eval->GetAssignment() AND $a->assignmentID == $_SESSION['assignmentID'] and $eval->evaluation_type == 'Individual'){
						$individual_eval_results[] = [					//add Twig variable
							"name" => $u->firstName." ".$u->lastName,	//user name
							"id"   => $eval->evaluationID				//user ID
						];
					}
				}
			}
		}
	}

	$check_individual = 0; //Twig variable used to check if there are individual evaluations
	$individual_evals = $assignment->GetEvaluations();	//get all evals for assignment
	foreach ($individual_evals as $eval) {				//foreach eval
		if($eval->evaluation_type == 'Individual'){		//check if type is individual
			$check_individual = 1;						//set variable
			break;
		}
	}

	// You need to send over the assignment id derived from the evaluation id so that the next view can
	// populate the dropdown with students/groups.
	// Of course for this to work by now the students need to be entered into their respective groups.
	echo $twig->render("student_create_evaluation.html",[
		"username"        => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
		"peers"		 	  => $peer_results,
		"groups"		  => $group_results,
		"individuals"	  => $individual_results,		//userID, name
		"peer_evals"	  => $peer_eval_results,
		"numPeers"		  => count($peer_results),
		"group_evals"	  => $group_eval_results,
		"numGroups"		  => count($group_results),
		"individual_evals" => $individual_eval_results,	//id, name
		"assignmentTitle" => $assignment->title,
		"check_individual" => $check_individual
		]);
?>