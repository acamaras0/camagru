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
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <img src="img/cam.png" alt="camera" class="camera1">
    <h1>Create Account</h1>
    <div class="create">
        <div class="email">
            Email:
            <input></input>
        </div>
        <div class="newusername">
            Username:
            <input></input>
        </div>
        <div class="newpassword">
            Password: 
            <input></input>
        </div>
        <div class="repeatpassword">
            Repeat password: 
            <input></input>
        </div>
    </div>

    <div class="footer">
    <?php	include('partials/footer.php');	?>
    </div>
</body>
</html>