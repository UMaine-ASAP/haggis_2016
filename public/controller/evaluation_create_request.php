<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	//check if all fields are filled
	if(empty($_POST['postEvaluationTitle']) or empty($_POST['evaluationType'])
		or in_array("",$_POST['postCriteriaTitle']) or in_array("",$_POST['postOptionOne'])
		or in_array("",$_POST['postOptionTwo']) or in_array("",$_POST['postOptionThree'])
		or in_array("",$_POST['postOptionFour']) or in_array("",$_POST['postOptionFive'])){
		die('Did not submit all fields, try again.');
	}

	//create and setup basic evaluation object
	$evaluation = new Evaluation(0);
	$evaluation->done = 0;
	$evaluation->criteriaID = 1;
	$evaluation->evaluation_type = $_POST['evaluationType'];
	$evaluation->Save();

	$count = count($_POST['postCriteriaTitle']); //get number of criteria
	for($i = 0; $i < $count; $i++){							//for each criteria
		$criteria = new Criteria(0);						//create new criteria
		$criteria->title = $_POST['postCriteriaTitle'][$i];	//give title
		$criteria->Save();
	
		$selection = new Selection(0);							//create choice 1
		$selection->description = $_POST['postOptionOne'][$i];	//set choice 1's description
		$selection->Save();
		$criteria->AddSelection($selection->selectionID);		//add to criteria

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

		$selection = new Selection(0);							//create choice 5
		$selection->description = $_POST['postOptionFive'][$i];	//set choice 5's description
		$selection->Save();			
		$criteria->AddSelection($selection->selectionID);		//add to criteria

		$evaluation->AddCriteria($criteria->criteriaID);		//add criteria to evaluation
	}

	$current_assignment = new Assignment($_SESSION['assignmentID']); //get assignment
	$current_assignment->AddEvaluation($evaluation->evaluationID);	 //add evaluation to assignment

	header("location:instructor_home.php");
?>