<?php
require_once dirname(__FILE__) . "/../system/database.php";
require_once dirname(__FILE__) . "/../models/user.php";
require_once dirname(__FILE__) . "/../models/assignment.php";
require_once dirname(__FILE__) . "/../models/criteria.php";
require_once dirname(__FILE__) . "/../models/student_group.php";

class Evaluation {

	public $evaluationID = -1;
	public $criteriaID;
	public $done;
	public $evaluation_type;
	public $target_userID;
	public $groupID;

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
				$_GET['error'] = 641;
				$_GET['error-detailed'] = mysqli_error($db);
				header("location:redirect.php");
				// die("Couldn't create evaluation");
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
				$this->comment = $evaluation['evaluation_type'];
				$this->target_userID = $evaluation['target_userID'];
				$this->evaluation_type = $evaluation['evaluation_type'];
				$this->groupID = $evaluation['groupID'];
			} else {
				$_GET['error'] = 642;
				$_GET['error-detailed'] = mysqli_error($db);
				header("location:redirect.php");
				// die("Couldn't find evaluation: " . $this->evaluationID);
			}
		} else {
			$_GET['error'] = 643;
			$_GET['error-detailed'] = mysqli_error($db);
			header("location:redirect.php");
			// die("Couldn't find evaluation: " . $this->evaluationID);
		}
	}

	public function Add(){

			$query = "INSERT INTO `evaluation`(`criteriaID`, `done`,`evaluation_type`,`target_userID`, `groupID`) VALUES (";
			$query .= $this->criteriaID . "','";
			$query .= $this->done . "','";
			$query .= $this->evaluation_type . "','";
			$query .= $this->target_userID . "','";
			$query .= $this->groupID . "')";

			$db = GetDB();
			if($db->query($query) === TRUE){
				// Updated succesfully
			} else {
				$_GET['error'] = 644;
				$_GET['error-detailed'] = mysqli_error($db);
				header("location:redirect.php");
				// die("Couldn't add evaluation: " . $this->evaluationID);
			}

	}

	public function Save(){
		if($this->evaluationID != -1){
			$query = "UPDATE `evaluation` SET ";
			$query .= "`done` = '" . $this->done . "', ";
			$query .= "`evaluation_type` = '" . $this->evaluation_type . "', ";
			$query .= "`target_userID` = '" . $this->target_userID . "', ";
			$query .= "`groupID` = '" . $this->groupID . "' ";

			$query .= "WHERE `evaluationID` = " . $this->evaluationID;

			$db = GetDB();
			if($db->query($query) === TRUE){
				// Updated succesfully
			} else {
				$_GET['error'] = 645;
				$_GET['error-detailed'] = mysqli_error($db);
				header("location:redirect.php");
				// die("Couldn't update evaluation: " . $this->evaluationID . " " . mysqli_error($db));
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
			$_GET['error'] = 646;
			$_GET['error-detailed'] = mysqli_error($db);
			header("location:redirect.php");
			// die("Couldn't delete evaluation: " . $this->evaluationID);
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
			$_GET['error'] = 647;
			$_GET['error-detailed'] = mysqli_error($db);
			header("location:redirect.php");
			// die("Couldn't find user for evaluationID: " . $this->evaluationID);
		}
	}

	public function GetAssignment(){
		$db = GetDB();

		$query =  "SELECT * FROM `assignment_evaluation` WHERE `evaluationID` = {$this->evaluationID}";

		$result = $db->query($query);
		if($result->num_rows != 0){
			$assign = $result->fetch_array(MYSQLI_BOTH);

			$assignment = new Assignment($assign['assignmentID']);
			return $assignment;
		}
		else{
			$_GET['error'] = 648;
			$_GET['error-detailed'] = mysqli_error($db);
			header("location:redirect.php");
			// die("Couldn't find assignment for evaluation: " . $this->evaluationID);
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

	public function SaveCriteria($criteriaID,$rating,$comments){
		// $query = "UPDATE `evaluation_criteria` SET `evaluationID`={$this->evaluationID},`criteriaID`={$criteriaID},";
		// $query .='`rating`={$rating},`comments`="'. .'"';
		// $query .=" WHERE `evaluationID`={$this->evaluationID} AND `criteriaID` = {$criteriaID}";
		$query = "UPDATE `evaluation_criteria` SET ";
		$query .="`rating`=". $rating .",`comments`='".$comments."' ";
		$query .=" WHERE `evaluationID` = ".$this->evaluationID." AND `criteriaID` = " . $criteriaID;
		$db = GetDB();
		echo $query;
		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			$_GET['error'] = 649;
			$_GET['error-detailed'] = mysqli_error($db);
			header("location:redirect.php");
			// die("Couldn't update criteria for evaluation: " . $this->evaluationID . " " . mysqli_error($db));
		}
	}

	public function AddCriteria($criteria){
		$query = "INSERT INTO `evaluation_criteria` (`evaluationID`, `criteriaID`) VALUES ";
		$query .="({$this->evaluationID}," .$criteria.")";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Created succesfully
		} else {
			$_GET['error'] = 650;
			$_GET['error-detailed'] = mysqli_error($db);
			header("location:redirect.php");
			// die("Couldn't add criteria to evaluation: " . $this->evaluationID);
		}
	}

	public function GetGroup(){
		$db = GetDB();

		$query =  "SELECT * FROM `student_group` WHERE `student_groupID` = {$this->groupID}";

		$result = $db->query($query);
		if($result->num_rows != 0){
			$assign = $result->fetch_array(MYSQLI_BOTH);

			$group = new Student_Group($assign['student_groupID']);
			return $group;
		}
		else{
			$_GET['error'] = 651;
			$_GET['error-detailed'] = mysqli_error($db);
			header("location:redirect.php");
			// die("Couldn't find group for evaluation: " . $this->evaluationID);
		}
	}

	public function AddChildEvaluation($childID){
		$query = "INSERT INTO `evaluation_parent` (`parentID`, `childID`) VALUES ";
		$query .="({$this->evaluationID}," .$childID.")";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Created succesfully
		} else {
			$_GET['error'] = 652;
			$_GET['error-detailed'] = mysqli_error($db);
			header("location:redirect.php");
			// die("Couldn't add child to parent evaluation: " . $this->evaluationID);
		}
	}

	public function GetChildEvaluations(){

		$query = "SELECT * FROM `evaluation_parent` WHERE `parentID` = {$this->evaluationID}";

		$db = GetDB();
		$rows = $db->query($query);
		if($rows){
			$ret = Array();
			while($row = $rows->fetch_array(MYSQLI_BOTH)){
				$e = new Evaluation($row['childID']);
				$ret[] = $e;
			}
			return $ret;
		} else {
			return Array();
		}
	}

	public function GetParentEvaluation(){
		$db = GetDB();

		$query =  "SELECT * FROM `evaluation_parent` WHERE `childID` = {$this->evaluationID}";

		$result = $db->query($query);
		if($result->num_rows != 0){
			$eval = $result->fetch_array(MYSQLI_BOTH);

			$eval = new Evaluation($eval['parentID']);
			return $eval;
		}
		else{
			$_GET['error'] = 653;
			$_GET['error-detailed'] = mysqli_error($db);
			header("location:redirect.php");
			// die("Couldn't find parent for evaluation: " . $this->evaluationID);
		}
	}
}

?>
