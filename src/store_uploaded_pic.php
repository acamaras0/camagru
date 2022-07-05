<?php
    session_start();
    require_once("print_msg.php");
    require_once("connection.php");
    require_once("get_user_id.php");

    if (empty($_SESSION['logged_in_user']))
        header('location:../index.php');

    $target_dir = "../uploads/";
    $file_name1 = basename($_FILES["fileToUpload"]["name"]);
    $file_name = str_replace(" ", "", $file_name1);
    $target_file1 = $target_dir . $file_name;
    $target_file = str_replace(" ", "", $target_file1);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $pic_owner = $_SESSION['logged_in_user'];
    get_id();
    $user = $_SESSION['logged_user_id'];
    $shot = 0;

    $conn = connection();
    $sql = "SELECT fullname FROM user_info WHERE id='$user'";
    $qry = $conn->query($sql);
    $res = $qry->fetchAll(PDO::FETCH_ASSOC);
    $fullname = $res[0]['fullname'];
    $conn = null;

    if(isset($_POST["submit"])) 
    {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check === false) 
        {
            print_msg("File is not an image.");
            header('Refresh: 2; upload.php');
            return;
        }
        // Check file size
        else if ($_FILES["fileToUpload"]["size"] > 1000000) 
        {
            print_msg("Sorry, your file is too large.");
            header('Refresh: 2; upload.php');
            return;
        }
        // Allow certain file formats
        else if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
        {
            print_msg("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            header('Refresh: 3; upload.php');
            return;
        }
        // if everything is ok, try to upload file
        else 
        {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
            {
                $conn = connection();
                $sql = $conn->prepare("INSERT INTO user_pictures(picture_path, picture_name, picture_owner, fullname, id_owner, cam_shot)
                                        VALUES (:picture_path, :picture_name, :picture_owner, :fullname, :id_owner, :cam_shot)");
                $sql->bindParam(':picture_path', $target_file, PDO::PARAM_STR);
                $sql->bindParam(':picture_name', $file_name, PDO::PARAM_STR);
                $sql->bindParam(':picture_owner', $pic_owner, PDO::PARAM_STR);
                $sql->bindParam(':fullname', $fullname, PDO::PARAM_STR);
                $sql->bindParam(':id_owner', $user, PDO::PARAM_STR);
                $sql->bindParam(':cam_shot', $shot, PDO::PARAM_STR);
                $sql->execute();
                $conn = null;
                if($imageFileType == "jpg" || $imageFileType == "jpeg")
                    $img = imagecreatefromjpeg($target_file);
                else if ($imageFileType == "png")
                    $img = imagecreatefrompng($target_file);
                else if ($imageFileType == "gif")
                    $img = imagecreatefromgif($target_file);
                imagedestroy($img);
                header("Location: upload.php");
            }
            else 
            {
                print_msg("Sorry, there was an error.");
                header("Location: upload.php");
            }
        }
        if (isset($_POST['stamp']))
        {
            $sticker_path = $_POST['stamp'];
            $sticker = imagecreatefrompng($sticker_path);
            if ($imageFileType == "jpeg" || $imageFileType== "jpg")
                $img = imagecreatefromjpeg($target_file);
            else if ($imageFileType == "png")
                $img = imagecreatefrompng($target_file);
            else if ($imageFileType == "gif")
                $img = imagecreatefromgif($target_file);
            $margin_r = 1;
            $margin_b = 1;

            $sx = imagesx($sticker);
            $sy = imagesy($sticker);

            imagecopy($img, $sticker, imagesx($img) - $sx - $margin_r, imagesy($img) - $sy - $margin_b, 0, 0, imagesx($sticker), imagesy($sticker));
            if ($_POST['stamp0'] != "")
            {
                $sticker_path0 = $_POST['stamp0'];
                $sticker0 = imagecreatefrompng($sticker_path0);
                $sx0 = imagesx($sticker0);
                $sy0 = imagesy($sticker0);
                $margin_l=270;
                $margin_t=125;
                imagecopy($img, $sticker0, imagesx($img) - $sx0 - $margin_l, imagesy($img) - $sy0 - $margin_t, 0, 0, imagesx($sticker0), imagesy($sticker0));
            }
            $scale= imagescale($img, 375, -1, IMG_BILINEAR_FIXED);
            if ($imageFileType == "gif")
                imagegif($scale, $target_file);
            else if ($imageFileType == "png")
                imagepng($scale, $target_file);
            else
                imagejpeg($scale, $target_file, 100);
            imagedestroy($scale);
            imagedestroy($img);
        }
    }
?>