<?php
require 'InventarioEmpresas.php';
require '../conexionSQL.php';
session_start();
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(403);
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
$result = $product->addProduct($_POST['name'],$_POST['price'], $_POST['category'],$_POST['description'], $_FILES['img'], $_POST['stock'] );
echo $result; 