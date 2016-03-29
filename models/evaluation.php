<?php
require_once dirname(__FILE__) . "/../system/database.php";
require_once dirname(__FILE__) . "/../models/user.php";
require_once dirname(__FILE__) . "/../models/assignment.php";
require_once dirname(__FILE__) . "/../models/criteria.php";

class Evaluation {

	public $evaluationID = -1;
	public $criteriaID;
	public $rating;
	public $comment;
	public $evaluatorID;

	public function Evaluation($class_id){
		$this->evaluationID = $class_id;

		if($this->evaluationID == -1){
			return;
		}

		$db = GetDB();

		// If the evaluation_id is equal to zero, then this must be a new evaluation
		if($this->evaluationID == 0){
			$query = "INSERT INTO `evaluation` () VALUES ()";
			if($db->query($query) === TRUE){
				$this->evaluationID = $db->insert_id;
			} else {
				die("Couldn't create evaluation");
			}
			return;
		}

		$query = "SELECT * FROM `evaluation` WHERE `evaluationID` = " . $this->evaluationID;

		$evaluation = $db->query($query, MYSQLI_STORE_RESULT );
		if($evaluation){
			$evaluation = $evaluation->fetch_array(MYSQLI_BOTH);

			if($evaluation != NULL){
				$this->criteriaID = $evaluation['criteriaID'];
				$this->rating = $evaluation['rating'];
				$this->comment = $evaluation['comment'];
				$this->evaluatorID = $evaluation['evaluatorID'];
			} else {
				die("Couldn't find evaluation: " . $this->evaluationID);
			}
		} else {
			die("Couldn't find evaluation: " . $this->evaluationID);
		}
	}

	public function Add(){
		
			$query = "INSERT INTO `evaluation`(`evaluationID`, `criteriaID`, `rating`, `comment`, `evaluatorID`) VALUES (";
			$query .= "NULL,'";
			$query .= $this->criteriaID . "','";
			$query .= $this->rating . "','";
			$query .= $this->comment . "','";
			$query .= $this->evaluatorID . "')";

			$db = GetDB();
			if($db->query($query) === TRUE){
				// Updated succesfully
			} else {
				die("Couldn't add evaluation: " . $this->evaluationID);
			}
		
	}

	public function Save(){
		if($this->evaluationID != -1){
			$query = "UPDATE `evaluation` SET ";
			$query .= "`criteriaID` = '"	 	. $this->criteriaID . "', ";
			$query .= "`rating` = '" 			. $this->rating . "', ";
			$query .= "`comment` = '" 			. $this->comment . "', ";
			$query .= "`evaluatorID` = '"		. $this->evaluatorID . "' ";
			$query .= "WHERE `evaluationID` = " . $this->evaluationID;

			$db = GetDB();
			if($db->query($query) === TRUE){
				// Updated succesfully
			} else {
				die("Couldn't update evaluation: " . $this->evaluationID);
			}
		}
	}

	public function Delete(){
		if(!filter_var($this->evaluationID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong evaluationID
		}

		$query = "DELETE FROM `evaluation` WHERE `evaluationID` = {$this->evaluationID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			die("Couldn't delete evaluation: " . $this->evaluationID);
		}
	}

////////////////////////////////////////////////////////////// USERS

	public function GetUser(){
		$db = GetDB();


		$query =  "SELECT * FROM `user_evaluation` WHERE `evaluationID` = {$this->evaluationID}";

		
		$result = $db->query($query);
		if($result->num_rows != 0){
			$user = $result->fetch_array(MYSQLI_BOTH);

			$user = new User ($user['userID']);
			return $user;
		}
		else{
			die("Couldn't find user for evaluationID: " . $this->evaluationID);
		}
	}	

	public function GetAssignment(){
		$db = GetDB();

		$query =  "SELECT * FROM `assignment_criteria` WHERE `assignmentID` = {$this->criteriaID}";
		
		$result = $db->query($query);
		if($result->num_rows != 0){
			$assign = $result->fetch_array(MYSQLI_BOTH);

			$assignment = new Assignment($assign['assignmentID']);
			return $assignment;
		}
		else{
			die("Couldn't find assignment for criteria: " . $this->criteriaID);
		}
	}
////////////////////////////////////////////////////////////// CRITERIA
	public function GetCriteria(){

		$query = "SELECT * FROM `evaluation_criteria` WHERE `evaluationID` = {$this->evaluationID}";

		$db = GetDB();
		$rows = $db->query($query);
		if($rows){
			$ret = Array();
			while($row = $rows->fetch_array(MYSQLI_BOTH)){
					
				$u = new Criteria($row['criteriaID']);
				$ret[] = $u;

			}
			return $ret;
		} else {
			return Array();
		}
	}
}

?>