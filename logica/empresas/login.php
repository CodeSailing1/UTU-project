<?php
require_once '../DataValidator.php';
require_once '../conexionSQL.php';
require_once 'Empresas.php';
header(  'Content-Type: application/json' );
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
$usuario = new Empresa(null, null, $_POST['emailEmpresa'], null, $_POST['passwordEmpresa'], null, $pdo);
$usuario->loginEmpresa();

