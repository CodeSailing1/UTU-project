<?php
class BackOffice
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }
    public function mostrarTodosUsuarios()
    {
        $stm = $this->pdo->prepare("SELECT 'usuario' AS tipo,(SELECT COUNT(idUsuario) FROM Usuario WHERE inactivoUsuario=FALSE) AS Activo, (SELECT COUNT(idUsuario) FROM Usuario WHERE inactivoUsuario = TRUE) AS Inactivo, (SELECT COUNT(idUsuario) FROM Usuario) AS Total
                                    UNION ALL
                                    select 'empresa' AS tipo,(SELECT COUNT(idEmpresa) FROM empresa WHERE inactivoEmpresa=FALSE) AS Activo, (SELECT COUNT(idEmpresa) FROM empresa WHERE inactivoEmpresa = TRUE) AS Inactivo, (SELECT COUNT(idEmpresa) FROM empresa) AS Total
                                    UNION ALL
                                    select 'administrador' AS tipo,(SELECT COUNT(idAdmin) FROM administrador) AS Activo, NULL as Inactivo, (SELECT COUNT(idAdmin) FROM administrador) AS Total
");
        if($stm->execute())
        {
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    public function mostrarCarritoDeComprasParticular($idUsuario)
    {
        $stm = $this->pdo->prepare('SELECT a.cantidad, p.precioProducto, p.idProducto, p.nombreProducto, p.imagenProducto FROM usuario u JOIN carritoDeCompras c JOIN agrega a JOIN producto p ON u.idUsuario = c.idCarritoCompras AND c.idCarritoCompras = a.idCarritoCompras AND a.idProducto = p.idProducto WHERE u.idUsuario = :idUsuario');
        $stm->bindParam(':idUsuario', $idUsuario);
        if($stm->execute())
        {
            return $stm->fetch(PDO::FETCH_ASSOC);
        }
    }
    public function rankingComprasUsuario()
    {
        $stm = $this->pdo->prepare('SELECT COUNT(g.idHistorial) AS cantidad, u.nombreUsuario
                                    FROM guarda g
                                    JOIN historial h ON g.idHistorial = h.idHistorial
                                    JOIN usuario u ON h.idUsuario = u.idUsuario
                                    WHERE g.tipo = "Compra"
                                    GROUP BY u.idUsuario
                                    ORDER BY cantidad ASC
                                    LIMIT 20;
');
        if($stm->execute())
        {
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        }
    }
//     public function rankingDineroGastadoUsuario()
//     {
//         $stm = $this->pdo->prepare('SELECT COUNT(idHistorial), idHistorial FROM guarda WHERE tipo = 'compra' group by idHistorial ORDER BY `COUNT(idHistorial)` ASC LIMIT 20');
//         if($stm->execute())
//         {
//             return $stm->fetch(PDO::FETCH_ASSOC);
//         }
//     }
    public function rankingProductosMasVendidos()
    {
        $stm = $this->pdo->prepare('SELECT nombreProducto, ventasProducto FROM Producto WHERE YEAR(fechaProducto) = YEAR(CURDATE()) ORDER BY ventasProducto DESC LIMIT 10');
        if($stm->execute())
        {
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    public function historialCompraCliente($idUsuario)
    {
        $stm = $this->pdo->prepare('SELECT g.productoHistorial, p.nombreProducto, g.cantidad from guarda g join producto p ON g.idProducto = p.idProducto WHERE g.idHistorial = :idUsuario AND g.tipo = "compra" ORDER BY g.productoHistorial ASC');
        $stm->bindParam(':idUsuario', $idUsuario);
        if($stm->execute())
        {
            return $stm->fetch(PDO::FETCH_ASSOC);
        }
    }
    public function nose($idProducto)
    {
        $stm = $this->pdo->prepare('SELECT h.fechaHistorial, h.nombreUsuario, g.cantidad FROM Guarda G JOIN Historial H ON g.idHistorial = h.idHistorial JOIN Usuario u ON h.idUsuario = u.idUsuario WHERE g.idProducto = :idProducto AND g.tipo = "Compra" ORDER BY H.fechaHistorial ASC');
        $stm->bindParam(':idUsuario', $idProducto);
        if($stm->execute())
        {
            return $stm->fetch(PDO::FETCH_ASSOC);
        }
    }
    public function historialVistosCliente($idUsuario)
    {
        $stm = $this->pdo->prepare('SELECT p.nombreProducto, p.idProducto, p.precioProducto FROM guarda g JOIN producto p ON g.idProducto = p.idProducto JOIN historial h ON G.idHistorial = H.idHistorial WHERE H.idUsuario = 1 AND g.tipo = "Visita"');
        $stm->bindParam(':idUsuario', $idUsuario);
        if($stm->execute())
        {
            return $stm->fetch(PDO::FETCH_ASSOC);
        }
    }
    public function productosNoComprasMes()
    {
        $stm = $this->pdo->prepare('SELECT p.idProducto, p.nombreProducto, p.precioProducto FROM Producto p LEFT JOIN guarda g ON p.idProducto = g.idProducto AND g.tipo = "compra" WHERE (g.idHistorial IS NULL OR g.productoHistorial < DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND p.ventasProducto = 0');
        if($stm->execute())
        {
            return $stm->fetch(PDO::FETCH_ASSOC);
        }
    }
    public function nose2()
    {
        $stm = $this->pdo->prepare('SELECT p.idProducto, p.nombreProducto, p.precioProducto FROM Producto p LEFT JOIN guarda g ON p.idProducto = g.idProducto AND g.tipo = "compra" WHERE (g.idHistorial IS NULL OR g.productoHistorial < DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) AND p.ventasProducto = 0');
        if($stm->execute())
        {
            return $stm->fetch(PDO::FETCH_ASSOC);
        }
    }
    public function clienteNoComprasTrimestre()
    {
        $stm = $this->pdo->prepare('SELECT u.nombreUsuario, u.emailUsuario FROM Usuario u LEFT JOIN guarda g ON u.idUsuario = g.idHistorial AND g.tipo = "Compra" WHERE (g.idHistorial IS NULL OR g.productoHistorial < DATE_SUB(CURDATE(), INTERVAL 3 MONTH));');
        if($stm->execute())
        {
            return $stm->fetch(PDO::FETCH_ASSOC);
        }
    }
    public function resumenVentasEmpresasAnio()
    {
        $stm = $this->pdo->prepare('SELECT E.nombreEmpresa, COALESCE(SUM(H.cantidad), 0) AS totalVentas from Empresa E LEFT JOIN
                                    Inventario I ON E.idEmpresa = I.idEmpresa LEFT JOIN
                                    Contiene C ON I.idInventario = C.idInventario LEFT JOIN
                                    Producto P ON C.idProducto = P.idProducto LEFT JOIN
                                    Guarda H ON P.idProducto = H.idProducto AND H.tipo = "Compra" WHERE
                                    YEAR(H.productoHistorial) = YEAR(CURDATE()) OR H.productoHistorial IS null GROUP BY E.idEmpresa;');
        if($stm->execute())
        {
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        }
    }
public function resumenVentasEmpresasMes()
    {
        $stm = $this->pdo->prepare('SELECT E.nombreEmpresa, COALESCE(SUM(H.cantidad), 0) AS totalVentas from Empresa E LEFT JOIN
                                    Inventario I ON E.idEmpresa = I.idEmpresa LEFT JOIN
                                    Contiene C ON I.idInventario = C.idInventario LEFT JOIN
                                    Producto P ON C.idProducto = P.idProducto LEFT JOIN
                                    Guarda H ON P.idProducto = H.idProducto AND H.tipo = "Compra" WHERE
                                    MONTH(H.productoHistorial) = MONTH(CURDATE()) OR H.productoHistorial IS null GROUP BY E.idEmpresa;');
        if($stm->execute())
        {
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}