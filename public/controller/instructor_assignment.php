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
		$assignment = new Assignment($assignmentID);
		$master_evaluations = $assignment->GetEvaluations();
		$class = $assignment->GetClasses()[0]; //class for this assignment
		$all_users = $class->GetUsers();
		$Get_Groups = $assignment->GetGroups();
		
	}
	else
		$assignmentID = $_SESSION['assignmentID'];
	

	$evalsTotal = -1; // will allow for creation of parent evaluation if this is -1
	//get all child evaluations done and count how many
	$all_group_evals = $master_evaluations[0]->GetChildEvaluations();
	$all_peer_evals = $master_evaluations[1]->GetChildEvaluations();
	$evalsTotal = count($all_group_evals);
	$evalsTotal += count($all_peer_evals);
	$students = array();
	$groups = array();	

	//adds EVERY STUDENT into the $studens array
	foreach($all_users as $user){ //
		if ($user->userType == "Student"){
			$students[] = ["name"=>$user->firstName." ".$user->lastName];
		}
	}

	//adds existing groups into the $groups array 
	foreach($Get_Groups as $group){
		$groups[]= ["groupID"=>$group->student_groupID, "number"=>$group->groupNumber];
	}



	$instructor = $_SESSION['user']->userID;

	echo $twig->render("instructor_assignment.html",
		[
			"username"        => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
			"assignmentName" => $assignment->title,
			"assignmentDescription" => $assignment->description,
			"evalsTotal" => $evalsTotal,
			"assignmentID" => $_SESSION['assignmentID'],
			"groupEvaluationID" => $master_evaluations[0]->evaluationID,
			"peerEvaluationID" => $master_evaluations[1]->evaluationID,
			"students" => $students,     //array(["name"=>'matt', "userID"=>50],["name"=>'steven'],["name"=>'matt']),
			"groups" => $groups           //array(["groupID"=>'6', "number"=>'1'])
		]);

?>