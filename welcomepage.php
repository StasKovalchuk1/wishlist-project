<?php
session_start();
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset = "utf-8">
        <title>Wishlist</title>
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
                        <form class="nav-link themes" action="main/set_theme.php" method="post">
                            <button class="switch">Switch</button>
                        </form>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Intro -->

        <div class="intro">
            <div class="container">
                <div class="intro-inner">
                    <h1 class="intro-title">The Wish List Maker</h1>
                    <h3 class="intro-subtitle">Your gift assistant</h3>
                    <a class="btn btn-yellow" href="main/request.php">Create my wishlist</a>
                </div>
            </div>
        </div>

        <!-- Reviews -->

        <div class="reviews">
            <div class="container">
                <div class="reviews-inner">
                    <div class="comment">
                        <p class="comment-info">Your service helps me and my family. Because
                        of you we always know what to present to each other. And it's very user-friendly
                        interface! We will share it with friends with your link! Thank you </p>
                        <p class="reviewer-name">John S.</p>
                    </div>
                    <div class="comment">
                        <p class="comment-info">I have really enjoyed using Wishlist. It is a nice way to show people are appreciated.
                            There is nothing worse than getting a gift you don't like, or a gift card for a store you would never shop at!
                        </p>
                        <p class="reviewer-name">Kevin M.</p>
                    </div>
                    <div class="comment">
                        <p class="comment-info">I have absolutely loved working with Wishlist! I would recommend it to anyone. Thank you for what you're doing!!! Keep up the good work!
                        </p>
                        <p class="reviewer-name">Rachel H.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="footer-inner">
                    <p class="footer-block">&copy;Things</p>
                </div>
            </div>
        </footer>
        <script src="script2.js"></script>
    </body>
</html>