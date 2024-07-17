<?php

//CART Class
//Handles all tasks realted to showing or modifying the number of items in the cart

//the cart keeps track of user selected items using a session variable, $_SESSION['cart'].  This session variable holds an array that contains the id and the number of selected products, in the cart.

// $_SESSION['cart']['product_id'] = num of specific items in the cart

class Cart
{
    function __construct() {}

    /**
     * Getters / Setters
     */

    /**
     * Return an array of all product info for items in the cart
     * 
     * @access public
     * @param int, int
     * @return array
     */
    public function get()
    {
        if(isset($_SESSION['cart']))
        {
            //get all product ids of items in the cart
            $ids = $this->get_ids();

            //use list of ids to get product info from database
            global $Products;
            return $Products->get($ids);
        }
        return NULL;
    }

    /**
     * Return an array of all product ids for items in the cart
     * 
     * @access public
     * @param
     * @return array, null
     */
    public function get_ids()
    {
        if(isset($_SESSION['cart']))
        {
            return array_keys($_SESSION['cart']);
        }
        return NULL;
    }

    /**
     * Add item to the cart
     * 
     * @access public
     * @param int, int 
     * @return null
     */
    public function add($id, $num = 1)
    {
        //setup or retrieve cart
        $cart = array();
        if(isset($_SESSION['cart']))
        {
            $cart = $_SESSION['cart'];
        }

        //check to see if item is already in cart
        if(isset($cart[$id]))
        {
            //if item is in cart, add to the number of items
            $cart[$id] += $num;
        }
        else
        {
            //if item is not in cart already
            $cart[$id] = $num;
        }
        $_SESSION['cart'] = $cart;
    }

    /**
     * Empties all items from cart
     * 
     * @access public
     * @param 
     * @return null
     */
    public function empty_cart()
    {
        unset($_SESSION['cart']);
    }

    /**
     * Create page parts
    */

    /**
     * Return a string, containing list items (product info) for each product in cart
     * 
     * @access public
     * @param 
     * @return string
     */
    public function create_cart()
    {
        //get products currently in cart
        $products = $this->get();

        echo '<pre>';
        print_r($products);
        echo '</pre>';
    }
}