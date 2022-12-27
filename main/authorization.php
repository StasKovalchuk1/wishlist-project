<?php
session_start();
require_once "connect.php";
require_once "validation.php";
$username = $_POST['username'];
$username = clean($username);
$password = $_POST['password'];

$check_user = mysqli_query($connect, "SELECT `id`, `name`,`password` FROM `users` WHERE `name` = '$username'");
// zkontroluje, zda je uživatel se zadaným uživatelským jménem v databázi
if (mysqli_num_rows($check_user) > 0){
    $check_user = mysqli_fetch_all($check_user);
    foreach ($check_user as $user){
        // zkontroluje, zda heslo odpovídá hash v databázi
        if (password_verify($password, $user[2])){
            setcookie('userID', $user[0], time()+60*60*24*365, '/');
            $_SESSION['session'] = 'active';
            setcookie('username',$username, time()+60*60*24*365, '/');
            header("Location: ../mywishlist.php");
        }
        else{
            $_SESSION['message'] = 'Wrong login or password';
            header("Location: ../login.php?name=$username");
        }
    }
}
else{
    $_SESSION['message'] = 'Wrong login or password';
    header("Location: ../login.php?name=$username");
}
