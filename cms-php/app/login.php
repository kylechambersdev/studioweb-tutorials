<?php

include("init.php");

if(isset($_POST['username']))
{
    //get data and set what is submitted equal to the "input_" variables in the Template object
    $FP->Template->setData("input_user", $_POST['username']);
    $FP->Template->setData("input_pass", $_POST['password']);

    //check that fields are filled in
    if($_POST['username'] == '' || $_POST['password'] == '')
    {
        //set applicable error classes
        if($_POST['username'] == '') {$FP->Template->setData('error_user', 'required');}
        if($_POST['password'] == '') {$FP->Template->setData('error_pass', 'required');}
        $FP->Template->setAlert("Please fill in all required fields", "error");
        //resize function for colorbox using JQuery
        echo '<script type="text/javascript">jQuery.colorbox.resize();</script>';
        //show the login page
        $FP->Template->load(APP_PATH . "core/views/v_login.php");
    }
    //runs the validateLogin function from the Auth object using the username and password from the form (retrieved using the Template object)  **see how the objects/classes are used
    else if($FP->Auth->validateLogin($FP->Template->getData('input_user'), $FP->Template->getData('input_pass')) == FALSE)
    {
        //if false (invalid login)
        $FP->Template->setAlert("Invalid username and/or password!", "error");
        //resize function for colorbox using JQuery
        echo '<script type="text/javascript">jQuery.colorbox.resize();</script>';
        
        //show the login page
        $FP->Template->load(APP_PATH . "core/views/v_login.php");
    }
    else
    {
        //if true, log the user in
        $_SESSION['username'] = $FP->Template->getData('input_user');
        $_SESSION['loggedin'] = TRUE;
        $FP->Template->load(APP_PATH . "core/views/v_loggingin.php");

    }
} 
else
{
    $FP->Template->load(APP_PATH . "core/views/v_login.php");
}


//generally you do not want to include the closing tag in a php file that ONLY contains php code to avoid code being outside the tag