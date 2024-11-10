<?php
class Pedido
{
    private $idUsuario;
    private $metodoDePago;
    private $tipo;
    private $pdo;
    public function __construct( $idUsuario, $metodoDePago, $tipo, $pdo)
    {
        $this->idUsuario = $idUsuario;
        $this->metodoDePago = $metodoDePago;
        $this->tipo = $tipo;
        $this->pdo = $pdo;
    }
    public function createPedido($idProducto)
    {
        // Insertar en la tabla 'pedido'
        $stm = $this->pdo->prepare('INSERT INTO pedido (idUsuario, metodoDePago, tipo) VALUES (:idUsuario, :metodoDePago, :tipo)');
        $stm->bindParam(':idUsuario', $this->idUsuario);
        $stm->bindParam(':metodoDePago', $this->metodoDePago);
        $stm->bindParam(':tipo', $this->tipo);

        if ($stm->execute()) {
            // Obtener el último ID insertado
            $idPedido = $this->pdo->lastInsertId();

            // Insertar en la tabla 'almacena'
            $stm = $this->pdo->prepare('INSERT INTO almacena (idPedido, idCarritoCompras) VALUES (:idPedido, :idCarritoCompras)');
            $stm->bindParam(':idPedido', $idPedido);
            $stm->bindParam(':idCarritoCompras', $this->idUsuario); // Verifica si realmente necesitas este valor

            if ($stm->execute()) {
                $stm = $this->pdo->prepare('INSERT INTO entrega (idProducto, idPedido) VALUES (:idProducto, :idPedido)');
                $stm->bindParam(':idProducto', $idProducto);
                $stm->bindParam(':idPedido', $idPedido);
                if($stm->execute())
                {
                    return true;
                }
            } else {
                // Manejar el error en la inserción de almacena
                error_log("Error al insertar en almacena: " . implode(", ", $stm->errorInfo()));
            }
        } else {
            // Manejar el error en la inserción de pedido
            error_log("Error al insertar en pedido: " . implode(", ", $stm->errorInfo()));
        }

        return false; // Fallo en la creación del pedido
    }

}