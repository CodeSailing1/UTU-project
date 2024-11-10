<?php
include '../functions.php';
require './Productos.php';
require '../conexionSQL.php';
session_start();
header('Content-Type: application/json');
if(!isset($_SESSION['loginEmpresa']))
{
    return json_encode(['success' => false, 'message' => 'Empresa no logueada']);
}
$idEmpresa = $_SESSION['id'];
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'sigto';
$ConexionDB = new conexionSQL($server, $database, $username, $password);
$pdo = $ConexionDB->getPdo();

$searchTerm = $_GET['searchTerm'];

if (isset($searchTerm)) {
    $products = new Productos(null, null, null, null, null, null, null, null,null, null, null, $pdo);
    $producto = "%$searchTerm%";
    $result = $products->findProductoByNameEmpresas($producto, $idEmpresa);
    echo json_encode($result);
}