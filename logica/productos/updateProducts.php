<?php
include '../functions.php';
require './Productos.php';
require '../conexionSQL.php';

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    echo json_encode([ 'error' => 'Method not allowed']);
    exit;
}

header('Content-Type: application/json');

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'sigto';
$ConexionDB = new conexionSQL($server, $database, $username, $password);
$pdo = $ConexionDB->getPdo();
$product = new Productos(null, $_POST['name'], $_POST['price'], $_POST['category'], $_POST['description'], null, null,null,null,null,null,$pdo);
$result = $product->updateProduct($_POST['id'], $_FILES['img']);
echo $result; 