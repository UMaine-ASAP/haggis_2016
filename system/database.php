<?php 

function GetDB(){
	$db = new mysqli('localhost', 'root', 'AsAp4U8u', 'projecteval');

	if($db->connect_errno > 0){
	    die('Unable to connect to database [' . $db->connect_error . ']');
	}

	return $db;
}

?> 