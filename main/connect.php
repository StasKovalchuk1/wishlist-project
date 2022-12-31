<?php
// připojení k databázi

    $connect = mysqli_connect('localhost', 'root', 'root', 'wishlist_bd');
    if (!$connect){
        die("Failed to connect to the database");
    }
