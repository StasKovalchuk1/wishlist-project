<?php
/*
 * Pomocí dotazu sql zkontrolujeme jedinečnost položky, pokud je taková položka již v seznamu,
 * zobrazí se chybová zpráva, pokud ne, pak po ověření správnosti tokenu CSRF se data přidají do databáze.
 */
session_start();
require_once "validation.php";
require_once "connect.php";
$id = $_POST['id'];
$wish = clean($_POST['item']);
$count = $_POST['count'];
$date = $_POST['date'];
$page = $_GET['page'];
if (isset($_POST['token'])){
    $token = $_POST['token'];
} else {
    $_SESSION['message'] = 'Error: CSRF attack!';
    header("Location: ../update.php?id=$id&page=$page");
    exit();
}

// ověření délky pole s přáním a hodnotou množství
if (strlen($wish) > 100 or $count < 1 or empty($wish) or strlen($_POST['count']) > 9 or !(validateDate($date))){
    if (strlen($wish) > 100){
        $_SESSION['wish-message'] = 'Your wish is too long';
    }
    if (empty($wish)){
        $_SESSION['wish-message'] = 'This field is required';
    }
    if ($count < 1 or strlen($_POST['count']) > 9){
        $_SESSION['count-message'] = 'The allowed number is from 1 to 99999999';
    }
    if (!(validateDate($date))){
        $_SESSION['date-message'] = 'Enter correct date (yyyy-mm-dd)';
    }
    header("Location: ../update.php?id=$id&wish=$wish&count=$count&date=$date&page=$page");
    exit();
}

$list = mysqli_query($connect, "SELECT `wish` FROM `wishes` WHERE `id` = '$id'");
$list = mysqli_fetch_all($list);
foreach ($list as $row){
    $defaultWish = $row[0]; // přání, které chceme aktualizovat
}

// odolnost proti dvojímu odeslání stejné položky
$result = mysqli_query($connect, "SELECT `wish` FROM `wishes` WHERE `user_id` = '" . $_COOKIE['userID'] . "'");
$result = mysqli_fetch_all($result);
foreach ($result as $row){
    if ($row[0] == $wish and $wish <> $defaultWish){
        $_SESSION['message'] = ucfirst($wish) . ' is already on your wishlist!';
        header("Location: ../update.php?ID=$id&wish=$wish&count=$count&date=$date&page=$page");
        exit();
    }
}

if (($token <> $_SESSION['token']) or !(isset($_POST['token']))){
    $_SESSION['message'] = 'Error: CSRF attack!';
    header("Location: ../update.php?id=$id&page=$page");
    exit();
}

if ($date == null){
    mysqli_query($connect, "UPDATE `wishes` SET `wish` = '$wish', `count` = '$count' WHERE `wishes`.`id` = '$id'");
    $result = mysqli_query($connect, "SELECT `date` FROM `wishes` WHERE `wishes`.`id` = '$id'");
    if ($result){
        mysqli_query($connect, "UPDATE `wishes` SET `date` = NULL WHERE `wishes`.`id` = '$id'");
    }
}
else{
    mysqli_query($connect, "UPDATE `wishes` SET `wish` = '$wish', `count` = '$count', `date` = '$date' WHERE `wishes`.`id` = '$id'");
}

header("Location: ../mywishlist.php?&page=$page");
?>