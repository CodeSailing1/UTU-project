<?php
class DataValidator
{
    private const nameRequirements = '/^[a-zA-Z\s]{2,25}$/';
    private const emailRequirementes = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,50}$/';
    private const passwdRequirements = '/^[\w\S\-¿\?\^*\´\|#$%&\/\{\}\(\)=><;:,\.\-]{8,50}$/';
    private const phoneRequirementes = '/^[0-9\s]{9}$/';
    private const directionRequirementes = '/^[a-zA-Z0-9\s]{2,25}$/';
    private const amountAndCurrency = '/^[0-9\s]{9}$/';
    private const description = '/^[a-zA-Z]/';
    private $pdo;
    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    private function validateRegex($pattern, $value, $type)
    {
        if (preg_match($pattern, $value)) {
            return true;
        }
        return json_encode("ERROR: $type does not match the requirements");
    }

    public function dataValidator($key, $value)
    {
        switch ($key) {
            case 'name':
                return $this->validateRegex(self::nameRequirements, $value, 'name');
            case 'email':
                return $this->validateRegex(self::emailRequirementes, $value, 'email');
            case 'passwd':
                return $this->validateRegex(self::passwdRequirements, $value, 'password');
            case 'conf':
                return $this->validateRegex(self::passwdRequirements, $value, 'password');
            case 'phone':
                return $this->validateRegex(self::phoneRequirementes, $value, 'phone number');
            case 'direction':
                return $this->validateRegex(self::directionRequirementes, $value, 'direction');
            default:
                return json_encode("Invalid data format for $key: " . json_encode($value));
        }
    }
    public function passWordValidator($pass, $conf)
    {
        if($pass !== $conf)
        {
            return false;
        }
        return true;
    }
    
    public function existingEmail($email)
    {
        $stm = $this->pdo->prepare("SELECT emailUsuario FROM usuario WHERE emailUsuario = :email");
        $stm->bindParam(':email', $email);
        $stm->execute();
        $affectedRow = $stm->rowCount();
        return $affectedRow === 0 ;
    }
    public function existingEmailEmpresas($email)
    {
        $stm = $this->pdo->prepare("SELECT emailEmpresa FROM empresa WHERE emailEmpresa = :email");
        $stm->bindParam(':email', $email);
        $stm->execute();
        $affectedRow = $stm->rowCount();
        return $affectedRow === 0 ;
    }
}