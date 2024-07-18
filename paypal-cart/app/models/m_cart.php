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
        //establish variables
        $data = '';
        $total = 0;
        //create cart header row
        $data .= '<li class="header_row"><div class="col1">Product Name:</div><div class="col2">Quantity:</div><div class="col3">Product Price:</div><div class="col4">Total Price:</div></li>';
        //check for products in cart
        if($products != '')
        {
            //products to display
            $line = 1;

            foreach($products as $product)
            {
                //create new item in cart
                $data .= '<li';
                //alternate row colors with "alt" class
                if($line % 2 == 0)
                {
                    $data .= ' class="alt"';
                }
                //each item row in cart
                $data .= '><div class="col1">' . $product['name'] . '</div>';
                $data .= '<div class="col2"><input name="product' . $product['id'] . '" value="' . $_SESSION['cart'][$product['id']] . '"></div>';
                $data .= '<div class="col3">$' . $product['price'] . '</div>';
                $data .= '<div class="col4">$' . $product['price'] * $_SESSION['cart'][$product['id']] . '</div></li>';

                $total += $product['price'] * $_SESSION['cart'][$product['id']];
                $line++;
            }

                //add subtotal row
                $data .= '<li class="subtotal_row"><div class="col1">Subtotal:</div><div class="col2">$' . $total . '</div></li>';

                //add total row
                $data .= '<li class="total_row"><div class="col1">Total:</div><div class="col2">$' . $total . '</div></li>';

        }
        else
        {
            //no products to display
            $data .= '<li><strong>No items in the cart!</strong></li>';

            //add subtotal row
            $data .= '<li class="subtotal_row"><div class="col1">Subtotal:</div><div class="col2">$0.00</div></li>';

            //add total row
            $data .= '<li class="total_row"><div class="col1">Total:</div><div class="col2">$0.00</div></li>';
        }

        return $data;
    }

}