<?php

/*
 * MEMBERS.PHP
 * Password protected area for members only
 */

 //start session
session_start();
include("includes/config.php");

//check if user is (not) logged in
if(!isset($_SESSION['username']))
{
    //redirect to login page
    header("Location: login.php?unauthorized");
}

//check for connectivity
if (time() > $_SESSION['last_active'] + $config['session_timeout'])
{
    //log out user
    session_destroy();
    header("Location: login.php?timeout");
}
else
{
    //update last active time stamp
    $_SESSION['last_active'] = time();
}

//display view
include("views/v_members.php");



?>