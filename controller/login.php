<?php
	//begin session
	session_start();

	//get user file
	require_once dirname(__FILE__) . "/../models/user.php";
	//get the html page ready to be displayed
	$page = file_get_contents(dirname(__FILE__) . '/../views/login.html');
	echo $page;

	if(isset($_POST['submitLogin'])){	//change submitLogin to the equivalent login.html file

		$user = new User(-1); //User with no user id to give
		$user->User_Login($_POST['postName'], $_POST['postPassword']); //check for right credentials

		//if correct credentials, set SESSION variables and go to correct home page
		if($user->userID != -1){
			$_SESSION['user'] = $user;
			$_SESSION['sessionCheck'] = 'true';
			if ($_SESSION['user']->userType == 'Student'){
				header("Location: student_home.php");
				exit;
			}
			else{
				header("Location: instructor_home.php");	
			}
		}
		else {
			echo "Wrong Username/Password</br>Please try again.</br>";
		}
	}
?>