<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	//if user is a student (not instructor) go back to login
	if($_SESSION['user']->userType == 'Student')
	{
		header("location:login.php");
	}

	//Build assignments
	$classes_results = array();    //classes to be displayed
	$assignment_results = array(); //assignments to be displayed

	$classes = $_SESSION['user']->GetClasses();	//classes associated to instructor
	
	//for each class
	foreach ($classes as $class) {
		$assignments = $class->GetAssignments();	//get assignments for class
		$titles = array();							
		$course = $class->courseID;					//get course id for class
		foreach($assignments as $a){				//get titles of assignments
			$titles[] = $a[0]->title;
		}

		$classes_results[] = [						//add to twig results
			"id"			   => $class->classID,	//class ID
			"className"    	   => $class->title,	//class title
			"assignmentNames"  => $titles			//assignment titles
		];
	}

	echo $twig->render('instructor_home.html', [
		"username"        => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
		"classes"         => $classes_results,
		"courseID"		  => $course
	]);

?>