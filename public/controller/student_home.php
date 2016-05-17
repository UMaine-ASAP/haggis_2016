<?php
require_once __DIR__ . "/../../system/bootstrap.php";

ensureLoggedIn();

//Build assignments
$assignments_results = array();

$classes = $_SESSION['user']->GetClasses(); 	//get all of student's classes
$assignments = Array();							//setup assignment array

foreach ($classes as $class) {					//for every class
	$assignments[] = $class->GetAssignments();	//get assignments for class
	$_SESSION['classID'] = $class->classID;		//set classID for session
}

if ($assignments != array() ) {					//if there are assignments for student
	foreach ($assignments[0] as $assignment) {	//go through each assignment
		$assignments_results[] = [				//set Twig variables for displaying assignments
			"id"    => $assignment[0]->assignmentID,	//assignment id
			"title" => $assignment[0]->title,			//assignment title
			"due"   => $assignment[1]					//assignment due date
		];
	}
}

//build evaluations to do
//scrapped due to redesign
$evaluationTodo_results = array();
$evaluations = $_SESSION['user']->GetEvaluations();

foreach($evaluations as $eval) {

	// if($eval->done == 0){
	// 	$e = new Evaluation($eval->evaluationID);

	// 	$title = $e->GetAssignment()->title." ";
	// 	// if ($e->evaluation_type=='Peer'){
	// 	// 	if($eval->target_userID != 0){
	// 	// 		$u = new User($eval->target_userID);
	// 	// 	}
	// 	// 	$title .= "Peer " . $u->firstName;
	// 	// } else {
	// 	// 	$title .= "Group ";//$e->GetGroup()->name;
	// 	// }

	// 	$evaluationTodo_results[] = [
	// 		"id"    => $eval->evaluationID,
	// 		"title" => $title
	// 	];
	// }
}

//build received evaluations
$evaluationReceived_results = [];		//setup Twig results for received evaluations
$rec_evaluations = $_SESSION['user']->GetReceivedEvaluations();	//get all evaluations targeted at student

foreach($rec_evaluations as $eval){					//for each evaluation received
	if($eval->done == 1){							//if it's complete
		$evaluationReceived_results[] = [			//add to Twig results 
			"id"    => $eval->evaluationID,			//evaluation id
			"title" => $eval->GetParentEvaluation()->GetAssignment()->title . " - " . $eval->evaluation_type //evaluation title: assignment title + eval type
		];
	}
}

// render
echo $twig->render('student_home.html', [
	"username"            => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
	"id"				  => $_SESSION['user']->userID,
	"assignments"         => $assignments_results,
	"evaluationsToDo"     => $evaluationTodo_results,
	"evaluationsReceived" => $evaluationReceived_results
	]);
?>