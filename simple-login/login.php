<?php

/*
* LOGIN.PHP
* Log in members
*/

//php sessions are way to store data, temporarily across multiple pages until the user leaves the site or closes the browser.  This is useful for storing data that the user needs to access on multiple pages, such as login information.  
//start the session / load configs
//session_start needs to be first code on page
session_start();
include('includes/config.php');
include('includes/db.php'); 


//form defaults (v_login.php)
$error['alert'] = '';
$error['user'] = '';
$error['pass'] = '';
$input['user'] = '';
$input['pass'] = '';

//check for form submission
if(isset($_POST['submit'])) 
{
    //process form
    if($_POST['username'] == '' || $_POST['password'] == '')
    {
        //both fields need to be filled in, if not, display error and alert
        if($_POST['username'] =='') {$error['user'] = 'required!';}
        if($_POST['password'] =='') {$error['pass'] = 'required!';}
        $error['alert'] = 'Please fill in all required fields.';

        //these refill the user inputs to the fields after error messages are displayed (always clean user inputs like this)
        $input['user'] = htmlentities($_POST['username'], ENT_QUOTES);
        $input['pass'] = htmlentities($_POST['password'], ENT_QUOTES);

        //reloads the login page
        include('views/v_login.php');
    }
    else
    {
        //clean the form data before processing, makes it html friendly and converts quotes to text (this is only necessary here b/c though it could go in the db, if it has an error, the page is reloaded with the user input data redisplayed to the user, so it must be cleaned)
        $input['user'] = htmlentities($_POST['username'], ENT_QUOTES);
        $input['pass'] = htmlentities($_POST['password'], ENT_QUOTES);

        //create query to check u/n and p/w against database (? are placeholders for user inputs)
        //added check for permissions comparing members type and permissions id (either 1 or 2)
        if($stmt = $mysqli->prepare("SELECT members.id, permissions.name FROM members, permissions where username = ? AND password = ? AND members.type = permissions.id"))
        {   //put md5 hash on password and stored as variable rathe rather than passed directly into the query
            $input['pass'] = md5(htmlentities($_POST['password'], ENT_QUOTES). $config['salt']);
            //bind the parameters to the user inputs
            $stmt->bind_param("ss", $input['user'], $input['pass']);
            //execute the query
            $stmt->execute();
            //store the result
            $stmt->bind_result($id, $type);
            $stmt->fetch();

            if($id)
            {
                //close statment used to compare u/n and p/w to the db
                $stmt->close();
                //set session variable
                $_SESSION['id'] = $id;
                //check permissions
                $_SESSION['type'] = $type;
                //set session variable, which would indicate the user is logged in
                $_SESSION['username']  = $input['user'];
                //starts the timer for last active
                $_SESSION['last_active'] = time();

                // redirect to members page (hypothetical if admin.php existed)
                // if($_SESSION['type'] == 'admin')
                // {
                //     header("Location: admin.php");
                // }
                // else
                header("Location: members.php");
            }
            else
            {
                // username or password incorrect/not found
                $error['alert'] = "Username or Password incorrect.";
                //redisplay the login form
                include('views/v_login.php');
            }
        }
        else
        {
            echo "ERROR: could not prepare MySQLi statment.";
        }
    }
}
else
{
    //if user tries to access members.php without loggin in
    if(isset($_GET['unauthorized']))
    {
        $error['alert'] = "You must be logged in to view that page.";
    }
    if(isset($_GET['timeout']))
    {
        $error['alert'] = "Your session has expired. Please log back in.";
    }

    include('views/v_login.php');
}

//always close the database connection
$mysqli->close();


?>