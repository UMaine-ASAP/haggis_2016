<?php
	require_once __DIR__ . "/../system/bootstrap.php";
	require_once dirname(__FILE__) . "/../models/user.php";
	require_once dirname(__FILE__) . "/../models/assignment.php";
	require_once dirname(__FILE__) . "/../models/class.php";

ensureLoggedIn();
	echo 'Success';

	echo $twig->render('instructor_home.html');

    $className .= "hello";
?>