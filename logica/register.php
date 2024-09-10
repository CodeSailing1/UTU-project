<?php
require_once 'conexionSQL.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /interfaz/public-html/register.html');
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if ($data === null) {
    echo json_encode('Invalid JSON data');
    exit;
}

$userData = [
    "userName" => $data['name'],
    "email" => $data['email'],
    "passwd" => $data['password'],
    "phone" => $data['phone'],
    "direccion" => $data['direction']
];

$hashedPasswd = password_hash($userData['passwd'], PASSWORD_DEFAULT);

$stm = $pdo->prepare("INSERT INTO usuario (nombreUsuario, emailUsuario, telefonoUsuario, contraseniaUsuario, direccionUsuario) VALUES (:nombre, :email, :phone, :passwd, :direccion)");
$stm->bindParam(':nombre', $userData['userName']);
$stm->bindParam(':email', $userData['email']);
$stm->bindParam(':phone', $userData['phone']);
$stm->bindParam(':passwd', $hashedPasswd); 
$stm->bindParam(':direccion', $userData['direccion']); 

if ($stm->execute()) {
    $affectedRows = $stm->rowCount();
    if ($affectedRows > 0) {
        echo json_encode(["success" => "User stored successfully"]);
        exit;
    } else {
        echo json_encode('Unable to register user');
    }
} else {
    echo json_encode('Unable to execute query');
}