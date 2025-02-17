SHOW DATABASES;
DROP DATABASE almacen;
CREATE DATABASE almacen;
USE almacen;

CREATE TABLE empleados(
id_empleado BIGINT PRIMARY KEY auto_increment,
empleado VARCHAR(40),
domicilio VARCHAR(50),
celular VARCHAR(20),
id_puesto BIGINT,
activo VARCHAR(1)
);

CREATE TABLE puestos(
id_puesto BIGINT PRIMARY KEY auto_increment,
puesto VARCHAR(20),
sueldo DECIMAL(15,2)
);

CREATE TABLE consultas(
id_consulta BIGINT PRIMARY KEY auto_increment,
id_empleado BIGINT,
id_material BIGINT,
id_usuario BIGINT,
fecha DATE,
cancelada VARCHAR(1)
);

CREATE TABLE materiales(
id_material BIGINT PRIMARY KEY auto_increment,
material VARCHAR(40),
existencia int,
precio DECIMAL(15,2),
disponible VARCHAR(1)
);

CREATE TABLE usuarios(
id_usuario BIGINT PRIMARY KEY auto_increment,
usuario VARCHAR(40),
cuenta VARCHAR(50),
clave VARCHAR(128),
nivel int,
idioma int,
autorizado VARCHAR(1)
);

-- Insertar datos en la tabla empleados
INSERT INTO empleados (empleado, domicilio, celular, id_puesto, activo) VALUES
('Juan Pérez', 'Calle 123, Ciudad', '555-1234', 1, 'S'),
('María Gómez', 'Avenida 456, Ciudad', '555-5678', 2, 'S'),
('Carlos Ramírez', 'Boulevard 789, Ciudad', '555-9101', 3, 'N');

-- Insertar datos en la tabla puestos
INSERT INTO puestos (puesto, sueldo) VALUES
('Gerente', 25000.00),
('Supervisor', 18000.00),
('Operario', 12000.00);

-- Insertar datos en la tabla materiales
INSERT INTO materiales (material, existencia, precio, disponible) VALUES
('Laptop Dell', 10, 15000.00, 'S'),
('Teclado Mecánico', 25, 1200.00, 'S'),
('Monitor 24"', 15, 3500.00, 'N');

-- Insertar datos en la tabla usuarios
INSERT INTO usuarios (usuario, cuenta, clave, nivel, idioma, autorizado) VALUES
('admin', 'root@gmail.com', SHA2('123',256), 1, 1, 'S'),
('Javier Armando Sarmiento Gil','jsdash10000@gmail.com',  SHA2('TheJavZs24.UwU_',256), 2, 1, 'S');

-- Insertar datos en la tabla consultas
INSERT INTO consultas (id_empleado, id_material, id_usuario, fecha, cancelada) VALUES
(1, 1, 1, 20240701, 'N'),
(2, 2, 2, 20240702, 'S'),
(3, 3, 3, 20240703, 'N');
