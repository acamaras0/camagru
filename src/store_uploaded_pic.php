<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

    session_start();
    require_once("print_msg.php");
    require_once("connection.php");
    require_once("get_user_id.php");

    if (!isset($_SESSION['logged_user_id']))
        header('location:../index.php');

    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $file_name = basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $shot = 0;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $pic_owner = $_SESSION['logged_in_user'];
    get_id();
    $user = $_SESSION['logged_user_id'];

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) 
    {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) 
        {
            $uploadOk = 1;
        }
        else 
        {
            print_msg ("File is not an image.");
            $uploadOk = 0;
        }
        // Check if file already exists
        if (file_exists($target_file)) 
        {
            print_msg("Sorry, file already exists.");
            $uploadOk = 0;
        }
        
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 100000000) 
        {
            print_msg ("Sorry, your file is too large.");
            $uploadOk = 0;
        }
        
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
        {
            print_msg ("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            $uploadOk = 0;
        }
        
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0)
        {
            print_msg ("Your file was not uploaded.");
        // if everything is ok, try to upload file
        } 
        else 
        {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
            {
                $conn = connection();
                $sql = $conn->prepare("INSERT INTO user_pictures(picture_path, picture_name, picture_owner, id_owner, cam_shot)
                                        VALUES (:picture_path, :picture_name, :picture_owner, :id_owner, :cam_shot)");
                $sql->bindParam(':picture_path', $target_file, PDO::PARAM_STR);
                $sql->bindParam(':picture_name', $file_name, PDO::PARAM_STR);
                $sql->bindParam(':picture_owner', $pic_owner, PDO::PARAM_STR);
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
                $scale = imagescale($img, 375, -1, IMG_BILINEAR_FIXED);
                imagedestroy($img);
                imagedestroy($scale);
                header("Location: upload.php");
                print_msg("The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.");
            }
            else 
            {
                print_msg("Sorry, there was an error uploading your file.");
            }
        }
        if (isset($_POST['stamp']))
        {
            $sticker_path = $_POST['stamp'];
            $sticker = imagecreatefrompng($sticker_path);
            if ($imageFileType == "jpeg" || $imageFileType== "jpg")
                $img = imagecreatefromjpeg($target_file);
            if ($imageFileType == "png")
                $img = imagecreatefrompng($target_file);
            $margin_r = 10;
            $margin_b = 10;

            $sx = imagesx($sticker);
            $sy = imagesy($sticker);

            imagecopy($img, $sticker, imagesx($img) - $sx - $margin_r, imagesy($img) - $sy - $margin_b, 0, 0, imagesx($sticker), imagesy($sticker));
            $scale= imagescale($img, 375, -1, IMG_BILINEAR_FIXED);
            imagejpeg($scale, $file_name, 100);
            imagedestroy($img);
            imagedestroy($scale);
        }
    }
?>