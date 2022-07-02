<?php
session_start();
require_once("connection.php");

if (!isset($_SESSION['logged_user_id']))
header('location:../index.php');
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
    </br>    
    <div class="middle">
        <div class="container">
        <p>Pick a sticker:</p>
            <div class="sticker-container">
                <div class="sticker-middle">
                    <img id="s1" onclick="s_path1()" src="../stickers/unicorn1.png" alt="">
                    <img id="s2" onclick="s_path2()" src="../stickers/unicorn2.png" alt="">
                    <img id="s3" onclick="s_path3()" src="../stickers/unicorn3.png" alt="">
                    <img id="s4" onclick="s_path4()" src="../stickers/unicorn4.png" alt="">
                    <img id="s5" onclick="s_path5()" src="../stickers/unicorn5.png" alt="">
                </div>
            </div>
            <button id="start_camera">Open camera!</button>
                <video id="video" width="340" height="240" autoplay></video>
            <button id="take_photo"><img src="../img/capture.png" width="30"></button>
            <div class="view-finder">
                <div class="canvas-preview" id="canvas_preview"></div>
                <div class="canvas-preview1" id="canvas_preview1"></div>
                <canvas id="canvas" width="375" height="280" value="canvas"></canvas>
            </div>
            
            <form class="form" action="store_web_pic.php" method="POST" enctype="multipart/form-data">
                <button id="web_add" type="submit" name="submit-web" value="">Submit</button>
				<input type="hidden" id="web_photo" name="new_pic" value="">
				<input type="hidden" id="stamp" name="stamp" value="">
			</form>
        </div>
        <br />
        <div class="upload-container">
            <form action="store_uploaded_pic.php" method="post" enctype="multipart/form-data">
                Or select an image to upload:
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
            camera = document.getElementById("video"),
            sticker_web = document.getElementById("stamp"),
            sticker_device = document.getElementById("stamp1"),
            check = 0,
            u1 = document.getElementById("s1"),
            u2 = document.getElementById("s2"),
            u3 = document.getElementById("s3"),
            u4 = document.getElementById("s4"),
            u5 = document.getElementById("s5");

            function s_path1(){
                canvas_preview.style.backgroundImage = "url(" + u1.src  +")";
                sticker_web.value = u1.src;
                sticker_device.value = u1.src;
                //sticker_preview1.style.backgroundImage = "url(" + u1.src  +")";
                check = 1;
            }

            function s_path2(){
                canvas_preview.style.backgroundImage = "url(" + u2.src  +")";
                sticker_web.value = u2.src;
                sticker_device.value = u2.src;
                //sticker_preview1.style.backgroundImage = "url(" + u2.src  +")";
                check = 1;
            }

            function s_path3(){
                canvas_preview.style.backgroundImage = "url(" + u3.src  +")";
                sticker_web.value = u3.src;
                sticker_device.value = u3.src;
                //sticker_preview1.style.backgroundImage = "url(" + u3.src  +")";
                check = 1;                
            }

            function s_path4(){
                canvas_preview.style.backgroundImage = "url(" + u4.src  +")";
                sticker_web.value = u4.src;
                sticker_device.value = u4.src;
                //sticker_preview1.style.backgroundImage = "url(" + u4.src  +")";
                check = 1;
            }

            function s_path5(){
                canvas_preview.style.backgroundImage = "url(" + u5.src  +")";
                sticker_web.value = u5.src;
                sticker_device.value = u5.src;
                //sticker_preview1.style.backgroundImage = "url(" + u5.src  +")";
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