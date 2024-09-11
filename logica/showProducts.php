<?php
include_once 'conexionSQL.php';
$stm = $pdo->prepare("SELECT idProducto, nombreProducto, precioProducto, categoriaProducto FROM producto");
if ($stm->execute()) {
    $affectedRows = $stm->rowCount();
    if ($affectedRows > 0) {
        $results = $stm->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($results); 
    }
}