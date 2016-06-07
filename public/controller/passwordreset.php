<?php

require_once __DIR__ . "/../../system/bootstrap.php";
echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';

echo $twig->render('passwordreset.html', [

]);



if(isset($_POST['postEmail'])){
	if($_POST['postEmail'] != null){
		echo "<br>The account associated with ".$_POST['postEmail']." has had its password reset. Please check your email for your new password.<br>";
		$user = User(-1);
		$returnFromFunction = $user->ResetPassword();
		mail('endlessxaura@gmail.com','Obama your lord and savior', 'Yeah this is just a test','obama@usa.gov');
	}else{
		echo "<br>Your email address is required to reset your password.";
	}
}

?>