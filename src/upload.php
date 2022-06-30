<?php
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
            if ($file_type == "jpeg" || $file_type == "jpg")
                $img = imagecreatefromjpeg($photo_file);
            if ($file_type == "png")
                $img = imagecreatefrompng($photo_file);

            $margin_r = 1;
            $margin_b = 1;

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
    <div class="camera">
            <a href="newsfeed.php"><img src="../img/cam.png" alt="camera"></a>
        </div>
        <div class="header">
            <?php include('../partials/header_profile.php'); ?>
    </div>    
    <div class="sticker-container">
        <div class="sticker-middle">
            <img id="s1" onclick="s_path1()" src="../stickers/unicorn1.png" alt="">
            <img id="s2" onclick="s_path2()" src="../stickers/unicorn2.png" alt="">
            <img id="s3" onclick="s_path3()" src="../stickers/unicorn3.png" alt="">
            <img id="s4" onclick="s_path4()" src="../stickers/unicorn4.png" alt="">
            <img id="s5" onclick="s_path5()" src="../stickers/unicorn5.png" alt="">
            <img id="s6" onclick="s_path6()" src="../stickers/unicorn6.png" alt="">
        </div>
    </div>
    <div class="middle">
        <div class="container">
            <video id="video" width="340" height="240" autoplay></video>
            <button id="start_camera"><img src="../img/cam.png" width="30"></button>
            <button id="take_photo"><p>Pick a sticker!</p><img src="../img/capture.png" width="30"></button>
            <canvas id="canvas" width="375" height="280" value="canvas"></canvas>
            <form class="form" action="store_web_pic.php" method="POST" enctype="multipart/form-data">
				<button id="web_add" type="submit" name="submit-web" value="">Submit</button>
				<input type="hidden" id="web_photo" name="new_pic" value="">
				<input type="hidden" id="stamp" name="stamp" value="">
			</form>
        </div>
        <br />
        <div class="upload-container">
            <form action="upload.php" method="post" enctype="multipart/form-data">
                Select image to upload:

                <div class="choose"><input type="file" name="fileToUpload" id="fileToUpload" required></div>
                <div class="upload"><input type="submit" value="Upload" name="submit"></div>
                <input type="hidden" id="stamp1" name="stamp" value="">
            </form>
        </div>
    </div>
        <script>

            let click_button = document.getElementById("take_photo"),
            start_camera = document.getElementById("start_camera"),
            canvas = document.getElementById("canvas"),
            new_pic = document.getElementById("web_photo");
            stamp_web = document.getElementById("stamp"),
            stamp_add = document.getElementById("stamp1"),
            camera = document.getElementById("video"),
            check = 0,
            u1 = document.getElementById("s1"),
            u2 = document.getElementById("s2"),
            u3 = document.getElementById("s3"),
            u4 = document.getElementById("s4"),
            u5 = document.getElementById("s5"),
            u6 = document.getElementById("s6");

            function s_path1(){
                stamp_web.value = u1.src;
                console.log(stamp_web);
                stamp_add.value = u1.src;
                check = 1;
            }

            function s_path2(){
                stamp_web.value = u2.src;
                stamp_add.value = u2.src;
                check = 1;
            }

            function s_path3(){
                stamp_web.value = u3.src;
                stamp_add.value = u3.src;
                check = 1;                
            }

            function s_path4(){
                stamp_web.value = u4.src;
                stamp_add.value = u4.src;
                check = 1;
            }

            function s_path5(){
                stamp_web.value = u5.src;
                stamp_add.value = u5.src;
                check = 1;
            }

            function s_path6(){
                stamp_web.value = u6.src;
                stamp_add.value = u6.src;
                check = 1;
            }

            start_camera.addEventListener('click', async function() {
		        let stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
		        video.srcObject = stream;
        	});

	        click_button.addEventListener('click', function() {
		        if (check == 1)
		        {
			        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
			        let image_data_url = canvas.toDataURL('image/jpeg');
			        new_pic.value = image_data_url;
		        }
	        });
                
        </script>

    <div class="footer">
        <?php	include('../partials/footer.php');	?>
    </div>
</body>
</html> 