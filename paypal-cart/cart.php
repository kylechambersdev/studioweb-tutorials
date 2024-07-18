<?php

include("app/init.php");
$Template->set_data('page_class', 'shoppingcart');

if(isset($_GET['id']) && is_numeric($_GET['id']))
{
    //check if adding a valid item
    if(!$Products->product_exists($_GET['id']))
    {
        //alert user invalid item
        $Template->set_alert('Invalid item!', 'error');
        $Template->redirect(SITE_PATH . 'cart.php');
    }

    //add item to cart
    if(isset($_GET['num']) && is_numeric($_GET['num']))
    { 
        //add additional item to cart
        $Cart->add($_GET['id'], $_GET['num']);
        //alert user item added to cart
        $Template->set_alert('Item added to cart!', 'success');
    }
    else
    {
        //add item to cart
        $Cart->add($_GET['id']);
        //alert user item added to cart
        $Template->set_alert('Item added to cart!', 'success');
    }
    //refreshes cart page
    $Template->redirect(SITE_PATH . 'cart.php');
}

if(isset($_GET['empty']))
{
    $Cart->empty_cart();
    $Template->set_alert('Shopping cart emptied!', 'success');
    $Template->redirect(SITE_PATH . 'cart.php');
}

//get items in cart
$display = $Cart->create_cart();
$Template->set_data('cart_rows', $display);


//get category nav
$category_nav = $Categories->create_category_nav('');
$Template->set_data('page_nav', $category_nav);

// //use Template load to load the public home page
$Template->load("app/views/v_public_cart.php", 'Shopping Cart');






