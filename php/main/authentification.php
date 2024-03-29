<?php
/*
  Pomocí funkce clean() ze souboru je pole s uživatelským jménem
  vymazáno ze značek html a php, speciální znaky jsou převedeny na entity HTML.
  Nejprve se zkontroluje, zda je uživatel se zadaným uživatelským jménem v databázi,
  poté zkontrolujte heslo pomocí funkce password_verify(), která zkontroluje, zda heslo odpovídá hash v databázi.
  Pokud jsou všechny kontroly úspěšné, uživatel bude přesměrován na stránku se seznamem přání,
  jeho uživatelské jméno a id jsou uloženy v Cookies a $_SESSION[„session“] nastavuje hodnotu „active“.
  Jinak se zobrazí chybová zpráva.
 */
session_start();
    require_once "connect.php";
    require_once "validation.php";
    $username = $_POST['username'];
    $username = clean($username);
    $username = mysqli_real_escape_string($connect, $username);
    $password = $_POST['password'];


if (strlen($username) < 5 or strlen($password) < 8 or strlen($username) > 20 or strlen($password) > 20){
    //  chybová zpráva
    if (strlen($username) < 5 or strlen($username) > 20){
        $_SESSION['username-message'] = 'Length is from 5 to 20 characters';
        header("Location: ../login.php?name=$username");
    }

    if (strlen($_POST['password']) < 8 or strlen($_POST['password']) > 20){
        $_SESSION['password'] = 'Length is from 8 to 20 characters';
        header("Location: ../login.php?name=$username");
    }
} else{
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
}
