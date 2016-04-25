<?php
require_once __DIR__ . "/../../system/bootstrap.php";

ensureLoggedIn();

if($_SESSION['user']->userType == 'Student')
	header("location:student_home.php");

else if($_SESSION['user']->userType == 'Instructor')
	header("location:instructor_home.php");
?>