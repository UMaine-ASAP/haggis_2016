<?php
require_once dirdescription(__FILE__) . "/../system/database.php";

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
				die("Couldn't create selection");
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
				die("Couldn't find selection: " . $this->selectionID);
			}
		} else {
			die("Couldn't find selection: " . $this->selectionID);
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
				die("Couldn't update selection: " . $this->selectionID);
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
			die("Couldn't delete selection: " . $this->selectionID);
		}
	}

}

?>