<?php 

include("../init.php");
include("models/m_settings.php");
//Settings object
$Settings = new Settings();
//check user logged in
$FP->Auth->checkAuthorization();
// THIS PAGE SUBMIT NEVER DID FUNCTION.  CLICKING SUBMIT SIMPLY CLOSES THIS WINDOW
//could not figure out why.  Even using source files yeilded same results.  My guess is conflict between jQuery ajax and iframe submit
if(isset($_POST['submit']))
{
    //get data
    $FP->Template->setData('oldpass', $_POST['oldpass']);
    $FP->Template->setData('newpass', $_POST['newpass']);
    $FP->Template->setData('newpass2', $_POST['newpass2']);

    //validate data, if missing show error
    if($_POST['oldpass'] == '' || $_POST['newpass'] == '' || $_POST['newpass2'] == '')
    {
        if($_POST['oldpass'] == '')
        {
            $FP->Template->setData('error_oldpass', 'required field!');
        }
        if($_POST['newpass'] == '')
        {
            $FP->Template->setData('error_newpass', 'required field!');
        }
        if($_POST['newpass2'] == '')
        {
            $FP->Template->setData('error_newpass2', 'required field!');
        }
        $FP->Template->setAlert('Please fill in all rquired fields.', 'error');
        //load view
        $FP->Template->load(APP_PATH . 'settings/views/v_password.php');
    }
    else if($_POST['newpass'] != $_POST['newpass2'])
    {
        $FP->Template->setData('error_newpass', 'must match!');
        $FP->Template->setData('error_newpass2', 'must match!');
        $FP->Template->setAlert('Please ensure new password matches.', 'error');
        //load view
        $FP->Template->load(APP_PATH . 'settings/views/v_password.php');
    }
    //use validateLogin function to check old password in database using the current username
    else if($FP->Auth->validateLogin($FP->Auth->getCurrentUserName(), $FP->Template->getData('oldpass')) == FALSE)
    {
        //invalid old password
        $FP->Template->setData('error_oldpass', 'incorrect password!');
        $FP->Template->setAlert('Old password is incorrect. Please re-enter.', 'error');
        //load view
        $FP->Template->load(APP_PATH . 'settings/views/v_password.php');
    }
    else
    {
        //store username and new password to variable equal to a function that changes the password in the database.  OR issue using submit function w/o ajax, in a colorbox window.
        $changed = $Settings->changePassword($FP->Auth->getCurrentUserName(), $FP->Template->getData('newpass'));

        //if password is changed
        if($changed == TRUE)
        {
            //clear the form
            $FP->Template->setData('oldpass', '');
            $FP->Template->setData('newpass', '');
            $FP->Template->setData('newpass2', '');
            //alert user of sucess
            $FP->Template->setAlert('Password has been changed successfully!');
            //load view
            $FP->Template->load(APP_PATH . 'settings/views/v_password.php');
        }
        else
        {
            //clear the form
            $FP->Template->setData('oldpass', '');
            $FP->Template->setData('newpass', '');
            $FP->Template->setData('newpass2', '');
            //alert user of error
            $FP->Template->setAlert('An error has occurred.  Please try again later', 'error');
            //load view
            $FP->Template->load(APP_PATH . 'settings/views/v_password.php');
        }

    }
}
else
{
    //load view
    $FP->Template->load(APP_PATH . 'settings/views/v_password.php');

}

