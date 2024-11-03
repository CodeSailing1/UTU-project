<?php
class CarritoDeCompras
{
    private $idUsuario;
    private $pdo;
    function __construct($idUsuario, $pdo)
    {
        $this->idUsuario = $idUsuario;
        $this->pdo = $pdo;
    }
    public function crearCarrito()
{
    // Verificar si el carrito ya existe
    $stm = $this->pdo->prepare("SELECT estado FROM carritoDeCompras WHERE idUsuario = :idUsuario");
    $stm->bindParam(":idUsuario", $this->idUsuario);
    $stm->execute();

    // Si el carrito ya existe, retornar un mensaje
    if ($stm->rowCount() > 0) {
        return ['success' => false, 'message' => 'El carrito de compras ya existe'];
    }

    // Si no existe, crear un nuevo carrito
    $date = date('Y-m-d H:i:s');
    $status = 'Vacio';
    $stm = $this->pdo->prepare("INSERT INTO carritoDeCompras (idCarritoCompras, idUsuario, fechaCreacion, estado) VALUES (:idUsuario, :idUsuario, :fechaCreacion, :estado)");
    $stm->bindParam(':idUsuario', $this->idUsuario);
    $stm->bindParam(':fechaCreacion', $date);
    $stm->bindParam(':estado', $status);

    if ($stm->execute()) {
        return ['success' => true, 'message' => 'Carrito de compras creado correctamente'];
    } else {
        return ['success' => false, 'error' => 'Error al crear el carrito de compras'];
    }
}
    public function addProduct($idproducto)
    {
        $checkProduct = $this->pdo->prepare('SELECT idProducto FROM producto WHERE idProducto = :idProducto');
        $checkProduct->bindParam(':idProducto', $idproducto);
        $checkProduct->execute();

        if ($checkProduct->rowCount() == 0) {
            return json_encode(['error' => 'El producto no existe']);
        }

        $stm = $this->pdo->prepare('SELECT idProducto, cantidad FROM agrega WHERE idCarritoCompras = :idUsuario AND idProducto = :idProducto');
        $stm->bindParam(':idUsuario', $this->idUsuario);
        $stm->bindParam(':idProducto', $idproducto);
        $stm->execute();

        if ($stm->rowCount() === 0) {
            $cantidad = 1;
            $stm = $this->pdo->prepare('INSERT INTO agrega (idCarritoCompras, idProducto, cantidad) VALUES (:idCarrito, :idProducto, :cantidad)');
            $stm->bindParam(':idCarrito', $this->idUsuario);
            $stm->bindParam(':idProducto', $idproducto);
            $stm->bindParam(':cantidad', $cantidad);

            if ($stm->execute()) {
                $estado = 'En curso';
                $stm = $this->pdo->prepare('UPDATE carritodecompras SET estado = :estado WHERE idCarritoCompras = :idUsuario AND idUsuario = :idUsuario');
                $stm->bindParam(':estado', $estado);
                $stm->bindParam(':idUsuario', $this->idUsuario);
                if ($stm->execute()) {
                    return ['success' => true, 'message' => 'Cantidad actualizada correctamente'];
                }
            } else {
                return json_encode(['error' => 'No se pudo agregar el producto']);
            }
        } else {
            $rowDataCant = $stm->fetch(PDO::FETCH_ASSOC);
            $newQuantity = $rowDataCant['cantidad'] + 1;
            $stm = $this->pdo->prepare('UPDATE agrega SET cantidad = :cantidad WHERE idCarritoCompras = :idUsuario AND idProducto = :idProducto');
            $stm->bindParam(':cantidad', $newQuantity);
            $stm->bindParam(':idUsuario', $this->idUsuario);
            $stm->bindParam(':idProducto', $idproducto);

            if ($stm->execute()) 
            {
                return json_encode(['success' => true, 'message' => 'Cantidad actualizada correctamente']);
            } else {
                return json_encode(['error' => 'No se pudo actualizar la cantidad']);
            }
        }
    }
    public function deleteProduct($idproducto)
    {
        $stm = $this->pdo->prepare('SELECT cantidad FROM agrega WHERE idCarritoCompras = :idUsuario AND idProducto = :idProducto');
        $stm->bindParam(':idUsuario', $this->idUsuario);
        $stm->bindParam(':idProducto', $idproducto);
        if( $stm->execute()) 
        {
            $cartData = $stm->fetch(PDO::FETCH_ASSOC);
            if ($cartData['cantidad'] <= 1) 
            {
                $stm = $this->pdo->prepare('DELETE FROM agrega WHERE idCarritoCompras = :idUsuario AND idProducto = :idProducto');
                $stm->bindParam(':idUsuario', $this->idUsuario);
                $stm->bindParam(':idProducto', $idproducto);
                if ($stm->execute()) {
                    return json_encode(['success' => true, 'message' => 'Product deleted succesfully from the cart']);
                }
            } 
            else 
            {
                $newQuantity = $cartData['cantidad'] - 1;
                $stm = $this->pdo->prepare('UPDATE agrega SET cantidad = :cantidad WHERE idCarritoCompras = :idUsuario AND idProducto = :idProducto');
                $stm->bindParam(':cantidad', $newQuantity);
                $stm->bindParam(':idUsuario', $this->idUsuario);
                $stm->bindParam(':idProducto', $idproducto);
                if ($stm->execute()) {
                    return json_encode(['success' => true, 'message' => 'Se pudo actualizar la cantidad correctamente']);
                } else {
                    return json_encode(['error' => 'No se pudo actualizar la cantidad']);
                }
            }
        }
    }
    public function costoTotalCarrito()
    {
        header('Content-Type: application/json'); 
        $stm = $this->pdo->prepare('SELECT SUM(p.precioProducto * a.cantidad) as total FROM producto p JOIN agrega a JOIN carritodecompras c JOIN usuario u ON p.idProducto = a.idProducto AND a.idCarritoCompras = c.idCarritoCompras AND c.idUsuario = u.idUsuario WHERE u.idUsuario = :idUsuario');
        $stm->bindParam(':idUsuario', $this->idUsuario);
        if ($stm->execute()) 
        {
            $precioData = $stm->fetch(PDO::FETCH_ASSOC);
            return json_encode(['success' => true, 'total' => $precioData['total']]);
        }
        return json_encode(['success' => false, 'error' => 'Failed to execute query']);
    }
    public function boughtProducts()
    {
        require_once '../historial/Historial.php';
        
        $stm  = $this->pdo->prepare('DELETE FROM agrega WHERE idCarritoCompras = :idUsuario');
        $stm->bindParam(':idUsuario', $this->idUsuario);
        if($stm->execute())
        {
            return  true; 
        }
        else 
        {
            return json_encode(['success' => false, 'error' => 'Failed to execute query']);
        }
    }
    public function showCart()
    {
        $stm = $this->pdo->prepare('SELECT a.cantidad, p.precioProducto, p.idProducto, p.nombreProducto, p.imagenProducto FROM usuario u JOIN carritoDeCompras c JOIN agrega a JOIN producto p ON u.idUsuario = c.idCarritoCompras AND c.idCarritoCompras = a.idCarritoCompras AND a.idProducto = p.idProducto WHERE u.idUsuario = :idUsuario');
        $stm->bindParam(':idUsuario', $this->idUsuario);

        if ($stm->execute()) {
            $row = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $row;
        }
    }
}