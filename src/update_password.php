<?php
require_once("print_msg.php");
require_once("connection.php");
require_once("character_check.php");
session_start();

if(isset($_POST['new']) && isset($_POST['repeat']) && isset($_POST['username']))
{
    $new_pass = $_POST['new'];
    $repeat_pass = $_POST['repeat'];
    $username = $_POST['username'];
    if (strlen($new_pass) < 10 || number_check($new_pass) == 0 || character_check($new_pass) == 0)
    {
        print_msg("Password has to be min. 10 characters long and has to include 1 number and 1 special character");
        header('Refresh: 3; reset_password.php');
    }
    if ($new_pass == $repeat_pass)
    {
        try
        {
            $conn = connection();
            $new_pass = hash('whirlpool', $new_pass);
            $qry = $conn->prepare("UPDATE user_info SET pwd=:new_pass WHERE u_name='$username'");
            $qry->bindParam(':new_pass', $new_pass, PDO::PARAM_STR);
            $qry->execute();
        }
        catch(PDOException $e)
        {
            echo $qry . "<br>" . $e->getMessage();
        }
        print_msg("Your password has been succesfully changed!");
        header('Refresh: 2 ; login.php');
    }
    else
    {
        print_msg("Passwords have to be identical. Try again!");
        header('Refresh: 2 ; login.php');
    }
}
else
{
    print_msg("Error");
}

?>