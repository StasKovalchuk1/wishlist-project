<?php
session_start();
$_SESSION['token'] = bin2hex(random_bytes(35));
if (isset($_GET['wish'])){
    $wish = $_GET['wish'];
}if (isset($_GET['count'])){
    $count = $_GET['count'];
}if (isset($_GET['date'])){
    $date = $_GET['date'];
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
    <form action="main/add.php" method="post">
      <div class="form-field">
        <fieldset>
          <legend class="form-title">Add an item</legend>
          <div class="row">
            <label for="item" class="form-label">What would you like?</label>
            <input type="text" name="item" id="item" placeholder="e.g. t-shirt" class="form-box" required value="<?= isset($wish) ? $wish : ''?>">
              <?php
              if (isset($_SESSION['message'])){
                  echo '<p class="err"> ' . $_SESSION['message'] . '</p>';
              }
              unset($_SESSION['message']);
              ?>
          </div>
          <div class="row">
            <label for="count" class="form-label">How much?</label>
            <input type="number" name="count" id="count" class="form-box" min="1" required value="<?= isset($count) ? $count : ''?>">
          </div>
          <div class="row">
            <label for="date" class="form-label">By what time? (optional)</label>
            <input type="date" name="date" id="date" class="form-box" value="<?= isset($date) ? $date : ''?>">
          </div>

            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
          <input type="submit" value="Add item" class="btn btn-form">
        </fieldset>
      </div>
    </form>
  </div>
</div>
<script src="script2.js"></script>
</body>
</html>