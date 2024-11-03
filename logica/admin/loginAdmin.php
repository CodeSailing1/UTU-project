<?php
require_once '../conexionSQL.php';
require_once '../DataValidator.php';
require_once './Admin.php';
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
$admin = new Admin(null, null, $_POST['email'], $_POST['password'],  null, $pdo);
$admin->loginAdmin();

