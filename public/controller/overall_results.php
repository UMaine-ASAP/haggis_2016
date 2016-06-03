<?php
	############NOTES#################
	/*
		$_POST contains a Sorting_Choice that is used to determine which table
		should be drawn.

		The math for determining average rating is as follows:
		(all evaluation ratings for a criteria totaled) / (numberofevaluations) /numberofcriteria
	*/

	############Functions#############
	function sortStudentsAlphabetically(&$array){
		//PRE: $array is the assignment data garnered from below
		//POST: Sorts the array in alphabetical order
		foreach ($array as &$studentA){
			foreach ($array as &$studentB){
				if(strcasecmp($studentA['lastName'], $studentB['lastName']) < 0) {
					$temp = $studentA;
					$studentA = $studentB;
					$studentB = $temp;
				}
			}
		}
	}

	function sortStudentsRAlphabetically(&$array){
		//PRE: $array is the assignment data garnered from below
		//POST: Sorts the array in alphabetical order
		foreach ($array as &$studentA){
			foreach ($array as &$studentB){
				if(strcasecmp($studentA['lastName'], $studentB['lastName']) > 0){
					$temp = $studentA;
					$studentA = $studentB;
					$studentB = $temp;
				}
			}
		}
	}

	function sortStudentsHighToLow(&$array){
		foreach ($array as &$studentA){
			foreach ($array as &$studentB){
				if($studentA['averageRating'] > $studentB['averageRating']){
					$temp = $studentA;
					$studentA = $studentB;
					$studentB = $temp;
				}
			}
		}
	}

	function sortStudentsLowToHigh(&$array){
		//PRE: $array is the assignment data garnered from below
		//POST: Sorts the assignment data in lowest to highest rating
		foreach ($array as &$studentA){
			foreach ($array as &$studentB){
				if($studentA['averageRating'] < $studentB['averageRating']){
					$temp = $studentA;
					$studentA = $studentB;
					$studentB = $temp;
				}
			}
		}
	}

	function sortGroupsNumerically(&$array){
		//PRE: $array is the assignment data garnered from below
		//POST: Sorts the assignment data in group number order
		foreach ($array as &$groupA){
			foreach ($array as &$groupB){
				if($groupA['groupNumber'] < $groupB['groupNumber']){
					$temp = $groupA;
					$groupA = $groupB;
					$groupB = $temp;
				}
			}
		}
	}

	function sortGroupsRNumerically(&$array){
		//PRE: $array is the assignment data garnered from below
		//POST: Sorts the assignment data in reverse group number order
		foreach ($array as &$groupA){
			foreach ($array as &$groupB){
				if($groupA['groupNumber'] > $groupB['groupNumber']){
					$temp = $groupA;
					$groupA = $groupB;
					$groupB = $temp;
				}
			}
		}
	}

	function sortGroupsHighToLow(&$array){
		foreach ($array as &$groupA){
			foreach ($array as &$groupB){
				if($groupA['averageRating'] > $groupB['averageRating']){
					$temp = $groupA;
					$groupA = $groupB;
					$groupB = $temp;
				}
			}
		}
	}

	function sortGroupsLowToHigh(&$array){
		//PRE: $array is the assignment data garnered from below
		//POST: Sorts the assignment data in lowest to highest rating
		foreach ($array as &$groupA){
			foreach ($array as &$groupB){
				if($groupA['averageRating'] < $groupB['averageRating']){
					$temp = $groupA;
					$groupA = $groupB;
					$groupB = $temp;
				}
			}
		}
	}

	############Inclusions############
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	############Data Processing#######
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
			break;
		}
		else if ($groups != array() && $evaluation->evaluation_type = 'Group'){
			$criteria = $evaluation->GetCriteria();
			break;
		}
	}

	#Declaring other used variables
	$type = '';
	$height = 0;
	$numberSort = false;

	#Determining if it is a group assignment or individual assignment
	if ($groups == array()){
		#Marks what kind of assignment this is
		$type = 'individual';

		foreach ($students as $student){
			#Setting the height of the graph
			$height += 50;


			#Removing teachers from the students
			if ($student->userType == 'Instructor'){
				unset($students[array_search($student, $students)]);
			}
		}

		$assignmentData = array();
		foreach ($students as $student){
			$assignmentData[$student->userID] = array();
			$assignmentData[$student->userID]['averageRating'] = 0;
			$assignmentData[$student->userID]['name'] = $student->firstName . ' ' . $student->lastName;
			$assignmentData[$student->userID]['lastName'] = $student->lastName;
			$assignmentData[$student->userID]['numberOfEvals'] = 0;
			foreach ($criteria as $criterion){
				$assignmentData[$student->userID][$criterion->criteriaID] = array();
				$assignmentData[$student->userID][$criterion->criteriaID]['rating'] = 0;
				$assignmentData[$student->userID][$criterion->criteriaID]['comments'] = array();
			}
		}

		#for each evaluation, checks if it matches a student and a criteria
		#and if it does, adds it to the corresponding place in the assignment data
		foreach ($evaluations as $evaluation){
			$evaluatedCriteria = $evaluation->GetCriteria();
			$target = $evaluation->target_userID;
			if(array_key_exists($target, $assignmentData)){
				$assignmentData[$target]['numberOfEvals'] += 1;
				foreach ($evaluatedCriteria as $evaluatedCriterion){
					if(array_key_exists($evaluatedCriterion->criteriaID, $assignmentData[$target])){
						$assignmentData[$target][$evaluatedCriterion->criteriaID]['rating'] += $criterion->GetCriteriaRating($evaluation->evaluationID);
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
				if (is_array($criterion)){
					if($student['numberOfEvals'] != 0){
						#echo '<pre> Total Criteria Rating:' . print_r($criterion['rating'], TRUE) . '</pre>';
						#echo '<pre> Number of Evaluations: ' . print_r($student['numberOfEvals'], TRUE) . '</pre>';
						$criterion['rating'] = $criterion['rating'] / $student['numberOfEvals'];
						#echo '<pre> Resulting Criteria Rating: ' . print_r($criterion['rating'], TRUE) . '</pre>';
					}
					$tempTotal += $criterion['rating'];
					$tempNumberOfCriteria += 1;
				}
			}
			#echo '<pre> Total: ' . print_r($tempTotal, TRUE) . '</pre>';
			#echo '<pre> Number of Criteria: ' . print_r($tempNumberOfCriteria, TRUE) . '</pre>';
			$student['averageRating'] = $tempTotal / $tempNumberOfCriteria;
			#echo '<pre> Average Rating: ' . print_r($student['averageRating'], TRUE) . '</pre>';
		}

		#Sorting the array based on user choice
		if(!isset($_POST['SortChoice'])){
			$_POST['SortChoice'] = 'Alphabetically';
		}
		if($_POST['SortChoice'] == 'Alphabetically'){
			sortStudentsAlphabetically($assignmentData);
		}
		else if (($_POST['SortChoice']) == 'RAlphabetically'){
			sortStudentsRAlphabetically($assignmentData);
		}
		else if ($_POST['SortChoice'] == 'HighToLow'){
			sortStudentsHighToLow($assignmentData);
			$numberSort = true;
		}
		else if ($_POST['SortChoice'] == 'LowToHigh'){
			sortStudentsLowToHigh($assignmentData);
			$numberSort = true;
		}
	}
	else{
		#Marks what kind of project this is
		$type = 'group';

		$assignmentData = array();
		foreach ($groups as $group){
			#Setting the height of the graph
			$height += 50;

			#Creating an array for the relevant information
			#This array is structured as [groupID][criteriaID][rating/comments]
			$assignmentData[$group->student_groupID] = array();
			$assignmentData[$group->student_groupID]['averageRating'] = 0;
			$assignmentData[$group->student_groupID]['groupNumber'] = $group->groupNumber;
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
				if(is_array($criterion)){
					if($criterion['numberOfEvals'] != 0){
						$criterion['rating'] = $criterion['rating'] / $criterion['numberOfEvals'];
					}
					$tempTotal += $criterion['rating'];
					$tempNumberOfCriteria += 1;
				}
			}
			$group['averageRating'] = $tempTotal / $tempNumberOfCriteria;
		}

		#Sorting the array based on user choice
		if(!isset($_POST['SortChoice'])){
			$_POST['SortChoice'] = 'Numerically';
		}
		if($_POST['SortChoice'] == 'Numerically'){
			sortGroupsNumerically($assignmentData);
		}
		else if($_POST['SortChoice'] == 'RNumerically'){
			sortGroupsRNumerically($assignmentData);
		}
		else if($_POST['SortChoice'] == 'HighToLow'){
			sortGroupsHighToLow($assignmentData);
		}
		else if($_POST['SortChoice'] == 'LowToHigh'){
			sortGroupsLowToHigh($assignmentData);
		}
	}

	#enable each of these to see important information
	//echo '<pre>' . print_r($assignmentData, TRUE) . '</pre>';
	//echo '<pre>' . print_r($evaluations, TRUE) . '</pre>';
	//echo '<pre>' . print_r($evaluations[0]->GetChildEvaluations(), TRUE) . '</pre>';
	//echo '<pre>' . print_r($groups, TRUE) . '</pre>';

	############Rendering page############
	echo $twig->render('overall_results.html', [
		"username"        => $_SESSION['user']->firstName . " " . $_SESSION['user']->lastName,
		"type" 			  => $type,
		"evaluations"     => $evaluations,
		"assignment"	  => $assignment,
		"criteria"		  => $criteria,
		"assignmentData"  => $assignmentData,
		"students"		  => $students,
		"groups"		  => $groups,
		"height"		  => $height
	]);

	#for use in HTML page
	#{{username}} = user's firstname lastname
	#{{assignmentType}} = the type of assignment, group or individual
	#{{evaluations}} = every evaluation as an array
	#{{assignment}} = the assignment object
	#{{criteria}} = the criteria of the assignment as an array
	#{{assignmentData}} = a 3D array
	#	first array = a numeric identifier for group or user
	#	second array = criteria ID or average rating
	#	third array = rating, comments
	#	NOTE!: comments is every comment as an array
	#{{students}} = every student in the class as an array
	#{{groups}} = every group in the project
	#{{height}} = the height of the graph
?>