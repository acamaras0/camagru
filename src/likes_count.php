<?php
session_start();
require_once('connection.php');
require_once('print_msg.php');

if ($_SESSION['logged_in_user'] == "")
header("Location: ../index.php");
if (isset($_POST['heart']) && isset($_POST['user_like']))
{
    header('Location: newsfeed.php');
    $user_like = $_POST['user_like'];
    $picture_name = $_POST['picture_name'];
    $picture_owner = $_POST['picture_owner'];
    try
    {
        $conn = connection();
        $owner = "SELECT id_owner FROM user_pictures WHERE picture_name='$picture_name'";
        $qry_owner= $conn->query($owner);
        $res_owner = $qry_owner->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
    $conn = null;

    try
    {
        $conn = connection();
        $owner_likes = "SELECT like_owner FROM user_likes WHERE picture_name='$picture_name'";
        $qry_likes= $conn->query($owner_likes);
        $res_likes = $qry_likes->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
    $conn = null;

    if(($res_owner[0]['id_owner'] != $user_like) && ($res_likes[0]['like_owner'] != $user_like))
    {
        try
        {
            $conn = connection();
            $sql = $conn->prepare("INSERT INTO user_likes (picture_name, like_owner, id_owner)
                                        VALUES (:picture_name, :like_owner, :id_owner)");
            $sql->bindParam(':picture_name', $picture_name, PDO::PARAM_STR);
            $sql->bindParam(':like_owner', $user_like, PDO::PARAM_STR);
            $sql->bindParam(':id_owner', $res_owner[0]['id_owner'], PDO::PARAM_STR);
            $sql->execute();
        }
        catch(PDOException $e)
        {
            echo $sql . "<br>" . $e->getMessage();
        }
        $conn = null;
    }
    if ($res_likes[0]['like_owner'] == $user_like)
    {
        try
        {
            $conn = connection();
            $del = "DELETE FROM user_likes WHERE picture_name ='$picture_name'";
            $conn->exec($del);
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