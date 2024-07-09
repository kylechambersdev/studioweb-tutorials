<!-- this page defines the values for the for elements which eliminates warnings based on undefined values -->
<?php

//variables

$to = 'kyle@kylechambers.dev';
$subject = 'Contact Form Submission';

$error_open = "<label class='error'>";
$error_close = "</label>";
$valid_form = TRUE;
$redirect = "success.php";

//contains form data
$form_elements = array('name', 'phone', 'fax', 'email', 'comments');
$required = array('name', 'phone', 'email');

//produces error message for each element required
foreach ($required as $require)
{
	$error[$require] = '';
}

if (isset($_POST['submit']))
{
    //process form
    
    //get form data
    foreach ($form_elements as $element)
	{
        //checks data for special characters (that we dont want) and gets the data
        $form[$element] = htmlspecialchars($_POST[$element]);
	}

    //check form elements
        //check required fields: these messages do not show for me, I think because validate.js is handling it already
        if ($form['name'] == '')
		{
			$error['name'] = $error_open . "Please fill in all required fields!" . $error_close;
			$valid_form = FALSE;
		}
		if ($form['phone'] == '')
		{
			$error['phone'] = $error_open . "Please fill in all required fields!" . $error_close;
			$valid_form = FALSE;
		}
		if ($form['email'] == '')
		{
			$error['email'] = $error_open . "Please fill in all required fields!" . $error_close;
			$valid_form = FALSE;
		}
		
		// check formatting
		if ($error['phone'] == '' && !preg_match('/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/', $form['phone']))
		{
			$error['phone'] = $error_open . "Please enter a valid phone number!" . $error_close;
			$valid_form = FALSE;
		}
		
		if ($error['email'] == '' && !preg_match('/^([0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$/', $form['email']))
		{
			$error['email'] = $error_open . "Please enter a valid email!" . $error_close;
			$valid_form = FALSE;
		}

    //check for bad data
    if (contains_bad_str($form['name']) || 
        contains_bad_str($form['email']) || 
        contains_bad_str($form['phone']) || 
        contains_bad_str($form['fax']) || 
        contains_bad_str($form['comments'])) 
    {
        $valid_form = FALSE;
    }
    if (contains_newlines($form['name']) || 
        contains_newlines($form['email']) || 
        contains_newlines($form['phone']) || 
        contains_newlines($form['fax'])) 
    {
        $valid_form = FALSE;
    }

    //check if form is valid
    if($valid_form) 
    {
        //create message
        $message = "Name: " . $form['name'] . "\n";
        $message .= "Email: " . $form['email'] . "\n";
        $message .= "Phone: " . $form['phone'] . "\n";
        $message .= "Fax: " . $form['fax'] . "\n\n";
        $message .= "Message: " . $form['comments'];

        $headers = "From: www.example.com <kyle@kylechambers.dev>\r\n";
        $headers .= "X-Sender: <kyle@kylechambers.dev>\r\n";
        $headers .= "X-Mailer: PHP/". phpversion() ."\r\n";
        $headers .= "Reply-To: " . $form['email'];

        //send email
        mail($to, $subject, $message, $headers);
        //redirect to success page
        header("Location: " . $redirect); 
    }
    else
    {
        include('form.php');
    }
}
//display form
else
{
    //set fields to blank
    foreach ($form_elements as $element)
    {
        $form[$element] = '';
    }
    //displays the form
    include('form.php');
}

function contains_bad_str($str_to_test)
{
    $bad_strings = array(
        "content-type:",
        "mime-version:",
        "multipart/mixed",
        "Content-Transfer-Encoding:",
        "bcc:",
        "cc:",
        "to:");
    
    foreach($bad_strings as $bad_string) 
    {
        if(stristr(strtolower($str_to_test), $bad_string))
        {
            return true;
        }
    }
    return false;
    
}

function contains_newlines($str_to_test)
{
    if(preg_match("/(%0A|%0D|\\n+|\\r+)/i", $str_to_test) !=0)
    {
        return true;
    }
    return false;
}



?>