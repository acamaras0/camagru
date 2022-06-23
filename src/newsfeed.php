<?php
    session_start();
    require_once("connection.php");
    require_once("get_user_id.php");

    if ($_SESSION['logged_in_user'] == "")
        header("Location: ../index.php");
    get_id();
    $conn = connection();
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
        if($res0)
        {
            foreach($res0 as $key)
            {
                $picture_id = $key['picture_name'];
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
    }
    catch(PDOException $e)
    {
        echo $qry0 . "<br>" . $e->getMessage();
    }
    $conn = null;
?>
    <div class="pagination">
            <a class="arrows" <?php if($page > 1){echo "href='?page_no=$prev_page'";} ?>> ⫷⫷⫷ </a>&nbsp&nbsp&nbsp&nbsp&nbsp
            <?php echo $page; ?>&nbsp&nbsp&nbsp&nbsp&nbsp
            <a class="arrows" <?php if($page < $total_pages){echo "href='?page_no=$next_page'";} ?>> ⫸⫸⫸ </a>
    </div>
        <div class="footer">
            <?php	include('../partials/footer.php');	?>
        </div>
    </body>
    </html> 
