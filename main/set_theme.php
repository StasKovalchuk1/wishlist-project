<?php
// nastaví hodnotu motivu webu v cookie
if (isset($_COOKIE['theme'])){
    if ($_COOKIE['theme'] == 'pink-theme'){
        unset($_COOKIE['theme']);
        setcookie('theme', 'blue-theme', time()+60*60*24*365, '/');
    }
    else{
        unset($_COOKIE['theme']);
        setcookie('theme', 'pink-theme', time()+60*60*24*365, '/');
    }
}
else{
    setcookie('theme', 'blue-theme', time()+60*60*24*365, '/');
}
header("Location: ../welcomepage.php");