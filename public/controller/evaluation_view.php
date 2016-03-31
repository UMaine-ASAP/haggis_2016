<?php
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

	foreach($criteria as $c){
		$s = $c->GetSelections();

		$v = intval($c->GetCriteriaRating($eval->evaluationID));
		switch($v){
			case 1:
				$criteria_results[] = [
				 	'id' => $c->criteriaID,
				 	'criteriaTitle' => $c->title,
				 	'v1' => $s[0]->description,
				 	'v2' => $s[1]->description,
				 	'v3' => $s[2]->description,
				 	'v4' => $s[3]->description,
				 	'v5' => $s[4]->description,
				 	'checked' => 1,
				 	'comments' => $c->comments
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
				 	'comments' => $c->comments
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
				 	'comments' => $c->comments
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
				 	'comments' => $c->comments
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
				 	'comments' => $c->comments
				 ];
				break;
			default:
				$criteria_results[] = [
				 	'id' => $c->criteriaID,
				 	'criteriaTitle' => $c->title,
				 	'v1' => $s[0]->description,
				 	'v2' => $s[1]->description,
				 	'v3' => $s[2]->description,
				 	'v4' => $s[3]->description,
				 	'v5' => $s[4]->description,
				 	'checked' => 'disabled',
				 	'comments' => $c->comments
				 ];
				break;
		 // $criteria_results[] = [
		 // 	'id' => $c->criteriaID,
		 // 	'criteriaTitle' => $c->title,
		 // 	'v1' => $s[0]->description,
		 // 	'v2' => $s[1]->description,
		 // 	'v3' => $s[2]->description,
		 // 	'v4' => $s[3]->description,
		 // 	'v5' => $s[4]->description,
		 // 	'checked' => $c->rating,
		 // 	'comments' => $c->comments
		 // ];
		}
	}
	//Go to html view.
	if($_SESSION['user']->userType == 'Student'){
		$action = 'student_home.php';
	}
	else{
		$action = 'instructor_home.php';
	}
	echo $twig->render('evaluation_view.html', [
		"username"              => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
		"evaluationTitle"		=>$evaluationTitle,
		"criteria"				=>$criteria_results, 
		"evaluationID"			=>$eval->evaluationID,
		"action"				=> $action
		
	]);

?>