<?php

require __DIR__ . '/../vendor/autoload.php';

// Load .env file
$dotenv = new Dotenv\Dotenv(__DIR__ . "/..");
$dotenv->load();

function GetDB(){
<<<<<<< HEAD
	$db = new mysqli('localhost', 'root', 'projecteval', 'projecteval');
=======
	$db = new mysqli('localhost', getenv("DB_USERNAME"), getenv("DB_PASSWORD"), getenv("DB_DATABASE"));
>>>>>>> master

	if($db->connect_errno > 0){
	    die('Unable to connect to database [' . $db->connect_error . ']');
	}

	return $db;
}

?>