<?php
include '../functions.php';
require './Productos.php';
require '../conexionSQL.php';

header('Content-Type: application/json');

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'sigto';
$ConexionDB = new conexionSQL($server, $database, $username, $password);
$pdo = $ConexionDB->getPdo();

$searchTerm = $_GET['idProducto'];

if (isset($searchTerm)) {
    $products = new Productos(null, null, null, null, null,null,null,null,null, null, null, $pdo);
    
    $result = $products->findProductById($searchTerm);
    echo json_encode($result); 
}