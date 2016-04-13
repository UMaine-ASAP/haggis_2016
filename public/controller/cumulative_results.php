<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	$assignment_results = array();
	$class = new Period($_SESSION['classID']);
	$assignments = $class->GetAssignments();
	$rec_evals = $_SESSION['user']->GetReceivedEvaluations();


	foreach($assignments as $a){
		$overallGroup = [0,0,0,0,0];
		$countGroup = 0;
		$overallPeer = [0,0,0,0,0];
		$countPeer = 0;
		$overallIndividual = [0,0,0,0,0];
		$countIndividual = 0;

		foreach($rec_evals as $eval){
			$assignmentID = $eval->GetAssignment()->assignmentID;
			if($a[0]->assignmentID == $assignmentID){
				if($eval->evaluation_type == 'Group'){
					$criteria = $eval->GetCriteria();
					for($i = 0; $i < count($criteria)-1; $i++){
						$overallGroup[$i] += $criteria[$i]->GetCriteriaRating($eval->evaluationID);
					}
					$countGroup++;
				}
				else if($eval->evaluation_type == 'Peer'){
					$criteria = $eval->GetCriteria();
					for($i = 0; $i < count($criteria)-1; $i++){
						$overallPeer[$i] += $criteria[$i]->GetCriteriaRating($eval->evaluationID);
					}
					$countPeer++;
				}
				else if($eval->evaluation_type == 'Individual'){
					$criteria = $eval->GetCriteria();
					var_dump($criteria);
					for($i = 0; $i < count($criteria); $i++){
						$overallIndividual[$i] += $criteria[$i]->GetCriteriaRating($eval->evaluationID);
					}
					$countIndividual++;
					var_dump($overallIndividual); echo "<br>";
				}
			}
		}
		if($countGroup > 0){
			$assignment_results[] = [
				"name"		=> $a[0]->title . " Group Results",
				"id"		=> $a[0]->assignmentID,
				"resultOne" => round($overallGroup[0]/$countGroup,1),
				"resultTwo" => round($overallGroup[1]/$countGroup,1),
				"resultThree" => round($overallGroup[2]/$countGroup,1),
				"resultFour" => round($overallGroup[3]/$countGroup,1),
				"resultFive" => round($overallGroup[4]/$countGroup,1)
			];
		}
		if($countPeer > 0){
			$assignment_results[] = [
				"name"		=> $a[0]->title . " Peer Results",
				"id"		=> $a[0]->assignmentID,
				"resultOne" => round($overallPeer[0]/$countPeer,1),
				"resultTwo" => round($overallPeer[1]/$countPeer,1),
				"resultThree" => round($overallPeer[2]/$countPeer,1),
				"resultFour" => round($overallPeer[3]/$countPeer,1),
				"resultFive" => round($overallPeer[4]/$countPeer,1)
			];
		}
		if($countIndividual > 0){
			$assignment_results[] = [
				"name"		=> $a[0]->title . " Individual Results",
				"id"		=> $a[0]->assignmentID,
				"resultOne" => round($overallIndividual[0]/$countIndividual,1),
				"resultTwo" => round($overallIndividual[1]/$countIndividual,1),
				"resultThree" => round($overallIndividual[2]/$countIndividual,1),
				"resultFour" => round($overallIndividual[3]/$countIndividual,1),
				"resultFive" => round($overallIndividual[4]/$countIndividual,1)
			];
		}
	}




	//get the html page ready to be displayed
	echo $twig->render('cumulative_results.html',[
			"username"    	=> $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
			"assignments"   => $assignment_results //name, id, result one-five
		]);

?>