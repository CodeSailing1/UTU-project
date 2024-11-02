<?php
define('nameRequirements', '/^[a-zA-Z\s]{2,25}$/');
define('emailRequirementes', '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+?.[a-zA-Z]{2,50}$/');
define('passwdRequirements', '/^[\w\S\-¿\?\^*\´\|#$%&\/\{\}\(\)=><;:,\.\-]{8,50}$/');
define('phoneRequirementes', '/^[0-9\s]{9}$/');
define('directionRequirementes', '/^[a-zA-Z0-9\s]{2,25}$/');
class Usuario
{
    private $nombreUsuario;
    private $emailUsuario;
    private $contraseniaUsuario;
    private $telefonoUsuario;
    private $direccionUsuario;
    public function __construct($nombreUsuario, $emailUsuario, $telefonoUsuario, $contraseniaUsuario, $direccionUsuario) {
        $this -> nombreUsuario = $nombreUsuario;
        $this -> emailUsuario = $emailUsuario;
        $this -> telefonoUsuario = $telefonoUsuario;
        $this -> contraseniaUsuario = $contraseniaUsuario;
        $this -> direccionUsuario = $direccionUsuario;
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
    public function setContraseniaUsuario($value)
    {
        $this -> contraseniaUsuario = $value;   
    }
    public function setDireccionUsuario($value)
    {
        $this -> direccionUsuario = $value;   
    }

    public function registerUser()
    {
        require '../conexionSQL.php';
        $server = "localhost";
        $user = "root";
        $pass = "";
        $db = "sigtoclap";
        $values = [
            'name' => false,
            'email' => false,
            'passwd' => false,
            'phone' => false,
            'direction' =>  false
        ];
        $data = [
            'name' => $this->nombreUsuario ,
            'email' => $this->emailUsuario,
            'passwd' => $this->contraseniaUsuario,
            'phone' => $this->telefonoUsuario,
            'direction' => $this->direccionUsuario,
        ];
        $conection = new conexionSQL($server,  $db, $user, $pass);
        $pdo = $conection -> getPdo();
        
        foreach ($data as $key => $value) {
            if(!$this->dataValidator($key, $value))
            {
                echo json_encode('ERROR: invalid data format');
                return;
            }
            $values[$key] = true;
            if(!in_array(false, $values))
            {
                $hashedPasswd = password_hash($this -> contraseniaUsuario, PASSWORD_DEFAULT);
                $stm = $pdo->prepare("INSERT INTO usuario (nombreUsuario, emailUsuario, telefonoUsuario, contraseniaUsuario, direccionUsuario) VALUES (:nombre, :email, :phone, :passwd,:direccion)");
        
                $stm->bindParam(':nombre', $this ->nombreUsuario);
                $stm->bindParam(':email', $this -> emailUsuario);
                $stm->bindParam(':phone', $this -> telefonoUsuario);
                $stm->bindParam(':passwd', $hashedPasswd);
                $stm->bindParam(':direccion', $this->direccionUsuario);
                if ($stm->execute()) 
                {
                    return json_encode(["success" => "User stored successfully"]);
                } else 
                {
                    return json_encode('ERROR: Unable to register user');
                }                
            }
        }
        
    }
    public function loginUser()
    {
        require '../conexionSQL.php';
        $server = "localhost";
        $user = "root";
        $pass = "";
        $db = "sigtoclap";
        $values = [
            'email' => false,
            'passwd' => false
        ];
        $userData = [
            "email" => $this -> emailUsuario,
            "passwd" => $this -> contraseniaUsuario
        ];
        $conection = new conexionSQL($server,  $db, $user, $pass);
        $pdo = $conection -> getPdo();
        foreach ($userData as $key => $value) {
            if(!$this->dataValidator($key, $value)){
                echo json_encode('error: invalid data format');
                return;
            }
            $values[$key] = true;
        }
            if(!in_array(false, $values))
            {
                $stm = $pdo->prepare("SELECT * FROM usuario WHERE emailUsuario = :email");
                $stm->bindParam(':email', $userData['email']);
                if ($stm->execute()) {
                    $affectedRows = $stm->rowCount();
                    if ($affectedRows === 0) {
                        echo json_encode(["ERROR: " => "User not found"]);
                        exit();
                    }
                    $userRow = $stm->fetch(PDO::FETCH_ASSOC);
                    var_dump($userRow);
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
                        exit;
                    } else {
                        echo json_encode(['error' => 'Invalid password']);
                        exit;
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
    }

    public function dataValidator($key, $value)
    {
        switch ($key) 
        {
            case 'name':
                if(isset($key))
                {
                    if(preg_match(nameRequirements,  $value)){
                        return true;
                    }
                    return json_encode('ERROR: name does not math the requirements');
                }
                echo json_encode('ERROR: name does not exist');
                break;
            case 'email':
                if(isset($key))
                {
                    if(preg_match(emailRequirementes,  $value)){
                        return true;
                    }
                    return json_encode('ERROR: email does not math the requirements');
                }
                echo json_encode('ERROR: email does not exist');
                break;
            case 'passwd':
                if(isset($key))
                {
                    if(preg_match(passwdRequirements,  $value)){
                        return true;
                }    
                    return json_encode('ERROR: password does not math the requirements');
                }
                echo json_encode('ERROR: password does not exist');
                break;
            case 'phone':
                if(isset($key))
                {
                    if(preg_match(phoneRequirementes,  $value)){
                        return true;
                    }
                    return json_encode('ERROR: phone number does not math the requirements');
                }
                echo json_encode('ERROR: phone number does not exist');
                break;
            case 'direction':
                if(isset($key))
                {
                    if(preg_match(directionRequirementes,  $value)){
                        return true;
                    }
                    return json_encode('ERROR: direction does not math the requirements');
                }
                echo json_encode('ERROR: direction does not exist');
                break;  
            default:
                echo "Invalid data format for $key: " . json_encode($value);
                return false;
        }
    }
     public function changeDataUserPasswd($camp, $value) {
         if($camp === 'contraseniaUsuario'){
             if(!$this->dataValidator($camp, $value))
             {
                 echo json_encode('error: invalid data format');
                 return;
             }
             $hashedPaswd = password_hash($value, PASSWORD_DEFAULT);
             $emailUsuario = $this->getEmailUsuario();
             $stm = $this->pdo->prepare("UPDATE usuario SET contraseniaUsuario = :contraseniaUsuario WHERE emailUsuario = $emailUsuario; SELECT contraseniaUsuario FROM usuario WHERE emailUsuario = $emailUsuario");

             $stm->bindParam(':contraseniaUsuario', $$hashedPaswd);
             if($stm->execute())
             {
                
             }
             $this->setContraseniaUsuario($hashedPaswd);
         }
         public function changeDataUserName($camp, $value) {
            if ($camp === 'nombreUsuario') {
                if (!$this->dataValidator($camp, $value)) {
                    echo json_encode('error: invalid data format');
                    return;
                }
                $emailUsuario = $this->getEmailUsuario();
                $stm = $this->pdo->prepare("UPDATE usuario SET nombreUsuario = :nombreUsuario WHERE emailUsuario = :emailUsuario");
                
                $stm->bindParam(':nombreUsuario', $value);
                $stm->bindParam(':emailUsuario', $emailUsuario);
                if ($stm->execute()) {
                    echo json_encode('success: nombreUsuario updated');
                } else {
                    echo json_encode('error: update failed');
                }
                $this->setNombreUsuario($value);
            }
        }
        public function changeDataUserEmail($camp, $value) {
            if ($camp === 'emailUsuario') {
                if (!$this->dataValidator($camp, $value)) {
                    echo json_encode('error: invalid data format');
                    return;
                }
                $emailUsuario = $this->getEmailUsuario();
                $stm = $this->pdo->prepare("UPDATE usuario SET emailUsuario = :newEmailUsuario WHERE emailUsuario = :emailUsuario");
                
                $stm->bindParam(':newEmailUsuario', $value);
                $stm->bindParam(':emailUsuario', $emailUsuario);
                    
                    if ($stm->execute()) {
                        echo json_encode('success: emailUsuario updated');
                    } else {
                        echo json_encode('error: update failed');
                    }
                    $this->setEmailUsuario($value);
                }
        }
        public function changeDataUserPhone($camp, $value) {
            if ($camp === 'telefonoUsuario') {
                if (!$this->dataValidator($camp, $value)) {
                    echo json_encode('error: invalid data format');
                    return;
                }
                $emailUsuario = $this->getEmailUsuario();
                $stm = $this->pdo->prepare("UPDATE usuario SET telefonoUsuario = :newTelefonoUsuario WHERE emailUsuario = :emailUsuario");
                
                $stm->bindParam(':newTelefonoUsuario', $value);
                $stm->bindParam(':emailUsuario', $emailUsuario);
                    
                    if ($stm->execute()) {
                        echo json_encode('success: telefonoUsuario updated');
                    } else {
                        echo json_encode('error: update failed');
                    }
                    $this->setEmailUsuario($value);
                }
        }
     }
}