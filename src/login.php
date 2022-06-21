<?php
session_start();
require_once("auth.php");
require_once("print_msg.php");

$check = auth($_POST['login'], $_POST['passwd']);
if (isset($_POST['submit']))
{
    if ($check == 2)
    {
        $_SESSION['logged_in_user'] = $_POST['login'];
        print_msg("Succesfully logged in!");
        header('Refresh: 2; newsfeed.php');
        exit();
    }
    else if ($check == 1)
    {
        print_msg("Email address not verified.");
        header('Refresh: 3; login.php?message=2');
        exit();
    }
    else if ($check == 0)
    {
        print_msg("Username or password incorrect.");
        header('Refresh: 3; login.php?message=3');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
    <div class="camera">
        <a href="landing.php"><img src="../img/cam.png" alt="camera"></a>
    </div>
    <div class="header">
        <h1>Camagru</h1>
    </div>
    <div class="middle">
        <div class="signup-container">
            <h1>Login</h1>
            <form class= "form" action="login.php" method="POST">
                <div class="username">
                    Username:
                    <input type="text" name="login" required></input>
                </div>
                <div class="password">
                    Password:
                    <input type="password" name="passwd" required></input>
                </div>
                <div class="log">
                    <button type="submit" name="submit" value="">Let's go!</button>
                </div>
             </form>
            <div class="forgot">
                <a href="forgot_password.php"><button>Forgotten password?</button></a>
            </div>
        </div>
    </div>
    <div class="footer">
    <?php	include('../partials/footer.php');	?>
    </div>
</body>
</html>
