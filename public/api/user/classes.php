<?php
	//Requested URL : localhost:8888/haggis/haggis/public/api/user/classes.php
	require_once dirname(__FILE__) . "/../../models/user.php"; //include user functions
	require_once dirname(__FILE__) . "/../../models/class.php"; //include class functions

	//if request is POST and email and pass are given
	if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_POST['userID'])){
		$user = new User($_GET['userID']); //make new user model

		//if there is a user with userID
		if($user->userID != -1){
			$classes = $user->GetClasses();					 //gets classes associated with user
			$json = array("status" => 1, "msg" => "Success") //start json
			$class_results = array();						 //setup class results for json

			foreach ($classes as $class) {
				//add index to class results for json
				$class_results[] = array("id" => $class->classID, "title" => $class->title);
			}
			$json[] = ["classes" => $class_results];
		}
		else{
			$json = array("status" => 0, "msg" => "Request userID incorrect");
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