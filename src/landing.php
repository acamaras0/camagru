<?php
session_start();
require_once("../config/setup.php");
require_once("connection.php");

if ($_SESSION['logged_in_user'] != "")
    header("Location: profile.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
    <div class="camera">
        <a href="../index.php"><img src="../img/cam.png" alt="camera"></a>
    </div>
    <div class="header">
        <h1>Camagru</h1>
    </div>
    <div class="center-container">
        <div class="index-middle">
            <div class="index-container">
                <div class="login">
                    <a href="login.php"><button>Log in</button></a>
                </div>
                <p>Or would you like to create an account?</p>
                <div class="signin">
                    <a href="create.php"><button>Sign up</button></a> 
                </div>
            </div>
            
        </div>
        <div class="images-container">
                <?php
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
                try
                {
                    $conn = connection();
                    $sql0 = "SELECT picture_path, picture_name, id_owner, created_at FROM `user_pictures` ORDER BY id DESC LIMIT $pictures, $total_pictures_per_page";
                    $qry0 = $conn->query($sql0);
                    $res0 = $qry0->fetchAll(PDO::FETCH_ASSOC);
                    if($res0)
                    {
                        foreach($res0 as $key)
                        {
                            $picture_id = $key['picture_name'];
                            ?>
                                <!DOCTYPE html>
                                <html>
                                <body>
                                    <div class="gallery">
                                        <img class="picture-gallery" src=<?php echo $key['picture_path'];?>>
                                    </div>
                                </body>
                                </html>
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
        </div>
    </div>
        <div class="footer">
            <?php   include('../partials/footer.php');	?>
        </div>
    </body>
</html>
