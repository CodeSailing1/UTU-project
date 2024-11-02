<?php
class Historial 
{
    private $idUsuario;
    private $pdo;
    public function __construct($idUsuario, $pdo)
    {
        $this->idUsuario = $idUsuario;
        $this->pdo = $pdo;
    }
    public function createHistorial()
    {
        $fecha = date("Y-m-d H:m:s");
        $stm = $this->pdo->prepare('INSERT INTO historial (idHistorial, idUsuario, fechaHistorial) VALUES (:idHistorial,  :idUsuario, :fecha)');
        $stm->bindParam(':idHistorial', $this->idUsuario) ;
        $stm->bindParam(':idUsuario', $this->idUsuario) ;
        $stm->bindParam(':fecha', $fecha) ;
        if($stm->execute())
        {
            return true;
        }
        return false;
    }
    public function insertIntoHistorialCompra($idProducto, $PrecioCompra, $cantidad)
    {
        $tipo = 'Compra';

        // Fetch existing record for the given product and user
        $stm = $this->pdo->prepare('SELECT cantidad, precioCompra, productoHistorial FROM Guarda WHERE idHistorial = :idUsuario AND idProducto = :idProducto AND tipo = :tipo');
        $stm->bindParam(':idUsuario', $this->idUsuario);
        $stm->bindParam(':idProducto', $idProducto);
        $stm->bindParam(':tipo', $tipo);
        $stm->execute();

        if ($stm->rowCount() !== 0) {
            $rowData = $stm->fetch(PDO::FETCH_ASSOC);
            $newQuantity = $rowData['cantidad'] + $cantidad; // Increment existing quantity
            $newPrice = $rowData['precioCompra'] + $PrecioCompra; // Increment total price

            // Check if the purchase was made on the same day
            $fechaCompra = new DateTime($rowData['productoHistorial']);
            $fechaHoy = new DateTime();

            if ($fechaCompra->format('Y-m-d') === $fechaHoy->format('Y-m-d')) {
                // Update the existing record
                $stm = $this->pdo->prepare('UPDATE Guarda SET cantidad = :cantidad, precioCompra = :precioCompra, productoHistorial = :fecha WHERE idHistorial = :idUsuario AND idProducto = :idProducto AND tipo = :tipo');
                $stm->bindParam(':cantidad', $newQuantity);
                $stm->bindParam(':precioCompra', $newPrice);
                $stm->bindParam(':idUsuario', $this->idUsuario);
                $stm->bindParam(':idProducto', $idProducto);
                $stm->bindParam(':fecha', $fechaCompra->format('Y-m-d H:i:s'));
                $stm->bindParam(':tipo', $tipo);

                if ($stm->execute()) {
                    // Additional operation after update
                    if ($this->insertBoughtIntoProducto($idProducto, $cantidad)) {
                        require_once '../inventario/InventarioEmpresas.php';
                        $inventarioEmpresa = new InventarioEmpresas(null, $this->pdo);
                        return $inventarioEmpresa->deleteProductAfterBought($idProducto, $cantidad);
                    }
                }
            }
            return false; // If the update failed
        } else {
            // New entry case
            $fecha = date("Y-m-d H:i:s");
            $stm = $this->pdo->prepare('INSERT INTO Guarda (idHistorial, idProducto, precioCompra, cantidad, tipo, productoHistorial) VALUES (:idHistorial, :idProducto, :precioCompra, :cantidad, :tipo, :productoHistorial)');
            $stm->bindParam(':idHistorial', $this->idUsuario);
            $stm->bindParam(':idProducto', $idProducto);
            $stm->bindParam(':precioCompra', $PrecioCompra);
            $stm->bindParam(':cantidad', $cantidad);
            $stm->bindParam(':tipo', $tipo);
            $stm->bindParam(':productoHistorial', $fecha);

            if ($stm->execute()) {
                return true;
            }
            return false; // If the insert failed
        }
    }




    public function insertIntoHistorialVista($idProducto)
    {
        $tipo = 'Visita';
        $stm = $this->pdo->prepare('SELECT idProducto, cantidad FROM guarda WHERE idHistorial = :idUsuario AND idProducto = :idProducto AND tipo = :tipo');
        $stm->bindParam(':idUsuario', $this->idUsuario);
        $stm->bindParam(':idProducto', $idProducto);
        $stm->bindParam(':tipo', $tipo);
        $stm->execute();

        if ($stm->rowCount() !== 0) {
            $tipo = 'Visita';
            $rowDataCant = $stm->fetch(PDO::FETCH_ASSOC);
            $newQuantity = $rowDataCant['cantidad'] + 1;
            $stm = $this->pdo->prepare('UPDATE guarda SET cantidad = :cantidad WHERE idHistorial = :idUsuario AND idProducto = :idProducto AND tipo = :tipo');
            $stm->bindParam(':cantidad', $newQuantity);
            $stm->bindParam(':idUsuario', $this->idUsuario);
            $stm->bindParam(':idProducto', $idProducto);
            $stm->bindParam(':tipo', $tipo);


            if ($stm->execute()) 
            {
                return true;
            } else {
                return false;
            }
        } else {
            $tipo = 'Visita';
            $fecha = date("Y-m-d H:i:s");
            $stm = $this->pdo->prepare('INSERT INTO guarda (idHistorial, idProducto, precioCompra, cantidad, tipo, productoHistorial) VALUE (:idHistorial,  :idProducto, null, 1, :tipo, :productoHistorial)');
            $stm->bindParam(':idHistorial', $this->idUsuario);
            $stm->bindParam(':idProducto',  $idProducto);
            $stm->bindParam(':tipo', $tipo);
            $stm->bindParam(':productoHistorial', $fecha);
    
            if($stm->execute())
            {
                return true;    
            }
            else
            {
                return false;
            }
        }
        
    }
    public function insertViewedIntoProducto($idProducto)
    {
        $stm = $this->pdo->prepare('SELECT visitasProducto FROM producto WHERE idProducto = :idProducto');
        $stm->bindParam(':idProducto', $idProducto);
        if($stm->execute())
        {
            $cantVistas = $stm->fetch(PDO::FETCH_ASSOC);
            echo json_encode($cantVistas);
            $vistasTotal = $cantVistas['visitasProducto'] + 1;
            $stm = $this->pdo->prepare('UPDATE producto SET visitasProducto = :vistasProducto WHERE idProducto = :idProducto');
            $stm->bindParam(':idProducto', $idProducto);
            $stm->bindParam(':vistasProducto', $vistasTotal);
            if($stm->execute())
            {
                return true;
            }
        }
    }
    public function insertBoughtIntoProducto($idProducto, $cantidad)
    {
        $stm = $this->pdo->prepare('SELECT ventasProducto FROM producto WHERE idProducto = :idProducto');
        $stm->bindParam(':idProducto', $idProducto);
        if($stm->execute())
        {
            $cantVentas = $stm->fetch(PDO::FETCH_ASSOC);
            $ventas = $cantVentas['ventasProducto'] + $cantidad;
            $stm = $this->pdo->prepare('UPDATE producto SET ventasProducto = :ventasProducto WHERE idProducto = :idProducto');
            $stm->bindParam(':idProducto', $idProducto);
            $stm->bindParam(':ventasProducto', $ventas);
            if($stm->execute())
            {
                return true;
            }
        }
        else
        {
            $stm = $this->pdo->prepare('INSERT INTO producto (ventasProducto) VALUES (:ventasProducto) WHERE idProducto = :idProducto');
            $stm->bindParam(':idProducto', $idProducto);
            $stm->bindParam(':ventasProducto', 1);
            if($stm->execute())
            {
                return true;
            }
        }
    }
    public function showHistorial()
    {
        $stm = $this->pdo->prepare("SELECT * FROM guarda g RIGHT JOIN producto p ON g.idProducto = p.idProducto WHERE idHistorial = :idHistorial");
        $stm->bindParam(':idHistorial', $this->idUsuario);
        if($stm->execute())
        {
            return  $stm->fetchAll(PDO::FETCH_ASSOC);
        }
        return  false;
    }
    public function showViwedHistorial()
    {
        $tipo =  'visita';

        $stm = $this->pdo->prepare('SELECT * FROM guarda g RIGHT JOIN producto p ON g.idProducto = p.idProducto WHERE idHistorial = :idHistorial AND tipo = :tipo');
        $stm->bindParam(':idHistorial', $this->idUsuario);
        $stm->bindParam(':tipo', $tipo);
        if($stm->execute())
        {
            return  $stm->fetchAll(PDO::FETCH_ASSOC);
        }
        return  false;
    }
    public function showBoughtHistorial()
    {
        $tipo =  'compra';

        $stm = $this->pdo->prepare('SELECT * FROM guarda g RIGHT JOIN producto p ON g.idProducto = p.idProducto WHERE idHistorial = :idHistorial AND tipo = :tipo');
        $stm->bindParam(':idHistorial', $this->idUsuario);
        $stm->bindParam(':tipo', $tipo);
        if($stm->execute())
        {
            return  $stm->fetchAll(PDO::FETCH_ASSOC);
        }
        return  false;
    }
}