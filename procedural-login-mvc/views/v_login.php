<?php



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="views/style.css">
</head>
<body>

<h1>Log In</h1>
<div id="content">
    <form action="" method="post">
        <!-- if you want to pass HTML validation, you need the input inside of a block element (ie. div) -->
        <div>
            <!-- if there is an error, display it -->
            <?php if ($error['alert']) {
                echo "<div class='alert'>".$error['alert']."</div>";
            }  ?>

            <label for="username">Username: *</label>
            <input type="text" name="username" value="<?php echo $input['user']; ?>"><div class="error"><?php echo $error['user']; ?></div>

            <label for="password">Password: *</label>
            <input type="password" name="password" value="<?php echo $input['pass']; ?>"><div class="error"><?php echo $error['pass']; ?></div>

            <p class="required">* required fields</p>

            <input type="submit" name="submit" id="" class="submit" value="Submit">
        </div>
    </form>

    <p><a href="reset_password.php">Reset Password</a></p>
</div>
    
</body>
</html>