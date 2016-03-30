<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	// echo $twig->render('evaluation_submit.html');



	// //get evaluation info
	// $eval = new Evaluation($_POST['evaluationID']);

	// //get critera set
	// $criteria = $eval->GetCriteria();


	// $evalDetails = "";
	// $evalDetails .= '<div id="evaluation">';

	// $count = 0;
	// $evalDetails .= '<form method="get" action="evaluation_submit_request.php">';

	// //create section for each criteria
	// foreach($criteria as $c){
	// 	$count++;
	// 	$_SESSION['criteria' . $count] = $c->criteriaID;
	// 	$evalDetails .= '<h3>'.$c->title.'</h3>';
	// 	$evalDetails .= '<div>'.$c->description.'</div>';
	// 	$evalDetails .= 'Strongly Disagree';
	// 	$evalDetails .= '<input type="radio" name="c'. $count .'" value="1">';
	// 	$evalDetails .= 'Disagree';
	// 	$evalDetails .= '<input type="radio" name="c'. $count .'" value="2">';
	// 	$evalDetails .= 'Neutral';
	// 	$evalDetails .= '<input type="radio" name="c'. $count .'" value="3">';
	// 	$evalDetails .= 'Agree';
	// 	$evalDetails .= '<input type="radio" name="c'. $count .'" value="4">';
	// 	$evalDetails .= 'Strongly Agree';
	// 	$evalDetails .= '<input type="radio" name="c'. $count .'" value="5">';
	// 	$evalDetails .= '<input type="text" name="'. $count .'comments" placeholder="Comments">';
	// 	$evalDetails .= '<br><br>';
	// }
	// $evalDetails .= '<input type="submit" value="submit"></form>';

	// $_SESSION['evaluation'] = $_POST['evaluationID'];
	// $_SESSION['count'] = $count;

	// //get the html page ready to be displayed
	// $page = str_replace('$firstName', $_SESSION['user']->firstName, $page);
	// $type= $eval->evaluation_type;
	// if($type=='Peer'){
	// 	$page = str_replace('$evaluationName', $eval->GetAssignment()->title." ". $type, $page);
	// }
	// else{
	// 	$page = str_replace('$evaluationName', $eval->GetAssignment()->title." " . $eval->GetGroup()->name, $page);
	// }
	// $page = str_replace('$evaluationInfo', $evalDetails, $page);
	// echo $page;

?>