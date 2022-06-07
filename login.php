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
        <a href="index.php"><img src="img/cam.png" alt="camera"></a>
    </div>
    <div class="header">
        <h1>Camagru</h1>
    </div>
    <div class="middle">
        <div class="signup-container">
            <h1>Login</h1>

            <div class="username">
                Username:
                <input type="text" required></input>
            </div>
            <div class="password">
                Password: 
                <input type="password" required></input>
            </div>
            <div class="log">
                <a href="auth.php"><button>Let's go!</button></a>
            </div>
            <div class="forgot">
                <a href="forgot_password.php"><button>Forgotten password?</button></a>
            </div>
        </div>
    </div>
    <div class="footer">
    <?php	include('partials/footer.php');	?>
    </div>
</body>
</html>