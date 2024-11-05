<?php
include '../functions.php';
require './Productos.php';
require '../conexionSQL.php';
session_start();
header('Content-Type: application/json');
$idEmpresa = $_SESSION['id'];
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'sigto';
$ConexionDB = new conexionSQL($server, $database, $username, $password);
$pdo = $ConexionDB->getPdo();

$searchTerm = $_GET['idProducto'];
if ($searchTerm == null) {
    header('Location: /UTU-project/interfaz/private-html/empresas/abm/eliminarEmpresas.php');
}
if(isset($searchTerm))
{
    $products = new Productos(null, null, null, null, null,null,null,null,null, null, null, $pdo);

    $result = $products->findProductByIdActivate($searchTerm, $idEmpresa);
    echo json_encode($result);
}