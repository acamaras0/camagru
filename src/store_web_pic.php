<?php
session_start();
require_once('connection.php');
require_once('get_user_id.php');
require_once('print_msg.php');

if (isset($_SESSION['logged_in_user']) == "")
    header("Location: landing.php");

if (!empty($_POST['new_pic']) && !empty($_POST['stamp']))
{
    header("Location: upload.php");
    get_id();
    $user = $_SESSION['logged_user_id'];
    $pic_owner = $_SESSION['logged_in_user'];
    $picture = $_POST['new_pic'];
    $folderPath = "../uploads/";
    $shot = 1;
    $sticker_path = $_POST['stamp'];
    $sticker_path0 = $_POST['stamp0'];
    $image_parts = explode(";base64,", $picture);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    
    $image_base64 = base64_decode($image_parts[1]);
    $fileName = uniqid() . '.jpeg';
    
    $file = $folderPath . $fileName;
    file_put_contents($file, $image_base64);

    $conn = connection();
    $sql1 = "SELECT fullname FROM user_info WHERE id='$user'";
    $qry = $conn->query($sql1);
    $res = $qry->fetchAll(PDO::FETCH_ASSOC);
    $fullname = $res[0]['fullname'];
    try
    {
        $conn = connection();
            $sql = $conn->prepare("INSERT INTO user_pictures(picture_path, picture_name, picture_owner, fullname, id_owner, cam_shot)
                                VALUES (:picture_path, :picture_name, :picture_owner, :fullname, :id_owner, :cam_shot)");
            $sql->bindParam(':picture_path', $file, PDO::PARAM_STR);
            $sql->bindParam(':picture_name', $fileName, PDO::PARAM_STR);
            $sql->bindParam(':picture_owner', $pic_owner, PDO::PARAM_STR);
            $sql->bindParam(':fullname', $fullname, PDO::PARAM_STR);
            $sql->bindParam(':id_owner', $user, PDO::PARAM_STR);
            $sql->bindParam(':cam_shot', $shot, PDO::PARAM_STR);
            $sql->execute();
            $conn = null;

        $sticker = imagecreatefrompng($sticker_path);
        $picture = imagecreatefromjpeg($file);

        $margin_r = 1;
		$margin_b = 1;
	
		$sx = imagesx($sticker);
		$sy = imagesy($sticker);

        imagecopy($picture, $sticker, imagesx($picture) - $sx - $margin_r, imagesy($picture) - $sy - $margin_b, 0, 0, imagesx($sticker), imagesy($sticker));
        if ($_POST['stamp0'] != "")
        {
            $sticker0 = imagecreatefrompng($sticker_path0);
            $sx0 = imagesx($sticker0);
		    $sy0 = imagesy($sticker0);
            $margin_l=260;
            $margin_t=160;
            imagecopy($picture, $sticker0, imagesx($picture) - $sx0 - $margin_l, imagesy($picture) - $sy0 - $margin_t, 0, 0, imagesx($sticker0), imagesy($sticker0));
        }
        header('Content-type: image/png');
		imagejpeg($picture, $file, 100);
		imagedestroy($picture);
        print_msg("The file ". $file_name . "has been uploaded.");
    }
    catch(PDOException $e)
    {
        $sql . "<br>" . $e->getMessage();
    }
}
else
{
    print_msg("You forgot to pick a sticker!");
    header("Refresh: 3; upload.php");
}
?>