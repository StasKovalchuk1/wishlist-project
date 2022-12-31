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
    $token = $_POST['token'];

    if (($token == $_SESSION['token']) and isset($_SESSION['token'])){
        // musel jsem rozdělit dotazy s prázdnou hodnotou data a neprázdnou
        if ($_POST['date'] == NULL){
            $result = mysqli_query($connect, "SELECT `wish` FROM `wishes` WHERE `user_id` = '" . $_COOKIE['userID'] . "'");
            $result = mysqli_fetch_all($result);
            // odolnost proti dvojímu odeslání stejné položky
            foreach ($result as $row){
                if ($row[0] == $wish){
                    $_SESSION['message'] = 'This item is already on your wishlist!';
                    header("Location: ../additem.php?wish=$wish&count=$count");
                    exit();
                }
            }
            mysqli_query($connect, "INSERT INTO `wishes` (`id`, `user_id`, `wish`, `count`, `date`, `reservation`) VALUES (NULL, '$userID', '$wish', '$count', NULL, NULL)");
        }
        else{
            $date = $_POST['date'];
            $result = mysqli_query($connect, "SELECT `wish` FROM `wishes` WHERE `user_id` = '" . $_COOKIE['userID'] . "'");
            $result = mysqli_fetch_all($result);
            // odolnost proti dvojímu odeslání stejné položky
            foreach ($result as $row){
                if ($row[0] == $wish){
                    $_SESSION['message'] = 'This item is already on your wishlist!';
                    header("Location: ../additem.php?wish=$wish&count=$count&date=$date");
                    exit();
                }
            }
            mysqli_query($connect, "INSERT INTO `wishes` (`id`, `user_id`, `wish`, `count`, `date`, `reservation`) VALUES (NULL, '$userID', '$wish', '$count', '$date', NULL)");
        }


        header("Location: ../mywishlist.php");
    }
    else{
        echo "Failed to validate CSRF token";
    }
