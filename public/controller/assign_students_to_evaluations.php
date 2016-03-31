<?php
require_once __DIR__ . "/../../system/bootstrap.php";

echo $twig->render('assign_students_to_evaluations.html', [
	"professorName"=>"Mike Scott",
	"title"=>"Edutainment",
	"description"=>"Create a project with scratch",
	"students"=>array(
		array(
			"firstName"=>"Matthew",
			"MI"=>"M",
			"lastName"=>"Loewen"
			),
		array(
			"firstName"=>"Ethan",
			"MI"=>"J",
			"lastName"=>"Daville"
			),
		array(
			"firstName"=>"Barby",
			"MI"=>"M",
			"lastName"=>"Roberts"
			),
		array(
			"firstName"=>"Dylan",
			"MI"=>"L",
			"lastName"=>"Scott"
			)
		),
	]);