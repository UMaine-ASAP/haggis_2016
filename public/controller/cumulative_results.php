<?php

	############NOTES#################
	/*
		This page is used to display a single student's
		ratings over all assignments he or she has done
	*/
	############FUNCTIONS#############

	############INCLUSIONS############
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	############DATA PROCESSING#######
	#Fetching data from database
	$student = new User($_GET['studentID']);
	$class = new Period($_SESSION['classID']);
	$assignments = $class->GetAssignments();
	$evaluations = $student->GetReceivedEvaluations();

	#For each assignment, creates a 3 dimensional array
	#assignmentData[assignmentID][criteria][score]
	$assignmentData = array();
	foreach ($assignments as $assignment){
		$groups = $assignment[0]->GetGroups();
		$groupCriteria = 0;
		$peerCriteria = 0;
		$individualCriteria = 0;
		$assignmentData[$assignment[0]->assignmentID] = array();

		#for each evaluation, pulls the needed criteria
		if ($groups != array()){
			$flag = 0;
			foreach ($groups as $group){
				$groupMembers = $group->GetUsers();
				foreach ($groupMembers as $groupMember){
					if ($groupMember == $student){
						$assignmentData[$assignment[0]->assignmentID]['group'] = $groupMembers;
					}
				}
			}
			foreach ($evaluations as $evaluation){
				if (!is_array($groupCriteria) && $evaluation->evaluation_type == 'Group' && $assignment[0]->assignmentID == $evaluation->GetAssignment()->assignmentID){
					$groupCriteria = $evaluation->GetCriteria();
					$flag++;
					if($flag == 2){
						break;
					}
				}
				else if (!is_array($peerCriteria) && $evaluation->evaluation_type == 'Peer' && $assignment[0]->assignmentID == $evaluation->GetAssignment()->assignmentID){
					$peerCriteria = $evaluation->GetCriteria();
					$flag++;
					if($flag == 2){
						break;
					}
				}
			}
		}
		else{
			foreach ($evaluations as $evaluation){
				if (!is_array($individualCriteria) && $assignment[0]->assignmentID == $evaluation->GetAssignment()->assignmentID){
					$individualCriteria = $evaluation->GetCriteria();
					break;
				}
			}
		}

		#for each criteria, places it as an array within the assignment's array
		#This is structured as [criteria][criterion][id/title/description/rating/comments]
		#note that comments is an array
		if(is_array($groupCriteria)){
			$assignmentData[$assignment[0]->assignmentID]['groupCriteria'] = $groupCriteria;
			$criteriaCounter = 0;
			foreach ($assignmentData[$assignment[0]->assignmentID]['groupCriteria'] as &$criterion){
				#saving object properties
				$criterionID = $criterion->criteriaID;
				$criterionTitle = $criterion->title;
				$criterionDescription = $criterion->description;
				$criterionSelections = $criterion->GetSelections();
				#loading object properties into an array
				$criterion = array();
				$criterion['id'] = $criterionID;
				$criterion['title'] = $criterionTitle;
				$criterion['description'] = $criterionDescription;
				$criterion['selections'] = array();
				foreach ($criterionSelections as $selection){
					$criterion['selections'][$selection->selectionID] = $selection->description;
				}
				$criterion['rating'] = 0;
				$criterion['comments'] = array();
				$criteriaCounter += 1;
			}
			$assignmentData[$assignment[0]->assignmentID]['groupCriteria']['numberOfCriteria'] = $criteriaCounter;
			$assignmentData[$assignment[0]->assignmentID]['groupCriteria']['numberOfEvals'] = 0;
			$assignmentData[$assignment[0]->assignmentID]['groupCriteria']['type'] = 'group';
		}
		if(is_array($peerCriteria)){
			$assignmentData[$assignment[0]->assignmentID]['peerCriteria'] = $peerCriteria;
			$criteriaCounter = 0;
			foreach ($assignmentData[$assignment[0]->assignmentID]['peerCriteria'] as &$criterion){
				#saving object properties
				$criterionID = $criterion->criteriaID;
				$criterionTitle = $criterion->title;
				$criterionDescription = $criterion->description;
				$criterionSelections = $criterion->GetSelections();
				#loading object properties into an array
				$criterion = array();
				$criterion['id'] = $criterionID;
				$criterion['title'] = $criterionTitle;
				$criterion['description'] = $criterionDescription;
				$criterion['selections'] = array();
				foreach ($criterionSelections as $selection){
					$criterion['selections'][$selection->selectionID] = $selection->description;
				}
				$criterion['rating'] = 0;
				$criterion['comments'] = array();
				$criteriaCounter += 1;
			}
			$assignmentData[$assignment[0]->assignmentID]['peerCriteria']['numberOfCriteria'] = $criteriaCounter;
			$assignmentData[$assignment[0]->assignmentID]['peerCriteria']['numberOfEvals'] = 0;
			$assignmentData[$assignment[0]->assignmentID]['peerCriteria']['type'] = 'peer';
		}
		if(is_array($individualCriteria)){
			$assignmentData[$assignment[0]->assignmentID]['individualCriteria'] = $individualCriteria;
			$criteriaCounter = 0;
			foreach ($assignmentData[$assignment[0]->assignmentID]['individualCriteria'] as &$criterion){
				#saving object properties
				$criterionID = $criterion->criteriaID;
				$criterionTitle = $criterion->title;
				$criterionDescription = $criterion->description;
				$criterionSelections = $criterion->GetSelections();
				#loading object properties into an array
				$criterion = array();
				$criterion['id'] = $criterionID;
				$criterion['title'] = $criterionTitle;
				$criterion['description'] = $criterionDescription;
				$criterion['selections'] = array();
				foreach ($criterionSelections as $selection){
					$criterion['selections'][$selection->selectionID] = $selection->description;
				}
				$criterion['rating'] = 0;
				$criterion['comments'] = array();
				$criteriaCounter += 1;
			}
			$assignmentData[$assignment[0]->assignmentID]['individualCriteria']['numberOfCriteria'] = $criteriaCounter;
			$assignmentData[$assignment[0]->assignmentID]['individualCriteria']['numberOfEvals'] = 0;
			$assignmentData[$assignment[0]->assignmentID]['individualCriteria']['type'] = 'individual';
		}
	}

	#Gathering the data from each evaluation
	foreach ($evaluations as $evaluation){
		$evaluatedCriteria = $evaluation->GetCriteria();
		$assignmentID = $evaluation->GetAssignment()->assignmentID;
		$user = $evaluation->GetUser();
		#Checks if the evaluation corresponds with an assignment
		if(array_key_exists($assignmentID, $assignmentData)){
			#For each criteria within the evaluation, checks what type it is
			if ($evaluation->evaluation_type == 'Group'){
				#Cycles through each criterion and compares it to the assignments criteria
				foreach ($evaluatedCriteria as $evaluatedCriterion){
					foreach ($assignmentData[$assignmentID]['groupCriteria'] as &$groupCriterion){
						if (is_array($groupCriterion)){
							#Checks if there is a match and, if so, adds its rating and comments
							if ($evaluatedCriterion->criteriaID == $groupCriterion['id']){
								$groupCriterion['rating'] += $evaluatedCriterion->GetCriteriaRating($evaluation->evaluationID);
								if ($evaluatedCriterion->GetCriteriaComments($evaluation->evaluationID) != ''){
									$groupCriterion['comments'][] = $user->firstName . ' ' . $user->lastName . ': ' . $evaluatedCriterion->GetCriteriaComments($evaluation->evaluationID) . ' - Score: ' . $evaluatedCriterion->GetCriteriaRating($evaluation->evaluationID);
								}
							}
						}
					}
				}
				$assignmentData[$assignmentID]['groupCriteria']['numberOfEvals'] += 1;
			}
			else if ($evaluation->evaluation_type == 'Peer'){
				#Cycles through each criterion and compares it to the assignments criteria
				foreach ($evaluatedCriteria as $evaluatedCriterion){
					foreach ($assignmentData[$assignmentID]['peerCriteria'] as &$peerCriterion){
						if (is_array($peerCriterion)){
							#Checks if there is a match and, if so, adds its rating and comments
							if ($evaluatedCriterion->criteriaID == $peerCriterion['id']){
								$peerCriterion['rating'] += $evaluatedCriterion->GetCriteriaRating($evaluation->evaluationID);
								if ($evaluatedCriterion->GetCriteriaComments($evaluation->evaluationID) != ''){
									$peerCriterion['comments'][] = $user->firstName . ' ' . $user->lastName . ': ' . $evaluatedCriterion->GetCriteriaComments($evaluation->evaluationID) . ' - Score: ' . $evaluatedCriterion->GetCriteriaRating($evaluation->evaluationID);
								}
							}
						}
					}
				}
				$assignmentData[$assignmentID]['peerCriteria']['numberOfEvals'] += 1;
			}
			else {
				#Cycles through each criterion and compares it to the assignments criteria
				foreach ($evaluatedCriteria as $evaluatedCriterion){
					foreach ($assignmentData[$assignmentID]['individualCriteria'] as &$individualCriterion){
						if (is_array($individualCriterion)){
							#Checks if there is a match and, if so, adds its rating and comments
							if ($evaluatedCriterion->criteriaID == $individualCriterion['id']){
								$individualCriterion['rating'] += $evaluatedCriterion->GetCriteriaRating($evaluation->evaluationID);
								if ($evaluatedCriterion->GetCriteriaComments($evaluation->evaluationID) != ''){
									$individualCriterion['comments'][] = $user->firstName . ' ' . $user->lastName . ': ' . $evaluatedCriterion->GetCriteriaComments($evaluation->evaluationID) . ' - Score: ' . $evaluatedCriterion->GetCriteriaRating($evaluation->evaluationID);
								}
							}
						}
					}
				}
				$assignmentData[$assignmentID]['individualCriteria']['numberOfEvals'] += 1;
			}
		}
	}

	#Computing the average ratings in each criterion
	#and computing the height each graph should be
	$heights = [];
	foreach ($assignmentData as &$assignment){
		foreach ($assignment as &$criteria){
			if(is_array($criteria) && array_search($criteria, $assignment) != 'group'){
				foreach ($criteria as &$criterion){
					#To avoid bugs, checks if this is a valid criterion
					if (is_array($criterion)){
						$criterion['rating'] = $criterion['rating'] / $criteria['numberOfEvals'];
					}
				}
				$heights[] = $criteria['numberOfCriteria'] * 50;
			}		
		}
	}


	#enable this to see important information
	//echo '<pre>' . print_r($_GET, TRUE) . '</pre>';
	//echo '<pre>' . print_r($assignmentData, TRUE) . '</pre>';
	//echo '<pre>' . print_r($evaluations[0]->GetCriteria()[0]->GetSelections(), TRUE) . '</pre>';


	############RENDERING#############
	echo $twig->render('cumulative_results.html',[
		"username" 			=> $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
		"name"				=> $student->firstName . ' ' . $student->lastName,
		"assignmentData" 	=> $assignmentData,
		"assignments"		=> $assignments,
		"heights"			=> $heights,
		"studentID"		    => $_GET['studentID']
		]);

	#Assignment data is structured as assignmentData[assignmentID][criteria type][criterion][id/title/description/rating/comments]

/*	$assignment_results = array();							//final Twig results
	$class = new Period($_SESSION['classID']);				//class object
	$assignments = $class->GetAssignments();				//get all assignments for class

	if($_GET['studentID'] != '') $user = new User(intval($_GET['studentID'])); //get userID

	$rec_evals = $user->GetReceivedEvaluations(); 			//get received evaluations

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

		//set comments varaibles for group/peer/individual
		$commentsGroup = array();
		$commentsPeer= array();
		$commentsIndividual= array();

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

						if($criteria[$i]->GetCriteriaComments($eval->evaluationID) != ''){
							$new_comment = array();
							$new_comment['criteria'] = $i + 1;
							$new_comment['score'] = $criteria[$i]->GetCriteriaRating($eval->evaluationID);
							$new_comment['comment'] = $criteria[$i]->GetCriteriaComments($eval->evaluationID);
							/*$new_comment = "Criteria " . ($i + 1) . ": " . $criteria[$i]->GetCriteriaComments($eval->evaluationID);
							$new_comment .= " ----- Score: " . $criteria[$i]->GetCriteriaRating($eval->evaluationID);
							$commentsGroup[] = $new_comment;
						}
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
						if($criteria[$i]->GetCriteriaComments($eval->evaluationID) != ''){
							$new_comment = array();
							$new_comment['criteria'] = $i + 1;
							$new_comment['score'] = $criteria[$i]->GetCriteriaRating($eval->evaluationID);
							$new_comment['comment'] = $criteria[$i]->GetCriteriaComments($eval->evaluationID);
							/*$new_comment = "Criteria " . ($i + 1) . ": " . $criteria[$i]->GetCriteriaComments($eval->evaluationID);
							$new_comment .= " ----- Score: " . $criteria[$i]->GetCriteriaRating($eval->evaluationID);
							$commentsPeer[] = $new_comment;
						}

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
						if($criteria[$i]->GetCriteriaComments($eval->evaluationID) != ''){
							$new_comment = array();
							$new_comment['criteria'] = $i + 1;
							$new_comment['score'] = $criteria[$i]->GetCriteriaRating($eval->evaluationID);
							$new_comment['comment'] = $criteria[$i]->GetCriteriaComments($eval->evaluationID);
							/*$new_comment = "Criteria " . ($i + 1) . ": " . $criteria[$i]->GetCriteriaComments($eval->evaluationID);
							$new_comment .= " ----- Score: " . $criteria[$i]->GetCriteriaRating($eval->evaluationID);
							$commentsIndividual[] = $new_comment;
						}

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
					$criteriaGroupFinal[$i] += $criteria[$i]; //add to running total of criteria rating
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
				"comments"  => $commentsGroup,					//comments for group
				"criteriaCount" => $criteriaCountGroup			//total number of criteria

			];
		}

		//if there are any peer evals
		if($countPeer > 0){

			//initialize final average results for peer evals for this assignment
			$criteriaPeerFinal = array();
			for ($i=0; $i < $criteriaCountPeer; $i++) { 
				$criteriaPeerFinal[] = 0;
			}

			//for each peer eval received
			foreach ($overallPeer as $criteria) {
				for ($i=0; $i < $criteriaCountPeer; $i++) { //foreach criteria
					$criteriaPeerFinal[$i] += $criteria[$i];//add to running total of criteria rating
				}
			}

			//for each criteria
			for ($i=0; $i < $criteriaCountPeer; $i++) { 

				//get average result for criteria
				//total of criteria ratings / total number of evals
				$criteriaPeerFinal[$i] = round($criteriaPeerFinal[$i]/$countPeer,1); 
			}

			$assignment_results[] = [

				"name"		=> $a[0]->title . " Peer Results", //assignment name + peer result
				"id"		=> $a[0]->assignmentID,			   //assignment id
				"criteria" => $criteriaPeerFinal,			   //final criteria averages
				"comments"  => $commentsPeer,				   //criteria comments
				"criteriaCount" => $criteriaCountPeer		   //number of criteria

			];
		}

		//if there are any inidividual evals
		if($countIndividual > 0){

			//initialize final average results for individual evals for this assignment
			$criteriaIndividualFinal = array();
			for ($i=0; $i < $criteriaCountIndividual; $i++) { 
				$criteriaIndividualFinal[] = 0;
			}

			//for each individual eval received
			foreach ($overallIndividual as $criteria) {
				for ($i=0; $i < $criteriaCountIndividual; $i++) { //for each criteria
					$criteriaIndividualFinal[$i] += $criteria[$i];//add to running total of criteria rating
				}
			}

			//for each criteria
			for ($i=0; $i < $criteriaCountIndividual; $i++) { 

				//get average result for criteria
				//total of criteria ratings / total number of evals
				$criteriaIndividualFinal[$i] = round($criteriaIndividualFinal[$i]/$countIndividual,1);
			}

			$assignment_results[] = [
				"name"		=> $a[0]->title . " Individual Results", //assignment name + individual result
				"id"		=> $a[0]->assignmentID,					 //assignment id
				"criteria" => $criteriaIndividualFinal,				 //final criteria averages
				"comments"  => $commentsIndividual,					 //comments as arrays with [criteria], [score], and [comment] (for literal)
				"criteriaCount" => $criteriaCountIndividual			 //number of criteria

			];
		}
	}

	echo '<pre>' . print_r($assignment_results, TRUE) . '</pre>';

	############RENDERING#############
	echo $twig->render('cumulative_results.html',[
			"username"    	=> $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
			"name"			=> $user->firstName . " " . $user->lastName,
			"assignments"   => $assignment_results //name, id, result one-five
		]);*/

?>