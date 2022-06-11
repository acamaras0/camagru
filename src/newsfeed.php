<?php
    session_start();
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
        <a href="../newsfeed.php"><img src="../img/cam.png" alt="camera"></a>
    </div>
    <div class="header">
        <?php include('../partials/header.php'); ?>
    </div>
    
    <div class="middle">
        <form class= "form" action="" method="POST">
            
        </form>
    </div>
    
    <div class="footer">
        <?php	include('../partials/footer.php');	?>
    </div>
</body>
</html> 