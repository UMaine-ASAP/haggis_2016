<?php
require_once dirname(__FILE__) . "/../system/database.php";

class Student_Group {

	public $student_groupID = -1;
	public $assignmentID;
	public $groupNumber;

	public function Student_Group($id){
		$this->student_groupID = $id;

		if($this->student_groupID == -1){
			return;
		}

		$db = GetDB();

		// If the criteria_id is equal to zero, then this must be a new criteria
		if($this->student_groupID == 0){
			$query = "INSERT INTO `student_group` () VALUES ()";
			if($db->query($query) === TRUE){
				$this->student_groupID = $db->insert_id;
			} else {
				$_SESSION['error'] = 659;
				$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
				header("location:error_message.php");
				// die("Couldn't create criteria");
			}
			return;
		}

		$query = "SELECT * FROM `student_group` WHERE `student_groupID` = " . $this->student_groupID;

		$group = $db->query($query, MYSQLI_STORE_RESULT );
		if($group){
			$group = $group->fetch_array(MYSQLI_BOTH);

			if($group != NULL){
				$this->assignmentID = $group['assignmentID'];
				$this->groupNumber = $group['groupNumber'];
			} else {
				$_SESSION['error'] = 660;
				$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
				header("location:error_message.php");
				// die("Couldn't find group: " . $this->criteriaID);
			}
		} else {
			$_SESSION['error'] = 661;
			$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
			header("location:error_message.php");
			// die("Couldn't find group: " . $this->criteriaID);
		}
	}

	public function Save(){
		if($this->student_groupID != -1){
			$query = "UPDATE `student_group` SET ";
			$query .= "`assignmentID` = '" . $this->assignmentID . "', ";
			$query .= "`groupNumber` = '" . $this->groupNumber . "' ";
			$query .= "WHERE `student_groupID` = " . $this->student_groupID;

			$db = GetDB();
			if($db->query($query) === TRUE){
				// Updated succesfully
			} else {
				$_SESSION['error'] = 662;
				$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
				header("location:error_message.php");
				// die("Couldn't update group: " . $this->student_groupID);
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
				$_SESSION['error'] = 663;
				$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
				header("location:error_message.php");
				// die("Couldn't update group: " . $this->student_groupID);
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
			$_SESSION['error'] = 664;
			$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
			header("location:error_message.php");
			// die("Couldn't delete group: " . $this->student_groupID);
		}
	}
	public function GetUsers(){

		$query = "SELECT * FROM `student_group_user` WHERE `student_groupID` = {$this->student_groupID}";

		$db = GetDB();
		$rows = $db->query($query);
		if($rows){
			$ret = Array();
			while($row = $rows->fetch_array(MYSQLI_BOTH)){
				
				$u = new User($row['userID']);
				$ret[] = $u;

			}
			return $ret;
		} else {
			return Array();
		}
	}

	public function AddUser($userID){
		if(!filter_var($this->student_groupID, FILTER_VALIDATE_INT) === TRUE){
			return; 
		}

		$query = "INSERT INTO `student_group_user`(`student_groupID`, `userID`) VALUES (".$this->student_groupID.", ". $userID .")";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			$_SESSION['error'] = 665;
			$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
			header("location:error_message.php");
			// die("Couldn't add group user: " . $userID);
		}
	}

	public function RemoveUser($userID){
		if(!filter_var($this->student_groupID, FILTER_VALIDATE_INT) === TRUE){
			return; 
		}

		$query = "DELETE FROM `student_group_user` WHERE `userID` = {$userID} AND `student_groupID` = {$this->student_groupID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			$_SESSION['error'] = 666;
			$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
			header("location:error_message.php");
			// die("Couldn't delete group user: " . $userID);
		}
	}

	public function GetOtherGroups(){

		$query = "SELECT * FROM `student_group` WHERE `assignmentID` = {$this->assignmentID} AND ";
		$query .= "`student_groupID` <> {$this->student_groupID}";

		$db = GetDB();
		$rows = $db->query($query);
		if($rows){
			$ret = Array();
			while($row = $rows->fetch_array(MYSQLI_BOTH)){
				
				$u = new Student_Group($row['student_groupID']);
				$ret[] = $u;

			}
			return $ret;
		} else {
			return Array();
		}
	}

	public function GetReceivedEvaluations(){
		
		$ret = Array();
		$db = GetDB();

		$query = "SELECT * FROM `evaluation` WHERE `groupID` = {$this->student_groupID}";
		$rows = $db->query($query);
		if($rows){
			while($row = $rows->fetch_array(MYSQLI_BOTH)){
				
				/*
				$query = "SELECT * FROM `evaluation` WHERE `evaluationID` = {$row['evaluationID']}";

				$evaluationes = $db->query($query);
				if($evaluationes){
					while($evaluation = $evaluationes->fetch_array(MYSQLI_BOTH)){
						$ret[] = $evaluation;
					}
				}
				*/

				$e = new Evaluation($row['evaluationID']);
				$ret[] = $e;
			}
		}
		else
		{
			$_SESSION['error'] = 667;
			$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
			header("location:error_message.php");
		}
		return $ret;
	}
}

?>