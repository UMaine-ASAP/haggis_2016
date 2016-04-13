<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

    $user = $_SESSION['user'];
    $new_eval = new Evaluation(0);

    $user->AddEvaluation($new_eval->evaluationID);

    //check if either group or peer eval
    if(!empty($_SESSION['group_target'])){
    	$new_eval->evaluation_type = 'Group';
    	$new_eval->done = 1;
    	$new_eval->groupID = $_SESSION['group_target'];
    	unset($_SESSION['group_target']);
    }
    else if(!empty($_SESSION['peer_target'])){
    	$new_eval->evaluation_type = 'Peer';
    	$new_eval->done = 1;
    	$new_eval->target_userID = $_SESSION['peer_target'];
    	unset($_SESSION['peer_target']);
    }
    else if(!empty($_SESSION['individual_target'])){
        $new_eval->evaluation_type = 'Individual';
        $new_eval->done = 1;
        $new_eval->target_userID = $_SESSION['individual_target'];
        unset($_SESSION['individual_target']);
    }
    
    //create and save results of criteria results into evaluation_criteria table
	for ($i = 1; $i<=$_SESSION['count']; $i++){
		$criteriaID = $_POST['id'][$i];
		$new_eval->AddCriteria($criteriaID);

		$rating = $_POST['selected'][$i];
		$comments = $_POST['comments'][$i];
		$new_eval->SaveCriteria($criteriaID,$rating,$comments);
	}

	//save eval results
	//add to parent_child evals
	$new_eval->Save();
	$parent_eval = new Evaluation($_SESSION['evaluationID']);
	$parent_eval->AddChildEvaluation($new_eval->evaluationID);

    $assignment = new Assignment($_SESSION['assignmentID']);
    $assignment->AddEvaluation($new_eval->evaluationID);

	header("location:student_home.php");
?>