<?php
session_start();
require_once('connection.php');
require_once('print_msg.php');
require_once('info_check.php');
require_once('auth.php');

if ($_SESSION['logged_in_user'] == "")
    header("Location: landing.php");
$user = $_SESSION['logged_in_user'];
$email = $_POST['email'];
$full_name = $_POST['fullname'];
$new_username = $_POST['username'];
$password = $_POST['passwd'];
$repeat_password = $_POST['re-passwd'];
$current_password = $_POST['current-passwd'];

if(isset($_POST['submit']))
{
    if (auth($user, $current_password) == 2)
    {
        if (!empty($email))
        {
            if (info_check(1, $email, 0) == 1)
            {
                try
                {
                    $conn = connection();
                    $sql = $conn->prepare("UPDATE user_info SET email=:new_email WHERE u_name='$user'");
                    $sql->bindParam(':new_email', $email, PDO::PARAM_STR);
                    $sql->execute();
                }
                catch(PDOException $e)
                {
                    echo $qry . "<br>" . $e->getMessage();
                }
                $conn = null;
                print_msg("Email address succesfully changed.");
                header('Refresh: 2; settings.php');
            }
            else
            {
                print_msg("Email already in use.");
                header('Refresh  2; settings.php');
            }
        }
        if (!empty($username))
        {
            if (info_check(2, 0, $user) == 1)
            {
                try
                {
                    $conn = connection();
                    $sql = $conn->prepare("UPDATE user_info SET u_name=:new_username WHERE u_name='$user'");
                    $sql->bindParam(':new_username', $username, PDO::PARAM_STR);
                    $sql->execute();
                    $sql = $conn->prepare("UPDATE user_images SET picture_owner=:picture_owner WHERE picture_owner='$user'");
                    $sql->bindParam(':picture_owner', $username, PDO::PARAM_STR);
                    $sql->execute();
                    $sql = $conn->prepare("UPDATE user_comments SET picture_owner=:picture_owner WHERE picture_owner='$user'");
                    $sql->bindParam(':picture_owner', $username, PDO::PARAM_STR);
                    $sql->execute();
                    $sql = $conn->prepare("UPDATE user_likes SET picture_owner=:picture_owner WHERE picture_owner='$user'");
                    $sql->bindParam(':picture_owner', $username, PDO::PARAM_STR);
                    $sql->execute();
                }
                catch(PDOException $e)
                {
                    echo $qry . "<br>" . $e->getMessage();
                }
                $conn = null;
                $_SESSION['logged_in_user'] = $username;
                print_msg("Username succesfully changed.");
                header('Refresh: 2; settings.php');
            }
            else
            {
                print_msg("Username already in use.");
                header('Refresh: 2; settings.php');
            }
        }
        if(!empty($password))
        {
            if($password == $repeat_password)
            {
                $password = hash('whirlpool', $password);
                try
                {
                    $conn = connection();
                    $sql = $conn->prepare("UPDATE user_info SET pwd=:new_password WHERE u_name='$user'");
                    $sql->bindParam(':new_password', $password, PDO::PARAM_STR);
                    $sql->execute();
                }
                catch(PDOException $e)
                {
                    echo $qry . "<br>" . $e->getMessage();
                }
                $conn = null;
                print_msg("Password succesfully changed.");
                header('Refresh: 2; settings.php');
            }
            else
            {
                print_msg("The passwords have to identical.");
                header('Refresh: 2; settings.php');
            }
        }
    }
    else
    {
        print_msg("Password incorrect! Try again!");
        header('Refresh: 2; settings.php');
    }
}

if (isset($_POST['delete_user']))
{
    if (auth($user, $current_password) == 2)
    {
        try
        {
            $conn = connection();
            $sql = "DELETE FROM user_info WHERE u_name='$user'";
            $conn->exec($sql);
            $sql = "DELETE FROM user_pictures WHERE picture_path='$img'";
            $conn->exec($sql);
            // $sql = "DELETE FROM user_comments WHERE id_owner='$user_id'";
            // $conn->exec($sql);
            // $sql = "DELETE FROM user_likes WHERE id_owner='$user_id'";
            // $conn->exec($sql);
            unlink($img);
        }
        catch(PDOException $e)
        {
            echo $qry . "<br>" . $e->getMessage();
        }
        $conn = null;
    }
    else
    {
        print_msg("Password incorrect! Try again!");
        header('Refresh: 2; settings.php');
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
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
        <form class= "form" action="settings.php" method="POST">
            <div class="signup-container">
                <div class="email-new input-element">
                    <label>Change e-mail address</label>
                    <input type="email" name="email" value="">
                </div>
                <div class="fullname input-element">
                    <label>Change full name</label>
                    <input type="text" name="fullname" value="">
                </div>
                <div class="username-new input-element">
                    <label>Change username</label>
                    <input type="text" name="username" value="">
                </div>
                <div class="password-new input-element">
                    <label>Change password</label>
                    <input type="password" name="passwd" value="">
                    <label>Repeat new password</label>
                    <input type="password" name="re-passwd"  value="" required>
                </div>
                <div class="current-password input-element">
                    <label>Input your current password in order to save the changes:
                    </label>
                    <input type="password" name="current-passwd"  value="" required>
                </div>
                <div class="button-container">
                    <button class="create-button" type="submit" name="submit"  value="OK">Submit changes</button>
                </div>
                <div class="button-container">
                    <button class="delete-button" type="delete_user" name="delete_user" value="OK">Delete account</button>
                </div>
            </div>
        </form>
    </div>
    <div class="footer">
        <?php	include('../partials/footer.php');	?>
    </div>
</body>
</html>