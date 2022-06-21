<?php
session_start();
require_once('connection.php');
require_once('print_msg.php');

if ($_SESSION['logged_in_user'] == "")
    header("Location: ../index.php");

if(isset($_POST['delete_pic']) && isset($_POST['picture_path']))
{
    
}

?>