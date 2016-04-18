<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

    if(empty($_POST['groupID'])){
        die("Didn't provide groupID, try again.");
    }

    $group = new Student_Group($_POST['groupID']);
    $users = $group->GetUsers();
    foreach ($users as $u) {
        $group->RemoveUser($u->userID);
    }
    $group->Delete();


	header("location:instructor_assignment.php");
?>