<?php
require_once('../conexionSQL.php');
require_once('Empresas.php');
session_start();
header('Content-Type: application/json');
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'sigto';
$idEmpresa = $_SESSION['id'];
$ConexionDB = new conexionSQL($server, $database, $username, $password);
$pdo = $ConexionDB->getPdo();
$empresa = new Empresa(null, null, null, null, null, null, $pdo);
$ventas = $empresa->rankingProductosMasVendidos($idEmpresa);
echo json_encode($ventas);
