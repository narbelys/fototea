-- MySQL dump 10.13  Distrib 5.5.35, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: fototea_fot
-- ------------------------------------------------------
-- Server version	5.5.35-0ubuntu0.12.04.2

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
-- Table structure for table `albumes`
--

DROP TABLE IF EXISTS `albumes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `albumes` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT,
  `a_tit` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `a_license` enum('Attribution (CC BY)','Attribution-ShareAlike (CC BY-SA)','Attribution-NoDerivs (CC BY-ND)','Attribution-NonCommercial (CC BY-NC)','Attribution-NonCommercial-ShareAlike (CC BY-NC-SA)','Attribution-NonCommercial-NoDerivs (CC BY-NC-ND)') COLLATE utf8_spanish_ci DEFAULT NULL,
  `a_user_id` int(11) NOT NULL,
  `a_type` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `a_status` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `a_cdate` datetime NOT NULL,
  PRIMARY KEY (`a_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `albumes`
--

LOCK TABLES `albumes` WRITE;
/*!40000 ALTER TABLE `albumes` DISABLE KEYS */;
INSERT INTO `albumes` VALUES (1,'Dublin','Attribution (CC BY)',5,'F','S','2014-05-26 18:01:07'),(2,'Mi Album 1','',6,'F','S','2014-05-26 18:09:23'),(3,'Prueba','Attribution (CC BY)',7,'F','S','2014-05-26 18:47:21');
/*!40000 ALTER TABLE `albumes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `albumes_det`
--

DROP TABLE IF EXISTS `albumes_det`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `albumes_det` (
  `ad_id` int(11) NOT NULL AUTO_INCREMENT,
  `ad_a_id` int(11) NOT NULL,
  `ad_url` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `ad_user_id` int(11) NOT NULL,
  `ad_description` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `ad_status` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `ad_cdate` datetime NOT NULL,
  `ad_is_principal` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ad_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `albumes_det`
--

LOCK TABLES `albumes_det` WRITE;
/*!40000 ALTER TABLE `albumes_det` DISABLE KEYS */;
INSERT INTO `albumes_det` VALUES (1,1,'IMG_20140315_173852_1.jpg',5,'','S','2014-05-26 18:01:15',0),(2,1,'IMG_20140315_174034_2.jpg',5,'','S','2014-05-26 18:01:20',0),(3,1,'IMG_20140315_181345_3.jpg',5,'','S','2014-05-26 18:01:27',0),(4,1,'IMG_20140315_181103_4.jpg',5,'','S','2014-05-26 18:01:30',0),(5,1,'IMG_20140315_182113_5.jpg',5,'','S','2014-05-26 18:01:38',0),(6,1,'IMG_20140315_183609_6.jpg',5,'','S','2014-05-26 18:01:43',0),(7,1,'IMG_20140315_173539_7.jpg',5,'','S','2014-05-26 18:01:54',0),(8,1,'IMG_20140315_173500_8.jpg',5,'','S','2014-05-26 18:02:01',1),(9,1,'IMG_20140315_162539_9.jpg',5,'','S','2014-05-26 18:02:16',0),(10,2,'carretera_10.jpg',6,'','S','2014-05-26 18:09:54',0),(11,2,'beautiful-sky_11.jpg',6,'','S','2014-05-26 18:09:55',0),(12,2,'fondo1_12.jpg',6,'','S','2014-05-26 18:09:56',0),(13,2,'fondo2_13.jpg',6,'','S','2014-05-26 18:09:57',0),(14,2,'fondo_14.jpg',6,'','S','2014-05-26 18:09:58',0),(15,2,'mountain_15.jpg',6,'','S','2014-05-26 18:09:58',0),(16,2,'snowy-firs_16.jpg',6,'','S','2014-05-26 18:10:00',0),(17,2,'tierra_17.jpg',6,'','S','2014-05-26 18:10:01',0),(18,2,'pintura_18.jpg',6,'','S','2014-05-26 18:10:01',0),(19,3,'Penguins_19.jpg',7,'','S','2014-05-26 18:49:59',1),(20,3,'Tulips_20.jpg',7,'','S','2014-05-26 18:49:59',0),(21,3,'Lighthouse_21.jpg',7,'','S','2014-05-26 18:50:06',0),(22,3,'Chrysanthemum_22.jpg',7,'','S','2014-05-26 18:50:06',0),(23,3,'Hydrangeas_23.jpg',7,'','S','2014-05-26 18:50:08',0),(24,3,'Desert_24.jpg',7,'','S','2014-05-26 18:50:08',0),(25,3,'Jellyfish_25.jpg',7,'','S','2014-05-26 18:50:09',0),(26,3,'20140214_172456_26.jpg',7,'','S','2014-05-26 18:50:29',0),(27,3,'Penguins_27.jpg',7,'','S','2014-05-26 18:52:00',0);
/*!40000 ALTER TABLE `albumes_det` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `texto` varchar(130) COLLATE utf8_unicode_ci NOT NULL,
  `img` text COLLATE utf8_unicode_ci NOT NULL,
  `orden` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
INSERT INTO `banners` VALUES (2,'Encuentra tu prÃ³ximo fotÃ³grafo','Contrata fotÃ³grafos acorde a tu proyecto.  <br> Compara diferentes propuestas.  <br> Paga de manera segura y online.','57713a3492d9ba358c4954fb21e491c5.jpg',1),(3,'Edita tus fotos','Respalda tu capacidad creativa en la ediciÃ³n de fotografÃ­as con uno de nuestros <br>fotÃ³grafos o creativos asociados','6a11824872b3c76928bb000bf8259702.jpg',2),(4,'Crea fabulosos videos','Descubre fabulosos directores y productores audiovisuales que te ayudarÃ¡n en tu prÃ³xima filmaciÃ³n de video profesional.','4b45fbfed75021fdc7003b8fa39aa18b.jpg',3),(5,'Edita videos y animaciones','Tu filmas. Tu fotografÃ­as. Tu Fototeas.  Nuestros animadores y editores crean <br>tu video o animaciÃ³n a partir de tu contenido','0c859e20229a5265e086dd9a3a77dd53.jpg',4);
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8_spanish_ci NOT NULL,
  `order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Producci&oacute;n de fotograf&iacute;as',1),(2,'Edici&oacute;n de fotograf&iacute;as',2),(3,'Producci&oacute;n y edici&oacute;n de videos',3);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories_event`
--

DROP TABLE IF EXISTS `categories_event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cat` int(11) NOT NULL,
  `description` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories_event`
--

LOCK TABLES `categories_event` WRITE;
/*!40000 ALTER TABLE `categories_event` DISABLE KEYS */;
INSERT INTO `categories_event` VALUES (1,1,'Bodas'),(2,1,'Autos'),(3,1,'Compromisos'),(4,1,'Corporativo'),(5,1,'Cumplea&ntilde;os'),(6,1,'Eventos y Cultural'),(7,1,'Familia'),(8,1,'Inmobiliario'),(10,1,'Maternidad'),(11,1,'Modelos y Actuaci&oacute;n'),(12,1,'Negocios'),(13,1,'Ni&ntilde;os y beb&eacute;s'),(14,1,'Producto'),(15,1,'Publicidad y Comercial'),(16,1,'Retratos'),(17,2,'Creativa'),(18,2,'T&eacute;cnica'),(19,3,'Bodas'),(20,3,'Compromisos'),(21,3,'Cursos'),(22,3,'Demostraci&oacute;n de productos'),(23,3,'Educaci&oacute;n'),(24,3,'Entrevistas'),(25,3,'Eventos y Cultural'),(26,3,'Familia'),(27,3,'Publicidad y Comercial'),(28,3,'Testimoniales'),(29,3,'Video Explicativo');
/*!40000 ALTER TABLE `categories_event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `credits`
--

DROP TABLE IF EXISTS `credits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `credits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `used_date` datetime DEFAULT NULL,
  `album_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `credits`
--

LOCK TABLES `credits` WRITE;
/*!40000 ALTER TABLE `credits` DISABLE KEYS */;
/*!40000 ALTER TABLE `credits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data`
--

DROP TABLE IF EXISTS `data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8_spanish_ci NOT NULL,
  `order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data`
--

LOCK TABLES `data` WRITE;
/*!40000 ALTER TABLE `data` DISABLE KEYS */;
INSERT INTO `data` VALUES (1,'user_img_perfil',NULL),(2,'user_bio_desc',NULL),(3,'user_direccion',NULL),(4,'user_cp',NULL),(5,'user_pais',NULL),(6,'user_tel',NULL),(7,'user_movil',NULL),(8,'user_fb',NULL),(9,'user_tw',NULL),(10,'user_city',NULL),(11,'user_camara',NULL),(12,'user_lentes',NULL),(13,'user_equipo',NULL),(14,'user_experiencia',NULL),(15,'user_cat_interes',NULL),(16,'user_cover',NULL),(17,'paypal_user',NULL);
/*!40000 ALTER TABLE `data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mensajes`
--

DROP TABLE IF EXISTS `mensajes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mensajes` (
  `m_id` int(11) NOT NULL AUTO_INCREMENT,
  `m_to` int(11) NOT NULL,
  `m_cuser` int(11) NOT NULL,
  `m_subject` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `pro_id` int(11) DEFAULT NULL,
  `m_cdate` datetime NOT NULL,
  `m_status` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'A',
  PRIMARY KEY (`m_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mensajes`
--

LOCK TABLES `mensajes` WRITE;
/*!40000 ALTER TABLE `mensajes` DISABLE KEYS */;
/*!40000 ALTER TABLE `mensajes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mensajes_det`
--

DROP TABLE IF EXISTS `mensajes_det`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mensajes_det` (
  `md_id` int(11) NOT NULL AUTO_INCREMENT,
  `md_m_id` int(11) NOT NULL,
  `md_to` int(11) NOT NULL,
  `md_from` int(11) NOT NULL,
  `md_txt` text COLLATE utf8_unicode_ci NOT NULL,
  `md_cdate` datetime NOT NULL,
  PRIMARY KEY (`md_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mensajes_det`
--

LOCK TABLES `mensajes_det` WRITE;
/*!40000 ALTER TABLE `mensajes_det` DISABLE KEYS */;
/*!40000 ALTER TABLE `mensajes_det` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mensajes_status`
--

DROP TABLE IF EXISTS `mensajes_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mensajes_status` (
  `ms_id` int(11) NOT NULL AUTO_INCREMENT,
  `ms_m_id` int(11) NOT NULL,
  `ms_user_id` int(11) NOT NULL,
  `ms_status` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ms_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mensajes_status`
--

LOCK TABLES `mensajes_status` WRITE;
/*!40000 ALTER TABLE `mensajes_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `mensajes_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `order` int(11) NOT NULL,
  `icon` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `modules`
--

LOCK TABLES `modules` WRITE;
/*!40000 ALTER TABLE `modules` DISABLE KEYS */;
INSERT INTO `modules` VALUES (1,'Inicio','dashboard',1,'dashboard'),(2,'Pagos realizados','#',5,'calendar'),(3,'SEO','#',3,'tag'),(11,'Administracion del sistema','#',11,'tool'),(5,'Usuarios registrados','#',4,'users'),(6,'Pagina Principal','#',2,'buttons');
/*!40000 ALTER TABLE `modules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notificaciones`
--

DROP TABLE IF EXISTS `notificaciones`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `notificacion` text COLLATE utf8_unicode_ci NOT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  `cdate` datetime NOT NULL,
  `leido` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `type` varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificaciones`
--

LOCK TABLES `notificaciones` WRITE;
/*!40000 ALTER TABLE `notificaciones` DISABLE KEYS */;
INSERT INTO `notificaciones` VALUES (1,4,'Has recibido un mensaje de Andrea LebrÃºn','proyecto?id=1','2014-05-26 16:37:47','S','C','{\"offer_id\":1,\"comment_id\":1,\"project_id\":\"1\"}'),(2,4,'Has recibido un mensaje de Andrea LebrÃºn','proyecto?id=2','2014-05-26 18:21:57','S','C','{\"offer_id\":3,\"comment_id\":2,\"project_id\":\"2\"}');
/*!40000 ALTER TABLE `notificaciones` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oferta_comments`
--

DROP TABLE IF EXISTS `oferta_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oferta_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oferta_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oferta_comments`
--

LOCK TABLES `oferta_comments` WRITE;
/*!40000 ALTER TABLE `oferta_comments` DISABLE KEYS */;
INSERT INTO `oferta_comments` VALUES (1,1,3,'Hola, esto es un mensaje','2014-05-26 16:37:47'),(2,3,7,'Holaaa','2014-05-26 18:21:57');
/*!40000 ALTER TABLE `oferta_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ofertas`
--

DROP TABLE IF EXISTS `ofertas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ofertas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bid` float NOT NULL,
  `mensaje` text COLLATE utf8_unicode_ci NOT NULL,
  `awarded` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ofertas`
--

LOCK TABLES `ofertas` WRITE;
/*!40000 ALTER TABLE `ofertas` DISABLE KEYS */;
INSERT INTO `ofertas` VALUES (1,1,3,400,'Oferta','S','2014-05-26 16:29:21'),(2,2,3,200,'aaaaaaaaaaa','N','2014-05-26 16:59:05'),(3,2,7,300,'Propuesta de Andrea','S','2014-05-26 18:21:35');
/*!40000 ALTER TABLE `ofertas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paises`
--

DROP TABLE IF EXISTS `paises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paises` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `iso` char(2) DEFAULT NULL,
  `nombre` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paises`
--

LOCK TABLES `paises` WRITE;
/*!40000 ALTER TABLE `paises` DISABLE KEYS */;
INSERT INTO `paises` VALUES (1,'AF','Afganistán'),(2,'AX','Islas Gland'),(3,'AL','Albania'),(4,'DE','Alemania'),(5,'AD','Andorra'),(6,'AO','Angola'),(7,'AI','Anguilla'),(8,'AQ','Antártida'),(9,'AG','Antigua y Barbuda'),(10,'AN','Antillas Holandesas'),(11,'SA','Arabia Saudí'),(12,'DZ','Argelia'),(13,'AR','Argentina'),(14,'AM','Armenia'),(15,'AW','Aruba'),(16,'AU','Australia'),(17,'AT','Austria'),(18,'AZ','Azerbaiyán'),(19,'BS','Bahamas'),(20,'BH','Bahréin'),(21,'BD','Bangladesh'),(22,'BB','Barbados'),(23,'BY','Bielorrusia'),(24,'BE','Bélgica'),(25,'BZ','Belice'),(26,'BJ','Benin'),(27,'BM','Bermudas'),(28,'BT','Bhután'),(29,'BO','Bolivia'),(30,'BA','Bosnia y Herzegovina'),(31,'BW','Botsuana'),(32,'BV','Isla Bouvet'),(33,'BR','Brasil'),(34,'BN','Brunéi'),(35,'BG','Bulgaria'),(36,'BF','Burkina Faso'),(37,'BI','Burundi'),(38,'CV','Cabo Verde'),(39,'KY','Islas Caimán'),(40,'KH','Camboya'),(41,'CM','Camerún'),(42,'CA','Canadá'),(43,'CF','República Centroafricana'),(44,'TD','Chad'),(45,'CZ','República Checa'),(46,'CL','Chile'),(47,'CN','China'),(48,'CY','Chipre'),(49,'CX','Isla de Navidad'),(50,'VA','Ciudad del Vaticano'),(51,'CC','Islas Cocos'),(52,'CO','Colombia'),(53,'KM','Comoras'),(54,'CD','República Democrática del Congo'),(55,'CG','Congo'),(56,'CK','Islas Cook'),(57,'KP','Corea del Norte'),(58,'KR','Corea del Sur'),(59,'CI','Costa de Marfil'),(60,'CR','Costa Rica'),(61,'HR','Croacia'),(62,'CU','Cuba'),(63,'DK','Dinamarca'),(64,'DM','Dominica'),(65,'DO','República Dominicana'),(66,'EC','Ecuador'),(67,'EG','Egipto'),(68,'SV','El Salvador'),(69,'AE','Emiratos Árabes Unidos'),(70,'ER','Eritrea'),(71,'SK','Eslovaquia'),(72,'SI','Eslovenia'),(73,'ES','España'),(74,'UM','Islas ultramarinas de Estados Unidos'),(75,'US','Estados Unidos'),(76,'EE','Estonia'),(77,'ET','Etiopía'),(78,'FO','Islas Feroe'),(79,'PH','Filipinas'),(80,'FI','Finlandia'),(81,'FJ','Fiyi'),(82,'FR','Francia'),(83,'GA','Gabón'),(84,'GM','Gambia'),(85,'GE','Georgia'),(86,'GS','Islas Georgias del Sur y Sandwich del Sur'),(87,'GH','Ghana'),(88,'GI','Gibraltar'),(89,'GD','Granada'),(90,'GR','Grecia'),(91,'GL','Groenlandia'),(92,'GP','Guadalupe'),(93,'GU','Guam'),(94,'GT','Guatemala'),(95,'GF','Guayana Francesa'),(96,'GN','Guinea'),(97,'GQ','Guinea Ecuatorial'),(98,'GW','Guinea-Bissau'),(99,'GY','Guyana'),(100,'HT','Haití'),(101,'HM','Islas Heard y McDonald'),(102,'HN','Honduras'),(103,'HK','Hong Kong'),(104,'HU','Hungría'),(105,'IN','India'),(106,'ID','Indonesia'),(107,'IR','Irán'),(108,'IQ','Iraq'),(109,'IE','Irlanda'),(110,'IS','Islandia'),(111,'IL','Israel'),(112,'IT','Italia'),(113,'JM','Jamaica'),(114,'JP','Japón'),(115,'JO','Jordania'),(116,'KZ','Kazajstán'),(117,'KE','Kenia'),(118,'KG','Kirguistán'),(119,'KI','Kiribati'),(120,'KW','Kuwait'),(121,'LA','Laos'),(122,'LS','Lesotho'),(123,'LV','Letonia'),(124,'LB','Líbano'),(125,'LR','Liberia'),(126,'LY','Libia'),(127,'LI','Liechtenstein'),(128,'LT','Lituania'),(129,'LU','Luxemburgo'),(130,'MO','Macao'),(131,'MK','ARY Macedonia'),(132,'MG','Madagascar'),(133,'MY','Malasia'),(134,'MW','Malawi'),(135,'MV','Maldivas'),(136,'ML','Malí'),(137,'MT','Malta'),(138,'FK','Islas Malvinas'),(139,'MP','Islas Marianas del Norte'),(140,'MA','Marruecos'),(141,'MH','Islas Marshall'),(142,'MQ','Martinica'),(143,'MU','Mauricio'),(144,'MR','Mauritania'),(145,'YT','Mayotte'),(146,'MX','México'),(147,'FM','Micronesia'),(148,'MD','Moldavia'),(149,'MC','Mónaco'),(150,'MN','Mongolia'),(151,'MS','Montserrat'),(152,'MZ','Mozambique'),(153,'MM','Myanmar'),(154,'NA','Namibia'),(155,'NR','Nauru'),(156,'NP','Nepal'),(157,'NI','Nicaragua'),(158,'NE','Níger'),(159,'NG','Nigeria'),(160,'NU','Niue'),(161,'NF','Isla Norfolk'),(162,'NO','Noruega'),(163,'NC','Nueva Caledonia'),(164,'NZ','Nueva Zelanda'),(165,'OM','Omán'),(166,'NL','Países Bajos'),(167,'PK','Pakistán'),(168,'PW','Palau'),(169,'PS','Palestina'),(170,'PA','Panamá'),(171,'PG','Papúa Nueva Guinea'),(172,'PY','Paraguay'),(173,'PE','Perú'),(174,'PN','Islas Pitcairn'),(175,'PF','Polinesia Francesa'),(176,'PL','Polonia'),(177,'PT','Portugal'),(178,'PR','Puerto Rico'),(179,'QA','Qatar'),(180,'GB','Reino Unido'),(181,'RE','Reunión'),(182,'RW','Ruanda'),(183,'RO','Rumania'),(184,'RU','Rusia'),(185,'EH','Sahara Occidental'),(186,'SB','Islas Salomón'),(187,'WS','Samoa'),(188,'AS','Samoa Americana'),(189,'KN','San Cristóbal y Nevis'),(190,'SM','San Marino'),(191,'PM','San Pedro y Miquelón'),(192,'VC','San Vicente y las Granadinas'),(193,'SH','Santa Helena'),(194,'LC','Santa Lucía'),(195,'ST','Santo Tomé y Príncipe'),(196,'SN','Senegal'),(197,'CS','Serbia y Montenegro'),(198,'SC','Seychelles'),(199,'SL','Sierra Leona'),(200,'SG','Singapur'),(201,'SY','Siria'),(202,'SO','Somalia'),(203,'LK','Sri Lanka'),(204,'SZ','Suazilandia'),(205,'ZA','Sudáfrica'),(206,'SD','Sudán'),(207,'SE','Suecia'),(208,'CH','Suiza'),(209,'SR','Surinam'),(210,'SJ','Svalbard y Jan Mayen'),(211,'TH','Tailandia'),(212,'TW','Taiwán'),(213,'TZ','Tanzania'),(214,'TJ','Tayikistán'),(215,'IO','Territorio Británico del Océano Índico'),(216,'TF','Territorios Australes Franceses'),(217,'TL','Timor Oriental'),(218,'TG','Togo'),(219,'TK','Tokelau'),(220,'TO','Tonga'),(221,'TT','Trinidad y Tobago'),(222,'TN','Túnez'),(223,'TC','Islas Turcas y Caicos'),(224,'TM','Turkmenistán'),(225,'TR','Turquía'),(226,'TV','Tuvalu'),(227,'UA','Ucrania'),(228,'UG','Uganda'),(229,'UY','Uruguay'),(230,'UZ','Uzbekistán'),(231,'VU','Vanuatu'),(232,'VE','Venezuela'),(233,'VN','Vietnam'),(234,'VG','Islas Vírgenes Británicas'),(235,'VI','Islas Vírgenes de los Estados Unidos'),(236,'WF','Wallis y Futuna'),(237,'YE','Yemen'),(238,'DJ','Yibuti'),(239,'ZM','Zambia'),(240,'ZW','Zimbabue');
/*!40000 ALTER TABLE `paises` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paypal`
--

DROP TABLE IF EXISTS `paypal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paypal` (
  `variables` text COLLATE utf8_unicode_ci NOT NULL,
  `cdate` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paypal`
--

LOCK TABLES `paypal` WRITE;
/*!40000 ALTER TABLE `paypal` DISABLE KEYS */;
/*!40000 ALTER TABLE `paypal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prelaunch_email`
--

DROP TABLE IF EXISTS `prelaunch_email`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prelaunch_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `interest` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cdate` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=270 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prelaunch_email`
--

LOCK TABLES `prelaunch_email` WRITE;
/*!40000 ALTER TABLE `prelaunch_email` DISABLE KEYS */;
INSERT INTO `prelaunch_email` VALUES (7,'mrocha86@gmail.com','Fotografo','2013-07-29 07:30:38'),(27,'rabricenog@gmail.com','Fotografo','2013-07-31 18:07:28'),(9,'Nayaridpr87@gmail.com','Fotografo','2013-07-29 08:12:32'),(10,'paulo.goncalves@iese.net','Fotografo','2013-07-29 09:01:12'),(11,'funkychop0530@gmail.com','Fotografo','2013-07-29 09:16:00'),(12,'Blanca.fernandez@iese.net','Fotografo','2013-07-29 09:53:29'),(13,'luca@bidaway.com','Fotografo','2013-07-29 10:11:53'),(14,'hmirabalz@gmail.com','Fotografo','2013-07-29 11:35:57'),(15,'marron.daniel@gmail.com','Fotografo','2013-07-29 13:40:31'),(16,'gonzaloaguilera@klick.com.ve','Fotografo','2013-07-29 14:34:02'),(17,'silrojas92@gmail.com','Fotografo','2013-07-29 15:28:12'),(18,'paulogoncalvesr@gmail.com','Fotografo','2013-07-29 17:34:32'),(19,'odreman.reinaldo@gmail.com','Fotografo','2013-07-30 00:18:23'),(20,'alittasobi@gmail.com','Fotografo','2013-07-30 02:01:13'),(21,'morales.oscar.d@gmail.com','Fotografo','2013-07-30 13:51:44'),(22,'contacto@3dlproducciones.com','Fotografo','2013-07-30 15:35:04'),(23,'siolly@hotmail.com','Fotografo','2013-07-30 21:02:23'),(24,'Luisabarbosah000@gmail.com','Fotografo','2013-07-30 22:39:41'),(25,'carolinasanchezcuellar@gmail.com','Fotografo','2013-07-30 22:43:28'),(26,'danielanarciso@gmail.com','Fotografo','2013-07-31 16:39:57'),(28,'utopiagraphics@gmail.com','Fotografo','2013-07-31 19:23:01'),(29,'Paulo@fototea.com','Fotografo','2013-08-01 02:28:33'),(30,'luis@thergbcorp.com','Fotografo','2013-08-01 07:08:35'),(31,'luispernia2000@gmail.com','Fotografo','2013-08-01 07:59:08'),(32,'josmaira@gmail.com','Fotografo','2013-08-01 10:00:41'),(33,'serranoja@gmail.com','Fotografo','2013-08-01 23:06:54'),(34,'rectorindependiente@gmail.com','Fotografo','2013-08-01 23:36:00'),(35,'av.guzmano@gmail.com','Fotografo','2013-08-05 11:41:24'),(36,'Rafaelmedinacastillo@hotmail.com','Fotografo','2013-08-05 15:31:59'),(37,'max.marascia@gmail.com','Fotografo','2013-08-07 09:33:44'),(38,'oho0013@gmail.com','Fotografo','2013-08-08 12:06:22'),(39,'beny032@gmail.com','Fotografo','2013-08-08 12:51:37'),(40,'vanessa-rangel@hotmail.com','Fotografo','2013-08-10 15:33:59'),(41,'grant@quotanda.com','Fotografo','2013-08-10 17:21:28'),(42,'matias@canelson.com.ar','Fotografo','2013-08-13 21:14:37'),(52,'info@pieralexandregagne.com','Fotografo','2013-08-16 19:23:41'),(53,'christian.olivares@gmail.com','Cliente','2013-08-19 15:31:07'),(54,'gastonaportal@gmail.com','Fotografo','2013-08-19 21:01:32'),(55,'','','2013-08-21 11:45:36'),(56,'mariana@ungranrecuerdo.com','Cliente','2013-08-21 14:20:30'),(57,'isakintan@gmail.com','Cliente','2013-08-21 15:29:18'),(58,'mezocarlos@gmail.com','Cliente','2013-08-26 05:13:10'),(59,'bookdemodelosvzla@gmail.com','Cliente','2013-08-28 17:26:38'),(60,'veraluciahernandez@yahoo.com','Cliente','2013-08-28 17:46:44'),(61,'ruperbass@Gmail.com','Cliente','2013-08-29 16:04:26'),(62,'ramalberich@hotmail.com','Cliente','2013-09-05 11:27:29'),(63,'aleman@cantv.net','Cliente','2013-09-05 14:53:03'),(64,'hsequeraphoto@gmail.com','Fotografo','2013-09-05 16:16:41'),(65,'cristinasalvadormoll@gmail.com','Fotografo','2013-09-06 04:22:34'),(66,'david.arroyo.calahorro@hotmail.com','Cliente','2013-09-06 04:34:28'),(67,'julietacrame@gmail.com','Cliente','2013-09-08 07:50:03'),(68,'ypaiva@gmail.com','Cliente','2013-09-09 17:28:24'),(69,'sr.emeele@gmail.com','Cliente','2013-09-11 04:09:16'),(70,'estefania.quinteroque@gmail.com','Cliente','2013-09-25 13:20:47'),(71,'magabi.lopez@gmail.com','Cliente','2013-09-30 08:16:05'),(72,'buonanno.fulvia@gmail.com','Cliente','2013-10-01 06:26:21'),(73,'tanit.roig@gmail.com','Fotografo','2013-10-01 14:09:44'),(74,'abelmolina23@gmail.com','Cliente','2013-10-01 14:48:51'),(75,'mafe217@hotmail.com','Cliente','2013-10-03 11:42:56'),(76,'ernest@sizephoto.com','Cliente','2013-10-11 02:15:25'),(77,'noebarceb@gmail.com','Cliente','2013-10-13 18:14:04'),(78,'adri.penalva@gmail.com','Cliente','2013-10-15 12:47:15'),(79,'manu.rr.garcia@gmail.com','Cliente','2013-10-16 13:08:48'),(80,'hosastre@gmail.com','Cliente','2013-10-17 05:56:16'),(81,'candina@gmail.com','Cliente','2013-10-22 09:32:00'),(82,'gsfswf@gmail.com','Fotografo','2013-10-23 12:36:11'),(83,'ffvdfg@gmail.com','Cliente','2013-10-23 12:37:09'),(84,'photoaroma@gmail.com','Cliente','2013-10-28 17:36:24'),(85,'martapujades@gmail.com','Cliente','2013-10-30 17:08:41'),(86,'luiscalderoncorripio@hotmail.com','Fotografo','2013-11-04 14:22:09'),(87,'cnistal@gmail.com','Cliente','2013-11-04 15:06:21'),(88,'ghill.sky@gmail.com','Cliente','2013-11-06 06:47:06'),(89,'palbord@gmail.com','Cliente','2013-11-07 15:13:34'),(90,'asurbistondo@gmail.com','Cliente','2013-11-07 15:49:01'),(91,'allanbruno89@gmail.com','Fotografo','2013-11-11 17:29:36'),(92,'info@photolounge.es','Cliente','2013-11-11 18:37:50'),(93,'leopatino@gmail.com','Cliente','2013-11-11 18:43:45'),(94,'karen.2maturano@gmail.com','Fotografo','2013-11-12 07:43:14'),(95,'claudiobertinetti@gmail.com','Cliente','2013-11-12 08:36:51'),(96,'munne.nuria@gmail.com','Cliente','2013-11-12 09:28:15'),(97,'inigosierra@gmail.com','Cliente','2013-11-14 05:43:34'),(98,'Diana.drago@gmail.com','Cliente','2013-11-17 17:20:28'),(99,'Niccolo.Cappon@iese.net','Fotografo','2013-11-17 22:13:21'),(100,'nico.ongaro@yahoo.it','Cliente','2013-11-18 08:22:23'),(101,'rohemo11@gmail.com','Cliente','2013-11-19 02:55:24'),(102,'lucaaimi1@gmail.com','Cliente','2013-11-19 09:51:22'),(103,'albertoalonsophoto@gmail.com','Fotografo','2013-11-21 12:38:41'),(104,'foto@marccastellet.cat','Cliente','2013-11-26 11:31:48'),(105,'lalibellobi@gmail.com','Cliente','2013-11-26 14:44:56'),(106,'antonioserranocorbacho@gmail.com','Cliente','2013-11-26 18:25:31'),(107,'Dngaya@gmai.com','Cliente','2013-11-27 08:21:57'),(108,'escriu@cecymota.com','Cliente','2013-11-27 09:05:18'),(109,'afer_15@hotmail.com','Cliente','2013-11-27 11:24:49'),(110,'info@roberastorgano.com','Cliente','2013-11-27 11:49:22'),(111,'javierollerfoto@gmail.com','Cliente','2013-11-27 12:35:14'),(112,'paula.n.clavero@gmail.com','Cliente','2013-11-27 14:22:22'),(113,'joandeulofeugomez@gmail.com','Cliente','2013-11-27 16:20:24'),(114,'dancingthedreams@gmail.com','Cliente','2013-11-27 18:28:00'),(115,'vagaworld@gmail.com','Cliente','2013-11-28 04:16:14'),(116,'stefvara@gmail.com','Cliente','2013-11-28 05:11:43'),(117,'balerio_one@hotmail.com','Cliente','2013-11-28 07:21:11'),(118,'ffernandez1999@hotmail.com','Cliente','2013-11-28 07:33:12'),(119,'marta.quismondo@gmail.com','Cliente','2013-11-28 08:00:23'),(120,'vdo.fotografia@gmail.com','Cliente','2013-11-28 08:05:17'),(121,'gonzalez_gonzi_1990@hotmail.com','Cliente','2013-11-28 08:53:13'),(122,'irialorenzo@gmail.com','Cliente','2013-11-28 09:44:16'),(123,'cesanto81@hotmail.com','Cliente','2013-11-28 14:34:25'),(124,'mafiroig@gmail.com','Cliente','2013-11-29 06:53:13'),(125,'chepina@gmail.com','Cliente','2013-11-30 06:09:00'),(126,'alfredo_ovalles@hotmail.com','Fotografo','2013-11-30 06:34:24'),(127,'alegarciasanchez@hotmail.com','Cliente','2013-11-30 07:04:36'),(128,'anahinovillo@hotmail.com','Cliente','2013-11-30 07:20:28'),(129,'julietagiuliano@gmail.com','Cliente','2013-11-30 09:29:59'),(130,'vnucete87@gmail.com','Cliente','2013-11-30 10:28:57'),(131,'fotonc2@gmail.com','Cliente','2013-11-30 11:52:34'),(132,'c@carlossilva.es','Cliente','2013-12-01 05:40:17'),(133,'irenemoray@gmail.com','Cliente','2013-12-01 13:17:27'),(134,'joselefotos@hotmail.com','Cliente','2013-12-02 06:50:57'),(135,'fsilla@yahoo.com','Cliente','2013-12-02 08:55:03'),(136,'jpadillacliment@gmail.com','Cliente','2013-12-02 13:05:00'),(137,'lucasrafael.uece@gmail.com','Fotografo','2013-12-02 19:44:36'),(138,'fotograma64@gmail.com','Cliente','2013-12-05 03:40:11'),(139,'lacaaimi1@gmail.com','Cliente','2013-12-05 16:42:39'),(140,'wedding photographer','Fotografo','2013-12-09 12:44:05'),(141,'pjoglar@gmail.com','Cliente','2013-12-09 12:45:34'),(142,'nacho.giralt.domingo@gmail.com','Cliente','2013-12-09 12:58:32'),(143,'a@gmail.com','Fotografo','2013-12-09 23:25:35'),(144,'hloboss@gmail.com','Fotografo','2013-12-10 06:43:44'),(145,'neva22@yahoo.com','Cliente','2013-12-10 10:45:55'),(146,'yvesdimantphoto@gmail.com','Cliente','2013-12-10 12:10:15'),(147,'eduardo@stgo2night.cl','Cliente','2013-12-12 20:40:56'),(148,'agusvialr@gmail.com','Fotografo','2013-12-12 20:41:49'),(149,'valentinamirandavega@gmail.com','Cliente','2013-12-12 20:53:45'),(150,'guishe_017@hotmail.com','Cliente','2013-12-12 20:56:29'),(151,'riding_thebullet@yahoo.es','Cliente','2013-12-12 21:00:30'),(152,'instantaneas','Cliente','2013-12-12 21:48:14'),(153,'valrodfotografias@gmail.com','Cliente','2013-12-12 21:49:30'),(154,'eduardomoya.produccion@gmail.com','Fotografo','2013-12-12 22:13:18'),(155,'rsalinaso@gmail.com','Fotografo','2013-12-13 00:27:57'),(156,'fotografia60@gmail.com','Cliente','2013-12-13 07:32:21'),(157,'nerwelfotografia@gmail.com','Cliente','2013-12-16 13:27:32'),(158,'lunamartinsanchez@hotmail.es','Cliente','2013-12-18 03:28:52'),(159,'jsalvadorvision@gmail.com','Cliente','2013-12-19 04:09:20'),(160,'yovester@hotmail.com','Cliente','2013-12-19 16:13:27'),(161,'contacto@vitofilms.cl','Cliente','2013-12-19 16:21:00'),(162,'japavees@hotmail.com','Cliente','2013-12-19 17:30:52'),(163,'fotografo.sergioh@gmail.com','Cliente','2013-12-19 17:39:22'),(164,'zeluloide@gmail.com','Cliente','2013-12-19 18:16:08'),(165,'ahahad@hotmail.com','Cliente','2013-12-19 18:19:59'),(166,'linxgrafic@gmail.com','Cliente','2013-12-19 18:36:20'),(167,'alvaroarosgarrido@gmail.com','Cliente','2013-12-19 18:56:55'),(168,'bernardita.hernandezf@gmail.com','Cliente','2013-12-19 19:19:50'),(169,'jeapc@hotmail.com','Cliente','2013-12-19 19:22:52'),(170,'trickaster@gmail.com','Cliente','2013-12-19 20:02:22'),(171,'hvallejosa@gmail.com','Cliente','2013-12-19 20:45:57'),(172,'difusofoto@gmail.com','Cliente','2013-12-19 21:16:19'),(173,'mmedina.cl@gmail.com','Cliente','2013-12-20 15:20:41'),(174,'martinmartua@gmail.com','Cliente','2013-12-20 15:23:44'),(175,'patagon-@hotmail.es','Fotografo','2013-12-20 15:24:18'),(176,'ediodgers@gmail.com','Cliente','2013-12-20 15:26:35'),(177,'reygadas@fotosrey.com','Cliente','2013-12-20 15:29:00'),(178,'cartermontecinos@gmail.com','Cliente','2013-12-20 15:29:03'),(179,'jhonorbeat.music@gmail.com','Cliente','2013-12-20 15:29:47'),(180,'sero.ae@gmail.com','Cliente','2013-12-20 15:34:17'),(181,'micheledison@gmail.com','Cliente','2013-12-20 15:34:31'),(182,'claklocl@gmail.com','Cliente','2013-12-20 15:36:56'),(183,'candia.audiovisual@gmail.com','Cliente','2013-12-20 15:37:04'),(184,'paolavalencia.fotografias@gmail.com','Cliente','2013-12-20 15:38:57'),(185,'felipe.soza.soza@gmail.com','Fotografo','2013-12-20 15:39:20'),(186,'daniel@fotosur.cl','Cliente','2013-12-20 15:44:42'),(187,'novios@imagen26.com','Cliente','2013-12-20 15:53:28'),(188,'renedelacruzcl@gmail.com','Cliente','2013-12-20 15:53:49'),(189,'vanessamoralesmeza@gmail.com','Cliente','2013-12-20 15:56:05'),(190,'rodrigo_8113@hotmail.com','Cliente','2013-12-20 15:59:14'),(191,'tnoches84@hotmail.com','Cliente','2013-12-20 16:11:10'),(192,'izam_rc@hotmail.com','Cliente','2013-12-20 16:14:37'),(193,'izamrc23@gmail.com','Cliente','2013-12-20 16:15:55'),(194,'juanmanuel@payurshots.com','Cliente','2013-12-20 16:16:53'),(195,'daniel@danieljove.com','Cliente','2013-12-20 16:20:23'),(196,'creativework@hotmail.es','Cliente','2013-12-20 17:30:55'),(197,'idvsdproducciones@gmail.com','Cliente','2013-12-20 17:45:54'),(198,'rgt69_2@hotmail.com','Cliente','2013-12-20 18:29:39'),(199,'juanjoserivera.stratos@gmail.com','Cliente','2013-12-20 18:30:45'),(200,'quirozwato@hotmail.com','Fotografo','2013-12-20 18:39:31'),(201,'robinson.marchant@gmail.com','Cliente','2013-12-20 18:40:44'),(202,'haroldohorta@gmail.com','Cliente','2013-12-20 18:49:00'),(203,'l.valencia.colque@gmail.com','Fotografo','2013-12-20 18:54:09'),(204,'zolodos@hotmail.com','Cliente','2013-12-20 18:59:03'),(205,'ktu.martinezh@gmail.com','Cliente','2013-12-20 19:01:43'),(206,'petobar@gmail.com','Fotografo','2013-12-20 19:15:44'),(207,'gabrielapenelafotografia@gmail.com','Cliente','2013-12-20 19:32:15'),(208,'sbmarting@gmail.com','Cliente','2013-12-20 19:41:22'),(209,'loretotapia.fotografia@gmail.com','Cliente','2013-12-20 19:41:44'),(210,'humangroupvideo@gmail.com','Cliente','2013-12-20 19:43:51'),(211,'kubeda@gmail.com','Cliente','2013-12-20 19:46:52'),(212,'chino_mestizo@hotmail.com','Fotografo','2013-12-20 19:55:09'),(213,'imagen.digital@telsur.cl','Fotografo','2013-12-20 19:56:06'),(214,'estudiosclaveluz@yahoo.com','Cliente','2013-12-20 19:58:01'),(215,'vkunov@yahoo.com','Cliente','2013-12-20 20:05:06'),(216,'fotonovio@hotmail.com','Cliente','2013-12-20 20:06:33'),(217,'capturartecl@gmail.com','Cliente','2013-12-20 20:12:38'),(218,'francisca.ibanez.providell@gmail.com','Cliente','2013-12-20 20:18:58'),(219,'vkunov63@gmail.com','Cliente','2013-12-20 20:29:23'),(220,'alicia_h_z@yahoo.com','Cliente','2013-12-20 20:36:04'),(221,'m.olavarria.i@gmail.com','Cliente','2013-12-20 20:46:07'),(222,'pato.vegancore@gmail.com','Cliente','2013-12-20 20:47:37'),(223,'cata_ro213@hotmail.com','Cliente','2013-12-20 20:53:58'),(224,'ale.cinf@gmail.com','Fotografo','2013-12-20 20:55:36'),(225,'marioalejandro.urbina@msn.com','Cliente','2013-12-20 21:00:46'),(226,'asalaz20@gmail.com','Cliente','2013-12-20 21:22:32'),(227,'benjacoca@gmail.com','Cliente','2013-12-20 21:27:54'),(228,'felipemuoz6@gmail.com','Fotografo','2013-12-20 21:39:15'),(229,'luis1464@gmail.com','Cliente','2013-12-20 21:54:25'),(230,'trujillogalaz@gmail.com','Cliente','2013-12-20 22:42:00'),(231,'esteban.cerda.godoy@gmail.com','Cliente','2013-12-20 22:43:04'),(232,'fco.alvarado.j@gmail.com','Cliente','2013-12-20 22:44:46'),(233,'rarojas12@alumnos.utalca.cl','Cliente','2013-12-20 22:51:05'),(234,'gutarembe@gmail.com','Cliente','2013-12-20 23:03:37'),(235,'nachodote@gmail.com','Cliente','2013-12-21 06:37:51'),(236,'jorgevargasparra@gmail.com','Cliente','2013-12-22 07:32:42'),(237,'foto.carrasco@gmail.com','Cliente','2013-12-23 08:02:39'),(238,'carlosemarciales@gmail.com','Cliente','2013-12-24 11:32:06'),(239,'marcelosolisfotos@gmail.com','Cliente','2013-12-24 14:06:42'),(240,'multimediosargentina@yahoo.com.ar','Cliente','2013-12-24 14:11:01'),(241,'vicky@haizelan.com','Cliente','2013-12-26 05:06:59'),(242,'marioscottibomb@hotmail.com','Cliente','2013-12-26 14:54:17'),(243,'viddasum@gmail.com','Cliente','2014-01-05 03:30:23'),(244,'bettina@camaloon.com','Fotografo','2014-01-06 16:33:37'),(245,'arare94@hotmail.com','Cliente','2014-01-08 08:09:05'),(246,'ignasi.fotografia@gmail.com','Cliente','2014-01-09 12:48:48'),(247,'Ariadna_89@msn.com','Cliente','2014-01-18 02:34:23'),(248,'javierporterovela@hotmail.com','Cliente','2014-01-19 14:10:42'),(249,'mimita@gmail.com','Cliente','2014-01-21 05:41:59'),(250,'matador0000@hotmail.com','Fotografo','2014-01-23 16:07:24'),(251,'rrjeanpablo@gmail.com','Fotografo','2014-01-23 18:00:34'),(252,'sulladrellum@yahoo.es','Fotografo','2014-01-24 05:29:58'),(253,'gerard.moret@gmail.com','Cliente','2014-01-28 09:49:05'),(254,'sheigm92@gmail.com','Cliente','2014-02-01 09:16:17'),(255,'jmprfoto@gmail.com','Cliente','2014-02-06 01:17:28'),(256,'txema.photo.works@gmail.com','Cliente','2014-02-10 07:35:09'),(257,'kilian_vadnov@hotmail.com','Cliente','2014-02-11 02:41:19'),(258,'muntsabee@gmail.com','Cliente','2014-02-11 03:10:28'),(259,'maletaglia@gmail.com','Cliente','2014-02-14 09:16:50'),(260,'karinaetcheverry@hotmail.com','Cliente','2014-02-14 09:18:05'),(261,'andreamadia@hotmail.com','Cliente','2014-02-14 16:25:37'),(262,'marianamtron@hotmail.com','Cliente','2014-02-18 13:46:46'),(263,'jordiadell32@gmail.com','Cliente','2014-02-20 08:50:29'),(264,'chorozqui.aldo@gmail.com','Cliente','2014-03-07 05:26:02'),(265,'liesl.hros@gmail.com','Fotografo','2014-03-09 16:42:01'),(266,'philip@philip.me','Fotografo','2014-03-13 18:36:19'),(267,'info@giovannibettinello.com','Cliente','2014-03-17 12:36:48'),(268,'cos.style@hotmail.com','Cliente','2014-03-19 12:16:53'),(269,'se2v2@hotmail.com','Cliente','2014-03-19 15:45:17');
/*!40000 ALTER TABLE `prelaunch_email` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pro_transactions`
--

DROP TABLE IF EXISTS `pro_transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pro_transactions` (
  `t_id` int(11) NOT NULL AUTO_INCREMENT,
  `t_pro_id` int(11) NOT NULL,
  `t_oferta_id` int(11) NOT NULL,
  `t_status` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `t_cdate` datetime NOT NULL,
  `t_pdate` datetime NOT NULL,
  `t_trans_id` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `t_monto` float NOT NULL,
  `usuario_pago` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`t_id`),
  UNIQUE KEY `t_pro_id` (`t_pro_id`,`t_oferta_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pro_transactions`
--

LOCK TABLES `pro_transactions` WRITE;
/*!40000 ALTER TABLE `pro_transactions` DISABLE KEYS */;
INSERT INTO `pro_transactions` VALUES (1,1,1,'P','2014-05-26 16:53:04','0000-00-00 00:00:00',' ',0,' '),(2,2,3,'P','2014-05-26 18:36:37','0000-00-00 00:00:00',' ',0,' ');
/*!40000 ALTER TABLE `pro_transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyecto_fin`
--

DROP TABLE IF EXISTS `proyecto_fin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyecto_fin` (
  `pf_id` int(11) NOT NULL AUTO_INCREMENT,
  `pf_pro_id` int(11) NOT NULL,
  `pf_user_id` int(11) NOT NULL,
  `pf_status` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `pf_date` datetime NOT NULL,
  PRIMARY KEY (`pf_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyecto_fin`
--

LOCK TABLES `proyecto_fin` WRITE;
/*!40000 ALTER TABLE `proyecto_fin` DISABLE KEYS */;
/*!40000 ALTER TABLE `proyecto_fin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyectos`
--

DROP TABLE IF EXISTS `proyectos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyectos` (
  `pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_cod` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `pro_tit` text COLLATE utf8_spanish_ci NOT NULL,
  `pro_descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `pro_budget` float NOT NULL,
  `pro_date` datetime NOT NULL,
  `pro_date_end` datetime NOT NULL,
  `pro_cant` int(11) NOT NULL,
  `pro_length` varchar(20) COLLATE utf8_spanish_ci NOT NULL DEFAULT 'N/A',
  `pro_country` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `pro_state` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `pro_city` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `pro_address` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `pro_cp` int(11) NOT NULL,
  `pro_type` int(11) NOT NULL,
  `pro_category` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pro_status` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `pro_cdate` datetime NOT NULL,
  PRIMARY KEY (`pro_id`),
  UNIQUE KEY `pro_cod` (`pro_cod`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyectos`
--

LOCK TABLES `proyectos` WRITE;
/*!40000 ALTER TABLE `proyectos` DISABLE KEYS */;
INSERT INTO `proyectos` VALUES (1,'140526162814','TÃ­tulo del proyecto','Hola, esta es  la descripciÃ³n',0,'2014-06-17 00:00:00','2014-05-26 16:53:04',10,'DuraciÃ³n del video','VE','Distrito Capital','Caracas','Plaza Venezuela',1060,1,2,4,'AD','2014-05-26 16:28:14'),(2,'140526165842','Prueba','aaaaaa',0,'2014-06-18 00:00:00','2014-05-26 18:36:37',2,'DuraciÃ³n del video','EH','cccccccccccc','bbbbbbbbbbbbbb','aaaaaaaaaa',0,1,8,4,'AD','2014-05-26 16:58:42'),(3,'140526170413','Aaaaaaaa','bbbbbbbbb',0,'2014-06-19 00:00:00','2014-06-10 17:04:13',4,'DuraciÃ³n del video','VE','ccccccccccc','bbbbbbbbbb','aaaaaaaaa',0,1,1,4,'C','2014-05-26 17:04:13');
/*!40000 ALTER TABLE `proyectos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `proyectos_view`
--

DROP TABLE IF EXISTS `proyectos_view`;
/*!50001 DROP VIEW IF EXISTS `proyectos_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `proyectos_view` (
  `pro_id` tinyint NOT NULL,
  `pro_cod` tinyint NOT NULL,
  `pro_tit` tinyint NOT NULL,
  `pro_descripcion` tinyint NOT NULL,
  `pro_budget` tinyint NOT NULL,
  `pro_date` tinyint NOT NULL,
  `pro_date_end` tinyint NOT NULL,
  `pro_cant` tinyint NOT NULL,
  `pro_length` tinyint NOT NULL,
  `pro_country` tinyint NOT NULL,
  `pro_state` tinyint NOT NULL,
  `pro_city` tinyint NOT NULL,
  `pro_address` tinyint NOT NULL,
  `pro_cp` tinyint NOT NULL,
  `pro_type` tinyint NOT NULL,
  `pro_category` tinyint NOT NULL,
  `user_id` tinyint NOT NULL,
  `pro_status` tinyint NOT NULL,
  `pro_cdate` tinyint NOT NULL,
  `total_ofertas` tinyint NOT NULL,
  `oferta_adjudicada_id` tinyint NOT NULL,
  `oferta_user_id` tinyint NOT NULL,
  `oferta_bid` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `referrals`
--

DROP TABLE IF EXISTS `referrals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `referrals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `referring_user` int(11) NOT NULL,
  `referred_user` int(11) NOT NULL,
  `media` varchar(50) NOT NULL,
  `date` datetime NOT NULL,
  `exchange_date` datetime DEFAULT NULL,
  `exchanged` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `referrals`
--

LOCK TABLES `referrals` WRITE;
/*!40000 ALTER TABLE `referrals` DISABLE KEYS */;
/*!40000 ALTER TABLE `referrals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `review_types`
--

DROP TABLE IF EXISTS `review_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `review_types` (
  `rt_id` int(11) NOT NULL AUTO_INCREMENT,
  `rt_desc` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `rt_abv` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`rt_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `review_types`
--

LOCK TABLES `review_types` WRITE;
/*!40000 ALTER TABLE `review_types` DISABLE KEYS */;
INSERT INTO `review_types` VALUES (1,'finish','F'),(2,'Calificacion','C'),(3,'comment','CO'),(4,'Calidad','CA'),(5,'trato','T'),(6,'puntualidad','P'),(7,'Responsabilidad','R'),(8,'Profesionalismo','PR');
/*!40000 ALTER TABLE `review_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `r_id` int(11) NOT NULL AUTO_INCREMENT,
  `r_pro_id` int(11) NOT NULL,
  `r_user_id` int(11) NOT NULL,
  `r_user_eval` int(11) NOT NULL,
  `r_type` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `r_value` text COLLATE utf8_spanish_ci NOT NULL,
  `r_cdate` datetime NOT NULL,
  PRIMARY KEY (`r_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `security`
--

DROP TABLE IF EXISTS `security`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `security` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `modules_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=351 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `security`
--

LOCK TABLES `security` WRITE;
/*!40000 ALTER TABLE `security` DISABLE KEYS */;
INSERT INTO `security` VALUES (347,6,10),(346,6,14),(345,6,1),(344,2,13),(343,2,18),(342,2,11),(341,2,10),(340,2,14),(339,2,1),(348,6,11),(349,6,18),(350,6,13);
/*!40000 ALTER TABLE `security` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `seo`
--

DROP TABLE IF EXISTS `seo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `seo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` text COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `keywords` varchar(120) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `seo`
--

LOCK TABLES `seo` WRITE;
/*!40000 ALTER TABLE `seo` DISABLE KEYS */;
/*!40000 ALTER TABLE `seo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `submodules`
--

DROP TABLE IF EXISTS `submodules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `submodules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `modules_id` int(11) NOT NULL,
  `url` varchar(100) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `submodules`
--

LOCK TABLES `submodules` WRITE;
/*!40000 ALTER TABLE `submodules` DISABLE KEYS */;
INSERT INTO `submodules` VALUES (1,'Usuarios del Sistema',11,'administracion-sistema',9),(14,'Banner principal',6,'banner',1),(13,'Usuarios',5,'usuarios',1),(10,'Listado',2,'pagos',1),(11,'Listado',3,'seo',1),(18,'Email Prelaunch',5,'prelaunch',2);
/*!40000 ALTER TABLE `submodules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `lastname` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `user` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `password` text COLLATE utf8_spanish_ci NOT NULL,
  `salt` text COLLATE utf8_spanish_ci NOT NULL,
  `user_type` int(11) NOT NULL,
  `cdate` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `act` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `act_code` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `wizard_completed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`),
  UNIQUE KEY `act_code` (`act_code`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Andrea','LebrÃºn','1983-01-01','M','andrealebrun+26mayo@gmail.com','4f264e1896094c8fcac3fd080da6eb2ee0caf54e','fe6c559ca65c60bda19ad167de740975c8cc7d5c',1,'2014-05-26 14:06:27','2014-05-26 14:08:53','S','K5h3sMiv71',0),(2,'Andrea','Lebrun','1993-10-16','M','andrealebrun+newcover@gmail.com','cc5f5687fe43993c8dfced42b5a867d93e49c160','5bec854e6ee80b3ba7884de0cb850cb29ca7bf42',1,'2014-05-26 16:11:47','2014-05-26 16:12:56','S','XRULH9uEvl',0),(3,'Andrea','LebrÃºn','1999-09-10','M','andrealebrun+f@gmail.com','c3d8eb73d7fcaacf8d06bcc47f3a20f6a715e5b5','fb4652de407d6ba4f860874a2bb201cbff2d8f68',1,'2014-05-26 16:18:09','2014-05-26 16:18:55','S','TKsWBOkY3t',1),(4,'Andrea','Lebrun','1982-06-04','M','andrealebrun+c@gmail.com','13c9d7e2c2c03607be4966d806ef88d52fe8fd86','1e12494b0b78f2b5746ddacf2f697e97c0fbc480',2,'2014-05-26 16:22:11','2014-05-26 16:26:41','S','tzw5bM3z7j',1),(5,'Robert','Reimi','2008-05-02','H','robert.reimi+fotografo@gmail.com','c05eeb754c60f75474ce109d21cb61c9c9f94963','ab013a806718fc6367e453621575e075d3433752',1,'2014-05-26 17:59:21','2014-05-26 18:17:26','S','hCoLlLDwoF',1),(6,'Jose','Troconis','2005-02-03','M','josemtm87@gmail.com','0139734fd95d95a87e3f8d9913084b4dda415064','71872d40a602e073ea17b22794e49c2362e32c1f',1,'2014-05-26 18:06:11','2014-05-26 18:07:30','S','6wK3WuxSN2',1),(7,'Andrea','LebrÃºn','1995-08-14','M','andrealebrun+prueba@gmail.com','03df658369920aaf38a6840759a81a30c4da784c','3123739763d8a1bdadd9941e5d61ebe1bfe3bca4',1,'2014-05-26 18:14:47','2014-05-26 18:16:15','S','Vez9S6EXHr',0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_det`
--

DROP TABLE IF EXISTS `user_det`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_det` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_data` int(11) NOT NULL,
  `description` text COLLATE utf8_spanish_ci,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=141 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_det`
--

LOCK TABLES `user_det` WRITE;
/*!40000 ALTER TABLE `user_det` DISABLE KEYS */;
INSERT INTO `user_det` VALUES (1,1,1,NULL),(2,1,16,NULL),(3,1,2,'Prueba de descripciÃ³n'),(4,1,3,'aaaaaaaaaaaaaa'),(5,1,4,'cccccccccccccccc'),(6,1,5,'VE'),(7,1,6,'dddddddddddddddd'),(8,1,10,'bbbbbbbbbbbbbbbbb'),(9,1,7,'eeeeeeeeeeeeeeeee'),(10,1,11,'aaaaaaaaaaaa'),(11,1,12,'bbbbbbbbbbbbb'),(12,1,14,''),(13,1,18,'ssssssssssssssss'),(14,1,19,'aaaaaaaaaaaaa'),(15,1,20,'[{\"empresa\":\"Hola\",\"localidad\":\"aaa\"}]'),(16,1,22,'sssssssssssssss'),(17,1,21,'fffffffffffffffffff'),(18,1,23,'vvvvvvvvvvvv'),(19,1,13,'cccccccccccc'),(20,1,17,''),(21,1,15,'2'),(22,2,1,NULL),(23,2,16,NULL),(24,2,2,'aaaaaaaaaaaaaaaaaaaaaaaaaa'),(25,2,3,'bbbbbbbbbbbbbbbb'),(26,2,4,'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'),(27,2,5,'VE'),(28,2,6,'1111111111111111111111'),(29,2,10,'cccccccccccccccccccccc'),(30,2,7,'66666666666666666'),(31,2,11,'aaaaaaaaaaaaaaaaaaaaaa'),(32,2,12,'bbbbbbbbbbbbbbbbbbb'),(33,2,14,''),(34,2,18,'aaaaaaaaaaaaaaaaaaaaa'),(35,2,19,'aeeeeeeeeeeeeeeeee'),(36,2,20,'[]'),(37,2,22,'eeetttttttttttttttttttttt'),(38,2,21,'tthhhhhhhhhhhhhhhhhhhhhhhh'),(39,2,23,'aaaaaaaaaa'),(40,2,13,'fffffffffffffffffffff'),(41,2,17,''),(42,2,15,'2'),(43,3,1,NULL),(44,3,16,NULL),(45,3,2,'aaaaaaaaaaaaaaaaaaaaaaaaaaa'),(46,3,3,'aaaaaaaaaaaaaaaaaaaaaa'),(47,3,4,'ccccccccccccccccccccc'),(48,3,5,'VE'),(49,3,6,'aaaaaaaaaaaaaaaaaaa'),(50,3,10,'bbbbbbbbbbbbbbbbbb'),(51,3,7,'fffffffffffffffffff'),(52,3,11,'aaaaaaaaaaaaaaaaaaaaa'),(53,3,12,'aaaddddddddddddddddddd'),(54,3,14,''),(55,3,18,'aaaaaaaaaaaaaaaaa'),(56,3,19,'aaaaaaaaaaaaaaaa'),(57,3,20,'[{\"empresa\":\"aaaaaaaaa\",\"localidad\":\"abbbbbbb\"}]'),(58,3,22,'aaaaaaaaaaaaaaaaa'),(59,3,21,'aaaaaaaaaaaaaaaaa'),(60,3,23,''),(61,3,13,'fffffffffffffff'),(62,3,17,''),(63,3,15,'2'),(64,4,1,NULL),(65,4,16,NULL),(66,4,2,'aaaaaaaaaaaa'),(67,4,3,'aabbbbbbbbbbbbbb'),(68,4,4,'ddddddddddddd'),(69,4,5,'VE'),(70,4,6,'aaaaaaaaaaaa'),(71,4,10,'ccccccccccc'),(72,4,7,'aaaaaaaaaaaaaaaaaa'),(73,5,1,NULL),(74,5,16,NULL),(75,5,2,'Fotografo profesional'),(76,5,3,'South Richmond St'),(77,5,4,'12345'),(78,5,5,'IE'),(79,5,6,'12312311231'),(80,5,10,'Dublin'),(81,5,7,'12312312312'),(82,5,11,'Desechable'),(83,5,12,'De sol'),(84,5,14,''),(85,5,18,'La de la vida'),(86,5,19,''),(87,5,20,'[]'),(88,5,22,''),(89,5,21,''),(90,5,23,''),(91,5,13,'Chaqueta'),(92,5,17,''),(93,5,15,'2'),(94,5,15,'1'),(95,5,15,'19'),(96,5,15,'20'),(97,6,1,NULL),(98,6,16,NULL),(99,6,2,'Aqui esta la descripcion de mi perfil'),(100,6,3,'El Hatillo'),(101,6,4,'118827'),(102,6,5,'VE'),(103,6,6,'02124143805'),(104,6,10,'Caracas'),(105,6,7,'04167052560'),(106,6,11,'Canon'),(107,6,12,'1010736'),(108,6,14,''),(109,6,18,'La escuela'),(110,6,19,'Mucha educacion'),(111,6,20,'[{\"empresa\":\"Empresa 1\",\"localidad\":\"Localidad 1\"}]'),(112,6,22,'Muchos idiomas'),(113,6,21,'Muchas habilidad'),(114,6,23,'Aqui rut'),(115,6,13,'Mi equipo'),(116,6,17,''),(117,6,15,'2'),(118,6,15,'17'),(119,6,15,'19'),(120,7,1,NULL),(121,7,16,NULL),(122,7,2,'Holaaaaaaaaaaaaaaaaa'),(123,7,3,'aaaaaaaaaaa'),(124,7,4,'1111111111111111'),(125,7,5,'VE'),(126,7,6,'1111111111111111'),(127,7,10,'bbbbbbbbbbbbb'),(128,7,7,'1222222222'),(129,7,11,'Holaaaaaaaa'),(130,7,12,'bbbbbbbbbbb'),(131,7,14,''),(132,7,18,'aaaaaaaaaaaaaaaaaa'),(133,7,19,'eeeeeeeeeeeeee'),(134,7,20,'[{\"empresa\":\"aaaaaaaaaaaaaaaa\",\"localidad\":\"eeeeeeeeeee\"}]'),(135,7,22,'aaaaaaaaaaaaaa'),(136,7,21,'aaeeeeeeeeeeeeeeee'),(137,7,23,'aaaaaaaaaaaaaaa'),(138,7,13,'ccccccccccccccc'),(139,7,17,''),(140,7,15,'2');
/*!40000 ALTER TABLE `user_det` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `department` varchar(50) NOT NULL,
  `user` varchar(20) NOT NULL,
  `salt` text NOT NULL,
  `pass` text NOT NULL,
  `cdate` datetime NOT NULL,
  `udate` datetime NOT NULL,
  `act` varchar(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`id`),
  UNIQUE KEY `avu_email` (`email`),
  UNIQUE KEY `avu_user` (`user`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'Alexander','Briceno','sharkam@gmail.com','Master','rabriceno','087a9be230b945eb5f93dd2c1ab304504b3cf807','c4a530bcf08180e8020dff3e4e3be8ed0446dff8','2012-07-08 21:21:42','2014-01-11 11:19:19','S'),(6,'Paulo','Rodrigues','paulo@fototea.com','fototea','paulo','ddc2e30b8d06d3e51906bdda05df68f80ad968a6','847e4d6d054879f789ddeff23e8f482d7d72027f','2014-01-13 20:17:55','2014-01-13 20:17:55','S');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Final view structure for view `proyectos_view`
--

/*!50001 DROP TABLE IF EXISTS `proyectos_view`*/;
/*!50001 DROP VIEW IF EXISTS `proyectos_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`fototea`@`%` SQL SECURITY DEFINER */
/*!50001 VIEW `proyectos_view` AS select `p`.`pro_id` AS `pro_id`,`p`.`pro_cod` AS `pro_cod`,`p`.`pro_tit` AS `pro_tit`,`p`.`pro_descripcion` AS `pro_descripcion`,`p`.`pro_budget` AS `pro_budget`,`p`.`pro_date` AS `pro_date`,`p`.`pro_date_end` AS `pro_date_end`,`p`.`pro_cant` AS `pro_cant`,`p`.`pro_length` AS `pro_length`,`p`.`pro_country` AS `pro_country`,`p`.`pro_state` AS `pro_state`,`p`.`pro_city` AS `pro_city`,`p`.`pro_address` AS `pro_address`,`p`.`pro_cp` AS `pro_cp`,`p`.`pro_type` AS `pro_type`,`p`.`pro_category` AS `pro_category`,`p`.`user_id` AS `user_id`,`p`.`pro_status` AS `pro_status`,`p`.`pro_cdate` AS `pro_cdate`,count(`o`.`id`) AS `total_ofertas`,`oa`.`id` AS `oferta_adjudicada_id`,`oa`.`user_id` AS `oferta_user_id`,`oa`.`bid` AS `oferta_bid` from ((`proyectos` `p` left join `ofertas` `o` on((`o`.`pro_id` = `p`.`pro_id`))) left join `ofertas` `oa` on(((`oa`.`pro_id` = `p`.`pro_id`) and (`oa`.`awarded` = 'S')))) group by `p`.`pro_id` */;
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

-- Dump completed on 2014-05-26 21:20:19
