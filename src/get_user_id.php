<?php
session_start();
require_once("connection.php");

function get_id()
{  
    $pic_owner = $_SESSION['logged_in_user'];
    try
    {
        $conn = connection();
        $sql = "SELECT id FROM `user_info` WHERE u_name='$pic_owner'";
        $qry = $conn->query($sql);
        $user = $qry->fetch(PDO::FETCH_ASSOC);
        $_SESSION['logged_user_id'] = $user['id'];
    }
    catch(PDOException $e)
    {
        echo $qry . "<br>" . $e->getMessage();
    }
    $conn = null;
    return $user;
}
?>