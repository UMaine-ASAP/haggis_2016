<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();
	// echo 'Success';

	if($_SESSION['user']->userType == 'Student')
	{
		header("location:login.php");
	}

	//Build assignments
	$classes_results = array();
	$assignment_results = array();

	$classes = $_SESSION['user']->GetClasses();
	
	foreach ($classes as $class) {
		$assignments = $class->GetAssignments();
		$titles = array();
		$course = $class->courseID;
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
		"classes"         => $classes_results,
		"courseID"		  => $course
	]);

?>