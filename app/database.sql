DROP DATABASE IF EXISTS `bd_superheroes`;
CREATE DATABASE IF NOT EXISTS `bd_superheroes`;
USE `bd_superheroes`;


CREATE TABLE IF NOT EXISTS `bd_superheroes`.`evolucion` (
  `evolucion` ENUM('PRINCIPIANTE', 'EXPERTO') NOT NULL,
  PRIMARY KEY (`evolucion`)
  );


CREATE TABLE IF NOT EXISTS `bd_superheroes`.`habilidades` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
  );
  
  CREATE TABLE IF NOT EXISTS `bd_superheroes`.`usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `usuario` VARCHAR(45) NOT NULL,
  `psw` VARCHAR(45) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   PRIMARY KEY (`id`),
  CONSTRAINT UC_user UNIQUE (usuario)
  );
  
CREATE TABLE IF NOT EXISTS `superheroes` (
  `id` INT AUTO_INCREMENT NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `imagen` VARCHAR(45),
  `evolucion` ENUM('PRINCIPIANTE', 'EXPERTO') NOT NULL,
  `idUsuario` INT NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
   CONSTRAINT `fk1_superheroes`
   FOREIGN KEY (`evolucion`)
   REFERENCES `bd_superheroes`.`evolucion` (`evolucion`)
   ON DELETE CASCADE
   ON UPDATE CASCADE,
   CONSTRAINT `fk2_superheroes`
   FOREIGN KEY (`idUsuario`)
   REFERENCES `bd_superheroes`.`usuarios` (`id`)
   ON DELETE CASCADE
   ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS `superheroes_habilidades` (
  `id` INT AUTO_INCREMENT NOT NULL,
  `idSuperheroe` INT NOT NULL,
   `idHabilidad` INT NOT NULL,
  `valor` INT NOT NULL,
  PRIMARY KEY (`id`),
   CONSTRAINT `fk1_superheroes_habilidades`
   FOREIGN KEY (`idSuperheroe`)
   REFERENCES `bd_superheroes`.`superheroes` (`id`)
   ON DELETE CASCADE
   ON UPDATE CASCADE,
   CONSTRAINT `fk2_superheroes_habilidades`
   FOREIGN KEY (`idHabilidad`)
   REFERENCES `bd_superheroes`.`habilidades` (`id`)
   ON DELETE CASCADE
   ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS `ciudadanos` (
  `id` INT AUTO_INCREMENT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `idUsuario` INT NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
   CONSTRAINT `fk1_ciudadanos`
   FOREIGN KEY (`idUsuario`)
   REFERENCES `bd_superheroes`.`usuarios` (`id`)
   ON DELETE CASCADE
   ON UPDATE CASCADE
);

CREATE TABLE IF NOT EXISTS `peticiones` (
  `id` INT AUTO_INCREMENT NOT NULL,
  `titulo` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(45) NOT NULL,
  `realizada` BOOLEAN NOT NULL,
  `idSuperheroe` INT NOT NULL,
  `idCiudadano` INT NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
   CONSTRAINT `fk1_peticiones`
   FOREIGN KEY (`idSuperHeroe`)
   REFERENCES `bd_superheroes`.`superheroes` (`id`)
   ON DELETE CASCADE
   ON UPDATE CASCADE,
   CONSTRAINT `fk2_peticiones`
   FOREIGN KEY (`idCiudadano`)
   REFERENCES `bd_superheroes`.`ciudadanos` (`id`)
   ON DELETE CASCADE
   ON UPDATE CASCADE
);


CREATE TRIGGER `update_updated_at1` 
BEFORE UPDATE 
ON `habilidades` FOR EACH ROW 
SET NEW.updated_at = CURRENT_TIMESTAMP;

CREATE TRIGGER `update_updated_at2` 
BEFORE UPDATE 
ON `usuarios` FOR EACH ROW 
SET NEW.updated_at = CURRENT_TIMESTAMP;

CREATE TRIGGER `update_updated_at3` 
BEFORE UPDATE 
ON `superheroes` FOR EACH ROW 
SET NEW.updated_at = CURRENT_TIMESTAMP;

CREATE TRIGGER `update_updated_at4` 
BEFORE UPDATE 
ON `ciudadanos` FOR EACH ROW 
SET NEW.updated_at = CURRENT_TIMESTAMP;

CREATE TRIGGER `update_updated_at5` 
BEFORE UPDATE 
ON `peticiones` FOR EACH ROW 
SET NEW.updated_at = CURRENT_TIMESTAMP;

INSERT INTO `evolucion` VALUES ('PRINCIPIANTE');
INSERT INTO `evolucion` VALUES ('EXPERTO');

INSERT INTO `habilidades` (`nombre`) VALUES ('volar');

INSERT INTO `usuarios` (`usuario`, `psw`) VALUES('jesus', '123');
INSERT INTO `usuarios` (`usuario`, `psw`) VALUES('pepe', '123');
INSERT INTO `usuarios` (`usuario`, `psw`) VALUES('juancho', '123');

INSERT INTO `superheroes` (`nombre`, `imagen`, `evolucion`, `idUsuario`) VALUES ('superman_newbie',NULL, 'PRINCIPIANTE', 2);
INSERT INTO `superheroes` (`nombre`, `imagen`, `evolucion`, `idUsuario`) VALUES ('superman_expert',NULL, 'EXPERTO', 3);

INSERT INTO `superheroes_habilidades` (`idSuperheroe`, `idHabilidad`,`valor`)
				VALUES (1,1, 50);
INSERT INTO `superheroes_habilidades` (`idSuperheroe`, `idHabilidad`,`valor`)
				VALUES (1,1, 51);
				
INSERT INTO `ciudadanos` (`nombre`, `email`, `idUsuario`) VALUES ('bules', 'jesus20.11@hotmail.es',1);

INSERT INTO `peticiones` (`titulo`, `descripcion`, `realizada`, `idSuperheroe`, `idCiudadano`) 
				VALUES ('Salvarme', 'Ven a córdoba', FALSE,1,1);
				
INSERT INTO `peticiones` (`titulo`, `descripcion`, `realizada`, `idSuperheroe`, `idCiudadano`) 
				VALUES ('Salvarme', 'Ven a córdoba', TRUE,1,1);

/*Como Invitado:*/
/* Ver un listado de superhéroes con sus correspondientes habilidades. */
SELECT superheroes.id AS 'idSuperheroe', superheroes.nombre, imagen, evolucion, habilidades.nombre AS 'habilidad' , idHabilidad, valor FROM `superheroes`
LEFT JOIN `superheroes_habilidades`
ON superheroes.id = idSuperheroe
LEFT JOIN `habilidades`
ON superheroes_habilidades.id = habilidades.id
ORDER BY superheroes.id DESC LIMIT 5;
/* Registrarte como ciudadano: Insert a usuarios y posteriormente insert a ciudadanos */


/*Como Ciudadano:*/
/*La misma consulta que arriba */
/* Enviar peticiones: Insert a peticiones*/

/*Como Superheroe:*/
/*Misma consulta para ver los superheroes */
/* Añadir nuevas habilidades: Insert de habilidades arriba */
/*Consultar sus peticiones:*/
SELECT * FROM `peticiones`
WHERE idSuperheroe = 1;

/* Marcar sus peticiones como realizadas. */
UPDATE `peticiones`
SET realizada = TRUE
WHERE id = 1;

/*Como Superheroe Experto*/
SELECT id, nombre, imagen, evolucion, idUsuario FROM `superheroes`
WHERE evolucion = 'EXPERTO';
/*Realizar las tareas permitidas a los superheroes.*/
/*Gestión de la tabla Superheroes. */
/*Crear superheroe: Insert de arriba*/
/*Actualizar superheroe: */
UPDATE `superheroes`
SET nombre = 'superman_noob'
WHERE id=1;

/*Eliminar superheroe: */
#DELETE FROM `superheroes` WHERE id=1;
/*Obtener superheroes: Ya lo hace */

/*login:*/
SELECT * FROM superheroes
WHERE superheroes.idUsuario = (SELECT id FROM usuarios WHERE (usuario = 'pepe' AND psw = '123'));

SELECT * FROM ciudadanos
WHERE ciudadanos.idUsuario = (SELECT id FROM usuarios WHERE (usuario = 'jesus' AND psw = '123'));

/*Actualizar superheroe*/
UPDATE superheroes SET nombre='superman', evolucion='EXPERTO', imagen='c:/' WHERE id=1;

#SELECT * FROM superheroes_habilidades;

UPDATE superheroes_habilidades 
SET valor=55
WHERE idSuperheroe=1 AND idHabilidad = 1;

SELECT superheroes_habilidades.id, nombre, idHabilidad, valor FROM superheroes_habilidades
INNER JOIN habilidades
ON habilidades.id = idHabilidad
WHERE idSuperheroe = 14;

SELECT * FROM usuarios
WHERE usuario='jesus' AND psw='123';


SELECT * FROM ciudadanos
WHERE idUsuario = (
SELECT id FROM usuarios
WHERE usuario='juancho' AND psw='123');

SELECT * FROM superheroes
WHERE idUsuario = (
SELECT id FROM usuarios
WHERE usuario='juancho' AND psw='123');

SELECT id FROM ciudadanos
WHERE idUsuario = 1;

/*Lista peticiones*/
SELECT id, titulo, descripcion, realizada, idSuperheroe, idCiudadano FROM peticiones
WHERE idSuperheroe = 15;

SELECT * FROM peticiones;

UPDATE `peticiones`
SET realizada = TRUE
WHERE id = 11 AND idSuperheroe = 55; #Utilizamos idSuperheroe para proteger suplantaciones

SELECT * FROM peticiones
WHERE idSuperheroe = 15 AND realizada = TRUE;

UPDATE superheroes SET evolucion=EXPERTO, updated_at=CURRENT_TIMESTAMP WHERE id= :id

SELECT * FROM ciudadanos WHERE idUsuario = 1;

SELECT * FROM superheroes WHERE idUsuario = 3;