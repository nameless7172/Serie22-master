<?php


$queryString =  $_SERVER['QUERY_STRING'];   
header("Location: app/views".$queryString);
die();