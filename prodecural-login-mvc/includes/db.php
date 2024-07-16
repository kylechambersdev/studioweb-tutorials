<?php

/*
 * DB.PHP
 * Database Settings & Connection
 */

 // Database Settings
 $server = 'localhost';
 $user = 'root';
 $password = 'root';
 $db = 'studioweb';

 // Connect to Database
 $mysqli = new mysqli($server, $user, $password, $db);

?>