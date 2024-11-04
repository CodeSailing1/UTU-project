<?php
class PayPal
{
    private $clientId;
    private $clientIdSecret;

    public function __construct ($clientId, $clientIdSecret)
    {
        $this->clientId =  $clientId;
        $this->clientIdSecret = $clientIdSecret;
    }

    public function getAccessToken ()
    {
        // Credenciales de la aplicación PayPal (clientId y secret)

    $clientId = $this->clientId;
    $clientIdSecret = $this->clientIdSecret;
    // URL del endpoint de PayPal para obtener el token
        $url = "https://api.sandbox.paypal.com/v1/oauth2/token";
        $ch = curl_init(); // Inicializa una nueva sesión cURL
        // Configuración de cURL para la solicitud
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_USERPWD, "$clientId:$clientIdSecret");
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");

        // Ejecuta la solicitud
        $response = curl_exec($ch);

        // Manejo de errores de cURL
        if (curl_errno($ch)) {
            throw new Exception('Error en cURL: ' . curl_error($ch));
        }

        // Decodifica la respuesta JSON
        $result = json_decode($response);
        curl_close($ch);

        // Verificación y retorno del token de acceso
        if (isset($result->access_token)) {
            return $result->access_token;
        } else {
            throw new Exception('Error al obtener el token de acceso: ' . json_encode($result));
        }
    }
    public function createPayment($amount, $currency, $description)
    {
        $baseUrl = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'] . "/UTU-project/logica/paypal";
        $accessToken = $this->getAccessToken();
        $url = "https://api.sandbox.paypal.com/v1/payments/payment";
    
        $data = json_encode([
            "intent" => "sale",
            "payer" => ["payment_method" => "paypal"],
            "transactions" => [
                [
                    "amount" => ["total" => $amount, "currency" => $currency],
                "description" => $description
                ]
            ],
            "redirect_urls" => [
                "return_url" => $baseUrl . "/paypalPayment.php", // URL de retorno usando la variable base
                "cancel_url" => $baseUrl . "/cancel.html" // URL de cancelación usando la variable base
            ]
        ]);
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $accessToken"
        ]);
    
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception('Error en cURL: ' . curl_error($ch));
        }
    
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode !== 201) { // 201 Created is the expected response for successful payment creation
            throw new Exception('Error en la creación del pago: ' . $response);
        }
        $result = json_decode($response);
        curl_close($ch);
    
        if (!empty($result->links)) {
            foreach ($result->links as $link) {
                if ($link->rel == 'approval_url') {
                    return $link->href;
                }
            }
        } else {
            throw new Exception('Error en la creación del pago: no se recibieron enlaces');
        }
    }
    public function executePayment($paymentId, $payerId, $pdo, $idUsuario)
    {
        // Obtener el token de acceso
        $accessToken = $this->getAccessToken();

        // URL para ejecutar el pago, utilizando el ID del pago
        $url = "https://api.sandbox.paypal.com/v1/payments/payment/$paymentId/execute";

        // Datos a enviar en la solicitud
        $data = json_encode(["payer_id" => $payerId]); // El ID del pagador

        // Inicializar cURL
        $ch = curl_init();

    // Configurar opciones de cURL
        curl_setopt($ch, CURLOPT_URL, $url); // Establece la URL para la solicitud
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Para recibir la respuesta como string
        curl_setopt($ch, CURLOPT_POST, true); // Método POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // Datos a enviar
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json", // Tipo de contenido
            "Authorization: Bearer $accessToken" // Token de acceso para autenticación
        ]);

        // Ejecutar la solicitud
        $response = curl_exec($ch);

        // Manejo de errores de cURL
        if (curl_errno($ch)) {
            throw new Exception('Error en cURL: ' . curl_error($ch)); // Lanza una excepción si hay un error
        }

        // Decodificar la respuesta JSON
        $result = json_decode($response);

        // Cerrar la conexión cURL
        curl_close($ch);

        // Verificar si el pago fue aprobado
{
    // ...

    // Verificar si el pago fue aprobado
    if ($result->state == "approved") {
    require_once '../carritoDeCompras/carritoDeCompras.php';
    require_once '../historial/Historial.php';
    require_once '../pedido/Pedido.php';
    $metodoDePago = 'PayPal';
    $tipo = 'Delivery';
    $pedido = new Pedido($idUsuario, $metodoDePago, $tipo, $pdo );
    $carrito = new CarritoDeCompras($idUsuario, $pdo);

    $historial = new Historial($idUsuario, $pdo);

    try {
        foreach ($carrito->showCart() as $item) {
            $precio = $item['precioProducto'] * $item['cantidad'];
            $success = $historial->insertIntoHistorialCompra($item['idProducto'], $precio, $item['cantidad']);
            if (!$success) {
                throw new Exception('Failed to insert into purchase history for product ID: ' . $item['idProducto']);
            }
            $pedido->createPedido($item['idProducto']);
        }
        return $carrito->boughtProducts();

    } catch (Exception $e) {
        // Loguea el error o haz algo para manejar la excepción
        error_log($e->getMessage());
        return false;
    }
        } else {
            throw new Exception('Error en la confirmación del pago');
        }
    }
        }
    }