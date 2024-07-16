<?php

include("includes/database.php");
include("includes/init.php");

if(isset($_POST['submit']))
{
    //get data and set what is submitted equal to the "input_" variables in the Template object
    $Template->setData("input_user", $_POST['username']);
    $Template->setData("input_pass", $_POST['password']);

    //check that fields are filled in
    if($_POST['username'] == '' || $_POST['password'] == '')
    {
        //show applicable errors
        if($_POST['username'] == '') {$Template->setData('error_user', 'required field!');}
        if($_POST['password'] == '') {$Template->setData('error_pass', 'required field!');}
        $Template->setAlert("Please fill in all required fields", "error");
        //show the login page
        $Template->load("views/v_login.php");
    }
    //runs the validateLogin function from the Auth object using the username and password from the form (retrieved using the Template object)  **see how the objects/classes are used
    else if($Auth->validateLogin($Template->getData('input_user'), $Template->getData('input_pass')) == FALSE)
    {
        //if false, 
        $Template->setAlert("Invalid username and/or password!", "error");
        //show the login page
        $Template->load("views/v_login.php");
    }
    else
    {
        //if true, log the user in
        $_SESSION['username'] = $Template->getData('input_user');
        $_SESSION['loggedin'] = TRUE;
        $Template->setAlert("Welcome <i>" . $Template->getData('input_user') . "</i>!");
        //show the login page
        $Template->redirect("members.php");

    }
} 
else
{
    $Template->load("views/v_login.php");
}


//generally you do not want to include the closing tag in a php file that ONLY contains php code to avoid code being outside the tag