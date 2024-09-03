<?php
require_once 'conexionSQL.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /interfaz/public-html/register.html');
    exit;
}

define("requirements", [
    "name" => "/^[a-zA-Z\s]{2,25}$/",
    "lastName" => "/^[a-zA-Z\s]{2,25}$/",
    "email" => "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+?.[a-zA-Z]{2,50}$/",
    "password" => "/^[\w\S-¿?^*´!|#$%&/{}()=><;:,.-]{8,50}$/",
    "day" => "/^[0-9\s]{2}$/",
    "month" => "/^[0-9\s]{2}$/",
    "year" => "/^[0-9\s]{4}$/"
]);

$userData = [
    "name" => testInput($_POST['name']),
    "lastName" => testInput($_POST['lastName']),
    "email" => testInput($_POST['email']),
    "day" => testInput($_POST['passwd']),
    "month" => testInput($_POST['passwd']),
    "year" => testInput($_POST['passwd']),
    "passwd" => $_POST['passwd']
];

foreach ($userData as $key => $value) {
    validateData($key);
}

$hashedPasswd = password_hash($passwd, PASSWORD_DEFAULT);
$sql = $conexion->prepare("INSERT INTO user (name, lastName, email, passwd) VALUES (?, ?, ?, ?)");
$sql->bind_param("ssss", $userData['name'], $userData['lastName'], $userData['email'], $hashedPasswd);

if ($sql->execute()) {
    $affectedRows = $sql->affected_rows;
    if ($affectedRows > 0) {
        $_SESSION['user'] = $name;
        header('Location: /interfaz/public-html/login.html');
        exit;
    } else {
        echo json_encode('Unable to register user');
    }
} else {
    echo json_encode('Unable to execute query');
}

$sql->close();
$conexion->close();