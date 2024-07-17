<?php

/*
* REGISTER.PHP
* Register New Member
*/

//php sessions are way to store data, temporarily across multiple pages until the user leaves the site or closes the browser.  This is useful for storing data that the user needs to access on multiple pages, such as login information.  
//start the session / load configs
//session_start needs to be first code on page
session_start();
include('includes/config.php');
include('includes/db.php');

//check if user is (not) logged in 
if(!isset($_SESSION['username']))
{
    // redirect to login page
    header("Location: login.php");
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

//form defaults (v_login.phpv_register.php)
$error['alert'] = '';
$error['current_pass'] = '';
$error['pass'] = '';
$error['pass2'] = '';

$input['current_pass'] = '';
$input['pass'] = '';
$input['pass2'] = '';

//check for form submission
if(isset($_POST['submit'])) 
{
    //process form
    if($_POST['current_pass'] == '' || $_POST['password'] == '' || $_POST['password2'] == '')
    {
        //both fields need to be filled in, if not, display error and alert
        if($_POST['current_pass'] =='') {$error['current_pass'] = 'required!';}
        if($_POST['password'] =='') {$error['pass'] = 'required!';}
        if($_POST['password2'] =='') {$error['pass2'] = 'required!';}
        $error['alert'] = 'Please fill in all required fields.';
        //these refill the user inputs to the fields after error messages are displayed, so must be cleaned with htmlentities and ENT_QUOTES (user input data redisplayed to user must always be cleaned)
        $input['current_pass'] = htmlentities($_POST['username'], ENT_QUOTES);
        $input['pass'] = htmlentities($_POST['password'], ENT_QUOTES);
        $input['pass2'] = htmlentities($_POST['password2'], ENT_QUOTES);
        //reloads the login page
        include('views/v_password.php');
    }
    else if ($_POST['password'] !== $_POST['password2'])
    {
                //both password fields need to match
                $error['alert'] = 'Password fields must match!.';
                //these refill the user inputs to the fields after error messages are displayed, so must be cleaned with htmlentities and ENT_QUOTES (user input data redisplayed to user must always be cleaned)
                $input['current_pass'] = htmlentities($_POST['current_pass'], ENT_QUOTES);
                $input['pass'] = htmlentities($_POST['password'], ENT_QUOTES);
                $input['pass2'] = htmlentities($_POST['password2'], ENT_QUOTES);
                //reloads the login page
                include('views/v_password.php');
    }
    else
    {
        //this data doesnt need clean because it is being inserted in the db and mysqli will clean it
        $input['current_pass'] = $_POST['current_pass'];
        //unlike when logging in, I had to do the md5 hash here, because the password is stored in the database as an md5 hash, and needed to be included in the query as a variable when using bind_param (ie. input['pass'])  ***read that md5 is no longer secure***
        $input['pass'] = md5($_POST['password'] . $config['salt']);
        // $input['pass2'] = htmlentities($_POST['password2'], ENT_QUOTES);

        //query password in db to compare against user input current password
        if($check = $mysqli->prepare("SELECT password FROM members WHERE id = ?"))
        {
            //gets the current password from the db and binds it to a variable $current_pass
            $check->bind_param("s", $_SESSION['id']);
            $check->execute();
            $check->bind_result($current_pass);
            $check->fetch();
            $check->close();
        }
        //check if current password entered matches the current password in the db
        if(md5($input['current_pass'] . $config['salt']) != $current_pass)
        {
            //error
            $error['alert'] = "Current password is incorrect!";
            $error['current_pass'] = "incorrect";
            include('views/v_password.php');
        }
        else
        {
        //insert new password into database
        if($stmt = $mysqli->prepare("UPDATE members SET password = ? WHERE id = ?"))
        {
            $input['password'] = md5($_POST['password']. $config['salt']);
            //bind the parameters to the new password and the session id
            $stmt->bind_param("ss", $input['password'], $_SESSION['id']);
            //execute the query
            $stmt->execute();
            //close the statement/query
            $stmt->close();
            //display success message
            $error['alert'] = 'Password successfully updated!';
            //clears inputs after successful registration
            $input['current_pass'] = '';
            $input['pass'] = '';
            $input['pass2'] = '';
            //reloads the register page
            include('views/v_password.php');
        }
        else
        {
            echo "ERROR: could not prepare MySQLi statment.";
        }
        }


    }
}
else
{
    include('views/v_password.php');
}

//always close the database connection
$mysqli->close();



?>