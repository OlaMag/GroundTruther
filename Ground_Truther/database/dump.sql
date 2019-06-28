-- MySQL dump 10.16  Distrib 10.1.36-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: ground_truther
-- ------------------------------------------------------
-- Server version	10.1.36-MariaDB

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
-- Table structure for table `tbl_disturbance`
--

DROP TABLE IF EXISTS `tbl_disturbance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_disturbance` (
  `id_disturbance` int(11) NOT NULL AUTO_INCREMENT,
  `name_disturbance` varchar(63) DEFAULT NULL,
  PRIMARY KEY (`id_disturbance`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_disturbance`
--

LOCK TABLES `tbl_disturbance` WRITE;
/*!40000 ALTER TABLE `tbl_disturbance` DISABLE KEYS */;
INSERT INTO `tbl_disturbance` VALUES (1,'Drought'),(2,'Fire'),(3,'Insect infestation'),(4,'Windthrow');
/*!40000 ALTER TABLE `tbl_disturbance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_landscape`
--

DROP TABLE IF EXISTS `tbl_landscape`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_landscape` (
  `id_land` int(11) NOT NULL AUTO_INCREMENT,
  `name_landscape` varchar(63) DEFAULT NULL,
  PRIMARY KEY (`id_land`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_landscape`
--

LOCK TABLES `tbl_landscape` WRITE;
/*!40000 ALTER TABLE `tbl_landscape` DISABLE KEYS */;
INSERT INTO `tbl_landscape` VALUES (1,'Broad-leaved forest'),(2,'Coniferous forest'),(3,'Mixed forest'),(4,'Meadow'),(5,'Agricultural'),(6,'Urban'),(7,'Coastal');
/*!40000 ALTER TABLE `tbl_landscape` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_obs`
--

DROP TABLE IF EXISTS `tbl_obs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_obs` (
  `id_part` int(11) DEFAULT NULL,
  `id_obs` int(11) NOT NULL AUTO_INCREMENT,
  `coords` varchar(63) DEFAULT NULL,
  `id_disturbance` int(11) DEFAULT NULL,
  `id_land` int(11) DEFAULT NULL,
  `comment` mediumtext,
  `date_obs` date DEFAULT NULL,
  `img_name` varchar(63) DEFAULT NULL,
  PRIMARY KEY (`id_obs`),
  KEY `idev` (`id_disturbance`),
  KEY `idland` (`id_land`),
  CONSTRAINT `idev` FOREIGN KEY (`id_disturbance`) REFERENCES `tbl_disturbance` (`id_disturbance`) ON DELETE CASCADE,
  CONSTRAINT `idland` FOREIGN KEY (`id_land`) REFERENCES `tbl_landscape` (`id_land`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_obs`
--

LOCK TABLES `tbl_obs` WRITE;
/*!40000 ALTER TABLE `tbl_obs` DISABLE KEYS */;
INSERT INTO `tbl_obs` VALUES (4,1,'52.873836, 13.787047',2,2,'0.25 ha of forest burnt, mostly pine forest','2017-07-20','uploads/img_example3.jpg'),(4,2,'52.823514, 13.796952',4,1,'storm Xavier cause damage to a beech stand','2017-10-18','uploads/img_example2.jpg'),(1,3,'53.200373, 13.489915',1,5,'Crops, possibly sugar beet - leaves yellow and on the ground','2018-08-28','uploads/'),(2,4,'52.938251, 13.303341',3,5,'some disease visible on leaves of cabbage','2019-05-28','uploads/'),(2,5,'53.218448, 13.808188',3,2,'Ips typographus outbreak in a spruce forest','2019-06-15','uploads/img_example3.jpg'),(2,6,'52.86212, 13.262185',1,1,'everything is looking very dry, leaves yellow, high fire risk','2019-06-28','uploads/img_example5.jpg'),(3,7,'53.029103, 13.61887',2,3,'fire due to human activity','2019-06-01','uploads/img_example3.jpg'),(3,9,'52.939905, 13.119511',1,4,'grass very yellow, soil exposed and cracked ','2018-07-28','uploads/'),(3,10,'53.083522, 13.289622',3,2,'6 dead spruces, insect activity visible','2017-06-28','uploads/img_example4.jpg'),(3,12,'52.830635, 13.330778',4,1,'','2018-09-28','uploads/');
/*!40000 ALTER TABLE `tbl_obs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_personal_adv`
--

DROP TABLE IF EXISTS `tbl_personal_adv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_personal_adv` (
  `id_part_a` int(11) DEFAULT NULL,
  `id_adv` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(63) DEFAULT NULL,
  `surname` varchar(63) DEFAULT NULL,
  `country` varchar(63) DEFAULT NULL,
  `town` varchar(63) DEFAULT NULL,
  `phone` varchar(63) DEFAULT NULL,
  PRIMARY KEY (`id_adv`),
  KEY `idpart` (`id_part_a`),
  CONSTRAINT `idpart` FOREIGN KEY (`id_part_a`) REFERENCES `tbl_personal_basic` (`id_part`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_personal_adv`
--

LOCK TABLES `tbl_personal_adv` WRITE;
/*!40000 ALTER TABLE `tbl_personal_adv` DISABLE KEYS */;
INSERT INTO `tbl_personal_adv` VALUES (1,1,'John','Doe','England','Bristol','0044 830183018'),(2,2,'Mary','Doe','Germany','Berlin','0049281368163'),(3,3,'Klaus','Kinski','Germany','Eberswalde','0049226816327164'),(4,4,'Klaudia','Schmidt','Germany','Eberswalde','00491826172863');
/*!40000 ALTER TABLE `tbl_personal_adv` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_personal_basic`
--

DROP TABLE IF EXISTS `tbl_personal_basic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_personal_basic` (
  `id_part` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(63) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id_part`),
  UNIQUE KEY `uni_id` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_personal_basic`
--

LOCK TABLES `tbl_personal_basic` WRITE;
/*!40000 ALTER TABLE `tbl_personal_basic` DISABLE KEYS */;
INSERT INTO `tbl_personal_basic` VALUES (1,'student1@mail.com','e6c3da5b206634d7f3f3586d747ffdb36b5c675757b380c6a5fe5c570c714349'),(2,'student2@mail.com','1ba3d16e9881959f8c9a9762854f72c6e6321cdd44358a10a4e939033117eab9'),(3,'student3@mail.com','3acb59306ef6e660cf832d1d34c4fba3d88d616f0bb5c2a9e0f82d18ef6fc167'),(4,'student4@mail.com','a417b5dc3d06d15d91c6687e27fc1705ebc56b3b2d813abe03066e5643fe4e74');
/*!40000 ALTER TABLE `tbl_personal_basic` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-06-28 14:46:55
