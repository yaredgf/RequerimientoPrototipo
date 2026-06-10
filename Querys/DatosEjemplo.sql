
INSERT INTO CategoriaProducto (Nombre)
VALUES
('Sin Categoría'),
('Tubería Cableado'),
('Cableado'),
('Alarma Antirobo'),
('Monitor Camaras'),
('Alarma Incendios'),
('CamarasCCTV');


INSERT INTO Proveedor (Nombre)
VALUES
('FireLite'),
('Schneider Electric'),
('Notifier');

INSERT INTO Usuario (Username, Password, Email, idTipoUsuario)
VALUES
('admin', 'admin123', 'admin@admin.com', 1),
('gabcer', '9231', 'gacerdascr@gmail.com', 1),
('yaredgf', 'yau', 'yaredgf@gmail.com', 1),
('bsmol21', 'sapito', 'bsmol21@gmail.com', 1),
('geyni', 'mipapa', 'gcerdas@gmail.com', 2);


INSERT INTO Producto (Nombre, IdCategoria, IdProveedor, Precio)
VALUES
('Cable UTP Cat5e', 3, 1, 150.00),
('Cámara de Seguridad HD', 6, 2, 1200.00),
('Sensor de Movimiento', 4, 3, 350.00),
('Monitor de Video', 5, 1, 800.00),
('Alarma de Incendios', 6, 2, 500.00);