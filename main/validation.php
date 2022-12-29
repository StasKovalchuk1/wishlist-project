<?php
// je pole vymazáno ze značek html a php,
// speciální znaky jsou převedeny na entity HTML
function clean($value){
    $value = trim($value);
    $value = stripslashes($value);
    $value = strip_tags($value);
    $value = htmlspecialchars($value);

    return $value;
}