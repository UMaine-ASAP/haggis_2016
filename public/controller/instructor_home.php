<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	if($_SESSION['user']->userType == 'Student')
	{
		header("location:login.php");
	}

		//Build assignments
	$classes_results = array();
	$assignment_results = array();

	$classes = $_SESSION['user']->GetClasses();
	
	foreach ($classes as $class) {
		$count = 0;
		$assignments = $class->GetAssignments();
		$titles = array();
		foreach($assignments as $a){
			$titles[] = $a[0]->title;
		}

		$classes_results[] = [
			"id"			   => $class->classID,
			"className"    	   => $class->title,
			"assignmentNames"  => $titles
		];
	}

	echo $twig->render('instructor_home.html', [
		"username"        => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
		"classes"         => $classes_results
	]);

?>