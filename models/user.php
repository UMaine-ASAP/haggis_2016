<?php
require_once dirname(__FILE__) . "/../system/database.php";
require_once dirname(__FILE__) . "/../models/evaluation.php";
require_once dirname(__FILE__) . "/../models/class.php";

class User {

	public $userID = -1;
	public $firstName;
	public $lastName;
	public $middleInitial;
	public $userType;
	public $email;
	public $password;
	public $salt;

	public function User($user_id){
		//check to see if valid user_id
		if($user_id <= -1){
			return;
		}

		$this->userID = $user_id;

		$db = GetDB();

		// If the user_id is equal to zero, then this must be a new user
		if($this->userID == 0){
			$query = "INSERT INTO `user` () VALUES ()";
			if($db->query($query) === TRUE){
				$this->userID = $db->insert_id;
			} else {
				die("Couldn't create user");
			}
			return;
		}

		$query = "SELECT * FROM `user` WHERE `userID` = " . $this->userID;

		$user = $db->query($query, MYSQLI_STORE_RESULT );
		if($user){
			$user = $user->fetch_array(MYSQLI_BOTH);

			if($user != NULL){
				$this->firstName = $user['firstName'];
				$this->lastName = $user['lastName'];
				$this->middleInitial = $user['middleInitial'];
				$this->userType = $user['userType'];
				$this->email = $user['email'];
				$this->password = $user['password'];
				$this->salt = $user['salt'];
			} else {
				die("Couldn't find user: " . $this->userID);
			}
		} else {
			die("Couldn't find user: " . $this->userID);
		}
	}

	public function Login($email, $password){
		$db = GetDB();

		//query for the user in the database using credentials
		$query = "SELECT `password`, `salt` FROM `user` WHERE `email` = '".$email."';";
		$result = $db->query($query);
		$credentials = $result->fetch_array(MYSQLI_BOTH);

		$query = "SELECT * FROM `user` WHERE `email` = '" .  $email . "' AND `password` = '" .  hash("sha512",$password.$credentials["salt"],false) . "';";
		$result = $db->query($query);

		// $query = "SELECT * FROM `user` WHERE `email` = '" .  $email . "' AND `password` = '" .  $password . "';";
		// $result = $db->query($query);

		//if the result isn't empty
		if($result->num_rows != 0){
			$user = $result->fetch_array(MYSQLI_BOTH);

			$this->userID = $user['userID'];
			$this->firstName = $user['firstName'];
			$this->lastName = $user['lastName'];
			$this->middleInitial = $user['middleInitial'];
			$this->userType = $user['userType'];
			$this->email = $user['email'];
			$this->password = $user['password'];
		}
	}

	public function Save(){
		if($this->userID != -1){
			$query = "UPDATE `user` SET ";
			$query .= "`firstName` = '" . $this->firstName . "', ";
			$query .= "`lastName` = '" . $this->lastName . "', ";
			$query .= "`middleInitial` = '" . $this->middleInitial . "', ";
			$query .= "`userType` = '" . $this->userType . "', ";
			$query .= "`email` = '" . $this->email . "', ";
			$query .= "`password` = '" . $this->password . "', ";
			$query .= "`salt` = '" . $this->salt . "' ";
			$query .= "WHERE `userID` = " . $this->userID;

			$db = GetDB();
			if($db->query($query) === TRUE){
				// Updated succesfully
				return TRUE;
			} else {
				return FALSE;
				die("Couldn't update user: " . $this->userID);
			}
		}
		return FALSE;
	}

	public function Delete(){
		if(!filter_var($this->userID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong userID
		}

		$query = "DELETE FROM `user` WHERE `userID` = {$this->userID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			die("Couldn't delete user: " . $this->userID . " Because " . mysqli_error($db));
		}
	}


////////////////////////////////////////////////////////////// EVALUATIONES

	public function AddEvaluation($evaluationID){
		if(!filter_var($this->userID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong userID
		}
		if(!filter_var($evaluationID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong evaluationID
		}
		$this->userType = filter_var($this->userType, FILTER_SANITIZE_STRING);

		$query = "INSERT INTO `user_evaluation` (`evaluationID`, `userID`) VALUES ($evaluationID, {$this->userID})";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Created succesfully
		} else {
			die("Couldn't add evaluation to user: " . $this->userID);
		}
	}

	public function GetEvaluations(){
		if(!filter_var($this->userID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong userID
		}

		$query = "SELECT * FROM `user_evaluation` WHERE `userID` = {$this->userID}";

		$db = GetDB();
		$rows = $db->query($query);
		if($rows){
			$ret = Array();
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
			return $ret;
		} else {
			return Array();
		}
	}

	public function GetReceivedEvaluations(){
		if(!filter_var($this->userID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong userID
		}

		$query = "SELECT * FROM `evaluation` WHERE `target_userID` = {$this->userID}";
		$ret = Array();
		$db = GetDB();
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

		$query = "SELECT * FROM `evaluation` WHERE `groupID` = {$this->GetGroup()->student_groupID}";
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
		return $ret;
	}

	public function RemoveEvaluation($evaluationID){
		if(!filter_var($this->userID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong userID
		}
		if(!filter_var($evaluationID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong evaluationID
		}

		$query = "DELETE FROM `user_evaluation` WHERE `evaluationID` = $evaluationID AND `userID` = {$this->userID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Removed succesfully
		} else {
			die("Couldn't remove evaluation from user: " . $this->userID);
		}
	}

////////////////////////////////////////////////////////////// Classes
	public function GetClasses(){

			$query = "SELECT * FROM `class_user` WHERE `userID` = {$this->userID}";

			$db = GetDB();
			$rows = $db->query($query);
			if($rows){
				$ret = Array();
				while($row = $rows->fetch_array(MYSQLI_BOTH)){
					
					$u = new Period($row['classID']);
					$ret[] = $u;

				}
				return $ret;
			} else {
				return Array();
			}
	}

	public function GetGroup(){
		$db = GetDB();
		$query = "SELECT * FROM `student_group_user` WHERE `userID` = {$this->userID}";

		$result = $db->query($query);
		if($result->num_rows != 0){
			$group = $result->fetch_array(MYSQLI_BOTH);

			$group = new Student_Group ($group['student_groupID']);
			return $group;
		}
		else{
			return FALSE;
			die("Couldn't find group for userID: " . $this->userID);
		}
	}

}






/*
$u = new User(1);
$u->AddEvaluation(1);
print_r($u->GetEvaluations()); echo "<br>";
$u->RemoveEvaluation(1);
*/

?>