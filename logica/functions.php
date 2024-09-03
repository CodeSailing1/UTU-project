<?php
function validateData($data){
    if(!preg_match(requirements["$data"], $data)){
        echo "Insert a valid $data";
        session_abort();
    }
}
function testInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}