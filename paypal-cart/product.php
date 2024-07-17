<?php

include("app/init.php");
//body tag class
$Template->set_data('page_class', 'product');

//check url for id that is a number
if(isset($_GET['id']) && is_numeric($_GET['id']))
{
    //show product using get and product id
    //set the product data to a variable (get function gets data)
    $product = $Products->get($_GET['id']);
    //is there "not" product data?
    if(!empty($product))
    {
        //if there is product data, pass product data to view
        $Template->set_data('prod_id', $_GET['id']);
        $Template->set_data('prod_name', $product['name']);
        $Template->set_data('prod_description', $product['description']);
        $Template->set_data('prod_price', $product['price']);
        $Template->set_data('prod_image', IMAGE_PATH . $product['image']);

        //create category nav (passing in the name of the category)
        $category_nav = $Categories->create_category_nav($product['category_name']);
        $Template->set_data('page_nav', $category_nav);
        
        //display product view
        $Template->load('app/views/v_public_product.php', $product['name']);

    }
    else
    {
        //error, redirect to home
        //could do an alert here too if wanted
        $Template->redirect(SITE_PATH);
    }
}
else
{
    //error, redirect to home
    //could do an alert here too if wanted
    $Template->redirect(SITE_PATH);
}
 