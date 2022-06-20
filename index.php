<?php
session_start();
require_once("./config/setup.php");
if ($_SESSION['logged_in_user'] != "")
    header("Location: ./src/profile.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="camera-index">
        <a class="index-picture" href="./src/landing.php"><img class="index-cam" src="img/cam.png" alt="camera"></a>
    </div>
    
    <div class="header">
        <h1>Welcome to Camagru!</h1>
        <h1>Click the icon above and let's get started!</h1>
    </div>

    <div class="footer">
        <?php	include('partials/footer.php');	?>
    </div>
</body>
</html>
