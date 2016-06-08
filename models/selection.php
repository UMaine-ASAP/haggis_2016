<?php
require_once dirname(__FILE__) . "/../system/database.php";

class Selection {

	public $selectionID = -1;
	public $description;

	public function Selection($selection_id){

		$this->selectionID = $selection_id;

		$db = GetDB();

		// If the selection_id is equal to zero, then this must be a new selection
		if($this->selectionID == 0){
			$query = "INSERT INTO `selection` () VALUES ()";
			if($db->query($query) === TRUE){
				$this->selectionID = $db->insert_id;
			} else {
				$_SESSION['error'] = 654;
				$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
				header("location:error_message.php");
				// die("Couldn't create selection");
			}
			return;
		}

		$query = "SELECT * FROM `selection` WHERE `selectionID` = " . $this->selectionID;

		$selection = $db->query($query, MYSQLI_STORE_RESULT );
		if($selection){
			$selection = $selection->fetch_array(MYSQLI_BOTH);

			if($selection != NULL){
				$this->description = $selection['description'];
			} else {
				$_SESSION['error'] = 655;
				$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
				header("location:error_message.php");
				// die("Couldn't find selection: " . $this->selectionID);
			}
		} else {
			$_SESSION['error'] = 656;
			$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
			header("location:error_message.php");
			// die("Couldn't find selection: " . $this->selectionID);
		}
	}

	public function Save(){
		if($this->selectionID != -1){
			$query = "UPDATE `selection` SET ";
			$query .= "`description` = '" . $this->description . "' ";
			$query .= "WHERE `selectionID` = " . $this->selectionID;

			$db = GetDB();
			if($db->query($query) === TRUE){
				// Updated succesfully
			} else {
				$_SESSION['error'] = 657;
				$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
				header("location:error_message.php");
				// die("Couldn't update selection: " . $this->selectionID);
			}
		}
	}

	public function Delete(){
		if(!filter_var($this->selectionID, FILTER_VALIDATE_INT) === TRUE){
			return; // Wrong selectionID
		}

		$query = "DELETE FROM `selection` WHERE `selectionID` = {$this->selectionID}";

		$db = GetDB();
		if($db->query($query) === TRUE){
			// Updated succesfully
		} else {
			$_SESSION['error'] = 658;
			$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__;
			header("location:error_message.php");
			// die("Couldn't delete selection: " . $this->selectionID);
		}
	}

	public function GetCriteria(){
		//POST: Returns the criteria this selection belongs to
		$query = "SELECT * FROM `criteria_selection` WHERE `selectionID` = {$this->selectionID}";

		$db = GetDB();
		$rows = $db->query($query);
		if($rows){
			while($row = $rows->fetch_array(MYSQLI_BOTH)){
				$s = new Criteria($row['criteriaID']);
			}
			return $s;
		} else {
			$_SESSION['error'] = 675;
			$_SESSION['error-detailed'] = mysqli_error($db)." On Line: ".__LINE__." of file ".__FILE__."
			SelectionID: ".$this->selectionID;
			header("location:error_message.php");
		}
	}

}

?>