<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Records</title>
</head>
<body>

<h1>View Records</h1>

<p><b>View All</b> | <b><a href="view-paginated.php">View Paginated</a></b></p>

<?php
//include the database connection
include 'connect-db.php';
//get specified data from database and order by id
if($result = $mysqli->query("SELECT * FROM players ORDER BY id"))
{
    //display records if there are records to display
    if($result->num_rows > 0)
    {
        //builds table to display results
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Edit</th><th>Delete</th>";
        //while there are results to display
        while($row=$result->fetch_object())
        {
            echo "<tr>";
            echo "<td>" . $row->id . "</td>";
            echo "<td>" . $row->firstname . "</td>";
            echo "<td>" . $row->lastname . "</td>";
            echo "<td><a href='records.php?id=" . $row->id . "'>Edit</a></td>";
            echo "<td><a href='delete.php?id=" . $row->id . "'>Delete</a></td>";
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