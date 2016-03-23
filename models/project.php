<?php
require_once dirname(__FILE__) . "/../system/database.php";
require_once dirname(__FILE__) . "/../models/assignment.php";
require_once dirname(__FILE__) . "/../models/evaluation.php";
require_once dirname(__FILE__) . "/../models/part.php";
require_once dirname(__FILE__) . "/../models/user.php";

class Project {

	public $projectID = -1;
	public $title;
	public $assignmentID;
	public $description;

	public function Project($project_id){
		$this->projectID = $project_id;

		$db = GetDB();

		// If the project_id is equal to zero, then this must be a new project
		if($this->projectID == 0){
			$query = "INSERT INTO `project` () VALUES ()";
			if($db->query($query) === TRUE){
				$this->projectID = $db->insert_id;
			} else {
				die("Couldn't create project");
			}
			return;
		}

		$query = "SELECT * FROM `project` WHERE `projectID` = " . $this->projectID;

		$project = $db->query($query, MYSQLI_STORE_RESULT );
		if($project){
			$project = $project->fetch_array(MYSQLI_BOTH);

			if($project != NULL){
				$this->title = $project['title'];
				$this->assignmentID = $project['assignmentID'];
				$this->description = $project['description'];
			} else {
				die("Couldn't find project: " . $this->projectID);
			}
		} else {
			die("Couldn't find project: " . $this->projectID);
		}
	}

	public function Save(){
		if($this->projectID != -1){
			$query = "UPDATE `project` SET ";
			$query .= "`title` = '" . $this->title . "', ";
			$query .= "`assignmentID` = '" . $this->assignmentID . "', ";
			$query .= "`description` = '" . $this->description . "', ";
			$query .= "WHERE `projectID` = " . $this->projectID;

			$db = GetDB();
			if($db->query($query) === TRUE){
				// Updated succesfully
			} else {
				die("Couldn't update project: " . $this->projectID);
			}
		}
	}

	public function Delete(){
		if(!filter_var($this->projectID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong projectID
		}

		$query = "DELETE FROM `project` WHERE `projectID` = {$this->projectID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			die("Couldn't delete project: " . $this->projectID);
		}
	}

/////////////////////////////////////////////////////////////////// ASSIGNMENTS

	public function AddAssignment($assignmentID){
		if(!filter_var($this->projectID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong projectID
		}
		if(!filter_var($assignmentID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong projectID
		}

		$query = "INSERT INTO `project_assignment` (`projectID`, `assignmentID`) VALUES ({$this->projectID}, $assignmentID)";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Created succesfully
		} else {
			die("Couldn't add assignment to project: " . $this->projectID);
		}
	}

	public function GetAssignments(){
		if(!filter_var($this->projectID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong projectID
		}

		$query = "SELECT * FROM `project_assignment` WHERE `projectID` = {$this->projectID}";

		$db = GetDB();
		$rows = $db->query($query);
		if($rows){
			$ret = Array();
			while($row = $rows->fetch_array(MYSQLI_BOTH)){
				
				/*$query = "SELECT * FROM `assignment` WHERE `assignmentID` = {$row['assignmentID']}";

				$assignments = $db->query($query);
				if($assignments){
					while($assignment = $assignments->fetch_array(MYSQLI_BOTH)){
						$ret[] = $assignment;
					}
				}*/

				$a = new Assignment($row['assignmentID']);
				$ret[] = $a;

			}
			return $ret;
		} else {
			return Array();
		}
	}

	public function RemoveAssignment($assignmentID){
		if(!filter_var($this->projectID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong classID
		}
		if(!filter_var($assignmentID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong projectID
		}

		$query = "DELETE FROM `project_assignment` WHERE `assignmentID` = $assignmentID AND `projectID` = {$this->projectID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Removed succesfully
		} else {
			die("Couldn't remove assignment from project: " . $this->projectID);
		}
	}

/////////////////////////////////////////////////////////////////// Evaluations

	public function AddEvaluation($evaluationID){
		if(!filter_var($this->projectID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong projectID
		}
		if(!filter_var($evaluationID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong projectID
		}

		$query = "INSERT INTO `project_evaluation` (`projectID`, `evaluationID`) VALUES ({$this->projectID}, $evaluationID)";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Created succesfully
		} else {
			die("Couldn't add evaluation to project: " . $this->projectID);
		}
	}

	public function GetEvaluation(){
		if(!filter_var($this->projectID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong projectID
		}

		$query = "SELECT * FROM `project_evaluation` WHERE `projectID` = {$this->projectID}";

		$db = GetDB();
		$rows = $db->query($query);
		if($rows){
			$ret = Array();
			while($row = $rows->fetch_array(MYSQLI_BOTH)){
				
				/*$query = "SELECT * FROM `evaluation` WHERE `evaluationID` = {$row['evaluationID']}";

				$evaluations = $db->query($query);
				if($evaluations){
					while($evaluation = $evaluations->fetch_array(MYSQLI_BOTH)){
						$ret[] = $evaluation;
					}
				}*/

				$e = new Evaluation($row['evaluationID']);
				$ret[] = $e;

			}
			return $ret;
		} else {
			return Array();
		}
	}

	public function RemoveEvaluation($evaluationID){
		if(!filter_var($this->projectID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong classID
		}
		if(!filter_var($evaluationID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong projectID
		}

		$query = "DELETE FROM `project_evaluation` WHERE `evaluationID` = $evaluationID AND `projectID` = {$this->projectID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Removed succesfully
		} else {
			die("Couldn't remove evaluation from project: " . $this->projectID);
		}
	}

/////////////////////////////////////////////////////////////////// PARTS

	public function AddPart($partID){
		if(!filter_var($this->projectID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong projectID
		}
		if(!filter_var($partID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong projectID
		}

		$query = "INSERT INTO `project_part` (`projectID`, `partID`) VALUES ({$this->projectID}, $partID)";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Created succesfully
		} else {
			die("Couldn't add part to project: " . $this->projectID);
		}
	}

	public function GetPart(){
		if(!filter_var($this->projectID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong projectID
		}

		$query = "SELECT * FROM `project_part` WHERE `projectID` = {$this->projectID}";

		$db = GetDB();
		$rows = $db->query($query);
		if($rows){
			$ret = Array();
			while($row = $rows->fetch_array(MYSQLI_BOTH)){
				
				/*$query = "SELECT * FROM `part` WHERE `partID` = {$row['partID']}";

				$parts = $db->query($query);
				if($parts){
					while($part = $parts->fetch_array(MYSQLI_BOTH)){
						$ret[] = $part;
					}
				}*/

				$c = new Part($row['partID']);
				$ret[] = $c;

			}
			return $ret;
		} else {
			return Array();
		}
	}

	public function RemovePart($partID){
		if(!filter_var($this->projectID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong classID
		}
		if(!filter_var($partID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong projectID
		}

		$query = "DELETE FROM `project_part` WHERE `partID` = $partID AND `projectID` = {$this->projectID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Removed succesfully
		} else {
			die("Couldn't remove part from project: " . $this->projectID);
		}
	}

/////////////////////////////////////////////////////////////////// USERS

	public function AddUser($userID){
		if(!filter_var($this->projectID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong projectID
		}
		if(!filter_var($userID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong projectID
		}

		$query = "INSERT INTO `project_user` (`projectID`, `userID`) VALUES ({$this->projectID}, $userID)";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Created succesfully
		} else {
			die("Couldn't add user to project: " . $this->projectID);
		}
	}

	public function GetUser(){
		if(!filter_var($this->projectID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong projectID
		}

		$query = "SELECT * FROM `project_user` WHERE `projectID` = {$this->projectID}";

		$db = GetDB();
		$rows = $db->query($query);
		if($rows){
			$ret = Array();
			while($row = $rows->fetch_array(MYSQLI_BOTH)){
				
				/*$query = "SELECT * FROM `user` WHERE `userID` = {$row['userID']}";

				$users = $db->query($query);
				if($users){
					while($user = $users->fetch_array(MYSQLI_BOTH)){
						$ret[] = $user;
					}
				}*/

				$u = new User($row['userID']);
				$ret[] = $u;

			}
			return $ret;
		} else {
			return Array();
		}
	}

	public function RemoveUser($userID){
		if(!filter_var($this->projectID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong classID
		}
		if(!filter_var($userID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong projectID
		}

		$query = "DELETE FROM `project_user` WHERE `userID` = $userID AND `projectID` = {$this->projectID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Removed succesfully
		} else {
			die("Couldn't remove user from project: " . $this->projectID);
		}
	}

}

/*
$u = new Project(1);
$u->AddAssignment(1);
print_r($u->GetAssignments()); echo "<br>";
$u->RemoveAssignment(1);
$u->AddEvaluation(1);
print_r($u->GetEvaluation()); echo "<br>";
$u->RemoveEvaluation(1);
$u->AddPart(1);
print_r($u->GetPart()); echo "<br>";
$u->RemovePart(1);
$u->AddUser(1);
print_r($u->GetUser()); echo "<br>";
$u->RemoveUser(1);
*/

?>