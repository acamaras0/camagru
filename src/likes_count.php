<?php
session_start();
require_once('connection.php');
require_once('print_msg.php');
require_once('get_user_id.php');

if ($_SESSION['logged_in_user'] == "")
header("Location: ../index.php");
get_id();
$user_id = $_SESSION['logged_user_id'];
if (isset($_POST['heart']) && isset($_POST['user_like']))
{
    header('Location: newsfeed.php');
    $user_like = $_POST['user_like'];
    $picture_name = $_POST['picture_name'];
    $picture_owner = $_POST['picture_owner'];
    try
    {
        $conn = connection();
        $owner = "SELECT picture_owner FROM user_pictures WHERE picture_name='$picture_name'";
        $qry_owner= $conn->query($owner);
        $res_owner = $qry_owner->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
    $conn = null;
    if($res_owner[0]['picture_owner'] != $user_like)
    {
        try
        {
            $conn = connection();
            $insert = $conn->prepare("INSERT INTO user_likes (picture_name, like_owner, id_owner)
                                        VALUES (:picture_name, :like_owner, :id_owner)");
            $insert->bindParam(':picture_name', $picture_name, PDO::PARAM_STR);
            $insert->bindParam(':like_owner', $user_like, PDO::PARAM_STR);
            $insert->bindParam(':id_owner', $user_id, PDO::PARAM_STR);
        }
        catch(PDOException $e)
        {
            echo $sql . "<br>" . $e->getMessage();
        }
        $conn = null;
    }
    else
    {
        try
        {
            $conn = connection();
            $del = "DELETE FROM user_likes WHERE picture_name ='$picture_name'";
            $conn = exec($del);
        }
        catch(PDOException $e)
        {
            echo $sql . "<br>" . $e->getMessage();
        }
        $conn = null;
    }
}
else
{
    print_msg("Error.");
}


?>