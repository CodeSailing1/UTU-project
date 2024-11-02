<?php
class conexionSQL 
{
    private $pdo;
    public function __construct(  $server, $database, $username, $password )
    {
        try {
            $this->pdo = new PDO("mysql:host=$server;dbname=$database", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Error al conectar a la base de datos: ' . $e->getMessage());
        }
    }
    public function getPdo()
    {
        return $this->pdo;
    }
}