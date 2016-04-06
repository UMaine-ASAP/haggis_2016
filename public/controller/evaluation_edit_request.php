<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

    if(empty($_POST['evaluationID'])){
        die('evaluationID not given');
    }

    $user = $_SESSION['user'];
    $eval = new Evaluation($_POST['evaluationID']);
    $criteria = $eval->GetCriteria();
    //create and save results of criteria results into evaluation_criteria table
	for ($i = 0; $i<=$_SESSION['count']-1; $i++){
		$criteriaID = $criteria[$i]->criteriaID;

		$rating = $_POST['selected'][$i];
		$comments = $_POST['comments'][$i]; 
		$eval->SaveCriteria($criteriaID,$rating,$comments);
	}

	header("location:student_home.php");
?>