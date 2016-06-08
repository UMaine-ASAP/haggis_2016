<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	//grab assignment info
	if(isset($_GET['assignmentID'])){
		$_SESSION['assignmentID'] =  $_GET['assignmentID'];
		$assignmentID = $_GET['assignmentID'];
	}
	else
		$assignmentID = $_SESSION['assignmentID'];

	$assignment = new Assignment($assignmentID); 		//get assignment
	$evaluations = $assignment->GetEvaluations();		//get evaluations
	$class = $assignment->GetClasses()[0]; 				//get class for assignment
	$all_users = $class->GetUsersAsc();					//get users for class
	$Get_Groups = $assignment->GetGroups();				//get groups for assignment

	//initilize some tracker variables
	$master_group = -1;
	$master_groupID = -1;
	$master_peer = -1;
	$master_peerID = -1;
	$master_individual = -1;
	$master_individualID = -1;

	//if there are existing evaluations for assignment
	if(count($evaluations > 0)){
		foreach ($evaluations as $eval) { //foreach evaluation

			//check if it's a peer/group/individual eval
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

	$evalsTotal = 0; //track total number of evals done

	//get all evaluations done by students
	$all_group_evals = array();
	$all_peer_evals  = array();
	$all_individual_evals = array();

	//if there is an existing group evaluation
	if(gettype($master_group) != 'integer'){ 
		$all_group_evals = $master_group->GetChildEvaluations(); //get student submissions
		$master_groupID = $master_group->evaluationID;
	}
	//if there is an existing peer evaluation
	if(gettype($master_peer) != 'integer'){
		$all_peer_evals = $master_peer->GetChildEvaluations(); //get student submissions
		$master_peerID = $master_peer->evaluationID;
	}
	//if there is an existing individual evaluation
	if(gettype($master_individual) != 'integer'){
		$all_individual_evals = $master_individual->GetChildEvaluations(); //get student submissions
		$master_individualID = $master_individual->evaluationID;
	}

	//count total submissions
	$evalsTotal += count($all_group_evals);
	$evalsTotal += count($all_peer_evals);
	$evalsTotal += count($all_individual_evals);

	//setup student and groups arrays
	$students = array();
	$groups = array();	

	//adds every STUDENT into the $students array
	foreach($all_users as $user){ //
		if ($user->userType == "Student"){
			$students[] = [
				"name"=>$user->firstName." ".$user->lastName,
				"id" => $user->userID
			];
		}
	}

	//adds existing groups into the $groups array 
	foreach($Get_Groups as $group){ //for each group

		$group_students = $group->GetUsers(); //get students in the group

		$names = array();					//names of students in group
		$students_for_group = $all_users;	//list of all students in class
		$students_for_group2 = array();		//list of all students minus students in this group
		foreach ($students_for_group as $user) {
			//check if student is already in group or is instructor
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

		//for each student in group
		foreach ($group_students as $s) {
			//add name, id to names
			$names[] = [
				"name"=>$s->firstName." ".$s->lastName,
				"id" => $s->userID
			];
		}

		//add to Twig variable
		$groups[]= [
			"groupID"=>$group->student_groupID, 
			"number"=>$group->groupNumber,
			"names" => $names,
			"students" => $students_for_group2
			];
	}

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