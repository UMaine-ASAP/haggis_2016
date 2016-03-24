<?php 

function GetDB(){
	$db = new mysqli('localhost', 'root', '', 'projecteval');

	if($db->connect_errno > 0){
	    die('Unable to connect to database [' . $db->connect_error . ']');
	}

	return $db;
}

?> 