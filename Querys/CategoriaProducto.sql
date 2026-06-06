USE RequerimientoPrototipo;
CREATE TABLE CategoriaProducto (
    Id INT PRIMARY KEY,
    Nombre VARCHAR(128) NOT NULL,
    Estado BIT NOT NULL DEFAULT 1);