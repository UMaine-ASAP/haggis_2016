<?php
	require_once __DIR__ . "/../../system/bootstrap.php";

	//check if there is a message in URL (comes from register page)
	if (isset($_GET['message'])) {
		echo $twig->render('login.html', ['message' => $_GET['message']]);
	} else {
		echo $twig->render('login.html');
	}

	//get the html page ready to be displayed
	if(isset($_POST['submitLogin'])){	//change submitLogin to the equivalent login.html file

		$user = new User(-1); //User with no user id to give
		$user->Login($_POST['postName'], $_POST['postPassword']); //check for right credentials

		//if correct credentials, set SESSION variables and go to correct home page
		if($user->userID != -1){
			$_SESSION['user'] = $user;
			$_SESSION['sessionCheck'] = 'true';
			if ($_SESSION['user']->userType == 'Student'){
				//if user is student, go to student home
				header("location:student_home.php");
			}
			else{
				//if user is instructor, go to instructor home
				header("location:instructor_home.php");
			}
		}
		else {
			//if credentials are wrong, tell user
			echo "<div align = 'center'> <p style='color:red;'>"."Wrong Username/Password</br>Please try again.</br>"."</p> </div>";
		}
	}
?>