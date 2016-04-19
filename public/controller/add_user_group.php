<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

    if(empty($_POST['user_target']) OR empty($_POST['groupID'])){
        die("Didn't provide userID and/or group id, try again.");
    }

    $group = new Student_Group($_POST['groupID']);

    $group->AddUser($_POST['user_target']);


	header("location:instructor_assignment.php");
?>