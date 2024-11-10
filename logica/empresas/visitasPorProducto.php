<?php
require_once 'Empresas.php';
require_once '../conexionSQL.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

try {
    $idEmpresa = $_SESSION['id'];
    $server = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'sigto';
    $ConexionDB = new conexionSQL($server, $database, $username, $password);
    $pdo = $ConexionDB->getPdo();
    $empresa = new Empresa(null,null,null,null,null,null, $pdo);
    $visitasProducto = $empresa->visitasPorProducto($idEmpresa);
    echo json_encode($visitasProducto);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
exit;