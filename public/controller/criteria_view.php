<?php

	############NOTES#################
	/*
		This page controlls the viewing of criteria for an individual student
		when a bar is clicked related to that criteria.
		Currently, this is only implemented in cumulative_results.html

		When $criterion is pulled in from the popup, this is the structure
		Array
		(
			[0] => criterion ID
			[1] => criteria title
			[2] => description (usually empty)
			[3] => Array (
				[0] => selection A
				[1] => selection B
				...	
			)
			[4] => student's rating
			[5] => Array (
				[0] => comment A
				[1] => comment B
				...
			)
			[6] => assignment ID
			[7] => student ID
			[8] => criteria type (raw)
		)
	*/
	############FUNCTIONS#############

	############INCLUSIONS############
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	############DATA PROCESSING#######
	#Declarations
	$criterion = 0;

	#Checking to see what criteria is currently being viewed
	if(isset($_GET['tempVariables'])){
		$criterion = json_decode($_GET['tempVariables']);
	}

	#Checking the assignment and user this is for
	$assignment = new Assignment($criterion[6]);
	$student = new User($criterion[7]);

	#Checking the criteria type
	$type = '';
	if($criterion[8] == "individualCriteria"){
		$type = "Individual";
	}
	if($criterion[8] == "groupCriteria"){
		$type = "Group";
	}
	if($criterion[8] == "peerCriteria"){
		$type = "Peer";
	}

	#enable these to see important information
	//echo '<pre>' . print_r($criterion, TRUE) . '</pre>';
	//echo '<pre>' . print_r($_GET, TRUE) . '</pre>';

	############RENDERING#############
	echo $twig->render('criteria_view.html',[
		"username" 			=> $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
		"criterion"			=> $criterion,
		"studentName"		=> $student->firstName . " " . $student->lastName,
		"assignmentName"	=> $assignment->title,
		"type"				=> $type
		]);
?>