<?php

class tagcloud_model
{
    //by calling these variables here, we can access inside any functions below using $->
    var $mysqli;
    var $tags; //array(id, name, total)
    var $largest;
    //constructor
    function __construct($conn)
    {
        //set the connection to a variable making it accessible inside the function
        $this->mysqli = $conn;
        //get tags and largest value
        $this->get_tags();
        //pre tags present data in a more readable format
        // echo "<pre>";
        // //prints tags array
        // print_r($this->tags);
        // echo "</pre>";
        // exit;
    }

    /* Utility Functions
    ---------------------------------------------------*/
    function get_tags()
    {
        //$this points it to the property of the object defined above
        $this->tags = array();
        $this->largest = 0;
        //query for three columns: tag_id, name, and count of tag_id in posts_to_tags; inside of two different tables(posts_to_tags and tags)
        //creates a total column with the number of times a tag_id is repeated in posts_to_tags
        //b/c COUNT is a SQL function, we cannot access it directly, hence the need to save it in a new column as a new data
        $result = $this->mysqli->query("SELECT posts_to_tags.tag_id, tags.name, COUNT(posts_to_tags.tag_id) AS total FROM tags, posts_to_tags WHERE posts_to_tags.tag_id = tags.id GROUP BY posts_to_tags.tag_id");
        //if there are more than 0 rows in the result
        if ($result->num_rows > 0)
        {   //while there are rows to fetch in the query results
            while($row = $result->fetch_object())
            {
                //check for largest amount of times a single tag was used and set to the variable largest
                if($row->total > $this->largest) {$this->largest = $row->total;}

                //add tag data to array
                $this->tags[] = array('id' => $row->tag_id, 'name' => $row->name, 'total' => $row->total);
            }
            //sort tags, array('classname', 'functionname') sorts our tag names alphabetically, along with their id and total values
            usort($this->tags, array('tagcloud_model', 'compare_names'));
        }
        else
        {
            $this->tags = false;
        }
    }
    function compare_names($a, $b)
    {
        return strcmp($a['name'], $b['name']);
    }

    /* Display Functions
    ---------------------------------------------------*/
    // sends results to $data['tag_list'] for displaying in tagcloud.view.php
    function get_tag_list()
    {   //check if there are tags
        if($this->tags != false)
        {
            $data = '';
            //display tags in table
            $data .= "<table border='1' cellpadding='10'>";
            $data .= "<tr><th>ID</th><th>Tag Name</th><th>Count</th><th>We
            ight</th></tr>";
            
            //loop through tags
            foreach($this->tags as $tag)
            {
                //find weight of each tag by dividing its total by the largest total and multiplying by 10 (giving a weight between 1 and 10)
                $weight = round(($tag['total'] / $this->largest) * 10);
                //put tag data into table
                $data .= "<tr>";
                $data .= "<td>" . $tag['id'] . "</td>";
                $data .= "<td>" . $tag['name'] . "</td>";
                $data .= "<td>" . $tag['total'] . "</td>";
                //remember weight is calculated, not stored in the database
                $data .= "<td>" . $weight . "</td>";
                $data .= "</tr>";
            }
            $data .= "</table>";
            return $data;
        }
        else
        {
            return "No tags found.";
        }
    }
    // sends results to $data['tag_cloud'] for displaying in tagcloud.view.php
    function get_tag_cloud()
    {   //check if there are tags
        if($this->tags != false)
        {
            //create unordered list
            $data = '';
            $data .= '<ul class="tagcloud">';

            foreach($this->tags as $tag)
            {
                //find weight
                $weight = round(($tag['total'] / $this->largest) * 10);
                //create tag cloud, using weight value in class to set proportional font size
                $data .= "<li><a href='tags.php?id=". $tag['id']."'class='tag".$weight."'>";
                $data .= $tag['name'] . "</a></li>";
                $data .= "\n";
            }
            $data.= "</ul>";
            return $data;

        }
        else
        {
            return "No tags found.";
        }
    }

}

?>