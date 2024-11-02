<?php
require_once 'Historial.php';
require_once '../conexionSQL.php';
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data)) {
    echo json_encode(['error' => 'No data provided']);
    exit;
}

if (!isset($_SESSION['idUsuario'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

try {
    $idUsuario = $_SESSION['idUsuario'];
    $idProducto = $data['idProducto'];
    $server = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'sigto';
    $ConexionDB = new conexionSQL($server, $database, $username, $password);
    $pdo = $ConexionDB->getPdo();
    $carrito = new Historial($idUsuario, $pdo);
    $carrito->insertIntoHistorialVista($idProducto);
    echo json_encode(['success'=> true,'message'=> 'Product viewed succesfully']);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
exit;