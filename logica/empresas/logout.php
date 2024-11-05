<?php
require_once '../DataValidator.php';
require_once '../conexionSQL.php';
require_once 'Empresas.php';
session_start();
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'sigto';
$ConexionDB = new conexionSQL($server, $database, $username, $password);
$pdo = $ConexionDB->getPdo();
$empresa = new Empresa(null, null, null, null, null, null, $pdo);
$empresa->logoutEmpresa();