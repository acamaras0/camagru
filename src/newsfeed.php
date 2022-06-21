<?php
    session_start();
    require_once("connection.php");
    require_once("get_user_id.php");

    if ($_SESSION['logged_in_user'] == "")
        header("Location: ../index.php");
    get_id();
    $conn = connection();
    $sql = "SELECT * FROM `user_pictures` ORDER BY created_at DESC";
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
                        <?php
                        if ($_SESSION['logged_user_id'] == $key['id_owner'])
                        {
                         ?>
                         <form action="delete_pic.php" method="post">
                            <button class="delete" type="submit" name="delete_pic" value="Delete"> <img src="../img/delete.png" width="18" alt="del"></button>
                            <input type="hidden" name="picture_path" value=<?php echo $key['picture_path'];?>>
                        </form>
                        <?php
                        }
                        ?>
                        <div class="username"><?php echo "@" . $key['picture_owner'];?></div>
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
