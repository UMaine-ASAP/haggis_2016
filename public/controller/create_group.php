<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

    if(empty($_POST['assignmentID']) OR empty($_POST['groupNumber'])){
        die("Didn't provide assignmentID and/or group number, try again.");
    }

    $new_group = new Student_Group(0);

    $new_group->assignmentID = $_POST['assignmentID'];
    $new_group->groupNumber = $_POST['groupNumber'];
    $new_group->Save();


	header("location:instructor_assignment.php");
?>