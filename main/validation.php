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

function validateDate($date){
    $pattern = '/^(\d{4})-(\d{1,2})-(\d{1,2})/';
    if (preg_match($pattern, $date)){ // shoda s regulárním výrazem
        $list = explode('-', $date);
        if (checkdate($list[1], $list[2], $list[0])){ // ověření data
            return true;
        } else{
            return false;
        }
    } else {
        return false;
    }
}