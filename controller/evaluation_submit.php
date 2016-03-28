<?php
	session_start();
	if($_SESSION['sessionCheck'] != 'true'){
			session_destroy();
			header("location:login.php");
		}
	echo "evaluation to submit: " . $_POST['evaluationID'];
?>