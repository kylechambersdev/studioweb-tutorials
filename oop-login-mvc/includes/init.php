<?php

// INIT
// Basic configuration of settings

// create objects
include("models/m_template.php");
include("models/m_auth.php");
//declares the Template object
$Template = new Template();
// Sets the alert types for the Template object
$Template->setAlertTypes(array("success", "warning", "error"));
//declares the Auth object
$Auth = new Auth();


// start session
session_start();


//generally you do not want to include the closing tag in a php file that ONLY contains php code to avoid code being outside the tag