-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.1.10-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura de base de datos para botigueta
CREATE DATABASE IF NOT EXISTS `botigueta` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci */;
USE `botigueta`;


-- Volcando estructura para tabla botigueta.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `_id` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `parent` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- Volcando datos para la tabla botigueta.categories: ~0 rows (aproximadamente)
DELETE FROM `categories`;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;


-- Volcando estructura para tabla botigueta.products
CREATE TABLE IF NOT EXISTS `products` (
  `id_` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `category_id` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `category_parent` varchar(100) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `currency` varchar(50) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `pictures` varchar(200) COLLATE utf8_spanish2_ci DEFAULT NULL,
  PRIMARY KEY (`id_`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- Volcando datos para la tabla botigueta.products: ~0 rows (aproximadamente)
DELETE FROM `products`;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
