<?php

include 'connect-db.php';
//executes if Delete link is clicked and if the id is a number (avoiding passing of a string)
if(isset($_GET['id']) && is_numeric($_GET['id']))
{
    $id = $_GET['id'];
    //deletes the record from the database
    //statement is prepared and query set to delete from players using LIMIT 1 to delete only one record
    //this is more secure way to preform this action
    if($stmt = $mysqli->prepare("DELETE FROM players WHERE id= ? LIMIT 1"))
    {
        //binds the param to the query by replacing the ? with the datatype (i=integer, d=double, s=string, b=blob) and the table field id
        $stmt->bind_param("i",$id);
        //runs the query
        $stmt->execute();
        //closes the statement
        $stmt->close();
    }
    else
    {
        echo "ERROR: could not prepare SQL statement.";
    }
    $mysqli->close();
    header("Location: view.php");
}
else
{
    header("Location: view.php");
}
?>