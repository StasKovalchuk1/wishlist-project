<?php
    session_start();
    require_once 'main/connect.php';

    if (isset($_SESSION['session'])){     //kontrola, zda je uživatel přihlášen
        if ($_SESSION['session'] == 'inactive'){
            header("Location: login.php");
        }
    }
    else{
        header("Location: login.php");
    }

    $_SESSION['token'] = bin2hex(random_bytes(35));   //vytvoření CSRF tokenu

    if (isset($_GET['id'])){
        $id = $_GET['id'];
        $result = mysqli_query($connect, "SELECT `wish`, `count`, `date` FROM `wishes` WHERE `id` = '$id'");
        $result = mysqli_fetch_all($result);
        foreach ($result as $row){
            $wish = $row[0];
            $count = $row[1];
            $date = $row[2];
        }
    }
    else{
        $id = $_GET['ID'];
        $wish = $_GET['wish'];
        $count = $_GET['count'];
        $date = $_GET['date'];
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Update your wish</title>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="print.css" media="print">
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;200;300;400;500;700&display=swap" rel="stylesheet">
        <script src="app.js"></script>
    </head>
    <body>

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

    <!-- Update -->

    <div class="form">
        <div class="container">
            <form action="main/update.php?page=<?=$_GET['page'] ?>" method="post" id="form3">
                <div class="form-field">
                    <fieldset>
                        <legend class="form-title">Update your item</legend>
                        <input type="hidden" name="id" value="<?=$id ?? '' ?>">
                        <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
                        <div class="row">
                            <label for="item" class="form-label">What would you like?</label>
                            <input type="text" name="item" id="item" placeholder="e.g. t-shirt" class="form-box wish" required value="<?= $wish ?? '' ?>">
                            <p class="err" id="err1"></p>
                            <?php
                            if (isset($_SESSION['message'])){
                                echo '<p class="err"> ' . $_SESSION['message'] . '</p>';
                            }
                            unset($_SESSION['message']);
                            if (isset($_SESSION['wish-message'])){
                                echo '<p class="err"> ' . $_SESSION['wish-message'] . '</p>';
                            }
                            unset($_SESSION['wish-message']);
                            ?>
                        </div>
                        <div class="row">
                            <label for="count" class="form-label">How much?</label>
                            <input type="number" name="count" id="count" class="form-box count" min="1" max="999999999" required value="<?= $count ?? '' ?>">
                            <p class="err" id="err2"></p>
                            <?php
                            if (isset($_SESSION['count-message'])){
                                echo '<p class="err"> ' . $_SESSION['count-message'] . '</p>';
                            }
                            unset($_SESSION['count-message']);
                            ?>
                        </div>
                        <div class="row">
                            <label for="date" class="form-label">By what time? (optional)</label>
                            <input type="date" name="date" id="date" class="form-box" value="<?= $date ?? '' ?>">
                        </div>

                        <input type="submit" value="Update item" class="btn btn-form">
                    </fieldset>
                </div>
            </form>
            <script>
                init();
            </script>
        </div>
    </div>
    <script src="script2.js"></script>
    </body>
    </html>
