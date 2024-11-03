<?php
require_once '../DataValidator.php';
header('Content-Type: application/json');

class Admin
{
    private $pdo;
    private $idAdmin;
    private $nombreAdmin;
    private $emailAdmin;
    private $contraseniaAdmin;
    private $telefonoAdmin;

    public function __construct($idAdmin, $nombreAdmin, $emailAdmin, $contraseniaAdmin, $telefonoAdmin, $pdo)
    {
        $this->idAdmin = $idAdmin;
        $this->nombreAdmin = $nombreAdmin;
        $this->emailAdmin = $emailAdmin;
        $this->contraseniaAdmin = $contraseniaAdmin;
        $this->telefonoAdmin = $telefonoAdmin;
        $this->pdo = $pdo;
    }
    public function registerAdmin()
    {

        $validator = new DataValidator($this->pdo);
        $values = [
            'id' => false,
            'name' => false,
            'email' => false,
            'passwd' => false,
            'phone' => false
        ];
        $data = [
            'id' => $this->idAdmin,
            'name' => $this->nombreAdmin,
            'email' => $this->emailAdmin,
            'passwd' => $this->contraseniaAdmin,
            'phone' => $this->telefonoAdmin
        ];
        if (!$validator->existingEmail($this->emailAdmin)) {
            echo json_encode('ERROR: email already exists');
            return;
        }

        foreach ($data as $key => $value) {
            if (!$validator->dataValidator($key, $value)) {
                echo json_encode('ERROR: invalid data format');
                return;
            }

            $values[$key] = true;

            if (!in_array(false, $values)) {

                $hashedPasswd = password_hash($this->contraseniaAdmin, PASSWORD_DEFAULT);
                $stm = $this->pdo->prepare("INSERT INTO administrador (idAdmin, nombreAdmin, emailAdmin, telefonoAdmin, contraseniaAdmin) VALUES (:id, :nombre, :email, :phone, :passwd)");

                $stm->bindParam(':id', $this->idAdmin);
                $stm->bindParam(':nombre', $this->nombreAdmin);
                $stm->bindParam(':email', $this->emailAdmin);
                $stm->bindParam(':phone', $this->telefonoAdmin);
                $stm->bindParam(':passwd', $hashedPasswd);
                if ($stm->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Admin registered successfully']);
                } else {
                    echo json_encode('ERROR: Unable to register user');
                }
            }
        }
    }
    public function loginAdmin()
    {
        $validator = new DataValidator($this->pdo);
        $values = [
            'email' => false,
            'passwd' => false
        ];
        $userData = [
            "email" => $this -> emailAdmin,
            "passwd" => $this -> contraseniaAdmin
        ];
        foreach ($userData as $key => $value) {
            if(!$validator->dataValidator($key, $value)){
                echo json_encode('error: invalid data format');
                return;
            }
            $values[$key] = true;
            if(!in_array(false, $values))
            {
                $stm = $this->pdo->prepare("SELECT * FROM administrador WHERE emailAdmin = :email");
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
                    if (password_verify($userData['passwd'], $userRow['contraseniaAdmin'])) {    
                        if (session_status() === PHP_SESSION_NONE) {
                            session_start();
                        }
                        $_SESSION['idUsuario'] = $userRow['idUsuario'];
                        $_SESSION['nombre'] = $userRow['nombreUsuario'];
                        $_SESSION['email'] = $userRow['emailUsuario'];
                        $_SESSION['phone'] = $userRow['telefonoUsuario'];
                        $_SESSION['direction']  = $userRow['direccionUsuario'];
                        $_SESSION['imagenUsuario']  = $userRow['fotoDePerfilUsuario'];
                        $_SESSION['login'] = true;
                        echo json_encode(["success" => true, "message" => "User logged in successfully"]);
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
}
