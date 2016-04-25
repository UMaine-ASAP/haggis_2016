<?php
	require_once __DIR__ . "/../../system/bootstrap.php";
	ensureLoggedIn();

    if(empty($_POST['postAssignmentTitle']) OR empty($_POST['postAssignmentDate'])){
        die("Didn't provide title and/or date, try again.");
    }


    $user = $_SESSION['user'];
    $assignment = new Assignment(0);

    $assignment->title = $_POST['postAssignmentTitle'];
    $assignment->description = $_POST['postAssignmentDescription'];
    $assignment->Save();
    $assignment->AddClass($_SESSION['classID'], $_POST['postAssignmentDate']);
    $_SESSION['assignmentID'] = $assignment->assignmentID;

	header("location:instructor_assignment.php");
?>