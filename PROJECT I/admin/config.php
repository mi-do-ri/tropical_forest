<?php

session_start();

define('SITEURL', 'http://localhost/PROJECT%20I/');
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "website_tropicalforest_demo");

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS) or die(mysqli_error($conn)); //Database Connection
$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn)); //Selecting Database


?>