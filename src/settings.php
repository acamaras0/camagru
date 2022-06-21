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
        <a href="profile.php"><img src="../img/cam.png" alt="camera"></a>
    </div>
    <div class="header">
        <?php include('../partials/header_settings.php'); ?>
    </div>
    <div class="middle">
        <form class= "form" action="create.php" method="POST">
            <div class="signup-container">
                <div class="email-new input-element">
                    <label>Change e-mail address</label>
                    <input type="email" name="email" required>
                </div>
                <div class="fullname input-element">
                    <label>Change full name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="username-new input-element">
                    <label>Change username</label>
                    <input type="text" name="login" required>
                </div>
                <div class="password-new input-element">
                    <label>Change password</label>
                    <input type="password" name="passwd" required>
                </div>
                <div class="repeat-password input-element">
                    <label>Input your current password in order to save the changes</label>
                    <input type="password" name="re-passwd" required>
                </div>
                <div class="button-container">
                    <button class="create-button" type="submit" name="submit">Submit changes</button>
                </div>
            </div>
        </form>
    </div>
    <div class="footer">
    <?php	include('../partials/footer.php');	?>
    </div>
</body>
</html>