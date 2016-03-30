<?php
	require_once __DIR__ . "/../system/bootstrap.php";
	//get user file
	require_once dirname(__FILE__) . "/../models/user.php";
	require_once dirname(__FILE__) . "/../models/criteria.php";

	ensureLoggedIn();

	$page = file_get_contents(dirname(__FILE__) . '/../views/evaluation_view.html');


	//get evaluation info
	$eval = new Evaluation($_POST['evaluationID']);

	//get critera set
	$criteria = $eval->GetCriteria();


	$evalDetails = "";
	$evalDetails .= '<div id="evaluation">';

	$count = 0;
	$evalDetails .= '<form action="student_home.php">';

	//create section for each criteria
	foreach($criteria as $c){
		$count++;
		$_SESSION['criteria' . $count] = $c->criteriaID;
		$evalDetails .= '<h3>'.$c->title.'</h3>';
		$evalDetails .= '<div>'.$c->description.'</div>';

//////////////////////////////////////////////////////////
		$evalDetails .= 'Strongly Disagree';
		if($c->rating == 1){
			$evalDetails .= '<input type="radio" name="c'. $count .'" value="1" checked>';
		}
		else{
			$evalDetails .= '<input type="radio" name="c'. $count .'" value="1" disabled>';
		}
//////////////////////////////////////////////////////////
		$evalDetails .= 'Disagree';
		if($c->rating == 2){
			$evalDetails .= '<input type="radio" name="c'. $count .'" value="2" checked>';
		}

		else{
			$evalDetails .= '<input type="radio" name="c'. $count .'" value="2" disabled>';
		}
//////////////////////////////////////////////////////////
		$evalDetails .= 'Neutral';
		if($c->rating == 3){
			$evalDetails .= '<input type="radio" name="c'. $count .'" value="3" checked>';
		}
		else{
			$evalDetails .= '<input type="radio" name="c'. $count .'" value="3" disabled>';
		}
//////////////////////////////////////////////////////////
		$evalDetails .= 'Agree';
		if($c->rating == 4){
			$evalDetails .= '<input type="radio" name="c'. $count .'" value="4" checked>';
		}
		else{
			$evalDetails .= '<input type="radio" name="c'. $count .'" value="4" disabled>';
		}
//////////////////////////////////////////////////////////
		$evalDetails .= 'Strongly Agree';
		if($c->rating == 5){
			$evalDetails .= '<input type="radio" name="c'. $count .'" value="5" checked>';
		}
		else{
			$evalDetails .= '<input type="radio" name="c'. $count .'" value="5" disabled>';
		}


		$evalDetails .= '<input type="text" name="'. $count .'comments" value="'.$c->comment.'">';
		$evalDetails .= '<br><br>';
	}
	$evalDetails .= '<input type="submit" value="Home"></form>';

	$_SESSION['evaluation'] = $_POST['evaluationID'];
	$_SESSION['count'] = $count;

	//get the html page ready to be displayed
	$page = str_replace('$firstName', $_SESSION['user']->firstName, $page);
	$page = str_replace('$evaluator', $eval->GetUser()->firstName, $page);
	$page = str_replace('$evaluationInfo', $evalDetails, $page);
	$type= $eval->evaluation_type;
	if($type=='Peer'){
		$page = str_replace('$evaluationName', $eval->GetAssignment()->title." ". $type, $page);
	}
	else{
		$page = str_replace('$evaluationName', $eval->GetAssignment()->title." " . $eval->GetGroup()->name, $page);
	}
	echo $page;
?>