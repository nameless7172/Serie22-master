<?php
$url = 'parameters.json'; // path to your JSON file
require_once ($url);

$data = file_get_contents(__DIR__ . '/' .$url); // put the contents of the file into a variable
$values = json_decode($data); // decode the JSON feed






?>