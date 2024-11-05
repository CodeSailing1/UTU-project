<?php
require 'InventarioEmpresas.php';
require '../conexionSQL.php';
session_start();
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    exit;
}
if(!isset($_SESSION['loginEmpresa']))
{
    echo json_encode('User not loged in');
    return;
}
$idEmpresa = $_SESSION['id'];
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'sigto';
$ConexionDB = new conexionSQL($server, $database, $username, $password);
$pdo = $ConexionDB->getPdo();

$product = new InventarioEmpresas($idEmpresa, $pdo);
$result = $product->showInventarioInactivo();
echo $result;