<?php
require_once '../conexionSQL.php';
require_once '../DataValidator.php';
require_once 'Admin.php';
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
$admin = new Admin($_POST['id'], $_POST['name'], $_POST['email'], $_POST['phone'], $_POST['password'], $pdo);
$admin->registerAdmin();