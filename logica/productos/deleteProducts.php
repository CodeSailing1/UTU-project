<?php
require './Productos.php';
require '../conexionSQL.php';

if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    header('Location: /interfaz/public-html/register.html');
    exit;
}

header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

if ($data === null) {
    echo json_encode('Invalid JSON data');
    exit;
}

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'sigto';
$ConexionDB = new conexionSQL($server, $database, $username, $password);
$pdo = $ConexionDB->getPdo();
$product = new Productos(null, null, null, null,null,null,null,null,null,null,null, $pdo);
$response = $product->deleteProduct($data['id']);
echo $response;