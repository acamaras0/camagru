<?php
    session_start();
    require_once("connection.php");

    $conn = connection();
    $user = $_SESSION['logged_in_user'];
    $sql = "SELECT picture_path, picture_name, picture_owner, created_at FROM `user_pictures` WHERE picture_owner='$user' ORDER BY id DESC";
    $qry = $conn->query($sql);
    $res = $qry->fetchAll(PDO::FETCH_ASSOC);?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Profile</title>
            <link rel="stylesheet" type="text/css" href="../style.css">
        </head>
        <body>
        <div class="camera">
                <a href="newsfeed.php"><img src="../img/cam.png" alt="camera"></a>
                <div class="profile_name"><?php echo $key['picture_owner'];?></div>
            </div>
            <div class="header">
                <?php include('../partials/header_profile.php'); ?>
            </div>

    <?php
    if ($res)
    {
        foreach($res as $key)
        {
            $id = $key['picture_name'];
            ?>
                <div class="middle-profile">
                    <div class="border-profile">
                        <div class="username"><?php echo $key['picture_owner'];?></div>
                        <?php echo " " . $key['created_at']?>
                        <img class="picture" src=<?php echo $key['picture_path'];?>>
                    </div>
                </div>
        <?php
        }
    }
?>

            <div class="footer">
                <?php	include('../partials/footer.php');	?>
            </div>
        </body>
        </html> 
