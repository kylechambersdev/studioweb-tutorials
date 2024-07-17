<?php

/**
 * Products Class
 * Handles all tasks related to retrieving and displaying products
 */

 class Products
 {
    private $Database;
    //variable holding products table from db
    private $db_table = 'products';

    function __construct()
    {
        //allows us to point to the global database object
        global $Database;
        $this->Database = $Database;
    }

    /**
     * Getters / Setters
     */

     /**
      * Retrieve product information from database (based on input of ids)
      * @access public
      * @param int (optional)
      * @return array
      */
	public function get($id = NULL)
	{
		$data = array();
		
		if (is_array($id))
		{
            //get products based on array of ids
            $items = '';
            foreach($id as $item)
            {
                //if items exist for the ids provided, add them to a comma separated list
                if($items != '') 
                {
                    $items .= ',';
                }
                $items .= $item;
            }
            //query to get products based on the list of ids
            //mysqli does not support prepared statments when using IN, so we have to use use a simple query
            if($result = $this->Database->query("SELECT id, name, description, price, image FROM $this->db_table WHERE id IN ($items) ORDER BY name"))
            {
                if($result->num_rows > 0)
                {
                    //loop through results and store in array with following keys
                    while($row = $result->fetch_array())
                    {
                        $data[] = array(
                            'id' => $row['id'],
                            'name' => $row['name'],
                            'description' => $row['description'],
                            'price' => $row['price'],
                            'image' => $row['image'],
                        );
                    }
                }
            }
        }
        else if ($id != NULL)
        {
            //get one specific product
            if($stmt = $this->Database->prepare("SELECT  
            -- db_table is equivalent to 'products' table
            $this->db_table.id, 
            $this->db_table.name,
            $this->db_table.description,
            $this->db_table.price,
            $this->db_table.image,
            -- store category name in a variable 'category_name'
            categories.name AS category_name
            -- get data from both tables
            FROM $this->db_table, categories
            -- products table and categories table have corresponding ids indicating the category type/name, matching the two gets products in the right category (name)
            WHERE $this->db_table.id = ? AND $this->db_table.category_id = categories.id"))
            {
                $stmt->bind_param('i', $id);
                $stmt->execute();
                $stmt->store_result();
                $stmt->bind_result($prod_id, $prod_name, $prod_description, $prod_price, $prod_image, $cat_name);
                $stmt->fetch();
                //if results are found, put them in an array
                if($stmt->num_rows > 0)
                {
                    $data = array('id' => $prod_id, 'name' => $prod_name, 'description' => $prod_description, 'price' => $prod_price, 'image' => $prod_image, 'category_name' => $cat_name);
                }
                $stmt->close();

            }   
        
        }
        else
        {
            //get list of all products
            if($result = $this->Database->query("SELECT * FROM " . $this->db_table . " ORDER BY name"))
            {
                if($result->num_rows > 0)
                {
                    //loop through results and store in array with following keys
                    while($row = $result->fetch_array())
                    {
                        $data[] = array(
                            'id' => $row['id'],
                            'name' => $row['name'],
                            'price' => $row['price'],
                            'image' => $row['image'],
                        );
                    }
                }
            }
        }
        return $data;
    }

    /**
     * Retrieve product information for all products in a specific category
     * @access public
     * @param int
     * @return string
     */
    public function get_in_category($id)
    {
        $data = array();
        //query to get all products in a specific category
        if($stmt = $this->Database->prepare("SELECT id, name, price, image FROM " . $this->db_table . " WHERE category_id = ? ORDER BY name"))
        {
            //bind the id to the query
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->store_result();
            //bind the results to variables
            $stmt->bind_result($prod_id, $prod_name, $prod_price, $prod_image);
            //fetch the results
            while($stmt->fetch())
            {
                //store the results in an array
                $data[] = array(
                    'id' => $prod_id,
                    'name' => $prod_name,
                    'price' => $prod_price,
                    'image' => $prod_image,
                );
            }
            $stmt->close();
            
        }
        //return the array outside of the query "if statment"
        return $data;
    }

    /**
     * Check to see if product exists in the database
     * 
     * @access public
     * @param int
     * @return boolean
     */
    public function product_exists($id)
    {
        if($stmt = $this->Database->prepare("SELECT id FROM $this->db_table WHERE id = ?"))
        {
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($id);
            $stmt->fetch();

            if ($stmt->num_rows > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
            
        }
    }


    /**
     * Creation of Page Elements
     */

    /**
     * Create product table using info from database
     * @access public
     * @param int (optional, default is 4), int (optional)
     * @return
     */
     public function create_product_table($cols = 4, $category = NULL)
     {
        //get products
        if($category != NULL)
        {
            //get products from specific category
            $products = $this->get_in_category($category);
        }
        else
        {
            $products = $this->get();
        }
        $data= '';

        //loop through each product
        if(!empty($products))
        {
            $i = 1;
            foreach($products as $product)
            {
                $data .='<li';
                if($i == $cols)
                {
                    $data .=' class="last"';
                    $i=0;
                }
                $data .= '><a href="' . SITE_PATH . 'product.php?id=' . $product['id'] . '">';
                $data .= '<img src="' . IMAGE_PATH . $product['image'] . '" alt="' . $product['name'] . '"><br>';
                $data .= '<strong>' . $product['name'] . '</strong></a><br>$' . $product['price'];
                $data .= '<br><a class="button_sml" href="' . SITE_PATH . 'cart.php?id=' . $product['id'] . '">Add to Cart</a><li>';
                $i++;
            }
        }
        return $data;
     }
}
