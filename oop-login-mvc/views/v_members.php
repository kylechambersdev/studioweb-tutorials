<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="views/style.css">
    <title>Members Area</title>
</head>
<body>
    <h1>Members Area</h1>
    <div id="content">
        <?php
        $alerts = $this->getAlerts();
        if($alerts != '') {echo '<ul class="alerts">' . $alerts . '</ul>';}
        ?>
        
        <p>You have successfully logged in to the member's area.</p>
        <p><a href="logout.php">Log Out</a></p>
    </div>

</body>
</html>