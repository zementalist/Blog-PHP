<?php


function checkForm($array, $fields) {
    foreach($fields as $field) {
        if(!array_key_exists($field, $array) || empty($array["$field"])) {
            return false;
        }
    }
    return true;
}

function checkLength($str, $min=1, $max=100) {
    return strlen($str) >= $min && strlen($str) <= $max;
}



?>