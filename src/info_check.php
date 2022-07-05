<?php
require_once('connection.php');

// when creating a new user, this functions checks if we already have the username
// and/or the email address registered in the database

function info_check($check ,$email, $username)
{
    try
    {
        $conn = connection();
        $sql = "SELECT * FROM user_info";
        $qry = $conn->query($sql);
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(PDOException $e)
    {
        echo $qry . "<br>" . $e->getMessage();
    }
    $conn = null;
    foreach ($res as $key)
    {
        if($check == 1 && $key['email'] == $email)
            return 0;
        if($check == 2 && $key['u_name'] == $username)
            return 0;
    }
    return 1;
}

?>