<?php
############NOTES#################
/*
	To create a new course in the database:
	construct with new course(0) to add new user to the database
	edit the values of the new course object
	update the database with the new values using Save()

	To pull a course from the database:
	construct a course object with course([number]), where [number] is the ID you want

	To delete a course:
	pull the course from the database
	call the Delete() function on the course
*/

require_once dirname(__FILE__) . "/../system/database.php";
require_once dirname(__FILE__) . "/../models2/class.php";

class Course {

	public $courseID = -1;
	public $title;
	public $courseCode;
	public $description;

	public function Course($course_id = -1){
		//PRE: $course_id must be a valid integer
		//POST: -1 returns an empty course, 0 creates a new course in the database, 1+ pulls a course from the database matching the id
		if($course_id <= -1){
			return;
		}

		$this->courseID = $course_id;

		$db = GetDB();

		// If the course_id is equal to zero, then this must be a new course
		if($this->courseID == 0){
			$query = "INSERT INTO `course` () VALUES ()";
			if($db->query($query) === TRUE){
				$this->courseID = $db->insert_id;
			} else {
				$_SESSION['error'] = 628;
				$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
				header("location:error_message.php");
				// die("Couldn't create course");
			}
			return;
		}

		$query = "SELECT * FROM `course` WHERE `courseID` = " . $this->courseID;

		$course = $db->query($query, MYSQLI_STORE_RESULT );
		if($course){
			$course = $course->fetch_array(MYSQLI_BOTH);

			if($course != NULL){
				$this->title = $course['title'];
				$this->courseCode = $course['courseCode'];
				$this->description = $course['description'];
			} else {
				$_SESSION['error'] = 629;
				$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
				header("location:error_message.php");
				// die("Couldn't find course: " . $this->courseID);
			}
		} else {
			$_SESSION['error'] = 630;
			$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
			header("location:error_message.php");
			// die("Couldn't find course: " . $this->courseID);
		}
	}

	public function Save(){
		//POST: Saves the course's current information in the database
		if($this->courseID != -1){
			$query = "UPDATE `course` SET ";
			$query .= "`title` = '" . $this->title . "', ";
			$query .= "`courseCode` = '" . $this->courseCode . "', ";
			$query .= "`description` = '" . $this->description . "', ";
			$query .= "WHERE `courseID` = " . $this->courseID;

			$db = GetDB();
			if($db->query($query) === TRUE){
				// Updated succesfully
			} else {
				$_SESSION['error'] = 631;
				$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
				header("location:error_message.php");
				// die("Couldn't update course: " . $this->courseID);
			}
		}
	}

	public function Delete(){
		//POST: Deletes the course's current information in the database
		if(!filter_var($this->courseID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong courseID
		}

		$query = "DELETE FROM `course` WHERE `courseID` = {$this->courseID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			$_SESSION['error'] = 632;
			$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
			header("location:error_message.php");
			// die("Couldn't delete course: " . $this->courseID);
		}
	}

	############CLASSES###############
	public function CreateAClass(){
		//POST: Creates a new class using this course's information and links it to this course
		$class = new Class(0);
		$class->courseID = $this->courseID;
		$class->title = $this->courseCode;
		$class->description = $this->description;
		$class->Save();
	}

	public function AddAClass($classID = -1){
		//PRE: classID must be a valid integer

		if($classID = -1){
			return;
		}

		$db = GetDB();
		$query = "SELECT 'classID' FROM 'class' WHERE 'classID' = {$classID};";
		$classID = $db->query($query);
		if($classID != null){
			$class = new Class($classID);
			$class->courseID = $this->courseID;
			$class->Save();
		}
		else{
			//error statement
		}
	}
}

?>