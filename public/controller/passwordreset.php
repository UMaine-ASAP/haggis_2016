<?php

require_once __DIR__ . "/../../system/bootstrap.php";

echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';

echo $twig->render('passwordreset.html', [

]);



if(isset($_POST['postEmail'])){
	if($_POST['postEmail'] != null){
		echo "<br>The account associated with ".$_POST['postEmail']." has had its password reset. Please check your email for your new password.<br>";
		$returnFromFunction = User::ResetPassword();
		if (mail('matthewlanimates@gmail.com','Obama your lord and savior', 'Yeah this is just a test','matt@matt.com')){
			echo 'hello';
		}
		else{
			echo 'dammit';
		}
	}else{
		echo "<br>Your email address is required to reset your password.";
	}
}
?>
