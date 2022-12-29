<?php
session_start();
$_SESSION['session'] = 'inactive';
unset($_COOKIE["username"]);
header('Location: ../login.php');
?>
