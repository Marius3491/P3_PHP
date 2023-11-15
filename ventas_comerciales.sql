--
-- Base de datos: `ventas_comerciales`
--
CREATE DATABASE IF NOT EXISTS `ventas_comerciales` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `ventas_comerciales`;

--
-- Estructura de las tablas
--
create table IF NOT EXISTS Comerciales (
	codigo		varchar(3) primary key,
	nombre		varchar(30) not null,
	salario		float not null,
	hijos		int not null,
	fNacimiento	date not null
	);

create table IF NOT EXISTS Productos (
	referencia		varchar(6) primary key,
	nombre		varchar(20) not null,
	descripcion	varchar(20),
	precio		float not null,
	descuento	int not null
);


create table IF NOT EXISTS Ventas (
	codComercial	varchar(3),
	refProducto		varchar(6),
	cantidad		int,
	fecha			date,
	primary key (codComercial, refProducto, fecha),
	foreign key (codComercial) references Comerciales(codigo),
	foreign key (refProducto) references Productos(referencia)
);

--
-- Inserción de datos
--

insert into Comerciales values ('111','Pedro Alonso Jiménez',1200.50,0,'1960/01/02');
insert into Comerciales values ('222','Julia Pérez Arribas',1305.75,1,'1971/11/12');
insert into Comerciales values ('333','Juan Lozano Gómez',1080.25,3,'1975/01/08');
insert into Comerciales values ('444','Sandra Molina Sánchez',1120.00,2,'1969/09/05');
insert into Comerciales values ('555','Salvador Beltrán Jiménez',975.50,0,'1980/11/10');
insert into Comerciales values ('666','Beatriz Martín Gutiérrez',1175.00,1,'1970/06/11');
insert into Comerciales values ('777','Eduardo Martínez Puig',1100.50,2,'1967/06/01');
insert into Comerciales values ('888','Juan Antonio Ochando Serrano',1000.50,0,'1982/03/03');
insert into Comerciales values ('999','Marina Pérez Blanco',1070.20,3,'1972/11/07');


insert into Productos values ('AC0001', 'Abrigo Caballero', 'Piel Color Marrón',  120.50, 15);
insert into Productos values ('AS0001', 'Abrigo Señora', 'Piel Color Marrón',  110.75, 25);
insert into Productos values ('CC0001', 'Camisa Caballero', 'Cuadros',  35.99, 10);
insert into Productos values ('PC0001', 'Pantalón Caballero', 'Vaquero',  34.90, 35);
insert into Productos values ('PC0002', 'Pantalón Caballero', 'Pana',  25.90, 0);
insert into Productos values ('AC0002', 'Abrigo Caballero', 'Piel Color Negro',  120.50, 15);
insert into Productos values ('CC0002', 'Camisa Caballero', 'Lisa Color Blanco',  35.99, 10);
insert into Productos values ('CC0003', 'Camisa Caballero', 'Lisa Color Azul',  35.99, 10);
insert into Productos values ('AS0002', 'Abrigo Señora', 'Piel Color Negro',  120.75, 15);
insert into Productos values ('AS0003', 'Abrigo Señora', 'Ante  Color Marrón',  90.95, 35);
insert into Productos values ('PS0001', 'Pantalón Señora', 'Vaquero',  30.90, 30);
insert into Productos values ('PS0002', 'Pantalón Señora', 'Lino',  39.90, 40);


insert into Ventas values ('111','PC0001',24,'2014/10/10');
insert into Ventas values ('111','PC0002',48,'2014/03/22');
insert into Ventas values ('222','AS0001',34,'2014/10/10');
insert into Ventas values ('222','AC0001',60,'2014/06/09');
insert into Ventas values ('222','AS0002',21,'2014/10/11');
insert into Ventas values ('333','AC0001',15,'2014/11/02');
insert into Ventas values ('333','AC0002',80,'2014/09/02');
insert into Ventas values ('333','CC0003',10,'2014/09/06');
insert into Ventas values ('444','CC0001',75,'2014/08/06');
insert into Ventas values ('555','PC0002',35,'2014/02/02');
insert into Ventas values ('666','CC0002',21,'2014/11/05');
insert into Ventas values ('666','CC0001',50,'2014/11/03');
insert into Ventas values ('666','CC0002',78,'2014/02/03');
insert into Ventas values ('777','AC0002',39,'2014/07/03');
insert into Ventas values ('777','AS0003',18,'2014/11/05');
insert into Ventas values ('888','PS0002',33,'2014/10/04');
insert into Ventas values ('888','PC0002',76,'2014/01/02');
insert into Ventas values ('888','CC0003',50,'2014/01/02');
insert into Ventas values ('999','AS0003',60,'2014/01/02');
insert into Ventas values ('999','AC0002',47,'2014/01/02');
insert into Ventas values ('999','PC0001',80,'2014/01/02');

GRANT ALL PRIVILEGES ON ventas_comerciales.* TO 'dwes'@'localhost';