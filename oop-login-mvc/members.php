<?php
//Initializes the files
include("includes/init.php");

// Check if user is logged in using Auth object function
if ($Auth->checkLoginStatus() == FALSE)
{
    //alert and redirect to login page if not logged in (using Template object functions)
    $Template->setAlert("Unauthorized!","error");
    $Template->redirect("login.php");
}
else
{
    //load the members page
    $Template->load("views/v_members.php");
}