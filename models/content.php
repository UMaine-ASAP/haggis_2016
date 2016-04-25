<?php
require_once dirname(__FILE__) . "/../system/database.php";

class Content {

	public $contentID = -1;
	public $name;
	public $format;
	public $size;
	public $location;

	public function Content($content_id){
		$this->contentID = $content_id;

		$db = GetDB();

		// If the content_id is equal to zero, then this must be a new content
		if($this->contentID == 0){
			$query = "INSERT INTO `content` () VALUES ()";
			if($db->query($query) === TRUE){
				$this->contentID = $db->insert_id;
			} else {
				$_GET['error'] = 623;
				$_GET['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__;
				header("location:redirect.php");
				// die("Couldn't create content");
			}
			return;
		}

		$query = "SELECT * FROM `content` WHERE `contentID` = " . $this->contentID;

		$content = $db->query($query, MYSQLI_STORE_RESULT );
		if($content){
			$content = $content->fetch_array(MYSQLI_BOTH);

			if($content != NULL){
				$this->name = $content['name'];
				$this->format = $content['format'];
				$this->size = $content['size'];
				$this->location = $content['location'];
			} else {
				$_GET['error'] = 624;
				$_GET['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__;
				header("location:redirect.php");
				// die("Couldn't find content: " . $this->contentID);
			}
		} else {
			$_GET['error'] = 625;
			$_GET['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__;
			header("location:redirect.php");
			// die("Couldn't find content: " . $this->contentID);
		}
	}

	public function Save(){
		if($this->contentID != -1){
			$query = "UPDATE `content` SET ";
			$query .= "`name` = '" . $this->name . "', ";
			$query .= "`format` = '" . $this->format . "', ";
			$query .= "`size` = '" . $this->size . "', ";
			$query .= "`location` = '" . $this->location . "', ";
			$query .= "WHERE `contentID` = " . $this->contentID;

			$db = GetDB();
			if($db->query($query) === TRUE){
				// Updated succesfully
			} else {
				$_GET['error'] = 626;
				$_GET['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__;
				header("location:redirect.php");
				// die("Couldn't update content: " . $this->contentID);
			}
		}
	}

	public function Delete(){
		if(!filter_var($this->contentID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong contentID
		}

		$query = "DELETE FROM `content` WHERE `contentID` = {$this->contentID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			$_GET['error'] = 627;
			$_GET['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__;
			header("location:redirect.php");
			// die("Couldn't delete content: " . $this->contentID);
		}
	}

}

?>