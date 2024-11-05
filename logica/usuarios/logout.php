<?php
require_once '../DataValidator.php';
require_once '../conexionSQL.php';
require_once 'Usuario.php';
session_start();
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'sigto';
$ConexionDB = new conexionSQL($server, $database, $username, $password);
$pdo = $ConexionDB->getPdo();
$usuario = new Usuario(null, null, null, null, null, null, $pdo);
$usuario->logoutUser();