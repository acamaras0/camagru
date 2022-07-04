<?php
include("database.php");

//create database
try
{
    $conn = new PDO($DB_HOST, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE DATABASE IF NOT EXISTS camagru_db";
    $conn->exec($sql);
}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;

//create user_info table
try
{
    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS `user_info`(
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        fullname VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        u_name VARCHAR(50) NOT NULL,
        pwd VARCHAR(1000) NOT NULL,
        activation_code VARCHAR(255) NOT NULL,
        activ_status int(11) NOT NULL,
        notif_status int(11) NOT NULL,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
    $conn->exec($sql);

}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;

//create user_pictures table
try
{
    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS `user_pictures`(
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        picture_path TEXT NOT NULL,
        created_at timestamp not null default current_timestamp(),
        picture_name TEXT NOT NULL,
        picture_owner VARCHAR(50) NOT NULL,
        fullname VARCHAR(100) NOT NULL,
        id_owner  INT(11) NOT NULL,
        cam_shot INT(11) NOT NULL
        )";
        $conn->exec($sql);
}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;

//create user_likes table
try
{
    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS `user_likes`(
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        created_at timestamp not null default current_timestamp(),
        picture_name TEXT NOT NULL,
        like_owner VARCHAR(50) NOT NULL,
        id_owner  INT(11) NOT NULL
        )";
    $conn->exec($sql);

}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;

//create user_comments table
try
{
    $conn = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE IF NOT EXISTS `user_comments`(
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        comments VARCHAR(500) NOT NULL,
        created_at timestamp not null default current_timestamp(),
        picture_name TEXT NOT NULL,
        picture_owner VARCHAR(50) NOT NULL,
        id_owner  INT(11) NOT NULL
        )";
    $conn->exec($sql);

}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}
$conn = null;


?>