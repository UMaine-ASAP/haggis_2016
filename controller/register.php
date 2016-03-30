<?php
	require_once __DIR__ . "/../system/bootstrap.php";

	//get user file
	require_once dirname(__FILE__) . "/../models/user.php";

	//get the html page ready to be displayed
	echo $twig->render('register.html');


	if(isset($_POST['submitRegister'])){	//change submitRegister to the equivalent register.html file
		//create new User object to work with
		$user = new User(0);

		//check if the passwords match, needs more checks
		if($_POST['postPassword1'] == $_POST['postPassword2']){

			//saves info into user object
			$user->firstName = $_POST['postFirstName'];
			$user->middleInitial = $_POST['postMiddle'];
			$user->lastName = $_POST['postLastName'];
			$user->userType = 'Student';
			$user->email = $_POST['postEmail'];
			$user->password = $_POST['postPassword1'];
		}
		else{
			echo "Passwords don't match.<br>";
		}

		//save user info into database
		$result = $user->Save();

		//if successful save, means registration worked. check DB for result
		if($result != FALSE){
			header("Location: register_success.php");
		}
		//else it didn't work, delete empty user from DB and restart
		else{
			$user->Delete();
			echo "Invalid data, try again.<br>";
		}
	}
?>