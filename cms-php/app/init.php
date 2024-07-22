<?php

// INIT
// Basic configuration of settings

//create application settings
define("SITE_PATH", "http://localhost:8888/studioweb-tutorials/cms-php/");
//replaces the backslashes common to Windows file structure, with forward slashes
//helps clean up directory paths
define("APP_PATH", str_replace("\\", "/", dirname(__FILE__)) . "/");

define("SITE_RESOURCES", "http://localhost:8888/studioweb-tutorials/cms-php/resources/");
define("APP_RESOURCES", "http://localhost:8888/studioweb-tutorials/cms-php/app/resources/");
define("SITE_CSS", "http://localhost:8888/studioweb-tutorials/cms-php/resources/css/style.css");

//database settings
$server = 'localhost';
$user = 'root';
$pass = 'root';
$db = 'studioweb';

// error reporting
mysqli_report(MYSQLI_REPORT_ERROR);

//create FlightPath core object
require_once(APP_PATH . "core/core.php");
//establishes the FlightPath_Core object, set to variable $FP that can be used to call the methods in the object FlightPath_Core(ie. $FP->head();)
$FP = new FlightPath_Core($server, $user, $pass, $db);





//generally you do not want to include the closing tag in a php file that ONLY contains php code to avoid code being outside the tag