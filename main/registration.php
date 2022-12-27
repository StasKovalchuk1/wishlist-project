<?php
    session_start();
    require_once 'connect.php';
    require_once "validation.php";
    $username = $_POST['username'];
    $username = clean($username);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if ((strlen($username) < 5) or ($confirm <> $password) or (strlen($_POST['password']) < 8)){
        //  chybová zpráva
        if (strlen($username) < 5){
            $_SESSION['username-message'] = 'Minimum 5 letters';
            header("Location: ../signup.php?name=$username");
        }
        if ($confirm <> $password){
            $_SESSION['confirm-password'] = 'Incorrectly repeated the password';
            header("Location: ../signup.php?name=$username");
        }

        if (strlen($_POST['password']) < 8){
            $_SESSION['password'] = 'Minimum 8 letters';
            header("Location: ../signup.php?name=$username");
        }
    } else{
        $password = password_hash($password, PASSWORD_DEFAULT);
        $check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `name` = '$username'");
        // zkontroluje, zda je uživatel se zadaným uživatelským již jménem v databázi
        if (mysqli_num_rows($check_user) > 0){
            $_SESSION['message'] = 'Choose another name';
            header("Location: ../signup.php?name=$username");
        }
        else {
            mysqli_query($connect, "INSERT INTO `users` (`id`, `name`, `password`) VALUES (NULL, '$username', '$password')");

            $_SESSION['session'] = 'active';
            setcookie('username',$username, time()+60*60*24*365, '/');
            setcookie('userID', mysqli_insert_id($connect), time()+60*60*24*365, '/');
            header("Location: ../mywishlist.php");
        }
    }

