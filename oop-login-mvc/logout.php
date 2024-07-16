<?php

//Initializes the files
include("includes/init.php");

//log out
$Auth->logout();

//redirect
$Template->setAlert("You have been logged out", "success");
$Template->redirect("login.php");

