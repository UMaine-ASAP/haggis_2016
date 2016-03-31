<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	var_dump($_POST);

	//Get evaluation according to ID.
	// $evaluation = new Evaluation($_POST["evaluationID"]);

	//Get key value arrays for both criteriaIDs => ratings and citeriaIDs => comments.
	$criteriaRatings = $_POST["criteriaRatings"];
	$criteriaComments = $_POST["criteriaComments"];


	// //Set rating for each criteria.
	// foreach ($criteriaRatings as $criteriaID => $value) {
	// 	$criteria = new Criteria($criteriaID);
	// 	$criteria->rating = $value;
	// 	$criteria->Save();
	// }

	// // //Set comment for each criteria.
	// foreach ($criteriaComments as $criteriaID => $value) {
	// 	$criteria = new Criteria($criteriaID);
	// 	$criteria->comment = $value;
	// 	$criteria->Save();
	// }

	
	

	// $count = $_SESSION['count'];

	// for ($i = 1; $i<=$count; $i++){
	// 	$criteria = new Criteria($_SESSION['criteria' . $i]);
	// 	$criteria->rating = $_GET['c'.$i];
	//  	$criteria->comment = $_GET[$i. 'comments'];
	// 	$criteria->SaveResult();
	// }
	// $evaluation->done = 1;
	// $evaluation->Save();
	// header("location:student_home.php");
?>