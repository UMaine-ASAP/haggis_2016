<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();
	// echo 'Success';

	if($_SESSION['user']->userType == 'Student')
	{
		header("location:login.php");
	}

	$class = new Period($_POST['classID']);
	//Build assignments
	$assignment_results = array();
	$assignments = $class->GetAssignments();
	foreach($assignments as $a){
		$assignment_results[] = [
			"name"			   => $a[0]->title,
			"dueDate"    	   => $a[1],
			"id"  			   => $a[0]->assignmentID
		];
	}

	//Build Evaluations
	$evaluation_results = array();

	foreach($assignments as $a){
		$evals = $a[0]->GetEvaluations();
		$e = array();
		$target = "";

		foreach($evals as $eval){
			$user = $eval->GetUser();
			if ($eval->evaluation_type=='Peer'){
				if($eval->target_userID != 0){
					$u = new User($eval->target_userID);
				}
				$target = "Peer " . $u->firstName;
			} 
			else {
				$target = "Group";//$eval->GetGroup()->name;
			}

			if($eval->done == 0){
				$target .= " - INCOMPLETE - " . $user->firstName . " " . $user->lastName; 
			}
			else{
				$target .= " - SUBMITTED - " . $user->firstName . " " . $user->lastName;
			}

			$e[] = [
				'target'		 => $target,
				'id'			 => $eval->evaluationID
			];
		
		}

		$evaluation_results[] = [
			'name'			 => $a[0]->title,
			'assigned'		 => $e
		];
	}

		//Build students
	$student_results = array();
	$students = $class->GetUsers();
	foreach($students as $s){
		if($s->userType == 'Student'){
			$student_results[] = $s->firstName . " " . $s->lastName;
		}
	}

	echo $twig->render('instructor_class.html', [
		"username"        => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
		"className"       => $class->title,
		"assignments"	  => $assignment_results,
		"evaluations"	  => $evaluation_results,
		"students"		  => $student_results
	]);

?>