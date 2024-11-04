<?php
require_once('../conexionSQL.php');
require_once('BackOffice.php');
header('Content-Type: application/json');
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'sigto';

$ConexionDB = new conexionSQL($server, $database, $username, $password);
$pdo = $ConexionDB->getPdo();
$backoffice = new BackOffice($pdo);
$ventas = $backoffice->resumenVentasEmpresasMes();
echo json_encode($ventas);
