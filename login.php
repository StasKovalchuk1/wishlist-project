<?php
session_start();
// data při nesprávném vyplnění formuláře nejsou ztracena
if (isset($_GET['name'])){
    $username = $_GET['name'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
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


<!--Login-->

<div class="form">
    <div class="container">
        <form action="main/authorization.php" method="post">
            <div class="form-field">
                <fieldset>
                    <legend class="form-title">Log in to your account</legend>
                    <div class="row">
                        <label for="login" class="form-label">Username</label>
                        <input type="text" name="username" id="login" class="form-box pattern" required value="<?= isset($username) ? $username : ''?>" pattern="\w{5,255}">
                    </div>
                    <div class="row">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-box pattern" required pattern="\w{8,255}">
                    </div>
                    <?php
                    //  chybová zpráva
                    if (isset($_SESSION['message'])){
                        echo '<p class="err"> ' . $_SESSION['message'] . '</p>';
                    }
                    unset($_SESSION['message']);
                    ?>
                    <input type="submit" value="Login" class="btn btn-form">
                    <p>Dont have an account yet? <a href="signup.php">Sign up!</a></p>

                </fieldset>
            </div>

        </form>
    </div>
</div>
<script src="app.js"></script>
<script src="script2.js"></script>
</body>
</html>