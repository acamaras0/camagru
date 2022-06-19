<?php
require_once("connection.php");

function get_id()
{
    session_start();
    $pic_owner = $_SESSION['logged_in_user'];
    try
    {
        $conn = connection();
        $sql = "SELECT id FROM `user_info` WHERE u_name='$pic_owner'";
        $qry = $conn->query($sql);
        $user = $qry->fetch(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e)
    {
        echo $qry . "<br>" . $e->getMessage();
    }
    return $user;
}
?>