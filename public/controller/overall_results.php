<?php
	############Inclusions############
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	############Data Processing############
	#We want a 3D array of [student][criteria][rating]

	#Finding data in database
	$assignment = new Assignment($_SESSION['assignmentID']);
	$class = new Period($_SESSION['classID']);
	$students = $class->GetUsers();
	$evaluations = $assignment->GetEvaluations();
	$criteria = $evaluations[1]->GetCriteria();

	#Removing teachers from the students
	foreach ($students as $student){
		if ($student->userType == 'Instructor'){
			unset($students[array_search($student, $students)]);
		}
	}

	#Creating an array for the relevant information
	#This array is structured as [studentID][criteriaID][rating/comments]
	$assignmentData = array();
	foreach ($students as $student){
		$assignmentData[$student->userID] = array();
		foreach ($criteria as $criterion){
			$assignmentData[$student->userID][$criterion->criteriaID] = array();
			$assignmentData[$student->userID][$criterion->criteriaID]['rating'] = 0;
			$assignmentData[$student->userID][$criterion->criteriaID]['numberOfEvals'] = 0;
			$assignmentData[$student->userID][$criterion->criteriaID]['comments'] = array();
		}
	}

	#for each evaluation, checks if it matches a student and a criteria
	#and if it does, adds it to the corresponding place in the assignment data
	foreach ($evaluations as $evaluation){
		$evaluatedCriteria = $evaluation->GetCriteria();
		$target = $evaluation->target_userID;
		if(array_key_exists($target, $assignmentData)){
			foreach ($evaluatedCriteria as $evaluatedCriterion){
				if(array_key_exists($evaluatedCriterion->criteriaID, $assignmentData[$target])){
					$assignmentData[$target][$evaluatedCriterion->criteriaID]['rating'] += $criterion->GetCriteriaRating($evaluation->evaluationID);
					$assignmentData[$target][$evaluatedCriterion->criteriaID]['numberOfEvals'] += 1;
					if($evaluatedCriterion->GetCriteriaComments($evaluation->evaluationID) != ''){
						$assignmentData[$target][$evaluatedCriterion->criteriaID]['comments'][] = $evaluatedCriterion->GetCriteriaComments($evaluation->evaluationID);
					}
				}
			}	
		}
	}

	#computes the average rating and stores that in rating
	foreach ($assignmentData as &$student){
		foreach ($student as &$criterion){
			if($criterion['numberOfEvals'] != 0){
				$criterion['rating'] = $criterion['rating'] / $criterion['numberOfEvals'];
			}
		}
	}

	#enable each of these to see important information
	//echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
	//echo '<pre>' . print_r($_POST, TRUE) . '</pre>';
	//echo '<pre>' . print_r($assignmentData, TRUE) . '</pre>';

	############Rendering page############
	echo $twig->render('overall_results.html', [
		#"username"        => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
		#"evaluations"     => $evaluations,
		#"assignment"	  => $assignment,
		#"criteria"		  => $criteria,
		#"assignmentData"  => $assignmentData,
		#"students"		  => $students
	]);
?>