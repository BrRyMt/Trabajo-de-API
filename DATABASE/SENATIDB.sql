CREATE DATABASE SENATIDB;

USE SENATIDB;

CREATE TABLE marcas
(
	idmarca 	INT AUTO_INCREMENT PRIMARY KEY,
	marca 		VARCHAR(30)	NOT NULL,
	create_at	DATETIME	NOT NULL DEFAULT NOW(),
	inactive_at	DATETIME	 NULL,
	update_at	DATETIME	 NULL,
	
	CONSTRAINT uk_marca_mar UNIQUE(marca)
)
ENGINE = INNODB;

INSERT INTO marcas(marca)
	VALUES
	('Toyota'),
	('Nissan'),
	('Volvon'),
	('Hyundai'),
	('KIA');
		
SELECT * FROM marcas;

CREATE TABLE vehiculos
(
	idvehiculo 	INT AUTO_INCREMENT PRIMARY KEY,
	idmarca 	INT 	NOT NULL,
	modelo		VARCHAR(50) NOT NULL,
	color		VARCHAR(30) NOT NULL,
	tipocombustible CHAR(3)     NOT NULL,
	peso		SMALLINT    NOT NULL,
	afabricacion 	CHAR(4)	    NOT NULL,
	placa		CHAR(7)	    NOT NULL,
	create_at	DATETIME    NOT NULL DEFAULT NOW(),
	inactive_at	DATETIME    NULL,
	update_at	DATETIME    NULL,
	CONSTRAINT fk_idmarca_veh FOREIGN KEY (idmarca) REFERENCES marcas(idmarca),
	CONSTRAINT CK_tipocombustible_veh CHECK (tipocombustible IN('GSL','DSL','GNV','GLP')),
	CONSTRAINT ck_peso_veh CHECK (peso >0),
	CONSTRAINT uk_placa_veh UNIQUE (placa)
)
ENGINE = INNODB;



INSERT INTO vehiculos 
	(idmarca,modelo,color,tipocombustible,peso,afabricacion,placa)
	VALUES
		(1,'Hilux','blanco','DSL',1800,'2020','ABC-111'),
		(2,'Sentra','gris','GSL',1200,'2011','ABC-112'),
		(3,'EX30','negro','GNV',1350,'2023','ABC-113'),
		(4,'Tucson','rojo','GLP',1800,'2022','ABC-114'),
		(5,'Sportage','azul','DSL',1500,'2010','ABC-115');
		
		
-------------------
DELIMITER $$
CREATE PROCEDURE spu_vehiculos_buscar (IN _placa CHAR(7))
BEGIN
	SELECT 
	VEH.idvehiculo,
	MAR.marca,
	VEH.modelo,
	VEH.color,
	VEH.tipocombustible,
	VEH.peso,
	VEH.afabricacion,
	VEH.placa
	FROM vehiculos VEH
	INNER JOIN marcas MAR ON MAR.idmarca = VEH.idmarca
	WHERE (VEH.inactive_at IS NULL) AND (VEH.placa=_placa);
END $$

CALL spu_vehiculos_buscar ('AVG-456');


DELIMITER $$	
CREATE PROCEDURE spu_vehiculos_registrar 
	(
	IN _idmarca 		INT, 
	IN _modelo 		VARCHAR(50),
	IN _color 		VARCHAR(30),
	IN _tipocombustible 	CHAR(3),
	IN _peso 		SMALLINT,
	IN _afabricacion 	CHAR(4),
	IN _placa 		CHAR(7)
	)
BEGIN 
	INSERT INTO vehiculos (idmarca,modelo,color,tipocombustible,peso,afabricacion,placa)
	VALUES (_idmarca,_modelo,_color,_tipocombustible,_peso,_afabricacion,_placa);
	
	SELECT @@last_insert_id 'idvehiculo';
END $$


CALL spu_vehiculos_registrar (1,'SanYT','azul','DSL',1800,'2020','ABC-116');
CALL spu_vehiculos_registrar (4,'Creta','azul électrico','GNV',1200,'2020','ABC-010');


SELECT * FROM vehiculos;

DELIMITER $$
CREATE PROCEDURE spu_marcas_listar()
BEGIN
	SELECT 
	idmarca,
	marca
	FROM marcas
	WHERE `inactive_at` IS NULL
	ORDER BY marca;
END$$ 

CALL `spu_marcas_listar`;

/**
DELETE FROM vehiculos;
ALTER TABLE vehiculos auto_increment 1;
Alter table vehiculos ADD CONSTRAINT uk_placa_veh UNIQUE (placa);
**/



/*#########################################################################*/
/*
	TABLA CON DATOS
	PARA BUSCAR EMPLEADOS
	INTERFAZ DE REGISTRO Y BUSQUEDA
	SELECTOR DE SEDES --- TABLAS SEDES
	BUSCAR -- BUSCAR EN UNA VISTA UNICA PARA EMPLEADOS--REGRESAR A LA PRIMERA VISTA POR UNA FORMA DE BOTONES
*/
-- IdSede
CREATE TABLE sedes
(
	idsede		INT AUTO_INCREMENT PRIMARY KEY,
	n_sede  	VARCHAR(45) NOT NULL,
	create_at	DATETIME    NOT NULL DEFAULT NOW(),
	inactive_at	DATETIME    NULL,
	update_at	DATETIME    NULL,
	CONSTRAINT uk_sede UNIQUE(n_sede)
)
ENGINE = INNODB;

INSERT INTO sedes (n_sede) VALUE
	('Ica'),
	('Lims'),
	('Cajamarca'),
	('Loreto'),
	('La Libertad');


-- Tablas de Empleados - campos de auditoria

CREATE TABLE empleados
(
	idempleado	INT 		AUTO_INCREMENT PRIMARY KEY,
	idsede		INT 		NOT NULL,
	apellidos	VARCHAR(80) 	NOT NULL,
	nombres		VARCHAR(80) 	NOT NULL,	
	nrodocumento	CHAR(8)		NOT NULL,
	fechanac	DATE		NOT NULL,
	telefono	CHAR(9)		NOT NULL,
	create_at	DATETIME    	NOT NULL DEFAULT NOW(),
	inactive_at	DATETIME    	NULL,
	update_at	DATETIME    	NULL,
	
	CONSTRAINT uk_nrodoc UNIQUE(nrodocumento),
	CONSTRAINT fk_sede   FOREIGN KEY(idsede) REFERENCES sedes(idsede),
	CONSTRAINT n_documento CHECK (LENGTH(nrodocumento)=8)

)
ENGINE = INNODB;

INSERT INTO empleados (idsede,apellidos,nombres,nrodocumento,fechanac,telefono)
VALUES(1,'Manolo','Luis','78945669','2016/3/23','933293445');


SELECT * FROM empleados;

/* PROCEDIMIEMNTO ALMACENADO LISTAR*/

DELIMITER $$
CREATE PROCEDURE spu_empleado_listar()
BEGIN
	SELECT 
	EMP.idempleado,
	EMP.nrodocumento,
	EMP.nombres,
	EMP.apellidos,
	SED.n_sede,
	EMP.fechanac,
	EMP.telefono
	FROM empleados EMP
	INNER JOIN sedes SED ON EMP.idsede = SED.idsede
	WHERE EMP.inactive_at IS NULL  
	ORDER BY nombres;
END $$

CALL spu_empleado_listar

/*PROCEDIMEINTO DE LISTAR SEDES*/

DELIMITER$$
CREATE PROCEDURE spu_sedes_listar()
BEGIN
	SELECT 
	idsede,
	n_sede
	FROM `sedes`
	WHERE `inactive_at` IS NULL
	ORDER BY n_sede;
END $$

CALL `spu_sedes_listar`;

/* PROCEDIMIENTO DE REGISTRAR */


DELIMITER $$
CREATE PROCEDURE spu_empleado_registrar
	(
	IN _idsede 		INT,
	IN _apellidos 		VARCHAR(80),
	IN _nombres		VARCHAR(80),
	IN _nrodocumento	CHAR(8),
	IN _fechanac		DATE,
	IN _telefono		CHAR(9)
	)
BEGIN
	INSERT INTO empleados (idsede,apellidos,nombres,nrodocumento,fechanac,telefono)
	VALUES (_idsede,_apellidos,_nombres,_nrodocumento,_fechanac,_telefono);
	
	SELECT @@last_insert_id 'idempleado';
END $$
/*
DELETE FROM empleados;
ALTER TABLE empleados auto_increment 1;
*/
CALL spu_empleado_registrar (1,'Martinez','Luisa','89945613','2016-3-23','933293445');

-- ----------------------------------------
CALL spu_empleado_registrar (2, 'Gomez', 'Carlos', '78896542', '2019-8-15', '933293445');
CALL spu_empleado_registrar (3, 'Rodriguez', 'Maria', '65547892', '2020-5-10', '933293445');
CALL spu_empleado_registrar (4, 'Perez', 'Juan', '77882233', '2017-11-02', '912345678');


/*CREATE PROCEDURE*/
DELIMITER $$
CREATE PROCEDURE spu_empleado_buscar(IN _nrodcoumento CHAR(9))
BEGIN
	SELECT 
	EMP.idempleado,
	EMP.nrodocumento,
	EMP.nombres,
	EMP.apellidos,
	SED.n_sede,
	EMP.fechanac,
	EMP.telefono
	FROM empleados EMP
	INNER JOIN sedes SED ON EMP.idsede = SED.idsede
	WHERE EMP.nrodocumento = _nrodcoumento;
END$$

CALL spu_empleado_buscar (89945613);


DELIMITER $$
CREATE PROCEDURE spu_grupos_sedes()
BEGIN
    SELECT
        s.n_sede AS Nombre_Sede,
        COUNT(e.idempleado) AS Empleados
    FROM
        sedes s
    LEFT JOIN
        empleados e ON s.idsede = e.idsede AND e.inactive_at IS NULL
    GROUP BY
        s.idsede, s.n_sede;
END $$

DELIMITER $$
CREATE PROCEDURE spu_resumen_tpcombustible()
BEGIN 
	SELECT 
	 `tipocombustible`,
	 COUNT(`tipocombustible`) AS 'total'
	FROM vehiculos 
	GROUP BY `tipocombustible`
	ORDER BY `total`;
END$$

CALL spu_grupos_sedes;