-- MySQL dump 10.13  Distrib 5.5.33, for Linux (x86_64)
--
-- Host: localhost    Database: fototea_fot
-- ------------------------------------------------------
-- Server version	5.5.33-31.1

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
  `a_user_id` int(11) NOT NULL,
  `a_type` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `a_status` varchar(1) COLLATE utf8_spanish_ci NOT NULL,
  `a_cdate` datetime NOT NULL,
  PRIMARY KEY (`a_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `albumes`
--

LOCK TABLES `albumes` WRITE;
/*!40000 ALTER TABLE `albumes` DISABLE KEYS */;
INSERT INTO `albumes` (`a_id`, `a_tit`, `a_user_id`, `a_type`, `a_status`, `a_cdate`) VALUES (10,'prueba 3',11,'F','N','2013-11-19 22:09:09'),(9,'prueba 3',11,'F','N','2013-11-19 22:09:08'),(8,'mi album',11,'F','S','2013-11-19 22:04:36'),(7,'prueba',11,'F','S','2013-11-19 21:05:20'),(11,'prueba',11,'F','N','2013-11-19 22:36:54'),(12,'Album Prueba',9,'F','S','2013-11-23 05:23:51'),(13,'Prueba #1',14,'F','S','2013-11-24 11:13:55'),(14,'Prueba #2',14,'F','S','2013-11-24 11:14:44'),(15,'Prueba',15,'F','S','2013-11-24 18:46:58'),(16,'Prueba #3',14,'F','N','2013-11-27 09:08:14'),(17,'Prueba #3',14,'F','N','2013-11-28 05:51:04'),(18,'Prueba #3',14,'F','N','2013-12-03 13:27:12'),(19,'prueba',11,'F','S','2013-12-05 08:55:34'),(20,'Prueba #3',14,'F','S','2013-12-05 17:24:52'),(21,'Prueba #4',14,'F','N','2013-12-05 17:27:25'),(22,'Prueba #4',14,'F','S','2013-12-05 17:41:49'),(23,'Fotos',14,'F','N','2013-12-11 04:56:09'),(24,'Album 4',14,'F','S','2014-01-14 10:28:17'),(25,'Prueba',14,'F','S','2014-03-22 08:25:46');
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
  PRIMARY KEY (`ad_id`)
) ENGINE=MyISAM AUTO_INCREMENT=102 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `albumes_det`
--

LOCK TABLES `albumes_det` WRITE;
/*!40000 ALTER TABLE `albumes_det` DISABLE KEYS */;
INSERT INTO `albumes_det` (`ad_id`, `ad_a_id`, `ad_url`, `ad_user_id`, `ad_description`, `ad_status`, `ad_cdate`) VALUES (7,7,'f20c285f824bfb4ae35ede89146b1186.jpg',11,'','S','2013-11-19 21:15:17'),(6,7,'e052abb0abdaeb812a7de57147fa445d.jpg',11,'prueba 2','S','2013-11-19 21:08:34'),(5,7,'328a4bd8e7cf2d8606dd9c40074be8dd.jpg',11,'prueba','S','2013-11-19 21:07:38'),(8,7,'09fadf44081706571e2ea50d112ac31f.jpg',11,'','S','2013-11-19 21:15:26'),(9,7,'8a2201d2a9bb16b26282923a13796d62.jpg',11,'','S','2013-11-19 21:15:37'),(10,7,'d37f0437dcc12ce759b58b830be1921a.jpg',11,'','S','2013-11-19 21:16:28'),(11,7,'451df3fb3d8fec2d1e7d5931b4297862.jpg',11,'','S','2013-11-19 21:17:26'),(12,7,'916fa725857d094eab356744f704b2ed.jpg',11,'','S','2013-11-19 21:19:38'),(13,8,'5be48dbe1deec73c91a4ae02540f4ca9.jpg',11,'prueba','S','2013-11-19 22:06:48'),(14,7,'06dc54f6591bbe87f41b0c70dfd1f6b7.jpg',11,'','S','2013-11-20 00:11:24'),(15,7,'64ddbeac3ba26f036af5aba4c98a8ab4.jpg',11,'Prueba de texto de descripcion','S','2013-11-20 00:33:45'),(16,12,'4d9c1aaa0dfc253365910f3069366923.jpg',9,'','S','2013-11-23 05:24:33'),(17,12,'f027a48ce8c52d3ba710271821dd704b.jpg',9,'','S','2013-11-23 05:24:44'),(18,13,'055d274916df8216833c14307d3d8a27.jpg',14,'','S','2013-11-24 11:14:10'),(19,13,'7b245a5e6787d7a8b40dfa07ff9f86bf.jpg',14,'','S','2013-11-24 11:14:20'),(20,13,'8dc3ac92b6ff81cf85cc0971a0241773.jpg',14,'','S','2013-11-24 11:14:28'),(21,14,'c36369c9fbbe30440fc37dd34a8b2fab.jpg',14,'','S','2013-11-24 11:14:55'),(22,14,'4768d23df3f22c2a610c7dfa9f086682.jpg',14,'','S','2013-11-24 11:15:03'),(23,15,'8273fa0efd246ae8ef80e09e049ec9ac.png',15,'Bucket','S','2013-11-24 18:48:32'),(24,8,'c01f69f949639a55c3816508adf99d57.png',11,'prueba de compresion','S','2013-11-29 18:09:56'),(25,8,'8549d71f2a66193aa63cab8d42c51c96.png',11,'','N','2013-11-29 18:27:55'),(26,13,'d6473130d4ecf97906e9d84902a97cef.jpg',14,'','S','2013-11-30 08:36:54'),(33,8,'cf2b5cd24552561b793268aee0e9b2c1.png',11,'2','S','2013-11-30 23:50:25'),(32,8,'36d0e50da6949d55a8b342c3c9b26a5c.png',11,'1','S','2013-11-30 23:50:25'),(34,8,'eb5cfcf803cf0046f1bcfb77d0ccdc94.jpg',11,'3','S','2013-11-30 23:51:27'),(35,8,'50566632dd2bc8dc797eeab9aa0f0dca.png',11,'4','S','2013-11-30 23:51:27'),(36,8,'983e03c2a4d54cef71202849a2d4a241.png',11,'5','N','2013-11-30 23:51:27'),(37,8,'364cad0e735bd4fddc2900956acf9a4b.jpg',11,'','N','2013-12-04 13:11:39'),(38,8,'3e6aa61d164fe0ed1f8c079756af74c4.jpg',11,'','N','2013-12-04 13:12:00'),(39,8,'eb45d0014d856d590e858ec8856086af.png',11,'aaaa','N','2013-12-04 13:18:31'),(40,8,'fbfc7022f92df88a5c925e776a04a4ba.png',11,'aaaa','N','2013-12-04 13:19:28'),(41,8,'dd4ab7644f06b04f0fa60e8239233054.png',11,'aaaa','N','2013-12-04 13:20:41'),(42,8,'eee6d1fd669d3877361df279abb9f384.png',11,'aaaa','N','2013-12-04 13:24:07'),(43,8,'47c18caa835c727ec9182e936736bff9.png',11,'aaaa','N','2013-12-04 13:25:01'),(44,8,'792a91707ad1884ad987c51824f245d2.png',11,'aaaa','N','2013-12-04 13:31:48'),(45,8,'d15e2d9fc380df6409a5f8bc5bb7836a.png',11,'aaaa','N','2013-12-04 13:33:05'),(46,8,'d7918a6e4c6bc31e46438b4045d6b02e.png',11,'aaaa','N','2013-12-04 13:45:35'),(47,8,'2cfcf0230876352be729a4beea3487c0.png',11,'aaaa','N','2013-12-04 13:47:52'),(48,8,'4826912fc5f2f275608417262cde7b75.png',11,' ','N','2013-12-04 13:57:52'),(49,8,'8bfff982fa508cf1d717ce3cc9bd17a4.png',11,' ','N','2013-12-04 13:57:52'),(50,8,'68af6f2283efbd650fdea46b8cce6197.jpg',11,' ','N','2013-12-04 19:24:15'),(51,8,'d699a580e1eee50dd5a5dcaa70bc87a9.png',11,' ','N','2013-12-04 19:24:15'),(52,8,'4b2100d6cd97e8b9116cee1ca425e732.png',11,' ','N','2013-12-04 20:47:09'),(53,8,'561de62829bc828ff43f3917764b2f8c.png',11,' ','N','2013-12-04 20:47:09'),(54,8,'273ea89133153c35f31184c7a8dce9af.png',11,' ','N','2013-12-04 20:47:09'),(55,8,'dd4ea3b0cba326dc2b3081718838d462.png',11,' ','N','2013-12-04 20:47:09'),(56,8,'ea026ac3adeed9c5dc48721714d5a343.png',11,' ','N','2013-12-04 20:47:09'),(57,8,'d387298bed308dfe02a2533872f18104.png',11,' ','N','2013-12-04 20:47:09'),(58,8,'f3539d4620552c09369cba68fa3b9eeb.png',11,' ','N','2013-12-04 20:48:27'),(59,8,'8f0e802544303a7be54fb2bbd178f485.ocx',11,' ','N','2013-12-04 20:53:05'),(60,8,'1feea7325a1bb0e8ecf5e414353f15b4.png',11,' ','N','2013-12-04 21:00:47'),(61,8,'dad0d40bfd0332b91c3f57548fd51d42.png',11,' ','N','2013-12-04 21:00:47'),(62,8,'ac8c2ec70fd2b5cc9223e8562f12b49e.png',11,' ','N','2013-12-04 21:01:19'),(63,8,'ecffb175e870751c56b3ba860b160c44.png',11,' ','N','2013-12-04 21:01:19'),(64,8,'c1405581671eb1ad4f238dbe43bb32db.png',11,' ','N','2013-12-04 21:23:32'),(65,8,'4fb0c3bd268e70a6d847f5ed2eba690f.png',11,' ','N','2013-12-04 21:23:32'),(66,20,'ec0b8257610e61177751a8e109688da9.jpg',14,' ','S','2013-12-05 17:25:38'),(67,20,'606b7191ee160fa40a25869265964214.jpg',14,' ','S','2013-12-05 17:25:38'),(68,20,'94e00ea3d209428e0d40f066b47fc828.jpg',14,' ','S','2013-12-05 17:25:38'),(69,20,'02dc8f78714d2659a4269c876402cde8.jpg',14,' ','S','2013-12-05 17:25:38'),(70,20,'a46d3c5f13a6b88990e63adfec253d73.jpg',14,' ','S','2013-12-05 17:25:38'),(71,20,'e5a44c46e76595d677c70d7aa5810aa9.jpg',14,' ','S','2013-12-05 17:25:38'),(72,20,'fbbd3a803a76e80252c304d95d0f50c2.jpg',14,' ','S','2013-12-05 17:25:38'),(73,20,'6a8c04e8ccf29c56f94bfcdee511579d.jpg',14,' ','S','2013-12-05 17:25:38'),(74,20,'8bbb4513f19c8b94e5d863d5ae2fd95c.jpg',14,' ','S','2013-12-05 17:25:38'),(75,20,'9160a710c38c6160339636b590c274cf.jpg',14,' ','S','2013-12-05 17:25:38'),(76,20,'7d3729adf34d8241aed18322836fab10.jpg',14,' ','S','2013-12-05 17:25:38'),(77,20,'fe1c202617fc9682fe8ce78cf8e57235.jpg',14,' ','S','2013-12-05 17:25:38'),(78,20,'dcba37d513728600070f91e8f0818979.jpg',14,' ','S','2013-12-05 17:26:26'),(79,20,'c68a38cb5bfa1942220abae31c274415.jpg',14,' ','S','2013-12-05 17:26:26'),(80,20,'c0e86636b596944c4bbda66233153810.jpg',14,' ','S','2013-12-05 17:26:26'),(81,20,'0547d992804cd46bfcc8d80d9e022631.jpg',14,' ','S','2013-12-05 17:26:26'),(82,20,'0951ad32c68042f220e7e918277f4ba9.jpg',14,' ','S','2013-12-05 17:26:26'),(83,20,'2a17c417358668b4c6cc2c5e5791a0eb.jpg',14,' ','S','2013-12-05 17:26:26'),(84,20,'2fb97275bf8827626cbeee9501c35d7b.jpg',14,' ','S','2013-12-05 17:26:26'),(85,20,'1c5a282883a4fd5bfac5f83404914a37.jpg',14,' ','S','2013-12-05 17:26:26'),(86,20,'8ca7cade8f26b6efcbdc25749127c585.jpg',14,' ','S','2013-12-05 17:26:26'),(87,20,'5d5317ccdfb4f4472c0977a77f3efa7b.jpg',14,' ','S','2013-12-05 17:26:26'),(88,22,'ef3f4e83e1be94e3ed4fb4b51609cac0.jpg',14,' ','S','2013-12-05 17:43:00'),(89,19,'f793a87765e112189bae818987930a14.png',11,' ','S','2013-12-05 18:02:31'),(90,24,'1c61e3e70e9293a8fdb756857ad382a2.jpg',14,' ','S','2014-01-14 10:28:47'),(91,24,'30cef1bc8376f9b15e27db28629393b4.jpg',14,' ','S','2014-01-14 10:28:47'),(92,24,'a4845d185fc343efd519b06451fd6b59.jpg',14,' ','S','2014-01-14 10:28:47'),(93,24,'645d472966c9d565e91154afed968f99.jpg',14,' ','S','2014-01-14 10:28:47'),(94,24,'b62fe17ce5e6b23b6bec2500bef8e869.jpg',14,' ','S','2014-01-14 10:28:47'),(95,24,'ab855d2817ca9367509abfb247c37a0c.jpg',14,' ','S','2014-01-14 10:28:47'),(96,24,'91e974a55616cb76320e6a9cfc0dd6d4.jpg',14,' ','S','2014-01-14 10:28:47'),(97,24,'ebeafafe6f89c9deaf96d90a2ca78285.jpg',14,' ','S','2014-01-14 10:28:47'),(98,24,'9367a50e2406a9eeac360a1705a0f0f1.jpg',14,' ','S','2014-01-14 10:28:47'),(99,24,'f91298c35cd6a4ed53a4837d8b8a6fe1.jpg',14,' ','S','2014-01-14 10:28:47'),(100,25,'524624e7069b626bbde9b668888c0fcb.jpg',14,' ','S','2014-03-22 08:27:18'),(101,25,'94b8193e38e03b6acae5b8ee29bc0719.jpg',14,' ','S','2014-03-22 08:27:18');
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
INSERT INTO `banners` (`id`, `titulo`, `texto`, `img`, `orden`) VALUES (2,'Encuentra tu prÃ³ximo fotÃ³grafo','Contrata fotÃ³grafos acorde a tu proyecto.  <br> Compara diferentes propuestas.  <br> Paga de manera segura y online.','57713a3492d9ba358c4954fb21e491c5.jpg',1),(3,'Edita tus fotos','Respalda tu capacidad creativa en la ediciÃ³n de fotografÃ­as con uno de nuestros <br>fotÃ³grafos o creativos asociados','6a11824872b3c76928bb000bf8259702.jpg',2),(4,'Crea fabulosos videos','Descubre fabulosos directores y productores audiovisuales que te ayudarÃ¡n en tu prÃ³xima filmaciÃ³n de video profesional.','4b45fbfed75021fdc7003b8fa39aa18b.jpg',3),(5,'Edita videos y animaciones','Tu filmas. Tu fotografÃ­as. Tu Fototeas.  Nuestros animadores y editores crean <br>tu video o animaciÃ³n a partir de tu contenido','0c859e20229a5265e086dd9a3a77dd53.jpg',4);
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `description`, `order`) VALUES (1,'Producci&oacute;n fotograf&iacute;as',1),(2,'Producci&oacute;n videos',2),(3,'Edici&oacute;n de video',3),(4,'Edici&oacute;n de fotograf&iacute;as',4);
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
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories_event`
--

LOCK TABLES `categories_event` WRITE;
/*!40000 ALTER TABLE `categories_event` DISABLE KEYS */;
INSERT INTO `categories_event` (`id`, `id_cat`, `description`) VALUES (1,1,'Bodas'),(2,1,'Comidas'),(3,1,'Modelaje'),(4,1,'Retratos'),(5,1,'Eventos (Conciertos, Fiestas, Corporativo, Reuniones)'),(6,1,'E-commerce'),(7,1,'Inmobiliario'),(8,1,'Negocios / Corporativo'),(9,2,'Negocio / Corporativo'),(10,2,'Publicidad'),(11,2,'Inmobiliario'),(12,2,'Corto animado'),(13,2,'Demo de producto'),(14,2,'Video musical'),(15,2,'Bodas'),(16,2,'Testimonial'),(17,2,'Evento en vivo'),(18,2,'Viajes / Turismo'),(19,2,'Kickstarter'),(20,2,'Apps / Juegos'),(21,4,'Edici&oacute;n ligera'),(22,4,'Edici&oacute;n Fuerte'),(23,3,'Negocio / Corporativo'),(24,3,'Publicidad'),(25,3,'Inmobiliario'),(26,3,'Corto animado'),(27,3,'Demo de producto'),(28,3,'Video musical'),(29,3,'Bodas'),(30,3,'Testimonial'),(31,3,'Evento en vivo'),(32,3,'Viajes / Turismo'),(33,3,'Kickstarter'),(34,3,'Apps / Juegos');
/*!40000 ALTER TABLE `categories_event` ENABLE KEYS */;
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
INSERT INTO `data` (`id`, `description`, `order`) VALUES (1,'user_img_perfil',NULL),(2,'user_bio_desc',NULL),(3,'user_direccion',NULL),(4,'user_cp',NULL),(5,'user_pais',NULL),(6,'user_tel',NULL),(7,'user_movil',NULL),(8,'user_fb',NULL),(9,'user_tw',NULL),(10,'user_city',NULL),(11,'user_camara',NULL),(12,'user_lentes',NULL),(13,'user_equipo',NULL),(14,'user_experiencia',NULL),(15,'user_cat_interes',NULL),(16,'user_cover',NULL),(17,'paypal_user',NULL);
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
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mensajes`
--

LOCK TABLES `mensajes` WRITE;
/*!40000 ALTER TABLE `mensajes` DISABLE KEYS */;
INSERT INTO `mensajes` (`m_id`, `m_to`, `m_cuser`, `m_subject`, `pro_id`, `m_cdate`, `m_status`) VALUES (2,11,8,'prueba',0,'2013-11-04 17:15:11','A'),(4,11,8,'prueba correo',0,'2013-11-04 18:53:53','A'),(5,11,8,'drgdrgdr',0,'2013-11-04 19:04:15','A'),(6,11,8,'prueba de fecha',0,'2013-11-05 18:03:20','A'),(7,11,8,'Prueba de creacion',0,'2013-11-06 17:03:31','A'),(19,8,11,'Proyecto: Produccion de fotografias en exterior',0,'2013-11-10 10:57:15','A'),(18,11,8,'vdfvsd',0,'2013-11-06 23:22:03','A'),(17,10,11,'Mensajes',0,'2013-11-06 23:19:40','A'),(20,8,11,'Proyecto: Produccion de fotografias en exterior',0,'2013-11-10 10:57:22','A'),(21,8,11,'Proyecto: Produccion de fotografias en exterior',5,'2013-11-10 11:11:17','A'),(22,14,14,'Hola',0,'2014-01-14 10:24:14','A'),(23,10,9,'Hola',0,'2014-01-14 10:26:44','A'),(24,14,10,'Proyecto: Prueba #2',12,'2014-01-21 08:33:05','A');
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
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mensajes_det`
--

LOCK TABLES `mensajes_det` WRITE;
/*!40000 ALTER TABLE `mensajes_det` DISABLE KEYS */;
INSERT INTO `mensajes_det` (`md_id`, `md_m_id`, `md_to`, `md_from`, `md_txt`, `md_cdate`) VALUES (1,7,11,8,'mensaje nuevo','2013-11-06 17:03:31'),(13,7,11,11,'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.<br/>;<br/>;Aenean commodo ligula eget dolor. Aenean massa.<br/>;<br/>;Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.<br/>;<br/>;Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec. ','2013-11-06 22:28:50'),(11,7,8,11,'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.<br/><br/>Aenean commodo ligula eget dolor. Aenean massa.<br/><br/>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.<br/><br/>Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec. ','2013-11-06 21:18:43'),(12,7,8,11,'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.&lt;br/&gt;&lt;br/&gt;Aenean commodo ligula eget dolor. Aenean massa.&lt;br/&gt;&lt;br/&gt;Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.&lt;br/&gt;&lt;br/&gt;Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec. ','2013-11-06 21:20:02'),(14,7,11,11,'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.<br/><br/>Aenean commodo ligula eget dolor. Aenean massa.<br/><br/>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.<br/><br/>Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec. ','2013-11-06 22:29:17'),(15,7,11,11,'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.<br/><br/>Aenean commodo ligula eget dolor. Aenean massa.<br/><br/>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.<br/><br/>Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec. ','2013-11-06 22:33:41'),(16,7,11,11,'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.<br/><br/>Aenean commodo ligula eget dolor. Aenean massa.<br/><br/>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.<br/><br/>Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec. ','2013-11-06 22:34:10'),(17,7,11,11,'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.<br/><br/>Aenean commodo ligula eget dolor. Aenean massa.<br/><br/>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.<br/><br/>Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec. ','2013-11-06 22:35:48'),(18,7,8,11,'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.<br/><br/>Aenean commodo ligula eget dolor. Aenean massa.<br/><br/>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.<br/><br/>Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec. ','2013-11-06 22:39:56'),(19,7,11,8,'respuesta<br/><br/>de mensaje','2013-11-06 22:41:02'),(20,7,8,11,'','2013-11-06 22:53:00'),(21,7,8,11,'prueba de recarga<br/><br/>y borrar textarea','2013-11-06 22:55:55'),(22,17,10,11,'Que mas chamo, ya estan listos los mensajes privados.<br/><br/>Pruebalos y cualquier cosa me avisas.','2013-11-06 23:19:40'),(23,18,11,8,'sdvsdvsdv','2013-11-06 23:22:03'),(24,18,11,8,'sdvsvsv<br/><br/>svsdv<br/>sv<br/>sv<br/>sdv','2013-11-06 23:22:16'),(25,17,11,10,'Prueba','2013-11-08 04:07:52'),(26,19,8,11,'trrthrth<br/>rthrth<br/>hrthr<br/>thrt','2013-11-10 10:57:15'),(27,20,8,11,'rhrhrh<br/>rth<br/>rth<br/>rth<br/>rth','2013-11-10 10:57:22'),(28,21,8,11,'prueba de vinculacion de proyecto','2013-11-10 11:11:17'),(29,22,14,14,'Hola','2014-01-14 10:24:14'),(30,23,10,9,'Hola (a)','2014-01-14 10:26:44'),(31,23,9,10,'Hola (a) a ti','2014-01-14 10:27:23'),(32,24,14,10,'Bajale el precio!!!!!','2014-01-21 08:33:05');
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
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mensajes_status`
--

LOCK TABLES `mensajes_status` WRITE;
/*!40000 ALTER TABLE `mensajes_status` DISABLE KEYS */;
INSERT INTO `mensajes_status` (`ms_id`, `ms_m_id`, `ms_user_id`, `ms_status`) VALUES (1,2,11,'B'),(2,2,8,'B'),(3,4,11,'B'),(4,4,8,'B'),(5,5,11,'B'),(6,5,8,'B'),(7,6,11,'B'),(8,6,8,'B'),(9,7,8,'L'),(10,7,11,'L'),(44,24,14,'L'),(43,24,10,'L'),(42,23,10,'L'),(41,23,9,'N'),(40,22,14,'L'),(39,22,14,'L'),(38,21,8,'B'),(37,21,11,'L'),(36,20,8,'B'),(35,20,11,'L'),(34,19,8,'L'),(33,19,11,'L'),(32,18,11,'L'),(31,18,8,'L'),(30,17,10,'L'),(29,17,11,'L');
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
INSERT INTO `modules` (`id`, `description`, `url`, `order`, `icon`) VALUES (1,'Inicio','dashboard',1,'dashboard'),(2,'Pagos realizados','#',5,'calendar'),(3,'SEO','#',3,'tag'),(11,'Administracion del sistema','#',11,'tool'),(5,'Usuarios registrados','#',4,'users'),(6,'Pagina Principal','#',2,'buttons');
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
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notificaciones`
--

LOCK TABLES `notificaciones` WRITE;
/*!40000 ALTER TABLE `notificaciones` DISABLE KEYS */;
INSERT INTO `notificaciones` (`id`, `user_id`, `notificacion`, `url`, `cdate`, `leido`) VALUES (1,11,'Has recibido un mensaje de Roger Briceno','proyecto?id=15','2014-02-10 10:51:29','N'),(2,8,'Has recibido un mensaje de sharkam mahal','proyecto?id=15','2014-02-10 10:53:44','S'),(8,11,'Tu oferta ha sido aceptada!','proyecto?id=15','2014-02-10 11:29:30','N'),(7,8,'El usuario Roger Briceno ha modificado su oferta en uno de tus proyectos','proyecto?id=15','2014-02-10 11:25:37','S'),(6,8,'El usuario Roger Briceno ha modificado su oferta en uno de tus proyectos','proyecto?id=15','2014-02-10 11:23:27','S'),(9,8,'Has sido calificado por el proyectoProyecto de fotografias','perfil?us=51Lr0y3snl&act=reviews','2014-02-10 11:38:57','N'),(10,14,'Has recibido un mensaje de Fototea Fotografo','proyecto?id=16','2014-02-13 19:00:07','S'),(11,14,'Has recibido un mensaje de Fototea Fotografo','proyecto?id=16','2014-02-13 22:23:10','S'),(12,13,'Has recibido una oferta en el proyecto Compromiso ','proyecto?id=20','2014-03-13 12:10:45','S'),(13,14,'Has recibido un mensaje de Fototea Fotografo','proyecto?id=20','2014-03-13 12:47:23','S'),(14,13,'Has recibido un mensaje de Fototea Cliente','proyecto?id=20','2014-03-13 12:48:14','N'),(15,13,'Has recibido una oferta en el proyecto Video para Startup Chile ','proyecto?id=19','2014-03-16 18:39:55','N'),(16,13,'Has recibido un mensaje de Fototea Cliente','proyecto?id=19','2014-03-16 18:40:25','N'),(17,13,'Has recibido un mensaje de Fototea Cliente','proyecto?id=19','2014-03-16 18:40:53','N');
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
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oferta_comments`
--

LOCK TABLES `oferta_comments` WRITE;
/*!40000 ALTER TABLE `oferta_comments` DISABLE KEYS */;
INSERT INTO `oferta_comments` (`id`, `oferta_id`, `user_id`, `comment`, `cdate`) VALUES (1,20,11,'Escribe tu comentario aqui!ftfgnfthft','2014-01-30 19:03:09'),(2,20,11,'comentario de prueba','2014-01-30 19:04:26'),(3,20,11,'Escribe tu comentario aqui! dfgbfbfgbdbd','2014-01-30 19:11:58'),(4,20,11,'sefewfwef','2014-01-30 19:16:03'),(5,20,11,'Mensaje de prueba','2014-01-31 09:19:16'),(6,20,11,'Escribe tu comentari','2014-01-31 09:20:48'),(7,20,11,'Escribe tu comentario','2014-01-31 09:22:59'),(8,20,11,'Escribe tu comentario','2014-01-31 09:24:03'),(9,20,11,'Escribe tu comentario','2014-01-31 09:28:45'),(10,20,11,'Escribe tu comentariodwedwedwe','2014-01-31 09:31:22'),(11,20,11,'prueba prueba','2014-01-31 09:32:25'),(12,20,11,'Escribe tu comentario a','2014-01-31 09:33:08'),(13,20,11,'Escribe tu ','2014-01-31 09:41:17'),(14,20,11,'ultima prueba!','2014-01-31 09:43:17'),(15,20,11,'ultima ultima prueba','2014-01-31 09:46:45'),(16,20,11,'ultima 3 prueba','2014-01-31 09:48:19'),(17,20,11,'comentario notificacion','2014-01-31 13:12:37'),(18,20,11,'notificacion','2014-01-31 14:05:41'),(19,20,11,'text','2014-01-31 14:33:35'),(20,20,11,'text','2014-01-31 14:39:11'),(21,20,11,'text','2014-01-31 14:40:45'),(22,20,11,'text','2014-01-31 14:40:54'),(23,20,11,'text','2014-01-31 14:41:30'),(24,20,11,'text','2014-01-31 14:42:41'),(25,20,11,'text','2014-01-31 14:43:42'),(26,20,11,'text','2014-01-31 14:44:26'),(27,20,11,'text','2014-01-31 14:45:59'),(28,20,8,'prueba de comentario de cliente','2014-01-31 14:49:07'),(29,20,11,'final test','2014-01-31 14:56:28'),(30,20,11,'test','2014-01-31 14:59:34'),(31,20,11,'hgucuc','2014-01-31 15:03:34'),(32,20,11,'text','2014-01-31 15:05:29'),(33,20,11,'jhgv ufrcutrc','2014-01-31 15:21:45'),(34,20,8,'edweferfer','2014-01-31 15:27:04'),(35,21,13,'Hola, el precio es demasiado caro','2014-02-04 09:13:56'),(36,21,13,'De nuevo, el precio es demasiado caro','2014-02-04 09:17:00'),(37,21,13,'Bajale el precio chamo!\n','2014-02-05 09:25:23'),(38,21,14,'Ok, ya lo intento bajar un poco','2014-02-05 10:39:46'),(39,20,8,'Prueba de notificaciones','2014-02-10 10:51:29'),(40,20,11,'orueba not client','2014-02-10 10:53:44'),(41,21,13,'Chamo,bajale un toque ahi','2014-02-13 19:00:07'),(42,21,13,'BAjale el precio\n','2014-02-13 22:23:10'),(43,22,13,'Hola! Â¿CÃ³mo estas?','2014-03-13 12:47:23'),(44,22,14,'Bien, y vos?','2014-03-13 12:48:14'),(45,23,14,'Prueba de mensaje','2014-03-16 18:40:25'),(46,23,14,'Mensaje 2','2014-03-16 18:40:53');
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
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ofertas`
--

LOCK TABLES `ofertas` WRITE;
/*!40000 ALTER TABLE `ofertas` DISABLE KEYS */;
INSERT INTO `ofertas` (`id`, `pro_id`, `user_id`, `bid`, `mensaje`, `awarded`, `cdate`) VALUES (1,1,11,1500,'Propuesta de proyecto, para probar que todo funciona bien.','N','2013-10-13 13:56:30'),(2,1,11,1000,'propuesta de pruba para envio de notificacion por email','N','2013-10-15 21:02:31'),(3,1,11,1000,'propuesta de pruba para envio de notificacion por email','N','2013-10-15 21:06:30'),(4,1,11,2000,'Propuesta para proyecto y validar los estilos del correo','N','2013-10-15 21:09:44'),(5,1,11,2000,'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate.','N','2013-10-15 21:12:32'),(6,4,9,200,'Prueba','N','2013-10-16 05:57:54'),(12,5,11,1401,'lingues differe solmen in li grammatica, li pronunciation e li plu commun vocabules. Omnicos directe al desirabilite de un nov lingua franca: On refusa continuar payar custosi traductores. At solme','S','2013-10-25 18:51:14'),(13,3,9,200,'','N','2013-11-08 04:13:46'),(14,3,12,1,'','N','2013-11-08 04:32:35'),(15,10,14,500,'','S','2013-11-17 07:13:08'),(16,10,9,300,'','N','2013-11-17 07:15:47'),(17,9,14,500,'Cambio de dinero','N','2013-11-25 04:52:12'),(18,12,14,200,'Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta Mi propuesta ','N','2014-01-14 09:48:46'),(19,12,9,250,'Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 Mi propuesta #1 ','N','2014-01-14 09:49:46'),(20,15,11,1300,'Propuestaa','S','2014-01-27 11:00:43'),(21,16,14,300,'Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta Esta es mi propuesta ','N','2014-02-04 09:11:48'),(22,20,14,300,'Haria el Proyecto de esta y otra forma, llevaria tales y tales cosas, etc. ','N','2014-03-13 12:10:45'),(23,19,14,100,'Yo soy','N','2014-03-16 18:39:55');
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
INSERT INTO `paises` (`id`, `iso`, `nombre`) VALUES (1,'AF','Afganistán'),(2,'AX','Islas Gland'),(3,'AL','Albania'),(4,'DE','Alemania'),(5,'AD','Andorra'),(6,'AO','Angola'),(7,'AI','Anguilla'),(8,'AQ','Antártida'),(9,'AG','Antigua y Barbuda'),(10,'AN','Antillas Holandesas'),(11,'SA','Arabia Saudí'),(12,'DZ','Argelia'),(13,'AR','Argentina'),(14,'AM','Armenia'),(15,'AW','Aruba'),(16,'AU','Australia'),(17,'AT','Austria'),(18,'AZ','Azerbaiyán'),(19,'BS','Bahamas'),(20,'BH','Bahréin'),(21,'BD','Bangladesh'),(22,'BB','Barbados'),(23,'BY','Bielorrusia'),(24,'BE','Bélgica'),(25,'BZ','Belice'),(26,'BJ','Benin'),(27,'BM','Bermudas'),(28,'BT','Bhután'),(29,'BO','Bolivia'),(30,'BA','Bosnia y Herzegovina'),(31,'BW','Botsuana'),(32,'BV','Isla Bouvet'),(33,'BR','Brasil'),(34,'BN','Brunéi'),(35,'BG','Bulgaria'),(36,'BF','Burkina Faso'),(37,'BI','Burundi'),(38,'CV','Cabo Verde'),(39,'KY','Islas Caimán'),(40,'KH','Camboya'),(41,'CM','Camerún'),(42,'CA','Canadá'),(43,'CF','República Centroafricana'),(44,'TD','Chad'),(45,'CZ','República Checa'),(46,'CL','Chile'),(47,'CN','China'),(48,'CY','Chipre'),(49,'CX','Isla de Navidad'),(50,'VA','Ciudad del Vaticano'),(51,'CC','Islas Cocos'),(52,'CO','Colombia'),(53,'KM','Comoras'),(54,'CD','República Democrática del Congo'),(55,'CG','Congo'),(56,'CK','Islas Cook'),(57,'KP','Corea del Norte'),(58,'KR','Corea del Sur'),(59,'CI','Costa de Marfil'),(60,'CR','Costa Rica'),(61,'HR','Croacia'),(62,'CU','Cuba'),(63,'DK','Dinamarca'),(64,'DM','Dominica'),(65,'DO','República Dominicana'),(66,'EC','Ecuador'),(67,'EG','Egipto'),(68,'SV','El Salvador'),(69,'AE','Emiratos Árabes Unidos'),(70,'ER','Eritrea'),(71,'SK','Eslovaquia'),(72,'SI','Eslovenia'),(73,'ES','España'),(74,'UM','Islas ultramarinas de Estados Unidos'),(75,'US','Estados Unidos'),(76,'EE','Estonia'),(77,'ET','Etiopía'),(78,'FO','Islas Feroe'),(79,'PH','Filipinas'),(80,'FI','Finlandia'),(81,'FJ','Fiyi'),(82,'FR','Francia'),(83,'GA','Gabón'),(84,'GM','Gambia'),(85,'GE','Georgia'),(86,'GS','Islas Georgias del Sur y Sandwich del Sur'),(87,'GH','Ghana'),(88,'GI','Gibraltar'),(89,'GD','Granada'),(90,'GR','Grecia'),(91,'GL','Groenlandia'),(92,'GP','Guadalupe'),(93,'GU','Guam'),(94,'GT','Guatemala'),(95,'GF','Guayana Francesa'),(96,'GN','Guinea'),(97,'GQ','Guinea Ecuatorial'),(98,'GW','Guinea-Bissau'),(99,'GY','Guyana'),(100,'HT','Haití'),(101,'HM','Islas Heard y McDonald'),(102,'HN','Honduras'),(103,'HK','Hong Kong'),(104,'HU','Hungría'),(105,'IN','India'),(106,'ID','Indonesia'),(107,'IR','Irán'),(108,'IQ','Iraq'),(109,'IE','Irlanda'),(110,'IS','Islandia'),(111,'IL','Israel'),(112,'IT','Italia'),(113,'JM','Jamaica'),(114,'JP','Japón'),(115,'JO','Jordania'),(116,'KZ','Kazajstán'),(117,'KE','Kenia'),(118,'KG','Kirguistán'),(119,'KI','Kiribati'),(120,'KW','Kuwait'),(121,'LA','Laos'),(122,'LS','Lesotho'),(123,'LV','Letonia'),(124,'LB','Líbano'),(125,'LR','Liberia'),(126,'LY','Libia'),(127,'LI','Liechtenstein'),(128,'LT','Lituania'),(129,'LU','Luxemburgo'),(130,'MO','Macao'),(131,'MK','ARY Macedonia'),(132,'MG','Madagascar'),(133,'MY','Malasia'),(134,'MW','Malawi'),(135,'MV','Maldivas'),(136,'ML','Malí'),(137,'MT','Malta'),(138,'FK','Islas Malvinas'),(139,'MP','Islas Marianas del Norte'),(140,'MA','Marruecos'),(141,'MH','Islas Marshall'),(142,'MQ','Martinica'),(143,'MU','Mauricio'),(144,'MR','Mauritania'),(145,'YT','Mayotte'),(146,'MX','México'),(147,'FM','Micronesia'),(148,'MD','Moldavia'),(149,'MC','Mónaco'),(150,'MN','Mongolia'),(151,'MS','Montserrat'),(152,'MZ','Mozambique'),(153,'MM','Myanmar'),(154,'NA','Namibia'),(155,'NR','Nauru'),(156,'NP','Nepal'),(157,'NI','Nicaragua'),(158,'NE','Níger'),(159,'NG','Nigeria'),(160,'NU','Niue'),(161,'NF','Isla Norfolk'),(162,'NO','Noruega'),(163,'NC','Nueva Caledonia'),(164,'NZ','Nueva Zelanda'),(165,'OM','Omán'),(166,'NL','Países Bajos'),(167,'PK','Pakistán'),(168,'PW','Palau'),(169,'PS','Palestina'),(170,'PA','Panamá'),(171,'PG','Papúa Nueva Guinea'),(172,'PY','Paraguay'),(173,'PE','Perú'),(174,'PN','Islas Pitcairn'),(175,'PF','Polinesia Francesa'),(176,'PL','Polonia'),(177,'PT','Portugal'),(178,'PR','Puerto Rico'),(179,'QA','Qatar'),(180,'GB','Reino Unido'),(181,'RE','Reunión'),(182,'RW','Ruanda'),(183,'RO','Rumania'),(184,'RU','Rusia'),(185,'EH','Sahara Occidental'),(186,'SB','Islas Salomón'),(187,'WS','Samoa'),(188,'AS','Samoa Americana'),(189,'KN','San Cristóbal y Nevis'),(190,'SM','San Marino'),(191,'PM','San Pedro y Miquelón'),(192,'VC','San Vicente y las Granadinas'),(193,'SH','Santa Helena'),(194,'LC','Santa Lucía'),(195,'ST','Santo Tomé y Príncipe'),(196,'SN','Senegal'),(197,'CS','Serbia y Montenegro'),(198,'SC','Seychelles'),(199,'SL','Sierra Leona'),(200,'SG','Singapur'),(201,'SY','Siria'),(202,'SO','Somalia'),(203,'LK','Sri Lanka'),(204,'SZ','Suazilandia'),(205,'ZA','Sudáfrica'),(206,'SD','Sudán'),(207,'SE','Suecia'),(208,'CH','Suiza'),(209,'SR','Surinam'),(210,'SJ','Svalbard y Jan Mayen'),(211,'TH','Tailandia'),(212,'TW','Taiwán'),(213,'TZ','Tanzania'),(214,'TJ','Tayikistán'),(215,'IO','Territorio Británico del Océano Índico'),(216,'TF','Territorios Australes Franceses'),(217,'TL','Timor Oriental'),(218,'TG','Togo'),(219,'TK','Tokelau'),(220,'TO','Tonga'),(221,'TT','Trinidad y Tobago'),(222,'TN','Túnez'),(223,'TC','Islas Turcas y Caicos'),(224,'TM','Turkmenistán'),(225,'TR','Turquía'),(226,'TV','Tuvalu'),(227,'UA','Ucrania'),(228,'UG','Uganda'),(229,'UY','Uruguay'),(230,'UZ','Uzbekistán'),(231,'VU','Vanuatu'),(232,'VE','Venezuela'),(233,'VN','Vietnam'),(234,'VG','Islas Vírgenes Británicas'),(235,'VI','Islas Vírgenes de los Estados Unidos'),(236,'WF','Wallis y Futuna'),(237,'YE','Yemen'),(238,'DJ','Yibuti'),(239,'ZM','Zambia'),(240,'ZW','Zimbabue');
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
INSERT INTO `prelaunch_email` (`id`, `email`, `interest`, `cdate`) VALUES (7,'mrocha86@gmail.com','Fotografo','2013-07-29 07:30:38'),(27,'rabricenog@gmail.com','Fotografo','2013-07-31 18:07:28'),(9,'Nayaridpr87@gmail.com','Fotografo','2013-07-29 08:12:32'),(10,'paulo.goncalves@iese.net','Fotografo','2013-07-29 09:01:12'),(11,'funkychop0530@gmail.com','Fotografo','2013-07-29 09:16:00'),(12,'Blanca.fernandez@iese.net','Fotografo','2013-07-29 09:53:29'),(13,'luca@bidaway.com','Fotografo','2013-07-29 10:11:53'),(14,'hmirabalz@gmail.com','Fotografo','2013-07-29 11:35:57'),(15,'marron.daniel@gmail.com','Fotografo','2013-07-29 13:40:31'),(16,'gonzaloaguilera@klick.com.ve','Fotografo','2013-07-29 14:34:02'),(17,'silrojas92@gmail.com','Fotografo','2013-07-29 15:28:12'),(18,'paulogoncalvesr@gmail.com','Fotografo','2013-07-29 17:34:32'),(19,'odreman.reinaldo@gmail.com','Fotografo','2013-07-30 00:18:23'),(20,'alittasobi@gmail.com','Fotografo','2013-07-30 02:01:13'),(21,'morales.oscar.d@gmail.com','Fotografo','2013-07-30 13:51:44'),(22,'contacto@3dlproducciones.com','Fotografo','2013-07-30 15:35:04'),(23,'siolly@hotmail.com','Fotografo','2013-07-30 21:02:23'),(24,'Luisabarbosah000@gmail.com','Fotografo','2013-07-30 22:39:41'),(25,'carolinasanchezcuellar@gmail.com','Fotografo','2013-07-30 22:43:28'),(26,'danielanarciso@gmail.com','Fotografo','2013-07-31 16:39:57'),(28,'utopiagraphics@gmail.com','Fotografo','2013-07-31 19:23:01'),(29,'Paulo@fototea.com','Fotografo','2013-08-01 02:28:33'),(30,'luis@thergbcorp.com','Fotografo','2013-08-01 07:08:35'),(31,'luispernia2000@gmail.com','Fotografo','2013-08-01 07:59:08'),(32,'josmaira@gmail.com','Fotografo','2013-08-01 10:00:41'),(33,'serranoja@gmail.com','Fotografo','2013-08-01 23:06:54'),(34,'rectorindependiente@gmail.com','Fotografo','2013-08-01 23:36:00'),(35,'av.guzmano@gmail.com','Fotografo','2013-08-05 11:41:24'),(36,'Rafaelmedinacastillo@hotmail.com','Fotografo','2013-08-05 15:31:59'),(37,'max.marascia@gmail.com','Fotografo','2013-08-07 09:33:44'),(38,'oho0013@gmail.com','Fotografo','2013-08-08 12:06:22'),(39,'beny032@gmail.com','Fotografo','2013-08-08 12:51:37'),(40,'vanessa-rangel@hotmail.com','Fotografo','2013-08-10 15:33:59'),(41,'grant@quotanda.com','Fotografo','2013-08-10 17:21:28'),(42,'matias@canelson.com.ar','Fotografo','2013-08-13 21:14:37'),(52,'info@pieralexandregagne.com','Fotografo','2013-08-16 19:23:41'),(53,'christian.olivares@gmail.com','Cliente','2013-08-19 15:31:07'),(54,'gastonaportal@gmail.com','Fotografo','2013-08-19 21:01:32'),(55,'','','2013-08-21 11:45:36'),(56,'mariana@ungranrecuerdo.com','Cliente','2013-08-21 14:20:30'),(57,'isakintan@gmail.com','Cliente','2013-08-21 15:29:18'),(58,'mezocarlos@gmail.com','Cliente','2013-08-26 05:13:10'),(59,'bookdemodelosvzla@gmail.com','Cliente','2013-08-28 17:26:38'),(60,'veraluciahernandez@yahoo.com','Cliente','2013-08-28 17:46:44'),(61,'ruperbass@Gmail.com','Cliente','2013-08-29 16:04:26'),(62,'ramalberich@hotmail.com','Cliente','2013-09-05 11:27:29'),(63,'aleman@cantv.net','Cliente','2013-09-05 14:53:03'),(64,'hsequeraphoto@gmail.com','Fotografo','2013-09-05 16:16:41'),(65,'cristinasalvadormoll@gmail.com','Fotografo','2013-09-06 04:22:34'),(66,'david.arroyo.calahorro@hotmail.com','Cliente','2013-09-06 04:34:28'),(67,'julietacrame@gmail.com','Cliente','2013-09-08 07:50:03'),(68,'ypaiva@gmail.com','Cliente','2013-09-09 17:28:24'),(69,'sr.emeele@gmail.com','Cliente','2013-09-11 04:09:16'),(70,'estefania.quinteroque@gmail.com','Cliente','2013-09-25 13:20:47'),(71,'magabi.lopez@gmail.com','Cliente','2013-09-30 08:16:05'),(72,'buonanno.fulvia@gmail.com','Cliente','2013-10-01 06:26:21'),(73,'tanit.roig@gmail.com','Fotografo','2013-10-01 14:09:44'),(74,'abelmolina23@gmail.com','Cliente','2013-10-01 14:48:51'),(75,'mafe217@hotmail.com','Cliente','2013-10-03 11:42:56'),(76,'ernest@sizephoto.com','Cliente','2013-10-11 02:15:25'),(77,'noebarceb@gmail.com','Cliente','2013-10-13 18:14:04'),(78,'adri.penalva@gmail.com','Cliente','2013-10-15 12:47:15'),(79,'manu.rr.garcia@gmail.com','Cliente','2013-10-16 13:08:48'),(80,'hosastre@gmail.com','Cliente','2013-10-17 05:56:16'),(81,'candina@gmail.com','Cliente','2013-10-22 09:32:00'),(82,'gsfswf@gmail.com','Fotografo','2013-10-23 12:36:11'),(83,'ffvdfg@gmail.com','Cliente','2013-10-23 12:37:09'),(84,'photoaroma@gmail.com','Cliente','2013-10-28 17:36:24'),(85,'martapujades@gmail.com','Cliente','2013-10-30 17:08:41'),(86,'luiscalderoncorripio@hotmail.com','Fotografo','2013-11-04 14:22:09'),(87,'cnistal@gmail.com','Cliente','2013-11-04 15:06:21'),(88,'ghill.sky@gmail.com','Cliente','2013-11-06 06:47:06'),(89,'palbord@gmail.com','Cliente','2013-11-07 15:13:34'),(90,'asurbistondo@gmail.com','Cliente','2013-11-07 15:49:01'),(91,'allanbruno89@gmail.com','Fotografo','2013-11-11 17:29:36'),(92,'info@photolounge.es','Cliente','2013-11-11 18:37:50'),(93,'leopatino@gmail.com','Cliente','2013-11-11 18:43:45'),(94,'karen.2maturano@gmail.com','Fotografo','2013-11-12 07:43:14'),(95,'claudiobertinetti@gmail.com','Cliente','2013-11-12 08:36:51'),(96,'munne.nuria@gmail.com','Cliente','2013-11-12 09:28:15'),(97,'inigosierra@gmail.com','Cliente','2013-11-14 05:43:34'),(98,'Diana.drago@gmail.com','Cliente','2013-11-17 17:20:28'),(99,'Niccolo.Cappon@iese.net','Fotografo','2013-11-17 22:13:21'),(100,'nico.ongaro@yahoo.it','Cliente','2013-11-18 08:22:23'),(101,'rohemo11@gmail.com','Cliente','2013-11-19 02:55:24'),(102,'lucaaimi1@gmail.com','Cliente','2013-11-19 09:51:22'),(103,'albertoalonsophoto@gmail.com','Fotografo','2013-11-21 12:38:41'),(104,'foto@marccastellet.cat','Cliente','2013-11-26 11:31:48'),(105,'lalibellobi@gmail.com','Cliente','2013-11-26 14:44:56'),(106,'antonioserranocorbacho@gmail.com','Cliente','2013-11-26 18:25:31'),(107,'Dngaya@gmai.com','Cliente','2013-11-27 08:21:57'),(108,'escriu@cecymota.com','Cliente','2013-11-27 09:05:18'),(109,'afer_15@hotmail.com','Cliente','2013-11-27 11:24:49'),(110,'info@roberastorgano.com','Cliente','2013-11-27 11:49:22'),(111,'javierollerfoto@gmail.com','Cliente','2013-11-27 12:35:14'),(112,'paula.n.clavero@gmail.com','Cliente','2013-11-27 14:22:22'),(113,'joandeulofeugomez@gmail.com','Cliente','2013-11-27 16:20:24'),(114,'dancingthedreams@gmail.com','Cliente','2013-11-27 18:28:00'),(115,'vagaworld@gmail.com','Cliente','2013-11-28 04:16:14'),(116,'stefvara@gmail.com','Cliente','2013-11-28 05:11:43'),(117,'balerio_one@hotmail.com','Cliente','2013-11-28 07:21:11'),(118,'ffernandez1999@hotmail.com','Cliente','2013-11-28 07:33:12'),(119,'marta.quismondo@gmail.com','Cliente','2013-11-28 08:00:23'),(120,'vdo.fotografia@gmail.com','Cliente','2013-11-28 08:05:17'),(121,'gonzalez_gonzi_1990@hotmail.com','Cliente','2013-11-28 08:53:13'),(122,'irialorenzo@gmail.com','Cliente','2013-11-28 09:44:16'),(123,'cesanto81@hotmail.com','Cliente','2013-11-28 14:34:25'),(124,'mafiroig@gmail.com','Cliente','2013-11-29 06:53:13'),(125,'chepina@gmail.com','Cliente','2013-11-30 06:09:00'),(126,'alfredo_ovalles@hotmail.com','Fotografo','2013-11-30 06:34:24'),(127,'alegarciasanchez@hotmail.com','Cliente','2013-11-30 07:04:36'),(128,'anahinovillo@hotmail.com','Cliente','2013-11-30 07:20:28'),(129,'julietagiuliano@gmail.com','Cliente','2013-11-30 09:29:59'),(130,'vnucete87@gmail.com','Cliente','2013-11-30 10:28:57'),(131,'fotonc2@gmail.com','Cliente','2013-11-30 11:52:34'),(132,'c@carlossilva.es','Cliente','2013-12-01 05:40:17'),(133,'irenemoray@gmail.com','Cliente','2013-12-01 13:17:27'),(134,'joselefotos@hotmail.com','Cliente','2013-12-02 06:50:57'),(135,'fsilla@yahoo.com','Cliente','2013-12-02 08:55:03'),(136,'jpadillacliment@gmail.com','Cliente','2013-12-02 13:05:00'),(137,'lucasrafael.uece@gmail.com','Fotografo','2013-12-02 19:44:36'),(138,'fotograma64@gmail.com','Cliente','2013-12-05 03:40:11'),(139,'lacaaimi1@gmail.com','Cliente','2013-12-05 16:42:39'),(140,'wedding photographer','Fotografo','2013-12-09 12:44:05'),(141,'pjoglar@gmail.com','Cliente','2013-12-09 12:45:34'),(142,'nacho.giralt.domingo@gmail.com','Cliente','2013-12-09 12:58:32'),(143,'a@gmail.com','Fotografo','2013-12-09 23:25:35'),(144,'hloboss@gmail.com','Fotografo','2013-12-10 06:43:44'),(145,'neva22@yahoo.com','Cliente','2013-12-10 10:45:55'),(146,'yvesdimantphoto@gmail.com','Cliente','2013-12-10 12:10:15'),(147,'eduardo@stgo2night.cl','Cliente','2013-12-12 20:40:56'),(148,'agusvialr@gmail.com','Fotografo','2013-12-12 20:41:49'),(149,'valentinamirandavega@gmail.com','Cliente','2013-12-12 20:53:45'),(150,'guishe_017@hotmail.com','Cliente','2013-12-12 20:56:29'),(151,'riding_thebullet@yahoo.es','Cliente','2013-12-12 21:00:30'),(152,'instantaneas','Cliente','2013-12-12 21:48:14'),(153,'valrodfotografias@gmail.com','Cliente','2013-12-12 21:49:30'),(154,'eduardomoya.produccion@gmail.com','Fotografo','2013-12-12 22:13:18'),(155,'rsalinaso@gmail.com','Fotografo','2013-12-13 00:27:57'),(156,'fotografia60@gmail.com','Cliente','2013-12-13 07:32:21'),(157,'nerwelfotografia@gmail.com','Cliente','2013-12-16 13:27:32'),(158,'lunamartinsanchez@hotmail.es','Cliente','2013-12-18 03:28:52'),(159,'jsalvadorvision@gmail.com','Cliente','2013-12-19 04:09:20'),(160,'yovester@hotmail.com','Cliente','2013-12-19 16:13:27'),(161,'contacto@vitofilms.cl','Cliente','2013-12-19 16:21:00'),(162,'japavees@hotmail.com','Cliente','2013-12-19 17:30:52'),(163,'fotografo.sergioh@gmail.com','Cliente','2013-12-19 17:39:22'),(164,'zeluloide@gmail.com','Cliente','2013-12-19 18:16:08'),(165,'ahahad@hotmail.com','Cliente','2013-12-19 18:19:59'),(166,'linxgrafic@gmail.com','Cliente','2013-12-19 18:36:20'),(167,'alvaroarosgarrido@gmail.com','Cliente','2013-12-19 18:56:55'),(168,'bernardita.hernandezf@gmail.com','Cliente','2013-12-19 19:19:50'),(169,'jeapc@hotmail.com','Cliente','2013-12-19 19:22:52'),(170,'trickaster@gmail.com','Cliente','2013-12-19 20:02:22'),(171,'hvallejosa@gmail.com','Cliente','2013-12-19 20:45:57'),(172,'difusofoto@gmail.com','Cliente','2013-12-19 21:16:19'),(173,'mmedina.cl@gmail.com','Cliente','2013-12-20 15:20:41'),(174,'martinmartua@gmail.com','Cliente','2013-12-20 15:23:44'),(175,'patagon-@hotmail.es','Fotografo','2013-12-20 15:24:18'),(176,'ediodgers@gmail.com','Cliente','2013-12-20 15:26:35'),(177,'reygadas@fotosrey.com','Cliente','2013-12-20 15:29:00'),(178,'cartermontecinos@gmail.com','Cliente','2013-12-20 15:29:03'),(179,'jhonorbeat.music@gmail.com','Cliente','2013-12-20 15:29:47'),(180,'sero.ae@gmail.com','Cliente','2013-12-20 15:34:17'),(181,'micheledison@gmail.com','Cliente','2013-12-20 15:34:31'),(182,'claklocl@gmail.com','Cliente','2013-12-20 15:36:56'),(183,'candia.audiovisual@gmail.com','Cliente','2013-12-20 15:37:04'),(184,'paolavalencia.fotografias@gmail.com','Cliente','2013-12-20 15:38:57'),(185,'felipe.soza.soza@gmail.com','Fotografo','2013-12-20 15:39:20'),(186,'daniel@fotosur.cl','Cliente','2013-12-20 15:44:42'),(187,'novios@imagen26.com','Cliente','2013-12-20 15:53:28'),(188,'renedelacruzcl@gmail.com','Cliente','2013-12-20 15:53:49'),(189,'vanessamoralesmeza@gmail.com','Cliente','2013-12-20 15:56:05'),(190,'rodrigo_8113@hotmail.com','Cliente','2013-12-20 15:59:14'),(191,'tnoches84@hotmail.com','Cliente','2013-12-20 16:11:10'),(192,'izam_rc@hotmail.com','Cliente','2013-12-20 16:14:37'),(193,'izamrc23@gmail.com','Cliente','2013-12-20 16:15:55'),(194,'juanmanuel@payurshots.com','Cliente','2013-12-20 16:16:53'),(195,'daniel@danieljove.com','Cliente','2013-12-20 16:20:23'),(196,'creativework@hotmail.es','Cliente','2013-12-20 17:30:55'),(197,'idvsdproducciones@gmail.com','Cliente','2013-12-20 17:45:54'),(198,'rgt69_2@hotmail.com','Cliente','2013-12-20 18:29:39'),(199,'juanjoserivera.stratos@gmail.com','Cliente','2013-12-20 18:30:45'),(200,'quirozwato@hotmail.com','Fotografo','2013-12-20 18:39:31'),(201,'robinson.marchant@gmail.com','Cliente','2013-12-20 18:40:44'),(202,'haroldohorta@gmail.com','Cliente','2013-12-20 18:49:00'),(203,'l.valencia.colque@gmail.com','Fotografo','2013-12-20 18:54:09'),(204,'zolodos@hotmail.com','Cliente','2013-12-20 18:59:03'),(205,'ktu.martinezh@gmail.com','Cliente','2013-12-20 19:01:43'),(206,'petobar@gmail.com','Fotografo','2013-12-20 19:15:44'),(207,'gabrielapenelafotografia@gmail.com','Cliente','2013-12-20 19:32:15'),(208,'sbmarting@gmail.com','Cliente','2013-12-20 19:41:22'),(209,'loretotapia.fotografia@gmail.com','Cliente','2013-12-20 19:41:44'),(210,'humangroupvideo@gmail.com','Cliente','2013-12-20 19:43:51'),(211,'kubeda@gmail.com','Cliente','2013-12-20 19:46:52'),(212,'chino_mestizo@hotmail.com','Fotografo','2013-12-20 19:55:09'),(213,'imagen.digital@telsur.cl','Fotografo','2013-12-20 19:56:06'),(214,'estudiosclaveluz@yahoo.com','Cliente','2013-12-20 19:58:01'),(215,'vkunov@yahoo.com','Cliente','2013-12-20 20:05:06'),(216,'fotonovio@hotmail.com','Cliente','2013-12-20 20:06:33'),(217,'capturartecl@gmail.com','Cliente','2013-12-20 20:12:38'),(218,'francisca.ibanez.providell@gmail.com','Cliente','2013-12-20 20:18:58'),(219,'vkunov63@gmail.com','Cliente','2013-12-20 20:29:23'),(220,'alicia_h_z@yahoo.com','Cliente','2013-12-20 20:36:04'),(221,'m.olavarria.i@gmail.com','Cliente','2013-12-20 20:46:07'),(222,'pato.vegancore@gmail.com','Cliente','2013-12-20 20:47:37'),(223,'cata_ro213@hotmail.com','Cliente','2013-12-20 20:53:58'),(224,'ale.cinf@gmail.com','Fotografo','2013-12-20 20:55:36'),(225,'marioalejandro.urbina@msn.com','Cliente','2013-12-20 21:00:46'),(226,'asalaz20@gmail.com','Cliente','2013-12-20 21:22:32'),(227,'benjacoca@gmail.com','Cliente','2013-12-20 21:27:54'),(228,'felipemuoz6@gmail.com','Fotografo','2013-12-20 21:39:15'),(229,'luis1464@gmail.com','Cliente','2013-12-20 21:54:25'),(230,'trujillogalaz@gmail.com','Cliente','2013-12-20 22:42:00'),(231,'esteban.cerda.godoy@gmail.com','Cliente','2013-12-20 22:43:04'),(232,'fco.alvarado.j@gmail.com','Cliente','2013-12-20 22:44:46'),(233,'rarojas12@alumnos.utalca.cl','Cliente','2013-12-20 22:51:05'),(234,'gutarembe@gmail.com','Cliente','2013-12-20 23:03:37'),(235,'nachodote@gmail.com','Cliente','2013-12-21 06:37:51'),(236,'jorgevargasparra@gmail.com','Cliente','2013-12-22 07:32:42'),(237,'foto.carrasco@gmail.com','Cliente','2013-12-23 08:02:39'),(238,'carlosemarciales@gmail.com','Cliente','2013-12-24 11:32:06'),(239,'marcelosolisfotos@gmail.com','Cliente','2013-12-24 14:06:42'),(240,'multimediosargentina@yahoo.com.ar','Cliente','2013-12-24 14:11:01'),(241,'vicky@haizelan.com','Cliente','2013-12-26 05:06:59'),(242,'marioscottibomb@hotmail.com','Cliente','2013-12-26 14:54:17'),(243,'viddasum@gmail.com','Cliente','2014-01-05 03:30:23'),(244,'bettina@camaloon.com','Fotografo','2014-01-06 16:33:37'),(245,'arare94@hotmail.com','Cliente','2014-01-08 08:09:05'),(246,'ignasi.fotografia@gmail.com','Cliente','2014-01-09 12:48:48'),(247,'Ariadna_89@msn.com','Cliente','2014-01-18 02:34:23'),(248,'javierporterovela@hotmail.com','Cliente','2014-01-19 14:10:42'),(249,'mimita@gmail.com','Cliente','2014-01-21 05:41:59'),(250,'matador0000@hotmail.com','Fotografo','2014-01-23 16:07:24'),(251,'rrjeanpablo@gmail.com','Fotografo','2014-01-23 18:00:34'),(252,'sulladrellum@yahoo.es','Fotografo','2014-01-24 05:29:58'),(253,'gerard.moret@gmail.com','Cliente','2014-01-28 09:49:05'),(254,'sheigm92@gmail.com','Cliente','2014-02-01 09:16:17'),(255,'jmprfoto@gmail.com','Cliente','2014-02-06 01:17:28'),(256,'txema.photo.works@gmail.com','Cliente','2014-02-10 07:35:09'),(257,'kilian_vadnov@hotmail.com','Cliente','2014-02-11 02:41:19'),(258,'muntsabee@gmail.com','Cliente','2014-02-11 03:10:28'),(259,'maletaglia@gmail.com','Cliente','2014-02-14 09:16:50'),(260,'karinaetcheverry@hotmail.com','Cliente','2014-02-14 09:18:05'),(261,'andreamadia@hotmail.com','Cliente','2014-02-14 16:25:37'),(262,'marianamtron@hotmail.com','Cliente','2014-02-18 13:46:46'),(263,'jordiadell32@gmail.com','Cliente','2014-02-20 08:50:29'),(264,'chorozqui.aldo@gmail.com','Cliente','2014-03-07 05:26:02'),(265,'liesl.hros@gmail.com','Fotografo','2014-03-09 16:42:01'),(266,'philip@philip.me','Fotografo','2014-03-13 18:36:19'),(267,'info@giovannibettinello.com','Cliente','2014-03-17 12:36:48'),(268,'cos.style@hotmail.com','Cliente','2014-03-19 12:16:53'),(269,'se2v2@hotmail.com','Cliente','2014-03-19 15:45:17');
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
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pro_transactions`
--

LOCK TABLES `pro_transactions` WRITE;
/*!40000 ALTER TABLE `pro_transactions` DISABLE KEYS */;
INSERT INTO `pro_transactions` (`t_id`, `t_pro_id`, `t_oferta_id`, `t_status`, `t_cdate`, `t_pdate`, `t_trans_id`, `t_monto`, `usuario_pago`) VALUES (4,10,15,'L','2013-11-26 06:13:42','2013-11-28 05:49:28','2147483647',0,''),(3,5,12,'P','2013-10-25 21:09:15','2013-12-07 23:45:37','69G50967JM924112A',1540,'personal@fototea.com'),(5,15,20,'P','2014-02-10 11:29:30','0000-00-00 00:00:00',' ',0,' ');
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyecto_fin`
--

LOCK TABLES `proyecto_fin` WRITE;
/*!40000 ALTER TABLE `proyecto_fin` DISABLE KEYS */;
INSERT INTO `proyecto_fin` (`pf_id`, `pf_pro_id`, `pf_user_id`, `pf_status`, `pf_date`) VALUES (1,10,13,'S','2013-11-26 06:17:37'),(2,10,14,'S','2013-11-28 05:49:28'),(3,15,11,'S','2014-02-10 11:38:57');
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
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyectos`
--

LOCK TABLES `proyectos` WRITE;
/*!40000 ALTER TABLE `proyectos` DISABLE KEYS */;
INSERT INTO `proyectos` (`pro_id`, `pro_cod`, `pro_tit`, `pro_descripcion`, `pro_budget`, `pro_date`, `pro_date_end`, `pro_cant`, `pro_length`, `pro_country`, `pro_state`, `pro_city`, `pro_address`, `pro_cp`, `pro_type`, `pro_category`, `user_id`, `pro_status`, `pro_cdate`) VALUES (1,'131006110127','proyecto de prueba','Descripcion de prueba de proyecto',2000,'2013-11-10 00:00:00','2013-10-20 11:01:27',1,'','ES','Madrid','Madrid','Gran via 10',28012,1,6,8,'C','2013-10-06 11:01:27'),(2,'131007143645','Titulo 1','Titulo 1',500,'2013-12-18 00:00:00','2013-10-21 14:36:45',3,'','ES','Barcelona','Barcelona','Carrer de grande gracia 134',8012,1,2,10,'F','2013-10-07 14:36:45'),(3,'131007144023','Titulo 2','Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 Titulo 2 ',400,'2014-10-19 00:00:00','2013-11-23 04:12:22',45,'','ES','Barcelona','Caracas','Carrer de Grande Gracia 134',8029,1,3,10,'F','2013-10-07 14:40:23'),(4,'131012135207','Proyecto Prueba','Sacar Fotos',1000,'2013-01-18 00:00:00','2013-10-26 13:52:07',10,'','EH','Madeira','Madeira','Madeira',12345,1,8,10,'F','2013-10-12 13:52:07'),(5,'131021223225','Produccion de fotografias en exterior','Li Europan lingues es membres del sam familie. Lor separat existentie es un myth. Por scientie, musica, sport etc, litot Europa usa li sam vocabular. Li lingues differe solmen in li grammatica, li pronunciation e li plu commun vocabules. Omnicos directe al desirabilite de un nov lingua franca: On refusa continuar payar custosi traductores. At solme',1500.76,'2013-12-01 00:00:00','2013-10-25 21:26:19',4,'','ES','Madrid','Madrid','Madrid',28012,1,3,8,'AD','2013-10-21 22:32:25'),(6,'131104093857','Prueba 1','Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba ',300,'2013-11-29 00:00:00','2013-11-19 09:38:57',5,'','ES','Barcelona','Barcelona','Carrer de Grande Gracia 134',8020,1,1,10,'F','2013-11-04 09:38:57'),(7,'131104094112','Prueba 2','Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba ',600,'2013-11-19 00:00:00','2013-11-19 09:41:12',5,'','ES','Barcelona','Barcelona','Carrer de Grande Gracia 134',8019,2,11,10,'F','2013-11-04 09:41:12'),(8,'131104094247','Prueba 3','Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba Prueba ',300,'2014-02-22 00:00:00','2013-11-19 09:42:47',8,'','ES','Barcelona','Barcelona','Carrer de Grande Gracia 134',8020,1,3,10,'F','2013-11-04 09:42:47'),(9,'131117062223','Prueba #1','Descripcion del proyecto Descripcion del proyecto Descripcion del proyecto Descripcion del proyecto Descripcion del proyecto Descripcion del proyecto Descripcion del proyecto Descripcion del proyecto Descripcion del proyecto Descripcion del proyecto Descripcion del proyecto Descripcion del proyecto Descripcion del proyecto Descripcion del proyecto Descripcion del proyecto ',100,'2013-12-10 00:00:00','2013-12-02 06:22:23',300,'','ES','Barcelona','BArcelona','Carrer de Grande Gracia 134 3-1',8020,1,2,13,'F','2013-11-17 06:22:23'),(10,'131117062823','Prueba #2','DescripciÃ³n del proyecto DescripciÃ³n del proyecto DescripciÃ³n del proyecto DescripciÃ³n del proyecto DescripciÃ³n del proyecto DescripciÃ³n del proyecto DescripciÃ³n del proyecto DescripciÃ³n del proyecto DescripciÃ³n del proyecto DescripciÃ³n del proyecto DescripciÃ³n del proyecto DescripciÃ³n del proyecto DescripciÃ³n del proyecto DescripciÃ³n del proyecto DescripciÃ³n del proyecto DescripciÃ³n del proyecto DescripciÃ³n del proyecto DescripciÃ³n del proyecto DescripciÃ³n del proyecto DescripciÃ³n del proyecto DescripciÃ³n del proyecto ',100,'2013-11-29 00:00:00','2013-11-28 05:49:28',5,'','ES','BArcelona','BArcelona','Carrer de Grande Gracia 134',8020,2,11,13,'F','2013-11-17 06:28:23'),(11,'140106104808','Prueba #1','Prueba de descripciÃ³n del proyecto Prueba de descripciÃ³n del proyecto Prueba de descripciÃ³n del proyecto Prueba de descripciÃ³n del proyecto Prueba de descripciÃ³n del proyecto Prueba de descripciÃ³n del proyecto Prueba de descripciÃ³n del proyecto Prueba de descripciÃ³n del proyecto Prueba de descripciÃ³n del proyecto Prueba de descripciÃ³n del proyecto Prueba de descripciÃ³n del proyecto Prueba de descripciÃ³n del proyecto Prueba de descripciÃ³n del proyecto Prueba de descripciÃ³n del proyecto Prueba de descripciÃ³n del proyecto Prueba de descripciÃ³n del proyecto Prueba de descripciÃ³n del proyecto Prueba de descripciÃ³n del proyecto ',0,'2014-01-31 00:00:00','2014-01-21 10:48:08',500,'','VE','Distrito Capital','Caracas','Calle el Gamelotal',1080,1,6,13,'F','2014-01-06 10:48:08'),(12,'140106105557','Prueba #2','DescripciÃ³n del proyecto de prueba DescripciÃ³n del proyecto de prueba DescripciÃ³n del proyecto de prueba DescripciÃ³n del proyecto de prueba DescripciÃ³n del proyecto de prueba DescripciÃ³n del proyecto de prueba DescripciÃ³n del proyecto de prueba DescripciÃ³n del proyecto de prueba DescripciÃ³n del proyecto de prueba DescripciÃ³n del proyecto de prueba DescripciÃ³n del proyecto de prueba DescripciÃ³n del proyecto de prueba DescripciÃ³n del proyecto de prueba DescripciÃ³n del proyecto de prueba ',0,'2014-03-19 00:00:00','2014-01-21 10:55:57',100,'','VE','Distrito Capital','Caracas','Calle el Gamelotal',1080,1,8,10,'F','2014-01-06 10:55:57'),(13,'140106172544','titulo de proyecto','descripcion del proyecto de prueba',0,'2014-01-13 00:00:00','2014-01-21 17:25:44',2,'','ES','madrid','madrid','madrid',1080,1,1,8,'B','2014-01-06 17:25:44'),(14,'140106172628','proyecto de prueba','proyecto de prueba',0,'2014-01-18 00:00:00','2014-01-21 22:10:00',1,'10 minutos','ES','madrid','madrid','madrid',1080,2,20,8,'B','2014-01-06 17:26:28'),(15,'140127110010','Proyecto de fotografias','Proyecto piloto',0,'2014-02-09 00:00:00','2014-02-10 11:29:30',10,'DuraciÃ³n del video','ES','Madrid','Madrid','Madrid',28024,1,6,8,'AD','2014-01-27 11:00:10'),(16,'140204084954','FotografÃ­as de Prueba #1','DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto ',0,'2014-05-21 00:00:00','2014-02-19 08:49:54',250,'DuraciÃ³n del video','VE','Distrito Capital','Caracas','Calle el Gamelotal ',1020,1,6,13,'F','2014-02-04 08:49:54'),(17,'140204085333','Produccion de Video preba # 1','DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto DescripciÃ³n del Proyecto ',0,'2015-04-04 00:00:00','2014-02-19 08:53:33',1,'2','VE','Distrito Capital','Caracas','Calle el Gamelotal',1020,2,12,13,'F','2014-02-04 08:53:33'),(18,'140313090533','ProducciÃ³n E-Commerce','Necesito fotografÃ­as para 55 carteras que serÃ¡n publicadas en mi web, gestionada por shopify. \r<br/>\r<br/>',0,'2014-03-13 00:00:00','2014-03-28 09:05:33',165,'DuraciÃ³n del video','CL','Providencia','Santiago de chile','Providencia 229',8880088,1,6,13,'A','2014-03-13 09:05:33'),(19,'140313092807','Video para Startup Chile','Somos una startup que esta aplicando a Startup Chile y necesitamos un video de nosotros para completar la aplicaciÃ³n',0,'2014-03-22 00:00:00','2014-03-28 09:28:07',1,'3 minutos','CL','Providencia','Santiago de Chile','Providencia',9889990,2,19,13,'A','2014-03-13 09:28:07'),(20,'140313093139','Compromiso','Me estarÃ© comprometiendo en el parque bicentenario de Vitacura y quisiera que nos sacasen fotografÃ­as mientras ello sucede!',0,'2014-04-13 00:00:00','2014-03-28 09:31:39',20,'DuraciÃ³n del video','CL','Las condes','Santiago de Chile','Av Bicentenario',787887778,1,1,13,'A','2014-03-13 09:31:39');
/*!40000 ALTER TABLE `proyectos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prueba`
--

DROP TABLE IF EXISTS `prueba`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prueba` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prueba`
--

LOCK TABLES `prueba` WRITE;
/*!40000 ALTER TABLE `prueba` DISABLE KEYS */;
/*!40000 ALTER TABLE `prueba` ENABLE KEYS */;
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
INSERT INTO `review_types` (`rt_id`, `rt_desc`, `rt_abv`) VALUES (1,'finish','F'),(2,'Calificacion','C'),(3,'comment','CO'),(4,'Calidad','CA'),(5,'trato','T'),(6,'puntualidad','P'),(7,'Responsabilidad','R'),(8,'Profesionalismo','PR');
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
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` (`r_id`, `r_pro_id`, `r_user_id`, `r_user_eval`, `r_type`, `r_value`, `r_cdate`) VALUES (1,10,14,13,'CO','Excelente!','2013-11-26 06:17:37'),(2,10,14,13,'F','S','2013-11-26 06:17:37'),(3,10,14,13,'CA','2','2013-11-26 06:17:37'),(4,10,14,13,'T','1','2013-11-26 06:17:37'),(5,10,14,13,'P','4','2013-11-26 06:17:37'),(6,10,14,13,'R','3','2013-11-26 06:17:37'),(7,10,14,13,'PR','5','2013-11-26 06:17:37'),(8,10,13,14,'CO','Buen Cliente','2013-11-28 05:49:28'),(9,10,13,14,'F','S','2013-11-28 05:49:28'),(10,10,13,14,'C','4','2013-11-28 05:49:28'),(11,15,8,11,'CO','Todo excelente!!','2014-02-10 11:38:57'),(12,15,8,11,'F','S','2014-02-10 11:38:57'),(13,15,8,11,'C','4','2014-02-10 11:38:57');
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
INSERT INTO `security` (`id`, `users_id`, `modules_id`) VALUES (347,6,10),(346,6,14),(345,6,1),(344,2,13),(343,2,18),(342,2,11),(341,2,10),(340,2,14),(339,2,1),(348,6,11),(349,6,18),(350,6,13);
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
INSERT INTO `submodules` (`id`, `description`, `modules_id`, `url`, `order`) VALUES (1,'Usuarios del Sistema',11,'administracion-sistema',9),(14,'Banner principal',6,'banner',1),(13,'Usuarios',5,'usuarios',1),(10,'Listado',2,'pagos',1),(11,'Listado',3,'seo',1),(18,'Email Prelaunch',5,'prelaunch',2);
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `user` (`user`),
  UNIQUE KEY `act_code` (`act_code`)
) ENGINE=MyISAM AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `name`, `lastname`, `dob`, `gender`, `user`, `password`, `salt`, `user_type`, `cdate`, `last_login`, `act`, `act_code`) VALUES (8,'sharkam','mahal','1985-09-06','H','sharkam@gmail.com','33f235fad7da27505aaefa1ac9d355937eb97f29','884abba663f5e424bec36e4343d419ce256ee774',2,'2013-09-15 10:09:00','2014-03-14 20:08:41','S','51Lr0y3snl'),(9,'Paulo','Goncalves','1985-06-29','H','paulo@fototea.com','afa4862b2d45ea6f5d049c110753daaca9154614','b254add61069bb5778e1949937989cd8c83a989f',1,'2013-09-15 18:35:40','2014-01-21 08:32:19','S','v9CoDHbi31'),(10,'David','Rodrigues','1992-06-29','H','paulogoncalvesr@gmail.com','d3c034520cbbbf907654619eaafed3e90727f66c','19ec0eb10ff3a0dea5f33a67bdb75bf6be2d42ee',2,'2013-09-16 06:19:07','2014-01-21 08:34:33','S','NHLa3UKwoA'),(11,'Roger','Briceno','1985-09-06','H','rabricenog@gmail.com','a0efc46a0ec6578945da6598f6c71e7bfcd712d5','adec3ace54ac14fb9e17ade537f4615ebbaf48c6',1,'2013-10-07 18:59:50','2014-03-14 20:38:30','S','5SSHv1QYFx'),(12,'Miguel','Rocha','1986-01-09','H','miguel@fototea.com','a6081e575d8a517aeba40d88e017b5308b52bd09','70c9a9d5b09b88cc27a9f62c9c61098db869f023',1,'2013-11-08 04:18:11','2013-11-08 04:28:38','S','p2z47npQmZ'),(13,'Fototea','Cliente','1993-02-19','H','fototeacliente@gmail.com','c108ef07c6fa2a266d4c2f7876fe3ea15515c431','1ad7603e003713178f2b6ef9133b4d8954725d49',2,'2013-11-17 05:58:20','2014-03-22 08:30:15','S','OlQvvBn85d'),(14,'Fototea','Fotografo','1985-08-08','H','fototeafotografo@gmail.com','5eef8a4e19bcccd1ddcc9e55db4a9ce4373289b3','e751f444c0abe5c667f5cb3cae07df4442014c9d',1,'2013-11-17 06:45:16','2014-03-22 09:02:55','S','4vQ0lGslqR'),(15,'Alexander','Briceno','1985-09-06','H','alexander_sharkam@hotmail.com','ae2efe1703d563e9a60b757ce45f728fede61ae2','e48b966abb5810eacab9b66ffca823226c7b84d3',1,'2013-11-23 09:35:40','2013-11-23 09:41:03','S','xnFoVroWav'),(32,'Julio','Castillo','1994-05-03','M','juliocc@gmail.com','e3d9873badf78de571b5b54ee4e951a123427ac3','4202dc5ed3967df33519fe2c89b0ee382a140d8b',2,'2014-03-12 15:06:38','0000-00-00 00:00:00','S','ynqhYx1W9s'),(31,'Paulo','Rodrigues','1985-06-29','H','paulo_bajasaeusb@yahoo.com','ae2d62d82128d637ff3d9081734c15c4fb261f3c','3606c7c99619da3d48f1044107ca4ad290b2c186',1,'2013-12-22 10:07:19','0000-00-00 00:00:00','N','83JFoWincq'),(33,'Alexander','Briceno','1985-09-06','H','rabriceno@superwebpeople.com','0d3a6b6f6e64732570b92c09bf2acf8ff54e7f51','0c4a5a584d6bf26406e1ef81ad6a3d81ea377956',1,'2014-03-15 08:41:18','0000-00-00 00:00:00','S','0ss9CScT3V'),(34,'roger','briceno','2004-03-02','H','rabriceno@superwebpeo2ple.com','fb7c2f19e5858f34c41c3b0615fed3b502cdce59','891089eed7710267023adbb43c6e6df660fbea7e',1,'2014-03-15 08:57:12','0000-00-00 00:00:00','N','GEI0UZERBS');
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
  `description` text COLLATE utf8_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=138 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_det`
--

LOCK TABLES `user_det` WRITE;
/*!40000 ALTER TABLE `user_det` DISABLE KEYS */;
INSERT INTO `user_det` (`id`, `id_user`, `id_data`, `description`) VALUES (1,9,1,'2b29caab83ab54d48b44ad603ad1cc73.jpg'),(2,9,2,'Â¡PregÃºntame lo que necesites de Fototea!'),(3,9,3,'Carrer de Grande Gracia 134. 3-1'),(4,9,4,'08011'),(5,9,5,'ES'),(6,9,6,'0034671710611'),(7,9,10,'Barcelona'),(25,8,1,'f7700e3f0a9298825a6408606eb55aa9.png'),(9,8,2,'Muy lejos, mÃ¡s allÃ¡ de las montaÃ±as de palabras, alejados de los paÃ­ses de las vocales y las consonantes, viven los textos.'),(10,8,3,'Calle islas Cies'),(11,8,4,'28924'),(12,8,5,'ES'),(13,8,6,'678254940'),(14,8,10,'Madrid'),(16,8,7,'678254940'),(17,9,7,'Telefono Movil'),(18,9,13,'TrÃ­pode Manfrotto'),(19,9,15,'2'),(20,9,15,'6'),(21,9,15,'11'),(22,9,15,'21'),(24,8,16,'5b7d8b54fce4f1374a3cac09c095fba1.jpg'),(26,10,1,'669be27055d8e1fc6ff64c3455b67e33.jpg'),(27,10,2,'Hola!'),(28,10,3,'Carrer de Grande Gracia 134'),(29,10,4,'08012'),(30,10,5,'ES'),(31,10,6,'0034671710611'),(32,10,10,'Barcelona'),(33,10,7,'0034671710611'),(34,10,1,'669be27055d8e1fc6ff64c3455b67e33.jpg'),(35,8,1,'f7700e3f0a9298825a6408606eb55aa9.png'),(36,8,1,'f7700e3f0a9298825a6408606eb55aa9.png'),(37,8,1,'f7700e3f0a9298825a6408606eb55aa9.png'),(38,8,1,'f7700e3f0a9298825a6408606eb55aa9.png'),(48,11,3,'calle islas cies'),(47,11,2,'Perfil de fotografo de Roger Briceno'),(46,11,1,'fd2092f337ca814d69943c2c9691cd6e.png'),(49,11,4,'28924'),(50,11,5,'ES'),(51,11,6,'678254940'),(52,11,10,'Madrid'),(53,11,11,'Nikkon'),(54,11,12,'grand angular'),(55,11,14,'2'),(56,11,13,'tripode'),(135,11,15,'15'),(134,11,15,'20'),(133,11,15,'6'),(132,11,15,'2'),(61,12,1,'57b4c224f8fbc91ddc3f6fbb7d7eb3ad.jpg'),(62,12,16,'7c1ccafcdd98690e4fb31e33037bf9e0.jpg'),(63,12,2,'Miguel Rocha'),(64,12,3,'Corsega 77 1-3'),(65,12,4,'08029'),(66,12,5,'ES'),(67,12,6,'34693602611'),(68,12,10,'Barcelona'),(69,12,7,'34693602611'),(70,12,11,'Nikon D90'),(71,12,12,'50 1.8'),(72,12,14,'1'),(73,12,13,'Tripode'),(74,12,15,'5'),(75,12,15,'3'),(76,12,15,'11'),(77,12,15,'34'),(78,12,15,'22'),(79,12,15,'21'),(80,13,1,'699c665158b1d910666f609015772d1b.png'),(81,13,16,'c4bb81d8494423ba76f144b92d6d0531.jpg'),(82,13,2,'Perfil de prueba de cliente'),(83,13,3,'Carrer de Grande Gracia 134 3-1'),(84,13,4,'08020'),(85,13,5,'ES'),(86,13,6,'0034671710611'),(87,13,10,'Barcelona'),(88,13,7,'0034671710611'),(89,14,1,'458b5d7e78a9ce64994049269cfece64.png'),(90,14,16,'4445acba3d7d7fcba015074e61c38edd.jpg'),(91,14,2,'Perfil de prueba'),(92,14,3,'Carrer de Grande Gracia 134 3-1'),(93,14,4,'Barcelona'),(94,14,5,'ES'),(95,14,6,'0034671710611'),(96,14,10,'Barcelona'),(97,14,7,'0034671710611'),(98,14,11,'Nikon D90'),(99,14,12,'18-105 vr'),(100,14,14,'18'),(101,14,13,'Tripode'),(102,14,15,'7'),(103,14,15,'3'),(104,15,1,'dae6e4dd2ad3ec6b7f6efe02399973b5.png'),(105,15,2,'perfil creativo'),(106,15,3,'direccion de mi casa'),(107,15,4,'33178'),(108,15,5,'ES'),(109,15,6,'678254940'),(110,15,10,'ciudad donde vivo'),(111,15,7,'678254940'),(112,15,11,'nikkon'),(113,15,12,'lentes de aumento'),(114,15,14,'1-3'),(115,15,15,'7'),(116,15,15,'8'),(117,15,15,'15'),(118,15,15,'11'),(119,15,15,'34'),(120,15,15,'33'),(121,15,15,'22'),(122,11,7,'Telefono Movil'),(123,11,17,'sharkam@gmail.com'),(136,8,8,''),(137,8,9,'');
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
INSERT INTO `users` (`id`, `name`, `lastname`, `email`, `department`, `user`, `salt`, `pass`, `cdate`, `udate`, `act`) VALUES (2,'Alexander','Briceno','sharkam@gmail.com','Master','rabriceno','087a9be230b945eb5f93dd2c1ab304504b3cf807','c4a530bcf08180e8020dff3e4e3be8ed0446dff8','2012-07-08 21:21:42','2014-01-11 11:19:19','S'),(6,'Paulo','Rodrigues','paulo@fototea.com','fototea','paulo','ddc2e30b8d06d3e51906bdda05df68f80ad968a6','847e4d6d054879f789ddeff23e8f482d7d72027f','2014-01-13 20:17:55','2014-01-13 20:17:55','S');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'fototea_fot'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-03-25 16:30:18
