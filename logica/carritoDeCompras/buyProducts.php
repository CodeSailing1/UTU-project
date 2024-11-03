<?php
// Función para obtener el token de acceso de PayPal
require_once 'Paypal.php';
session_start();
header('Content-type: application/json');
const  API_CLIENT_ID = 'AbCe3asYQEKaml8QWJhxi5uPmY7MwZ1j7oi96cZMwitlnkAjPCLoO-UDNELu8RrvLTQTv70HdFI4Ixjc';
const  API_CLIENT_SECRET = 'EEmi8hRfz33y_jH0u7v5-WTKTcdHfFhhv02kxeHiocQS8qNbWgrXyTf3jN896XBGnQNROUplKPa9yhsv';
if($_SERVER['REQUEST_METHOD'] !== 'POST')
{
    http_response_code(405);
    return json_encode(['succes' => false, 'message' => 'Method not allowed']);
}

$data = json_decode(file_get_contents('php://input'), true);
if (!isset($data)) {
    echo json_encode(['error' => 'No data provided']);
    exit;
}

if (!isset($_SESSION['idUsuario'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

$paypal = new Paypal(API_CLIENT_ID,  API_CLIENT_SECRET);
$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['amount'], $input['currency'], $input['description'])) {
    $amount = $input['amount']; 
    $currency = $input['currency'];
    $description = $input['description'];
    try {
        $approvalUrl = $paypal->createPayment($amount, $currency, $description);
        echo json_encode(['approvalUrl' => $approvalUrl]);
    } catch (Exception $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Datos de entrada inválidos.']);
}