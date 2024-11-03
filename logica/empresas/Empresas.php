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
    public function __construct($idEmpresa, $nombreEmpresa, $emailEmpresa, $telefonoEmpresa, $contraseniaEmpresa, $direccionEmpresa, $pdo) {
        $this->idEmpresa = $idEmpresa;
        $this -> nombreEmpresa = $nombreEmpresa;
        $this -> emailEmpresa = $emailEmpresa;
        $this -> telefonoEmpresa = $telefonoEmpresa;
        $this -> contraseniaEmpresa = $contraseniaEmpresa;
        $this -> direccionEmpresa = $direccionEmpresa;
        $this -> pdo = $pdo;
    }
    public function getNombreEmpresa()
    {
        return $this -> nombreEmpresa;
    }
    public function getTelefonoEmpresa()
    {
        return $this -> telefonoEmpresa;
    }
    public function getEmailEmpresa()
    {
        return $this -> emailEmpresa;
    }
    public function getDireccionEmpresa()
    {
        return $this -> direccionEmpresa;
    }
    public function setNombreEmpresa($value)
    {
        $this -> nombreEmpresa = $value;   
    }   
    public function setEmailEmpresa($value)
    {
        $this -> emailEmpresa = $value;   
    }
    public function setTelefonoEmpresa($value)
    {
        $this -> telefonoEmpresa = $value;   
    }
    public function setDireccionEmpresa($value)
    {
        $this -> direccionEmpresa = $value;   
    }
    private function setIdEmpresa($value)
    {
        $this -> idEmpresa = $value;
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
            'name' => $this->nombreEmpresa ,
            'email' => $this->emailEmpresa,
            'passwd' => $this->contraseniaEmpresa,
            'phone' => $this->telefonoEmpresa,
            'direction' => $this->direccionEmpresa
        ];
        if (!$validator->existingEmailEmpresas($this->emailEmpresa)) {
            value:return json_encode(["success" => false, 'message' => "email already registered"]);
        }
        $fotoDePerfilEmpresa = $this->setImage($image);
        foreach ($data as $key => $value) {
            if(!$validator->dataValidator($key, $value))
            {
                echo json_encode('ERROR: invalid data format');
                return;
            }
            $values[$key] = true;
            if(!in_array(false, $values))
            {
                $hashedPasswd = password_hash($this -> contraseniaEmpresa, PASSWORD_DEFAULT);
                $stm = $this->pdo->prepare("INSERT INTO Empresa (nombreEmpresa, emailEmpresa, telefonoEmpresa, contraseniaEmpresa, direccionEmpresa, fotoDePerfilEmpresa) VALUES (:nombre, :email, :phone, :passwd,:direccion, :foto)");

        
                $stm->bindParam(':nombre', $this ->nombreEmpresa);
                $stm->bindParam(':email', $this -> emailEmpresa);
                $stm->bindParam(':phone', $this -> telefonoEmpresa);
                $stm->bindParam(':passwd', $hashedPasswd);
                $stm->bindParam(':direccion', $this->direccionEmpresa);
                $stm->bindParam(':foto', $fotoDePerfilEmpresa);
                if ($stm->execute()) 
                {
                    $stm =$this->pdo->prepare('SELECT idEmpresa FROM empresa WHERE emailEmpresa = :emailempresa');
                    $stm->bindParam(':emailempresa', $this->emailEmpresa);
                    if($stm->execute())
                    {
                        $dataEmpresa = $stm->fetch(PDO::FETCH_ASSOC);
                        $this->setIdEmpresa( $dataEmpresa['idEmpresa'] );
                        require_once '../inventario/inventarioEmpresas.php';
                        $carrito = new InventarioEmpresas($this->idEmpresa, $this->pdo);
                        $carrito->createInventario();
                        return json_encode(["success" => true, 'message'=> "User stored successfully"]);
                    }
                } else 
                {
                    return json_encode('ERROR: Unable to register user');
                }                
            }
        }
        
    }
    public function loginEmpresa()
    {
        $validator = new DataValidator($this->pdo);
        $values = [
            'email' => false,
            'passwd' => false
        ];
        $userData = [
            "email" => $this -> emailEmpresa,
            "passwd" => $this -> contraseniaEmpresa
        ];
        foreach ($userData as $key => $value) {
            if(!$validator->dataValidator($key, $value)){
                echo json_encode('error: invalid data format');
                return;
            }
            $values[$key] = true;
            if(!in_array(false, $values))
            {
                $stm = $this->pdo->prepare("SELECT * FROM Empresa WHERE emailEmpresa = :email");
                $stm->bindParam(':email', $userData['email']);
                if ($stm->execute()) {
                    $affectedRows = $stm->rowCount();
                    if ($affectedRows === 0) {
                        echo json_encode(["ERROR: " => "User not found"]);
                        exit();
                    }
                    $userRow = $stm->fetch(PDO::FETCH_ASSOC);
                    if (!$userRow) {
                        echo json_encode(['error' => 'User not found']);
                        exit;
                    }
                    if (password_verify($userData['passwd'], $userRow['contraseniaEmpresa'])) {    
                        if (session_status() === PHP_SESSION_NONE) {
                            session_start();
                        }
                        $_SESSION['id'] = $userRow['idEmpresa'];
                        $_SESSION['nombre'] = $userRow['nombreEmpresa'];
                        $_SESSION['email'] = $userRow['emailEmpresa'];
                        $_SESSION['imagenEmpresa']  = $userRow['fotoDePerfilEmpresa'];
                        $_SESSION['loginEmpresa'] = true;
                        echo json_encode(["success" => "User logged in successfully"]);
                        exit;
                    } else {
                        echo json_encode(['error' => 'Invalid password']);
                        exit;
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

    
    public function changeDataUserPasswd($camp, $value) {
        $validator = new DataValidator($this->pdo);
        if($camp === 'contraseniaEmpresa'){
            if(!$validator->dataValidator($camp, $value))
            {
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
    public function changeDataUserName($camp, $value) {
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
    public function changeDataUserEmail($camp, $value) {
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
    public function changeDataUserPhone($camp, $value) {
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
}