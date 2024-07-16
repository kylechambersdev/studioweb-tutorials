<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Password</title>
    <link rel="stylesheet" href="views/style.css">
</head>
<body>

<h1>Update Password</h1>
<div id="content">
    <form action="" method="post">
        <!-- if you want to pass HTML validation, you need the input inside of a block element (ie. div) -->
        <div>
            <!-- if there is an error, display it -->
            <?php if ($error['alert']) {
                echo "<div class='alert'>".$error['alert']."</div>";
            }  ?>

            <label for="username">Current Password: *</label>
            <input type="password" name="current_pass" value="<?php echo $input['current_pass']; ?>"><div class="error"><?php echo $error['current_pass']; ?></div>

            <label for="password">New Password: *</label>
            <input type="text" name="password" value="<?php echo $input['pass']; ?>"><div class="error"><?php echo $error['pass']; ?></div>

            <label for="password">New Password (confirm): *</label>
            <input type="text" name="password2" value="<?php echo $input['pass2']; ?>"><div class="error"><?php echo $error['pass2']; ?></div>

            <p class="required">* required fields</p>

            <input type="submit" name="submit" id="" class="submit" value="Submit">
        </div>
    </form>

    <p><a href="members.php">Back to member's page</a></p>
    <p><a href="change_password.php">Change Password</a></p>
    <p><a href="logout.php">Log Out</a></p>
</div>
    
</body>
</html>