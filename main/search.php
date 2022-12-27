<?php

session_start();
require_once 'connect.php';
require_once "validation.php";
$searchName = $_POST['search-login'];
$searchName = clean($searchName); // je pole se jménem vymazáno ze značek html a php,
                                  // speciální znaky jsou převedeny na entity HTML

$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `name` = '$searchName'");
if ($check_user == false){
    $_SESSION['message'] = 'User was not found';
    header("Location: ../searchlist.php?name=$searchName");
}
else{
    if (mysqli_num_rows($check_user) > 0) {
        if (isset($_COOKIE['search-name'])){
            unset($_COOKIE['search-name']);
        }
        setcookie('search-name', $searchName, time()+60*60*24*365, '/');
        header("Location: ../searchPage.php");
    } else {
        $_SESSION['message'] = 'User was not found';
        header("Location: ../searchlist.php?name=$searchName");
    }
}


