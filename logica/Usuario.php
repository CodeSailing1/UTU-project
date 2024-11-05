<?php
require_once '../conexionSQL.php';
require_once '../DataValidator.php';
header('Content-Type: application/json');


class Usuario
{
    private $idUsuario;
    private $nombreUsuario;
    private $emailUsuario;
    private $contraseniaUsuario;
    private $telefonoUsuario;
    private $direccionUsuario;
    private $pdo;
    public function __construct($idUsuario, $nombreUsuario, $emailUsuario, $telefonoUsuario, $contraseniaUsuario, $direccionUsuario, $pdo) {
        $this -> idUsuario = $idUsuario;
        $this -> nombreUsuario = $nombreUsuario;
        $this -> emailUsuario = $emailUsuario;
        $this -> telefonoUsuario = $telefonoUsuario;
        $this -> contraseniaUsuario = $contraseniaUsuario;
        $this -> direccionUsuario = $direccionUsuario;
        $this -> pdo = $pdo;
    }
    public function getIdUsuario()
    {
        return $this -> idUsuario;

    }
    public function getNombreUsuario()
    {
        return $this -> nombreUsuario;
    }
    public function getTelefonoUsuario()
    {
        return $this -> telefonoUsuario;
    }
    public function getEmailUsuario()
    {
        return $this -> emailUsuario;
    }
    public function getDireccionUsuario()
    {
        return $this -> direccionUsuario;
    }
    public function setNombreUsuario($value)
    {
        $this -> nombreUsuario = $value;   
    }   
    public function setEmailUsuario($value)
    {
        $this -> emailUsuario = $value;   
    }
    public function setTelefonoUsuario($value)
    {
        $this -> telefonoUsuario = $value;   
    }
    public function setDireccionUsuario($value)
    {
        $this -> direccionUsuario = $value;   
    }
    public function setImage($imageData)
    {
        require_once '../GetImage.php';
        $image = new GetImage();
        return $image->uploadImage($imageData);
    }
    public function setIdUsuario($idUsuario)
    {
        $this -> idUsuario = $idUsuario;
    }
    
    public function registerUser($imageData)
    {

        $validator = new DataValidator($this->pdo);
        $values = [
            'name' => false,
            'email' => false,
            'passwd' => false,
            'phone' => false,
            'direction' =>  false,
        ];
        $data = [
            'name' => $this->nombreUsuario ,
            'email' => $this->emailUsuario,
            'passwd' => $this->contraseniaUsuario,
            'phone' => $this->telefonoUsuario,
            'direction' => $this->direccionUsuario,
        ];
        if (!$validator->existingEmail($this->emailUsuario)) {
            echo json_encode('ERROR: email already exists');
            return;
        }

        $fotoDePerfilUsuario = $this->setImage($imageData);
        foreach ($data as $key => $value) {
            if(!$validator->dataValidator($key, $value))
            {
                echo json_encode('ERROR: invalid data format');
                return;
            }
            
            $values[$key] = true;
            
            if(!in_array(false, $values))
            {
                
                $hashedPasswd = password_hash($this -> contraseniaUsuario, PASSWORD_DEFAULT);
                $stm = $this->pdo->prepare("INSERT INTO Usuario (nombreUsuario, emailUsuario, telefonoUsuario, contraseniaUsuario, direccionUsuario, fotoDePerfilUsuario) VALUES (:nombre, :email, :phone, :passwd,:direccion, :foto)");

        
                $stm->bindParam(':nombre', $this ->nombreUsuario);
                $stm->bindParam(':email', $this -> emailUsuario);
                $stm->bindParam(':phone', $this -> telefonoUsuario);
                $stm->bindParam(':passwd', $hashedPasswd);
                $stm->bindParam(':direccion', $this->direccionUsuario);
                $stm->bindParam(':foto', $fotoDePerfilUsuario);
                if ($stm->execute()) 
                {
                    $stm =$this->pdo->prepare('SELECT idUsuario FROM usuario WHERE emailUsuario = :emailUsuario');
                    $stm->bindParam(':emailUsuario', $this->emailUsuario);
                    if($stm->execute())
                    {
                        $dataUsuario = $stm->fetch(PDO::FETCH_ASSOC);
                        $this->setIdUsuario( $dataUsuario['idUsuario'] );
                        require_once '../historial/Historial.php';
                        $historial = new Historial($this->idUsuario, $this->pdo);
                        if($historial->createHistorial())
                        {
                            require_once '../carritoDeCompras/carritoDeCompras.php';
                            $carrito = new CarritoDeCompras($this->idUsuario, $this->pdo);
                            $carritoCrear = $carrito->crearCarrito();
                            return json_encode($carritoCrear);
                        }
                        
                    }
                    
                } else 
                {
                    echo json_encode('ERROR: Unable to register user');
                }                

            }

        }
    }
    public function loginUser()
{
    ob_clean();  // Clear any buffered output at the start
    $validator = new DataValidator($this->pdo);
    $values = [
        'email' => false,
        'passwd' => false
    ];
    $userData = [
        "email" => $this->emailUsuario,
        "passwd" => $this->contraseniaUsuario
    ];

    foreach ($userData as $key => $value) {
        if (!$validator->dataValidator($key, $value)) {
            echo json_encode(['error' => 'Invalid data format']);
            exit();
        }
        $values[$key] = true;

        // Check if validation passed for all fields
        if (!in_array(false, $values)) {
            $stm = $this->pdo->prepare("SELECT * FROM usuario WHERE emailUsuario = :email");
            $stm->bindParam(':email', $userData['email']);
            
            if ($stm->execute()) {
                if ($stm->rowCount() === 0) {
                    echo json_encode(["error" => "User not found"]);
                    exit();
                }
                
                $userRow = $stm->fetch(PDO::FETCH_ASSOC);
                if (!$userRow) {
                    echo json_encode(['error' => 'User not found']);
                    exit();
                }
                
                if (password_verify($userData['passwd'], $userRow['contraseniaUsuario'])) {
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    
                    $_SESSION['idUsuario'] = $userRow['idUsuario'];
                    $_SESSION['nombre'] = $userRow['nombreUsuario'];
                    $_SESSION['email'] = $userRow['emailUsuario'];
                    $_SESSION['phone'] = $userRow['telefonoUsuario'];
                    $_SESSION['direction'] = $userRow['direccionUsuario'];
                    $_SESSION['imagenUsuario'] = $userRow['fotoDePerfilUsuario'];
                    $_SESSION['login'] = true;

                    echo json_encode(["success" => "User logged in successfully"]);
                    exit();
                } else {
                    echo json_encode(['error' => 'Invalid password']);
                    exit();
                }
            }
        }
    }
}

    public function logoutUser()
    {
        try {
            unset($_SESSION['login']);
            session_destroy();
            echo json_encode(['success' => true, 'message' => 'User logged out successfully']);
        } catch (Exception $e) {
            echo json_encode(['error' => 'Internal server error']);
        }
        exit;
    }
    public function changeDataUserPasswd($pass, $conf) {
        $validator = new DataValidator($this->pdo);
        $passwords = ['pass' => $pass, 'confirm' => $conf];
            foreach ($passwords as $key => $value) {
                if(!$validator->dataValidator($key, $value))
                {
                    echo json_encode('error: invalid data format');
                    return;
                }
            }
            if(!$validator->passWordValidator($pass, $conf))
            {
                echo json_encode('error: passwords does not match');
                return;
            }
            $stm = $this->pdo->prepare('SELECT emailUsuario FROM usuario WHERE idUsuario = :idUsuario');
            $stm->bindParam(':idUsuario', $this->idUsuario);
            if($stm->execute())
            {
                $email = $stm->fetch(PDO::FETCH_ASSOC);
                $hashedPaswd = password_hash($value, PASSWORD_DEFAULT);
                $emailUsuario = $this->getEmailUsuario();
                $stm = $this->pdo->prepare("UPDATE usuario SET contraseniaUsuario = :contraseniaUsuario WHERE emailUsuario = :email; SELECT contraseniaUsuario FROM usuario WHERE emailUsuario = $emailUsuario");
                $stm->bindParam(':email', $email['emailUsuario']);
                $stm->bindParam(':contraseniaUsuario', $hashedPaswd);
                if($stm->execute())
                {
                    return true;
                }
                return false;
            }
        }
}
    
