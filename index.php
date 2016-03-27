<?php

echo $uri = $_SERVER["PATH_INFO"]."<br \>";

$routes = explode('/',$uri);

echo "<pre>";
print_r($routes);