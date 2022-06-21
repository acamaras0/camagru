<?php
session_start();
require_once('connection.php');
require_once('print_msg.php');
require_once('get_user_id.php');

if ($_SESSION['logged_in_user'] == "")
    header("Location: ../index.php");

$user_id = $_SESSION['logged_user_id'];
if(isset($_POST['delete_pic']) && isset($_POST['picture_path']))
{
    $img = $_POST['picture_path'];
    $user_id = $_SESSION['logged_user_id'];
    try
    {
        $conn = connection();
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
        echo $sql . "<br>" . $e->getMessage();
    }
    $conn = null;
    print_msg("Picture succesfully deleted!");
    header("Refresh: 2; profile.php");
}
else
    print_msg("Something went wrong.");
?>