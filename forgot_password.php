<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgotten password</title>
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
            <h1>Forgotten password</h1>

            <div class="email">
                Email address:
                <input type="email" required></input>
            </div>
            <div class="forgot">
                <a href="password_link.php"><button>Submit</button></a>
            </div>
        </div>
    </div>
    <div class="footer">
    <?php	include('partials/footer.php');	?>
    </div>
</body>
</html>