-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.10.2-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para almacen
CREATE DATABASE IF NOT EXISTS `almacen` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;
USE `almacen`;

-- Volcando estructura para tabla almacen.consultas
CREATE TABLE IF NOT EXISTS `consultas` (
  `id_consulta` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_empleado` bigint(20) DEFAULT NULL,
  `id_material` bigint(20) DEFAULT NULL,
  `id_usuario` bigint(20) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `cancelada` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id_consulta`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla almacen.empleados
CREATE TABLE IF NOT EXISTS `empleados` (
  `id_empleado` bigint(20) NOT NULL AUTO_INCREMENT,
  `empleado` varchar(40) DEFAULT NULL,
  `domicilio` varchar(50) DEFAULT NULL,
  `celular` varchar(20) DEFAULT NULL,
  `id_puesto` bigint(20) DEFAULT NULL,
  `activo` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id_empleado`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla almacen.materiales
CREATE TABLE IF NOT EXISTS `materiales` (
  `id_material` bigint(20) NOT NULL AUTO_INCREMENT,
  `material` varchar(40) DEFAULT NULL,
  `existencia` int(11) DEFAULT NULL,
  `precio` decimal(15,2) DEFAULT NULL,
  `disponible` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id_material`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla almacen.puestos
CREATE TABLE IF NOT EXISTS `puestos` (
  `id_puesto` bigint(20) NOT NULL AUTO_INCREMENT,
  `puesto` varchar(20) DEFAULT NULL,
  `sueldo` decimal(15,2) DEFAULT NULL,
  PRIMARY KEY (`id_puesto`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla almacen.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id_usuario` bigint(20) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(40) DEFAULT NULL,
  `cuenta` varchar(50) DEFAULT NULL,
  `clave` varchar(128) DEFAULT NULL,
  `nivel` int(11) DEFAULT NULL,
  `idioma` int(11) DEFAULT NULL,
  `autorizado` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- La exportación de datos fue deseleccionada.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
