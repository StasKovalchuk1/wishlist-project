<?php
session_start();
require_once "connect.php";
// kontrola rezervace dárku, možná pouze při přihlášení uživatele
if (isset($_SESSION['session'])){
    if ($_SESSION['session'] == 'inactive'){
        $_SESSION['book-message'] = 'Please, log in to your account to book a gift. Click ';
        header("Location: ../searchPage.php");
    }
    else{
        if ($_SESSION['session'] == 'active'){
            $id = $_GET['id'];
            mysqli_query($connect, "UPDATE `wishes` SET `reservation` = '".$_COOKIE['userID']."' WHERE `wishes`.`id` = '$id'");
            header("Location: ../searchPage.php");
        }
    }
}
else{
    $_SESSION['book-message'] = 'Please, log in to your account to book a gift. Click ';
    header("Location: ../searchPage.php");
}

