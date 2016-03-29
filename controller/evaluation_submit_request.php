<?php
	require_once dirname(__FILE__) . "/../models/evaluation.php";
	require_once dirname(__FILE__) . "/../models/criteria.php";
	require_once dirname(__FILE__) . "/../models/user.php";

	session_start();
	if($_SESSION['sessionCheck'] != 'true'){
			session_destroy();
			header("location:login.php");
	}

	$evaluation = new Evaluation($_SESSION['evaluation']);
	$count = $_SESSION['count'];

	for ($i = 1; $i<=$count; $i++){
		$criteria = new Criteria($_SESSION['criteria' . $i]);
		$criteria->rating = $_GET['c'.$i];
	 	$criteria->comment = $_GET[$i. 'comments'];
		$criteria->SaveResult();
	}
	$evaluation->rating = 1;
	$evaluation->Save();
	header("location:student_home.php");
?>