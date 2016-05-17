<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	//get assignment and evaluations
	$assignment = new Assignment($_SESSION['assignmentID']);
	$evals = $assignment->GetEvaluations();

	//create evaluation title from assignment name, type of eval, and who it targets.
	$evaluationTitle = $assignment->title . " - "; //assignment title

	//check if group or peer or individual eval
	if(!empty($_POST['group_target'])){
		$group = new Student_Group($_POST['group_target']);
		$evaluationTitle .= "Group " . $group->groupNumber . " Evaluation";
		foreach($evals as $e){
			if($e->evaluation_type == 'Group' and $e->groupID == 0){ //check if template group eval (groupID = 0)
				$eval = $e;											 //set eval
				break;
			}
		}
	}else if(!empty($_POST['peer_target'])){
		$user = new User($_POST['peer_target']);
		$evaluationTitle .= $user->firstName . " " . $user->lastName . " Peer Evaluation";
		foreach($evals as $e){
			if($e->evaluation_type == 'Peer' and $e->target_userID == 0){ //check if template peer eval (target_userID = 0)
				$eval = $e;											 	  //set eval
				break;
			}
		}
	}else if(!empty($_POST['individual_target'])){
		$user = new User($_POST['individual_target']);
		$evaluationTitle .= $user->firstName . " " . $user->lastName . " Individual Evaluation";
		foreach($evals as $e){
			if($e->evaluation_type == 'Individual' and $e->target_userID == 0){ //check if template individual eval (target_userID = 0)
				$eval = $e;											 	  		//set eval
				break;
			}
		}
	}
	 

	//get critera of evaluation.
	$criteria_results = array();		//initialize criteria twig var
	$criteria = $eval->GetCriteria();	//get criteria for this eval
	$count = 0;							//counts how many criteria there are

	foreach($criteria as $c){			//foreach criteria
		$s = $c->GetSelections();		//get choices
		$count++;
		 $criteria_results[] = [		//add to twig var
		 	'id' => $c->criteriaID,			//criteria ID
		 	'criteriaTitle' => $c->title,	//description of criteria
		 	'count' => $count,				//what number criteria it is
		 	'v1' => $s[0]->description,		//choice 1
		 	'v2' => $s[1]->description,
		 	'v3' => $s[2]->description,
		 	'v4' => $s[3]->description,
		 	'v5' => $s[4]->description 		//choice 5
		 ];
	}

	//set some sessions variables for the submission of evaluation in 'evaluation_submit_request.php'
	$_SESSION['count'] = $count;
	$_SESSION['evaluationID'] = $eval->evaluationID;

	if(!empty($_POST['group_target'])){
		$_SESSION['group_target'] = $_POST['group_target'];
	}
	else if(!empty($_POST['peer_target'])){
		$_SESSION['peer_target'] = $_POST['peer_target'];
	}
	else if(!empty($_POST['individual_target'])){
		$_SESSION['individual_target'] = $_POST['individual_target'];
	}
	
	//Go to html view.
	echo $twig->render('evaluation_submit.html', [
		"username"              => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
		"evaluationTitle"		=>$evaluationTitle,
		"criteria"				=>$criteria_results, 
		"evaluationID"			=>$eval->evaluationID
		
	]);

?>