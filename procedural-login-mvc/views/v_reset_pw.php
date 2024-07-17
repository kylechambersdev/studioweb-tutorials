<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="views/style.css">
</head>
<body>

<h1>Reset Password</h1>
<div id="content">
    <form action="" method="POST">
        <!-- if you want to pass HTML validation, you need the input inside of a block element (ie. div) -->
        <div>
            <!-- if there is an error, display it -->
            <?php if ($error['alert']) {
                echo "<div class='alert'>".$error['alert']."</div>";
            }  ?>

            <p>Forgot your password? enter your email below, and we will email you a link to reset your password.</p>

            <label for="email">Email address: *</label>
            <input type="text" name="email" value="<?php echo $input['email']; ?>"><div class="error"><?php echo $error['email']; ?></div>

            <p class="required">* required fields</p>

            <input type="submit" name="submit" id="" class="submit" value="Submit">
        </div>
    </form>

    <p><a href="./login.php">Log In</a></p>
</div>
    
</body>
</html>