<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	$evaluation = new Evaluation($_SESSION['evaluation']);
	$count = $_SESSION['count'];

	for ($i = 1; $i<=$count; $i++){
		$criteria = new Criteria($_SESSION['criteria' . $i]);
		$criteria->rating = $_GET['c'.$i];
	 	$criteria->comment = $_GET[$i. 'comments'];
		$criteria->SaveResult();
	}
	$evaluation->done = 1;
	$evaluation->Save();
	header("location:student_home.php");
?>