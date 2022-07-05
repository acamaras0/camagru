<?php
    session_start();
    require_once("connection.php");
    require_once("get_user_id.php");

    if ($_SESSION['logged_in_user'] == "")
        header("Location: ../index.php");

    get_id();
    $conn = connection();
    $username = $_SESSION['logged_user_id'];

    if (isset($_GET['page_no']) && $_GET['page_no'] != "")
    {
        $page = $_GET['page_no'];
    }
    else
    {
        $page = 1;
    }
    $total_pictures_per_page = 5;
    $pictures = ($page - 1) * $total_pictures_per_page;
    $next_page = $page + 1;
    $prev_page = $page - 1;
    $sql = "SELECT COUNT(*) FROM user_pictures"; 
    $qry = $conn->query($sql);
    $res = $qry->fetchAll(PDO::FETCH_ASSOC);
    $total_pictures = $res[0]['COUNT(*)'];
    $total_pages = ceil($total_pictures / $total_pictures_per_page);
?>
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
    try
    {
     $conn = connection();
     $sql0 = "SELECT * FROM `user_pictures` ORDER BY id DESC LIMIT $pictures, $total_pictures_per_page";
     $qry0 = $conn->query($sql0);
     $res0 = $qry0->fetchAll(PDO::FETCH_ASSOC);
     if ($res0)
     {
         foreach($res0 as $key0)
         {
             $id = $key0['picture_name'];
             $likes_sql = "SELECT COUNT(*) FROM user_likes WHERE picture_name='$id'";
             $likes_qry = $conn->query($likes_sql);
             $res_likes = $likes_qry->fetchAll(PDO::FETCH_ASSOC);
             ?>
                 <div class="middle-profile">
                     <div class="border-profile">
                            <?php
                            if ($_SESSION['logged_user_id'] == $key0['id_owner'])
                            {
                            ?>
                                <form action="delete_pic.php" method="post">
                                    <button class="delete" type="submit" name="delete_pic" value="Delete"> <img src="../img/delete.png" width="18" alt="del"></button>
                                    <input type="hidden" name="picture_path" value=<?php echo $key0['picture_path'];?>>

                                </form>
                            <?php
                            }
                            ?>
                            <div class="username"><?php echo "@" . $key0['picture_owner'];?></div>
                            <div class="fname"><?php echo $key0['fullname'];?></div>
                        </br>
                            <?php echo " " . $key0['created_at']?>
                            <img class="picture" src=<?php echo $key0['picture_path'];?>>
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
                                <input type="hidden" name="picture_owner" value=<?php echo $key0['picture_owner'];?>>
                                <input type="hidden" name="picture_name" value=<?php echo $key0['picture_name'];?>>
                                <button  class="submit-comment" type="submit" name="submit" value="OK"><img src="../img/send.png" width="18" alt="del"></button>
                            </form>
                            <?php
                            $comments = "SELECT * FROM user_comments WHERE picture_name='$id'";
                            $qry_comments= $conn->query($comments);
                            $res_comments = $qry_comments->fetchAll(PDO::FETCH_ASSOC);
                            foreach($res_comments as $key_comments)
                            {
                                $id_new = $key_comments['id_owner'];
                                $sql = "SELECT u_name FROM user_info WHERE id='$id_new'"; 
                                $qry = $conn->query($sql);
                                $u_name = $qry->fetchAll(PDO::FETCH_ASSOC);
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
        echo $qry0 . "<br>" . $e->getMessage();
    }
    $conn = null;
?>
    <div class="pagination">
        <a class="arrows" <?php if($page > 1){echo "href='?page_no=$prev_page'";} ?>> ⬅ </a>&nbsp&nbsp&nbsp&nbsp&nbsp
            <?php echo $page; ?>&nbsp&nbsp&nbsp&nbsp&nbsp
        <a class="arrows" <?php if($page < $total_pages){echo "href='?page_no=$next_page'";} ?>> ➡ </a>
    </div>
    <div class="footer">
        <?php	include('../partials/footer.php');	?>
    </div>
    </body>
</html> 
