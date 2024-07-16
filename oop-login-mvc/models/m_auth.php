<?php

//Authorization Class
//Deal with auth tasks - login, logout, etc

class Auth
{
    //variables only accessible within this clas
    private $salt = 'j4H9?s0d';

    // Constructor
    function __construct()
    {


    }

    //Functions
    //compares user input username and password against the database
    function validateLogin($user, $pass)
    {
        // gives us access to $database variable in database.php
        //just included here b/c this is only function that needs db access(as opposed to making it a private variable for whole class)
        global $database;
        //create database query
        if($stmt = $database->prepare("SELECT * FROM users WHERE username = ? AND password = ?"))
        {
            $stmt->bind_param("ss", $user, md5($pass . $this->salt));
            $stmt->execute();
            $stmt->store_result();
            
            // check for num rows (if there is a match)
            if($stmt->num_rows > 0)
            {
                //success
                $stmt->close();
                return true;
            }
            else
            {
                //failure
                $stmt->close();
                return false;
            }
        }
        else
        {
            // could be part of your error handling/alerts if you wanted (doing this for simplicity)
            echo "<script>alert('Your username and/or password were not found.');</script>";
            
            header("views/v_login.php");
        }
    }
    //check if user is already logged in
    function checkLoginStatus()
    {
        if(isset($_SESSION['loggedin']))
        {
            return true;
        }
        else
        {
            return false;
        }
        
    }
    //log user out and restart session (clears any variables stored in session)
    function logout()
    {
        //clears out the session by "restarting" it (destroy and (re)start)
        session_destroy();
        session_start();
    }
}
?>