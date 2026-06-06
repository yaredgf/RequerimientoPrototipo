CREATE TABLE Usuario (
    Id INT  PRIMARY KEY,
    Username VARCHAR(64) NOT NULL,
    Password VARCHAR(128) NOT NULL,
    Email VARCHAR(128) NOT NULL UNIQUE,
    idTipoUsuario INT NOT NULL,
    CONSTRAINT FK_Usuarios_TipoUsuario
        FOREIGN KEY (IdTipoUsuario)
        REFERENCES TipoUsuario(IdTipoUsuario),
    Estado BIT NOT NULL DEFAULT 1
);