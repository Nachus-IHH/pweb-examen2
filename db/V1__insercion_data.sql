-- Hernandez Hernandez Ignacio - 23200144
-- Lara Cruz Brandon Javier - 23200146
-- Santiago Padilla Rubén - 23200158

USE bd_almacen;
-- Inserción de datos

INSERT INTO rol (rol_nombre, rol_descripcion) VALUES 
('ADMINISTRADOR', 'Administrador General de la Empresa'),
('VENTAS', 'Gerente de Ventas'),
('COMPRAS', 'Gerente de Compras'),
('CLIENTE', 'Cliente general, sin distincion inicial');


INSERT INTO usuario (usu_nombre, usu_apellido_paterno, usu_apellido_materno, usu_telefono, usu_correo, usu_fecha_registro, usu_usuario, usu_password, rol_cve_rol) VALUES 
('Pedro', 'Perez', 'Roig', '771-234-234', 'pperez@gmail.com', NOW(), 'pperez', 'itp2026', 1),
('Luis', 'Ruiz', 'Lopez', '771-876-321', 'lruiz@gmail.com', NOW(), 'lruiz', 'itp2026', 2),
('Ana', 'Bell', 'Ring', '771-123-987', 'bbell@gmail.com', NOW(), 'bbell', 'itp2026', 4);

INSERT INTO producto 
(PRO_NOMBRE, PRO_DESCRIPCION, PRO_PRECIO, PRO_CANTIDAD, PRO_ACTIVO, PRO_FOTO, PRO_ESTATUS) 
VALUES
('Jabón Rosa', 'Jabón de tocador rosa', 18.50, 15, 1, 'imagenes/productos/1.jpg', 'DISPONIBLE'),
('Cloralex', 'Cloro desinfectante', 22.00, 20, 1, 'imagenes/productos/2.jpg', 'DISPONIBLE'),
('Shampoo Head & Shoulders', 'Shampoo control caspa', 85.00, 8, 1, 'imagenes/productos/3.jpg', 'DISPONIBLE'),
('Desodorante Dove', 'Desodorante en barra', 58.00, 5, 1, 'imagenes/productos/4.jpg', 'DISPONIBLE'),
('Pasta Colgate', 'Pasta dental Colgate Triple Acción', 32.00, 6, 1, 'imagenes/productos/5.jpg', 'DISPONIBLE'),
('Cepillo Dental', 'Cepillo de dientes suave', 25.00, 12, 1, 'imagenes/productos/6.jpg', 'DISPONIBLE'),
('Salsa Valentina', 'Salsa picante Valentina', 18.00, 18, 1, 'imagenes/productos/7.jpg', 'DISPONIBLE'),
('Salsa Búfalo', 'Salsa picante Búfalo', 16.50, 30, 1, 'imagenes/productos/8.jpg', 'DISPONIBLE'),
('Mermelada McCormick', 'Mermelada de fresa', 42.00, 7, 1, 'imagenes/productos/9.jpg', 'DISPONIBLE'),
('Leche Condensada La Lechera', 'Leche condensada Nestlé La Lechera', 28.50, 10, 1, 'imagenes/productos/10.jpg', 'DISPONIBLE'),
('Leche Evaporada Carnation', 'Leche evaporada Carnation Clavel', 21.00, 9, 1, 'imagenes/productos/11.jpg', 'DISPONIBLE'),
('Polvo Tang', 'Bebida en polvo sabor naranja', 6.50, 5, 1, 'imagenes/productos/12.jpg', 'DISPONIBLE'),
('Coca-Cola', 'Refresco de cola en botella de vidrio', 18.00, 11, 1, 'imagenes/productos/13.jpg', 'DISPONIBLE'),
('Refresco Red Cola', 'Refresco Red Cola de 600 ml', 13.00, 25, 1, 'imagenes/productos/14.jpg', 'DISPONIBLE'),
('Atún Herdez', 'Lata de atún en agua Herdez', 21.50, 20, 1, 'imagenes/productos/15.jpg', 'DISPONIBLE'),
('Frijoles La Costeña', 'Frijoles refritos La Costeña', 16.00, 8, 1, 'imagenes/productos/16.jpg', 'DISPONIBLE'),
('Leche Nutri Leche', 'Producto lácteo combinado Nutri', 22.50, 4, 1, 'imagenes/productos/17.jpg', 'DISPONIBLE'),
('Mostaza French\'s', 'Mostaza preparada French\'s', 34.00, 6, 1, 'imagenes/productos/18.jpg', 'DISPONIBLE'),
('Chiles San Marcos', 'Lata de chiles jalapeños San Marcos', 24.00, 3, 1, 'imagenes/productos/19.jpg', 'DISPONIBLE'),
('Mayonesa McCormick', 'Mayonesa McCormick con jugo de limones', 52.00, 9, 1, 'imagenes/productos/20.jpg', 'DISPONIBLE');
