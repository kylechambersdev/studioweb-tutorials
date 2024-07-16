<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>You have been logged out!</title>
    <link rel="stylesheet" href="views/style.css">
    <!-- redirects to login page after 2 seconds -->
    <meta http-equiv="refresh" content="2; url=login.php">
</head>
<body>
    <h1>Logged Out</h1>
    <div id="content">
        <p>You have been successfully logged out.  You will now be redirected to the login page.</p>

        <!-- in case user has disabled javascript, a link to the login page is provided -->
        <noscript><a href="login.php"></a></noscript>
    </div>
    
</body>
</html>