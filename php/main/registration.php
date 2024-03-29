<?php
    session_start();
    /* Pomocí funkce clean() ze souboru je pole s uživatelským jménem
       vymazáno ze značek html a php, speciální znaky jsou převedeny na entity HTML.
       Po ověření všech úvodních parametrů je heslo hashováno spolu s automaticky generovanou solí
       pomocí funkce password _hash(). Pokud uživatel při registraci zadal již existující jméno,
       bude předán zpět na registrační stránku a požádán o výběr jiného jména. Pokud jsou všechny kontroly úspěšné,
       uživatel bude přidán do databáze, jeho uživatelské jméno a id jsou uloženy v Cookies
       a $_SESSION[„session“] nastavuje hodnotu „active“. Jinak se zobrazí chybová zpráva.
    */
    require_once 'connect.php';
    require_once "validation.php";
    $username = $_POST['username'];
    $username = clean($username);
    $username = mysqli_real_escape_string($connect, $username);
    $password = $_POST['password'];
    $password = mysqli_real_escape_string($connect, $password);
    $confirm = $_POST['confirm'];
    // validace vstupních polí
    if ((strlen($username) < 5) or ($confirm <> $password) or (strlen($_POST['password']) < 8) or strlen($username) > 20 or strlen($_POST['password']) > 20){
        //  chybová zpráva
        if (strlen($username) < 5 or strlen($username) > 20){
            $_SESSION['username-message'] = 'Length is from 5 to 20 characters';
            header("Location: ../signup.php?name=$username");
        }
        if ($confirm <> $password){
            $_SESSION['confirm-password'] = 'Incorrectly repeated password';
            header("Location: ../signup.php?name=$username");
        }

        if (strlen($_POST['password']) < 8 or strlen($_POST['password']) > 20){
            $_SESSION['password'] = 'Length is from 8 to 20 characters';
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

