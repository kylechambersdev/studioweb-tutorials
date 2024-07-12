<?php
//include the database connection
include ("connect-db.php");
//used to add and edit records
//variables set empty as default, prevents undefined errors
function renderForm($first = '', $last = '', $error = '', $id = '')
{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if ($id != '') {echo "Edit Record";} else {echo "New Record";} ?></title>
</head>
<body>
    
</body>
<!-- if id is set, we are editing a record, otherwise we are adding a record -->
<h1><?php if ($id != '') {echo "Edit Record";} else {echo "New Record";} ?></h1>

<!-- displays error message if there is one (can be resued around page) -->
<?php if ($error != '')
{
    echo "<div style='padding:4px; border:1px solid red; color:red'>" . $error
    . "</div>";
}
?>

<form action="" method="post">
    <div>
        <!-- displays id if it is set -->
        <?php if ($id != '') { ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <p>ID: <?php echo $id; ?></p>
        <?php } ?>
            <!-- form for adding and editing records -->
        <strong>First Name: *</strong><input type="text" name="firstname" value="<?php echo $first; ?>">
        <br>
        <strong>Last Name: *</strong><input type="text" name="lastname" value="<?php echo $last; ?>">
        <p>* required</p>
        <input type="submit" name="submit" value="submit" id="">
    </div>
</form>
</html>
<?php
}
//end of renderForm function
//starts the code for adding and editing records, if id is set in url
if (isset($_GET['id']))
    {   //once edited record is submitted
        if(isset($_POST['submit']))
        {
            //check if id is numeric
            if (is_numeric($_POST['id']))
            {
                //get form data, validate it with htmlentities, flag with ENT_QUOTES to encode the data and avoid issues with sql injection
                $id = $_POST['id'];
                $firstname = htmlentities($_POST['firstname'], ENT_QUOTES);
                $lastname = htmlentities($_POST['lastname'], ENT_QUOTES);
                //check if the fields are empty upon submit
                if($firstname == '' || $lastname == '')
                {
                    $error = 'ERROR: Please fill in all required fields!';
                    //reloads page with data inputted by user
                    renderForm($firstname, $lastname, $error);
                }
                else 
                {
                    //prepare statement to update the record in the database
                    if ($stmt = $mysqli->prepare("UPDATE players SET firstname = ?, lastname = ? WHERE id = ?"))
                    {
                        //binds the parameters to the query, an s for each string being passed, and i for integer (ie. ssi)
                        $stmt->bind_param("ssi", $firstname, $lastname, $id);
                        //runs the query
                        $stmt->execute();
                        //closes the statement
                        $stmt->close();
                        //redirects to view.php
                        header("Location: view.php");
                    }
                    else
                    {
                        echo "ERROR: could not prepare SQL statement.";
                    }
                }
            }
            else
            {
                echo "ERROR: ID is not a number";
            
            }
        }
        else
        {
    //editing an existing record
        if(is_numeric($_GET['id']) && $_GET['id'] > 0)
        {

                //query database for the record
                $id = $_GET['id'];
                //prepare statement to select the record from the database
                if($stmt = $mysqli->prepare("SELECT * FROM players WHERE id = ?"))
                {
                    //bind the query to the id provided
                    $stmt->bind_param("i", $id);
                    //run the query
                    $stmt->execute();
                    //bind the results to variables (variables refer to the columns in our db, need a variable for each column of db for proper assignment)
                    $stmt->bind_result($id, $firstname, $lastname);
                    //fetch the results
                    $stmt->fetch();
                    //fills in the form with current db values, $errors set to NULL
                    renderform($firstname, $lastname, NULL, $id);
                    //close the statement
                    $stmt->close();
                }
                else
                {
                    echo "ERROR: could not prepare SQL statement.";
                
                }
            }
            else
            {
                header("Location: view.php");
            }
        }
    }
    else
    {
        //adding a new record
        if(isset($_POST['submit']))
        {
            //get form data, validate it with htmlentities, flag with ENT_QUOTES to encode the data and avoid issues with sql injection
            $firstname = htmlentities($_POST['firstname'], ENT_QUOTES);
            $lastname = htmlentities($_POST['lastname'], ENT_QUOTES);
            //check if the fields are empty upon submit
            if($firstname == '' || $lastname == '')
            {
                $error = 'ERROR: Please fill in all required fields!';
                //reloads page with data inputted by user
                renderForm($firstname, $lastname, $error);
            }
            else
            {
                //prepare statement to insert data into database
                if($stmt = $mysqli->prepare("INSERT players (firstname, lastname) VALUES (?, ?)"))
                {
                    //binds the parameters to the query, an s for each string being passed (ie. ss)
                    $stmt->bind_param("ss", $firstname, $lastname);
                    //runs the query
                    $stmt->execute();
                    //closes the statement
                    $stmt->close();
                }
                else
                {
                    echo "ERROR: could not prepare SQL statement.";
                }
                header("Location: view.php");
            }
        }
        else
        {
            renderForm();
        }
    }
$mysqli->close();
?>