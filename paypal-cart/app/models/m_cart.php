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
     * Update the number of items in the cart
     * 
     * @access public
     * @param int, int
     * @return null
     */
    public function update($id, $num)
    {
        if($num == 0)
        {
            //if number of items is 0, remove item from cart
            unset($_SESSION['cart'][$id]);
            if(empty($_SESSION['cart']))
            {
                unset($_SESSION['cart']);
            }
        }
        else
        {
            //updates number of items for calculation of total price
            $_SESSION['cart'][$id] = $num;
        }
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
     * Return the total number of items in the cart
     * 
     * @access public
     * @param 
     * @return int
     */
    public function get_total_items()
    {
        $num=0;
        if(isset($_SESSION['cart']))
        {
            foreach($_SESSION['cart'] as $item)
            {
                $num += $item;
            }
        }
        return $num;
    }

    /**
     * Return total cost of all items in cart
     * 
     * @access public
     * @param
     * @return int
     */
    public function get_total_cost()
    {
        $num = '0.00';
        if(isset($_SESSION['cart']))
        {
            //if items to display

            //get product ids
            $ids = $this->get_ids();

            //get product prices
            global $Products;
            $prices = $Products->get_prices($ids);

            //loop through, adding the cost of each item * the number of the item in the cart to $num each time
            if($prices != NULL)
            {
                foreach($prices as $price)
                {
                    //get price from price array and multiply by number of that item in cart, loops through each item in the cart, and adds it to total price $num each time
                    //doubleval() is used to ensure that the price is a float
                    $num += doubleval($price['price'] * $_SESSION['cart'][$price['id']]);
                }
            }
        }
        return $num;
    }

    /**
     * Return the shipping cost for the total cost of items in the cart
     * 
     * @access public
     * @param double
     * @return double
     */
    public function get_shipping_cost($total)
    {
        if($total > 200)
        {
            return 40.00;
        }
        else if ($total > 50)
        {
            return 15.00;
        }
        else if ($total > 10)
        {
            return 4.00;
        }
        else
        {
            return 2.00;
        }

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
            $shipping = 0;

            //loop through each product in cart
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
                //
                $shipping += ($this->get_shipping_cost($product['price'] * $_SESSION['cart'][$product['id']]));

                $total += $product['price'] * $_SESSION['cart'][$product['id']];
                $line++;
            }

                //add subtotal row
                $data .= '<li class="subtotal_row"><div class="col1">Subtotal:</div><div class="col2">$' . $total . '</div></li>';

                //shipping
                $data .= '<li class="shipping_row"><div class="col1">Shipping Cost:</div><div class="col2">$' . number_format($shipping, 2) . '</div></li>';

                if(SHOP_TAX > 0)
                {
                    $data .= '<li class="taxes_row"><div class="col1">Tax (' . (SHOP_TAX * 100) . '%):</div><div class="col2">$' . number_format(SHOP_TAX * $total, 2) . '</div></li>';
                }

                //add total row
                $data .= '<li class="total_row"><div class="col1">Total:</div><div class="col2">$' . number_format(($total * (1 + SHOP_TAX)) + $shipping, 2) . '</div></li>';

        }
        else
        {
            //no products to display
            $data .= '<li><strong>No items in the cart!</strong></li>';

            //add subtotal row
            $data .= '<li class="subtotal_row"><div class="col1">Subtotal:</div><div class="col2">$0.00</div></li>';

            //shipping
            $data .= '<li class="shipping_row"><div class="col1">Shipping Cost:</div><div class="col2">$0.00</div></li>';

            //taxes
            if(SHOP_TAX > 0)
            {
                $data .= '<li class="taxes_row"><div class="col1">Tax (' . (SHOP_TAX * 100) . '%):</div><div class="col2">$0.00</div></li>';
            }

            //add total row
            $data .= '<li class="total_row"><div class="col1">Total:</div><div class="col2">$0.00</div></li>';
        }

        return $data;
    }

}