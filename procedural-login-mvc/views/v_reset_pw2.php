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
    <form action="" method="post">
        <!-- if you want to pass HTML validation, you need the input inside of a block element (ie. div) -->
        <div>
            <!-- if there is an error, display it -->
            <?php if ($error['alert']) {
                echo "<div class='alert'>".$error['alert']."</div>";
            }  ?>

            <p>Please reset your password using the form below.</p>

            <label for="email">Email address: *</label>
            <input type="password" name="email" value="<?php echo $input['email']; ?>"><div class="error"><?php echo $error['email']; ?></div>

            <label for="password">New Password: *</label>
            <input type="password" name="password" value="<?php echo $input['pass']; ?>"><div class="error"><?php echo $error['pass']; ?></div>

            <label for="password">New Password (confirm): *</label>
            <input type="password" name="password2" value="<?php echo $input['pass2']; ?>"><div class="error"><?php echo $error['pass2']; ?></div>
            
            <p class="required">* required fields</p>

            <input type="submit" name="submit" id="" class="submit" value="Submit">
        </div>
    </form>

    <p><a href="login.php">Log In</a></p>
</div>
    
</body>
</html>