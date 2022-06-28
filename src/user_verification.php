<?php
require_once('connection.php');

function verif_user($email, $usr_name)
{
    try
    {
        $conn = connection();
        $sql = "SELECT email, u_name FROM user_info";
        $qry = $conn->query($sql);
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        if($res)
        {
            foreach($res as $key)
            {
                if($key['email'] == $email)
                {
                    $conn = null;
                    return 2;
                }
                else if($key['u_name'] == $usr_name)
                {
                    $conn = null;
                    return 1;
                }
            }
        }
    }
    catch(PDOException $e)
    {
        echo $qry . "<br>" . $e->getMessage();
    }
    $conn = null;
    return 0;
}
?>