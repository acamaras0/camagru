<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create account</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="camera">
        <a href="../index.php"><img src="../img/cam.png" alt="camera"></a>
    </div>
    <div class="header">
        <h1>Camagru</h1>
    </div>
    <div class="middle">
        <div class="signup-container">
            <h1>Sign up</h1>
            <div class="email-new input-element">
                <label>Email address</label>
                <input type="email" required>
            </div>

            <div class="fullname input-element">
                <label>Full name</label>
                <input type="text" required>
            </div>

            <div class="username-new input-element">
                <label>Username</label>
                <input type="text" required>
            </div>

            <div class="password-new input-element">
                <label>Password</label>
                <input type="password" required>
            </div>

            <div class="repeat-password input-element">
                <label>Repeat password</label>
                <input type="password" required>
            </div>

            <div class="button-container">
                <button class="create-button">
                    Sign up
                </button>
            </div>
            
        </div>
    </div>
    <div class="footer">
    <?php	include('../partials/footer.php');	?>
    </div>
</body>
</html>