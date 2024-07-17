<?php

//Categories Class
//Handles all tasks related to retrieving and displaying categories

class Categories
{
    private $Database;
    private $db_table = 'categories';

    function __construct()
    {
        //allows us to point to the global database object
        global $Database;
        $this->Database = $Database;
    }

    //Setting / Getting categories from database

    //Return an array with category information
    //@access public
    //@param int
    //@return array
    public function get_categories($id = NULL)
    {
        $data =array();
        if($id != NULL)
        {
            //get specific category
            //note* must be space after FROM and before ORDER where the quotes are. Otherwise buts the variable name and the query keyword together
            if($stmt = $this->Database->prepare("SELECT id, name FROM " . $this->db_table . " WHERE id = ? LIMIT 1"))
            {
                //bind the id to the query
                $stmt->bind_param('i', $id);
                $stmt->execute();
                $stmt->store_result();
                //bind the results to variables (id and name, as in the query)
                $stmt->bind_result($cat_id, $cat_name);
                //fetch the results
                $stmt->fetch();
                //if results are found (ie greater than zero)
                if($stmt->num_rows > 0)
                {   
                    //save the data to the array, under variable names
                    $data = array('id' => $cat_id, 'name' => $cat_name);
                }
                $stmt->close();
            }
        }
        else
        {
            //get all categories
            //note* must be space after FROM and before ORDER where the quotes are. Otherwise buts the variable name and the query keyword together
            if($result = $this->Database->query("SELECT * FROM " . $this->db_table . " ORDER BY name"))
            {
                //if results are found (ie greater than zero)
                if($result->num_rows > 0)
                {
                    //loop through the results
                    while($row = $result->fetch_array())
                    {
                        //save the data to the array, under variable names
                        $data[] = array('id' => $row['id'], 'name' => $row['name']);
                    }
                }
            }
        }
        //array of category data (either specific category or all categories)
        return $data;
    }

    //Creation Of Page Parts
    /**
     * Returns an unordered list of links to all category pages
     * 
     * @access public
     * @param string (optional)
     * @return string
     */
    public function create_category_nav($active = NULL)
    {
        //get all categories (in array)
        $categories = $this->get_categories();

        //set up 'all' items
        $data = '<li';
        //if active set to home, set class to active
        if($active == strtolower('home'))
        {
            $data .= ' class="active"';
        }
        $data .= '><a href="' . SITE_PATH . '">View All</a></li>';

        //loop through each category
        if(!empty($categories))
        {
            //check to see if list item should be active
            foreach($categories as $category)
            {
                $data .= '<li';
                if(strtolower($active)== strtolower($category['name']))
                {
                    $data .= ' class="active"';
                }
                //creates the hyperlink to the category set as active
                $data .= '><a href="' . SITE_PATH . 'index.php?id=' . $category['id'] . '">' . $category['name'] . '</a></li>';
            }
        }
        return $data;
    }
}