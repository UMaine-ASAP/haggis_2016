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
$criteria_ids = [];

$rec_evaluations = $_SESSION['user']->GetReceivedEvaluations();

$parentEvaluation = $rec_evaluations[0]->GetParentEvaluation();

$e = new Evaluation($parentEvaluation->evaluationID);

$criterias = $e->GetCriteria();
foreach($criterias as $key=>$criteria)
{
	$criteria_ids[] =
	[
		"citeriaID".$key	=> $criteria->criteriaID
	];
}

$totalCriteriaResults = array();

foreach ($rec_evaluations as $eval)
{
	if($eval->done == 1)
	{
		$e = new Evaluation($eval->evaluationID);
		foreach ($criterias as $key=>$criteria)
		{
			$thisRating = $criteria->GetCriteriaRating($e->evaluationID);
			$totalCriteriaResults[] = $thisRating;
		}
	}
}

$criteriaTotal = 0;
foreach ($rec_evaluations as $eval)
{
	if($eval->done == 1)
	{
		$e = new Evaluation($eval->evaluationID);
		foreach ($criterias as $key=>$criteria)
		{
			$criteriaTotal = $criteriaTotal+1;
		}
	}
}

$criteriaLoop = 0;
foreach ($rec_evaluations as $key=>$eval)
{
	for($i = 0; $i < $criteriaTotal;$i++)
	{
		$index = $i + $criteriaLoop;
		if(isset(${"criteria$i"}))
		{
			${"criteria$i"} += $totalCriteriaResults[$index];
		}
		else
		{
			${"criteria$i"} = $totalCriteriaResults[$index];
		}	
	}
	$criteriaLoop += $criteriaTotal;
}

for($i = 0; $i < $criteriaTotal;$i++)
{
	${"avgCriteriaRating$i"} = ${"criteria$i"}/($key+1);
}

for($i = 0; $i < $criteriaTotal; $i++)
{
	$allTheRatingsAveraged[] =
	[
		${"avgCriteriaRating$i"}
	];
}
var_dump($allTheRatingsAveraged);
die();

echo $twig->render('cumulative_results_student.html', [
	"username"      		=> $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
	"assignments"			=> $assignments,
	"criterias"				=> $criteria_ids,
	"ratings"				=> $allTheRatingsAveraged
	]);
?>