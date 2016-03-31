<?php
	ini_set('display_errors',1);  
	error_reporting(E_ALL);
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();
	//get evaluation
	$eval = new Evaluation($_POST['evaluationID']);
	
	//create evaluation title from assignment name, type of eval, and who it targets.
	$evaluationTitle = $eval->GetAssignment()->title . " " . $eval->evaluation_type." ";
	if($eval->evaluation_type == "Group"){
		$evaluationTitle .= $eval->groupID. " Evaluation";
	}else{
		$user = new User($eval->target_userID);
		$evaluationTitle .= "Evaluation- ".$user->firstName." ".$user->lastName;
	}
	 

	//get critera of evaluation.
	$criteria_results = array();
	$criteria = $eval->GetCriteria();
	$count = 0;
	foreach($criteria as $c){
		$s = $c->GetSelections();
		$count++;
		 $criteria_results[] = [
		 	'id' => $c->criteriaID,
		 	'criteriaTitle' => $c->title,
		 	'count' => $count,
		 	'v1' => $s[0]->description,
		 	'v2' => $s[1]->description,
		 	'v3' => $s[2]->description,
		 	'v4' => $s[3]->description,
		 	'v5' => $s[4]->description
		 ];
	}
	$_SESSION['count'] = $count;
	$_SESSION['evaluationID'] = $_POST['evaluationID'];
	//Go to html view.
	echo $twig->render('evaluation_submit.html', [
		"username"              => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
		"evaluationTitle"		=>$evaluationTitle,
		"criteria"				=>$criteria_results, 
		"evaluationID"			=>$eval->evaluationID
		
	]);

?>