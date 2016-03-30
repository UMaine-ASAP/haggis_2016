<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();
	echo 'Success';

	echo $twig->render('instructor_home.html');

    $className .= "hello";
?>