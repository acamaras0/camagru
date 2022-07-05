<?php
    session_start();
    require_once("connection.php");
    require_once("get_user_id.php");
    
    if ($_SESSION['logged_in_user'] == "")
        header("Location: ../index.php");
    get_id();
    $user = $_SESSION['logged_user_id'];
    try
    {
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
                $likes_sql = "SELECT COUNT(*) FROM user_likes WHERE picture_name='$id'";
                $likes_qry = $conn->query($likes_sql);
                $res_likes = $likes_qry->fetchAll(PDO::FETCH_ASSOC);
                ?>
                    <div class="middle-profile">
                        <div class="border-profile">
                            <form action="delete_pic.php" method="post">
                                <button class="delete" type="submit" name="delete_pic" value="Delete"> <img src="../img/delete.png" width="18" alt="del"></button>
                                <input type="hidden" name="picture_path" value=<?php echo $key['picture_path'];?>>
                            </form>
                            <div class="username"><?php echo "@" . $key['picture_owner'];?></div>
                            <div class="fname"><?php echo $key['fullname'];?></div>
                            </br>
                            <p><?php echo " " . $key['created_at']?></p>
                            <img class="picture" src=<?php echo $key['picture_path'];?>>
                            <div class="like-container">
                                <form class="likes" action="likes_count.php" method="post">
                                    <button  class="like" type="like" name="heart" value="OK"><img src="../img/heart.png" width="25" alt="del"></button>
                                    <input type="hidden" name="picture_owner" value=<?php echo $key0['picture_owner'];?>>
                                    <input type="hidden" name="picture_name" value=<?php echo $key0['picture_name'];?>>
                                </form>
                                <p class="like_count"><?php echo $res_likes[0]['COUNT(*)'];?></p>
                            </div>
                            <form class="comments" action="comments.php" method="post">
                                <textarea class="comments" name="comments" placeholder=". . ."></textarea>
                                <input type="hidden" name="picture_owner" value=<?php echo $key['picture_owner'];?>>
                                <input type="hidden" name="picture_name" value=<?php echo $key['picture_name'];?>>
                                <button  class="submit-comment" type="submit" name="submit" value="OK"><img src="../img/send.png" width="18" alt="del"></button>
                            </form>
                        <?php
                            $comments = "SELECT * FROM user_comments WHERE picture_name='$id'";
                            $qry_comments= $conn->query($comments);
                            $res_comments = $qry_comments->fetchAll(PDO::FETCH_ASSOC);
                            $id_username = $res_comments[0]['id_owner'];
                            $sql = "SELECT u_name FROM user_info WHERE id='$id_username'"; 
                            $qry = $conn->query($sql);
                            $u_name = $qry->fetchAll(PDO::FETCH_ASSOC);
                            foreach($res_comments as $key_comments)
                            {
                                ?>
                                    <!DOCTYPE html>
                                    <html lang="en">
                                    <body>
                                    <div class="show-comments">
                                        <p class="com"><div class="user_com"><?php echo "@". $u_name[0]['u_name']?>
                                        &nbsp<?php echo $key_comments['comments']?></div></p>
                                    </div>
                                </body>
                                </html>
                                <?php
                            } 
                        ?>
                        </div>
                    </div>
            <?php
            }
        }
    }
    catch(PDOException $e)
    {
        echo $qry . "<br>" . $e->getMessage();
    }
    $conn = null;
    ?>
        <div class="footer">
            <?php	include('../partials/footer.php');	?>
        </div>
    </body>
</html> 
