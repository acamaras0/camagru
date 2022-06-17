<?php
    session_start();
    require_once("connection.php");

    $conn = connection();
    $pic_owner = $_SESSION['logged_in_user'];
        try
        {
            $conn1 = connection();
            $sqlid = "SELECT id FROM user_info WHERE u_name='$pic_owner'";
            $qryid = $conn->query($sqlid);
            $user = $qryid->fetch(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
        {
            echo $qry . "<br>" . $e->getMessage();
        }
        $conn1 = null;
    $sql = "SELECT picture_path, picture_name, picture_owner, id_owner, created_at FROM `user_pictures` WHERE id_owner='$user' ORDER BY id DESC";
    $qry = $conn->query($sql);
    $res = $qry->fetchAll(PDO::FETCH_ASSOC);?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Newsfeed</title>
            <link rel="stylesheet" type="text/css" href="../style.css">
        </head>
        <body>
        <div class="camera">
                <a href="newsfeed.php"><img src="../img/cam.png" alt="camera"></a>
            </div>
            <div class="header">
                <?php include('../partials/header_newsfeed.php'); ?>
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
