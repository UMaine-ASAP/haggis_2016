<?php

	############NOTES#################
	/*
		This page is used to display a group's score
		on a particular assignment.

		NOTE: Groups are assignment specific, so
		output what assignment the teacher is looking at
	*/
	############FUNCTIONS#############

	############INCLUSIONS############
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	############DATA PROCESSING#######
	//Get group members
	//From group, get assignment
	//From group, get received evaluations
	//From evaluations, determine criteria
	//From evaluations, calculate average scores for each criteria
	//

	#enable this to see important information
	//echo '<pre>' . print_r($_GET, TRUE) . '</pre>';
	//echo '<pre>' . print_r($assignmentData, TRUE) . '</pre>';
	//echo '<pre>' . print_r($evaluations[0]->GetCriteria()[0]->GetSelections(), TRUE) . '</pre>';


	############RENDERING#############
	echo $twig->render('cumulative_results.html',[
		"username" 			=> $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,

		]);

	#Assignment data is structured as assignmentData[assignmentID][criteria type][criterion][id/title/description/rating/comments]
	
?>