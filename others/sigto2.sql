USE sigto;

CREATE TABLE usuario(
    idUsuario INT UNSIGNED AUTO_INCREMENT,
    nombreUsuario VARCHAR(30) NOT NULL,
    emailUsuario VARCHAR(30) NOT NULL,
    telefonoUsuario INT UNSIGNED NOT NULL,
    contraseniaUsuario VARCHAR(255) NOT NULL,
    direccionUsuario VARCHAR(250) NOT NULL,
    fotoDePerfilUsuario BLOB NOT NULL, 
    inactivoUsuario BOOLEAN NOT NULL,
    idGoogle INT UNSIGNED NOT NULL,
    PRIMARY KEY(idUsuario)
);

CREATE TABLE ticketDeAyuda(
    idTicket INT UNSIGNED AUTO_INCREMENT,
    asuntoTicket VARCHAR(250) NOT NULL,
    fechaTicket DATETIME NOT NULL,
    PRIMARY KEY(idTicket)
);

CREATE TABLE empresa(
    idEmpresa INT UNSIGNED AUTO_INCREMENT,
    nombreEmpresa VARCHAR(30) NOT NULL,
    emailEmpresa VARCHAR(30) NOT NULL,
    telefonoEmpresa INT UNSIGNED NOT NULL,
    contraseniaEmpresa VARCHAR(255) NOT NULL,
    direccionEmpresa VARCHAR(250) NOT NULL,
    fotoDePerfilEmpresa BLOB NOT NULL,
    inactivoEmpresa BOOLEAN NOT NULL,
    PRIMARY KEY(idEmpresa)
);

CREATE TABLE administrador(
    idAdmin INT UNSIGNED AUTO_INCREMENT,
    nombreAdmin VARCHAR(30) NOT NULL,
    emailAdmin VARCHAR(30) NOT NULL,
    telefonoAdmin INT UNSIGNED NOT NULL,
    contraseniaAdmin VARCHAR(255) NOT NULL,
    inactivoAdmin BOOLEAN NOT NULL,
    PRIMARY KEY(idAdmin)
);

CREATE TABLE producto(
    idProducto INT UNSIGNED AUTO_INCREMENT,
    nombreProducto VARCHAR(30) NOT NULL,
    precioProducto INT UNSIGNED NOT NULL,
    categoriaProducto ENUM ('juegos y consolas', 'musica', 'libros', 'celulares', 'ropa', 
                            'muebles', 'deportes', 'joyeria', 'herramientas', 'salud y belleza') NOT NULL,
    descripcionProducto VARCHAR(250) NOT NULL,
    valoracionProducto INT UNSIGNED,
    imagenProducto BLOB NOT NULL,
    ventasProducto INT UNSIGNED,
    fechaProducto DATETIME NOT NULL,
    visitasProducto INT UNSIGNED,
    inactivoProducto BOOLEAN NOT NULL,
    PRIMARY KEY(idProducto)
);

CREATE TABLE oferta(
    idOferta INT UNSIGNED AUTO_INCREMENT,
    idProducto INT UNSIGNED,
    descuento INT NOT NULL,
    nombreOferta VARCHAR(30) NOT NULL,
    inicioOferta DATETIME NOT NULL,
    finOferta DATETIME,
    inactivoOferta BOOLEAN NOT NULL,
    PRIMARY KEY(idOferta),
    FOREIGN KEY(idProducto) REFERENCES producto(idProducto)
);

CREATE TABLE inventario(
    idInventario INT UNSIGNED AUTO_INCREMENT,
    idEmpresa INT UNSIGNED,
    fechaCreacion DATETIME NOT NULL,
    PRIMARY KEY(idInventario),
    FOREIGN KEY(idEmpresa) REFERENCES empresa(idEmpresa)
);

CREATE TABLE contiene(
    idInventario INT UNSIGNED,
    idProducto INT UNSIGNED AUTO_INCREMENT,
    stock INT UNSIGNED NOT NULL,
    PRIMARY KEY(idProducto),
    FOREIGN KEY(idInventario) REFERENCES inventario(idInventario)
);

CREATE TABLE pedido(
    idPedido INT UNSIGNED AUTO_INCREMENT,
    idUsuario INT UNSIGNED,
    tipo ENUM('Delivery', 'PickUp') NOT NULL,
    metodoDePago ENUM('Paypal', 'Debito', 'Credito', 'Red de cobranza') NOT NULL,
    PRIMARY KEY(idPedido),
    FOREIGN KEY(idUsuario) REFERENCES usuario(idUsuario)
);

CREATE TABLE carritoDeCompras(
    idCarritoCompras INT UNSIGNED AUTO_INCREMENT,
    idUsuario INT UNSIGNED,
    fechaCreacion DATETIME NOT NULL,
    estado ENUM('Vacio', 'En curso', 'En pago') NOT NULL,
    PRIMARY KEY(idCarritoCompras),
    FOREIGN KEY(idUsuario) REFERENCES usuario(idUsuario)
);

CREATE TABLE historial(
    idHistorial INT UNSIGNED AUTO_INCREMENT,
    idUsuario INT UNSIGNED,
    fechaHistorial DATETIME NOT NULL,
    PRIMARY KEY(idHistorial),
    FOREIGN KEY(idUsuario) REFERENCES usuario(idUsuario)
);

CREATE TABLE formula(
    idUsuario INT UNSIGNED,
    idTicket INT UNSIGNED,
    PRIMARY KEY(idTicket),
    FOREIGN KEY(idUsuario) REFERENCES usuario(idUsuario),
    FOREIGN KEY(idTicket) REFERENCES ticketDeAyuda(idTicket)
);

CREATE TABLE piden(
    idEmpresa INT UNSIGNED,
    idTicket INT UNSIGNED,
    PRIMARY KEY(idTicket),
    FOREIGN KEY(idEmpresa) REFERENCES empresa(idEmpresa),
    FOREIGN KEY(idTicket) REFERENCES ticketDeAyuda(idTicket)
);

CREATE TABLE resuelve(
    idAdmin INT UNSIGNED,
    idTicket INT UNSIGNED,
    PRIMARY KEY(idTicket),
    FOREIGN KEY(idAdmin) REFERENCES administrador(idAdmin),
    FOREIGN KEY(idTicket) REFERENCES ticketDeAyuda(idTicket)
);

CREATE TABLE agrega(
    idProducto INT UNSIGNED,
    idCarritoCompras INT UNSIGNED,
    cantidad INT UNSIGNED NOT NULL,
    PRIMARY KEY(idProducto, idCarritoCompras),
    FOREIGN KEY(idProducto) REFERENCES producto(idProducto),
    FOREIGN KEY(idCarritoCompras) REFERENCES carritoDeCompras(idCarritoCompras)
);

CREATE TABLE guarda(
    idProducto INT UNSIGNED,
    idHistorial INT UNSIGNED,
    cantidad INT UNSIGNED,
    precioCompra INT UNSIGNED,
    productoHistorial DATETIME NOT NULL,
    tipo ENUM('Visita', 'Compra') NOT NULL,
    PRIMARY KEY(idProducto, idHistorial, tipo, precioCompra),
    FOREIGN KEY(idProducto) REFERENCES producto(idProducto),
    FOREIGN KEY(idHistorial) REFERENCES historial(idHistorial)
);

CREATE TABLE entrega(
    idProducto INT UNSIGNED,
    idPedido INT UNSIGNED,
    PRIMARY KEY(idProducto, idPedido),
    FOREIGN KEY(idProducto) REFERENCES producto(idProducto),
    FOREIGN KEY(idPedido) REFERENCES pedido(idPedido)
);

CREATE TABLE almacena(
    idCarritoCompras INT UNSIGNED,
    idPedido INT UNSIGNED,
    PRIMARY KEY(idPedido),
    FOREIGN KEY(idCarritoCompras) REFERENCES carritoDeCompras(idCarritoCompras),
    FOREIGN KEY(idPedido) REFERENCES pedido(idPedido)
);

CREATE TABLE publica(
    idEmpresa INT UNSIGNED,
    idOferta INT UNSIGNED,
    PRIMARY KEY(idOferta),
    FOREIGN KEY(idEmpresa) REFERENCES empresa(idEmpresa),
    FOREIGN KEY(idOferta) REFERENCES oferta(idOferta)
);

CREATE TABLE comenta(
    idComentario INT UNSIGNED AUTO_INCREMENT,
    textoComentario VARCHAR(300),
    fechaComentario DATETIME NOT NULL,
    idUsuario INT UNSIGNED,
    idProducto INT UNSIGNED,
    PRIMARY KEY(idComentario, idProducto),
    FOREIGN KEY(idUsuario) REFERENCES usuario(idUsuario),
    FOREIGN KEY(idProducto) REFERENCES producto(idProducto)
);

CREATE TABLE administra(
    idEmpresa INT UNSIGNED,
    idAdmin INT UNSIGNED,
    PRIMARY KEY(idEmpresa),
    FOREIGN KEY(idEmpresa) REFERENCES empresa(idEmpresa),
    FOREIGN KEY(idAdmin) REFERENCES administrador(idAdmin)
);

CREATE TABLE gestiona(
    idProducto INT UNSIGNED,
    idAdmin INT UNSIGNED,
    PRIMARY KEY(idProducto),
    FOREIGN KEY(idProducto) REFERENCES producto(idProducto),
    FOREIGN KEY(idAdmin) REFERENCES administrador(idAdmin)
);

CREATE TABLE supervisa(
    idUsuario INT UNSIGNED,
    idAdmin INT UNSIGNED,
    PRIMARY KEY(idUsuario),
    FOREIGN KEY(idUsuario) REFERENCES usuario(idUsuario),
    FOREIGN KEY(idAdmin) REFERENCES administrador(idAdmin)
);
