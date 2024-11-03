<?php
class Productos
{
    private $idProducto;
    private $nombreProducto;
    private $precioProducto;
    private $categoriaProducto;
    private $descripcionProducto;
    private $valoracionProducto;
    private $imageProducto;
    private $ventasProducto;
    private $fechaProducto;
    private $visitasProducto;
    private $inactivoProducto;
    private $pdo;
    public function  __construct($idProducto, $nombreProducto, $precioProducto, $categoriaProducto, $descripcionProducto, $valoracionProducto, $imageProducto, $ventasProducto, $fechaProducto, $visitasProducto, $inactivoProducto, $pdo)
    {
        $this->idProducto = $idProducto;
        $this->nombreProducto = $nombreProducto;
        $this->precioProducto = $precioProducto;
        $this->categoriaProducto = $categoriaProducto;
        $this->descripcionProducto = $descripcionProducto;
        $this->valoracionProducto = $valoracionProducto;
        $this->imageProducto = $imageProducto;
        $this->inactivoProducto = $inactivoProducto;
        $this->fechaProducto = $fechaProducto;
        $this->visitasProducto = $visitasProducto;
        $this->pdo = $pdo;
    }
    public function setImage($imageData)
    {
        require_once '../GetImage.php';
        $image = new GetImage();
        return $image->uploadImage($imageData);
    }
    public function setFecha( $fecha )
    {
        return $this->fechaProducto = $fecha;
    }
    public function findProductById($id)
    {
        $stm = $this->pdo->prepare("SELECT * FROM producto WHERE idProducto LIKE :id");
        $stm->bindParam(':id', $id);
        if ($stm->execute()) 
        {
            $affectedRows = $stm->rowCount();
            if ($affectedRows > 0) {
                return $stm->fetch(PDO::FETCH_ASSOC);
            }
            echo json_encode('ERROR: Unable to show products');
        }
        echo json_encode('ERROR: query couldnt be executed');
    }
    public function findProductoByName($producto)
    {
        if(!isset($producto))
        {
            $this->showProducts();
        }
        $stm = $this->pdo->prepare("SELECT idProducto, nombreProducto, precioProducto, categoriaProducto, imagenProducto FROM producto WHERE nombreProducto LIKE :producto AND inactivoProducto != 1 LIMIT 10");
        $stm->bindParam(':producto', $producto);
        if ($stm->execute()) 
        {
            $affectedRows = $stm->rowCount();
            if ($affectedRows > 0) {
                return $stm->fetchAll(PDO::FETCH_ASSOC);
            }
            echo json_encode('ERROR: Unable to show products');
        }
        echo json_encode('ERROR: query couldnt be executed');
    }
    public function findProductsByCategory()
    {
        $stm = $this->pdo->prepare("SELECT idProducto, nombreProducto, precioProducto, imagenProducto FROM producto WHERE categoriaProducto = :categoryProduct AND inactivoProducto != 1 LIMIT 10");
        $stm->bindParam(':categoryProduct', $this->categoriaProducto);
        if($stm->execute())
        {
            $affectedRows = $stm->rowCount();
            if ($affectedRows > 0) {
                return $stm->fetchAll(PDO::FETCH_ASSOC);
            }
            echo json_encode('ERROR: Unable to find products');
        }
        echo json_encode('ERROR: query couldnt be executed');
    }
    public function showProducts()
    {
        $stm = $this->pdo->prepare("SELECT idProducto, nombreProducto, precioProducto, imagenProducto FROM producto WHERE inactivoProducto != 1 ORDER BY RAND() LIMIT 5");
        if ($stm->execute()) 
        {
            $affectedRows = $stm->rowCount();
            if ($affectedRows > 0) {
                $results = $stm->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($results); 
            }
        }
        return json_encode('ERROR: query couldnt be executed');
    }
    public function addProduct($imageProducto) {
        $fechaProducto = date("Y-m-d h:m:s");
        $fotoDeProducto = $this->setImage($imageProducto);
        
        // Check if the image was processed correctly
        if (is_array($fotoDeProducto) || !$fotoDeProducto) {
            return json_encode(['success' => false, 'message' => 'Error processing image']);
        }
    
        // Check if idProducto exists in Contiene
        $checkStmt = $this->pdo->prepare("SELECT COUNT(*) FROM contiene WHERE idProducto = :id");
        $checkStmt->bindParam(':id', $this->idProducto);
        $checkStmt->execute();
        $exists = $checkStmt->fetchColumn();
        echo json_encode($exists);
        if ($exists == 0) {
            return json_encode(['success' => false, 'message' => 'idProducto does not exist in contiene']);
        }
    
        // Proceed to insert into Producto
        $stm = $this->pdo->prepare("INSERT INTO producto (idProducto, nombreProducto, precioProducto, categoriaProducto, descripcionProducto, valoracionProducto, imagenProducto, ventasProducto, fechaProducto, visitasProducto, inactivoProducto) VALUES (:id, :nombre, :precio, :categoria, :descripcion, null, :img, null, :fecha, null, :false)");
        
        // Binding parameters
        $stm->bindParam(":id", $this->idProducto);
        $stm->bindParam(':nombre', $this->nombreProducto);
        $stm->bindParam(':precio', $this->precioProducto);
        $stm->bindParam(':categoria', $this->categoriaProducto);
        $stm->bindParam(':descripcion', $this->descripcionProducto);
        $stm->bindParam(':img', $fotoDeProducto);
        $stm->bindParam(':fecha', $fechaProducto);
        $stm->bindParam(':false', $this->inactivoProducto);
    
        // Execute and check for success
        if ($stm->execute()) {
            $this->setFecha($fechaProducto);
            return json_encode(['success' => true, 'message' => 'Product stored successfully']);
        }
        return json_encode(['error' => 'Error storing the product']);
    }
    
    
    public function updateProduct($id, $img)
{ 
        // Manejar la imagen
        
        $fotoDeProducto = $this->setImage($img);
        if (!$fotoDeProducto) {
            return json_encode(['success' => false,'message' => 'Error processing image']);
        }

        $fechaProducto = date("Y-m-d H:i");
        // Preparar y ejecutar la consulta
        $stm = $this->pdo->prepare("UPDATE producto SET nombreProducto = :nombre, precioProducto = :precio, categoriaProducto = :categoriaProducto,  descripcionProducto = :descripcionProducto, imagenProducto = :img, fechaProducto = :fecha WHERE idProducto = :id");

        $stm->bindParam(':nombre', $this->nombreProducto);
        $stm->bindParam(':precio', $this->precioProducto);
        $stm->bindParam(':categoriaProducto', $this->categoriaProducto);
        $stm->bindParam(':descripcionProducto', $this->descripcionProducto);
        $stm->bindParam(':img', $fotoDeProducto);
        $stm->bindParam(':fecha', $fechaProducto);
        $stm->bindParam(':id', $id);

        if($stm->execute()) {
            if($stm->rowCount() > 0) {
                $this->setFecha($fechaProducto);
                return json_encode(['success' => true,'message' => 'Product updated successfully']);
            } else {
                return json_encode(['success' => false,'message' => 'No product found with the provided ID']);
            }
        }
    }
    public function deleteProduct($id)
    {
        $inactivoProducto = true;
        $stm = $this->pdo->prepare("UPDATE producto SET inactivoProducto = :inactivoProducto WHERE idProducto = :id");
        $stm->bindParam(':inactivoProducto', $inactivoProducto);
        $stm->bindParam(':id', $id);
        if($stm->execute())
        {
            echo json_encode(["success" => true, "message" => "Product deletes duccesfully"]);
        }
        return json_encode(['error deleting the product']);
    }
public function showAllProducts()
    {
        $stm = $this->pdo->prepare("SELECT p.idProducto,p.nombreProducto,p.precioProducto,p.categoriaProducto,p.valoracionProducto, p.imagenProducto,p.ventasProducto,p.fechaProducto,p.visitasProducto,p.inactivoProducto , c.stock, e.nombreEmpresa
                                    FROM producto p
                                    LEFT JOIN contiene c ON p.idProducto = c.idProducto
                                    JOIN inventario i ON c.idInventario = i.idInventario
                                    JOIN empresa e ON i.idEmpresa = e.idEmpresa
                                    ORDER BY p.idProducto ASC;
");
        if ($stm->execute())
        {
            $affectedRows = $stm->rowCount();
            if ($affectedRows > 0) {
                $results = $stm->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($results);
            }
        }
        return json_encode('ERROR: query couldnt be executed');
    }
public function findProductoByNameBackoffice($producto)
    {
        $stm = $this->pdo->prepare("SELECT p.idProducto,p.nombreProducto,p.precioProducto,p.categoriaProducto,p.valoracionProducto, p.imagenProducto,p.ventasProducto,p.fechaProducto,p.visitasProducto,p.inactivoProducto , c.stock, e.nombreEmpresa
                                    FROM producto p
                                    LEFT JOIN contiene c ON p.idProducto = c.idProducto
                                    JOIN inventario i ON c.idInventario = i.idInventario
                                    JOIN empresa e ON i.idEmpresa = e.idEmpresa
                                     WHERE nombreProducto LIKE :producto
                                    ORDER BY p.idProducto ASC");
        $stm->bindParam(':producto', $producto);
        if ($stm->execute())
        {
            $affectedRows = $stm->rowCount();
            if ($affectedRows > 0) {
                return $stm->fetchAll(PDO::FETCH_ASSOC);
            }
            echo json_encode('ERROR: Unable to show products');
        }
        echo json_encode('ERROR: query couldnt be executed');
    }
public function showProductsBackOffice()
    {
        $stm = $this->pdo->prepare("SELECT idProducto, nombreProducto, precioProducto, imagenProducto FROM producto");
        if ($stm->execute())
        {
            $affectedRows = $stm->rowCount();
            if ($affectedRows > 0) {
                $results = $stm->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($results);
            }
        }
        return json_encode('ERROR: query couldnt be executed');
    }
}
