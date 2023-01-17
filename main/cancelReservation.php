<?php
// Zrušení rezervace zboží

require_once "connect.php";
$id = $_GET['id'];
$id = mysqli_real_escape_string($connect, $id);
$page = $_GET['page'];
mysqli_query($connect, "UPDATE `wishes` SET `reservation` = NULL WHERE `wishes`.`id` = '$id'");
header("Location: ../searchPage.php?page=$page");
?>