<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	if(empty($_POST['evaluationID'])){
		die('evaluationID not given');
	}

	//get evaluation
	$eval = new Evaluation($_POST['evaluationID']);
	
	//create evaluation title from assignment name, type of eval, and who it targets.

	//get assignment title
	if(!empty($_SESSION['assignmentID'])){
		$assignment = new Assignment($_SESSION['assignmentID']);
		$evaluationTitle = $assignment->title;
	}
	else{
		$evaluationTitle = $eval->GetParentEvaluation()->GetAssignment()->title;
	}

	//get either group or peer or individual part of title
	if($eval->evaluation_type == "Group" and intval($eval->groupID) > 0){
		$evaluationTitle .= " - Group ". $eval->GetGroup()->groupNumber. " Evaluation";
	}else if($eval->evaluation_type == "Peer" and intval($eval->target_userID) > 0){
		$user = new User($eval->target_userID);
		$evaluationTitle .= " - " . $user->firstName." ".$user->lastName." Peer Evaluation";
	}else if($eval->evaluation_type == "Individual" and intval($eval->target_userID) > 0){
		$user = new User($eval->target_userID);
		$evaluationTitle .= " - " . $user->firstName." ".$user->lastName." Individual Evaluation";
	}
	else if($eval->evaluation_type == "Group"){
		$evaluationTitle .= " - Group Criteria";
	}
	else if($eval->evaluation_type == "Peer"){
		$evaluationTitle .= " - Peer Criteria";
	}
	else{
		$evaluationTitle .= " - Individual Criteria";
	}
	 

	//get critera of evaluation.
	$criteria_results = array();			//final twig results for criteria
	$criteria = $eval->GetCriteria();		//get evals criteria
	$_SESSION['count'] = count($criteria);	//get number of critera
	foreach($criteria as $c){				//foreach criteria
		$s = $c->GetSelections();			//get choices

		$v = intval($c->GetCriteriaRating($eval->evaluationID));	//get user's previously given rating
		$co = $c->GetCriteriaComments($eval->evaluationID);			//get user's previously given comments

		//check the previous rating (1-5)
		switch($v){
			case 1:
				$criteria_results[] = [				//add to twig results
				 	'id' => $c->criteriaID,			//criteria ID
				 	'criteriaTitle' => $c->title,	//title
				 	'v1' => $s[0]->description,		//description of choice 1
				 	'v2' => $s[1]->description,
				 	'v3' => $s[2]->description,
				 	'v4' => $s[3]->description,
				 	'v5' => $s[4]->description,		//description of choice 5
				 	'checked' => 1,					//choice one was previous choice
				 	'comments' => $co 				//previous comments
				 ];
				break;
			case 2:
				$criteria_results[] = [
				 	'id' => $c->criteriaID,
				 	'criteriaTitle' => $c->title,
				 	'v1' => $s[0]->description,
				 	'v2' => $s[1]->description,
				 	'v3' => $s[2]->description,
				 	'v4' => $s[3]->description,
				 	'v5' => $s[4]->description,
				 	'checked' => 2,
				 	'comments' => $co
				 ];
				break;
			case 3:
				$criteria_results[] = [
				 	'id' => $c->criteriaID,
				 	'criteriaTitle' => $c->title,
				 	'v1' => $s[0]->description,
				 	'v2' => $s[1]->description,
				 	'v3' => $s[2]->description,
				 	'v4' => $s[3]->description,
				 	'v5' => $s[4]->description,
				 	'checked' => 3,
				 	'comments' => $co
				 ];
				break;
			case 4:
				$criteria_results[] = [
				 	'id' => $c->criteriaID,
				 	'criteriaTitle' => $c->title,
				 	'v1' => $s[0]->description,
				 	'v2' => $s[1]->description,
				 	'v3' => $s[2]->description,
				 	'v4' => $s[3]->description,
				 	'v5' => $s[4]->description,
				 	'checked' => 4,
				 	'comments' => $co
				 ];
				break;
			case 5:
				$criteria_results[] = [
				 	'id' => $c->criteriaID,
				 	'criteriaTitle' => $c->title,
				 	'v1' => $s[0]->description,
				 	'v2' => $s[1]->description,
				 	'v3' => $s[2]->description,
				 	'v4' => $s[3]->description,
				 	'v5' => $s[4]->description,
				 	'checked' => 5,
				 	'comments' => $co
				 ];
				break;
			default:								//default setting if nothing was chosen for a rating
				$criteria_results[] = [
				 	'id' => $c->criteriaID,
				 	'criteriaTitle' => $c->title,
				 	'v1' => $s[0]->description,
				 	'v2' => $s[1]->description,
				 	'v3' => $s[2]->description,
				 	'v4' => $s[3]->description,
				 	'v5' => $s[4]->description,
				 	'checked' => 'disabled', 		
				 	'comments' => $co
				 ];
				break;
		}
	}
	//Go to html view.
	if($_SESSION['user']->userType == 'Student'){
		$action = 'student_home.php';
	}
	else{
		$action = 'instructor_home.php';
	}
	echo $twig->render('evaluation_edit.html', [
		"username"              => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
		"evaluationTitle"		=>$evaluationTitle,
		"criteria"				=>$criteria_results, 
		"evaluationID"			=>$eval->evaluationID,
		"action"				=> $action
		
	]);
?>