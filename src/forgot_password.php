<?php
    session_start();
    require_once('connection.php');
    require_once('send_email.php');
    require_once('print_msg.php');

    if (isset($_POST['submit']))
    {
        if(!empty($_POST['email']) && isset($_POST['submit']))
        {
            $address = $_POST['email'];
            try
            {
                $conn = connection();
                $sql = "SELECT u_name, pwd FROM user_info WHERE email='$address'";
                $qry = $conn->query($sql);
                $res = $qry->fetchAll(PDO::FETCH_ASSOC);
                $username = $res[0]['u_name'];
                $password = $res[0]['pwd'];
            }
            catch(PDOException $e)
            {
                echo $qry . "<br>" . $e->getMessage();
            }
            $conn = null;
            send_email($address, 0, $username, $password, 2);
            print_msg("A link to reset your password was sent to your email.");
            header('Refresh: 2; login.php');
        }
        else
        {
            print_msg("Email address not found in the database. Try again!");
            header('Refresh: 2; forgot_password.php');
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgotten password</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
    <div class="camera">
    <a href="../index.php"><img src="../img/cam.png" alt="camera"></a>
    </div>
    <div class="header">
        <h1>Camagru</h1>
    </div>

    <div class="middle">
        <form method="post">
            <div class="signup-container">
                <h1>Forgotten password</h1>
                <div class="email">
                    Email address:
                    <input type="email"  name="email" required></input>
                </div>
                <div class="forgot">
                    <button type="submit" name="submit" value="">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <div class="footer">
    <?php	include('../partials/footer.php');	?>
    </div>
</body>
</html>

