<?php
session_start();
require_once("setup.php");
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
        <a class="index-picture" href="./src/landing.php"><img src="img/cam.png" alt="camera"></a>
    </div>

    <div class="header">
    </div>

    <div class="footer">
        <?php	include('partials/footer.php');	?>
    </div>
</body>
</html>
