<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	$assignment_results = array();
	$class = new Period($_SESSION['classID']);
	$assignments = $class->GetAssignments();

	if($_GET['studentID'] != '') $user = new User(intval($_GET['studentID']));

	$rec_evals = $user->GetReceivedEvaluations();


	foreach($assignments as $a){
		$overallGroup = array();
		$countGroup = 0;
		$criteriaCountGroup = 0;

		$overallPeer = array();
		$countPeer = 0;
		$criteriaCountPeer = 0;

		$overallIndividual = array();
		$countIndividual = 0;
		$criteriaCountIndividual = 0;

		$commentsGroup = array();
		$commentsPeer= array();
		$commentsIndividual= array();

		foreach($rec_evals as $eval){
			$assignmentID = $eval->GetParentEvaluation()->GetAssignment()->assignmentID;
			if($a[0]->assignmentID == $assignmentID){
				if($eval->evaluation_type == 'Group'){
					$criteria = $eval->GetCriteria();
					$overallGroup[] = array();
					$criteriaCountGroup = count($criteria);
					for($i = 0; $i < count($criteria); $i++){
						$overallGroup[$countGroup][] += $criteria[$i]->GetCriteriaRating($eval->evaluationID);

						if($criteria[$i]->GetCriteriaComments($eval->evaluationID) != ''){
							$new_comment = "Criteria " . ($i + 1) . ": " . $criteria[$i]->GetCriteriaComments($eval->evaluationID);
							$new_comment .= " ----- Score: " . $criteria[$i]->GetCriteriaRating($eval->evaluationID);
							$commentsGroup[] = $new_comment;
						}
					}
					$countGroup++;
				}
				else if($eval->evaluation_type == 'Peer'){
					$criteria = $eval->GetCriteria();
					$overallPeer[] = array();
					$criteriaCountPeer = count($criteria);
					for($i = 0; $i < count($criteria); $i++){
						$overallPeer[$countPeer][] += $criteria[$i]->GetCriteriaRating($eval->evaluationID);
						if($criteria[$i]->GetCriteriaComments($eval->evaluationID) != ''){
							$new_comment = "Criteria " . ($i + 1) . ": " . $criteria[$i]->GetCriteriaComments($eval->evaluationID);
							$new_comment .= " ----- Score: " . $criteria[$i]->GetCriteriaRating($eval->evaluationID);
							$commentsPeer[] = $new_comment;
						}

					}
					$countPeer++;
				}
				else if($eval->evaluation_type == 'Individual'){
					$criteria = $eval->GetCriteria();
					$overallIndividual[] = array();
					$criteriaCountIndividual = count($criteria);
					for($i = 0; $i < count($criteria); $i++){
						$overallIndividual[$countIndividual][] += $criteria[$i]->GetCriteriaRating($eval->evaluationID);
						if($criteria[$i]->GetCriteriaComments($eval->evaluationID) != ''){
							$new_comment = "Criteria " . ($i + 1) . ": " . $criteria[$i]->GetCriteriaComments($eval->evaluationID);
							$new_comment .= " ----- Score: " . $criteria[$i]->GetCriteriaRating($eval->evaluationID);
							$commentsIndividual[] = $new_comment;
						}

					}
					$countIndividual++;
				}
			}
		}
		if($countGroup > 0){
			$criteriaGroupFinal = array();
			for ($i=0; $i < $criteriaCountGroup; $i++) { 
				$criteriaGroupFinal[] = 0;
			}
			foreach ($overallGroup as $criteria) {
				for ($i=0; $i < $criteriaCountGroup; $i++) { 
					$criteriaGroupFinal[$i] += $criteria[$i];
				}
			}
			for ($i=0; $i < $criteriaCountGroup; $i++) { 
				$criteriaGroupFinal[$i] = round($criteriaGroupFinal[$i]/$countGroup,1);
			}

			$assignment_results[] = [
				"name"		=> $a[0]->title . " Group Results",
				"id"		=> $a[0]->assignmentID,
				"criteria"  => $criteriaGroupFinal,
				"comments"  => $commentsGroup,
				"criteriaCount" => $criteriaCountGroup
			];
		}
		if($countPeer > 0){
			$criteriaPeerFinal = array();
			for ($i=0; $i < $criteriaCountPeer; $i++) { 
				$criteriaPeerFinal[] = 0;
			}
			foreach ($overallPeer as $criteria) {
				for ($i=0; $i < $criteriaCountPeer; $i++) { 
					$criteriaPeerFinal[$i] += $criteria[$i];
				}
			}
			for ($i=0; $i < $criteriaCountPeer; $i++) { 
				$criteriaPeerFinal[$i] = round($criteriaPeerFinal[$i]/$countPeer,1);
			}

			$assignment_results[] = [
				"name"		=> $a[0]->title . " Peer Results",
				"id"		=> $a[0]->assignmentID,
				"criteria" => $criteriaPeerFinal,
				"comments"  => $commentsPeer,
				"criteriaCount" => $criteriaCountPeer
			];
		}
		if($countIndividual > 0){
			$criteriaIndividualFinal = array();
			for ($i=0; $i < $criteriaCountIndividual; $i++) { 
				$criteriaIndividualFinal[] = 0;
			}
			foreach ($overallIndividual as $criteria) {
				for ($i=0; $i < $criteriaCountIndividual; $i++) { 
					$criteriaIndividualFinal[$i] += $criteria[$i];
				}
			}
			for ($i=0; $i < $criteriaCountIndividual; $i++) { 
				$criteriaIndividualFinal[$i] = round($criteriaIndividualFinal[$i]/$countIndividual,1);
			}

			$assignment_results[] = [
				"name"		=> $a[0]->title . " Individual Results",
				"id"		=> $a[0]->assignmentID,
				"criteria" => $criteriaIndividualFinal,
				"comments"  => $commentsIndividual,
				"criteriaCount" => $criteriaCountIndividual
			];
		}
	}




	//get the html page ready to be displayed
	echo $twig->render('cumulative_results.html',[
			"username"    	=> $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
			"name"			=> $user->firstName . " " . $user->lastName,
			"assignments"   => $assignment_results //name, id, result one-five
		]);

?>