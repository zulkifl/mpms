CREATE DATABASE  IF NOT EXISTS `mpms` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `mpms`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: mpms
-- ------------------------------------------------------
-- Server version	5.6.15-log

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
-- Table structure for table `es_category`
--

DROP TABLE IF EXISTS `es_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `es_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `c_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `c_img` varchar(255) DEFAULT NULL,
  `active` varchar(1) DEFAULT '1',
  `mapshow` varchar(1) DEFAULT '1',
  `b_img` varchar(255) DEFAULT NULL,
  `description` varchar(2000) DEFAULT NULL,
  `detail` text,
  `order` int(11) DEFAULT '0',
  `views` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `es_category`
--

LOCK TABLES `es_category` WRITE;
/*!40000 ALTER TABLE `es_category` DISABLE KEYS */;
INSERT INTO `es_category` VALUES (1,'Carpenter','2016-08-15 08:29:49',NULL,'1','1',NULL,'',NULL,0,0);
/*!40000 ALTER TABLE `es_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `es_cities`
--

DROP TABLE IF EXISTS `es_cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `es_cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `country_id` int(11) NOT NULL,
  `c_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` varchar(1) DEFAULT '1',
  `lat` decimal(9,6) DEFAULT '0.000000',
  `lng` decimal(9,6) DEFAULT '0.000000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `es_countries`
--

DROP TABLE IF EXISTS `es_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `es_countries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `c_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


LOCK TABLES `es_countries` WRITE;
/*!40000 ALTER TABLE `es_countries` DISABLE KEYS */;
INSERT INTO `es_countries` VALUES (1,'ABC','2016-08-15 08:51:54','1');
/*!40000 ALTER TABLE `es_countries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `es_serviceprovider`
--

DROP TABLE IF EXISTS `es_serviceprovider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `es_serviceprovider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `country_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `keywords` varchar(1000) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `services` text,
  `address2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `es_user`
--

DROP TABLE IF EXISTS `es_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `es_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `f_name` varchar(255) DEFAULT NULL,
  `l_name` varchar(225) DEFAULT NULL,
  `c_timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `pic` varchar(200) DEFAULT NULL,
  `is_admin` varchar(1) DEFAULT '0',
  `is_active` varchar(1) DEFAULT '1',
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `es_user`
--

LOCK TABLES `es_user` WRITE;
/*!40000 ALTER TABLE `es_user` DISABLE KEYS */;
INSERT INTO `es_user` VALUES (1,'admin','Vi1TKuWixfBm5gpRchSfypE15mppp4Hy','$2y$13$Lu7yJJYLuP7wj4SGxXYxw.KJJYZmnfzSnADXKPBVE0nk8brxclWya','ldcKrbgnBYty9s4DUstaIJeYwiXcBZ_O_1463647037','admin@mpms.com',10,1445238113,1471258280,'Mr','Admin','2016-08-15 07:55:07','','1','1','');
/*!40000 ALTER TABLE `es_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-01 11:57:20
