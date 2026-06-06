USE RequerimientoPrototipo;
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