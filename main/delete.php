<?php
//Odstranění položky

session_start();
require_once "connect.php";
$id = $_GET['id'];
$token = $_POST['token'];
$page = $_GET['page'];

// ověření správnosti CSRF tokenu
if (($token <> $_SESSION['token']) or !(isset($_SESSION['token']))){
    die("Failed: CSRF attack");
}
else{
    mysqli_query($connect, "DELETE FROM `wishes` WHERE `wishes`.`id` = '$id'");

    header("Location: ../mywishlist.php?page=$page");
}
?>