<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	//grab assignment info
	if(isset($_POST['assignmentID'])){
		$_SESSION['assignmentID'] =  $_POST['assignmentID'];
		$assignmentID = $_POST['assignmentID'];
	}
	else
		$assignmentID = $_SESSION['assignmentID'];

	$assignment = new Assignment($assignmentID);
	$evaluations = $assignment->GetEvaluations();
	$master_evaluations = $assignment->GetEvaluations();
	$class = $assignment->GetClasses()[0]; //class for this assignment
	$all_users = $class->GetUsers();
	$Get_Groups = $assignment->GetGroups();

	$master_group = -1;
	$master_groupID = -1;
	$master_peer = -1;
	$master_peerID = -1;
	$master_individual = -1;
	$master_individualID = -1;
	if(count($evaluations > 0)){
		foreach ($evaluations as $eval) {
			if($eval->evaluation_type == 'Peer' AND $eval->target_userID == 0 AND $eval->groupID == 0){
				$master_peer = $eval;
			}
			else if($eval->evaluation_type == 'Group' AND $eval->target_userID == 0 AND $eval->groupID == 0){
				$master_group = $eval;
			}
			else if($eval->evaluation_type == 'Individual' AND $eval->target_userID == 0 AND $eval->groupID == 0){
				$master_individual = $eval;
			}
		}
	}

	$evalsTotal = 0;
	//get all child evaluations done and count how many
	$all_group_evals = array();
	$all_peer_evals  = array();
	$all_individual_evals = array();
	if(gettype($master_group) != 'integer'){
		$all_group_evals = $master_group->GetChildEvaluations();
		$master_groupID = $master_group->evaluationID;
	}
	if(gettype($master_peer) != 'integer'){
		$all_peer_evals = $master_peer->GetChildEvaluations();
		$master_peerID = $master_peer->evaluationID;
	}
	if(gettype($master_individual) != 'integer'){
		$all_individual_evals = $master_individual->GetChildEvaluations();
		$master_individualID = $master_individual->evaluationID;
	}

	$evalsTotal += count($all_group_evals);
	$evalsTotal += count($all_peer_evals);
	$students = array();
	$groups = array();	

	//adds EVERY STUDENT into the $studens array
	foreach($all_users as $user){ //
		if ($user->userType == "Student"){
			$students[] = [
				"name"=>$user->firstName." ".$user->lastName,
				"id" => $user->userID
			];
		}
	}

	//adds existing groups into the $groups array 
	foreach($Get_Groups as $group){
		$group_students = $group->GetUsers();
		$names = array();
		$students_for_group = $all_users;
		$students_for_group2 = array();
		foreach ($students_for_group as $user) {
			if(in_array($user,$group_students) OR $user->userType == 'Instructor'){
				continue;
			}
			else{
				$students_for_group2[] = [
				"name"=>$user->firstName." ".$user->lastName,
				"id" => $user->userID
				];
			}
		}

		foreach ($group_students as $s) {
			$names[] = [
				"name"=>$s->firstName." ".$s->lastName,
				"id" => $s->userID
			];
		}
		$groups[]= [
			"groupID"=>$group->student_groupID, 
			"number"=>$group->groupNumber,
			"names" => $names,
			"students" => $students_for_group2
			];
	}

	$evalsTotal += count($all_individual_evals);

	$instructor = $_SESSION['user']->userID;

	echo $twig->render("instructor_assignment.html",
		[	
			"username"      	    => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
			"assignmentName" 		=> $assignment->title,
			"assignmentDescription" => $assignment->description,
			"students" 				=> $students,     //array(["name"=>'matt', "userID"=>50],["name"=>'steven'],["name"=>'matt']),
			"groups" 				=> $groups,       //array(["groupID"=>'6', "number"=>'1'])
			"evalsTotal" 			=> $evalsTotal,
			"assignmentID" 			=> $_SESSION['assignmentID'],
			"groupEvaluationID" 	=> $master_groupID,
			"peerEvaluationID" 		=> $master_peerID,
			"individualEvaluationID" => $master_individualID
		]);

?>