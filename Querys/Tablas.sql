CREATE TABLE TipoUsuario (
    IdTipoUsuario INT PRIMARY KEY,
    Nombre VARCHAR(50) NOT NULL
);
INSERT INTO TipoUsuario (IdTipoUsuario, Nombre) VALUES (1, 'Administrador'), (2, 'Vendedor');

CREATE TABLE CategoriaProducto (
    Id INT PRIMARY KEY,
    Nombre VARCHAR(128) NOT NULL,
    Estado BIT NOT NULL DEFAULT 1);

CREATE TABLE Proveedor ( 
    Id INT PRIMARY KEY, 
    Nombre VARCHAR(128) NOT NULL,
    Estado BIT NOT NULL DEFAULT 1);

CREATE TABLE Usuario (
    Id INT  PRIMARY KEY,
    Username VARCHAR(64) NOT NULL,
    Password VARCHAR(128) NOT NULL,
    idTipoUsuario INT NOT NULL,
    CONSTRAINT FK_Usuarios_TipoUsuario
        FOREIGN KEY (IdTipoUsuario)
        REFERENCES TipoUsuario(IdTipoUsuario),
    Estado BIT NOT NULL DEFAULT 1
);

CREATE TABLE Producto (
    Id INT PRIMARY KEY,
    Nombre VARCHAR(128) NOT NULL,
    IdCategoria INT NOT NULL,
    IdProveedor INT NOT NULL,
    Precio DECIMAL(10, 2) NOT NULL,
    Estado BIT NOT NULL DEFAULT 1,
    CONSTRAINT FK_Producto_Categoria FOREIGN KEY (IdCategoria) REFERENCES CategoriaProducto(Id),
    CONSTRAINT FK_Producto_Proveedor FOREIGN KEY (IdProveedor) REFERENCES Proveedor(Id)
);

