CREATE TABLE TipoUsuario (
    IdTipoUsuario INT PRIMARY KEY,
    Nombre VARCHAR(50) NOT NULL
);
INSERT INTO TipoUsuario (IdTipoUsuario, Nombre) VALUES (1, 'Administrador'), (2, 'Vendedor');
