<?php
require_once '../DataValidator.php';
require_once 'Empresa.php';
require_once '../GetImage.php';
header(  'Content-Type: application/json' );
session_start();
if($_SERVER['REQUEST_METHOD'] !== 'PUT')
{
    http_response_code(405);
}
$data = json_decode(file_get_contents('php://input'), true);

if ($data === null) {
    echo json_encode('Invalid JSON data');
    exit;
}
$idUsuario = $_SESSION['id'];
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'sigto';
$ConexionDB = new conexionSQL($server, $database, $username, $password);
$pdo = $ConexionDB->getPdo();
$empresa = new Empresa($idUsuario, null, null, null, null, null, $pdo);
if($empresa->changeDataEmpresaPasswd($data['password'], $data['confirmPassword']))
{
    session_destroy();
    session_abort();
    return json_encode(['success' => 'success']);
} else
{
    return json_encode(['success' => false]);
}