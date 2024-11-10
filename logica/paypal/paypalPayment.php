<?php
// Función para obtener el token de acceso de PayPal
require_once 'Paypal.php';
require_once '../conexionSQL.php';
header('Content-type: application/json');
session_start();
$idUsuario = $_SESSION['idUsuario'];
const  API_CLIENT_ID = 'AbCe3asYQEKaml8QWJhxi5uPmY7MwZ1j7oi96cZMwitlnkAjPCLoO-UDNELu8RrvLTQTv70HdFI4Ixjc';
const  API_CLIENT_SECRET = 'EEmi8hRfz33y_jH0u7v5-WTKTcdHfFhhv02kxeHiocQS8qNbWgrXyTf3jN896XBGnQNROUplKPa9yhsv';
$server = 'localhost';
$username = 'root';
$password = '';
$database = 'sigto';
$ConexionDB = new conexionSQL($server, $database, $username, $password);
$pdo = $ConexionDB->getPdo();
$paymentId = $_GET['paymentId']; // ID del pago obtenido de la URL
$payerId = $_GET['PayerID']; // ID del pagador obtenido de la URL
$paypal = new Paypal(API_CLIENT_ID,  API_CLIENT_SECRET);
if($paypal->executePayment($paymentId, $payerId, $pdo, $idUsuario))
{
    echo  json_encode(['success' => true, 'message' => 'Pago exitoso']);
    header("location: /UTU-project/interfaz/public-html/index.php");
}
else 
{
    header("location: /UTU-project/interfaz/public-html/nose.php");

}