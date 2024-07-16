<?php 

// Database
// DB connection settings

//database settings
$server = 'localhost';
$user = 'root';
$pass = 'root';
$db = 'studioweb';

//connect to database
$database = new mysqli($server, $user, $pass, $db);

// error reporting
mysqli_report(MYSQLI_REPORT_ERROR);