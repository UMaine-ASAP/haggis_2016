<?php

	#Inclusions
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	#Data Processing
	echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
	echo '<pre>' . print_r($_POST, TRUE) . '</pre>';

	#Rendering page
	echo $twig->render('overall_results.html', [
		"username"        => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
	]);
?>