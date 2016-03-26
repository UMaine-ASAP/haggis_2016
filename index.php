<?php

include "route.php";
include "TempConts/about.php";
include "TempConts/home.php";
include "TempConts/contact.php";

$route = new Route();

$route->add('/', "Home");
$route->add('/about', "About");
$route->add('/contact', "Contact");

echo '<pre>';
print_r($route);

$route->submit();

?>