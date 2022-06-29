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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>
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
            <img id="1" onclick="s_Path1()" src="../stickers/unicorn1.png" alt="">
            <img id="2" onclick="s_Path2()" src="../stickers/unicorn2.png" alt="">
            <img id="3" onclick="s_Path3()" src="../stickers/unicorn3.png" alt="">
            <img id="4" onclick="s_Path4()" src="../stickers/unicorn4.png" alt="">
            <img id="5" onclick="s_Path5()" src="../stickers/unicorn5.png" alt="">
            <img id="6" onclick="s_Path6()" src="../stickers/unicorn6.png" alt="">
        </div>
    </div>
    <div class="middle">
        <div class="container">
            <form method="POST" action="store_web_pic.php">
                <div class="row">
                    <div class="col-md-6">
                        <div id="my_camera"></div>
                        <br/>
                        <input type=button value="Take Snapshot" onClick="take_snapshot()">
                        <input type="hidden" name="image" class="image-tag">
                    </div>
                    <div class="col-md-6">
                        <div id="results">Your captured image will appear here...</div>
                    </div>
                    <div class="col-md-12 text-center">
                        <br/>
                        <button class="btn btn-success" name="submit-web" value ="submit-web">Submit</button>
                    </div>
                </div>
            </form>
        </div>
        <script language="JavaScript">
            Webcam.set({
                width: 490,
                height: 390,
                image_format: 'jpeg',
                jpeg_quality: 100
            });
        
            Webcam.attach( '#my_camera' );
        
            function take_snapshot() {
                Webcam.snap( function(data_uri) {
                    $(".image-tag").val(data_uri);
                    document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
                } );
            }

            function s_path1(){

            }

            function s_path2(){
                
            }

            function s_path3(){
                
            }

            function s_path4(){
                
            }

            function s_path5(){
                
            }

            function s_path6(){
                
            }
        </script>
        <br />
        <div class="upload-container">
            <form action="upload.php" method="post" enctype="multipart/form-data">
                Select image to upload:

                <div class="choose"><input type="file" name="fileToUpload" id="fileToUpload" required></div>
                <div class="upload"><input type="submit" value="Upload" name="submit"></div>
            </form>
        </div>
    </div>

    <div class="footer">
        <?php	include('../partials/footer.php');	?>
    </div>
</body>
</html> 