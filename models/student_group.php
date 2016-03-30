<?php
require_once dirname(__FILE__) . "/../system/database.php";

class Student_Group {

	public $student_groupID = -1;
	public $assignmentID;
	public $name;

	public function Student_Group($id){
		$this->student_groupID = $id;

		if($this->student_groupID == -1){
			return;
		}

		$db = GetDB();

		// If the criteria_id is equal to zero, then this must be a new criteria
		if($this->student_groupID == 0){
			$query = "INSERT INTO `criteria` () VALUES ()";
			if($db->query($query) === TRUE){
				$this->student_groupID = $db->insert_id;
			} else {
				die("Couldn't create criteria");
			}
			return;
		}

		$query = "SELECT * FROM `student_group` WHERE `student_groupID` = " . $this->student_groupID;

		$group = $db->query($query, MYSQLI_STORE_RESULT );
		if($group){
			$group = $group->fetch_array(MYSQLI_BOTH);

			if($group != NULL){
				$this->assignmentID = $group['assignmentID'];
				$this->name = $group['name'];
			} else {
				die("Couldn't find group: " . $this->criteriaID);
			}
		} else {
			die("Couldn't find group: " . $this->criteriaID);
		}
	}

	public function Save(){
		if($this->student_groupID != -1){
			$query = "UPDATE `student_group` SET ";
			$query .= "`assignmentID` = '" . $this->assignmentID . "', ";
			$query .= "`name` = '" . $this->name . "' ";
			$query .= "WHERE `student_groupID` = " . $this->student_groupID;

			$db = GetDB();
			if($db->query($query) === TRUE){
				// Updated succesfully
			} else {
				die("Couldn't update group: " . $this->student_groupID);
			}
		}
	}

	public function SaveResult(){
		if($this->student_groupID != -1){
			$query = "UPDATE `student_group` SET `assignmentID` = '".$this->assignmentID."' ";
			$query .= " WHERE `student_group`.`student_groupID` = ".$this->student_groupID;

			$db = GetDB();
			if($db->query($query) === TRUE){
				// Updated succesfully
			} else {
				die("Couldn't update group: " . $this->student_groupID);
			}
		}
	}	

	public function Delete(){
		if(!filter_var($this->student_groupID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong criteriaID
		}

		$query = "DELETE FROM `student_group` WHERE `student_groupID` = {$this->student_groupID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			die("Couldn't delete group: " . $this->student_groupID);
		}
	}

}

?>