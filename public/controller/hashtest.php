<?php 
	$password = "L3ouyamberamy";


	// Create 10 character salt.
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $salt = '';
    for ($i = 0; $i < 10; $i++) {
        $salt .= $characters[rand(0, $charactersLength - 1)];
    }

    //Combine salt with entered password then hash.
	$hashedPassword = hash("sha512", $password."tyBzkJzj6n");

	echo "<pre>";
	var_dump($password);

	var_dump($salt);

	var_dump($hashedPassword);




?>