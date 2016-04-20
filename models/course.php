<?php
require_once dirname(__FILE__) . "/../system/database.php";

class Course {

	public $courseID = -1;
	public $title;
	public $courseCode;
	public $description;

	public function Course($course_id){
		$this->courseID = $course_id;

		$db = GetDB();

		// If the course_id is equal to zero, then this must be a new course
		if($this->courseID == 0){
			$query = "INSERT INTO `course` () VALUES ()";
			if($db->query($query) === TRUE){
				$this->courseID = $db->insert_id;
			} else {
				$_GET['error'] = 628;
				$_GET['error-detailed'] = mysqli_error($db);
				header("location:redirect.php");
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
				$_GET['error'] = 629;
				$_GET['error-detailed'] = mysqli_error($db);
				header("location:redirect.php");
				// die("Couldn't find course: " . $this->courseID);
			}
		} else {
			$_GET['error'] = 630;
			$_GET['error-detailed'] = mysqli_error($db);
			header("location:redirect.php");
			// die("Couldn't find course: " . $this->courseID);
		}
	}

	public function Save(){
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
				$_GET['error'] = 631;
				$_GET['error-detailed'] = mysqli_error($db);
				header("location:redirect.php");
				// die("Couldn't update course: " . $this->courseID);
			}
		}
	}

	public function Delete(){
		if(!filter_var($this->courseID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong courseID
		}

		$query = "DELETE FROM `course` WHERE `courseID` = {$this->courseID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			$_GET['error'] = 632;
			$_GET['error-detailed'] = mysqli_error($db);
			header("location:redirect.php");
			// die("Couldn't delete course: " . $this->courseID);
		}
	}

}

?>