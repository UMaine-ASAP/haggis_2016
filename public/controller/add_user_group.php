<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

    //make sure of correct fields
    if(empty($_POST['user_target']) OR empty($_POST['groupID']) AND $_POST['user_target'] == ""){
        die("Didn't provide userID and/or group id, try again.");
    }

    //get group
    $group = new Student_Group($_POST['groupID']);

    //get users in group
    $group_users = $group->GetUsers();

    //check if user is already in group
    foreach ($group_users as $u) {
    	if($u->userID == $_POST['user_target']){
    		die("Can't add same user to group");
    	}
    }

    //add user to group
    $group->AddUser($_POST['user_target']);


	header("location:instructor_assignment.php");
?>