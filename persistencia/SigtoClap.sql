-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-11-2024 a las 15:18:13
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = '-03:00';


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sigto`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administra`
--

CREATE TABLE `administra` (
  `idEmpresa` int(10) UNSIGNED NOT NULL,
  `idAdmin` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `idAdmin` int(10) UNSIGNED NOT NULL,
  `nombreAdmin` varchar(30) NOT NULL,
  `emailAdmin` varchar(30) NOT NULL,
  `telefonoAdmin` int(10) UNSIGNED NOT NULL,
  `contraseniaAdmin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `agrega`
--

CREATE TABLE `agrega` (
  `idProducto` int(10) UNSIGNED NOT NULL,
  `idCarritoCompras` int(10) UNSIGNED NOT NULL,
  `cantidad` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `agrega`
--

INSERT INTO `agrega` (`idProducto`, `idCarritoCompras`, `cantidad`) VALUES
(1, 1, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacena`
--

CREATE TABLE `almacena` (
  `idCarritoCompras` int(10) UNSIGNED DEFAULT NULL,
  `idPedido` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `almacena`
--

INSERT INTO `almacena` (`idCarritoCompras`, `idPedido`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carritodecompras`
--

CREATE TABLE `carritodecompras` (
  `idCarritoCompras` int(10) UNSIGNED NOT NULL,
  `idUsuario` int(10) UNSIGNED DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL,
  `estado` enum('Vacio','En curso','En pago') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carritodecompras`
--

INSERT INTO `carritodecompras` (`idCarritoCompras`, `idUsuario`, `fechaCreacion`, `estado`) VALUES
(1, 1, '2024-11-05 12:22:41', 'En curso');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comenta`
--

CREATE TABLE `comenta` (
  `idComentario` int(10) UNSIGNED NOT NULL,
  `textoComentario` varchar(300) DEFAULT NULL,
  `fechaComentario` datetime NOT NULL,
  `idUsuario` int(10) UNSIGNED DEFAULT NULL,
  `idProducto` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comenta`
--

INSERT INTO `comenta` (`idComentario`, `textoComentario`, `fechaComentario`, `idUsuario`, `idProducto`) VALUES
(1, 'buenas', '2024-11-05 13:58:29', 1, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contiene`
--

CREATE TABLE `contiene` (
  `idInventario` int(10) UNSIGNED DEFAULT NULL,
  `idProducto` int(10) UNSIGNED NOT NULL,
  `stock` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `contiene`
--

INSERT INTO `contiene` (`idInventario`, `idProducto`, `stock`) VALUES
(1, 1, 90),
(1, 2, 100),
(1, 3, 100),
(1, 4, 100),
(1, 5, 100),
(1, 6, 100),
(1, 7, 100),
(1, 8, 100),
(1, 9, 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE `empresa` (
  `idEmpresa` int(10) UNSIGNED NOT NULL,
  `nombreEmpresa` varchar(30) NOT NULL,
  `emailEmpresa` varchar(30) NOT NULL,
  `telefonoEmpresa` int(10) UNSIGNED NOT NULL,
  `contraseniaEmpresa` varchar(255) NOT NULL,
  `direccionEmpresa` varchar(250) NOT NULL,
  `fotoDePerfilEmpresa` blob NOT NULL,
  `inactivoEmpresa` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`idEmpresa`, `nombreEmpresa`, `emailEmpresa`, `telefonoEmpresa`, `contraseniaEmpresa`, `direccionEmpresa`, `fotoDePerfilEmpresa`, `inactivoEmpresa`) VALUES
(1, 'codeSailing', 'codeSailing1@gmail.com', 111111111, '$2y$10$QcJ/GiExfifb1.OnWNKuceEaZnQ.qF2Mqa6PgonkT31fDWzDVdQ82', '111', 0x363732613030326531646533332e706e67, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `entrega`
--

CREATE TABLE `entrega` (
  `idProducto` int(10) UNSIGNED NOT NULL,
  `idPedido` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `entrega`
--

INSERT INTO `entrega` (`idProducto`, `idPedido`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formula`
--

CREATE TABLE `formula` (
  `idUsuario` int(10) UNSIGNED DEFAULT NULL,
  `idTicket` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gestiona`
--

CREATE TABLE `gestiona` (
  `idProducto` int(10) UNSIGNED NOT NULL,
  `idAdmin` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guarda`
--

CREATE TABLE `guarda` (
  `idProducto` int(10) UNSIGNED NOT NULL,
  `idHistorial` int(10) UNSIGNED NOT NULL,
  `cantidad` int(10) UNSIGNED DEFAULT NULL,
  `precioCompra` int(10) UNSIGNED DEFAULT NULL,
  `productoHistorial` datetime NOT NULL,
  `tipo` enum('Visita','Compra') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `guarda`
--

INSERT INTO `guarda` (`idProducto`, `idHistorial`, `cantidad`, `precioCompra`, `productoHistorial`, `tipo`) VALUES
(1, 1, 4, NULL, '2024-11-05 12:37:18', 'Visita'),
(1, 1, 13, 3700, '2024-11-05 12:47:12', 'Compra'),
(9, 1, 2, NULL, '2024-11-05 13:58:23', 'Visita');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial`
--

CREATE TABLE `historial` (
  `idHistorial` int(10) UNSIGNED NOT NULL,
  `idUsuario` int(10) UNSIGNED DEFAULT NULL,
  `fechaHistorial` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `historial`
--

INSERT INTO `historial` (`idHistorial`, `idUsuario`, `fechaHistorial`) VALUES
(1, 1, '2024-11-05 12:11:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `idInventario` int(10) UNSIGNED NOT NULL,
  `idEmpresa` int(10) UNSIGNED DEFAULT NULL,
  `fechaCreacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`idInventario`, `idEmpresa`, `fechaCreacion`) VALUES
(1, 1, '2024-11-05 12:11:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `oferta`
--

CREATE TABLE `oferta` (
  `idOferta` int(10) UNSIGNED NOT NULL,
  `idProducto` int(10) UNSIGNED NOT NULL,
  `descuento` int(11) NOT NULL,
  `nombreOferta` varchar(30) NOT NULL,
  `inicioOferta` datetime NOT NULL,
  `finOferta` datetime DEFAULT NULL,
  `inactivoOferta` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `idPedido` int(10) UNSIGNED NOT NULL,
  `idUsuario` int(10) UNSIGNED DEFAULT NULL,
  `tipo` enum('Delivery','PickUp') NOT NULL,
  `metodoDePago` enum('Paypal','Debito','Credito','Red de cobranza') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`idPedido`, `idUsuario`, `tipo`, `metodoDePago`) VALUES
(1, 1, 'Delivery', 'Paypal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `piden`
--

CREATE TABLE `piden` (
  `idEmpresa` int(10) UNSIGNED DEFAULT NULL,
  `idTicket` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idProducto` int(10) UNSIGNED NOT NULL,
  `nombreProducto` varchar(30) NOT NULL,
  `precioProducto` int(10) UNSIGNED NOT NULL,
  `categoriaProducto` enum('juegos y consolas','musica','libros','celulares','ropa','muebles','deportes','joyeria','herramientas','salud y belleza') NOT NULL,
  `descripcionProducto` varchar(250) NOT NULL,
  `valoracionProducto` int(10) UNSIGNED DEFAULT NULL,
  `imagenProducto` blob NOT NULL,
  `ventasProducto` int(10) UNSIGNED DEFAULT NULL,
  `fechaProducto` datetime NOT NULL,
  `visitasProducto` int(10) UNSIGNED DEFAULT NULL,
  `inactivoProducto` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idProducto`, `nombreProducto`, `precioProducto`, `categoriaProducto`, `descripcionProducto`, `valoracionProducto`, `imagenProducto`, `ventasProducto`, `fechaProducto`, `visitasProducto`, `inactivoProducto`) VALUES
(1, 'cocacola', 1200, '', 'Cocacola de la marca cocacola', NULL, 0x363732613030366230313631342e77656270, 10, '2024-11-05 12:11:27', 6, 1),
(2, 'guitarra clasica', 500, '', 'Guitarra de buena calidad', NULL, 0x363732613030393761386364352e706e67, NULL, '2024-11-05 12:11:11', 2, 0),
(3, 'telefono iphone', 300, '', 'Telefono de gama alta', NULL, 0x363732613030636235653930642e6a7067, NULL, '2024-11-05 12:11:03', NULL, 0),
(8, 'celular iphone 2003', 400, '', 'Celular de alta gama', NULL, 0x363732613031353738303432312e6a7067, NULL, '2024-11-05 12:11:23', NULL, 0),
(9, 'pala de playa', 300, '', 'Juguete perfecto para usar en la playa', NULL, 0x363732613031383465653761662e6a7067, NULL, '2024-11-05 12:11:08', 5, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publica`
--

CREATE TABLE `publica` (
  `idEmpresa` int(10) UNSIGNED DEFAULT NULL,
  `idOferta` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resuelve`
--

CREATE TABLE `resuelve` (
  `idAdmin` int(10) UNSIGNED DEFAULT NULL,
  `idTicket` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `supervisa`
--

CREATE TABLE `supervisa` (
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `idAdmin` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ticketdeayuda`
--

CREATE TABLE `ticketdeayuda` (
  `idTicket` int(10) UNSIGNED NOT NULL,
  `asuntoTicket` varchar(250) NOT NULL,
  `fechaTicket` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `idUsuario` int(10) UNSIGNED NOT NULL,
  `nombreUsuario` varchar(30) NOT NULL,
  `emailUsuario` varchar(30) NOT NULL,
  `telefonoUsuario` int(10) UNSIGNED NOT NULL,
  `contraseniaUsuario` varchar(255) NOT NULL,
  `direccionUsuario` varchar(250) NOT NULL,
  `fotoDePerfilUsuario` blob NOT NULL,
  `inactivoUsuario` tinyint(1) NOT NULL,
  `idGoogle` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `nombreUsuario`, `emailUsuario`, `telefonoUsuario`, `contraseniaUsuario`, `direccionUsuario`, `fotoDePerfilUsuario`, `inactivoUsuario`, `idGoogle`) VALUES
(1, 'juan', 'juan@gmail.com', 111111111, '$2y$10$K00NPA4Acl0NgrbNXtHkm.zfLcSz5FUbi/lbnpFzGhQc/TsJn/.ki', '111', 0x363732613030303134656136632e706e67, 0, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administra`
--
ALTER TABLE `administra`
  ADD PRIMARY KEY (`idEmpresa`),
  ADD KEY `idAdmin` (`idAdmin`);

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`idAdmin`);

--
-- Indices de la tabla `agrega`
--
ALTER TABLE `agrega`
  ADD PRIMARY KEY (`idProducto`,`idCarritoCompras`),
  ADD KEY `idCarritoCompras` (`idCarritoCompras`);

--
-- Indices de la tabla `almacena`
--
ALTER TABLE `almacena`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `idCarritoCompras` (`idCarritoCompras`);

--
-- Indices de la tabla `carritodecompras`
--
ALTER TABLE `carritodecompras`
  ADD PRIMARY KEY (`idCarritoCompras`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `comenta`
--
ALTER TABLE `comenta`
  ADD PRIMARY KEY (`idComentario`,`idProducto`),
  ADD KEY `idUsuario` (`idUsuario`),
  ADD KEY `idProducto` (`idProducto`);

--
-- Indices de la tabla `contiene`
--
ALTER TABLE `contiene`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `idInventario` (`idInventario`);

--
-- Indices de la tabla `empresa`
--
ALTER TABLE `empresa`
  ADD PRIMARY KEY (`idEmpresa`);

--
-- Indices de la tabla `entrega`
--
ALTER TABLE `entrega`
  ADD PRIMARY KEY (`idProducto`,`idPedido`),
  ADD KEY `idPedido` (`idPedido`);

--
-- Indices de la tabla `formula`
--
ALTER TABLE `formula`
  ADD PRIMARY KEY (`idTicket`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `gestiona`
--
ALTER TABLE `gestiona`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `idAdmin` (`idAdmin`);

--
-- Indices de la tabla `guarda`
--
ALTER TABLE `guarda`
  ADD PRIMARY KEY (`idProducto`,`idHistorial`,`tipo`,`productoHistorial`),
  ADD KEY `idHistorial` (`idHistorial`);

--
-- Indices de la tabla `historial`
--
ALTER TABLE `historial`
  ADD PRIMARY KEY (`idHistorial`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`idInventario`),
  ADD KEY `idEmpresa` (`idEmpresa`);

--
-- Indices de la tabla `oferta`
--
ALTER TABLE `oferta`
  ADD PRIMARY KEY (`idOferta`,`idProducto`),
  ADD KEY `idProducto` (`idProducto`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `piden`
--
ALTER TABLE `piden`
  ADD PRIMARY KEY (`idTicket`),
  ADD KEY `idEmpresa` (`idEmpresa`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idProducto`);

--
-- Indices de la tabla `publica`
--
ALTER TABLE `publica`
  ADD PRIMARY KEY (`idOferta`),
  ADD KEY `idEmpresa` (`idEmpresa`);

--
-- Indices de la tabla `resuelve`
--
ALTER TABLE `resuelve`
  ADD PRIMARY KEY (`idTicket`),
  ADD KEY `idAdmin` (`idAdmin`);

--
-- Indices de la tabla `supervisa`
--
ALTER TABLE `supervisa`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `idAdmin` (`idAdmin`);

--
-- Indices de la tabla `ticketdeayuda`
--
ALTER TABLE `ticketdeayuda`
  ADD PRIMARY KEY (`idTicket`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`idUsuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `idAdmin` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `carritodecompras`
--
ALTER TABLE `carritodecompras`
  MODIFY `idCarritoCompras` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `comenta`
--
ALTER TABLE `comenta`
  MODIFY `idComentario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `contiene`
--
ALTER TABLE `contiene`
  MODIFY `idProducto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `empresa`
--
ALTER TABLE `empresa`
  MODIFY `idEmpresa` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `historial`
--
ALTER TABLE `historial`
  MODIFY `idHistorial` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `idInventario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `oferta`
--
ALTER TABLE `oferta`
  MODIFY `idOferta` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `idPedido` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `ticketdeayuda`
--
ALTER TABLE `ticketdeayuda`
  MODIFY `idTicket` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `idUsuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administra`
--
ALTER TABLE `administra`
  ADD CONSTRAINT `administra_ibfk_1` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`),
  ADD CONSTRAINT `administra_ibfk_2` FOREIGN KEY (`idAdmin`) REFERENCES `administrador` (`idAdmin`);

--
-- Filtros para la tabla `agrega`
--
ALTER TABLE `agrega`
  ADD CONSTRAINT `agrega_ibfk_1` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`),
  ADD CONSTRAINT `agrega_ibfk_2` FOREIGN KEY (`idCarritoCompras`) REFERENCES `carritodecompras` (`idCarritoCompras`);

--
-- Filtros para la tabla `almacena`
--
ALTER TABLE `almacena`
  ADD CONSTRAINT `almacena_ibfk_1` FOREIGN KEY (`idCarritoCompras`) REFERENCES `carritodecompras` (`idCarritoCompras`),
  ADD CONSTRAINT `almacena_ibfk_2` FOREIGN KEY (`idPedido`) REFERENCES `pedido` (`idPedido`);

--
-- Filtros para la tabla `carritodecompras`
--
ALTER TABLE `carritodecompras`
  ADD CONSTRAINT `carritodecompras_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `comenta`
--
ALTER TABLE `comenta`
  ADD CONSTRAINT `comenta_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `comenta_ibfk_2` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`);

--
-- Filtros para la tabla `contiene`
--
ALTER TABLE `contiene`
  ADD CONSTRAINT `contiene_ibfk_1` FOREIGN KEY (`idInventario`) REFERENCES `inventario` (`idInventario`);

--
-- Filtros para la tabla `entrega`
--
ALTER TABLE `entrega`
  ADD CONSTRAINT `entrega_ibfk_1` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`),
  ADD CONSTRAINT `entrega_ibfk_2` FOREIGN KEY (`idPedido`) REFERENCES `pedido` (`idPedido`);

--
-- Filtros para la tabla `formula`
--
ALTER TABLE `formula`
  ADD CONSTRAINT `formula_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `formula_ibfk_2` FOREIGN KEY (`idTicket`) REFERENCES `ticketdeayuda` (`idTicket`);

--
-- Filtros para la tabla `gestiona`
--
ALTER TABLE `gestiona`
  ADD CONSTRAINT `gestiona_ibfk_1` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`),
  ADD CONSTRAINT `gestiona_ibfk_2` FOREIGN KEY (`idAdmin`) REFERENCES `administrador` (`idAdmin`);

--
-- Filtros para la tabla `guarda`
--
ALTER TABLE `guarda`
  ADD CONSTRAINT `guarda_ibfk_1` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`),
  ADD CONSTRAINT `guarda_ibfk_2` FOREIGN KEY (`idHistorial`) REFERENCES `historial` (`idHistorial`);

--
-- Filtros para la tabla `historial`
--
ALTER TABLE `historial`
  ADD CONSTRAINT `historial_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`);

--
-- Filtros para la tabla `oferta`
--
ALTER TABLE `oferta`
  ADD CONSTRAINT `oferta_ibfk_1` FOREIGN KEY (`idProducto`) REFERENCES `producto` (`idProducto`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`);

--
-- Filtros para la tabla `piden`
--
ALTER TABLE `piden`
  ADD CONSTRAINT `piden_ibfk_1` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`),
  ADD CONSTRAINT `piden_ibfk_2` FOREIGN KEY (`idTicket`) REFERENCES `ticketdeayuda` (`idTicket`);

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`idProducto`) REFERENCES `contiene` (`idProducto`);

--
-- Filtros para la tabla `publica`
--
ALTER TABLE `publica`
  ADD CONSTRAINT `publica_ibfk_1` FOREIGN KEY (`idEmpresa`) REFERENCES `empresa` (`idEmpresa`),
  ADD CONSTRAINT `publica_ibfk_2` FOREIGN KEY (`idOferta`) REFERENCES `oferta` (`idOferta`);

--
-- Filtros para la tabla `resuelve`
--
ALTER TABLE `resuelve`
  ADD CONSTRAINT `resuelve_ibfk_1` FOREIGN KEY (`idAdmin`) REFERENCES `administrador` (`idAdmin`),
  ADD CONSTRAINT `resuelve_ibfk_2` FOREIGN KEY (`idTicket`) REFERENCES `ticketdeayuda` (`idTicket`);

--
-- Filtros para la tabla `supervisa`
--
ALTER TABLE `supervisa`
  ADD CONSTRAINT `supervisa_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuario` (`idUsuario`),
  ADD CONSTRAINT `supervisa_ibfk_2` FOREIGN KEY (`idAdmin`) REFERENCES `administrador` (`idAdmin`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
