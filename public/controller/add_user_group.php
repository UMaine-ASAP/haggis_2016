<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

    if(empty($_POST['user_target']) OR empty($_POST['groupID']) AND $_POST['user_target'] == ""){
        die("Didn't provide userID and/or group id, try again.");
    }

    $group = new Student_Group($_POST['groupID']);

    $group_users = $group->GetUsers();
    foreach ($group_users as $u) {
    	if($u->userID == $_POST['user_target']){
    		die("Can't add same user to group");
    	}
    }

    $group->AddUser($_POST['user_target']);


	header("location:instructor_assignment.php");
?>