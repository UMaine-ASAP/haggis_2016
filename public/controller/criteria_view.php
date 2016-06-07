<?php

	############NOTES#################
	/*
		This page controlls the viewing of criteria for an individual student
		when a bar is clicked related to that criteria.
		Currently, this is only implemented in cumulative_results.html
	*/
	############FUNCTIONS#############

	############INCLUSIONS############
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	############DATA PROCESSING#######

	#enable these to see important information
	echo '<pre>' . print_r($_GET, TRUE) . '</pre>';

	############RENDERING#############
	echo $twig->render('criteria_view.html',[
		"username" 			=> $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName
		]);
?>