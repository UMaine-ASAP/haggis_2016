<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	$assignment_results = array();							//final Twig results
	$class = new Period($_SESSION['classID']);				//class object
	$assignments = $class->GetAssignments();				//get all assignments for class
	$rec_evals = $_SESSION['user']->GetReceivedEvaluations();	//get received evaluations


	foreach($assignments as $a){			//for each assignment

		//set group variables
		$overallGroup = array(); // 2D array, saves each criteria result 
		$countGroup = 0;		 //number of group evals
		$criteriaCountGroup = 0; //number of criteria per eval

		//set peer variables
		$overallPeer = array();	// 2D array, saves each criteria result
		$countPeer = 0;			//number of peer evals
		$criteriaCountPeer = 0;	//number of criteria per eval

		//set individual variables
		$overallIndividual = array();	// 2D array, saves each criteria result
		$countIndividual = 0;			//number of individual evals
		$criteriaCountIndividual = 0;	//number of criteria of eval

		foreach($rec_evals as $eval){	//for every received eval

			//get assignment ID
			$assignmentID = $eval->GetParentEvaluation()->GetAssignment()->assignmentID;

			//if received eval's assignment ID is this current assignment ID
			if($a[0]->assignmentID == $assignmentID){

				//check if eval type is group or peer or individual
				if($eval->evaluation_type == 'Group'){
					$criteria = $eval->GetCriteria();			//get criteria for eval
					$overallGroup[] = array();					//add index to group evals
					$criteriaCountGroup = count($criteria);		//get number of criteria for eval
					for($i = 0; $i < count($criteria); $i++){	//for each criteria of eval
						//get rating received for criteria and save to 2D array
						$overallGroup[$countGroup][] += $criteria[$i]->GetCriteriaRating($eval->evaluationID);
					}
					$countGroup++;
				}
				else if($eval->evaluation_type == 'Peer'){
					$criteria = $eval->GetCriteria();			//get criteria for eval
					$overallPeer[] = array();					//add index to group evals
					$criteriaCountPeer = count($criteria); 		//get number of criteria for eval
					for($i = 0; $i < count($criteria); $i++){	//for each criteria of eval
						//get rating received for criteria and save to 2D array
						$overallPeer[$countPeer][] += $criteria[$i]->GetCriteriaRating($eval->evaluationID);
					}
					$countPeer++;
				}
				else if($eval->evaluation_type == 'Individual'){
					$criteria = $eval->GetCriteria();			//get criteria for eval
					$overallIndividual[] = array();				//add index to group evals
					$criteriaCountIndividual = count($criteria);//get number of criteria for eval
					for($i = 0; $i < count($criteria); $i++){	//for each criteria of eval
						//get rating received for criteria and save to 2D array
						$overallIndividual[$countIndividual][] += $criteria[$i]->GetCriteriaRating($eval->evaluationID);
					}
					$countIndividual++;
				}
			}
		}

		//if there are any group evals
		if($countGroup > 0){

			//initialize final average results for group evals for this assignment
			$criteriaGroupFinal = array();	
			for ($i=0; $i < $criteriaCountGroup; $i++) { 
				$criteriaGroupFinal[] = 0;				 
			}

			//foreach group eval receieved
			foreach ($overallGroup as $criteria) {
				for ($i=0; $i < $criteriaCountGroup; $i++) { //foreach criteria
					$criteriaGroupFinal[$i] += $criteria[$i]; //add to running total of each criteria
				}
			}

			//for each criteria
			for ($i=0; $i < $criteriaCountGroup; $i++) { 

				//get average result for criteria
				//total of criteria ratings / total number of evals
				$criteriaGroupFinal[$i] = round($criteriaGroupFinal[$i]/$countGroup,1); 
			}

			$assignment_results[] = [							//add to twig variable
				"name"		=> $a[0]->title . " Group Results",	//assignment title + group results
				"id"		=> $a[0]->assignmentID,				//assignment ID
				"criteria" => $criteriaGroupFinal,				//final averages of criteria
				"criteriaCount" => $criteriaCountGroup			//total number of criteria
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
				"criteriaCount" => $criteriaCountIndividual
			];
		}
	}

	//get the html page ready to be displayed
	echo $twig->render('cumulative_results.html',[
			"username"    	=> $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
			"assignments"   => $assignment_results //name, id, result one-five
		]);

?>