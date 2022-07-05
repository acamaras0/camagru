<?php
session_start();
require_once('connection.php');
require_once('print_msg.php');
require_once('info_check.php');
require_once('character_check.php');
require_once('auth.php');
require_once('get_user_id.php');

if ($_SESSION['logged_in_user'] == "")
    header("Location: landing.php");
$user = $_SESSION['logged_in_user'];
$email = $_POST['email'];
$full_name = strip_tags($_POST['fullname']);
$new_username = strip_tags($_POST['username']);
$password = $_POST['passwd'];
$repeat_password = $_POST['re-passwd'];
$current_password = $_POST['current-passwd'];
get_id();
$user_id = $_SESSION['logged_user_id'];

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
                header('Refresh:  2; settings.php');
            }
        }
        else if (!empty($full_name))
        {
            if (info_check(2, 0, $user) == 0)
            {
                try
                {
                    $conn = connection();
                    $sql = $conn->prepare("UPDATE user_info SET fullname=:new_fullname WHERE u_name='$user'");
                    $sql->bindParam(':new_fullname', $full_name, PDO::PARAM_STR);
                    $sql->execute();
                }
                catch(PDOException $e)
                {
                    echo $qry . "<br>" . $e->getMessage();
                }
                $conn = null;
                print_msg("Fullname succesfully changed.");
                header('Refresh: 2; settings.php');
            }
            else
            {
                print_msg("Something went wrong. Try again!");
                header('Refresh  2; settings.php');
            }
        }
        else if (!empty($new_username))
        {
            if (info_check(2, 0, $new_username) == 1 && character_check($new_username) == 0)
            {
                if (strlen($new_username) <= 20 && strlen($new_username) >= 4)
                {
                    try
                    {
                        $conn = connection();
                        $sql = $conn->prepare("UPDATE user_info SET u_name=:new_username WHERE u_name='$user'");
                        $sql->bindParam(':new_username', $new_username, PDO::PARAM_STR);
                        $sql->execute();
                        $sql = $conn->prepare("UPDATE user_pictures SET picture_owner=:picture_owner WHERE picture_owner='$user'");
                        $sql->bindParam(':picture_owner', $new_username, PDO::PARAM_STR);
                        $sql->execute();
                        $sql = $conn->prepare("UPDATE user_comments SET picture_owner=:picture_owner WHERE picture_owner='$user'");
                        $sql->bindParam(':picture_owner', $new_username, PDO::PARAM_STR);
                        $sql->execute();
                        $sql = $conn->prepare("UPDATE user_likes SET like_owner=:like_owner WHERE like_owner='$user'");
                        $sql->bindParam(':like_owner', $new_username, PDO::PARAM_STR);
                        $sql->execute();
                    }
                    catch(PDOException $e)
                    {
                        echo $qry . "<br>" . $e->getMessage();
                    }
                    $conn = null;
                    $_SESSION['logged_in_user'] = $new_username;
                    print_msg("Username successfully changed.");
                    header('Refresh: 2; settings.php');
                }
                else
                {
                    print_msg("Username has to be in between 4 and 20 characters long.");
                    header('Refresh: 2; settings.php');
                }
            }
            else
            {
                print_msg("Username already in use.");
                header('Refresh: 2; settings.php');
            }
        }
        else if(!empty($password))
        {
            if($password == $repeat_password && strlen($password > 10) && number_check($password) == 1 && character_check($password) == 1)
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
                print_msg("Password successfully changed.");
                header('Refresh: 2; settings.php');
            }
            else
            {
                print_msg("Passwords have to be identical, minimum 10 characters long, including a number, a capital letter and a special character.");
                header('Refresh: 6; settings.php');
            }
        }
    }
    else
        print_msg("Wrong password.");
}

if (isset($_POST['delete_user']))
{
    if (auth($user, $current_password) == 2)
    {
        try
        {
            $conn = connection();
            $sql = "SELECT picture_path FROM user_pictures WHERE id_owner='$user_id'";
            $qry = $conn->query($sql);
            $res = $qry->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $key)
            {
                $path = $key['picture_path'];
                unlink($path);
            }
        }
        catch(PDOException $e)
        {
            echo $qry . "<br>" . $e->getMessage();
        }
        $conn = null;
        try
        {
            $conn = connection();
            $sql = "DELETE FROM user_info WHERE u_name='$user'";
            $conn->exec($sql);
            $sql = "DELETE FROM user_pictures WHERE  picture_owner='$user'";
            $conn->exec($sql);
            $sql = "DELETE FROM user_comments WHERE  id_owner='$user_id'";
            $conn->exec($sql);
            $sql = "DELETE FROM user_likes WHERE  id_owner='$user_id'";
            $conn->exec($sql);
        }
        catch(PDOException $e)
        {
            echo $qry . "<br>" . $e->getMessage();
        }
        $conn = null;
        print_msg("Account deleted successfully!");
        $_SESSION['logged_in_user'] == "";
        session_destroy();
        header('Refresh: 2; landing.php');
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
        <form class="form2" action="notifications_update.php" method="post">
            <div class="notifi">
            <div class="notif-container">
                <label>Notifications</label>
                <input class="notif" type="submit" name="on" value="ON" />
                <input class="notif" type="submit" name="off" value="OFF" />
            </div>
            </div>
        </form>
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
                    <input type="password" name="re-passwd"  value="">
                </div>
                <div class="current-password input-element">
                    <label>Input your current password in order to save the changes:
                        </label>
                        <input type="password" name="current-passwd"  value="">
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