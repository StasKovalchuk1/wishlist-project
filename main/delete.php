<?php
//Odstranění položky

session_start();
require_once "connect.php";
$id = $_GET['id'];
$token = $_POST['token'];

// ověření správnosti CSRF tokenu
if (($token != $_SESSION['token']) or !(isset($_SESSION['token']))){
    die("Failed to validate CSRF token");
}
else{
    mysqli_query($connect, "DELETE FROM `wishes` WHERE `wishes`.`id` = '$id'");

    header("Location: ../mywishlist.php");
}
?>