<?php
require_once dirname(__FILE__) . "/../system/database.php";

class Criteria {

	public $criteriaID = -1;
	public $title;
	public $description;

	public function Criteria($criteria_id){
		$this->criteriaID = $criteria_id;

		if($this->criteriaID == -1){
			return;
		}

		$db = GetDB();

		// If the criteria_id is equal to zero, then this must be a new criteria
		if($this->criteriaID == 0){
			$query = "INSERT INTO `criteria` () VALUES ()";
			if($db->query($query) === TRUE){
				$this->criteriaID = $db->insert_id;
			} else {
				die("Couldn't create criteria");
			}
			return;
		}

		$query = "SELECT * FROM `criteria` WHERE `criteriaID` = " . $this->criteriaID;

		$criteria = $db->query($query, MYSQLI_STORE_RESULT );
		if($criteria){
			$criteria = $criteria->fetch_array(MYSQLI_BOTH);

			if($criteria != NULL){
				$this->title = $criteria['title'];
				$this->description = $criteria['description'];
			} else {
				die("Couldn't find criteria: " . $this->criteriaID);
			}
		} else {
			die("Couldn't find criteria: " . $this->criteriaID);
		}
	}

	public function Save(){
		if($this->criteriaID != -1){
			$query = "UPDATE `criteria` SET ";
			$query .= "`title` = '" . $this->title . "', ";
			$query .= "`description` = '" . $this->description . "' ";
			$query .= "WHERE `criteriaID` = " . $this->criteriaID;

			$db = GetDB();
			if($db->query($query) === TRUE){
				// Updated succesfully
			} else {
				die("Couldn't update criteria: " . $this->criteriaID);
			}
		}
	}


	public function Delete(){
		if(!filter_var($this->criteriaID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong criteriaID
		}

		$query = "DELETE FROM `criteria` WHERE `criteriaID` = {$this->criteriaID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			die("Couldn't delete criteria: " . $this->criteriaID);
		}
	}

	public function GetSelections(){

		$query = "SELECT * FROM `criteria_selection` WHERE `criteriaID` = {$this->criteriaID}";

		$db = GetDB();
		$rows = $db->query($query);
		if($rows){
			$ret = Array();
			while($row = $rows->fetch_array(MYSQLI_BOTH)){
				
				$s = new Selection($row['selectionID']);
			
				$ret[] = $s;

			}
			return $ret;
		} else {
			return Array();
		}
	}

	public function AddSelection($selection){
		$query = "INSERT INTO `criteria_selection` (`criteriaID`, `selectionID`) VALUES ";
		$query .="({$this->criteriaID}," .$selection.")";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Created succesfully
		} else {
			die("Couldn't add selection to criteria: " . $this->criteriaID);
		}
	}

	public function GetCriteriaRating($evaluationID){
		$db = GetDB();

		$query =  "SELECT * FROM `evaluation_criteria` WHERE `criteriaID` = {$this->criteriaID} AND `evaluationID` = ".$evaluationID;

		$result = $db->query($query);
		if($result->num_rows != 0){
			$r = $result->fetch_array(MYSQLI_BOTH);
			return $r['rating'];
		}
		else{
			die("Couldn't find group for evaluation: " . $this->evaluationID);
		}
	}
	public function GetCriteriaComments($evaluationID){
	$db = GetDB();

	$query =  "SELECT * FROM `evaluation_criteria` WHERE `criteriaID` = {$this->criteriaID} AND `evaluationID` = ".$evaluationID;

	$result = $db->query($query);
	if($result->num_rows != 0){
		$r = $result->fetch_array(MYSQLI_BOTH);
		return $r['comments'];
	}
	else{
		die("Couldn't find group for evaluation: " . $this->evaluationID);
	}
	}
}

?>