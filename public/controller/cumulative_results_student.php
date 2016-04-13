<?php
require_once __DIR__ . "/../../system/bootstrap.php";

ensureLoggedIn();

$classes = $_SESSION['user']->GetClasses();

$assignments = Array();

foreach ($classes as $class)
{
	if($class->classID == $_SESSION['classID'])
	{
		$assignments[] = $class->GetAssignments();
	}
}

$evaluationReceived_results = [];
$criteria_ids = [];

$rec_evaluations = $_SESSION['user']->GetReceivedEvaluations();

foreach ($rec_evaluations as $eval)
{
	if($eval->done == 1)
	{
		$e = new Evaluation($eval->evaluationID);
		
		$criterias = $e->GetCriteria();
		foreach($criterias as $key=>$criteria)
		{
			$criteria_ids[] =
			[
				"citeriaID".$key	=> $criteria->criteriaID
			];
		}
	}
}

foreach ($rec_evaluations as $eval)
{
	if($eval->done == 1)
	{
		$e = new Evaluation($eval->evaluationID);
		
	}
}

echo $twig->render('cumulative_results_student.html', [
	"username"      		=> $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
	"assignments"			=> $assignments,
	"criterias"				=> $criteria_ids,
	"evaluationsReceived"	=> $evaluationReceived_results
	]);
?>