<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();
	$evaluationID = $_POST["evaluationID"];
	
	// You need to send over the assignment id derived from the evaluation id so that the next view can
	// populate the dropdown with students/groups.
	// Of course for this to work by now the students need to be entered into their respective groups.
	echo $twig->render("student_create_evaluation.html");
