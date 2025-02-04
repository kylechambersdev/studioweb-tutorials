<?php

/**
 * Core FlightPath class
 * Creates the central FlightPath object, as well as core functionality
 */

 class FlightPath_Core
 {
    public $Template, $Auth, $Database, $Cms;

    function __construct($server, $user, $pass, $db)
    {
        //create database connection
        $this->Database = new mysqli($server, $user, $pass, $db);

        //// create template object
        include(APP_PATH . "core/models/m_template.php");
        //declares the Template object
        $this->Template = new Template();
        // Sets the alert types for the Template object
        $this->Template->setAlertTypes(array("success", "warning", "error"));

        //create authorization object
        include(APP_PATH . "core/models/m_auth.php");
        $this->Auth = new Auth();

        //create CMS object
        include(APP_PATH . "cms/models/m_cms.php");
        $this->Cms = new Cms();

        // start session
        session_start(); 
    }

    function __destruct()
    {
        $this->Database->close();
    }

    /**
     * Checks if user is logged in and displays the head or login form
     */

    function head()
    {
        if($this->Auth->checkLoginStatus())
        {
            include(APP_PATH . "core/templates/t_head.php");
        }
        if(isset($_GET['login']) && $this->Auth->checkLoginStatus() == FALSE)
        {
            include(APP_PATH . "core/templates/t_login.php");
        }
        
    }

    /**
     * Adds class to body tag if user is logged in
     */
    function body_class()
    {
        if($this->Auth->checkLoginStatus())
        {
            echo " fp_editing";
        }
    }

    /**
     * Displays the toolbar if user is logged in
     */
    function toolbar()
    {
        if($this->Auth->checkLoginStatus())
            {
                include (APP_PATH . "core/templates/t_toolbar.php");
            }
    }


    function login_link()
    {
        if($this->Auth->checkLoginStatus())
        {
            echo "<a href='" . SITE_PATH . "app/logout.php'>Logout</a>";
        }
        else
        {
            echo "<a href='?login'>Login</a>";
        }
    }
 }

?>