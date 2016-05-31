<?php
	//Requested URL : localhost:8888/haggis/haggis/public/api/user/login.php
	require_once dirname(__FILE__) . "/../../models/user.php"; //include user functions

	$user = new User(-1); //User with no user id to give

	//if request is POST and email and pass are given
	if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['email']) && isset($_POST['password'])){
		$user->Login($_POST['email'], $_POST['password']); //check for right credentials

		//if user entered correct credentials
		if($user->userID != -1){
			$json = array("status" => 1, "msg" => "Success", "userID" => $user->userID);
		}
		//incorrect credentials
		else{
			$json = array("status" => 0, "msg" => "Failed email or password");
		}

	}
	//incorrect request method
	else{
		$json = array("status" => 0, "msg" => "Request method not accepted");
	}

	//output as json
	header('Content-type: application/json');
	echo json_encode($json);
?>