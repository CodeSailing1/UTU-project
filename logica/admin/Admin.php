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
        // Ensure all input data is UTF-8 encoded
        $this->idAdmin = utf8_encode($idAdmin);
        $this->nombreAdmin = utf8_encode($nombreAdmin);
        $this->emailAdmin = utf8_encode($emailAdmin);
        $this->contraseniaAdmin = utf8_encode($contraseniaAdmin);
        $this->telefonoAdmin = utf8_encode($telefonoAdmin);
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

        // Check if email already exists
        if (!$validator->existingEmail($this->emailAdmin)) {
            echo json_encode('ERROR: email already exists');
            return;
        }

        // Validate all data fields
        foreach ($data as $key => $value) {
            if (!$validator->dataValidator($key, $value)) {
                echo json_encode('ERROR: invalid data format');
                return;
            }
            $values[$key] = true;
        }

        // Ensure all fields are valid before inserting
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

    public function loginAdmin()
    {
        $validator = new DataValidator($this->pdo);
        $values = [
            'email' => false,
            'passwd' => false
        ];
        $userData = [
            "email" => $this->emailAdmin,
            "passwd" => $this->contraseniaAdmin
        ];

        // Validate email and password format
        foreach ($userData as $key => $value) {
            if (!$validator->dataValidator($key, $value)) {
                echo json_encode('error: invalid data format');
                return;
            }
            $values[$key] = true;
        }

        // Ensure validation passes before querying
        if (!in_array(false, $values)) {
            $stm = $this->pdo->prepare("SELECT * FROM administrador WHERE emailAdmin = :email");
            $stm->bindParam(':email', $this->emailAdmin);
            $stm->execute();

            $userRow = $stm->fetch(PDO::FETCH_ASSOC);

            if (!$userRow) {
                echo json_encode(['error' => 'User not found']);
                return;
            }

            // Debugging: Display encoding and password data
            echo json_encode([
                'input_password_encoding' => mb_detect_encoding($this->contraseniaAdmin),
                'stored_hash_encoding' => mb_detect_encoding($userRow['contraseniaAdmin']),
                'stored_hash' => $userRow['contraseniaAdmin'],
                'password_verify' => password_verify($this->contraseniaAdmin, $userRow['contraseniaAdmin'])
            ]);

            // Password verification
            if (password_verify($this->contraseniaAdmin, $userRow['contraseniaAdmin'])) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['idAdmin'] = $userRow['idAdmin'];
                $_SESSION['nombre'] = $userRow['nombreAdmin'];
                $_SESSION['email'] = $userRow['emailAdmin'];
                $_SESSION['phone'] = $userRow['telefonoAdmin'];
                $_SESSION['login'] = true;

                echo json_encode(["success" => true, "message" => "User logged in successfully"]);
            } else {
                echo json_encode(['error' => 'Invalid password']);
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
}
