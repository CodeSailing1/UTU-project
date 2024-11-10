<?php

require_once '../DataValidator.php';
require_once 'Usuario.php';
require_once '../carritoDeCompras/carritoDeCompras.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
$usuario = new Usuario(null, null, $_POST['email'], null, $_POST['password'], null, $pdo);
$usuario->loginUser();

