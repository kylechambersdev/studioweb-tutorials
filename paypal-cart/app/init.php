<?php

//INIT
//Basic configuration settings

//connect to database
$server = "localhost";
$user = "root";
$pass = "root";
$db = "studioweb";
//can capitalize objects and lowercase variables, to help distinguish between the two
$Database = new mysqli($server, $user, $pass, $db);

//error reporting (this setting good for development, but not for production)
mysqli_report(MYSQLI_REPORT_ERROR);
ini_set('display_errors', 1);

//set up constants
define('SITE_NAME', 'My Online Store'); //first term is variable, second term is value
define('SITE_PATH', 'http://localhost:8888/studioweb-tutorials/paypal-cart/'); 
define('IMAGE_PATH', SITE_PATH.'resources/images/'); //concatenation

define('SHOP_TAX', .0575 );

//include objects
include("app/models/m_template.php");
include("app/models/m_categories.php");
include("app/models/m_products.php");
include("app/models/m_cart.php");

//create objects
$Template = new Template();
$Categories = new Categories();
$Products = new Products();
$Cart = new Cart();

session_start();

//global
//sets total items in top right of every page (sets when page loads but not if user updates/empties cart while on the page b/c init.php only runs on page load)
$Template->set_data('cart_total_items', $Cart->get_total_items());
$Template->set_data('cart_total_cost', $Cart->get_total_cost());
