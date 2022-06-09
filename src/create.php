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
        <form class= "form" method="POST">
            <div class="signup-container">
                <h1>Sign up</h1>
                <div class="email-new input-element">
                    <label>Email address</label>
                    <input type="email" name="email" required>
                </div>
                <div class="fullname input-element">
                    <label>Full name</label>
                    <input type="text" name="name" required>
                </div>
                <div class="username-new input-element">
                    <label>Username</label>
                    <input type="text" name="login" required>
                </div>
                <div class="password-new input-element">
                    <label>Password</label>
                    <input type="password" name="passwd" required>
                </div>
                <div class="repeat-password input-element">
                    <label>Repeat password</label>
                    <input type="password" name="re-passwd" required>
                </div>
                <div class="button-container">
                    <button class="create-button" type="submit" name="submit" value="OK">
                        Sign up
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="footer">
    <?php	include('../partials/footer.php');	?>
    </div>
</body>
</html>

<?php
require_once('connection.php');
// require_once('send_email.php');
session_start();

$new_email = $_POST['email'];
$new_fullname = $_POST['name'];
$new_user = $_POST['login'];
$new_pwd = $_POST['passwd'];
$re_pwd = $_POST['re-passwd'];
$status = 0;
$notifications = 1;
$activation_code = md5($new_email.time());

if($_POST['email'] && $_POST['name'] && $_POST['login'] && $_POST['passwd'] === $_POST['re-passwd'] && $_POST['submit'] && $_POST['submit'] === 'OK')
{
    $new_pwd = hash('whirlpool', $new_pwd);
    try
    {
        $conn = connection();
        $stm = $conn->prepare("INSERT INTO user_info (email, fullname, u_name, pwd, activation_code, activ_status, notif_status)
                               VALUES (:new_email, :new_fullname, :new_user, :new_pwd, :activation_code, :activ_status, :notif_status)");
        $stm->bindParam(':new_mail', $new_mail, PDO::PARAM_STR);
        $stm->bindParam(':new_fullname', $new_fullname, PDO::PARAM_STR);
        $stm->bindParam(':new_user', $new_user, PDO::PARAM_STR);
        $stm->bindParam(':new_pwd', $new_pwd, PDO::PARAM_STR);
        $stm->bindParam(':activation_code', $activation_code, PDO::PARAM_STR);
        $stm->bindParam(':activ_status', $status, PDO::PARAM_STR);
        $stm->bindParam(':notif_status', $notifications, PDO::PARAM_STR);
        $stm->execute();
    }
    catch(PDOException $e)
    {
        echo $stm . "<br>" . $e->getMessage();
    }
    $conn = null;
}

?>