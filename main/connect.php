<?php
    $connect = mysqli_connect('localhost', 'kovalst1', 'webove aplikace', 'kovalst1');
    if (!$connect){
        die("Failed to connect to the database");
    }
