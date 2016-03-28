<?php
require_once dirname(__FILE__) . "/../system/database.php";
require_once dirname(__FILE__) . "/../models/class.php";
require_once dirname(__FILE__) . "/../models/criteria.php";
require_once dirname(__FILE__) . "/../models/part.php";

class Assignment {

	public $assignmentID = -1;
	public $title;
	public $description;

	public function Assignment($assignment_id){
		$this->assignmentID = $assignment_id;

		$db = GetDB();

		// If the assignment_id is equal to zero, then this must be a new assignment
		if($this->assignmentID == 0){
			$query = "INSERT INTO `assignment` () VALUES ()";
			if($db->query($query) === TRUE){
				$this->assignmentID = $db->insert_id;
			} else {
				die("Couldn't create assignment");
			}
			return;
		}

		$query = "SELECT * FROM `assignment` WHERE `assignmentID` = " . $this->assignmentID;

		$assignment = $db->query($query, MYSQLI_STORE_RESULT );
		if($assignment){
			$assignment = $assignment->fetch_array(MYSQLI_BOTH);

			if($assignment != NULL){
				$this->title = $assignment['title'];
				$this->description = $assignment['description'];
			} else {
				die("Couldn't find assignment: " . $this->assignmentID);
			}
		} else {
			die("Couldn't find assignment: " . $this->assignmentID);
		}
	}

	public function Save(){
		if($this->assignmentID != -1){
			$query = "UPDATE `assignment` SET ";
			$query .= "`title` = '" . $this->title . "', ";
			$query .= "`description` = '" . $this->description . "', ";
			$query .= "WHERE `assignmentID` = " . $this->assignmentID;

			$db = GetDB();
			if($db->query($query) === TRUE){
				// Updated succesfully
			} else {
				die("Couldn't update assignment: " . $this->assignmentID);
			}
		}
	}

	public function Delete(){
		if(!filter_var($this->assignmentID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong assignmentID
		}

		$query = "DELETE FROM `assignment` WHERE `assignmentID` = {$this->assignmentID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			die("Couldn't delete assignment: " . $this->assignmentID);
		}
	}

/////////////////////////////////////////////////////////////////// CRITERIA

	public function AddCriteria($criteriaID){
		if(!filter_var($this->assignmentID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong assignmentID
		}
		if(!filter_var($criteriaID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong assignmentID
		}

		$query = "INSERT INTO `assignment_criteria` (`assignmentID`, `criteriaID`) VALUES ({$this->assignmentID}, $criteriaID)";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Created succesfully
		} else {
			die("Couldn't add criteria to assignment: " . $this->assignmentID);
		}
	}

	public function GetCriteria(){
		if(!filter_var($this->assignmentID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong assignmentID
		}

		$query = "SELECT * FROM `assignment_criteria` WHERE `assignmentID` = {$this->assignmentID}";

		$db = GetDB();
		$rows = $db->query($query);
		if($rows){
			$ret = Array();
			while($row = $rows->fetch_array(MYSQLI_BOTH)){
				
				/*$query = "SELECT * FROM `criteria` WHERE `criteriaID` = {$row['criteriaID']}";

				$criteria = $db->query($query);
				if($criteria){
					while($c = $criteria->fetch_array(MYSQLI_BOTH)){
						$ret[] = $c;
					}
				}*/

				$c = new Criteria($row['criteriaID']);
				$ret[] = $c;

			}
			return $ret;
		} else {
			return Array();
		}
	}

	public function RemoveCriteria($criteriaID){
		if(!filter_var($this->assignmentID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong assignmentID
		}
		if(!filter_var($criteriaID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong assignmentID
		}

		$query = "DELETE FROM `assignment_criteria` WHERE `criteriaID` = $criteriaID AND `assignmentID` = {$this->assignmentID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Removed succesfully
		} else {
			die("Couldn't remove criteria from assignment: " . $this->assignmentID);
		}
	}

/////////////////////////////////////////////////////////////////// PART

	public function AddPart($partID){
		if(!filter_var($this->assignmentID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong assignmentID
		}
		if(!filter_var($partID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong assignmentID
		}

		$query = "INSERT INTO `assignment_parts` (`assignmentID`, `PartID`) VALUES ({$this->assignmentID}, $partID)";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Created succesfully
		} else {
			die("Couldn't add part to assignment: " . $this->assignmentID);
		}
	}

	public function GetPart(){
		if(!filter_var($this->assignmentID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong assignmentID
		}

		$query = "SELECT * FROM `assignment_parts` WHERE `assignmentID` = {$this->assignmentID}";

		$db = GetDB();
		$rows = $db->query($query);
		if($rows){
			$ret = Array();
			while($row = $rows->fetch_array(MYSQLI_BOTH)){
				
				/*$query = "SELECT * FROM `part` WHERE `partID` = {$row['PartID']}";

				$parts = $db->query($query);
				if($parts){
					while($c = $parts->fetch_array(MYSQLI_BOTH)){
						$ret[] = $c;
					}
				}*/

				$c = new Part($row['PartID']);
				$ret[] = $c;

			}
			return $ret;
		} else {
			return Array();
		}
	}

	public function RemovePart($partID){
		if(!filter_var($this->assignmentID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong assignmentID
		}
		if(!filter_var($partID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong assignmentID
		}

		$query = "DELETE FROM `assignment_parts` WHERE `partID` = $partID AND `assignmentID` = {$this->assignmentID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Removed succesfully
		} else {
			die("Couldn't remove part from assignment: " . $this->assignmentID);
		}
	}

/////////////////////////////////////////////////////////////////// CLASS

	public function AddClass($classID){
		if(!filter_var($this->assignmentID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong assignmentID
		}
		if(!filter_var($classID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong assignmentID
		}

		$query = "INSERT INTO `assignment_class` (`assignmentID`, `ClassID`) VALUES ({$this->assignmentID}, $classID)";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Created succesfully
		} else {
			die("Couldn't add class to assignment: " . $this->assignmentID);
		}
	}

	public function GetClasses(){
		if(!filter_var($this->assignmentID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong assignmentID
		}

		$query = "SELECT * FROM `assignment_class` WHERE `assignmentID` = {$this->assignmentID}";

		$db = GetDB();
		$rows = $db->query($query);
		if($rows){
			$ret = Array();
			while($row = $rows->fetch_array(MYSQLI_BOTH)){
				
				/*$query = "SELECT * FROM `class` WHERE `classID` = {$row['classID']}";

				$classs = $db->query($query);
				if($classs){
					while($c = $classs->fetch_array(MYSQLI_BOTH)){
						$ret[] = $c;
					}
				}*/

				$c = new Period($row['classID']);
				$ret[] = $c;

			}
			return $ret;
		} else {
			return Array();
		}
	}

	public function RemoveClass($classID){
		if(!filter_var($this->assignmentID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong assignmentID
		}
		if(!filter_var($classID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong assignmentID
		}

		$query = "DELETE FROM `assignment_class` WHERE `classID` = $classID AND `assignmentID` = {$this->assignmentID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Removed succesfully
		} else {
			die("Couldn't remove class from assignment: " . $this->assignmentID);
		}
	}

}

/*
$u = new Assignment(1);
$u->AddCriteria(1);
$u->AddPart(1);
$u->AddClass(1);
print_r($u->GetCriteria()); echo "<br>";
print_r($u->GetPart()); echo "<br>";
print_r($u->GetClasses()); echo "<br>";
$u->RemoveCriteria(1);
$u->RemovePart(1);
$u->RemoveClass(1);
*/

?>