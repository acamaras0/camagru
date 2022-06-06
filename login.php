<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="camera">
        <img src="img/cam.png" alt="camera">
    </div>
<div class="middle">
    <div class="signup-container">
        <h1>Login</h1>

        <div class="username">
            Username:
            <input required></input>
        </div>
        <div class="password">
            Password: 
            <input required></input>
        </div>
        <div class="forgot">
            <button>Forgotten password?</button>
        </div>
    </div>
</div>
    <div class="footer">
    <?php	include('partials/footer.php');	?>
    </div>
</body>
</html>