<?php
require_once dirname(__FILE__) . "/../system/database.php";

class Evaluation {

	public $evaluationID = -1;
	public $criteriaID;
	public $rating;
	public $comment;
	public $evaluatorID;

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

	public function Save(){
		if($this->evaluationID != -1){
			$query = "UPDATE `evaluation` SET ";
			$query .= "`criteriaID` = '" . $this->criteriaID . "', ";
			$query .= "`rating` = '" . $this->rating . "', ";
			$query .= "`comment` = '" . $this->comment . "', ";
			$query .= "`evaluatorID` = '" . $this->evaluatorID . "', ";
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

}

?>