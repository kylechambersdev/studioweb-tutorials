<?php

/*
	INIT
	Basic configuration settings
*/

// connect to database
$server = 'localhost';
$user = 'root';
$pass = 'root';
$db = 'ks_shop';
$Database = new mysqli($server, $user, $pass, $db);

// error reporting
mysqli_report(MYSQLI_REPORT_ERROR);
ini_set('display_errors', 1);

// set up constants
define('SITE_NAME', 'My Online Store');
define('SITE_PATH', 'http://localhost:8888/Killersites/');
define('IMAGE_PATH', 'http://localhost:8888/Killersites/resources/images/');

define('SHOP_TAX', '0.0875');

define('PAYPAL_MODE', 'sandbox'); // either sandbox or live
define('PAYPAL_CURRENCY', 'USD'); 
define('PAYPAL_DEVID', 'AQK2ORAoc6ocd7v7fl-iJB5O3Hq_xNcCMf11YZmM6VFRopdxVGrXCoqiqOWn'); 
define('PAYPAL_DEVSECRET', 'ECin5RD55B7Zx-3RvyA3HZJYjya-ndY0jQp6qmNHFss-68SbL77akWcd__-S'); 
define('PAYPAL_LIVEID', ''); 
define('PAYPAL_LIVESECRET', ''); 

// include objects
include('app/models/m_template.php');
include('app/models/m_categories.php');
include('app/models/m_products.php');
include('app/models/m_cart.php');

// create objects
$Template = new Template();
$Categories = new Categories();
$Products = new Products();
$Cart = new Cart();


session_start();


// global
$Template->set_data('cart_total_items', $Cart->get_total_items());
$Template->set_data('cart_total_cost', $Cart->get_total_cost());


