<?php
require_once dirname(__FILE__) . "/../system/database.php";
require_once dirname(__FILE__) . "/../models/evaluation.php";
require_once dirname(__FILE__) . "/../models/content.php";
require_once dirname(__FILE__) . "/../models/criteria.php";

class Part {

	public $partID = -1;
	public $title;
	public $description;

	public function Part($part_ID){
		$this->partID = $part_ID;

		$db = GetDB();

		// If the part_id is equal to zero, then this must be a new part
		if($this->partID == 0){
			$query = "INSERT INTO `part` () VALUES ()";
			if($db->query($query) === TRUE){
				$this->partID = $db->insert_id;
			} else {
				die("Couldn't create part");
			}
			return;
		}

		$query = "SELECT * FROM `part` WHERE `partID` = " . $this->partID;

		$part = $db->query($query, MYSQLI_STORE_RESULT );
		if($part){
			$part = $part->fetch_array(MYSQLI_BOTH);

			if($part != NULL){
				$this->title = $part['title'];
				$this->description = $part['description'];
			} else {
				die("Couldn't find part: " . $this->partID);
			}
		} else {
			die("Couldn't find part: " . $this->partID);
		}
	}

	public function Save(){
		if($this->partID != -1){
			$query = "UPDATE `part` SET ";
			$query .= "`title` = '" . $this->title . "', ";
			$query .= "`description` = '" . $this->description . "', ";
			$query .= "WHERE `partID` = " . $this->partID;

			$db = GetDB();
			if($db->query($query) === TRUE){
				// Updated succesfully
			} else {
				die("Couldn't update part: " . $this->partID);
			}
		}
	}

	public function Delete(){
		if(!filter_var($this->partID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong partID
		}

		$query = "DELETE FROM `part` WHERE `partID` = {$this->partID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			die("Couldn't delete part: " . $this->partID);
		}
	}

/////////////////////////////////////////////////////////////////// CONTENT

	public function AddContent($contentID){
		if(!filter_var($this->partID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong partID
		}
		if(!filter_var($contentID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong partID
		}

		$query = "INSERT INTO `part_content` (`partID`, `ContentID`) VALUES ({$this->partID}, $contentID)";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Created succesfully
		} else {
			die("Couldn't add content to part: " . $this->partID);
		}
	}

	public function GetContents(){
		if(!filter_var($this->partID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong partID
		}

		$query = "SELECT * FROM `part_content` WHERE `partID` = {$this->partID}";

		$db = GetDB();
		$rows = $db->query($query);
		if($rows){
			$ret = Array();
			while($row = $rows->fetch_array(MYSQLI_BOTH)){
				
				/*$query = "SELECT * FROM `content` WHERE `contentID` = {$row['contentID']}";

				$contents = $db->query($query);
				if($contents){
					while($c = $contents->fetch_array(MYSQLI_BOTH)){
						$ret[] = $c;
					}
				}*/

				$c = new Content($row['contentID']);
				$ret[] = $c;

			}
			return $ret;
		} else {
			return Array();
		}
	}

	public function RemoveContent($contentID){
		if(!filter_var($this->partID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong partID
		}
		if(!filter_var($contentID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong partID
		}

		$query = "DELETE FROM `part_content` WHERE `contentID` = $contentID AND `partID` = {$this->partID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Removed succesfully
		} else {
			die("Couldn't remove content from part: " . $this->partID);
		}
	}

/////////////////////////////////////////////////////////////////// EVALUATION

	public function AddEvaluation($evaluationID){
		if(!filter_var($this->partID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong partID
		}
		if(!filter_var($evaluationID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong partID
		}

		$query = "INSERT INTO `part_evaluation` (`partID`, `EvaluationID`) VALUES ({$this->partID}, $evaluationID)";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Created succesfully
		} else {
			die("Couldn't add evaluation to part: " . $this->partID);
		}
	}

	public function GetEvaluations(){
		if(!filter_var($this->partID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong partID
		}

		$query = "SELECT * FROM `part_evaluation` WHERE `partID` = {$this->partID}";

		$db = GetDB();
		$rows = $db->query($query);
		if($rows){
			$ret = Array();
			while($row = $rows->fetch_array(MYSQLI_BOTH)){
				
				/*$query = "SELECT * FROM `evaluation` WHERE `evaluationID` = {$row['evaluationID']}";

				$evaluations = $db->query($query);
				if($evaluations){
					while($c = $evaluations->fetch_array(MYSQLI_BOTH)){
						$ret[] = $c;
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
		if(!filter_var($this->partID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong partID
		}
		if(!filter_var($evaluationID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong partID
		}

		$query = "DELETE FROM `part_evaluation` WHERE `evaluationID` = $evaluationID AND `partID` = {$this->partID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Removed succesfully
		} else {
			die("Couldn't remove evaluation from part: " . $this->partID);
		}
	}

/////////////////////////////////////////////////////////////////// CRITERIA

	public function AddCriteria($criteriaID){
		if(!filter_var($this->partID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong partID
		}
		if(!filter_var($criteriaID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong partID
		}

		$query = "INSERT INTO `part_criteria` (`partID`, `CriteriaID`) VALUES ({$this->partID}, $criteriaID)";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Created succesfully
		} else {
			die("Couldn't add criteria to part: " . $this->partID);
		}
	}

	public function GetCriteria(){
		if(!filter_var($this->partID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong partID
		}

		$query = "SELECT * FROM `part_criteria` WHERE `partID` = {$this->partID}";

		$db = GetDB();
		$rows = $db->query($query);
		if($rows){
			$ret = Array();
			while($row = $rows->fetch_array(MYSQLI_BOTH)){
				
				/*$query = "SELECT * FROM `criteria` WHERE `criteriaID` = {$row['criteriaID']}";

				$criterias = $db->query($query);
				if($criterias){
					while($c = $criterias->fetch_array(MYSQLI_BOTH)){
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
		if(!filter_var($this->partID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong partID
		}
		if(!filter_var($criteriaID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong partID
		}

		$query = "DELETE FROM `part_criteria` WHERE `criteriaID` = $criteriaID AND `partID` = {$this->partID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Removed succesfully
		} else {
			die("Couldn't remove criteria from part: " . $this->partID);
		}
	}

}

/*
$u = new Part(1);
$u->AddContent(1);
print_r($u->GetContents()); echo "<br>";
$u->RemoveContent(1);
$u->AddEvaluation(1);
print_r($u->GetEvaluations()); echo "<br>";
$u->RemoveEvaluation(1);
$u->AddCriteria(1);
print_r($u->GetCriteria()); echo "<br>";
$u->RemoveCriteria(1);
*/

?>