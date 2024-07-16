<?php

/*
* RESET_PASSWORD.PHP
* Allows members to reset their password
*/
//start session, connect to database, and include config
session_start();
include('includes/config.php');
include('includes/db.php');


//form defaults (v_reset_pw.php)
$error['alert'] = '';
$error['email'] = '';
$error['pass'] = '';
$error['pass2'] = '';

$input['email'] = '';
$input['pass'] = '';
$input['pass2'] = '';



if(isset($_GET['key']))
{
    //this part is when user follows link in their email to reset their password
    //user entering a new password
    if(isset($_POST['submit']))
    {
        //process form
        $input['email']= htmlentities($_POST['email'], ENT_QUOTES);
        $input['pass']= htmlentities($_POST['password'], ENT_QUOTES);
        $input['pass2']= htmlentities($_POST['password2'], ENT_QUOTES);
        $key = htmlentities($_GET['key'], ENT_QUOTES);

        if($input['email'] == '' || $input['pass'] == '' || $input['pass2'] == '')
        {
            //all fields must be filled in, otherwise error messages
            if($input['email'] == '') {$error['email'] = 'required!';}
            if($input['pass'] == '') {$error['pass'] = 'required!';}
            if($input['pass2'] == '') {$error['pass2'] = 'required!';}
            $error['alert'] = 'Please fill in all required fields.';

            //reloads the password reset page
            include('views/v_reset_pw.php');

        }
        else if (!preg_match('/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/', $input['email']))
        {
            //email is invalid
            $error['email'] = 'Please enter a valid email address.';
            
            //reloads the passwor reset page
            include('views/v_reset_pw2.php');
        }
        else
        {
            // make sure email and key match
            $check = $mysqli->prepare("SELECT email FROM members WHERE email = ? AND pw_reset = ?");
            $check->bind_param("ss", $input['email'], $key);
            $check->execute();
            //only needed when displaying results
            $check->store_result();
            if($check->num_rows == 0)
            {
                //error
                $error['alert'] = "Unfortunately the reset key and the email you have entered do not match, or the password reset key is invalid.  Please double check your email address, or try <a href='reset_password.php'>requesting a new password reset</a> again.";

                //show form
                include('views/v_reset_pw2.php');
            }
            else
            {
                //update password, clear pw_reset
                $check = $mysqli->prepare("UPDATE members SET password = ?, pw_reset = '' WHERE email = ?");
                //adding salt to password
                $check->bind_param("ss", md5($input['pass'] . $config['salt']),  $input['email']);
                $check->execute();
                //do not need to display results, so can simply close
                $check->close();

                //add alert message
                $error['alert'] = "Password reset successful.  You can now <a href='login.php'>log in</a> with your new password.";
                //clear form
                $input['email'] = '';
                $input['pass'] = '';
                $input['pass2'] = '';

                //show form
                include('views/v_reset_pw2.php');
            }
        }
    }
    else
    {
        //show form
        include('views/v_reset_pw2.php');
    }
}
else
{
    //this part is when the user request the reset password link sent to their email address (results in a $key)
    //user requesting a password reset
    if(isset($_POST['submit']))
    {
        //process form
        $input['email']= htmlentities($_POST['email'], ENT_QUOTES);

        if($input['email'] == '')
        {
            //email is blank
            $error['email'] = 'required!';
            $error['alert'] = 'Please fill in all required fields.';

            //reloads the password reset page
            include('views/v_reset_pw.php');

        }
        else if (!preg_match('/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/', $input['email']))
        {
            //email is invalid
            $error['email'] = 'Please enter a valid email address.';
            
            //reloads the passwor reset page
            include('views/v_reset_pw.php');
        }
        else
        {
            //check that email exists in the database
            $check = $mysqli->prepare("SELECT id FROM members WHERE email = ?");
            $check->bind_param("s", $input['email']);
            $check->execute();
            $check->store_result();
            if($check->num_rows == 0)
            {
                $check->close();
                //display error - email isnt in database
                $error['alert'] = 'Email address not found, please check for typos and resubmit.';
                //show form
                include('views/v_reset_pw.php');
            }
            else
            {
                $check->close();
                //create a key (function at the bottom of the page)
                

                $key = randomString(16);
                //create email to reset password (dont need to worry about <head> tags)
                $subject = "Password reset requres from " . $config['site_name'];
                $message = "<html><body>";
                $message .= "<p>Hello,</p>";
                $message .= "<p>You have requested a password reset from " . $config['site_name'] . "</p>";
                $message .= "<p>To reset your password, please click the link below and you will be redirected to a webpage where you can enter a new password.  If you did not request a password reset, or do not wish to reset your current password, please ignore this email</p>";
                //link is hyperlinked and displayed as text in case hyperlink fails
                $message .= "<p><a href='" . $config['site_url'] . "/reset_password.php?key=" . $key . "'>" . $config['site_url'] . "/reset_password.php?key=" . $key . "</a></p>";
                $message .= "<p>Thank you,</p> <br> The Administrator, " . $config['site_name'] . "</p>";
                $message .= "</body></html>";

                //create email headers
                $headers = "MIME-Version: 1.0 \r\n";
                $headers .= "Content-type: text/html; charset=iso-8859-1 \r\n";
                $headers .= "From: " . $config['site_name'] . " <noreply@" . $config['site_domain'] . ">\r\n";
                $headers .= "X-Sender: <noreply@" . $config['site_domain'] . ">\r\n";
                $message .= "Reply-Tp: <noreply@" . $config['site_domain'] . ">\r\n";

                //send email
                mail($input['email'], $subject, $message, $headers);

                //update the database with the key
                $stmt = $mysqli->prepare("UPDATE members SET pw_reset = ? WHERE email = ?");
                $stmt->bind_param("ss", $key, $input['email']);
                $stmt->execute();
                $stmt->close();

                //display success message
                $error['alert'] = "Password reset sent successfuly. Please check your email.";
                $input['email'] = '';
                include('views/v_reset_pw.php');
            }
            
        } 

    }
    else
    {
    //show form
    include('views/v_reset_pw.php');
    }

}


//always close the database connection
$mysqli->close();

//create a random string for the key

    function randomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';    

        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $string;
    }


?>