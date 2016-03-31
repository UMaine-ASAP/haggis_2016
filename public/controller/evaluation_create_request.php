<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	$evaluation = new Evaluation(0);
	$evaluation->done = 0;
	$evaluation->criteriaID = 1;
	$evaluation->evaluation_type = $_POST['evaluationType'];
	$evaluation->Save();

	$count = count($_POST['postCriteriaTitle']);
	for($i = 0; $i < $count; $i++){
		$criteria = new Criteria(0);
		$criteria->title = $_POST['postCriteriaTitle'][$i];
		$criteria->Save();
	
		$selection = new Selection(0);
		$selection->description = $_POST['postOptionOne'][$i];
		$selection->Save();
		$criteria->AddSelection($selection->selectionID);

		$selection = new Selection(0);
		$selection->description = $_POST['postOptionTwo'][$i];
		$selection->Save();
		$criteria->AddSelection($selection->selectionID);

		$selection = new Selection(0);
		$selection->description = $_POST['postOptionThree'][$i];
		$selection->Save();
		$criteria->AddSelection($selection->selectionID);

		$selection = new Selection(0);
		$selection->description = $_POST['postOptionFour'][$i];
		$selection->Save();
		$criteria->AddSelection($selection->selectionID);

		$selection = new Selection(0);
		$selection->description = $_POST['postOptionFive'][$i];
		$selection->Save();
		$criteria->AddSelection($selection->selectionID);

		$evaluation->AddCriteria($criteria->criteriaID);
	}

	$current_assignment = new Assignment($_SESSION['assignmentID']);
	$current_assignment->AddEvaluation($evaluation->evaluationID);

	header("location:instructor_home.php");
?>