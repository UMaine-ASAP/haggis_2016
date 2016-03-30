<?php
require_once dirname(__FILE__) . "/../system/database.php";
require_once dirname(__FILE__) . "/../models/user.php";
require_once dirname(__FILE__) . "/../models/assignment.php";

class Period {

	public $classID = -1;
	public $title;
	public $courseID;
	public $time;
	public $description;
	public $location;

	public function Period($class_id){
		if($class_id == -1){
			return;
		}

		$this->classID = $class_id;

		$db = GetDB();

		// If the class_id is equal to zero, then this must be a new class
		if($this->classID == 0){
			$query = "INSERT INTO `class` () VALUES ()";
			if($db->query($query) === TRUE){
				$this->classID = $db->insert_id;
			} else {
				die("Couldn't create class");
			}
			return;
		}

		$query = "SELECT * FROM `class` WHERE `classID` = " . $this->classID;

		$class = $db->query($query, MYSQLI_STORE_RESULT );
		if($class){
			$class = $class->fetch_array(MYSQLI_BOTH);

			if($class != NULL){
				$this->title = $class['title'];
				$this->courseID = $class['courseID'];
				$this->time = $class['time'];
				$this->description = $class['description'];
				$this->location = $class['location'];
			} else {
				die("Couldn't find class: " . $this->classID);
			}
		} else {
			die("Couldn't find class: " . $this->classID);
		}
	}

	public function Save(){
		if($this->classID != -1){
			$query = "UPDATE `class` SET ";
			$query .= "`title` = '" . $this->title . "', ";
			$query .= "`courseID` = '" . $this->courseID . "', ";
			$query .= "`time` = '" . $this->time . "', ";
			$query .= "`description` = '" . $this->description . "', ";
			$query .= "`location` = '" . $this->location . "' ";
			$query .= "WHERE `classID` = " . $this->classID;

			$db = GetDB();
			if($db->query($query) === TRUE){
				// Updated succesfully
			} else {
				die("Couldn't update class: " . $this->classID . " " . mysqli_error($db));
			}
		}
	}

	public function Add(){
		$query = "INSERT INTO `class` (`classID`, `title`, `courseID`, `time`, `description`, `location`) VALUES (";
		$query .= "NULL, ";
		$query .= $this->title . "','";
		$query .= $this->courseID . "','";
		$query .= $this->time . "','";
		$query .= $this->description . "','";
		$query .= $this->location . "')";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			die("Couldn't update class: " . $this->classID . " " . mysqli_error($db));
		}
	}

	public function Delete(){
		if(!filter_var($this->classID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong classID
		}

		$query = "DELETE FROM `class` WHERE `classID` = {$this->classID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			die("Couldn't delete class: " . $this->classID);
		}
	}

/////////////////////////////////////////////////////////////////// USERS

	public function AddUser($userID,$userType){
		if(!filter_var($this->classID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong classID
		}
		if(!filter_var($userID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong classID
		}
		$userType = filter_var($userType, FILTER_SANITIZE_STRING);

		$query = "INSERT INTO `class_user` (`userID`, `classID`, `userType`) VALUES ($userID, {$this->classID}, '$userType')";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Created succesfully
		} else {
			die("Couldn't add user to class: " . $this->classID);
		}
	}

	public function GetUsers(){
		if(!filter_var($this->classID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong classID
		}

		$query = "SELECT * FROM `class_user` WHERE `classID` = {$this->classID}";

		$db = GetDB();
		$rows = $db->query($query);
		if($rows){
			$ret = Array();
			while($row = $rows->fetch_array(MYSQLI_BOTH)){
				
				/*$query = "SELECT * FROM `user` WHERE `userID` = {$row['userID']}";

				$users = $db->query($query);
				if($users){
					while($user = $users->fetch_array(MYSQLI_BOTH)){
						$user['class_userType'] = $row['userType'];
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
		if(!filter_var($this->classID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong classID
		}
		if(!filter_var($userID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong classID
		}

		$query = "DELETE FROM `class_user` WHERE `userID` = $userID AND `classID` = {$this->classID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Removed succesfully
		} else {
			die("Couldn't remove user from class: " . $this->classID);
		}
	}

/////////////////////////////////////////////////////////////////// Assignments

	public function GetAssignments(){
		
			$query =  "SELECT * FROM `assignment_class` WHERE `classID` = {$this->classID}";

			$db = GetDB();
			$rows = $db->query($query);
			if($rows){
				$ret = Array();
				while($row = $rows->fetch_array(MYSQLI_BOTH)){
					
					$u = array(new Assignment($row['assignmentID']), $row['dueDate']);
					$ret[] = $u;

				}
				return $ret;
			} else {
				return Array();
			}
	}

/////////////////////////////////////////////////////////////////// Evaluations

	
}







/*
$u = new Period(1);
$u->AddUser(1,1);
print_r($u->GetUsers()); echo "<br>";
$u->RemoveUser(1);
*/

?>