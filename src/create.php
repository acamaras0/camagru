<?php
    require_once('user_verification.php');
    require_once('connection.php');
    require_once('send_email.php');
    require_once('character_check.php');
    require_once('print_msg.php');
    session_start();

    if(isset($_POST['submit']))
    {
        $new_email = $_POST['email'];
        $new_fullname = strip_tags($_POST['name']);
        $new_user = strip_tags($_POST['login']);
        $new_pwd = $_POST['passwd'];
        $re_pwd = $_POST['re-passwd'];
        $status = 0;
        $notifications = 1;
        $activation_code = md5($new_email.time());
        if(strlen($new_user) > 20 || strlen($new_user) < 4)
        {
            print_msg("Username has to be in between 4 and 20 characters long.");
            header('Refresh: 2; create.php');
        }
        else if (character_check($new_user) == 1)
        {
            print_msg("It can only contain aphabetical characters, numbers and underscores.");
            header('Refresh: 2; create.php');
        }
        else if (($new_pwd != $re_pwd) || strlen($new_pwd < 10) || number_check($new_pwd) == 0 || character_check($new_pwd) == 0)
        {
            print_msg("Passwords have to be identical, minimum 10 characters long, including a number, a capital letter and a special character.");
            header('Refresh: 5; create.php');
        }
        else if($_POST['email'] && $_POST['name'] && $_POST['login'] && $_POST['passwd'] === $_POST['re-passwd'] && isset($_POST['submit']))
        {
            $double_user_verification = verif_user($new_email, $new_user);
            if($double_user_verification == 2)
            {
                print_msg("Email address already in use.");
                header("Refresh: 2; create.php?message=2");
            }
            else if($double_user_verification == 1)
            {
                print_msg("Username already in use.");
                header("Refresh: 2; create.php?message=3");
            }
            else if($double_user_verification == 0)
            {
                $new_pwd = hash('whirlpool', $new_pwd);
                try
                {
                    $conn = connection();
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stm = $conn->prepare("INSERT INTO user_info (email, fullname, u_name, pwd, activation_code, activ_status, notif_status)
                                        VALUES (:new_email, :new_fullname, :new_user, :new_pwd, :activation_code, :activ_status, :notif_status)");
                    $stm->bindParam(':new_email', $new_email, PDO::PARAM_STR);
                    $stm->bindParam(':new_fullname', $new_fullname, PDO::PARAM_STR);
                    $stm->bindParam(':new_user', $new_user, PDO::PARAM_STR);
                    $stm->bindParam(':new_pwd', $new_pwd, PDO::PARAM_STR);
                    $stm->bindParam(':activation_code', $activation_code, PDO::PARAM_STR);
                    $stm->bindParam(':activ_status', $status, PDO::PARAM_STR);
                    $stm->bindParam(':notif_status', $notifications, PDO::PARAM_STR);
                    $stm->execute();
                }
                catch(PDOException $e)
                {
                    echo $stm . "<br>" . $e->getMessage();
                }
                $conn = null;
                send_email($new_email, $activation_code, $new_user, $new_pwd, 1);
                print_msg("User created succesfully! Activation link sent!");
                header("Refresh: 2; login.php?message=1");
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create account</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="camera">
        <a href="landing.php"><img src="../img/cam.png" alt="camera"></a>
    </div>
    <div class="header">
        <h1>Camagru</h1>
    </div>
    <div class="middle">
        <form class= "form" action="create.php" method="POST">
            <div class="signup-container">
                <h1>Sign up</h1>
                <div class="email-new input-element">
                    <label>Email address</label>
                    <input type="email" name="email" placeholder="example@example.com" required>
                </div>
                <div class="fullname input-element">
                    <label>Full name</label>
                    <input type="text" name="name" placeholder="John Doe" required>
                </div>
                <div class="username-new input-element">
                    <label>Username</label>
                    <input type="text" name="login" placeholder="4-20 characters long" required>
                </div>
                <div class="password-new input-element">
                    <label>Password</label>
                    <input type="password" name="passwd" required>
                </div>
                <div class="repeat-password input-element">
                    <label>Repeat password</label>
                    <input type="password" name="re-passwd" required>
                </div>
                
                <div class="button-container">
                    <button class="create-button" type="submit" name="submit">Sign up</button>
                </div>
                </br>
                <label class="info">*Username has to be in between 4-20 characters long.</lable></br>
                <label class="info">*Passwords have to be identical, minimum 10 characters long, including a number, a capital letter and a special character.</lable>

            </div>
        </form>
    </div>
    <div class="footer">
    <?php	include('../partials/footer.php');	?>
    </div>
</body>
</html>