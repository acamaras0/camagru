<?php
session_start();
require_once('connection.php');
require_once('print_msg.php');
require_once('get_user_id.php');

if ($_SESSION['logged_in_user'] == "")
    header("Location: ../index.php");

get_id();
$user_id = $_SESSION['logged_user_id'];
$path = $_POST['picture_path'];

$conn = connection();
$checkDel = "SELECT id_owner FROM user_pictures WHERE picture_path = '$path'";
$qry= $conn->query($checkDel);
$res = $qry->fetchAll(PDO::FETCH_ASSOC);
$id_on_pic = $res[0]['id_owner'];

if(isset($_POST['delete_pic']) && isset($_POST['picture_path']) && ($user_id == $id_on_pic))
{
    $img = $_POST['picture_path'];
    try
    {
        $conn = connection();
        $sql = "DELETE FROM user_pictures WHERE picture_path='$img'";
        $conn->exec($sql);
        $sql = "DELETE FROM user_comments WHERE id_owner='$user_id'";
        $conn->exec($sql);
        $sql = "DELETE FROM user_likes WHERE id_owner='$user_id'";
        $conn->exec($sql);
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
{
    print_msg("Something went wrong.");
    header("Refresh: 2; profile.php");
}
?>