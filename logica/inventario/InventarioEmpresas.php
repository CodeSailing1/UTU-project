<?php
class InventarioEmpresas
{
    private  $idEmpresa;

    private $pdo;
    public  function __construct($idEmpresa,  $pdo)
    {
        $this ->idEmpresa = $idEmpresa;
        $this ->pdo = $pdo;
    }

    public function createInventario()
    {
        $stm = $this->pdo->prepare("INSERT INTO inventario  (idInventario, idEmpresa, fechaCreacion) VALUES (:idInventario, :idEmpresa, :fecha)");
        $stm->bindParam(':idInventario', $this->idEmpresa);
        $stm->bindParam(':idEmpresa', $this->idEmpresa);
        $stm->bindParam(  ':fecha', date('Y-m-d H:m:s'));

        if($stm->execute())
        {
            echo json_encode(  ["success" => "Inventario created succesfully"]);
        }
    }
    public function showInventario ()
    {
        $stm = $this->pdo->prepare("SELECT c.stock, p.precioProducto, p.idProducto, p.nombreProducto, p.imagenProducto FROM empresa e JOIN inventario i JOIN contiene c JOIN producto p ON e.idEmpresa = i.idInventario AND i.idInventario = c.idInventario AND c.idProducto = p.idProducto WHERE e.idEmpresa = :idEmpresa");
        $stm->bindParam(':idEmpresa', $this->idEmpresa);
        $inventarioItems = [];

        if ($stm->execute()) {
            $row = $stm->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($row);
        }
    }
    public function deleteProductAfterBought($idproducto, $cantidad)
    {
        $stm = $this->pdo->prepare('SELECT c.stock, e.idEmpresa FROM contiene c JOIN inventario i ON c.idInventario = i.idInventario JOIN empresa e ON i.idInventario = e.idEmpresa WHERE c.idProducto = :idProducto');
        $stm->bindParam(':idProducto', $idproducto);
        if( $stm->execute()) 
        {
            $inventarioData = $stm->fetch(PDO::FETCH_ASSOC);
            $idEmpresa = $inventarioData['idEmpresa'];

            if($inventarioData)
            {
                $newQuantity = $inventarioData['stock'] - $cantidad;
                $stm = $this->pdo->prepare('UPDATE contiene SET stock = :stock WHERE idInventario = :idEmpresa AND idProducto = :idProducto');
                $stm->bindParam(':stock', $newQuantity);
                $stm->bindParam(':idEmpresa', $idEmpresa);
                $stm->bindParam(':idProducto', $idproducto);
                if ($stm->execute()) {
                    return true;
                } else {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
    }
    public function deleteAllFromStock($idProducto)
    {
        $checkProduct = $this->pdo->prepare('SELECT idProducto FROM contiene WHERE idProducto = :idProducto');
        $checkProduct->bindParam(':idProducto', $idProducto);
        $checkProduct->execute();

        if ($checkProduct->rowCount() == 0) {
            return json_encode(['error' => 'El producto no existe']);
        }

        $stm = $this->pdo->prepare('DELETE FROM contiene WHERE idProducto = :idProducto');
        $stm->bindParam(':idProducto', $idProducto);
        if($stm->execute())
        {
            return json_encode(['success' => true, 'message' => 'Producto eliminado completamente del inventario']);
        }
        return json_encode(['success' => false, 'message' => 'Error al eliminar el producto completamente del inventario']);

    }
    public function addProduct($nombreProducto, $precioProducto, $categoriaProducto, $descripcionProducto, $imagenProducto, $stock)
    {
        require_once '../productos/Productos.php';
        
            $stm = $this->pdo->prepare('INSERT INTO contiene (idInventario, stock) VALUES (:idInventario, :cantidad)');
            $stm->bindParam(':idInventario', $this->idEmpresa);
            $stm->bindParam(':cantidad', $stock);
            if ($stm->execute()) {
                $idProducto = $this->pdo->prepare('SELECT idProducto FROM contiene ORDER BY idProducto DESC LIMIT 1');
                $idProducto->execute();
                $id = $idProducto->fetch(PDO::FETCH_ASSOC);
                echo json_encode($id['idProducto']);
                $producto = new Productos($id['idProducto'], $nombreProducto, $precioProducto, $categoriaProducto, $descripcionProducto, null, null, null,null, null, false, $this->pdo );
                if($producto->addProduct($imagenProducto))
                {
                    return json_encode(['success' => true, 'message' => 'Product stored successfully']);
                }
                return json_encode(['success' => true, 'message' => 'Cantidad actualizada correctamente']);
            }
    }
}
