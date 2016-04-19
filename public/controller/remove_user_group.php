<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

    if(empty($_POST['groupID']) or empty($_POST['studentID'])){
        die("Didn't provide groupID or studentID, try again.");
    }

    $group = new Student_Group($_POST['groupID']);
    $group->RemoveUser($_POST['studentID']);


	header("location:instructor_assignment.php");
?>