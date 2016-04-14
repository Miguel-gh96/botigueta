CREATE DATABASE  IF NOT EXISTS `hipoteca` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci */;
USE `hipoteca`;
-- MySQL dump 10.13  Distrib 5.5.47, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: hipoteca
-- ------------------------------------------------------
-- Server version	5.5.47-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `hipotecas`
--

DROP TABLE IF EXISTS `hipotecas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hipotecas` (
  `idHipoteca` int(11) NOT NULL,
  `nif` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `nombre` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `ape1` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `ape2` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `edad` int(11) DEFAULT NULL,
  `telefono` int(11) DEFAULT NULL,
  `email` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `ingresos_mensuales` int(11) DEFAULT NULL,
  `capital` int(11) DEFAULT NULL,
  `tipo_interes` varchar(45) COLLATE utf8_spanish2_ci DEFAULT NULL,
  `euribor` float DEFAULT NULL,
  `diferencial` float DEFAULT NULL,
  `interes_fijo` float DEFAULT NULL,
  `plazo_anyos` int(11) DEFAULT NULL,
  `producto_segurocasa` tinyint(1) DEFAULT NULL,
  `producto_nomina` tinyint(1) DEFAULT NULL,
  `producto_segurovida` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idHipoteca`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hipotecas`
--

LOCK TABLES `hipotecas` WRITE;
/*!40000 ALTER TABLE `hipotecas` DISABLE KEYS */;
INSERT INTO `hipotecas` VALUES (1,'12345678Z','Pere','Crespo','Molina',41,656340567,'pedcremo@gmail.com',1200,120000,'fixed',NULL,NULL,2.97,25,0,0,0),(3,'48608794L','miguel','gandia','gandia',20,680118945,'miguel@gmail.com',1200,1200000,'variable',0.7,2.9,0,20,0,1,0),(7,'48608794L','miguel','gandia','gandia',20,680118945,'miguel@gmail.com',1200,1200000,'variable',0.7,2.9,0,20,0,1,0),(2661,'48608794L','miguel','gandia','gandia',20,680118945,'miguel@gmail.com',1200,1200000,'variable',0.7,2.9,0,20,0,1,0),(4639,'48608794L','miguel','gandia','gandia',20,680118945,'miguel@gmail.com',1200,1200000,'variable',0.7,2.9,0,20,0,1,0),(5722,'48608794L','miguel','gandia','gandia',20,680118945,'miguel@gmail.com',1200,1200000,'variable',0.7,2.9,0,20,0,1,0);
/*!40000 ALTER TABLE `hipotecas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'hipoteca'
--

--
-- Dumping routines for database 'hipoteca'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-04-14 18:52:15
