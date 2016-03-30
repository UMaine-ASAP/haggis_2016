<?php

require_once __DIR__ . "/../system/bootstrap.php";

function GetDB(){
	$db = new mysqli('localhost', getenv("DB_USERNAME"), getenv("DB_PASSWORD"), getenv("DB_DATABASE"));

	if($db->connect_errno > 0){
	    die('Unable to connect to database [' . $db->connect_error . ']');
	}

	return $db;
}

?>