<?php

//Template Class
//Handles all templating tasks - displaying views, alerts, view data & errors

class Template 
{
    private $data;
    private $alert_types = array('success', 'alert', 'error');

    //placeholder for constructor class if needed at later date
    function __constructor() {}

    //Load Specified URL and that pages title
    //@access public
    //@param string, string
    //@return null
    public function load($url, $title = '')
    {
        //if title is set, save it
        if($title != '')
        {
            $this->set_data('page_title', $title);
        }
        //load the page
        include($url);
    }

    //Redirects To Specified URL
    //@access public
    //@param string
    //@return null
    public function redirect($url)
    {
        header("Location: $url");
        exit;
    }

    //Get / Set Data

    //Saves provided data for use the by view later
    //@access public
    //@param string, string, bool
    //@return null
    public function set_data($name, $value, $clean = FALSE)
    {
        if($clean == TRUE)
        {
            //clean data before saving
            $this->data[$name] = htmlentities($value, ENT_QUOTES);
        }
        else
        {   //otherwise if already clean, save as is
            $this->data[$name] = $value;
        }
    }

    //Retrieves provided data for use the by view
    //@access public
    //@param string, bool
    //@return string
    public function get_data($name, $echo = TRUE)
    {
        if(isset($this->data[$name]))
        {
            //if exists
            if($echo) 
            {
                //displays data 
                echo $this->data[$name];
            }
            else
            {   
            //otherwise returns function but doesnt display
            return $this->data[$name];
            }
        }
    return '';
    }

    //Get / Set Alerts

    //Sets alert message stored in a session variable
    //@access public
    //@param string, string (optional, default is 'success')
    //@return null
    public function set_alert($value, $type = 'success')
    {
        //sets alert type
        $_SESSION[$type][] = $value;
    }

    //Returns string, containing multiple list items of alerts
    //@access public
    //@param 
    //@return string
    public function get_alert()
    {
        //starts with blank string
        $data ='';
        //loops through each alert type
        foreach($this->alert_types as $alert)
        {
            //if alert type is set by the session
            if(isset($_SESSION[$alert]))
            {
                //loops through each message in that alert type array and adds to list
                foreach($_SESSION[$alert] as $value)
                {
                    $data .= '<li class="' . $alert . '">' . $value . '</li>';
                }
                //after loops through all alerts, clears the session variable
                unset($_SESSION[$alert]);
            }
        }
        //returns the list of alerts
        echo $data;
    }
    


}