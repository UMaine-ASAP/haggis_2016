<?php
require_once __DIR__ . "/../../system/bootstrap.php";

if(isset($_SESSION['error']))
	$errNum = $_SESSION['error'];
else
	$errNum = 0;

if(isset($_SESSION['error-detailed']))
	$errDet = $_SESSION['error-detailed'];
else
	$errDet = " No Such Error Known ";

echo $twig->render('error_message.html',
	[
	"username"            => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
	"errorNum"         	  => $errNum,
	"errorMessage"        => $errDet
	]);
?>