<?php
/**
 * CONFIG.PHP
 * Configuration Settings
 */

 //user authentication (this means passwords will not be stored in the)
 $config['salt'] = 'dl5s?3';
 $config['session_timeout'] = 300; //seconds **would want to increase

 //domain
 $config['site_name'] = "Your Website";
 $config['site_url'] = "http://www.yourdomain.com";
 $config['site_domain'] = "yourdomain.com";

 // error reporting, this setting good for development, but turn off for production
 mysqli_report(MYSQLI_REPORT_ERROR);

 //Functions
 //check to see if user is an admin permission type
 function is_admin()
 {
    if($_SESSION['type'] == 'admin')
    {
        return true;
    }
    else
    {
        return false;
    }
 }

?>