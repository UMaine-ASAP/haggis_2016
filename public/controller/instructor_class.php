<?php

	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	//if not instructor, go to login
	if($_SESSION['user']->userType == 'Student')
	{
		header("location:login.php");
	}

	//if class id was not given
	if(!empty($_GET['classID'])){
		$_SESSION['classID'] = $_GET['classID'];
	}

	$class = new Period($_SESSION['classID']); //get class object
	//Build assignments
	$assignment_results = array();				//twig results for assignments
	$assignments = $class->GetAssignments();	//get assignments for class
	foreach($assignments as $a){				//for each assignment
		$assignment_results[] = [				//add twig result
			"name"			   => $a[0]->title,	//assignment title
			"dueDate"    	   => $a[1],		//assignment due date
			"id"  			   => $a[0]->assignmentID //assignment ID
		];
		
	}

	//Build Evaluations
	/*$evaluation_results = array();
	foreach ($assignments as $assignment){
		$evaluation_results[$assignment[0]->assignmentID] = array();
		$evaluations = $assignment[0]->GetEvaluations();
		foreach ($evaluations as $evaluation){
			$evaluation_results[$assignment[0]->assignmentID][] = $evaluation;
		}
	}

	foreach($assignments as $a){

		$parent_evals = $a[0]->GetEvaluations();
		$e = array();
		$target = "";

		foreach($parent_evals as $parent_eval){
			$evals = $parent_eval->GetChildEvaluations();
	
			foreach($evals as $eval){
	
				$user = $eval->GetUser();
				if($user->userType == 'Student'){
	
					if ($eval->evaluation_type=='Peer'){
						if($eval->target_userID != 0){
							$u = new User($eval->target_userID);
							$target = "Peer " . $u->firstName;
						}
					} 
					else if ($eval->evaluation_type=='Group'){
						$target = "Group " . $eval->GetGroup()->groupNumber;
					}
					else if ($eval->evaluation_type=='Individual'){
						if($eval->target_userID != 0){
							$u = new User($eval->target_userID);
							$target = "Individual " . $u->firstName;
						}
					}
	
					if($eval->done == 0){
						$target .= " - INCOMPLETE - " . $user->firstName . " " . $user->lastName; 
					}
					else{
						$target .= " - SUBMITTED BY- " . $user->firstName . " " . $user->lastName;
	
					}
	
					$e[] = [
						'target'		 => $target,
						'id'			 => $eval->evaluationID
					];
				}
	
			}
		}
		$evaluation_results[] = [
				'name'			 => $a[0]->title,
				'assigned'		 => $e
		];
	}*/


	//Build students
	$student_results = array();

	$students = $class->GetUsersAsc(); //ascending order of student's first names
	foreach($students as $s){			//for each user
		if($s->userType == 'Student'){	//if user is student
			$student_results[] = [		//add twig variable
				"name" => $s->firstName . " " . $s->lastName, //first + last name
				"id"   => $s->userID 						  //user ID

			];
		}
	}

	#enable these to see important information
	//echo '<pre>' . print_r($evaluation_results, TRUE) . '</pre>';

	echo $twig->render('instructor_class.html', [
		"username"        => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
		"className"       => $class->title,
		"assignments"	  => $assignment_results,
		//"evaluations"	  => $evaluation_results,
		"students"		  => $student_results,
		"classID"	 	  => $_SESSION['classID']
	]);

?>