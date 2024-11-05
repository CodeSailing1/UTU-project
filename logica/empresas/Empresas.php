<?php
require_once '../DataValidator.php';


class Empresa
{
    private  $idEmpresa;

    private $nombreEmpresa;
    private $emailEmpresa;
    private $contraseniaEmpresa;
    private $telefonoEmpresa;
    private $direccionEmpresa;
    private $pdo;
    public function __construct($idEmpresa, $nombreEmpresa, $emailEmpresa, $telefonoEmpresa, $contraseniaEmpresa, $direccionEmpresa, $pdo)
    {
        $this->idEmpresa = $idEmpresa;
        $this->nombreEmpresa = $nombreEmpresa;
        $this->emailEmpresa = $emailEmpresa;
        $this->telefonoEmpresa = $telefonoEmpresa;
        $this->contraseniaEmpresa = $contraseniaEmpresa;
        $this->direccionEmpresa = $direccionEmpresa;
        $this->pdo = $pdo;
    }
    public function getNombreEmpresa()
    {
        return $this->nombreEmpresa;
    }
    public function getTelefonoEmpresa()
    {
        return $this->telefonoEmpresa;
    }
    public function getEmailEmpresa()
    {
        return $this->emailEmpresa;
    }
    public function getDireccionEmpresa()
    {
        return $this->direccionEmpresa;
    }
    public function setNombreEmpresa($value)
    {
        $this->nombreEmpresa = $value;
    }
    public function setEmailEmpresa($value)
    {
        $this->emailEmpresa = $value;
    }
    public function setTelefonoEmpresa($value)
    {
        $this->telefonoEmpresa = $value;
    }
    public function setDireccionEmpresa($value)
    {
        $this->direccionEmpresa = $value;
    }
    private function setIdEmpresa($value)
    {
        $this->idEmpresa = $value;
    }
    public function setImage($imageData)
    {
        require_once '../GetImage.php';
        $image = new GetImage();
        return $image->uploadImage($imageData);
    }
    public function registerEmpresa($image)
    {
        $validator = new DataValidator($this->pdo);
        $values = [
            'name' => false,
            'email' => false,
            'passwd' => false,
            'phone' => false,
            'direction' =>  false
        ];
        $data = [
            'name' => $this->nombreEmpresa,
            'email' => $this->emailEmpresa,
            'passwd' => $this->contraseniaEmpresa,
            'phone' => $this->telefonoEmpresa,
            'direction' => $this->direccionEmpresa
        ];
        if (!$validator->existingEmailEmpresas($this->emailEmpresa)) {
            value:
            return json_encode(["success" => false, 'message' => "email already registered"]);
        }
        $fotoDePerfilEmpresa = $this->setImage($image);
        foreach ($data as $key => $value) {
            if (!$validator->dataValidator($key, $value)) {
                echo json_encode('ERROR: invalid data format');
                return;
            }
            $values[$key] = true;
            if (!in_array(false, $values)) {
                $hashedPasswd = password_hash($this->contraseniaEmpresa, PASSWORD_DEFAULT);
                $stm = $this->pdo->prepare("INSERT INTO Empresa (nombreEmpresa, emailEmpresa, telefonoEmpresa, contraseniaEmpresa, direccionEmpresa, fotoDePerfilEmpresa) VALUES (:nombre, :email, :phone, :passwd,:direccion, :foto)");


                $stm->bindParam(':nombre', $this->nombreEmpresa);
                $stm->bindParam(':email', $this->emailEmpresa);
                $stm->bindParam(':phone', $this->telefonoEmpresa);
                $stm->bindParam(':passwd', $hashedPasswd);
                $stm->bindParam(':direccion', $this->direccionEmpresa);
                $stm->bindParam(':foto', $fotoDePerfilEmpresa);
                if ($stm->execute()) {
                    $stm = $this->pdo->prepare('SELECT idEmpresa FROM empresa WHERE emailEmpresa = :emailempresa');
                    $stm->bindParam(':emailempresa', $this->emailEmpresa);
                    if ($stm->execute()) {
                        $dataEmpresa = $stm->fetch(PDO::FETCH_ASSOC);
                        $this->setIdEmpresa($dataEmpresa['idEmpresa']);
                        require_once '../inventario/inventarioEmpresas.php';
                        $carrito = new InventarioEmpresas($this->idEmpresa, $this->pdo);
                        $carrito->createInventario();
                        return json_encode(["success" => true, 'message' => "User stored successfully"]);
                    }
                } else {
                    return json_encode('ERROR: Unable to register user');
                }
            }
        }
    }
    public function loginEmpresa()
{
    header('Content-Type: application/json');  // Encabezado JSON
    
    $validator = new DataValidator($this->pdo);
    $values = [
        'email' => false,
        'passwd' => false
    ];
    $userData = [
        "email" => $this->emailEmpresa,
        "passwd" => $this->contraseniaEmpresa
    ];

    // Validación de datos
    foreach ($userData as $key => $value) {
        if (!$validator->dataValidator($key, $value)) {
            echo json_encode(['error' => 'Invalid data format']);
            return;
        }
        $values[$key] = true;
    }

    // Solo continúa si todos los datos son válidos
    if (in_array(false, $values)) {
        echo json_encode(['error' => 'Invalid data']);
        return;
    }

    // Consulta SQL
    $stm = $this->pdo->prepare("SELECT * FROM Empresa WHERE emailEmpresa = :email");
    $stm->bindParam(':email', $userData['email']);
    if ($stm->execute()) {
        $affectedRows = $stm->rowCount();
        if ($affectedRows === 0) {
            echo json_encode(['error' => 'User not found']);
            return;
        }

        $userRow = $stm->fetch(PDO::FETCH_ASSOC);
        if (!$userRow) {
            echo json_encode(['error' => 'User not found']);
            return;
        }

        // Verificar la contraseña
        if (password_verify($userData['passwd'], $userRow['contraseniaEmpresa'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['id'] = $userRow['idEmpresa'];
            $_SESSION['nombre'] = $userRow['nombreEmpresa'];
            $_SESSION['email'] = $userRow['emailEmpresa'];
            $_SESSION['imagenEmpresa'] = $userRow['fotoDePerfilEmpresa'];
            $_SESSION['direction'] = $userRow['direccionEmpresa'];
            $_SESSION['phone'] = $userRow['telefonoEmpresa'];
            $_SESSION['loginEmpresa'] = true;
            
            echo json_encode(['success' => 'User logged in successfully']);
        } else {
            echo json_encode(['error' => 'Invalid password']);
        }
    } else {
        echo json_encode(['error' => 'Database error']);
    }
}

    public function logoutEmpresa()
    {
        try {
            unset($_SESSION['loginEmpresa']);
            session_destroy();
            echo json_encode(['success' => true, 'message' => 'User logged out successfully']);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Internal server error']);
        }
        exit;
    }


    public function changeDataUserPasswd($camp, $value)
    {
        $validator = new DataValidator($this->pdo);
        if ($camp === 'contraseniaEmpresa') {
            if (!$validator->dataValidator($camp, $value)) {
                echo json_encode('error: invalid data format');
                return;
            }
            $hashedPaswd = password_hash($value, PASSWORD_DEFAULT);
            $emailEmpresa = $this->getEmailEmpresa();
            $stm = $this->pdo->prepare("UPDATE Empresa SET contraseniaEmpresa = :contraseniaEmpresa WHERE emailEmpresa = $emailEmpresa; SELECT contraseniaEmpresa FROM Empresa WHERE emailEmpresa = $emailEmpresa");

            $stm->bindParam(':contraseniaEmpresa', $$hashedPaswd);
            $stm->execute();
        }
    }
    public function changeDataUserName($camp, $value)
    {
        $validator = new DataValidator($this->pdo);
        if ($camp === 'nombreEmpresa') {
            if (!$validator->dataValidator($camp, $value)) {
                echo json_encode('error: invalid data format');
                return;
            }
            $emailEmpresa = $this->getEmailEmpresa();
            $stm = $this->pdo->prepare("UPDATE Empresa SET nombreEmpresa = :nombreEmpresa WHERE emailEmpresa = :emailEmpresa");

            $stm->bindParam(':nombreEmpresa', $value);
            $stm->bindParam(':emailEmpresa', $emailEmpresa);
            if ($stm->execute()) {
                echo json_encode('success: nombreEmpresa updated');
            } else {
                echo json_encode('error: update failed');
            }
            $this->setNombreEmpresa($value);
        }
    }
    public function changeDataUserEmail($camp, $value)
    {
        $validator = new DataValidator($this->pdo);
        if ($camp === 'emailEmpresa') {
            if (!$validator->dataValidator($camp, $value)) {
                echo json_encode('error: invalid data format');
                return;
            }
            $emailEmpresa = $this->getEmailEmpresa();
            $stm = $this->pdo->prepare("UPDATE Empresa SET emailEmpresa = :newEmailEmpresa WHERE emailEmpresa = :emailEmpresa");

            $stm->bindParam(':newEmailEmpresa', $value);
            $stm->bindParam(':emailEmpresa', $emailEmpresa);

            if ($stm->execute()) {
                echo json_encode('success: emailEmpresa updated');
            } else {
                echo json_encode('error: update failed');
            }
            $this->setEmailEmpresa($value);
        }
    }
    public function changeDataUserPhone($camp, $value)
    {
        $validator = new DataValidator($this->pdo);
        if ($camp === 'telefonoEmpresa') {
            if (!$validator->dataValidator($camp, $value)) {
                echo json_encode('error: invalid data format');
                return;
            }
            $emailEmpresa = $this->getEmailEmpresa();
            $stm = $this->pdo->prepare("UPDATE Empresa SET telefonoEmpresa = :newTelefonoEmpresa WHERE emailEmpresa = :emailEmpresa");
            $stm->bindParam(':newTelefonoEmpresa', $value);
            $stm->bindParam(':emailEmpresa', $emailEmpresa);
            if ($stm->execute()) {
                echo json_encode('success: telefonoEmpresa updated');
            } else {
                echo json_encode('error: update failed');
            }
            $this->setEmailEmpresa($value);
        }
    }
    public function rankingProductosMasVendidos($idEmpresa)
    {

        $stm = $this->pdo->prepare('SELECT P.nombreProducto, P.ventasProducto
                                        FROM Producto P
                                        JOIN Contiene C ON P.idProducto = C.idProducto
                                        JOIN Inventario I ON C.idInventario = I.idInventario
                                        WHERE I.idEmpresa = :idEmpresa
                                        AND YEAR(fechaProducto) = YEAR(CURDATE())
                                        ORDER BY P.ventasProducto DESC
                                    ;');
        $stm->bindParam(':idEmpresa', $idEmpresa);
        if ($stm->execute()) {
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    public function rankingProductosMenosVendidos($idEmpresa)
    {

        $stm = $this->pdo->prepare('SELECT P.nombreProducto, P.ventasProducto
                                    FROM Producto P
                                    JOIN Contiene C ON P.idProducto = C.idProducto
                                    JOIN Inventario I ON C.idInventario = I.idInventario
                                    WHERE I.idEmpresa = :idEmpresa
                                        AND YEAR(fechaProducto) = YEAR(CURDATE())
                                        ORDER BY P.ventasProducto ASC
                                    ;');
        $stm->bindParam(':idEmpresa', $idEmpresa);
        if ($stm->execute()) {
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    public function productosConMenosStock($idEmpresa)
    {

        $stm = $this->pdo->prepare('SELECT P.nombreProducto, P.idProducto, C.stock
                                    FROM Producto P
                                    JOIN Contiene C ON P.idProducto = C.idProducto
                                    JOIN Inventario I ON C.idInventario = I.idInventario
                                    WHERE I.idEmpresa = :idEmpresa
                                    ORDER BY C.stock ASC;');
        $stm->bindParam(':idEmpresa', $idEmpresa);
        if ($stm->execute()) {
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    public function personasMasFieles($idEmpresa)
    {

        $stm = $this->pdo->prepare('SELECT U.nombreUsuario, sum(g.cantidad) AS visitas
                                    FROM usuario u
                                    join historial h on u.idUsuario = h.idHistorial
                                    JOIN guarda g ON h.idHistorial = g.idHistorial
                                    JOIN producto p ON g.idProducto = p.idProducto
                                    JOIN contiene c ON p.idProducto = c.idProducto
                                    JOIN inventario i ON c.idInventario = i.idInventario
                                    JOIN empresa e ON i.idInventario = e.idEmpresa
                                    WHERE g.tipo = "Visita"
                                    AND e.idEmpresa = :idEmpresa
                                    GROUP BY U.nombreUsuario
                                    ORDER BY visitas DESC
');
        $stm->bindParam(':idEmpresa', $idEmpresa);
        if ($stm->execute()) {
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    public function visitasPorProducto($idEmpresa)
    {

        $stm = $this->pdo->prepare('SELECT P.nombreProducto, P.visitasProducto
                                    FROM Producto P
                                    JOIN Contiene C ON P.idProducto = C.idProducto
                                    JOIN Inventario I ON C.idInventario = I.idInventario
                                    WHERE I.idEmpresa = :idEmpresa
                                    ORDER BY P.visitasProducto DESC

');
        $stm->bindParam(':idEmpresa', $idEmpresa);
        if ($stm->execute()) {
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    public function totalVentasAnio($idEmpresa)
    {
        $anio = date('Y');
        $stm = $this->pdo->prepare('SELECT MONTH(G.productoHistorial) AS mes, SUM(G.cantidad) AS totalVentas
                                    FROM Guarda G
                                    JOIN Historial H ON G.idHistorial = H.idHistorial
                                    JOIN Usuario U ON H.idUsuario = U.idUsuario
                                    JOIN Producto P ON G.idProducto = P.idProducto
                                    JOIN Contiene C ON P.idProducto = C.idProducto
                                    JOIN Inventario I ON C.idInventario = I.idInventario
                                    WHERE I.idEmpresa = :idEmpresa
                                    AND YEAR(G.productoHistorial) = :anio
                                    AND G.tipo = "Compra"
                                    GROUP BY MONTH(G.productoHistorial)
                                    ORDER BY mes;



');
        $stm->bindParam(':idEmpresa', $idEmpresa);
        $stm->bindParam(':anio', $anio);
        if ($stm->execute()) {
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    public function comentariosMasRecientes($idEmpresa)
    {
        $anio = date('Y');
        $stm = $this->pdo->prepare('SELECT CMT.textoComentario, CMT.fechaComentario, U.nombreUsuario, P.nombreProducto, P.idProducto
                                    FROM Comenta CMT
                                    JOIN Usuario U ON CMT.idUsuario = U.idUsuario
                                    JOIN Producto P ON CMT.idProducto = P.idProducto
                                    JOIN Contiene C ON P.idProducto = C.idProducto
                                    JOIN Inventario I ON C.idInventario = I.idInventario
                                    WHERE I.idEmpresa = :idEmpresa
                                    ORDER BY CMT.fechaComentario DESC
');
        $stm->bindParam(':idEmpresa', $idEmpresa);
        if ($stm->execute()) {
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    public function changeDataEmpresaPasswd($pass, $conf)
    {
        $validator = new DataValidator($this->pdo);
        $passwords = ['pass' => $pass, 'confirm' => $conf];
        foreach ($passwords as $key => $value) {
            if (!$validator->dataValidator($key, $value)) {
                echo json_encode('error: invalid data format');
                return;
            }
        }
        if (!$validator->passWordValidator($pass, $conf)) {
            echo json_encode('error: passwords does not match');
            return;
        }
        $stm = $this->pdo->prepare('SELECT emailUsuario FROM usuario WHERE idUsuario = :idUsuario');
        $stm->bindParam(':idUsuario', $this->idEmpresa);
        if ($stm->execute()) {
            $email = $stm->fetch(PDO::FETCH_ASSOC);
            $hashedPaswd = password_hash($value, PASSWORD_DEFAULT);
            $emailUsuario = $this->getEmailEmpresa();
            $stm = $this->pdo->prepare("UPDATE usuario SET contraseniaUsuario = :contraseniaUsuario WHERE emailUsuario = :email; SELECT contraseniaUsuario FROM usuario WHERE emailUsuario = $emailUsuario");
            $stm->bindParam(':email', $email['emailUsuario']);
            $stm->bindParam(':contraseniaUsuario', $hashedPaswd);
            if ($stm->execute()) {
                return true;
            }
            return false;
        }
    }
}
