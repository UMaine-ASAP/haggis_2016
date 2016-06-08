 <?php

require_once __DIR__ . "/../../system/bootstrap.php";

echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';


if(isset($_POST['postEmail'])){
	if($_POST['postEmail'] != null){
		
		$code = rand(100000,1000000000);
		
		echo $code;
		
		if(User::ResetPassword($code) === true){

		}else{

		}





		echo "<br>The account associated with ".$_POST['postEmail']." has had its password reset. Please check your email for stpes on resetting your password.<br>";


		$email = $_POST['postEmail'];
		$to = $_POST['postEmail'];
		$from = "support@haggis.com";
		$subject = "Password Reset";
		$body = "

		This is an auto generated email. Please DO NOT respond as the inbox is not monitored.


		Click the link below or paste it into your browser to reset your password.

		http://chitna.asap.um.maine.edu/haggis/public/controller/passwordreset.php?code=$code&email=$email

		";

		mail($to,$subject,$body,$from);
	}else{
		echo "<br>Your email address is required to reset your password.";
	}
}

//TWIG THINGS
echo $twig->render('passwordreset.html', [

]);

?>