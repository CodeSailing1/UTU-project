<?php
require './Productos.php';
require '../conexionSQL.php';

header('Content-Type: application/json');

try {
    $server = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'sigto';
    $ConexionDB = new conexionSQL($server, $database, $username, $password);
    $pdo = $ConexionDB->getPdo();

    $products = new Productos(null, null, null, null, null, null, null, null, null, null, null, $pdo);

    $result = $products->showProducts();
    return json_encode($result);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}