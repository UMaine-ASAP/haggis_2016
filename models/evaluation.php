<?php
require_once dirname(__FILE__) . "/../system/database.php";
require_once dirname(__FILE__) . "/../models/user.php";

class Evaluation {

	public $evaluationID = -1;
	public $criteriaID;
	public $done;
	public $comment;
	public $target_userID;

	public function Evaluation($class_id){
		$this->evaluationID = $class_id;

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
				$this->done = $evaluation['done'];
				$this->comment = $evaluation['comment'];
				$this->target_userID = $evaluation['target_userID'];
			} else {
				die("Couldn't find evaluation: " . $this->evaluationID);
			}
		} else {
			die("Couldn't find evaluation: " . $this->evaluationID);
		}
	}

	public function Save(){
		if($this->evaluationID != -1){
			$query = "UPDATE `evaluation` SET ";
			$query .= "`criteriaID` = '" . $this->criteriaID . "', ";
			$query .= "`done` = '" . $this->done . "', ";
			$query .= "`comment` = '" . $this->comment . "', ";
			$query .= "`target_userID` = '" . $this->target_userID . "', ";
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

}

?>