<?php
require_once('connection.php');
require_once('print_msg.php');
session_start();

if ($_SESSION['logged_in_user'] == "")
    header("Location: landing.php");

if (isset($_POST['on']) || isset($_POST['off']))
{
    $user = $_SESSION['logged_in_user'];
    $active = 1;
    $inactive = 0;
    if (isset($_POST['on']))
    {
        try
        {
            $conn = connection();
            $sql = $conn->prepare("UPDATE user_info SET notif_status=:new_status WHERE u_name='$user'");
            $sql->bindParam(':new_status', $active, PDO::PARAM_STR);
            $sql->execute();
        }
        catch(PDOException $e)
        {
            echo $sql . "<br>" . $e->getMessage();
        }
        $conn = null;
        print_msg("Notifications turned on!");
        header("Refresh: 2; settings.php");
    }
    else if (isset($_POST['off']))
    {
        try
        {
            $conn = connection();
            $sql = $conn->prepare("UPDATE user_info SET notif_status=:new_status WHERE u_name='$user'");
            $sql->bindParam(':new_status', $inactive, PDO::PARAM_STR);
            $sql->execute();
        }
        catch(PDOException $e)
        {
            echo $sql . "<br>" . $e->getMessage();
        }
        $conn = null;
        print_msg("Notifications turned off!");
        header("Refresh: 2; settings.php");
    }
}

?>