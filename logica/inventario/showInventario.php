<?php
require 'InventarioEmpresas.php';
require '../conexionSQL.php';
session_start();
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header('Location: /interfaz/public-html/register.html');
    exit;
}
$idEmpresa = $_SESSION['id'];
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'sigto';
$ConexionDB = new conexionSQL($server, $database, $username, $password);
$pdo = $ConexionDB->getPdo();

$product = new InventarioEmpresas($idEmpresa, $pdo);
$result = $product->showInventario();
echo $result; 