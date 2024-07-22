<?php

// Template Class
// Handles all templateing tasks - displaying templates, alerts & errors

class Template
{
    //private means this variable can only be accessed within this class
    private $data;
    private $alertTypes;
    // Constructor
    function __construct() {}

    // Functions
    // Load Template
    function load($url) 
    {
        include($url);
    }

    //redirect function
    function redirect($url)
    {
        header("Location: $url");
    }

    // Get / Set Data Functions
    // Set Data
    //if clean is true, it will clean the data before saving it, if false, it will save it as is
    function setData($name, $value, $clean = true)
    {
        if($clean)
        {

            $this->data[$name] = htmlentities($value, ENT_QUOTES);
        }
        else
        {
            $this->data[$name] = $value;
        }
    }
    // Get Data
    function getData($name)
    {
        //if the data exists, return it
        if(isset($this->data[$name]))
        {
            return $this->data[$name];
        }
        else{
            return "";
        }
    }
    // Get / Set Alerts Fuctions
    function setAlertTypes($types)
    {
        $this->alertTypes = $types;
    }
    function setAlert($value, $type = null)
    {
        if($type == '')
        {
            $type = $this->alertTypes[0];
        }
        //makes alert accessible between pages, creates 2D array, index keeps track of the number of times the alert has been called
        $_SESSION[$type][] = $value;
    }
    function getAlerts()
    {
        $data = "";
        //goes through each alert type and displays the alerts when needed
        foreach($this->alertTypes as $alert)
        {
            //if session with correct alert type is set
            if(isset($_SESSION[$alert]))
            {
                //loops through each alert in the session array
                foreach($_SESSION[$alert] as $value)
                {
                    //class holds the alert type, and set value
                    $data .= "<li class='" . $alert . "'>" . $value . "</li>";
                }
                //clears the session/alert
                unset($_SESSION[$alert]);
            }
        }
        //after its looped through all the alert types, returns the value for the specific alerts needed
        return $data;
    }

    function error($type = '', $message = '')
    {
        if($type == 'unauthorized')
        {
            $this->load(APP_PATH . 'core/views/v_unauthorized.php');
        }
        else
        {
            //if no message set
            if($message != '')
            {
                $this->setData('message', $message);
            }
            else
            {
                $this->setData('message', "An error has occurred.  Please contact the website administrater.");
            }
            $this->load(APP_PATH . 'core/views/v_error.php');
        }
    }

    // nav menu on CMS Dashboard (setting it up for easy update in future)
    function cms_nav($selected_section = '', $selected_subsection = '')
    {
        $sections = array(
            array(
                'dashboard' => 'inactive',

            ),
            array (
                'users' => 'inactive',
                'manage_users' => 'inactive',
                'create_user' => 'inactive'
            ),
            array(
                'settings' => 'inactive',
                'change_password'=> 'inactive'
            )
        );
        //& allows us to change the value of an array by reference (ie. a change to $section will change the value in the main $sections array)
        foreach ($sections as &$section)
        {
            //if the "selected section" is in the array, set it to active
            if(array_key_exists($selected_section, $section))
            {
                $section[$selected_section] = 'active';
            }
            //if the "selected subsection" is in the array, set it to active
            if(array_key_exists($selected_subsection, $section))
            {
                $section[$selected_subsection] = 'active';
            }
        }
        //create nav menu
        $nav = '<ul class"fp_nav">';
        $nav .= '<li class="' . $sections[0]['dashboard'] . '"><a href="../dashboard/index.php">Dashboard</a></li>';
        $nav .= '<li class="' . $sections[1]['users'] . '">
                    <span>Users</span>
                    <ul>
                        <li class="' . $sections[1]['manage_users'] . '">
                        <a href="#">Manage Users</a>
                        </li>
                        <li class="' . $sections[1]['create_user'] . '">
                        <a href="#">Create Users</a>
                        </li>
                    </ul>
                </li>';
        $nav .= '<li class="' . $sections[2]['settings'] . '">
                    <span>Settings</span>
                    <ul>
                        <li class="' . $sections[2]['change_password'] . '">
                        <a href="../settings/password.php">Change Password</a>
                    </ul>
                </li>';
        $nav .= '</ul>';

        echo $nav;
    }

}