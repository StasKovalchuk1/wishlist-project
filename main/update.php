<?php
require_once "connect.php";
$id = $_POST['id'];
$wish = $_POST['item'];
$count = $_POST['count'];
$date = $_POST['date'];

if ($date == null){
    mysqli_query($connect, "UPDATE `wishes` SET `wish` = '$wish', `count` = '$count' WHERE `wishes`.`id` = '$id'");
}
else{
    mysqli_query($connect, "UPDATE `wishes` SET `wish` = '$wish', `count` = '$count', `date` = '$date' WHERE `wishes`.`id` = '$id'");
}

header("Location: ../mywishlist.php");
?>