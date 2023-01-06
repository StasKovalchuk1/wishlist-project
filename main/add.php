<?php
/*
  Pomocí funkce clean() ze souboru main/validation.php je pole s názvem položky vymazáno ze značek html a php,
  speciální znaky jsou převedeny na entity HTML. Pomocí dotazu sql zkontrolujeme jedinečnost položky,
  pokud je taková položka již v seznamu, zobrazí se chybová zpráva, pokud ne,
  pak po ověření správnosti tokenu CSRF se data přidají do databáze.
 */
session_start();
    require_once "connect.php";
    require_once "validation.php";

    $userID = $_COOKIE['userID'];

    $wish = $_POST['item'];
    $wish = clean($wish);
    $count = $_POST['count'];
    if (isset($_POST['token'])){
        $token = $_POST['token'];
    } else {
        $_SESSION['message'] = 'Error: CSRF attack!';
        header("Location: ../additem.php");
    }
    if (isset($_POST['checkbox'])){
        $check = $_POST['checkbox'];
    } else {
        $check = '';
    }

if (($token == $_SESSION['token']) and isset($_SESSION['token'])){
    // musel jsem rozdělit dotazy s prázdnou hodnotou data a neprázdnou
    if ($_POST['date'] == NULL){
        // ověření délky pole s přáním a hodnotou množství
        if (strlen($wish) > 100 or $count < 1 or empty($wish) or strlen($_POST['count']) > 9){
            if (strlen($wish) > 100){
                $_SESSION['wish-message'] = 'Your wish is too long';
            }
            if (empty($wish)){
                $_SESSION['wish-message'] = 'This field is required';
            }
            if ($count < 1 or strlen($_POST['count']) > 9){
                $_SESSION['count-message'] = 'The allowed number is from 1 to 99999999';
            }
            header("Location: ../additem.php?wish=$wish&count=$count&checkbox=$check");
            exit();
        }
        else{
            $result = mysqli_query($connect, "SELECT `wish` FROM `wishes` WHERE `user_id` = '" . $_COOKIE['userID'] . "'");
            $result = mysqli_fetch_all($result);
            // odolnost proti dvojímu odeslání stejné položky
            foreach ($result as $row){
                if ($row[0] == $wish){
                    $_SESSION['message'] = 'This item is already on your wishlist!';
                    header("Location: ../additem.php?wish=$wish&count=$count&checkbox=$check");
                    exit();
                }
            }
            mysqli_query($connect, "INSERT INTO `wishes` (`id`, `user_id`, `wish`, `count`, `date`, `reservation`) VALUES (NULL, '$userID', '$wish', '$count', NULL, NULL)");
        }
    }
    else{
        $date = $_POST['date'];
        // ověření délky pole s přáním a hodnotou množství
        if (strlen($wish) > 100 or $count < 1 or empty($wish) or strlen($_POST['count']) > 9){
            if (strlen($wish) > 100){
                $_SESSION['wish-message'] = 'Your wish is too long';
            }
            if (empty($wish)){
                $_SESSION['wish-message'] = 'This field is required';
            }
            if ($count < 1 or strlen($_POST['count']) > 9){
                $_SESSION['count-message'] = 'The allowed number is from 1 to 99999999';
            }
            header("Location: ../additem.php?wish=$wish&count=$count&date=$date&checkbox=$check");
            exit();
        }
        else{
            $result = mysqli_query($connect, "SELECT `wish` FROM `wishes` WHERE `user_id` = '" . $_COOKIE['userID'] . "'");
            $result = mysqli_fetch_all($result);
            // odolnost proti dvojímu odeslání stejné položky
            foreach ($result as $row){
                if ($row[0] == $wish){
                    $_SESSION['message'] = 'This item is already on your wishlist!';
                    header("Location: ../additem.php?wish=$wish&count=$count&date=$date&checkbox=$check");
                    exit();
                }
            }
            mysqli_query($connect, "INSERT INTO `wishes` (`id`, `user_id`, `wish`, `count`, `date`, `reservation`) VALUES (NULL, '$userID', '$wish', '$count', '$date', NULL)");
        }
    }


    header("Location: ../mywishlist.php");
}
else{
    $_SESSION['message'] = 'Error: CSRF attack!';
    header("Location: ../additem.php");
}