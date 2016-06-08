 <?php

require_once __DIR__ . "/../../system/bootstrap.php";

//Reset password things
if(!isset($_GET['code']) && !isset($_GET['email']))
{
	echo "
		<p>If you have forgotten your password enter your email. You will have instructions emailed to you.</p>
		<form method='POST' name='password_reset'>
			<input type='text' name='postEmail' placeholder='Registered Email'/>
			<input type='submit' name='submitPasswordReset' value='Submit'></input>
		</form>
	";
	if(isset($_POST['postEmail'])){
		if($_POST['postEmail'] != null){
			
			$code = rand(100000,1000000000);
			
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
}
//verify reset password er... part 2?
if(isset($_GET['code']) && isset($_GET['email'])){
	$code = $_GET['code'];
	$email = $_GET['email'];
	
	if(User::ConfirmResetPassword($code,$email) === true){
		echo "
		<form method='post' name='password_reset_complete'>
			Enter a new password<br><input type='password' name='newpassword'/><br>
			Re-enter your password<br><input type='password' name='newpassword1'/><br>
			<input type='submit' value='Update Password'>
		</form>
		";
	}else{
		echo "ERRORs";
	}
}

if(isset($_POST['newpassword']) && $_POST['newpassword1']){
	if($_POST['newpassword'] != null && $_POST['newpassword1'] != null){
 		if($_POST['newpassword'] === $_POST['newpassword1']){
 			//push information to DB

 		}
 		else
 		{
 			echo "Passwords must match";
 		}
	}
	else
	{
		echo "Passwords must not be null";
	}
}



//TWIG THINGS
echo $twig->render('passwordreset.html', [

]);

//$_GET["name"]
?>