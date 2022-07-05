<?php
session_start();

if($_SESSION['logged_in_user'] == "")
    header("Location: landing.php");
    
$_SESSION['logged_in_user'] = "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
    <p id="message">See ya later!</p>
</body>
</html>

<?php
    header("Refresh: 1; ../index.php");
?>