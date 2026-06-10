CREATE TABLE TipoUsuario (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(50) NOT NULL
);
INSERT INTO TipoUsuario (Nombre) VALUES ('Administrador'), ('Vendedor');

CREATE TABLE CategoriaProducto (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(128) NOT NULL,
    Estado BIT NOT NULL DEFAULT 1);
INSERT INTO CategoriaProducto (Nombre) VALUES ('Sin Categoría'), ('Cámaras');

CREATE TABLE Proveedor ( 
    Id INT PRIMARY KEY AUTO_INCREMENT, 
    Nombre VARCHAR(128) NOT NULL,
    Estado BIT NOT NULL DEFAULT 1);

CREATE TABLE Usuario (
    Id INT  PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(64) NOT NULL,
    Password VARCHAR(128) NOT NULL,
    Email VARCHAR(128) NOT NULL UNIQUE,
    idTipoUsuario INT NOT NULL,
    CONSTRAINT FK_Usuarios_TipoUsuario
        FOREIGN KEY (IdTipoUsuario)
        REFERENCES TipoUsuario(Id),
    Estado BIT NOT NULL DEFAULT 1
);
INSERT INTO Usuario (Username, Password, Email, idTipoUsuario) VALUES ('Admin', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'admin@admin.com', 1);

CREATE TABLE Producto (
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Nombre VARCHAR(128) NOT NULL,
    IdCategoria INT NOT NULL,
    IdProveedor INT NOT NULL,
    Precio DECIMAL(10, 2) NOT NULL,
    Estado BIT NOT NULL DEFAULT 1,
    CONSTRAINT FK_Producto_Categoria FOREIGN KEY (IdCategoria) REFERENCES CategoriaProducto(Id),
    CONSTRAINT FK_Producto_Proveedor FOREIGN KEY (IdProveedor) REFERENCES Proveedor(Id)
);

