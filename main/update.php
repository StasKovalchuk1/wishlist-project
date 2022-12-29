<?php
/*
 * Pomocí dotazu sql zkontrolujeme jedinečnost položky, pokud je taková položka již v seznamu,
 * zobrazí se chybová zpráva, pokud ne, pak po ověření správnosti tokenu CSRF se data přidají do databáze.
 */
session_start();
require_once "connect.php";
$id = $_POST['id'];
$wish = $_POST['item'];
$count = $_POST['count'];
$date = $_POST['date'];
$token = $_POST['token'];

$result = mysqli_query($connect, "SELECT `wish` FROM `wishes` WHERE `user_id` = '" . $_COOKIE['userID'] . "'");
$result = mysqli_fetch_all($result);
// odolnost proti dvojímu odeslání stejné položky
foreach ($result as $row){
    if ($row[0] == $wish){
        $_SESSION['message'] = ucfirst($wish) . ' is already on your wishlist!';
        header("Location: ../update.php?id=$id");
        exit();
    }
}

if (($token != $_SESSION['token']) or !(isset($_SESSION['token']))){
    die("Failed to validate CSRF token");
}

if ($date == null){
    mysqli_query($connect, "UPDATE `wishes` SET `wish` = '$wish', `count` = '$count' WHERE `wishes`.`id` = '$id'");
}
else{
    mysqli_query($connect, "UPDATE `wishes` SET `wish` = '$wish', `count` = '$count', `date` = '$date' WHERE `wishes`.`id` = '$id'");
}

header("Location: ../mywishlist.php");
?>