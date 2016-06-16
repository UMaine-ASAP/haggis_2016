<?php
############NOTES#################
/*
	To create a new user in the database:
	construct with new class(0) to add new user to the database
	edit the values of the new class object
	update the database with the new values using Save()

	To pull a user from the database:
	construct a class object with class([number]), where [number] is the ID you want

	To delete a class:
	pull the class from the database
	call the Delete() function on the class
*/

require_once dirname(__FILE__) . "/../system/database.php";
require_once dirname(__FILE__) . "/../models2/user.php";

class Class {

	public $classID = -1;
	public $title;
	public $courseID;
	public $sessionTime;
	public $description;
	public $location;

	public function Class($class_id = -1){
		//PRE: class_id must be a valid integer
		//POST: -1 returns an empty class, 0 creates a new class in the database, 1+ pulls a class from the database matching the ID 
		if($class_id <= -1){
			return;
		}

		$this->classID = $class_id;

		$db = GetDB();

		// If the class_id is equal to zero, then this must be a new class
		if($this->classID == 0){
			$query = "INSERT INTO `class` () VALUES ()";
			if($db->query($query) === TRUE){
				$this->classID = $db->insert_id;
			} else {
				$_SESSION['error'] = 615;
				$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
				header("location:error_message.php");
				// die("Couldn't create class");
			}
			return;
		}

		$query = "SELECT * FROM `class` WHERE `classID` = " . $this->classID;

		$class = $db->query($query, MYSQLI_STORE_RESULT );
		if($class){
			$class = $class->fetch_array(MYSQLI_BOTH);

			if($class != NULL){
				$this->title = $class['title'];
				$this->courseID = $class['courseID'];
				$this->sessionTime = $class['sessionTime'];
				$this->description = $class['description'];
				$this->location = $class['location'];
			} else {
				$_SESSION['error'] = 616;
				$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
				header("location:error_message.php");
				// die("Couldn't find class: " . $this->classID);
			}
		} else {
			$_SESSION['error'] = 617;
			$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
			header("location:error_message.php");
			// die("Couldn't find class: " . $this->classID);
		}
	}

	public function Save(){
		//POST: Saves the class' current information in the database
		if($this->classID != -1){
			$query = "UPDATE `class` SET ";
			$query .= "`title` = '" . $this->title . "', ";
			$query .= "`courseID` = '" . $this->courseID . "', ";
			$query .= "`sessionTime` = '" . $this->sessionTime . "', ";
			$query .= "`description` = '" . $this->description . "', ";
			$query .= "`location` = '" . $this->location . "' ";
			$query .= "WHERE `classID` = " . $this->classID;

			$db = GetDB();
			if($db->query($query) === TRUE){
				// Updated succesfully
			} else {
				$_SESSION['error'] = 618;
				$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
				header("location:error_message.php");
				// die("Couldn't update class: " . $this->classID . " " . mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__);
			}
		}
	}

	/*public function Add(){
		//POST: this is a literally useless function, never use it
		$query = "INSERT INTO `class` (`classID`, `title`, `courseID`, `sessionTime`, `description`, `location`) VALUES (";
		$query .= "NULL, ";
		$query .= $this->title . "','";
		$query .= $this->courseID . "','";
		$query .= $this->sessionTime . "','";
		$query .= $this->description . "','";
		$query .= $this->location . "')";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			$_SESSION['error'] = 619;
			$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
			header("location:error_message.php");
			// die("Couldn't update class: " . $this->classID . " " . mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__);
		}
	}*/

	public function Delete(){
		//POST: Deletes the class from the database
		if(!filter_var($this->classID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong classID
		}

		$query = "DELETE FROM `class` WHERE `classID` = {$this->classID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			$_SESSION['error'] = 620;
			$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
			header("location:error_message.php");
			// die("Couldn't delete class: " . $this->classID);
		}
	}

	############USERS#################
	public function AddUser(){

	}
}
?>