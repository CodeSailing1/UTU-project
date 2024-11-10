<?php
require_once('../conexionSQL.php');
require_once('carritoDeCompras.php');
header('Content-Type: application/json');
session_start();
$idUsuario = $_SESSION['idUsuario'];
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'sigto';

$ConexionDB = new conexionSQL($server, $database, $username, $password);
$pdo = $ConexionDB->getPdo();
$carrito = new CarritoDeCompras($idUsuario, $pdo);
$cart = $carrito->showCart();
echo json_encode($cart);
