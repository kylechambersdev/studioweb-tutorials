<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Records</title>
</head>
<body>

    <h1>View Records</h1>
    <?php
    //include the database connection
    include 'connect-db.php';

    $per_page = 3;

    if($result = $mysqli->query("SELECT * FROM players ORDER BY id"))
    {
        //if more than 0 records are found
        if($result->num_rows != 0)
        {
            $total_results = $result->num_rows;
            //ceil() function returns the next highest integer value by rounding up
            $total_pages = ceil($total_results / $per_page);
            //check if the page number is set and a number
            if(isset($_GET['page']) && is_numeric($_GET['page']))
            {
                //gets the value of the page number from the url
                $show_page = $_GET['page'];
                //makes sure the page number is valid and less than total pages
                if($show_page > 0 && $show_page <= $total_pages)
                {
                    //
                    $start = ($show_page - 1) * $per_page;
                    $end = $start + $per_page;
                }
                else
                {
                    //if page cannot be returned for any reason, display first page
                    $start = 0;
                    $end = $per_page;
                
                }
            }
            else
            {
                $start = 0;
                $end = $per_page;
            }
            //display pagination
            echo "<p><a href='view.php'>View All</a> | <b>View Page: </b>";
            for ($i=1; $i <= $total_pages; $i++)
            {
                if(isset($_GET['page']) && $_GET['page'] == $i)
                {
                    echo $i . " ";                
                }
                else
                {
                    echo "<a href='view-paginated.php?page={$i}'>{$i}</a> ";
                }
            }
            echo "</p>";
            //display records in table
            echo "<table border='1' cellpadding='10'>";
            echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Edit</th><th>Delete</th></tr>";
            //loop through the records
            for ($i=$start; $i < $end; $i++)
            {
                //if no additional pages, exit the loop
                if ($i == $total_results) {break;}
                //move the pointer to the next record (data_seek();)
                $result->data_seek($i);
                //fetch the record
                $row = $result->fetch_row();
                //display the record as a table
                echo "<tr>";
                //id row
                echo "<td>" . $row[0] . "</td>";
                //first name row
                echo "<td>" . $row[1] . "</td>";
                //last name row
                echo "<td>" . $row[2] . "</td>";
                //Edit row (not in db)
                echo "<td><a href='records.php?id=" . $row[0] . "'>Edit</a></td>";
                //Delete row (not in db)
                echo "<td><a href='delete.php?id=" . $row[0] . "'>Delete</a></td>";
                echo "</tr>";
            }
            echo "</table>";

            
        }
        else
        {
            echo 'No records found';
        
        }
    }
    else
    {
        echo 'Error: ' . $mysqli->error;
    
    }

    //closes the connection to database
    $mysqli->close();
    ?>

    <a href="records.php">Add New Record</a>
    </body>
</html>