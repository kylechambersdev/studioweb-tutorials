<?php

include("app/init.php");
$Template->set_data('page_class', 'home');

if(isset($_GET['id']) && is_numeric($_GET['id']))
{
    //get products from specific category
    // set equal to a variable
    $category = $Categories->get_categories($_GET['id']);

    //check if valid category (has an id in the db)
    if(!empty($category))
    {
        //get category nav (passing in the name of the category)
        $category_nav = $Categories->create_category_nav('name');
        $Template->set_data('page_nav', $category_nav);

        //get all products from that category
        $cat_products = $Products->create_product_table(4, $_GET['id']);

        //check if products exist in that category
        if(!empty($cat_products))
        {
            //set products to the category requested by user
            $Template->set_data('products', $cat_products);
        }
        else
        {
            //show message that no products exist in this category on products page
            $Template->set_data('products', '<li>No products exist in this category!</li>');
        }
        //use Template load to load the public home page
        $Template->load('app/views/v_public_home.php', $category['name']);
    }
    else
    {
        // if category isn't valid, redirect to home page
        $Template->redirect(SITE_PATH);
    }
}
else
{
    //get all products from all categories

    //get category nav
$category_nav = $Categories->create_category_nav('home');
$Template->set_data('page_nav', $category_nav);

// get products
$products = $Products->create_product_table();
$Template->set_data('products', $products);

// //use Template load to load the public home page
$Template->load("app/views/v_public_home.php", 'Welcome!');
}





