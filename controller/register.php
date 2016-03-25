<?php
	//get user file
	require_once dirname(__FILE__) . "/../models/user.php";

	//get the html page ready to be displayed
	$page = file_get_contents(dirname(__FILE__) . '/../views/register.html');

	echo $page;
	

	if(isset($_POST['submitRegister'])){	//change submitRegister to the equivalent register.html file
		$user = new User(0);
		$user->firstName = 
	}
?>