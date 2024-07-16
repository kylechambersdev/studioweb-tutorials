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
    function setData($name, $value)
    {
        $this->data[$name] = htmlentities($value, ENT_QUOTES);
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

}