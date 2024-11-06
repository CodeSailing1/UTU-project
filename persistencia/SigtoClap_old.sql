CREATE DATABASE sigto;
USE sigto;

CREATE TABLE Usuario(
    idUsuario INT AUTO_INCREMENT,
    nombreUsuario VARCHAR(30) NOT NULL,
    emailUsuario VARCHAR(30) NOT NULL,
    telefonoUsuario INT NOT NULL,
    contraseniaUsuario VARCHAR(255) NOT NULL,
    direccionUsuario VARCHAR(250) NOT NULL,
    fotoDePerfilUsuario BLOB NOT NULL,
    inactivoUsuario BOOLEAN NOT NULL,
    PRIMARY KEY(idUsuario));

CREATE TABLE TicketDeAyuda(
    idTicket INT AUTO_INCREMENT,
    asuntoTicket VARCHAR(250) NOT NULL,
    fechaTicket DATE NOT NULL,
    PRIMARY KEY(idTicket));

CREATE TABLE Empresa(
    idEmpresa INT AUTO_INCREMENT,
    nombreEmpresa VARCHAR(30) NOT NULL,
    emailEmpresa VARCHAR(30) NOT NULL,
    telefonoEmpresa INT NOT NULL,
    contraseniaEmpresa VARCHAR(255) NOT NULL,
    direccionEmpresa VARCHAR(250) NOT NULL,
    fotoDePerfilEmpresa BLOB NOT NULL,
    inactivoEmpresa BOOLEAN NOT NULL,
    PRIMARY KEY(idEmpresa));

CREATE TABLE Inventario(
    idInventario INT AUTO_INCREMENT,
    idEmpresa INT,
    stock INT NOT NULL,
    categorias VARCHAR(25) NOT NULL,
    PRIMARY KEY(idInventario),
    FOREIGN KEY(idEmpresa) REFERENCES Empresa(idEmpresa));

CREATE TABLE Producto(
    idProducto INT AUTO_INCREMENT,
    nombreProducto VARCHAR(30) NOT NULL,
    precioProducto INT UNSIGNED NOT NULL,
    categoriaProducto VARCHAR(250) NOT NULL,
    descripcionProducto VARCHAR(250) NOT NULL,
    valoracionProducto INT NOT NULL,
    imagenProducto BLOB NOT NULL,
    inactivoProducto BOOLEAN NOT NULL,
    PRIMARY KEY(idProducto));

CREATE TABLE Pedido(
    idPedido INT AUTO_INCREMENT,
    idUsuario INT,
    tipo ENUM('Delivery', 'PickUp') NOT NULL,
    metodoDePago ENUM('Paypal', 'Debito', 'Credito', 'Red de cobranza') NOT NULL,
    PRIMARY KEY(idPedido),
    FOREIGN KEY(idUsuario) REFERENCES Usuario(idUsuario));

CREATE TABLE CarritoDeCompras(
    idCarritoCompras INT AUTO_INCREMENT,
    idUsuario INT,
    fechaCreacion DATE NOT NULL,
    estado ENUM('Vacio', 'En curso', 'En pago') NOT NULL,
    PRIMARY KEY(idCarritoCompras),
    FOREIGN KEY(idUsuario) REFERENCES Usuario(idUsuario));

CREATE TABLE Historial(
    idHistorial INT AUTO_INCREMENT,
    idUsuario INT,
    fechaHistorial DATE NOT NULL,
    PRIMARY KEY(idHistorial),
    FOREIGN KEY(idUsuario) REFERENCES Usuario(idUsuario));

CREATE TABLE Oferta(
    idOferta INT AUTO_INCREMENT,
    idProducto INT,
    descuento INT NOT NULL,
    nombreOferta VARCHAR(30) NOT NULL,
    inicioOferta DATE NOT NULL,
    finOferta DATE NOT NULL,
    inactivoOferta BOOLEAN NOT NULL,
    PRIMARY KEY(idOferta, idProducto),
    FOREIGN KEY(idProducto) REFERENCES Producto(idProducto));

CREATE TABLE Formula(
    idUsuario INT,
    idTicket INT,
    PRIMARY KEY(idUsuario, idTicket),
    FOREIGN KEY(idUsuario) REFERENCES usuario(idUsuario),
    FOREIGN KEY(idTicket) REFERENCES ticketDeAyuda(idTicket));

CREATE TABLE Piden(
    idEmpresa INT,
    idTicket INT,
    PRIMARY KEY(idEmpresa, idTicket),
    FOREIGN KEY(idEmpresa) REFERENCES empresa(idEmpresa),
    FOREIGN KEY(idTicket) REFERENCES ticketDeAyuda(idTicket));

CREATE TABLE Contiene(
    idProducto INT,
    idInventario INT,
    PRIMARY KEY(idProducto),
    FOREIGN KEY(idProducto) REFERENCES producto(idProducto),
    FOREIGN KEY(idInventario) REFERENCES inventario(idInventario));

CREATE TABLE Agrega(
    idProducto INT,
    idCarritoCompras INT,
    cantidad INT UNSIGNED NOT NULL,
    PRIMARY KEY(idProducto, idCarritoCompras),
    FOREIGN KEY(idProducto) REFERENCES producto(idProducto),
    FOREIGN KEY(idCarritoCompras) REFERENCES carritodecompras(idCarritoCompras));

CREATE TABLE Guarda(
    idProducto INT,
    idHistorial INT,
    PRIMARY KEY(idProducto, idHistorial),
    FOREIGN KEY(idProducto) REFERENCES producto(idProducto),
    FOREIGN KEY(idHistorial) REFERENCES historial(idHistorial));

CREATE TABLE Entrega(
    idProducto INT,
    idPedido INT,
    PRIMARY KEY(idProducto, idPedido),
    FOREIGN KEY(idProducto) REFERENCES producto(idProducto),
    FOREIGN KEY(idPedido) REFERENCES pedido(idPedido));

CREATE TABLE Almacena(
    idCarritoCompras INT,
    idPedido INT,
    PRIMARY KEY(idPedido),
    FOREIGN KEY(idCarritoCompras) REFERENCES carritodecompras(idCarritoCompras),
    FOREIGN KEY(idPedido) REFERENCES pedido(idPedido));

CREATE TABLE Publica(
    idEmpresa INT,
    idOferta INT,
    PRIMARY KEY(idOferta),
    FOREIGN KEY(idEmpresa) REFERENCES empresa(idEmpresa),
    FOREIGN KEY(idOferta) REFERENCES oferta(idOferta));

CREATE TABLE Comenta(
    idComentario INT AUTO_INCREMENT,
    fechaComentario DATE NOT NULL,
    idUsuario INT,
    idProducto INT,
    PRIMARY KEY(idComentario, idProducto),
    FOREIGN KEY(idUsuario) REFERENCES usuario(idUsuario),
    FOREIGN KEY(idProducto) REFERENCES producto(idProducto));

