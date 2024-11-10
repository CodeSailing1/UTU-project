<?php
require_once 'Historial.php';
require_once '../conexionSQL.php';
session_start();

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
    $historial = new Historial($idUsuario, $pdo);
    $historialUser = $historial->showViwedHistorial();
    echo json_encode($historialUser);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
exit;