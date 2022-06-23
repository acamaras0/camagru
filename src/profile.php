<?php
    session_start();
    require_once("connection.php");
    require_once("get_user_id.php");
    if ($_SESSION['logged_in_user'] == "")
        header("Location: ../index.php");
    get_id();
    $user = $_SESSION['logged_user_id'];
    $conn = connection();
    $sql = "SELECT * FROM `user_pictures` WHERE id_owner='$user' ORDER BY id DESC";
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
                        <form action="delete_pic.php" method="post">
                            <button class="delete" type="submit" name="delete_pic" value="Delete"> <img src="../img/delete.png" width="18" alt="del"></button>
                            <input type="hidden" name="picture_path" value=<?php echo $key['picture_path'];?>>
                        </form>
                        <div class="username"><?php echo "@" . $key['picture_owner'];?></div>
                        <?php echo " " . $key['created_at']?>
                        <img class="picture" src=<?php echo $key['picture_path'];?>>

                        <form class="comments" action="comments.php" method="post">
                            <textarea class="comment" name="comment" placeholder=". . ."></textarea>
                            <input type="hidden" name="picture_path" value=<?php echo $key['picture_path'];?>>
                            <input type="hidden" name="picture_name" value=<?php echo $key['picture_name'];?>>
                            <button  class="submit-comment" type="submit" name="submit" value="OK"><img src="../img/send.png" width="18" alt="del"></button>
                        </form>
                    </div>
                    <?php
                    $comments = "SELECT * FROM user_comments WHERE picture_name='$id'";
                    $qry_comments= $conn->query($comments);
                    $res_commnets = $qry_comments->fetchAll(PDO::FETCH_ASSOC);
                    foreach($res_commnets as $key_comments)
                    {
                    ?>
                    <!DOCTYPE html>
                    <html lang="en">
                    <body>
                        <div class="show-comments">
                            <p class="com"><div class="user_com"><?php echo $key_comments['picture_owner']?>
                            &nbsp<?php echo $key_comments['comments']?></div></p>
                        </div>
                    <?php
                    } ?>
                    </body>
                    </html>
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
