<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	var_dump($_POST);
	//Get evaluation according to ID.
    $evaluation = new Evaluation($_SESSION["evaluationID"]);
    
	for ($i = 1; $i<=$_SESSION['count']; $i++){
		$criteriaID = $_POST['id'][$i];
		$rating = $_POST['selected'][$i];
		$comments = $_POST['comments'][$i];
		$evaluation->SaveCriteria($criteriaID,$rating,$comments);
	}

	$evaluation->done = 1;
	$evaluation->Save();
	header("location:student_home.php");
?>