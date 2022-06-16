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
    <div class="camera">
    <a href="index.php"><img src="img/cam.png" alt="camera"></a>
    </div>
    <div class="header">
        <h1>Camagru</h1>
    </div>
    <div class="index-middle">

        

        <div class="index-container">
            <div class="login">
            <a href="src/login.php"><button>Log in</button></a>
            </div>
            <p>Or would you like to create an account?</p>
            <div class="signin">
            <a href="src/create.php"><button>Sign up</button></a> 
            </div>
        </div>
    </div>




    <div class="index-gallery">
        <div class="gallery-container">
            <div class="login">
            <a href="src/login.php"><button>Log in</button></a>
            </div>
            <p>Or would you like to create an account?</p>
            <div class="signin">
            <a href="src/create.php"><button>Sign up</button></a> 
            </div>
        </div>
    </div>





    <div class="footer">
    <?php	include('partials/footer.php');	?>
    </div>
</body>
</html>
