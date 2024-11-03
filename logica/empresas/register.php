<?php
require_once '../DataValidator.php';
require_once 'Empresas.php';
require_once '../GetImage.php';
require_once '../conexionSQL.php';
header(  'Content-Type: application/json' );
if($_SERVER['REQUEST_METHOD'] !== 'POST')
{
    http_response_code(405);
}
    $server = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'sigto';
    $ConexionDB = new conexionSQL($server, $database, $username, $password);
    $pdo = $ConexionDB->getPdo();
    $empresa = new Empresa(null, $_POST['nameEmpresas'], $_POST['emailEmpresas'], $_POST['phoneEmpresas'], $_POST['passwordEmpresas'], $_POST['direccionEmpresas'], $pdo);
    $empresa->registerEmpresa($_FILES['imageEmpresas']);