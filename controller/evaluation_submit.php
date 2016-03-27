<?php
	//get user file
	require_once dirname(__FILE__) . "/../models/user.php";
	require_once dirname(__FILE__) . "/../models/assignment.php";
	session_start();

	$page = file_get_contents(dirname(__FILE__) . '/../views/evaluation_submit.html');
	

	//get evaluation info
	$eval = new Evaluation($_POST['evaluationID']);

	$evalDetails = "";

	$evalDetails .= '<div id="evaluation">';

	//get assignment
	$assignment = $eval->GetAssignment();

	//get critera set
	$criteria = $assignment->GetCriteria();

	//create section for each criteria
	foreach($criteria as $c){
		$evalDetails .= '<div class="criteria">';
		$evalDetails .= '<h3>'.$c->title.'</h3>';
		$evalDetails .= '<div>'.$c->description.'</div>';
		$evalDetails .= 'Strongly Disagree';
		$evalDetails .= '<input type="radio" name="agree">';
		$evalDetails .= 'Disagree';
		$evalDetails .= '<input type="radio" name="agree">';
		$evalDetails .= 'Neutral';
		$evalDetails .= '<input type="radio" name="agree">';
		$evalDetails .= 'Agree';
		$evalDetails .= '<input type="radio" name="agree">';
		$evalDetails .= 'Strongly Agree';
		$evalDetails .= '<input type="radio" name="agree">';
		$evalDetails .= '<input type="text" name="comments" placeholder="Comments">';
		$evalDetails .= '<input type="button" value="save"><input type="button" value="submit"></div>';
	}

	//get the html page ready to be displayed
	$page = str_replace('$firstName', $_SESSION['user']->firstName, $page);
	$page = str_replace('$evaluationInfo', $evalDetails, $page);
	echo $page;
?>