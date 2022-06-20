<?php
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="../style.css">
	</head>
	<body>
		<h1><?php echo $_SESSION['logged_in_user'];?></h1>
		<div class="png-header">
			<div class="png-wrap">
				<div class="settings"><a href="../src/settings.php"><img class="png" src="../img/settings.png" alt="settings"></a></div>
				<div class="pic"> <a href="../src/upload.php"><img class="png" src="../img/upload.png" alt="settings"></a></div>
				<div class="logout"><a href="../src/logout.php"><img class="png" src="../img/logout.png" alt="logout"></a></div>
            </div>
		</div>
    </body>
</html>