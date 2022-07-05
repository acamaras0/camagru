<?php
    session_start();
    require_once("connection.php");
    require_once("print_msg.php");

    // sets the activation status to true.
    function update_status($activation_code)
    {
        $status = 1;
        try
        {
            $conn = connection();
            $prep = $conn->prepare("UPDATE user_info SET activ_status=:activ_status WHERE activation_code=:activation_code");
            $prep->bindParam(":activation_code", $activation_code, PDO::PARAM_STR);
            $prep->bindParam(":activ_status", $status, PDO::PARAM_STR);
            $prep->execute();
        }
        catch(PDOException $e)
        {
            echo $prep . "<br>" . $e->getMessage();
        }
        $conn = null;
    }

    //checks that the activation code sent in the email matches the one in the database
    function code_check($activation_code)
    {
        try
        {
            $conn = connection();
            $sql = "SELECT activation_code FROM user_info WHERE BINARY activation_code='$activation_code'";
            $qry = $conn->query($sql);
            $res = $qry->fetchAll(PDO::FETCH_ASSOC);
            if($res)
            {
                foreach($res as $key)
                {
                    if($activation_code == $key['activation_code'])
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

    if(isset($_GET['code']) && !empty($_GET['code']))
    {
        $activation_code = $_GET['code'];
        $status = code_check($activation_code);
        if($status == 1)
        {
            update_status($activation_code);
            print_msg("Your account has been activated!");
            header("Refresh: 1.5; login.php");
        }
    }
    else 
        print_msg("A problem has occured. Try again later.");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account activation</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>

</body>
</html>
