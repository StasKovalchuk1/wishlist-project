<?php
session_start();
require_once "main/connect.php";

// kontrola čísla stránky

$num_per_page = 5;

if (isset($_GET['page'])){
    $page = $_GET['page'];
}
else{
    $page = 1;
}

$start_from = ($page - 1) * 5;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WishList</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="print.css" media="print">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;200;300;400;500;700&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<?php
if (isset($_COOKIE['theme'])){
    if ($_COOKIE['theme'] == 'blue-theme'){
        echo '<body class="blue-theme">';
    }
    else if ($_COOKIE['theme'] == 'pink-theme'){
        echo '<body class="pink-theme">';
    }
}
else{
    echo '<body class="blue-theme">';
}
?>

<!-- Header -->

<header class="header" id="header">
    <div class="container">
        <div class="header-inner">
            <div class="header-title">
                <h4 class="corner-title">make<br>others<br>happy___</h4>
            </div>
            <nav class="nav" id="nav">
                <a href="welcomepage.php" class="nav-link">Home</a>
                <?php
                if (isset($_SESSION['session'])){
                    if ($_SESSION['session'] == 'inactive'){
                        echo '<a href="login.php" class="nav-link">Log in</a>';
                    }
                    else if ($_SESSION['session'] == 'active'){
                        echo '<a href="mywishlist.php" class="nav-link">Wishlist</a>';
                        echo '<form action="main/destroySession.php" method="post"><button class="nav-link logout">Log out</button></form>';
                    }
                }
                else{
                    echo '<a href="login.php" class="nav-link">Log in</a>';
                }
                ?>
                <form class="nav-link search-btn" action="searchlist.php">
                    <button class="search" id="search">
                        <img src="img/search1.jpg" alt="" class="icon-search">
                    </button>
                </form>
            </nav>
        </div>
    </div>
</header>
<!--Title-->

<div class="list-title">
    <?php
    if (isset($_COOKIE['search-name'])){
        echo '<h2>Search for ' . $_COOKIE['search-name'] . '&apos;s  Wishlist</h2>';
    }

    else{
        echo 'My Wishlist';
    }

    ?>
</div>
<?php
/* pokud se uživatel, který není přihlášen, pokusí zarezervovat dárek,
     zobrazí se zpráva s odkazem na přihlášení */
if (isset($_SESSION['book-message'])){
    echo '<p class="message"> ' . $_SESSION['book-message'] . ' <a href="login.php">here</a></p>';
}
unset($_SESSION['book-message']);
?>
<div class="wishlist">
    <div class="container">
        <div class="wishlist-inner">
            <table>
                <tr>
                    <th>Wish</th>
                    <th>Count</th>
                    <th>Date</th>
                    <th>Reserved by</th>
                </tr>
                <?php
                if (isset($_COOKIE['search-name'])){
                $arr = mysqli_query($connect, "SELECT `id` FROM `users` WHERE `name` = '".$_COOKIE['search-name']."'");
                $arr = mysqli_fetch_all($arr);
                foreach ($arr as $row){
                    $id = $row[0];
                }
                $result = mysqli_query($connect, "SELECT `id`, `wish`, `count`, `date`, `reservation` FROM `wishes` WHERE `user_id` = '$id' LIMIT $start_from ,$num_per_page");
                $result = mysqli_fetch_all($result);
                foreach ($result as $row){
                    $reserved_by_id = $row[4]; // id uživatele, který si rezervoval dárek
                    $reserved_wish_id = $row[0]; // id položky k rezervaci
                    ?>
                    <tr>
                        <td><?= $row[1]?></td>
                        <td><?= $row[2]?></td>
                        <td><?= $row[3]?></td>
                        <td><?php
                            // vyplnění sloupce tabulky “Reserved by“
                            if ($reserved_by_id== NULL){
                                echo '<a id="reserveButton" href="main/book_gift.php?page='.$page.'&id='.$reserved_wish_id.'">Click to reserve</a>';

                            }
                            else{
                                $list = mysqli_query($connect, "SELECT `name` FROM `users` WHERE `id` = '$reserved_by_id'");
                                $list = mysqli_fetch_all($list);
                                foreach ($list as $row){
                                    $reserved_by = $row[0];
                                }
                                if($reserved_by_id == $_COOKIE['userID'] and isset($_SESSION['session'])) {
                                    if ($_SESSION['session'] == 'active') {
                                        // odkaz na zrušení rezervace
                                        echo '<a href="main/cancelReservation.php?page='.$page.'&id='.$reserved_wish_id.'">' . $reserved_by . '</a>';
                                    }
                                    else{
                                        echo $reserved_by;
                                    }
                                }
                                else{
                                    echo $reserved_by;
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                }
                }
                ?>
            </table>
            <?php
            // strankovani
            //výstup 5 řádků seznamu
            if (isset($id)){
                $result = mysqli_query($connect, "SELECT * FROM `wishes` WHERE `user_id` = '$id'");
                $total_records = mysqli_num_rows($result);
                $total_pages = ceil($total_records/$num_per_page);
                echo "<div class='pagination'>";
                // číslování stránek ve formě odkazů
                for($i=1;$i<=$total_pages;$i++){
                    if ($i == $page){
                        echo "<a class='page' href='searchPage.php?page=".$i."'>".$i." </a>";
                    }
                    else{
                        echo "<a class='pagenumber' href='searchPage.php?page=".$i."'>".$i." </a>";
                    }
                }
                echo "</div>";
            }
            ?>
        </div>
    </div>
</div>
<script src="app.js"></script>
<script src="script2.js"></script>
</body>
</html>
