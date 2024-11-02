<?php
require_once '../functions.php';
require '../clases/Usuario.php';
require_once '../clases/conexionSQL.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    header('Location: /interfaz/public-html/register.html');
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if ($data === null) {
    echo json_encode('Invalid JSON data');
    exit;
}
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'sigtoClap';
$ConexionDB = new conexionSQL($server, $database, $username, $password);
$pdo = $ConexionDB->getPdo();
$emailNuevo = new Usuario(null, $data['email'], null ,null, null, $pdo);
$emailNuevo->changeDataUser($data['emailCampo'], $data['emailNuevo']);