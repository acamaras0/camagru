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
    <link rel="stylesheet" type="text/css" href="../style.css">
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
            <div class="php-messages">
                <?php
                    if($_GET['message'] == 1)
                    {
                        echo "User created succesfully!";
                    }
                    else if($_GET['message'] == 2)
                    {
                        echo "Email address not verified or username or password incorrect.";
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="footer">
    <?php	include('../partials/footer.php');	?>
    </div>
</body>
</html>

<?php
require_once("auth.php");
$check = auth($_POST['login'], $_POST['passwd']);
if ($check == 2)
{
    $_SESSION['logged_in_user'] = $_POST['login'];
    header('Location: newsfeed.php');
    exit();
}
else if ($check == 1)
{
    header('Location: login.php?message=2');
    exit();
}
else
    return;
?>