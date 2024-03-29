<?php
require_once __DIR__ . "/../../system/bootstrap.php";

//if register button was pressed on login
if (isset($_POST['submitRegister'])) {

	// Validate fields
	$data = $_POST;

	if ( empty($_POST['postFirstName'])) {
		$data['message'] = "First name is required.";
		echo $twig->render('register.html', $data);
		exit();
	}

	if ( empty($_POST['postLastName'])) {
		$data['message'] = "Last name is required.";
		echo $twig->render('register.html', $data);
		exit();
	}

	if ( empty($_POST['postEmail'])) {
		$data['message'] = "Email is required.";
		echo $twig->render('register.html', $data);
		exit();
	}

	if (!filter_var($_POST['postEmail'], FILTER_VALIDATE_EMAIL)) {
		$data['message'] = "Email is invalid.";
		echo $twig->render('register.html', $data);
		exit();
	}

	if (strlen($_POST['postPassword1']) < 6){
		$data['message'] = "Passwords must be at least 6 characters long.";
		echo $twig->render('register.html', $data);
		exit();
	}

	if ( empty($_POST['postPassword1']) || empty($_POST['postPassword2']) || $_POST['postPassword1'] != $_POST['postPassword2']){
		$data['message'] = "Passwords don't match.";
		echo $twig->render('register.html', $data);
		exit();
	}


	if ( empty($_POST['classID'])) {
		$data['message'] = "Class ID is required.";


		echo $twig->render('register.html', $data);
		exit();}

	
	//TURN THIS INTO A FUNCTION
	// Create 10 character salt.
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $salt = '';
    for ($i = 0; $i < 10; $i++) {
        $salt .= $characters[rand(0, $charactersLength - 1)];
    }

    //Combine salt with entered password then hash.
	$hashedPassword = hash("sha512", $_POST["postPassword1"].$salt,false);	

	//saves info into user object
	$user = new User(0);
	$user->firstName = $_POST['postFirstName'];
	$user->middleInitial = $_POST['postMiddle'];
	$user->lastName = $_POST['postLastName'];
	$user->userType = 'Student';
	$user->email = $_POST['postEmail'];
	$user->password = $hashedPassword;
	$user->salt = $salt;

	$class = new Period($_POST["classID"]);
	$class->AddUser($user->userID, $user->userType);



	//if successful save, means registration worked. check DB for result
	if ($user->Save() == FALSE) {
		$user->Delete();
		echo $twig->render('register.html', ['message' => 'Failed to register. Try again.']);
		exit();
	}

	$classForUser = new Period($_POST['postClassCode']);

	if ($classForUser->AddUser($user->userID, $user->userType) == FALSE)
	{
		// $data['message'] = "Error Adding To Class.";
		// $user->Delete();
		// echo $twig->render('register.html', $data);
		// exit();
	}

	// Success!
	header("location:login.php?message=Registration Successful!");
} else {
	echo $twig->render('register.html');
}
