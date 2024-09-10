<?php
function loginValidator(){
    if(!isset($_SESSION['nombre'])){
        header("Location: /UTU-project/interfaz/public-html/login.html");
        session_abort();
        exit;
    }
    
}
function URLvalidator(){
if ($_SERVER['REQUEST_URI'] === "/UTU-project/interfaz/public-html/finder.php"){
    require 'showProducts.php';
}
}