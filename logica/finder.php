<?php
require_once 'conexionSQL.php';
header('Content-Type: application/json');

$searchTerm = $_GET['searchTerm'];

if (isset($searchTerm)) {
    $producto = "%$searchTerm%";
    $stm = $pdo->prepare("SELECT idProducto, nombreProducto, precioProducto, categoriaProducto, descripcionProducto FROM producto WHERE nombreProducto LIKE :producto");

    $stm->bindParam(':producto', $producto);

    if ($stm->execute()) {
        $affectedRows = $stm->rowCount();
        if ($affectedRows > 0) {
            $results = $stm->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($results); 
        }
    }
}
