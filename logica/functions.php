<?php
function URLvalidator(){
    if ($_SERVER['REQUEST_URI'] === "/UTU-project/interfaz/public-html/finder.php"){
        require 'showProducts.php';
    }
}