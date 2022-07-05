<?php
session_start();
require_once('print_msg.php');
require_once('connection.php');
require_once('send_email.php');
require_once('get_user_id.php');

if ($_SESSION['logged_in_user'] == "")
header("Location: ../index.php");
get_id();
$user_id = $_SESSION['logged_user_id'];

if(isset($_POST['submit']))
{
    if(!empty($_POST['comments']))
    {
        header('Location: newsfeed.php');
        $username = $_SESSION['logged_in_user'];
        $picture_name = $_POST['picture_name'];
        $picture_owner = $_POST['picture_owner'];
        $comm = htmlspecialchars($_POST['comments']);
        try
        {
            $conn = connection();
            $sql = $conn->prepare("INSERT INTO user_comments(comments, picture_name, picture_owner, id_owner)
                                    VALUES(:comments, :picture_name, :picture_owner, :id_owner)");
            $sql->bindParam(':comments', $comm, PDO::PARAM_STR);
            $sql->bindParam(':picture_name', $picture_name, PDO::PARAM_STR);
            $sql->bindParam(':picture_owner', $picture_owner, PDO::PARAM_STR);
            $sql->bindParam(':id_owner', $user_id, PDO::PARAM_STR);
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
        }
        catch(PDOException $e)
        {
            echo $sql . "<br>" . $e->getMessage();
        }
        if($res[0]['notif_status'] == 1)
        {
            send_email($res[0]['email'], 0, 0, 0, 3);
        }
        $conn = null;
    }
    else
    {
        print_msg("You can't leave an empty comment!");
        header("Refresh: 2; newsfeed.php");
    }
}
?>