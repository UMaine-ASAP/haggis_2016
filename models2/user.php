<?php
############NOTES#################
/*
	To create a new user in the database:
	construct with new User(0) to add new user to the database
	edit the values of the new user object
	update the database with the new values using Save()

	To pull a user from the database:
	construct a User object with User([number]), where [number] is the ID you want

	To delete a user:
	pull the user from the database
	call the Delete() function on the user

	To login a user:
	use the Login() function with the email and password of choice
*/


require_once dirname(__FILE__) . "/../system/database.php";

class User {

	public $userID = -1;			//A unique number for the user
	public $firstName;				//The user's first name
	public $lastName;				//The user's last name
	public $middleInitial;			//The user's middle initial
	public $userType;				//The type of user, Student or Instructor
	public $email;					//The user's email
	public $password;				//The password for the user
	public $salt;					//A salt encryption for the user's password

	public function User($user_id = -1){
		//PRE: user_id must be a valid integer
		//POST: -1 creates an empty user, 0 creates a new user in the database, 1+ pulls a user from the database

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
		//PRE: email must be in a name@address format and password must be a string
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

	static public function ConfirmResetPassword($code,$email){
		$db =GetDB();

		$query = "SELECT * FROM user WHERE passreset = '$code' AND email = '$email'";

		if($rows = $db->query($query)){
			echo "yeaahh mannnn";
			return true;
		}else{
			echo "Password Reset Failed, Wrong Email or Code";
		}
	}

}
?>