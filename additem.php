<?php
session_start();
$_SESSION['token'] = bin2hex(random_bytes(35));

if (isset($_SESSION['session'])){     //kontrola, zda je uživatel přihlášen
    if ($_SESSION['session'] == 'inactive'){
        header("Location: login.php");
    }
}
else{
    header("Location: login.php");
}

if (isset($_GET['wish'])){
    $wish = $_GET['wish'];
}if (isset($_GET['count'])){
    $count = $_GET['count'];
}if (isset($_GET['date'])){
    $date = $_GET['date'];
}
if (isset($_GET['checkbox'])){
    $check = $_GET['checkbox'];
}

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
    <script src="app.js"></script>
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
    <form action="main/add.php" method="post" id="form3">
      <div class="form-field">
        <fieldset>
          <legend class="form-title">Add an item</legend>
          <div class="row">
            <label for="item" class="form-label">What would you like? (0-100 characters)</label>
            <input type="text" name="item" id="item" placeholder="e.g. t-shirt" class="form-box wish" required value="<?= isset($wish) ? $wish : ''?>">
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
            <input type="number" name="count" id="count" class="form-box count" min="1" max="999999999" required value="<?= isset($count) ? $count : ''?>">
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
            <input type="date" name="date" id="date" class="form-box" value="<?= isset($date) ? $date : ''?>">
          </div>
            <div class="row">
                <label for="checkbox" class="form-label">Click if you are cool! (optional)</label>
                <?php
                    if (isset($check)){
                        if ($check == 'on'){
                            echo '<input type="checkbox" name="checkbox" id="checkbox" class="click" checked>';
                        } else{
                            echo '<input type="checkbox" name="checkbox" id="checkbox" class="click">';
                        }
                    } else{
                        echo '<input type="checkbox" name="checkbox" id="checkbox" class="click">';
                    }

                ?>
            </div>

            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
          <input type="submit" value="Add item" class="btn btn-form">
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