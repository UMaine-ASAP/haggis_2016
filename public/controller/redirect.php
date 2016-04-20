<?php
require_once __DIR__ . "/../../system/bootstrap.php";

ensureLoggedIn();

if(isset($_GET['error']) && isset($_GET['error-detailed']))
{
	header("location:error_message.php");
}

else if($_SESSION['user']->userType == 'Student')
	header("location:student_home.php");

else if($_SESSION['user']->userType == 'Instructor')
	header("location:instructor_home.php");
?>