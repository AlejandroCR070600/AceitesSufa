-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: aceites
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `aceites_stock`
--

DROP TABLE IF EXISTS `aceites_stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `aceites_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Cant_Aceites` int(11) DEFAULT NULL,
  `Fecha_Aceites` date DEFAULT NULL,
  `Entrada` int(11) DEFAULT NULL,
  `Salida` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aceites_stock`
--

LOCK TABLES `aceites_stock` WRITE;
/*!40000 ALTER TABLE `aceites_stock` DISABLE KEYS */;
INSERT INTO `aceites_stock` VALUES (1,10,'2025-01-25',10,0),(2,9,'2025-01-12',0,1),(3,8,'2025-01-25',0,1),(4,7,'2025-01-13',0,1),(5,6,'2025-01-14',0,1),(6,5,'2025-01-14',0,1),(7,4,'2025-01-14',0,1),(8,3,'2025-01-16',0,1),(9,2,'2025-01-16',0,1),(10,1,'2025-01-18',0,1),(11,0,'2025-01-18',0,1),(12,10,'2025-01-25',10,0),(13,9,'2025-01-19',0,1),(14,8,'2025-01-21',0,1),(15,7,'2025-01-21',0,1),(16,6,'2025-01-21',0,1),(17,5,'2025-01-21',0,1),(18,4,'2025-01-22',0,1),(19,3,'2025-01-22',0,1),(20,2,'2025-01-23',0,1),(21,1,'2025-01-24',0,1),(22,0,'2025-01-23',0,1),(32,10,'2025-01-23',10,0),(33,9,'2025-01-23',0,1),(34,8,'2025-01-24',0,1),(35,7,'2025-01-24',0,1),(36,6,'2025-01-25',0,1),(37,5,'2025-01-25',0,1),(38,4,'2025-01-27',0,1),(39,3,'2025-01-27',0,1),(40,2,'2025-01-29',0,1),(41,1,'2025-01-29',0,1),(42,0,'2025-01-29',0,1),(48,10,'2025-02-03',10,0),(49,9,'2025-01-31',0,1),(50,8,'2025-01-31',0,1),(51,7,'2025-02-01',0,1),(52,6,'2025-02-01',0,1),(53,5,'2025-02-03',0,1),(55,4,'2025-02-03',0,1),(56,3,'2025-02-03',0,1),(57,2,'2025-02-02',0,1),(58,1,'2025-02-05',0,1),(59,0,'2025-02-05',0,1),(60,10,'2025-02-06',10,0);
/*!40000 ALTER TABLE `aceites_stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `control_aceites`
--

DROP TABLE IF EXISTS `control_aceites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `control_aceites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Fecha` date DEFAULT NULL,
  `Moto_Num` varchar(50) DEFAULT NULL,
  `Cant_Aceites` int(11) DEFAULT NULL,
  `id_Informe` int(11) DEFAULT NULL,
  `precio` int(11) DEFAULT NULL,
  `folio` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_id_informe` (`id_Informe`),
  CONSTRAINT `fk_id_informe` FOREIGN KEY (`id_Informe`) REFERENCES `informe` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `control_aceites`
--

LOCK TABLES `control_aceites` WRITE;
/*!40000 ALTER TABLE `control_aceites` DISABLE KEYS */;
INSERT INTO `control_aceites` VALUES (1,'2025-01-12','1',1,1,93,'IWAED389096'),(2,'2025-01-13','10',1,1,93,'IWAED389096'),(3,'2025-01-13','12',1,1,93,'IWAED389096'),(4,'2025-01-14','19',1,1,93,'IWAED389096'),(5,'2025-01-14','5',1,1,93,'IWAED389096'),(6,'2025-01-14','16',1,1,93,'IWAED389096'),(7,'2025-01-16','10',1,1,93,'IWAED389096'),(8,'2025-01-16','16',1,1,93,'IWAED389096'),(9,'2025-01-18','4',1,1,93,'IWAED389096'),(10,'2025-01-18','10',1,1,93,'IWAED389096'),(11,'2025-01-19','10',1,2,93,'IWAED389456'),(12,'2025-01-21','1',1,2,93,'IWAED389456'),(13,'2025-01-21','4',1,2,93,'IWAED389456'),(14,'2025-01-21','15',1,2,93,'IWAED389456'),(15,'2025-01-21','10',1,2,93,'IWAED389456'),(16,'2025-01-22','10',1,2,93,'IWAED389456'),(17,'2025-01-22','10',1,2,93,'IWAED389456'),(18,'2025-01-23','14',1,2,93,'IWAED389456'),(19,'2025-01-23','1',1,2,93,'IWAED389456'),(20,'2025-01-23','planta',1,2,93,'IWAED389456'),(30,'2025-01-23','10',1,3,93,'IWAED389881'),(31,'2025-01-24','6',1,3,93,'IWAED389881'),(32,'2025-01-24','10',1,3,93,'IWAED389881'),(33,'2025-01-25','10',1,3,93,'IWAED389881'),(34,'2025-01-25','6',1,3,93,'IWAED389881'),(35,'2025-01-27','1',1,3,93,'IWAED389881'),(36,'2025-01-27','10',1,3,93,'IWAED389881'),(37,'2025-01-29','14',1,3,93,'IWAED389881'),(38,'2025-01-29','1',1,3,93,'IWAED389881'),(39,'2025-01-29','10',1,3,93,'IWAED389881'),(44,'2025-01-31','10',1,6,93,'IWAED390612'),(45,'2025-01-31','10',1,6,93,'IWAED390612'),(46,'2025-02-01','12',1,6,93,'IWAED390612'),(47,'2025-02-01','5',1,6,93,'IWAED390612'),(48,'2025-02-03','1',1,6,93,'IWAED390612'),(50,'2025-02-03','1',1,6,93,'IWAED390612'),(51,'2025-02-03','10',1,6,93,'IWAED390612'),(52,'2025-02-02','6',1,6,93,'IWAED390612'),(53,'2025-02-05','1',1,6,93,'IWAED390612'),(54,'2025-02-05','oswi',1,6,93,'IWAED390612');
/*!40000 ALTER TABLE `control_aceites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `informe`
--

DROP TABLE IF EXISTS `informe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `informe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inicio` date DEFAULT NULL,
  `final` date DEFAULT NULL,
  `folio` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_folio` (`folio`),
  UNIQUE KEY `folio` (`folio`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `informe`
--

LOCK TABLES `informe` WRITE;
/*!40000 ALTER TABLE `informe` DISABLE KEYS */;
INSERT INTO `informe` VALUES (1,'2025-01-11','2025-01-18','IWAED389096'),(2,'2025-01-19','2025-01-23','IWAED389456'),(3,'2025-01-23','2025-02-03','IWAED389881'),(6,'2025-01-31','2025-02-06','IWAED390612'),(7,'2025-02-06',NULL,NULL);
/*!40000 ALTER TABLE `informe` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-02-06 14:57:36
