<?php
$server = "localhost";
$user = "root";
$pass = "";
$db = "sigtoclap";
try {
    $pdo = new PDO("mysql:host=$server;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $p) {
    die('Error al conectar a la base de datos: ' . $p->getMessage());
}