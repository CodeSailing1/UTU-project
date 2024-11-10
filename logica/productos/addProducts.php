<?php
require 'Productos.php';
require '../conexionSQL.php';

header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /interfaz/public-html/register.html');
    exit;
}

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'sigto';
$ConexionDB = new conexionSQL($server, $database, $username, $password);
$pdo = $ConexionDB->getPdo();

$product = new Productos($_POST['name'], $_POST['price'], $_POST['category'], $_POST['description'], null, null, false, null, null,null, false, $pdo);
$result = $product->addProduct($_FILES['img']);
echo $result; 