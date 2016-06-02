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
	$groups = $assignment->GetGroups();
	$evaluations = $assignment->GetEvaluations();

	#Getting correct criteria for a group or individual assignment
	$criteria = array();
	foreach ($evaluations as $evaluation){
		if ($groups == array() && $evaluation->evaluation_type == ''){
			$criteria = $evaluation->GetCriteria();
		}
		else if ($groups != array() && $evaluation->evaluation_type = 'Group'){
			$criteria = $evaluation->GetCriteria();
		}
	}

	#Determining if it is a group assignment or individual assignment
	if ($groups == array()){
		#Marks what kind of assignment this is
		$type = 'individual';

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
			$assignmentData[$student->userID]['averageRating'] = 0;
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
			$tempNumberOfCriteria = 0;
			$tempTotal = 0;
			foreach ($student as &$criterion){
				if($criterion['numberOfEvals'] != 0){
					$criterion['rating'] = $criterion['rating'] / $criterion['numberOfEvals'];
				}
				$tempTotal += $criterion['rating'];
				$tempNumberOfCriteria += 1;
			}
			$student['averageRating'] = $tempTotal / $tempNumberOfCriteria;
		}
	}
	else{
		#Marks what kind of project this is
		$type = 'group';

		#Creating an array for the relevant information
		#This array is structured as [groupID][criteriaID][rating/comments]
		$assignmentData = array();
		foreach ($groups as $group){
			$assignmentData[$group->student_groupID] = array();
			$assignmentData[$group->student_groupID]['averageRating'] = 0;
			foreach ($criteria as $criterion){
				$assignmentData[$group->student_groupID][$criterion->criteriaID] = array();
				$assignmentData[$group->student_groupID][$criterion->criteriaID]['rating'] = 0;
				$assignmentData[$group->student_groupID][$criterion->criteriaID]['numberOfEvals'] = 0;
				$assignmentData[$group->student_groupID][$criterion->criteriaID]['comments'] = array();
			}
		}

		#for each evaluation, checks if it matches a group and a criteria
		#and if it does, adds it to the corresponding place in the assignment data
		foreach ($evaluations as $evaluation){
			$evaluatedCriteria = $evaluation->GetCriteria();
			$target = $evaluation->groupID;
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

		#computes the average rating for each group
		foreach ($assignmentData as &$group){
			$tempNumberOfCriteria = 0;
			$tempTotal = 0;
			foreach ($group as &$criterion){
				if($criterion['numberOfEvals'] != 0){
					$criterion['rating'] = $criterion['rating'] / $criterion['numberOfEvals'];
				}
				$tempTotal += $criterion['rating'];
				$tempNumberOfCriteria += 1;
			}
			$group['averageRating'] = $tempTotal / $tempNumberOfCriteria;
		}
	}

	#enable each of these to see important information
	//echo '<pre>' . print_r($assignmentData, TRUE) . '</pre>';
	//echo '<pre>' . print_r($evaluations, TRUE) . '</pre>';
	//echo '<pre>' . print_r($groups, TRUE) . '</pre>';

	############Rendering page############
	echo $twig->render('overall_results.html', [
		"username"        => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
		"type"  => $type,
		"evaluations"     => $evaluations,
		"assignment"	  => $assignment,
		"criteria"		  => $criteria,
		"assignmentData"  => $assignmentData,
		"students"		  => $students,
		"groups"		  => $groups
	]);

	#for use in HTML page
	#{{username}} = user's firstname lastname
	#{{assignmentType}} = the type of assignment, group or individual
	#{{evaluations}} = every evaluation as an array
	#{{assignment}} = the assignment object
	#{{criteria}} = the criteria of the assignment as an array
	#{{assignmentData}} = a 3D array
	#	first array = user ID or group ID
	#	second array = criteria ID or average rating
	#	third array = rating, comments
	#	NOTE!: comments is every comment as an array
	#{{students}} = every student in the class as an array
	#{{groups}} = every group in the project
?>