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

if (!isset($data['emailUsuario'], $data['contraseniaUsuario'])) {
    echo json_encode('Invalid JSON data');
    exit;
}

$userData = [
    "email" => $data['emailUsuario'],
    "passwd" => $data['contraseniaUsuario']
];

$stm = $pdo->prepare("SELECT * FROM usuario WHERE emailUsuario = :email");
$stm->bindParam(':email', $userData['email']);

if ($stm->execute()) {
    $affectedRows = $stm->rowCount();
    if ($affectedRows === 0) {
        echo json_encode(["ERROR: " => "User not found"]);
        exit();
    }

    $userRow = $stm->fetch();
    
    if (!$userRow) {
        echo json_encode(['error' => 'User not found']);
        exit;
    }
    
    if (password_verify($userData['passwd'], $userRow['contraseniaUsuario'])) {
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['id'] = $userRow['idUsuario'];
        $_SESSION['nombre'] = $userRow['nombreUsuario'];
        $_SESSION['email'] = $userRow['emailUsuario'];
        $_SESSION['login'] = true;

        echo json_encode(["success" => "User logged in successfully"]);
        exit();

    } else {
        echo json_encode(['error' => 'Invalid password']);
        exit;
    }
    
}