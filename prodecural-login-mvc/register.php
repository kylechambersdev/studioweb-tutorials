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
    header("Location: login.php?unauthorized");
}
//check that user is an admin
else if (!is_admin())
{
    //redirect to members page
    header("Location: members.php");
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
$error['user'] = '';
$error['email'] = '';
$error['type'] = '';
$error['pass'] = '';
$error['pass2'] = '';

$input['user'] = '';
$input['email'] = '';
$input['type'] = '';
$input['pass'] = '';
$input['pass2'] = '';

//check for form submission
if(isset($_POST['submit'])) 
{
    //these refill the user inputs to the fields after error messages are displayed, so must be cleaned with htmlentities and ENT_QUOTES (user input data redisplayed to user must always be cleaned)
    $input['user'] = htmlentities($_POST['username'], ENT_QUOTES);
    $input['email'] = htmlentities($_POST['email'], ENT_QUOTES);
    $input['type'] = htmlentities($_POST['type'], ENT_QUOTES);
    $input['pass'] = htmlentities($_POST['password'], ENT_QUOTES);
    $input['pass2'] = htmlentities($_POST['password2'], ENT_QUOTES);

        //create select options
        $select = '<option value="">Select an option</option>';
        $stmt = $mysqli->prepare("SELECT id, name FROM permissions");
        $stmt->execute();
        $stmt->bind_result($id, $name);
        //loops through query results
        while($stmt->fetch())
        {
            //if the user has already selected a type, it will be selected when the page reloads
            $select .= "<option value='" . $id . "'";
            if($input['type'] == $id) {$select .= "selected='selected'";}
            $select .= ">" . $name . "</option>";
        }
        $stmt->close();

    //process form
    if($_POST['username'] == '' || $_POST['email'] == '' || $_POST['password'] == '' || $_POST['password2'] == '' || $_POST['type'] == '')
    {
        //both fields need to be filled in, if not, display error and alert
        if($_POST['username'] =='') {$error['user'] = 'required!';}
        if($_POST['email'] =='') {$error['email'] = 'required!';}
        if($_POST['type'] =='') {$error['type'] = 'required!';}
        if($_POST['password'] =='') {$error['pass'] = 'required!';}
        if($_POST['password2'] =='') {$error['pass2'] = 'required!';}
        $error['alert'] = 'Please fill in all required fields.';
 
        //reloads the login page
        include('views/v_register.php');
    }
    else if ($_POST['password'] !== $_POST['password2'])
    {
        //both password fields need to match
        $error['alert'] = 'Password fields must match!.';

        //reloads the login page
        include('views/v_register.php');
    }
    //this is a regex to check if the email is (not) valid
    else if (!preg_match('/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/', $input['email']))
    {
        //email is invalid
        $error['email'] = "Please enter a valid email address.";
        include("views/v_register.php");
    }
    else
    {
        //this data doesnt need clean because it is being inserted in the db and mysqli will clean it
        $input['user'] = $_POST['username'];
        $input['email'] = $_POST['email'];

    
    // $input['pass2'] = htmlentities($_POST['password2'], ENT_QUOTES);

    //insert into database (included pw_reset to avoid warning message also prevented registration of new member while left undefined)
    if($stmt = $mysqli->prepare("INSERT members (username, email, type, password, pw_reset ) VALUES (?, ?, ?, ?, '')"))
    {           
        //unlike when logging in, I had to do the md5 hash here, because the password is stored in the database as an md5 hash, and needed to be included in the query as a variable when using bind_param (ie. input['pass'])  ***read that md5 is no longer secure***
        $input['pass'] = md5($_POST['password'] . $config['salt']);
        //bind the parameters to the user inputs
        $stmt->bind_param("ssss", $input['user'], $input['email'], $input['type'], $input['pass']);
        //execute the query
        $stmt->execute();
        //close the statement/query
        $stmt->close();
        //display success message
        $error['alert'] = 'Member added successfully!';
        //clears inputs after successful registration
        $input['user'] = '';
        $input['email'] = '';
        $input['type'] = '';
        $input['pass'] = '';
        $input['pass2'] = '';
        //reloads the register page
        include('views/v_register.php');
    }
    else
    {
        echo "ERROR: could not prepare MySQLi statment.";
    }
    }
}
else
{
    //create select options
    $select = '<option value="">Select an option</option>';
    $stmt = $mysqli->prepare("SELECT id, name FROM permissions");
    $stmt->execute();
    $stmt->bind_result($id, $name);
    //loops through query results
    while($stmt->fetch())
    {
        $select .= "<option value='" . $id . "'>" . $name . "</option>";
    }
    $stmt->close();

    //display the register page
    include('views/v_register.php');
}

//always close the database connection
$mysqli->close();



?>