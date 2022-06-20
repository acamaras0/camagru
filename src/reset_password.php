<?php
require_once("connection.php");
require_once("print_msg.php");
session_start();


if(isset($_GET['user']) && isset($_GET['pwd']))
{
    $username = $_GET['user'];
    $password = $_GET['pwd'];
    $email = $_GET['mail'];
    try
    {
        $conn = connection();
        $sql = "SELECT u_name, pwd FROM user_info WHERE email='$email'";
        $qry = $conn->query($sql);
        $res = $qry->fetchAll(PDO::FETCH_ASSOC);
        if($res[0]['u_name'] == $username && $res[0]['pwd'] == $password)
        {
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Reset Password</title>
                <link rel="stylesheet" type="text/css" href="../style.css">
            </head>
            <body>
            <div class="camera">
                <a href="login.php"><img src="../img/cam.png" alt="camera"></a>
                </div>
                <div class="header">
                    <h1>Camagru</h1>
                </div>
                <div class="middle">
                    <form method="POST" action="update_password.php">
                        <div class="signup-container">
                            <h1>Password reset</h1>
                            <div>
                                New password:
                                <input type="password"  name="new" value="" required></input>
                            </div>
                            <div>
                                Repeat password:
                                <input type="password"  name="repeat" value="" required></input>
                                <input type="hidden" id="username" name="username" value='<?php echo $username;?>'>
                            </div>
                            <div class="">
                                <button type="submit" name="submit" value="OK">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="footer">
                <?php	include('../partials/footer.php');	?>
                </div>
            </body>
            </html>
            <?php
        }
        else
        {
            print_msg("Error. Try again!");
            header('Refresh: 2; login.php');
        }
    }
    catch(PDOException $e)
    {
        echo $qry . "<br>" . $e->getMessage();
    }
}
else
{
    print_msg("Error.");
    header('Refresh: 2; login.php');
}
?>