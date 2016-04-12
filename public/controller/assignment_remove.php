<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

    if(empty($_POST['assignmentID']) or empty($_SESSION['classID'])){
        die("Error, assignment ID or class ID not provided. Try again.");
    }


    $assignment = new Assignment($_POST['assignmentID']);
    $assignment->DeleteFromClass($_SESSION['classID']);

	header("location:instructor_home.php");
?>