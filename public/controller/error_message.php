<?php
require_once __DIR__ . "/../../system/bootstrap.php";

echo $twig->render('error_message.html',
	[
	"username"            => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
	"errorNum"         	  => $_GET['error'],
	"errorMessage"        => $_GET['error-detailed']
	]);
?>