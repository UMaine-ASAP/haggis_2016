<?php
	//begin session
	session_start();

	//get user file
	require_once dirname(__FILE__) . "/../models/user.php";

	//get the html page ready to be displayed
	$page = file_get_contents(dirname(__FILE__) . '/../views/login.html');
	echo $page;
	
	if(isset($_POST['submitLogin'])){	//change submitLogin to the equivalent login.html file

		//get actual DB
		require_once dirname(__FILE__) . "/../system/database.php";
		$db = GetDB();

		//query for the user in the database
		$query = "SELECT * FROM `user` WHERE `email` = '" .  $_POST['postName'] . "' AND `password` = '" .  $_POST['postPassword'] . "';";
		$result = $db->query($query);
		//if found, set SESSION variables and go to correct home page
		if($result->num_rows != 0){
			$user = $result->fetch_array(MYSQLI_BOTH);
			$_SESSION['user'] = new User($user['userID']);
			$_SESSION['sessionCheck'] = 'true';
			if ($_SESSION['user']->userType == 'Student'){
				header("location:student_home.php");
			}
			else{
				header("location:instructor_home.php");	
			}
		}
		else {
			echo "Wrong Username/Password</br>Please try again.</br>";
		}
	}
?>