<?php
session_start();
require_once('connection.php');
require_once('print_msg.php');
require_once('send_email.php');
require_once('get_user_id.php');

if ($_SESSION['logged_in_user'] == "")
    header("Location: ../index.php");

get_id();
$user_like = $_SESSION['logged_user_id'];
if (isset($_POST['heart']))
{
    header('Location: newsfeed.php');
    $picture_name = $_POST['picture_name'];
    $picture_owner = $_POST['picture_owner'];
    try
    {
        $conn = connection();
        $owner = "SELECT id_owner FROM user_pictures WHERE picture_name='$picture_name'";
        $qry_owner= $conn->query($owner);
        $res_owner = $qry_owner->fetchAll(PDO::FETCH_ASSOC);
        foreach($res_owner as $key_owner)
        {
            $id_owner = $key_owner['id_owner'];
        }
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
        foreach($res_likes as $key_likes)
        {
            $like_owner = $key_likes['like_owner'];
        }
    }
    catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
    $conn = null;

    if(($id_owner != $user_like) && ($like_owner != $user_like))
    {
        try
        {
            $conn = connection();
            $sql = $conn->prepare("INSERT INTO user_likes (picture_name, like_owner, id_owner)
                                        VALUES (:picture_name, :like_owner, :id_owner)");
            $sql->bindParam(':picture_name', $picture_name, PDO::PARAM_STR);
            $sql->bindParam(':like_owner', $user_like, PDO::PARAM_STR);
            $sql->bindParam(':id_owner', $id_owner, PDO::PARAM_STR);
            $sql->execute();
        }
        catch(PDOException $e)
        {
            echo $sql . "<br>" . $e->getMessage();
        }
        $conn = null;
        try
        {
            $conn = connection();
            $sql = "SELECT * FROM user_info WHERE u_name='$picture_owner'";
            $sql = $conn->query($sql);
            $res = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach($res as $key)
            {
                $email = $key['email'];
                $notif_status = $key['notif_status'];
            }
        }
        catch(PDOException $e)
        {
            echo $sql . "<br>" . $e->getMessage();
        }
        if($notif_status == 1)
        {
            send_email($email, 0, 0, 0, 4);
        }
        $conn = null;
    }
    if ($like_owner == $user_like)
    {
        try
        {
            $conn = connection();
            $del = "DELETE FROM user_likes WHERE picture_name ='$picture_name' AND like_owner = '$user_like'";
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