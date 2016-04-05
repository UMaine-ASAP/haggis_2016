<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

	$assignmentID = $_POST['assignmentID'];
	$assignmentWorking = new Assignment($assignmentID);
	$assignmentName = $assignmentWorking->title;
	$assignmentDescription = $assignmentWorking->description;

	$instructedID = $_SESSION['user']->userID;

	$instructor = new User($instructedID);

	$allEvaluationsInstructor = $instructor->GetEvaluations();
	$allEvaluationsAssignment = $assignmentWorking->GetEvaluations();

	$blankEval = new Evaluation(0);

	//COMPARE INSTRUCTOR CLASSES TO STUDENT CLASSES - this will work for now but not later *sigh*

	$instructorClasses = $instructor->GetClasses();

	$usersInClassAssignment = $assignmentWorking->GetClasses()[0]->GetUsers();
	foreach ($usersInClassAssignment as $user) {
		foreach ($instructorClasses as $class) {
			$userClasses = $user->GetClasses();
			foreach ($userClasses as $clase) {
				if(!isset($similarClass))
					$similarClass = 0;
				if($clase->classID == $class->classID)
				{
					$similarClass = $clase->classID;
				}
			}
		}
	}

	$classIDWorking = $similarClass;

	var_dump($_POST['dueDate']);

	$month = substr($_POST['dueDate'], 5,2);
	$day = substr($_POST['dueDate'], 8,2);
	$year = substr($_POST['dueDate'], 0, 4);
	$myTime = date("Ymd", mktime(0, 0, 0, $month, $day, $year));

	$assignmentWorking->AddClass($classIDWorking, $myTime);

	$_SESSION['assignmentKey'] = $matchedEval->evaluationID;
	$_SESSION['assignmentID'] = $_POST['assignmentID'];

	header("location:instructor_assignment.php");