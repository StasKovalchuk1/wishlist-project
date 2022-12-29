<?php
session_start();
$_SESSION['session'] = 'inactive';
header('Location: ../login.php');
?>
