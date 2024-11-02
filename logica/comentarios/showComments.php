<?php
require_once('../conexionSQL.php');
require_once('comentarios.php');
header('Content-Type: application/json');
session_start();

$idProducto =  $_GET['id'];

$server = 'localhost';
$username = 'root';
$password = '';
$database = 'sigto';

$ConexionDB = new conexionSQL($server, $database, $username, $password);
$pdo = $ConexionDB->getPdo();
$carrito = new Comentarios($idProducto, $pdo);
$response = $carrito->showComments();
echo $response;
