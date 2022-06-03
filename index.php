<?php
session_start();
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
    <img src="img/cam.png" alt="camera" class="camera">
    <h1>Camagru</h1>
    <div class="signin">
        <button>Sign in</button>
    </div>

    <div class="login">
        <button>Log in</button>
    </div>

    <div class="footer">
    <?php	include('partials/footer.php');	?>
    </div>
</body>
</html>
