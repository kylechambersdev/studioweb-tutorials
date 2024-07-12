<?php

$host = 'localhost';
$user = 'root';
$password = 'root';
$db = 'studioweb';
//mysqli is for OOP and mysqli_connect is for procedural programming
$mysqli = new mysqli($host, $user, $password, $db);
//test for db connection
// if ($mysqli) {
//     echo 'Connection successful';
// } else {
//     echo 'Connection failed';
// }
//will show all errors
mysqli_report(MYSQLI_REPORT_ALL);

?>