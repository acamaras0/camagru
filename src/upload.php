<?php
session_start();
require_once("connection.php");
require_once("get_user_id.php");

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
        <div class="thumbnails">
            <div class="slide">
                <?php
                    require_once("connection.php");
                    require_once("get_user_id.php");
                    get_id();
                    $user_id = $_SESSION['logged_user_id'];
                    $conn = connection();
                    $sql = "SELECT picture_path, cam_shot FROM user_pictures WHERE id_owner='$user_id'";
                    $stmt = $conn->query($sql);
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if($result)
                    {
                        foreach($result as $k)
                        {
                            if ($k['cam_shot'] == 1)
                            {
                                $img_id = $k['picture_name'];
                                ?>
                                    <!DOCTYPE html>
                                        <html>
                                            <body>
                                                <img class="img_size" src=<?php echo $k['picture_path'];?>>&nbsp
                                            </body>
                                    </html>
                            <?php        
                            }
                        }
                    }    
                ?>
            </div>
        </div>  
        </br> 
        <div class="container">
            <button id="start_camera">Open camera!</button>
            <div class="view-finder">
                <div class="sticker-preview" id="sticker_preview"></div>
                <div class="sticker-preview1" id="sticker_preview1"></div>
                <video id="video" width="340" height="240" autoplay></video>
            </div>
            <p>Pick a sticker:</p>
                <div class="sticker-container">
                    <div class="sticker-middle">
                        <img id="s1" src="../stickers/unicorn1.png" alt="">
                        <img id="s2" src="../stickers/unicorn2.png" alt="">
                        <img id="s3" src="../stickers/unicorn3.png" alt="">
                        <img id="s4" src="../stickers/unicorn4.png" alt="">
                        <img id="s5" src="../stickers/unicorn5.png" alt="">
                    </div>
                </div>
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
                <input type="hidden" id="stamp0" name="stamp0" value="">
			</form>
        </div>
        <br />
        <div class="upload-container">
            <form action="store_uploaded_pic.php" method="post" enctype="multipart/form-data">
                Or select an image to upload:
                <div class="choose"><input type="file" name="fileToUpload" id="fileToUpload" required></div>
                <div class="upload"><input type="submit" value="Upload" name="submit"></div>
                <input type="hidden" id="stamp1" name="stamp" value="">
                <input type="hidden" id="stamp2" name="stamp0" value="">
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
            sticker_web1 = document.getElementById("stamp0"),
            sticker_device = document.getElementById("stamp1"),
            sticker_device1 = document.getElementById("stamp2"),
            check = 0,
            click = 0;
            u1 = document.getElementById("s1"),
            u2 = document.getElementById("s2"),
            u3 = document.getElementById("s3"),
            u4 = document.getElementById("s4"),
            u5 = document.getElementById("s5");

            const paths = new Array(
                "../stickers/unicorn1.png",
                "../stickers/unicorn2.png",
                "../stickers/unicorn3.png",
                "../stickers/unicorn4.png",
                "../stickers/unicorn5.png",
            )

            u1.addEventListener("click", () => sticker(0));
            u2.addEventListener("click", () => sticker(1));
            u3.addEventListener("click", () => sticker(2));
            u4.addEventListener("click", () => sticker(3));
            u5.addEventListener("click", () => sticker(4));

            function sticker(i){
                click++;
                check = 1;

                if (click===1)
                {
                    canvas_preview.style.backgroundImage = "url(" + paths[i]  +")";
                    sticker_preview.style.backgroundImage = "url(" + paths[i]  +")";
                    sticker_web.value = paths[i];
                    sticker_device.value = paths[i];
                    click++;
                }
                else if (click === 2)
                {
                    canvas_preview1.style.backgroundImage = "url(" + paths[i]  +")";
                    sticker_preview1.style.backgroundImage = "url(" + paths[i]  +")";
                    sticker_web1.value = paths[i];
                    sticker_device1.value = paths[i];
                    click++;
                }
                if (click === 3)
                    click = 1;
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