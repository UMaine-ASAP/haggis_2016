<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();
	//get evaluation
	$assignment = new Assignment($_SESSION['assignmentID']);
	$eval = $assignment->GetEvaluation();

	//create evaluation title from assignment name, type of eval, and who it targets.
	$evaluationTitle = $assignment->title . " - ";
	if(!empty($_POST['group_target'])){
		$group = new Student_Group($_POST['group_target']);
		$evaluationTitle .= "Group " . $group->groupNumber . " Evaluation";
	}else{
		$user = new User($_POST['peer_target']);
		$evaluationTitle .= $user->firstName . " " . $user->lastName . " Peer Evaluation";
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
	$_SESSION['evaluationID'] = $eval->evaluationID;

	if(!empty($_POST['group_target'])){
		$_SESSION['group_target'] = $_POST['group_target'];
	}
	else{
		$_SESSION['peer_target'] = $_POST['peer_target'];
	}
	//Go to html view.
	echo $twig->render('evaluation_submit.html', [
		"username"              => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
		"evaluationTitle"		=>$evaluationTitle,
		"criteria"				=>$criteria_results, 
		"evaluationID"			=>$eval->evaluationID
		
	]);

?>