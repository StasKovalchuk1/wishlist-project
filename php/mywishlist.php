<?php
    session_start();
    $_SESSION['token'] = bin2hex(random_bytes(35));   //vytvoření CSRF tokenu
    require_once 'main/connect.php';

    if (isset($_SESSION['session'])){     //kontrola, zda je uživatel přihlášen
        if ($_SESSION['session'] == 'inactive'){
            header("Location: login.php");
        }
    }
    else{
        header("Location: login.php");
    }

    // kontrola čísla stránky

    $num_per_page = 5;

    if (isset($_GET['page'])){
        $page = $_GET['page'];
        $result = mysqli_query($connect, "SELECT * FROM `wishes` WHERE `user_id` = '" . $_COOKIE['userID'] . "'");
        $total_records = mysqli_num_rows($result);
        $total_pages = ceil($total_records/$num_per_page);
        if ($page > $total_pages){
            $page = $page - 1;
        }
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
        else{
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
    if (isset($_COOKIE['username'])){
        echo '<h2>' . $_COOKIE['username'] . '&apos;s  Wishlist</h2>';
    }

    else{
        echo '<h2>My Wishlist</h2>';
    }

    ?>
    </div>

    <!-- WishList-->

    <div class="wishlist">
      <div class="container">
        <div class="wishlist-inner">
            <form action="additem.php" method="post">
                <button class="btn btn-green">add another item</button>
            </form>
                <table>
                    <tr>
                        <th>Wish</th>
                        <th>Count</th>
                        <th>Date</th>
                    </tr>
                    <?php
                    if (isset($_COOKIE['userID'])){
                        $result = mysqli_query($connect, "SELECT `id`, `wish`, `count`, `date` FROM `wishes` WHERE `user_id` = '" . $_COOKIE['userID'] . "' LIMIT $start_from ,$num_per_page");
                        if ($result){
                        $result = mysqli_fetch_all($result);
                        foreach ($result as $row){
                    ?>
                    <tr>
                     <td><?= $row[1]?></td>
                     <td><?= $row[2]?></td>
                     <td><?= $row[3]?></td>
                     <td class="correct">
                         <form action="update.php?id=<?= $row[0]?>&page=<?= $page ?>" method="post">
                             <button class="search"><img src="img/edit.png" alt="" class="edit"></button>
                         </form>
                     </td>
                     <td class="correct">
                         <form action="main/delete.php?id=<?= $row[0] ?>&page=<?= $page ?>" method="post">
                             <button class="search"><img src="img/delete.png" alt="" class="delete"></button>
                             <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
                         </form>
                     </td>
                    </tr>
                    <?php
                        }
                        }
                    ?>
                </table>

                <?php
                    // výstup 5 řádků seznamu
                    $result = mysqli_query($connect, "SELECT * FROM `wishes` WHERE `user_id` = '" . $_COOKIE['userID'] . "'");
                    $total_records = mysqli_num_rows($result);
                    $total_pages = ceil($total_records/$num_per_page);
                    echo "<div class='pagination'>";
                    // číslování stránek ve formě odkazů
                    for($i=1;$i<=$total_pages;$i++){
                        if ($i == $page){
                            echo "<a class='page' href='mywishlist.php?page=".$i."'>".$i." </a>";
                        }
                        else{
                            echo "<a class='pagenumber' href='mywishlist.php?page=".$i."'>".$i." </a>";
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