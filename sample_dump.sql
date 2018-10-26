-- MySQL dump 10.13  Distrib 5.7.23, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: todos
-- ------------------------------------------------------
-- Server version	5.7.23-0ubuntu0.18.04.1

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
-- Table structure for table `todo_items`
--

DROP TABLE IF EXISTS `todo_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `todo_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `listID` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `isdone` tinyint(1) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `todo_items_id_uindex` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `todo_items`
--

LOCK TABLES `todo_items` WRITE;
/*!40000 ALTER TABLE `todo_items` DISABLE KEYS */;
INSERT INTO `todo_items` VALUES (1,1,'Notebook',0,1,'2018-10-26 23:54:15','2018-10-26 23:54:15'),(2,1,'Smartphone',0,2,'2018-10-26 23:54:24','2018-10-26 23:54:24'),(3,2,'pizza',0,3,'2018-10-26 23:55:42','2018-10-26 23:55:42'),(4,2,'sushi',0,4,'2018-10-26 23:55:51','2018-10-26 23:55:51'),(5,2,'bread',0,5,'2018-10-26 23:56:04','2018-10-26 23:56:04'),(6,2,'milk',0,6,'2018-10-26 23:56:11','2018-10-26 23:56:11'),(7,2,'cheese',0,7,'2018-10-26 23:56:19','2018-10-26 23:56:19'),(8,2,'sausage',0,8,'2018-10-26 23:56:31','2018-10-26 23:56:31'),(9,2,'coffee',0,9,'2018-10-26 23:56:38','2018-10-26 23:56:38'),(10,3,'trip to the Carpathians in 2018',0,10,'2018-10-26 23:57:22','2018-10-26 23:57:22'),(11,3,'to visit an opera in Lviv',0,11,'2018-10-26 23:57:52','2018-10-26 23:57:52'),(12,3,'go skiing in Bukovel',0,12,'2018-10-26 23:58:37','2018-10-26 23:58:37');
/*!40000 ALTER TABLE `todo_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `todo_list`
--

DROP TABLE IF EXISTS `todo_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `todo_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `position` int(11) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL,
  `modified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `todo_list_id_uindex` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `todo_list`
--

LOCK TABLES `todo_list` WRITE;
/*!40000 ALTER TABLE `todo_list` DISABLE KEYS */;
INSERT INTO `todo_list` VALUES (1,'buy in internet',1,'2018-10-26 23:53:44','2018-10-26 23:53:44'),(2,'buy in shop',2,'2018-10-26 23:54:58','2018-10-26 23:54:58'),(3,'todo',3,'2018-10-26 23:56:46','2018-10-26 23:56:46');
/*!40000 ALTER TABLE `todo_list` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-10-27  0:00:47
