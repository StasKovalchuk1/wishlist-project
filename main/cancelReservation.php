<?php
// Zrušení rezervace zboží

require_once "connect.php";
$id = $_GET['id'];
mysqli_query($connect, "UPDATE `wishes` SET `reservation` = NULL WHERE `wishes`.`id` = '$id'");
header("Location: ../searchPage.php");
?>