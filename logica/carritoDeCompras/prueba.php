<?php
require_once 'carritoDeCompras.php';
require_once '../conexionSQL.php';
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}



if (!isset($_SESSION['idUsuario'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

try {
    $idUsuario = $_SESSION['idUsuario'];
    $server = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'sigto';
    $ConexionDB = new conexionSQL($server, $database, $username, $password);
    $pdo = $ConexionDB->getPdo();
    $carrito = new CarritoDeCompras($idUsuario, $pdo);
    $response = $carrito->boughtProducts();

    echo json_encode($response);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
exit;