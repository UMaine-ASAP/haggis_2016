<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	//get the html page ready to be displayed
	echo $twig->render('cumulative_results.html');


	// This controller should accept the class.




	// $class = $_POST["classID"];



	// Access a class by id

	// Get assignment
	// $assignment = new Assignment(1);
	// Get project submission by user






	// $page = str_replace('$evaluationsReceived', $evaluationsReceived, $page);
	echo $page;