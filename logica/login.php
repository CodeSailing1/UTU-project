<?php
require_once 'conexionSQL.php';

$email = $_POST['email'];
$passwd = $_POST['passwd']; 

$hashedPasswd = password_hash($passwd, PASSWORD_DEFAULT);
$sql = $conexion -> prepare("SELECT * FROM  users WHERE email = ? AND passwd = ?");
$sql->bind_param("ss", $email, $hashedPasswd);

if($sql->execute()){
    $affectedRows = $sql->affected_rows;
    if(!$affectedRows > 0){
        session_abort();
        exit();
    }
    session_start();
    $_SESSION['user'] = $name;
    header('Location: /interfaz/public-html/index.html');
}