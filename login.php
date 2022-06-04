<?php

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
    <img src="img/cam.png" alt="camera" class="camera1">
    <h1>Login</h1>

    <div class="username">
        Username:
        <input></input>
    </div>
    <div class="password">
        Password: 
        <input></input>
    </div>
    <div class="forgot">
        <button>Forgotten password?</button>
    </div>

    <div class="footer">
    <?php	include('partials/footer.php');	?>
    </div>
</body>
</html>