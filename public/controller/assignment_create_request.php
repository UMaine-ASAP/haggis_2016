<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

    //if assignment title and due date not given, tell user
    if(empty($_POST['postAssignmentTitle']) OR empty($_POST['postAssignmentDate'])){
        die("Didn't provide title and/or date, try again.");
    }

    //create new assignment
    $assignment = new Assignment(0);

    //set assignment variables: title, description
    $assignment->title = $_POST['postAssignmentTitle'];
    $assignment->description = $_POST['postAssignmentDescription'];
    $assignment->Save();

    //add assignment to class
    $assignment->AddClass($_SESSION['classID'], $_POST['postAssignmentDate']);
    $_SESSION['assignmentID'] = $assignment->assignmentID;

	header("location:instructor_assignment.php");
?>