<?php
require_once 'conexionSQL.php'; // Added semicolon

header('Content-Type: application/json');
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

if ($data === null) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON data']);
    exit;
}

if (!isset($data['login'])) {
    http_response_code(401);
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

try {
    unset($_SESSION['login']);
    session_destroy();
    http_response_code(200);
    echo json_encode(['success' => true, 'message' => 'User logged out successfully']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error']);
}

exit;