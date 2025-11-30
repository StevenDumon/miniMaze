-- MySQL dump 10.13  Distrib 8.0.44, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: minimaze
-- ------------------------------------------------------
-- Server version	8.0.44-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `CertificateTypes`
--

DROP TABLE IF EXISTS `CertificateTypes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `CertificateTypes` (
  `CertificateType_ID` int NOT NULL AUTO_INCREMENT,
  `CertificateType` varchar(10) NOT NULL,
  PRIMARY KEY (`CertificateType_ID`),
  UNIQUE KEY `CertificateType_UNIQUE` (`CertificateType`),
  UNIQUE KEY `CetrificateTypes_ID_UNIQUE` (`CertificateType_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CertificateTypes`
--

LOCK TABLES `CertificateTypes` WRITE;
/*!40000 ALTER TABLE `CertificateTypes` DISABLE KEYS */;
INSERT INTO `CertificateTypes` VALUES (2,'2.2'),(3,'3.1');
/*!40000 ALTER TABLE `CertificateTypes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Conditions`
--

DROP TABLE IF EXISTS `Conditions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Conditions` (
  `Conditions_ID` int NOT NULL AUTO_INCREMENT,
  `Condition` varchar(20) NOT NULL,
  PRIMARY KEY (`Conditions_ID`),
  UNIQUE KEY `Conditions_ID_UNIQUE` (`Conditions_ID`),
  UNIQUE KEY `Condition_UNIQUE` (`Condition`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Conditions`
--

LOCK TABLES `Conditions` WRITE;
/*!40000 ALTER TABLE `Conditions` DISABLE KEYS */;
INSERT INTO `Conditions` VALUES (4,'Geschilderd'),(2,'Gestraald'),(3,'Primer'),(1,'Zwart (onbehandeld)');
/*!40000 ALTER TABLE `Conditions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `OnHandStock`
--

DROP TABLE IF EXISTS `OnHandStock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `OnHandStock` (
  `OnHandStock_ID` int NOT NULL AUTO_INCREMENT,
  `Part_ID` int NOT NULL,
  `Dimensions` varchar(45) NOT NULL,
  `Batch_ID` int DEFAULT NULL,
  PRIMARY KEY (`OnHandStock_ID`),
  UNIQUE KEY `OnHandStock_ID_UNIQUE` (`OnHandStock_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `OnHandStock`
--

LOCK TABLES `OnHandStock` WRITE;
/*!40000 ALTER TABLE `OnHandStock` DISABLE KEYS */;
INSERT INTO `OnHandStock` VALUES (1,12,'6000x2000',4),(2,12,'6000x2000',4),(3,13,'6000x2000',4),(4,13,'6000x2000',4),(5,14,'6000x2000',4),(6,14,'6000x2000',4);
/*!40000 ALTER TABLE `OnHandStock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Operations`
--

DROP TABLE IF EXISTS `Operations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Operations` (
  `Operation_ID` int NOT NULL AUTO_INCREMENT,
  `Code` varchar(10) NOT NULL,
  `Operation_Description` varchar(45) NOT NULL,
  PRIMARY KEY (`Operation_ID`),
  UNIQUE KEY `Code_UNIQUE` (`Code`),
  UNIQUE KEY `OperationsID_UNIQUE` (`Operation_ID`),
  UNIQUE KEY `Description_UNIQUE` (`Operation_Description`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Operations`
--

LOCK TABLES `Operations` WRITE;
/*!40000 ALTER TABLE `Operations` DISABLE KEYS */;
INSERT INTO `Operations` VALUES (1,'BR','Branden'),(2,'PO','Ponsen'),(3,'PL','Plooien'),(4,'ZA','Zagen'),(5,'ZB','Zaagboor'),(6,'RO','Rollen'),(7,'LS','Lasersnijden'),(8,'SN','Snijden'),(9,'NS','Schilderen'),(10,'NG','Galvanizeren');
/*!40000 ALTER TABLE `Operations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `PartUsage`
--

DROP TABLE IF EXISTS `PartUsage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `PartUsage` (
  `PartUsage_ID` int NOT NULL AUTO_INCREMENT,
  `Parent_ID` int NOT NULL,
  `Child_ID` int NOT NULL,
  `Quantity` int NOT NULL,
  `CertificateType_ID` int DEFAULT NULL,
  PRIMARY KEY (`PartUsage_ID`),
  UNIQUE KEY `PartUsage_ID_UNIQUE` (`PartUsage_ID`),
  UNIQUE KEY `unique_parent_child` (`Parent_ID`,`Child_ID`),
  KEY `fk_CertificateType_ID_idx` (`CertificateType_ID`),
  KEY `fk_child_Part_ID_idx` (`Child_ID`),
  CONSTRAINT `fk_CertificateType_ID` FOREIGN KEY (`CertificateType_ID`) REFERENCES `CertificateTypes` (`CertificateType_ID`),
  CONSTRAINT `fk_child_Part_ID` FOREIGN KEY (`Child_ID`) REFERENCES `Parts` (`Part_ID`),
  CONSTRAINT `fk_parent_Part_ID` FOREIGN KEY (`Parent_ID`) REFERENCES `Parts` (`Part_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `PartUsage`
--

LOCK TABLES `PartUsage` WRITE;
/*!40000 ALTER TABLE `PartUsage` DISABLE KEYS */;
INSERT INTO `PartUsage` VALUES (1,1171,1,3,NULL),(2,1171,5,2,3),(10,37,38,30,2);
/*!40000 ALTER TABLE `PartUsage` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Parts`
--

DROP TABLE IF EXISTS `Parts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Parts` (
  `Part_ID` int NOT NULL AUTO_INCREMENT,
  `PartNumber` varchar(20) NOT NULL,
  `CADNumber` varchar(45) DEFAULT NULL,
  `Name` varchar(60) NOT NULL,
  `Version` varchar(10) DEFAULT NULL,
  `Description` varchar(80) DEFAULT NULL,
  `Material` varchar(20) DEFAULT NULL,
  `Weight` decimal(10,2) DEFAULT NULL,
  `Dimensions` varchar(20) DEFAULT NULL,
  `Norm` varchar(30) DEFAULT NULL,
  `Operation_1_ID` int DEFAULT NULL,
  `Operation_2_ID` int DEFAULT NULL,
  `Operation_3_ID` int DEFAULT NULL,
  `Operation_4_ID` int DEFAULT NULL,
  `Operation_5_ID` int DEFAULT NULL,
  `RM_number` varchar(20) DEFAULT NULL,
  `Remarks` varchar(45) DEFAULT NULL,
  `State_ID` int NOT NULL,
  PRIMARY KEY (`Part_ID`),
  UNIQUE KEY `Part_ID_UNIQUE` (`Part_ID`),
  UNIQUE KEY `PartNumber` (`PartNumber`,`CADNumber`,`Version`),
  KEY `fk_Parts_States_idx` (`State_ID`),
  KEY `fk_Parts_Operation_1_idx` (`Operation_1_ID`),
  KEY `fk_Parts_Operation_2_idx` (`Operation_2_ID`),
  KEY `fk_Parts_Operation_3_idx` (`Operation_3_ID`),
  KEY `fk_Parts_Operation_4_idx` (`Operation_4_ID`),
  KEY `fk_Parts_Operation_5_idx` (`Operation_5_ID`),
  CONSTRAINT `fk_Parts_Operation_1` FOREIGN KEY (`Operation_1_ID`) REFERENCES `Operations` (`Operation_ID`),
  CONSTRAINT `fk_Parts_Operation_2` FOREIGN KEY (`Operation_2_ID`) REFERENCES `Operations` (`Operation_ID`),
  CONSTRAINT `fk_Parts_Operation_3` FOREIGN KEY (`Operation_3_ID`) REFERENCES `Operations` (`Operation_ID`),
  CONSTRAINT `fk_Parts_Operation_4` FOREIGN KEY (`Operation_4_ID`) REFERENCES `Operations` (`Operation_ID`),
  CONSTRAINT `fk_Parts_Operation_5` FOREIGN KEY (`Operation_5_ID`) REFERENCES `Operations` (`Operation_ID`),
  CONSTRAINT `fk_Parts_States` FOREIGN KEY (`State_ID`) REFERENCES `States` (`State_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1173 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Parts`
--

LOCK TABLES `Parts` WRITE;
/*!40000 ALTER TABLE `Parts` DISABLE KEYS */;
INSERT INTO `Parts` VALUES (1,'tst_prt_001','tst_prt_001','Test part 001','00.1','PLAAT 10 MM','S235JR',10.00,'500x500',NULL,1,NULL,NULL,NULL,NULL,'W00003007',NULL,1),(5,'tst_prt_002','tst_prt_002','Test part 002','00.6','PLAAT 10 MM','S235JR',15.00,'600x600',NULL,1,3,NULL,NULL,NULL,'W00003007',NULL,1),(6,'tst_prt_002','tst_prt_002','Test part 002','00.7','PLAAT 10 MM','S235JR',15.00,'600x600',NULL,1,3,NULL,NULL,NULL,'W00003007',NULL,1),(8,'tst_prt_002','tst_prt_002','Test part 002','00.9','PLAAT 10 MM','S235JR',15.00,'600x600','Norm',1,2,3,4,4,'W00003007','*',1),(9,'tst_prt_003','tst_prt_003','Test part 003','00.3','KOKER 100x100x10','S235JRH',65.00,'L=2500','EN 10210',4,NULL,6,NULL,NULL,'W00123456','Overlengte',1),(10,'tst_prt_004','tst_prt_004','Test decimal','00.1','TEST DECIMAL','8.8',3.14,'M8x50','EN ISO 4014',NULL,NULL,NULL,NULL,NULL,'','',2),(11,'tst_prt_005','tst_prt_005','Test decimal','00.2','TEST DECIMAL','8.8',1.23,'M8x60',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1),(12,'W00003007',NULL,'Plaat 10 mm - S235JR','00.1','PLAAT 10 MM','S235JR',80.00,NULL,'EN 10025',NULL,NULL,NULL,NULL,NULL,NULL,NULL,2),(13,'W00003008',NULL,'Plaat 12 mm - S235JR','00.2','PLAAT 12 MM','S235JR',92.00,NULL,'EN 10025',NULL,NULL,NULL,NULL,NULL,NULL,NULL,2),(14,'W00003006',NULL,'Plaat 8 mm - S235JR','00.3','PLAAT 8 MM','S235JR',64.00,NULL,'EN 10025',NULL,NULL,NULL,NULL,NULL,NULL,NULL,2),(15,'tst_part_update','tst_part_update','Demo stored procedure','00.1','DEMO STORED PROCEDURE','8.8',3.00,'M10x60','EN 4014',NULL,NULL,NULL,NULL,NULL,'','',2),(22,'ERP0000051522','34339-051-490','Tijdelijke versteviging silodeur','00.1','','',4133.40,'','',NULL,NULL,NULL,NULL,NULL,'','',1),(23,'34339-051-400','34339-051-400','porte évacuation silo 1','00.29','','',3900.83,'','',NULL,NULL,NULL,NULL,NULL,'','',1),(24,'34339-051-401','34339-051-401','pièce encastrée porte évacuation silo 1','00.22','','',703.38,'','',NULL,NULL,NULL,NULL,NULL,'','',1),(25,'C04479646','C04479646','Vloerplaat','00.9','','',107.26,'','',NULL,NULL,NULL,NULL,NULL,'','',1),(26,'C04479676','C04479676','Vloerplaat','00.10','PLAAT 8 MM','S235JR',87.62,'4689x300','EN 10025-2',1,NULL,NULL,NULL,NULL,'W00003006','',1),(27,'C04479677','C04479677','Dichtingsprofiel','00.9','KOKER 40X40X4','S235JRH',17.72,'4231','EN 10219-2',4,6,NULL,NULL,NULL,'W00182200','',1),(28,'C04479678','C04479678','Ankerlus','00.2','BETONSTAALSTAAF Ø12MM','BSt 500 S',0.38,'434','DIN 488-2',4,6,NULL,NULL,NULL,'W00150779','',1),(36,'ERP0000013033','36863-P00006','Kop','00.2','','',3402.19,'','',NULL,NULL,NULL,NULL,NULL,'','',1),(37,'36863-072-100','36863-072-100','TBP2 - Head','00.22','','',1465.84,'','',NULL,NULL,NULL,NULL,NULL,'','',1),(38,'36863-072-140','36863-072-140','TBP2 - Head frame + chute','00.17','','',326.69,'','',NULL,NULL,NULL,NULL,NULL,'','',1),(39,'36863-072-141','36863-072-141','TBP2 - Head - chute','00.9','','',102.23,'','',NULL,NULL,NULL,NULL,NULL,'','',1),(40,'C05512890','C05512890','TBP2 - Kop - Trechterplaat 1','00.6','PLAAT 5 MM','S235JR',16.39,'831x797','EN 10025-2',7,NULL,NULL,NULL,NULL,'W00003004','',1),(41,'C05512891','C05512891','TBP2 - Kop - Trechterplaat 2','00.6','PLAAT 5 MM','S235JR',31.78,'1026x1090','EN 10025-2',7,NULL,NULL,NULL,NULL,'W00003004','',1),(42,'C05512892','C05512892','TBP2 - Kop - Trechterplaat 3','00.6','PLAAT 5 MM','S235JR',16.39,'831x797','EN 10025-2',7,NULL,NULL,NULL,NULL,'W00003004','',1),(43,'C05512893','C05512893','TBP2 - Kop - Trechterplaat 4','00.6','PLAAT 5 MM','S235JR',30.23,'1026x1053','EN 10025-2',7,NULL,NULL,NULL,NULL,'W00003004','',1),(44,'ERP0000014719','C05572190','TBP2 - Kop - flens','00.2','PLAAT 10 MM','S235JR',7.44,'Ø445xØ347','EN 10025-2',7,NULL,NULL,NULL,NULL,'W00003007','',1),(45,'36863-072-142','36863-072-142','TBP2 - Head - frame','00.19','','',224.46,'','',NULL,NULL,NULL,NULL,NULL,'','',1),(46,'99999-041-138','99999-041-138','Plate for welding socket - Blind plate','00.5','Plaat voor lasmof - blindplaat','',2.47,'','',NULL,NULL,NULL,NULL,NULL,'','',2),(47,'ERP00000001802','C01920530','Lasplaat','00.12','PLAAT 15 MM','S235JR',1.30,'120x120','EN 10025-2',7,NULL,NULL,NULL,NULL,'W00003011','',2),(48,'ERP0000001729','EN4017_M12X20_8-8_THVZ_GETAPT','EN ISO 4017 Bout assembly M12x20 - 8.8 Therm verz - Getapt','00.5','BOUT + SLUITRING THERM VERZ','8.8',0.04,'M12x20','EN ISO 4017',NULL,NULL,NULL,NULL,NULL,'','',2),(49,'W00137445','W00137445','EN ISO 4017 Zeskantbout M12x20 - 8.8 Therm. verz.','00.16','ZESKANTBOUT THERM VERZ','8.8',0.04,'M12x20','EN ISO 4017',NULL,NULL,NULL,NULL,NULL,'','',2),(50,'W00192189','W00192189','EN ISO 7089 Vlakke sluitring M12 Staal Therm. verz.','00.23','VLAKKE SLUITRING THERM VERZ','Staal',0.00,'M12','EN ISO 7089',NULL,NULL,NULL,NULL,NULL,'','',2),(51,'ERP0000005771','C02111073','Level Limit Switch: Blind Plate','00.7','PLAAT 8 MM','S235JR',1.00,'130x130','EN 10025-2',1,NULL,NULL,NULL,NULL,'W00003006','',1),(52,'C05512745','C05512745','TBP2 - Kop - Chassis - Support Longeron','00.8','','',2.92,'','',NULL,NULL,NULL,NULL,NULL,'','',1),(53,'C05512933','C05512933','TBP2 - Kop - Chassis - Support Longeron - Support R','00.5','PLAAT 5 MM','S235JR',1.20,'289x170','EN 10025-2',7,NULL,NULL,NULL,NULL,'W00003004','',1),(54,'C05512934','C05512934','TBP2 - Kop - Chassis - Support Longeron - Support L','00.5','PLAAT 5 MM','S235JR',1.20,'289x170','EN 10025-2',7,NULL,NULL,NULL,NULL,'W00003004','',1),(150,'ERP0000011511','EN4017_M12X50_A2-70_PTFE','EN ISO 4017 Bout assembly M12x50 - A2-70 - PTFE','00.4','BOUT + MOER','A2-70',0.09,'M12x50','EN ISO 4017/EN ISO 4032',NULL,NULL,NULL,NULL,NULL,'','',1),(151,'W00001548','W00001548','EN ISO 4017 Zeskantbout M12x50 - A2-70','00.14','ZESKANTBOUT','A2-70',0.06,'M12x50','EN ISO 4017',NULL,NULL,NULL,NULL,NULL,'','',2),(152,'W00005014','W00005014','EN ISO 4032 Zeskantmoer M12 - A2-70','00.16','ZESKANTMOER','A2-70',0.01,'M12','EN ISO 4032',NULL,NULL,NULL,NULL,NULL,'','',2),(153,'W00203143','W00203143','EN ISO 7089 Vlakke sluitring M12 - A4 PTFE Coated','00.7','VLAKKE SLUITRING PFTE COATED','A4-70',0.00,'M12','EN ISO 7089',NULL,NULL,NULL,NULL,NULL,'','',2),(154,'ERP0000013493','EN4017_M12X40_A2-70_PTFE','EN ISO 4017 Bout assembly M12x40 - A2-70 - PTFE','00.3','BOUT + MOER','A2-70',0.08,'M12x40','EN ISO 4017/EN ISO 4032',NULL,NULL,NULL,NULL,NULL,'','',1),(155,'W00001554','W00001554','EN ISO 4017 Zeskantbout M12x40 - A2-70','00.14','ZESKANTBOUT','A2-70',0.05,'M12x40','EN ISO 4017',NULL,NULL,NULL,NULL,NULL,'','',2),(158,'C05512918','C05512918','TBP2 - Kop - Chassis - Chassisplaat R','00.12','PLAAT 8 MM','S235JR',65.92,'1100x1049','EN 10025-2',7,NULL,NULL,NULL,NULL,'W00003006','',1),(159,'C05512919','C05512919','TBP2 - Kop - Chassis - Chassisplaat L','00.12','PLAAT 8 MM','S235JR',65.68,'1100x1049','EN 10025-2',7,NULL,NULL,NULL,NULL,'W00003006','',1),(160,'C05512920','C05512920','TBP2 - Kop - Chassis - clip1','00.9','PLAAT 8 MM','S235JR',7.59,'662x186','EN 10025-2',7,NULL,NULL,NULL,NULL,'W00003006','',1),(161,'C05512924','C05512924','TBP2 - Kop - Chassis - clip 2','00.7','PLAAT 8 MM','S235JR',5.02,'662x186','EN 10025-2',7,NULL,NULL,NULL,NULL,'W00003006','',1),(162,'C05512928','C05512928','TBP2 - Kop - Chassis - clip 3','00.9','PLAAT 8 MM','S235JR',4.18,'554x186','EN 10025-2',7,NULL,NULL,NULL,NULL,'W00003006','',1),(163,'C05512930','C05512930','TBP2 - Kop - Chassis - Chassisplaat voor','00.9','PLAAT 8 MM','S235JR',25.57,'1144x380','EN 10025-2',7,NULL,NULL,NULL,NULL,'W00003006','',1),(164,'C05512931','C05512931','TBP2 - Kop - Chassis - chassisplaat achter','00.12','PLAAT 8 MM','S235JR',12.35,'1130x185','EN 10025-2',7,NULL,NULL,NULL,NULL,'W00003006','',1),(165,'ERP0000014385','C05570006','TBP2 - Kop - Chassis - ribbe','00.4','PLAAT 5 MM','S235JR',0.39,'LS','EN 10025-2',NULL,NULL,NULL,NULL,NULL,'W00003004','',1),(167,'36863-072-751','36863-072-751','TBP2 - CE nameplate','00.3','NAAMPLAAT 2MM','1.4301',0.28,'160x110','',NULL,NULL,NULL,NULL,NULL,'W00161066','',1),(168,'99999-043-011','99999-043-011','Lagerkussen L=410 C=350','00.8','LAGERKUSSEN','',15.62,'','',NULL,NULL,NULL,NULL,NULL,'','',2),(169,'ERP0000007259','C01791294','Lagerkussen L=410 C=350 - Voetplaat','00.3','PLAAT 20 MM','S235JR',12.09,'560x140','EN 10025-2',7,NULL,NULL,NULL,NULL,'W00003014','',2),(170,'ERP0000007320','C01791283','Lagerkussen - Regelplaat','00.5','PLAT 60x30MM','S235JR',1.35,'100','EN 10058',4,NULL,NULL,NULL,NULL,'W00007929','',2),(171,'W00192187','W00192187','EN ISO 7089 Vlakke sluitring M20 - Staal Therm. verz.','00.13','VLAKKE SLUITRING THERM VERZ','Staal',0.00,'M20','EN ISO 7089',NULL,NULL,NULL,NULL,NULL,'','',2),(172,'W00200206','W00200206','EN 15048 Bout EN ISO 4017 + moer M20x100 - 8.8 Therm. verz.','00.9','BOUT ISO 4017 + MOER ISO 4032 THERM VERZ','8.8',0.39,'M20x100','EN 15048',NULL,NULL,NULL,NULL,NULL,'','',2),(173,'99999-045-100','99999-045-100','wartelende oogbout M20','00.5','WARTELENDE OOGBOUT M20 - TP2.5','',0.66,'','',NULL,NULL,NULL,NULL,NULL,'','',1),(174,'W00139058','W00139058','EN ISO 4032 Zeskantmoer M20 - kl.8 Therm. verz.','00.16','ZESKANTMOER THERM VERZ','kl. 8',0.07,'M20','EN ISO 4032',NULL,NULL,NULL,NULL,NULL,'','',2),(176,'W00205767','W00205767','Wartelende oogbout TP 2,5 - M20x70','00.4','JTD WARTELENDE OOGBOUT THEIPA TP 2,5','',0.57,'M20x70','',NULL,NULL,NULL,NULL,NULL,'','',2),(177,'ERP0000011464','EN4017_M16X50_A2-70_PTFE','EN ISO 4017 Bout assembly M16x50 - A2-70 - PTFE','00.7','BOUT + MOER','A2-70',0.18,'M16x50','EN ISO 4017/EN ISO 4032',NULL,NULL,NULL,NULL,NULL,'','',1),(178,'W00001533','W00001533','EN ISO 4017 Zeskantbout M16x50 - A2-70','00.14','ZESKANTBOUT','A2-70',0.12,'M16x50','EN ISO 4017',NULL,NULL,NULL,NULL,NULL,'','',2),(179,'W00194560','W00194560','EN ISO 4032 Zeskantmoer M16 - A2-70','00.9','ZESKANTMOER','A2-70',0.04,'M16','EN ISO 4032',NULL,NULL,NULL,NULL,NULL,'','',2),(180,'W00203144','W00203144','EN ISO 7089 Vlakke sluitring M16 - A4 PTFE Coated','00.7','VLAKKE SLUITRING PFTE COATED','A4',0.00,'M16','EN ISO 7089',NULL,NULL,NULL,NULL,NULL,'','',2),(181,'ERP0000011687','36863-072-005','TBP2 - Drive pulley','00.9','','',404.59,'','',NULL,NULL,NULL,NULL,NULL,'','',1),(182,'C05515957','C05515957','TBP2 - Drive pulley - Buis','00.3','NAADLOZE BUIS 16&quot; XS','A106 Gr.B',113.70,'955','ASME B36.10M',4,NULL,NULL,NULL,NULL,'W00111391','',1),(183,'C05515958','C05515958','TBP2 - Drive pulley - Rubber','00.3','ANTISLIP RUBBER 10MM GEPROFILEERD','CAOUTCHOUC 60° SHORE',18.61,'950xØ426','',NULL,NULL,NULL,NULL,NULL,'','',1),(184,'C05515959','C05515959','TBP2 - Drive pulley - Flens','00.4','PLAAT 25 MM','S235JR',15.75,'Ø390xØ155','EN 10025-2',1,NULL,NULL,NULL,NULL,'W00003016','',1),(185,'C05515977','C05515977','TBP2 - Drive pulley - As','00.6','ROND Ø130 GEWALST','34CrNiMo6+QT',156.66,'1895','EN 10060',4,NULL,NULL,NULL,NULL,'W00212217','',1),(186,'C05515978','C05515978','TBP2 - Drive pulley - Afstandring','00.5','ROND Ø120MM','Ertalon 6 SA',0.20,'15','',NULL,NULL,NULL,NULL,NULL,'W00153025','',1),(187,'ERP0000006911','99999-040-110-B-G','Lager 22224 EK met huis SNL 524-620 met deksel','00.7','','',37.54,'','',NULL,NULL,NULL,NULL,NULL,'','',1),(188,'W00159844','W00159844','Lagerhuis SNL 524-620','00.17','LAGERHUIS SNL 524-620','',26.20,'','',NULL,NULL,NULL,NULL,NULL,'','',2),(189,'W00159845','W00159845','Tweerijig tonlager 22224 EK','00.12','TWEERIJIG TONLAGER 22224 EK','',8.50,'','',NULL,NULL,NULL,NULL,NULL,'','',2),(190,'W00159846','W00159846','Trekbus H 3124','00.12','TREKBUS H 3124','',2.67,'','',NULL,NULL,NULL,NULL,NULL,'','',2),(191,'W00159847','W00159847','Lagerdichting TSN 524 L','00.11','DICHTING TSN 524 L','',0.10,'','',NULL,NULL,NULL,NULL,NULL,'','',2),(192,'W00192110','W00192110','Einddeksel ASNH 524-620','00.10','EINDDEKSEL ASNH 524-620','',0.07,'','',NULL,NULL,NULL,NULL,NULL,'','',2),(193,'ERP0000006922','99999-040-110-C-G','Lager 22224 EK met huis SNL 524-620 met stelringen','00.7','','',38.21,'','',NULL,NULL,NULL,NULL,NULL,'','',1),(198,'W00160246','W00160246','Stelring FRB 14/215','00.9','STELRING FRB 14/215','',0.32,'','',NULL,NULL,NULL,NULL,NULL,'','',2),(199,'W00153064','W00153064','Klembus Geers serie 160 - Ø120 x Ø165','00.10','KLEMBUS Geers serie 160','',3.46,'Ø120 x Ø165','',NULL,NULL,NULL,NULL,NULL,'','',2),(200,'W00187476','W00187476','Afschermkap voor klembus Ø120 x Ø165','00.13','AFSCHERMKAP KLEMBUS Ø120 x Ø165','304L',0.60,'Ø115xØ255','',NULL,NULL,NULL,NULL,NULL,'','',2),(201,'ERP0000014234','36863-072-104','TBP2 - snub roller BB800 Ø133 axe Ø30 sw22','00.6','','',27.12,'','',NULL,NULL,NULL,NULL,9,'','',1),(206,'ERP0000014225','C05569609','plaat','00.2','PLAAT 8 MM','S235JR',1.21,'188x110','EN 10025-2',7,NULL,NULL,NULL,9,'W00003006','',1),(207,'W00201194','W00201194','DIN 15207-T1 Onderrol Ø133 as Ø30 sw22 L=950mm rubber 5mm','00.9','ONDERROL Ø133 x L=950 AS Ø30 SW22 + RUBBER 5 MM','Staal',24.38,'','DIN 15207-T1',NULL,NULL,NULL,NULL,NULL,'','',2),(208,'ERP0000014235','36863-072-171','TBP2 - Scraper assembly R800-750 - 304L','00.11','','',24.83,'','',NULL,NULL,NULL,NULL,NULL,'','',1),(209,'ERP0000014228','C05569552','Afschermplaat rechts R800-750 - 304L','00.7','','',0.80,'','',NULL,NULL,NULL,NULL,NULL,'','',1),(210,'ERP0000014226','C05569565','zwee','00.5','PLAAT 2 MM','1.4404',0.17,'180x30','EN 10088-2',7,NULL,NULL,NULL,NULL,'W00004171','',1),(211,'ERP0000014231','C05569563','Afschermplaat rechts R800-750 onderstuk - 304L','00.5','PLAAT 2 MM','1.4404',0.29,'127x126','EN 10088-2',7,NULL,NULL,NULL,NULL,'W00004171','',1),(212,'ERP0000014233','C05569562','Afschermplaat rechts R800-750 bovenstuk - 304L','00.5','PLAAT 2 MM','1.4404',0.29,'129x127','EN 10088-2',7,NULL,NULL,NULL,NULL,'W00004171','',1),(213,'ERP0000037354','EN4017_M8X20_A2-70_PTFE','EN ISO 4017 Bout assembly M8x20 - A2-70 - PTFE','00.3','BOUT + MOER','A2-70',0.02,'M8x20','',NULL,NULL,NULL,NULL,NULL,'','',1),(214,'W00005012','W00005012','EN ISO 4032 Zeskantmoer M8 - A2-70','00.15','ZESKANTMOER','A2-70',0.01,'M8','EN ISO 4032',NULL,NULL,NULL,NULL,NULL,'','',2),(215,'W00138184','W00138184','EN ISO 4017 Zeskantbout M8x20 - A2-70','00.13','ZESKANTBOUT','A2-70',0.01,'M8x20','EN ISO 4017',NULL,NULL,NULL,NULL,NULL,'','',2),(216,'W00203141','W00203141','EN ISO 7089 Vlakke sluitring M8 - A4 PTFE Coated','00.9','VLAKKE SLUITRING PFTE COATED','A4',0.00,'M8','EN ISO 7089',NULL,NULL,NULL,NULL,NULL,'','',2),(217,'ERP0000014230','C05569557','Afschermplaat links R800-750 - 304L','00.7','','',0.80,'','',NULL,NULL,NULL,NULL,NULL,'','',1),(218,'ERP0000014224','C05569583','Afschermplaat rechts R800-750 onderstuk - 304L','00.5','PLAAT 2 MM','1.4404',0.29,'127x126','EN 10088-2',7,NULL,NULL,NULL,NULL,'W00004171','',1),(220,'ERP0000014232','C05569582','Afschermplaat links R800-750 bovenstuk - 304L','00.5','PLAAT 2 MM','1.4404',0.29,'129x127','EN 10088-2',7,NULL,NULL,NULL,NULL,'W00004171','',1),(225,'ERP0000037340','EN4017_M8X30_A2-70_PTFE','EN ISO 4017 Bout assembly M8x30 - A2-70 - PTFE','00.3','BOUT + MOER','A2-70',0.03,'M8x30','',NULL,NULL,NULL,NULL,NULL,'','',1),(226,'W00001575','W00001575','EN ISO 4017 Zeskantbout M8x30 - A2-70','00.13','ZESKANTBOUT','A2-70',0.02,'M8x30','EN ISO 4017',NULL,NULL,NULL,NULL,NULL,'','',2),(229,'W00201659','W00201659','Bandschraper Promati type R-800-750 - 1.4306 + RVS messen','00.10','BANDSCHRAPER PROMATI TYPE R 800-750','1.4306',23.13,'','',NULL,NULL,NULL,NULL,NULL,'','',2),(230,'ERP0000014292','EN4017_M24X110_A2-70_PTFE','EN ISO 4017 Bout assembly M20x110 - A2-70 - PTFE','00.3','BOUT + MOER','A2-70',0.73,'M24x110','EN ISO 4017/EN ISO 4032',NULL,NULL,NULL,NULL,NULL,'','',1),(231,'W00005007','W00005007','EN ISO 4032 Zeskantmoer M24 - A2-70','00.12','ZESKANTMOER','A2-70',0.13,'M24','EN ISO 4032',NULL,NULL,NULL,NULL,NULL,'','',2),(232,'W00138330','W00138330','EN ISO 4017 Zeskantbout M24x110 - A2-70','00.12','ZESKANTBOUT','A2-70',0.53,'M24x110','EN ISO 4017',NULL,NULL,NULL,NULL,NULL,'','',2),(233,'W00203146','W00203146','EN ISO 7089 Vlakke sluitring M24 - A4 PTFE Coated','00.6','VLAKKE SLUITRING PFTE COATED','A4',0.00,'M24','EN ISO 7089',NULL,NULL,NULL,NULL,NULL,'','',2),(234,'ERP0000014391','36863-072-112','Torque arm','00.5','','',32.34,'','',NULL,NULL,NULL,NULL,NULL,'','',1),(239,'ERP0000014383','C05569859','Boutplaat','00.3','PLAAT 12 MM','S235JR',5.84,'450x140','EN 10025-2',7,NULL,NULL,NULL,NULL,'W00003008','M',1),(240,'ERP0000014386','C05569862','Ribbe','00.3','PLAAT 6 MM','S235JR',0.65,'220x150','EN 10025-2',7,NULL,NULL,NULL,NULL,'W00003005','',1),(241,'ERP0000014387','C05569826','Draadstang M24','00.3','','',1.51,'','',NULL,NULL,NULL,NULL,NULL,'','',1),(242,'ERP0000014379','C05569848','Draadstang M24','00.3','DRAADSTANG M24 THERM VERZ ISOMETRISCH','8.8',0.91,'258','DIN 975',4,NULL,NULL,NULL,NULL,'W00194990','',1),(243,'W00139060','W00139060','EN ISO 4032 Zeskantmoer M24 - kl.8 Therm. verz.','00.14','ZESKANTMOER THERM VERZ','kl. 8',0.13,'M24','EN ISO 4032',NULL,NULL,NULL,NULL,NULL,'','',2),(245,'ERP0000014390','C05569857','Langsligger','00.4','UPN 120','S235JR',8.09,'609','DIN 1026-1',4,NULL,NULL,NULL,NULL,'W00007002','',1),(246,'W00006512','W00006512','DIN 1481 Spanbus Ø8X30 Verenstaal','A.4','SPANBUS - ZWARE UITVOERING','',0.01,'Ø8 x 30','DIN 1481',NULL,NULL,NULL,NULL,NULL,'','',2),(248,'ERP0000015693','EN4017_M12X20_A2-70_GETAPT_PTFE','EN ISO 4017 Bout assembly M12x20 - A2-70 - Getapt PTFE','00.1','BOUT + SLUITRING','A2-70',0.04,'M12x20','EN ISO 4017',NULL,NULL,NULL,NULL,NULL,'','',1),(249,'W00138227','W00138227','EN ISO 4017 Zeskantbout M12x20 - A2-70','00.12','ZESKANTBOUT','A2-70',0.04,'M12x20','EN ISO 4017',NULL,NULL,NULL,NULL,NULL,'','',2),(251,'ERP0000015694','C05577616','afschermkap - licht','00.11','','',11.15,'','',NULL,NULL,NULL,NULL,NULL,'','',1),(252,'ERP0000013494','EN4017_M12X30_A2-70_PTFE','EN ISO 4017 Bout assembly M12x30 - A2-70 - PTFE','00.3','BOUT + MOER','A2-70',0.07,'M12x30','EN ISO 4017/EN ISO 4032',NULL,NULL,NULL,NULL,NULL,'','',1),(253,'W00001552','W00001552','EN ISO 4017 Zeskantbout M12x30 - A2-70','00.14','ZESKANTBOUT','A2-70',0.05,'M12x30','EN ISO 4017',NULL,NULL,NULL,NULL,NULL,'','',2),(256,'ERP0000015691','C05577620','kap R','00.2','PLAAT 2 MM','1.4401',1.12,'150x360','EN 10088-2',7,NULL,NULL,NULL,NULL,'W00004123','',1),(257,'ERP0000015692','C05577621','kap L','00.10','PLAAT 2 MM','1.4401',2.84,'500x446','EN 10088-2',7,NULL,NULL,NULL,NULL,'W00004123','',1),(258,'ERP0000015695','C05577619','kap_achter','00.3','PLAAT 2 MM','1.4401',7.74,'1130x360','EN 10088-2',7,NULL,NULL,NULL,NULL,'W00004123','',1),(259,'W00201337','W00201337','Sticker Pictogram Lifting Point, rond Ø50mm blauw','00.9','STICKER HIJSPUNT','',0.01,'Ø50mm','ISO 3864',NULL,NULL,NULL,NULL,NULL,'','',2),(260,'W00221176','W00221176','Motorreductor KH107/T AMS200 DRN200L4/TF 30 kW 65 tr/min','00.4','MOTORREDUCTOR KH107/T AMS200 DRN200L4/TF 30 kW 65 tr/min','',600.00,'','',NULL,NULL,NULL,NULL,NULL,'','',2),(1171,'tst_asm_001','tst_asm_001','Test Assembly structure','00.1',NULL,NULL,100.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `Parts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProductionOrders`
--

DROP TABLE IF EXISTS `ProductionOrders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ProductionOrders` (
  `ProductionOrder_ID` int NOT NULL,
  `Part_ID` int NOT NULL,
  PRIMARY KEY (`ProductionOrder_ID`),
  UNIQUE KEY `ProductionOrder_ID_UNIQUE` (`ProductionOrder_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProductionOrders`
--

LOCK TABLES `ProductionOrders` WRITE;
/*!40000 ALTER TABLE `ProductionOrders` DISABLE KEYS */;
/*!40000 ALTER TABLE `ProductionOrders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProjectStates`
--

DROP TABLE IF EXISTS `ProjectStates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ProjectStates` (
  `ProjectState_ID` int NOT NULL AUTO_INCREMENT,
  `Description` varchar(20) NOT NULL,
  PRIMARY KEY (`ProjectState_ID`),
  UNIQUE KEY `ProjectState_ID_UNIQUE` (`ProjectState_ID`),
  UNIQUE KEY `Description_UNIQUE` (`Description`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProjectStates`
--

LOCK TABLES `ProjectStates` WRITE;
/*!40000 ALTER TABLE `ProjectStates` DISABLE KEYS */;
INSERT INTO `ProjectStates` VALUES (2,'Active'),(3,'Closed'),(1,'In tender');
/*!40000 ALTER TABLE `ProjectStates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Projects`
--

DROP TABLE IF EXISTS `Projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Projects` (
  `ProjectID` int NOT NULL AUTO_INCREMENT,
  `Number` varchar(10) NOT NULL,
  `Description` varchar(60) NOT NULL,
  `Client` varchar(60) DEFAULT NULL,
  `Status_ID` int DEFAULT NULL,
  PRIMARY KEY (`ProjectID`),
  KEY `fk_Project_State_ID_idx` (`Status_ID`),
  CONSTRAINT `fk_Project_State_ID` FOREIGN KEY (`Status_ID`) REFERENCES `ProjectStates` (`ProjectState_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Projects`
--

LOCK TABLES `Projects` WRITE;
/*!40000 ALTER TABLE `Projects` DISABLE KEYS */;
INSERT INTO `Projects` VALUES (1,'31966','12 jet fuel tanks','Oikos Storage',2),(2,'32895','Bioethanol - 16 tanks SS/Duplex','Clariant',2),(4,'37025','Insert plates 2x6m 35mm - R230-R-002','Petro Rabigh Company',2),(5,'37518','Verhogen silos','Sibelco',2),(6,'37617','Papeterie Desctartes Palm Groupe','Dalkia Tours',2),(7,'37275','Herstellen Fermentor TK401E','Alco',2),(9,'12345','Test','Test',2);
/*!40000 ALTER TABLE `Projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RawMaterialBatches`
--

DROP TABLE IF EXISTS `RawMaterialBatches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `RawMaterialBatches` (
  `Batch_ID` int NOT NULL AUTO_INCREMENT,
  `Number` varchar(45) NOT NULL,
  `Supplier_ID` int NOT NULL,
  `Condition_ID` int DEFAULT NULL,
  PRIMARY KEY (`Batch_ID`),
  UNIQUE KEY `BatchID_UNIQUE` (`Batch_ID`),
  KEY `fk_RawMaterialBatches_1_idx` (`Supplier_ID`),
  KEY `fk_RawMaterialBatches_Condition_ID_idx` (`Condition_ID`),
  CONSTRAINT `fk_RawMaterialBatches_Condition_ID` FOREIGN KEY (`Condition_ID`) REFERENCES `Conditions` (`Conditions_ID`),
  CONSTRAINT `fk_RawMaterialBatches_SupplierID` FOREIGN KEY (`Supplier_ID`) REFERENCES `Suppliers` (`Supplier_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RawMaterialBatches`
--

LOCK TABLES `RawMaterialBatches` WRITE;
/*!40000 ALTER TABLE `RawMaterialBatches` DISABLE KEYS */;
INSERT INTO `RawMaterialBatches` VALUES (1,'AX125-445',1,NULL),(2,'154899_A',2,NULL),(3,'Batch 2025-11-23 #001',4,NULL),(4,'Batch 2025-11-23 #002',4,NULL),(5,'Batch 2025-11-23 #003',4,NULL);
/*!40000 ALTER TABLE `RawMaterialBatches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `States`
--

DROP TABLE IF EXISTS `States`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `States` (
  `State_ID` int NOT NULL AUTO_INCREMENT,
  `State` varchar(20) NOT NULL,
  PRIMARY KEY (`State_ID`),
  UNIQUE KEY `State_ID_UNIQUE` (`State_ID`),
  UNIQUE KEY `State_UNIQUE` (`State`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `States`
--

LOCK TABLES `States` WRITE;
/*!40000 ALTER TABLE `States` DISABLE KEYS */;
INSERT INTO `States` VALUES (1,'In Work'),(3,'Obsolete'),(2,'Released');
/*!40000 ALTER TABLE `States` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Suppliers`
--

DROP TABLE IF EXISTS `Suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Suppliers` (
  `Supplier_ID` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(45) NOT NULL,
  PRIMARY KEY (`Supplier_ID`),
  UNIQUE KEY `SupplierID_UNIQUE` (`Supplier_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Suppliers`
--

LOCK TABLES `Suppliers` WRITE;
/*!40000 ALTER TABLE `Suppliers` DISABLE KEYS */;
INSERT INTO `Suppliers` VALUES (1,'Van Leeuwen'),(2,'Industeel'),(3,'Saey'),(4,'Tata steel'),(5,'Fabory');
/*!40000 ALTER TABLE `Suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Users`
--

DROP TABLE IF EXISTS `Users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `Users` (
  `UserID` int NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `Name_UNIQUE` (`Name`),
  UNIQUE KEY `UserID_UNIQUE` (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
INSERT INTO `Users` VALUES (1,'Steven Dumon','steven.dumon@geldof.com'),(2,'Filip Debyser','filip.debyser@geldof.com'),(3,'Sammy Vromant','sammy.vromant@geldof.com'),(4,'Tom Carton','tom.carton@geldof.com');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `viewOnHandStock`
--

DROP TABLE IF EXISTS `viewOnHandStock`;
/*!50001 DROP VIEW IF EXISTS `viewOnHandStock`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `viewOnHandStock` AS SELECT 
 1 AS `PartNumber`,
 1 AS `Name`,
 1 AS `Material`,
 1 AS `Supplier`,
 1 AS `Dimensions`,
 1 AS `BatchNumber`,
 1 AS `State`*/;
SET character_set_client = @saved_cs_client;

--
-- Temporary view structure for view `viewParts`
--

DROP TABLE IF EXISTS `viewParts`;
/*!50001 DROP VIEW IF EXISTS `viewParts`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `viewParts` AS SELECT 
 1 AS `PartNumber`,
 1 AS `CADNumber`,
 1 AS `Name`,
 1 AS `Bew.1`,
 1 AS `Bew.2`,
 1 AS `Bew.3`,
 1 AS `Bew.4`,
 1 AS `Bew.5`,
 1 AS `State`*/;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `viewOnHandStock`
--

/*!50001 DROP VIEW IF EXISTS `viewOnHandStock`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`Theseus`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `viewOnHandStock` AS select `Parts`.`PartNumber` AS `PartNumber`,`Parts`.`Name` AS `Name`,`Parts`.`Material` AS `Material`,`Suppliers`.`Name` AS `Supplier`,`OnHandStock`.`Dimensions` AS `Dimensions`,`RawMaterialBatches`.`Number` AS `BatchNumber`,`States`.`State` AS `State` from ((((`OnHandStock` left join `RawMaterialBatches` on((`OnHandStock`.`Batch_ID` = `RawMaterialBatches`.`Batch_ID`))) left join `Parts` on((`OnHandStock`.`Part_ID` = `Parts`.`Part_ID`))) left join `States` on((`States`.`State_ID` = `Parts`.`State_ID`))) left join `Suppliers` on((`RawMaterialBatches`.`Supplier_ID` = `Suppliers`.`Supplier_ID`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `viewParts`
--

/*!50001 DROP VIEW IF EXISTS `viewParts`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`Theseus`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `viewParts` AS select `Parts`.`PartNumber` AS `PartNumber`,`Parts`.`CADNumber` AS `CADNumber`,`Parts`.`Name` AS `Name`,`operations_for_operation_1`.`Operation_Description` AS `Bew.1`,`operations_for_operation_2`.`Operation_Description` AS `Bew.2`,`operations_for_operation_3`.`Operation_Description` AS `Bew.3`,`operations_for_operation_4`.`Operation_Description` AS `Bew.4`,`operations_for_operation_5`.`Operation_Description` AS `Bew.5`,`States`.`State` AS `State` from ((((((`Parts` join `States` on((`Parts`.`State_ID` = `States`.`State_ID`))) left join `Operations` `operations_for_operation_1` on((`operations_for_operation_1`.`Operation_ID` = `Parts`.`Operation_1_ID`))) left join `Operations` `operations_for_operation_2` on((`operations_for_operation_2`.`Operation_ID` = `Parts`.`Operation_2_ID`))) left join `Operations` `operations_for_operation_3` on((`operations_for_operation_3`.`Operation_ID` = `Parts`.`Operation_3_ID`))) left join `Operations` `operations_for_operation_4` on((`operations_for_operation_4`.`Operation_ID` = `Parts`.`Operation_4_ID`))) left join `Operations` `operations_for_operation_5` on((`operations_for_operation_5`.`Operation_ID` = `Parts`.`Operation_5_ID`))) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-30 21:21:52
