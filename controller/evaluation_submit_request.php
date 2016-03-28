<?php
	require_once dirname(__FILE__) . "/../models/evaluation.php";
	require_once dirname(__FILE__) . "/../models/user.php";

	session_start();
	if($_SESSION['sessionCheck'] != 'true'){
			session_destroy();
			header("location:login.php");
	}

	$evaluation = $_SESSION['evaluation'];
	$count = $_SESSION['count'];

	for ($i = 1; $i<=$count; $i++){
		$eval = new Evaluation(-1);
		$eval->criteriaID = $_SESSION['criteria' . $i];
		$eval->rating = $_GET['c'.$i];
	 	$eval->comment = $_GET[$i. 'comments'];
		$eval->evaluatorID = $_SESSION['user']->userID;
		$eval->Add();
	}

	
?>