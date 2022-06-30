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
    $img = $_POST['new_pic'];
    $folderPath = "../uploads/";
    $shot = 1;
    $sticker_path = $_POST['stamp'];
    $image_parts = explode(";base64,", $img);
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    
    $image_base64 = base64_decode($image_parts[1]);
    $fileName = uniqid() . '.jpeg';
    
    $file = $folderPath . $fileName;
    file_put_contents($file, $image_base64);
    try
    {
        $conn = connection();
        $sql = $conn->prepare("INSERT INTO user_pictures(picture_path, picture_name, picture_owner, id_owner, cam_shot)
                                        VALUES (:picture_path, :picture_name, :picture_owner, :id_owner, :cam_shot)");
        $sql->bindParam(':picture_path', $file, PDO::PARAM_STR);
        $sql->bindParam(':picture_name', $fileName, PDO::PARAM_STR);
        $sql->bindParam(':picture_owner', $pic_owner, PDO::PARAM_STR);
        $sql->bindParam(':id_owner', $user, PDO::PARAM_STR);
        $sql->bindParam(':cam_shot', $shot, PDO::PARAM_STR);
        $sql->execute();
        $conn = null;

        $sticker = imagecreatefrompng($sticker_path);
        $picture = imagecreatefromjpeg($file);

        $margin_r = 10;
		$margin_b = 10;
	
		$sx = imagesx($sticker);
		$sy = imagesy($sticker);

        imagecopy($img, $sticker, imagesx($img) - $sx - $margin_r, imagesy($img) - $sy - $margin_b, 0, 0, imagesx($sticker), imagesy($sticker));
		header('Content-type: image/png');
		imagejpeg($img, $file, 95);
		imagedestroy($img);
        print_msg("The file ". $file_name . "has been uploaded.");

    }
    catch(PDOException $e)
    {
        $sql . "<br>" . $e->getMessage();
    }
}
else
{
    print_msg("Something went wrong.");
}
?>