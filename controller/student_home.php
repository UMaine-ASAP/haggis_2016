<?php
require_once __DIR__ . "/../../system/bootstrap.php";

ensureLoggedIn();

//Build assignments
$assignments_results = array();

$classes = $_SESSION['user']->GetClasses();
$assignments = Array();
foreach ($classes as $class) {
	$assignments[] = $class->GetAssignments();
}
if ($assignments != array() ) {
	foreach ($assignments[0] as $assignment) {
		$assignments_results[] = [
			"id"    => $assignment[0]->assignmentID,
			"title" => $assignment[0]->title,
			"due"   => $assignment[1]
		];
	}
}

//build evaluations to do
$evaluationTodo_results = array();
$evaluations = $_SESSION['user']->GetEvaluations();

foreach($evaluations as $eval) {
	//This may not be a significant way of telling whether or not the evaluation is finished or not.
	// There should probably be a function to determine if any criteria within the evaluation do not have a filled rating.
	if($eval->done == 0){
		$e = new Evaluation($eval->evaluationID);

		$title = $e->getAssignment()->title;
		if ($e->evaluation_type=='Peer'){
			if($eval->target_userID != 0){
				$u = new User($eval->target_userID);
			}
			$title .= "Peer " . $u->firstName;
		} else {
			$title .= $e->GetGroup()->name;
		}

		$evaluationTodo_results[] = [
			"id"    => $eval->evaluationID,
			"title" => $title
		];
	}
}

//build received evaluations
$evaluationReceived_results = [];
$rec_evaluations = $_SESSION['user']->GetReceivedEvaluations();

foreach($rec_evaluations as $eval){
	if($eval->done == 1){
		$e = new Evaluation($eval->evaluationID);

		$evaluationReceived_results[] = [
			"id"    => $eval->evaluationID,
			"title" => $e->GetAssignment()->title . " " . $e->evaluation_type . "evaluation",
		];
	}
}

// render
echo $twig->render('student_home.html', [
	"username"            => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
	"assignments"         => $assignments_results,
	"evaluationsToDo"     => $evaluationTodo_results,
	"evaluationsReceived" => $evaluationReceived_results
	]);
