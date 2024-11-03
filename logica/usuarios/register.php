<?php
require_once '../DataValidator.php';
require_once 'Usuario.php';
require_once '../GetImage.php';
header(  'Content-Type: application/json' );
if($_SERVER['REQUEST_METHOD'] !== 'POST')
{
    http_response_code(405);
}
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'sigto';
$ConexionDB = new conexionSQL($server, $database, $username, $password);
$pdo = $ConexionDB->getPdo();
$usuario = new Usuario(null, $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['password'], $_POST['direccion'], $pdo);
$usuario->registerUser($_FILES['image']);