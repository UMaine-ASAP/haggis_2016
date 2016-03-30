<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
 die("here");
ensureLoggedIn();

	//Build classes/assignments
	$classes_results = array();
	$classes = $_SESSION['user']->GetClasses();
	foreach ($classes as $class) {
		$classes_results[] = array($class->title,$class->GetAssignments());
	}

	echo $twig->render('instructor_home.html', [
		"username"            => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
		"classes"     		  => $classes_results
		]);
?>