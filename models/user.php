<?php
require_once dirname(__FILE__) . "/../system/database.php";
require_once dirname(__FILE__) . "/../models/evaluation.php";
require_once dirname(__FILE__) . "/../models/class.php";

class User {

	public $userID = -1;			//A unique number for the user
	public $firstName;				//The user's first name
	public $lastName;				//The user's last name
	public $middleInitial;			//The user's middle initial
	public $userType;				//The type of user, Student or Instructor
	public $email;					//The user's email
	public $password;				//The password for the user
	public $salt;					//A salt encryption for the user's password

	public function User($user_id){
		//PRE: user_id must be 0 for a new user or a valid userID
		//POST: Creates a new user or pulls a user object from the database matching the user_id

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
				$_SESSION['error'] = 668;
				$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
				header("location:error_message.php");
				// die("Couldn't create user");
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
				$_SESSION['error'] = 669;
				$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
				header("location:error_message.php");
				// die("Couldn't find user: " . $this->userID);
			}
		} else {
			$_SESSION['error'] = 670;
			$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
			header("location:error_message.php");
			// die("Couldn't find user: " . $this->userID);
		}
	}

	public function Login($email, $password){
		//POST: pulls a user object where email and password both match

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
		//POST: Saves the user's current information to the database

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
				$_SESSION['error'] = 671;
				$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
				header("location:error_message.php");
				// die("Couldn't update user: " . $this->userID);
			}
		}
		return FALSE;
	}

	public function Delete(){
		//POST: Deletes the user's information from the databse
		if(!filter_var($this->userID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong userID
		}

		$query = "DELETE FROM `user` WHERE `userID` = {$this->userID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			$_SESSION['error'] = 672;
			$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
			header("location:error_message.php");
			// die("Couldn't delete user: " . $this->userID . " Because " . mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__);
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
			$_SESSION['error'] = 673;
			$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
			header("location:error_message.php");
			// die("Couldn't add evaluation to user: " . $this->userID);
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

		$groups = $this->GetGroups();
		if($groups != array()){
		  foreach($groups as $group){
			$query = "SELECT * FROM `evaluation` WHERE `groupID` = {$group->student_groupID}";
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
			$_SESSION['error'] = 674;
			$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
			header("location:error_message.php");
			// die("Couldn't remove evaluation from user: " . $this->userID);
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

	public function GetGroups(){
		$db = GetDB();
		$query = "SELECT * FROM `student_group_user` WHERE `userID` = {$this->userID}";

		$rows = $db->query($query);
		if($rows){
			$ret = Array();
			while($row = $rows->fetch_array(MYSQLI_BOTH)){
				
				$g = new Student_Group($row['student_groupID']);
				$ret[] = $g;

			}
			return $ret;
		} else {
			return Array();
		}
	}

	static public function ResetPassword($code){
		$db = GetDB();
		$email = $_POST['postEmail'];
		$query = "SELECT * FROM `user` WHERE `email` = '$email'";
		$rows = $db->query($query);
		$ret = [];
		//if the query returns a user
		if($rows){
			while ($row = $rows->fetch_array(MYSQLI_BOTH)){
				$user = new User($row['userID']);
				$ret[] = $user;
			}
			//if the user is found return true
			if (isset($ret[0])){
				$query = "UPDATE user SET passreset = '$code' WHERE email = '$email'";
				//if the passrest field is updated
				if($db->query($query) === TRUE){

					return true;
				//if not
				}else{

					return false;
				}
				

			}
			//if not return false
			else{
				return false;
			}
		}
		//if DB query fails
		else{
			return "Please try again";
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