<?php



?>

<!-- the html from open div up, and bottom div down, could have each been their only include(); -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members Only</title>
    <link rel="stylesheet" href="views/style.css">
</head>
<body>
    <?php if(is_admin()) { ?>

        <!-- is_admin() = true -->
<h1>Admin Area</h1>
<div id="content">
    <p>You have successfully logged in to the member's area</p>
    <p><a href="register.php">Register Member</a></p>
    <p><a href="change_password.php">Change Password</a></p>
    <p><a href="logout.php">Log Out</a></p>

</div>
<?php } else { ?>
    <!-- is_admin() = false -->
    <h1>Members Area</h1>
    <div id="content">
        <p>You have successfully logged in to the member's area</p>
        <p><a href="change_password.php">Change Password</a></p>
        <p><a href="logout.php">Log Out</a></p>
    </div>
<?php } ?>
    
</body>
</html>