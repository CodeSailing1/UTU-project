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

$categoryProduct = $_GET['category'];

if (isset($categoryProduct)) {
    $product = new Productos(null, null, null, $categoryProduct, null, null,null,null,null, null, null, $pdo);
    $categoria = "%$categoryProduct%";

    $result = $product->findProductsByCategory();
    echo json_encode($result); 
}