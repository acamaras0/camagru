<?php
    require_once('connection.php');

    //checks that the login and password match and also if the account was activated

    function auth($login, $passwd)
    {
        $res = 0;
        try{
            $conn = connection();
            $sql = "SELECT u_name, pwd, activ_status FROM user_info";
            $qry = $conn->query($sql);
            $result = $qry->fetchAll(PDO::FETCH_ASSOC);
            if ($result)
            {
                foreach ($result as $key)
                {
                    $user_pwd = hash('whirlpool', $passwd);
                    if ($key['u_name'] == $login && $key['pwd'] == $user_pwd)
                        $res += 1;
                    if ($key['activ_status'] == 1 && $res == 1)
                    {
                        $conn = null;
                        return($res += 1);
                    }
                }
            }
        }
        catch(PDOException $e)
        {
            echo $qry . "<br>" . $e->getMessage();
        }
        $conn = null;
        return $res;
    }
?>
