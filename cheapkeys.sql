-- MariaDB dump 10.19  Distrib 10.4.24-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: cheapkeys
-- ------------------------------------------------------
-- Server version	10.4.24-MariaDB

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
-- Table structure for table `billing`
--

DROP TABLE IF EXISTS `billing`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `billing` (
  `id_billing` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL,
  `billing_name` text NOT NULL,
  `billing_state` enum('ACTIVE','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `billing_direction` varchar(150) NOT NULL,
  `billing_postal` varchar(5) NOT NULL,
  `billing_poblation` varchar(100) NOT NULL,
  `billing_country` varchar(100) NOT NULL,
  `billing_province` varchar(100) NOT NULL,
  `billin_tlfo` varchar(11) NOT NULL,
  PRIMARY KEY (`id_billing`),
  KEY `FK1` (`id_user`),
  CONSTRAINT `FK1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `billing`
--

LOCK TABLES `billing` WRITE;
/*!40000 ALTER TABLE `billing` DISABLE KEYS */;
INSERT INTO `billing` VALUES (1,1,'Sergio Araque García','ACTIVE','Calle de huesca 3','28941','Fuenlabrada','España','Madrid','695124903'),(2,1,'Sergio Araque García','DELETED','Calle Joselito 3 3ºA','28945','Mostoles','España','Madrid','695124903');
/*!40000 ALTER TABLE `billing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart` (
  `id_cart` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL,
  `cart_total` decimal(5,2) NOT NULL DEFAULT 0.00,
  `cart_state` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_cart`),
  KEY `fk18` (`id_user`),
  CONSTRAINT `fk18` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` VALUES (8,1,695.29,1);
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cart_products`
--

DROP TABLE IF EXISTS `cart_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cart_products` (
  `id_cart` int(10) unsigned NOT NULL,
  `id_game` int(11) unsigned NOT NULL,
  `id_platform` int(10) unsigned NOT NULL,
  `cant` int(10) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_cart`,`id_game`,`id_platform`),
  KEY `Fk21` (`id_platform`),
  KEY `FK22` (`id_game`),
  CONSTRAINT `FK19` FOREIGN KEY (`id_cart`) REFERENCES `cart` (`id_cart`) ON UPDATE CASCADE,
  CONSTRAINT `FK22` FOREIGN KEY (`id_game`) REFERENCES `games` (`id_game`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `Fk21` FOREIGN KEY (`id_platform`) REFERENCES `platforms` (`id_platform`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart_products`
--

LOCK TABLES `cart_products` WRITE;
/*!40000 ALTER TABLE `cart_products` DISABLE KEYS */;
INSERT INTO `cart_products` VALUES (8,1,1,34),(8,2,2,1);
/*!40000 ALTER TABLE `cart_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `features`
--

DROP TABLE IF EXISTS `features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `features` (
  `id_feature` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `game_desc` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`game_desc`)),
  `game_developer` varchar(100) NOT NULL,
  `game_distributor` varchar(100) NOT NULL,
  `game_stock` int(10) unsigned NOT NULL DEFAULT 0,
  `game_slug` text NOT NULL,
  `game_date` date NOT NULL,
  `game_state` enum('LAUNCHED','RESERVE') NOT NULL,
  `min_req` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`min_req`)),
  `max_req` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`max_req`)),
  `game_price` decimal(5,2) unsigned NOT NULL,
  `game_discount` int(3) unsigned NOT NULL DEFAULT 0,
  `game_valoration` decimal(2,1) unsigned NOT NULL,
  `game_pegi` int(2) NOT NULL,
  PRIMARY KEY (`id_feature`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `features`
--

LOCK TABLES `features` WRITE;
/*!40000 ALTER TABLE `features` DISABLE KEYS */;
INSERT INTO `features` VALUES (1,'{\r\n  \"title\": [\r\n    null,\r\n    \"Construye el mundo de tus sueños\"\r\n  ],\r\n  \"content\": [\r\n    \"Minecraft es un juego de aventuras sandbox, desarrollado y publicado por Mojang. En el juego, la tarea del jugador es crear construcciones a partir de varios tipos de materiales que tienen que extraer en un entorno de mundo abierto. Los jugadores de Minecraft pueden participar en varios modos de juego, incluido el modo Supervivencia, Creativo y Aventura. El juego también ofrece un modo multijugador, donde los jugadores pueden cooperar en la obra de construcciones o competir entre sí en el modo PvP. Minecraft para Xbox One recibió críticas favorables de los críticos y se ha convertido en un fenómeno cultural con millones de fanáticos dedicados.\",\r\n    \"El jugador inicia un juego de Minecraft en un entorno abierto generado por procedimientos, que consta de bosques, llanuras, colinas y otras áreas. Su trabajo consiste en utilizar cualquier material que pueda encontrar para edificar construcciones. Los materiales del juego aparecen en forma de bloques, a partir de los cuales el jugador puede construir. Cada tipo de bloques tiene propiedades diferentes y puede ser utilizado para diferentes propósitos. El jugador puede visitar otros planos, Nether y The End, donde puede encontrar recursos y elementos exclusivos. Explorando el mundo de Minecraft, el jugador puede encontrar varias criaturas: desde animales, que pueden ser cazados para conseguir comida y materiales de artesanía, hasta monstruos peligrosos, como enredaderas que comen bloques.\"\r\n  ]\r\n}','Mojang','Xbox Games Studios',25,'minecraft_java_edition','2011-11-18','LAUNCHED','{\r\n  \"OS\": \"Windows 7\",\r\n  \"Procesador\": \"Intel Core i3-3210 3.2 GHz\",\r\n  \"RAM\": \"2GB RAM\",\r\n  \"Almacenamiento\": \"4GB\",\r\n  \"Grafica\": \"Nvidia GeForce 400 Series\"\r\n}','{\r\n  \"OS\": \"Windows 10\",\r\n  \"Procesador\": \"Intel Core i5-4690 3.5GHz \",\r\n  \"RAM\": \"4GB RAM\",\r\n  \"Almacenamiento\": \"4GB\",\r\n  \"Grafica\": \"GeForce 700 Series \"\r\n}',19.95,0,7.3,3),(2,'{\r\n   \"title\": [\r\n     null,\r\n     \"Disfruta del juego con la mejor calidad\",\r\n     \"De vuelta al principio: BioShock\",\r\n     null\r\n   ],\r\n   \"content\": [\r\n     \"Lanzado en 2016, Bioshock: The Collection es la combinación definitiva de los tres títulos de Bioshock, junto con sus DLC. Reunidos en un solo paquete, cada uno de los juegos se ha renovado significativamente y cuenta con gráficos mejorados, con mayor resolución y efectos visuales mejorados.\",\r\n     \"Gloriosamente remasterizado en 1080p. BioShock: The Collection incluye todo el contenido para un jugador de BioShock, BioShock 2 y BioShock Infinite, junto con todos los DLC, como el pack Columbia\'s Finest o las dos partes del DLC de la historia Burial at Sea. Ahora puedes disfrutar del mítico FPS con elementos de RPG en una resolución de 1920x1080 a 60 fps.\",\r\n     \"La trilogía de BioShock comienza con Bioshock. Como náufrago de un avión siniestrado, entras en un faro, que resulta ser la entrada a la ciudad submarina de Rapture. Concebida como una utopía, la vida en Rapture debía transcurrir sin la molestia de ningún dolor terrenal. Y así fue, hasta el descubrimiento de ADAM, una sustancia que proporciona habilidades sobrehumanas. Esto resultó ser el principio del fin de la utopía de Rapture.\",\r\n     \"Las tensiones sociales provocaron conflictos entre facciones. Ahora Rapture es una ciudad colapsada, capturada por locos mutantes que habitan en las ruinas. La única forma de sobrevivir allí en este momento es usar ADAM. Conseguirlo, sin embargo, conlleva retos extremadamente peligrosos. Cargado con todo un arsenal de armas, exploras las ruinas submarinas enfrentándote a innumerables obstáculos en tu camino.\\n\\nDesde robot y mutantes, hasta Little Sisters y sus Big Daddies, te encontrarás con decenas de enemigos en tu camino. Prepárate para modificar tu ADN, ya que puede proporcionarte herramientas aún más mortíferas.\"\r\n   ]\r\n }','2K Boston','2K',0,'bioshock_the_collection','2020-05-29','LAUNCHED','{\r\n   \"Almacenamiento\": \"20.7GB\",\r\n   \"Red\": \"Conexión de red constante\"\r\n }','{\r\n   \"Almacenamiento\": \"20.7GB\",\r\n   \"Red\": \"Conexión de red constante\"\r\n }',22.65,25,0.0,18);
/*!40000 ALTER TABLE `features` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game_keys`
--

DROP TABLE IF EXISTS `game_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game_keys` (
  `id_key` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_platform` int(10) unsigned NOT NULL,
  `id_game` int(10) unsigned NOT NULL,
  `id_order` int(10) unsigned DEFAULT NULL,
  `key_value` varchar(15) NOT NULL,
  PRIMARY KEY (`id_key`),
  UNIQUE KEY `key_value` (`key_value`),
  KEY `FK7` (`id_platform`),
  KEY `FK8` (`id_game`),
  KEY `FK9` (`id_order`),
  CONSTRAINT `FK7` FOREIGN KEY (`id_platform`) REFERENCES `platforms` (`id_platform`) ON UPDATE CASCADE,
  CONSTRAINT `FK8` FOREIGN KEY (`id_game`) REFERENCES `games` (`id_game`) ON UPDATE CASCADE,
  CONSTRAINT `FK9` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_keys`
--

LOCK TABLES `game_keys` WRITE;
/*!40000 ALTER TABLE `game_keys` DISABLE KEYS */;
/*!40000 ALTER TABLE `game_keys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `games`
--

DROP TABLE IF EXISTS `games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `games` (
  `id_game` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `game_name` varchar(150) NOT NULL,
  `game_slug` varchar(100) NOT NULL,
  PRIMARY KEY (`id_game`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` VALUES (1,'Minecraft: Java Edition','minecraft_java_edition'),(2,'Bioshock: The Collection','bioshock_the_collection');
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `games_platform`
--

DROP TABLE IF EXISTS `games_platform`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `games_platform` (
  `id_platform` int(10) unsigned NOT NULL,
  `game_id` int(10) unsigned NOT NULL,
  `id_feature` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_platform`,`game_id`),
  KEY `FK5` (`game_id`),
  KEY `FK6` (`id_platform`),
  KEY `FK20` (`id_feature`),
  CONSTRAINT `FK20` FOREIGN KEY (`id_feature`) REFERENCES `features` (`id_feature`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK5` FOREIGN KEY (`game_id`) REFERENCES `games` (`id_game`) ON UPDATE CASCADE,
  CONSTRAINT `FK6` FOREIGN KEY (`id_platform`) REFERENCES `platforms` (`id_platform`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games_platform`
--

LOCK TABLES `games_platform` WRITE;
/*!40000 ALTER TABLE `games_platform` DISABLE KEYS */;
INSERT INTO `games_platform` VALUES (1,1,1),(2,2,2);
/*!40000 ALTER TABLE `games_platform` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media`
--

DROP TABLE IF EXISTS `media`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media` (
  `id_media` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_game` int(10) unsigned NOT NULL,
  `media_url` varchar(100) NOT NULL,
  `media_alt` varchar(100) NOT NULL,
  `media_InfoImg` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_media`),
  KEY `FK12` (`id_game`),
  CONSTRAINT `FK12` FOREIGN KEY (`id_game`) REFERENCES `games` (`id_game`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
INSERT INTO `media` VALUES (1,1,'minecraft','Imagen del videojuego minecraft',0),(2,1,'minecraft2','Imagen del videojuego Minecraft',0),(3,1,'minecraft3','Imagen del videojuego Minecraft',0),(4,1,'minecraft4','Imagen del videojuego Minecraft',0),(5,1,'minecraftInfo','Imagen del videojuego Minecraft',1),(6,2,'bioshokCollectionInfo','Portada del videojuego bioshock',1),(7,2,'bioshock','Imagen del videojuego Bioshock',0),(8,2,'bioshock2','Imagen del videojuego Bioshock',0),(9,2,'bioshock3','Imagen del videojuego Bioshock',0),(10,2,'bioshock4','Imagen del videojuego Bioshock',0),(11,2,'bioshock5','Imagen del videojuego Bioshock',0);
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id_order` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL,
  `order_date` date NOT NULL DEFAULT current_timestamp(),
  `order_total` decimal(5,2) NOT NULL DEFAULT 0.00,
  `id_billing` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_order`),
  KEY `FK2` (`id_user`),
  KEY `FK3` (`id_billing`),
  CONSTRAINT `FK2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE,
  CONSTRAINT `FK3` FOREIGN KEY (`id_billing`) REFERENCES `billing` (`id_billing`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `platforms`
--

DROP TABLE IF EXISTS `platforms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `platforms` (
  `id_platform` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `platform_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id_platform`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `platforms`
--

LOCK TABLES `platforms` WRITE;
/*!40000 ALTER TABLE `platforms` DISABLE KEYS */;
INSERT INTO `platforms` VALUES (1,'windows'),(2,'switch');
/*!40000 ALTER TABLE `platforms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `id_plaftorm` int(10) unsigned NOT NULL,
  `id_game` int(10) unsigned NOT NULL,
  `id_user` int(10) unsigned NOT NULL,
  `review_calification` decimal(2,1) NOT NULL,
  `review_desc` varchar(255) NOT NULL,
  `review_date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_plaftorm`,`id_game`,`id_user`),
  KEY `FK14` (`id_game`),
  KEY `FK15` (`id_user`),
  KEY `FK16` (`id_plaftorm`),
  CONSTRAINT `FK14` FOREIGN KEY (`id_game`) REFERENCES `games` (`id_game`) ON UPDATE CASCADE,
  CONSTRAINT `FK15` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE,
  CONSTRAINT `Fk16` FOREIGN KEY (`id_plaftorm`) REFERENCES `platforms` (`id_platform`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,1,1,9.9,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta justo ac ipsum fermentum porta. Praesent nunc metus, consequat sed neque sed, elementum vehicula mi. Suspendisse potenti. Aenean eu mollis neque. Ut dictum euismod sem, ut pharetra.','2022-05-10 00:00:00'),(1,1,3,9.5,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta justo ac ipsum fermentum porta. Praesent nunc metus, consequat sed neque sed, elementum vehicula mi. Suspendisse potenti. Aenean eu mollis neque. Ut dictum euismod sem, ut pharetra.','2022-05-10 00:00:00'),(1,1,4,8.0,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta justo ac ipsum fermentum porta. Praesent nunc metus, consequat sed neque sed, elementum vehicula mi. Suspendisse potenti. Aenean eu mollis neque. Ut dictum euismod sem, ut pharetra.','2022-05-10 00:00:00'),(1,1,5,4.0,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta justo ac ipsum fermentum porta. Praesent nunc metus, consequat sed neque sed, elementum vehicula mi. Suspendisse potenti. Aenean eu mollis neque. Ut dictum euismod sem, ut pharetra.','2022-05-10 00:00:00'),(1,1,6,5.5,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta justo ac ipsum fermentum porta. Praesent nunc metus, consequat sed neque sed, elementum vehicula mi. Suspendisse potenti. Aenean eu mollis neque. Ut dictum euismod sem, ut pharetra.','2022-05-10 00:00:00'),(1,1,7,7.0,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta justo ac ipsum fermentum porta. Praesent nunc metus, consequat sed neque sed, elementum vehicula mi. Suspendisse potenti. Aenean eu mollis neque. Ut dictum euismod sem, ut pharetra.','2022-05-10 00:00:00'),(1,1,8,3.3,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta justo ac ipsum fermentum porta. Praesent nunc metus, consequat sed neque sed, elementum vehicula mi. Suspendisse potenti. Aenean eu mollis neque. Ut dictum euismod sem, ut pharetra.','2022-05-10 00:00:00');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id_user` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_pass` varchar(100) NOT NULL,
  `user_img` varchar(50) NOT NULL DEFAULT 'default',
  `user_rol` enum('ROLE_USER','ROLE_ADMIN') NOT NULL DEFAULT 'ROLE_USER',
  `user_state` enum('ACTIVE','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `user_wishlist` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `EmailIndex` (`user_email`),
  UNIQUE KEY `user_name` (`user_name`),
  UNIQUE KEY `user_name_2` (`user_name`,`user_email`),
  KEY `FK4` (`user_wishlist`),
  CONSTRAINT `FK4` FOREIGN KEY (`user_wishlist`) REFERENCES `wishlist` (`id_wishlist`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Usuario 1','usuario1@gmail.com','$2y$10$sRfDbs4bd/FwFaqAMXgaMOwolBDqbeKyY93SaaPwLobYfLMh8202y','default','ROLE_USER','ACTIVE',1),(2,'Usuario 2','usuario2@gmail.com','$2a$10$rtRzzL0PtMXebGJjlQTpbuLWNSpdfyjYjLIu8P.s95UcbMNghSfDi','default','ROLE_USER','ACTIVE',2),(3,'Usuario 3','usuario3@gmail.com','$2a$10$RBTzjNTPCn6AelYEaGYcRu/PKadqFXczCyorGbNOSNQGhs6H6uRa.','default','ROLE_USER','ACTIVE',3),(4,'Usuario 4','usuario4@gmail.com','$2a$10$Y8lklhtnC7Ca9/Um8xLR6uqQUehBdh3qFkLayAHwf7FCAltETI1hm','default','ROLE_USER','ACTIVE',4),(5,'Usuario 5','usuario5@gmail.com',' $2a$10$JBQktfx3fF17/ZSs9iGhUe/VOZcXpiYCF9GY4cXxbAhw6gxEOkvH','default','ROLE_USER','ACTIVE',5),(6,'Usuario 6','usuario6@gmail.com',' $2a$10$5yLnm6EsTPQ0DtoHINa.FuH8M6PxRchhle2KbT.giS5QVHvS6UN2','default','ROLE_USER','ACTIVE',6),(7,'Usuario 7','usuario7@gmail.com',' $2a$10$cVRvLqM0eGR45kYXIWm/SeBGv29mPKmFv0GIAJoaiazWpmyb7R5a','default','ROLE_USER','ACTIVE',7),(8,'Usuario 8','usuario8@gmail.com',' $2a$10$E139RnijNmvzLRuIDDTFmeGA/cT69NWfdxbno6nXMBv470GjcLnI','default','ROLE_USER','ACTIVE',8),(9,'registro','registro@gmail.com','$2y$13$f2XP065Sh3.Vpld1M1O8PucTIlsFo6wt5T9jCGygsBpmAZJbCPBEm','default','ROLE_USER','ACTIVE',9),(10,'pruebaRegistro','pruebaregistro@gmail.com','$2y$13$WMWDtr.PgDhino9XoXDGVe18CpPXR2PY74fglPakZ4rW3WhnKxTtm','default','ROLE_USER','ACTIVE',10),(11,'prueba2','prueba2@gmail.com','$2y$13$QrOv8jP/jbMKEiiXgrV09epUuxXc9vILd4bGzSu9PeJ8dFdUlGGTy','default','','',11),(12,'prueba3','prueba3@gmail.com','$2y$13$bxzyaaIhsOyvA9L9whB0Fuf03JOoj4NDNl3DRakV.l7UNyW7LA4zC','default','','',12),(13,'prueba4','prueba4@gmail.com','$2y$13$7rjR1LENH8hoPCiqWhCk7uNLBE2nNC7bGAgWAy6fO/Aa0b8sGGwgK','default','ROLE_USER','ACTIVE',13),(14,'prueba5','prueba5@gmail.com','$2y$13$IXnsJErSNNt1A2HP2oU4Ouj8gfJL3PJUbd7Ajnp4dhQHHyy.NC3Hm','\'default\'','','',15),(15,'prueba6','prueba6@gmail.com','$2y$13$/618bAQK4RebmKfC4INzfewzKfN7NnRJdIVXstaCUB7BOVJtyrYB6','default','ROLE_USER','ACTIVE',16),(16,'prueba7','prueba7@gmail.com','$2y$13$UjEp9CY9JciwrsDmPP2xDejqGHI3KWr5WPX0xhumiir9zMX6k.lFW','default','ROLE_USER','ACTIVE',17),(17,'prueba8','prueba8@gmail.com','$2y$13$12D9Tg9lRPeFDbwcqC5WP.WlYFEgHMxqODGSvG6BdWdBLN9Ib91aS','default','ROLE_USER','ACTIVE',18),(18,'12345','usuario1@gamil.com','$2y$13$/sps0OxO9ta0neudIqegxuCoyWWCdZP6gInp9UVj6KPvPmkWleIdK','default','ROLE_USER','ACTIVE',19);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wishlist` (
  `id_wishlist` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id_wishlist`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlist`
--

LOCK TABLES `wishlist` WRITE;
/*!40000 ALTER TABLE `wishlist` DISABLE KEYS */;
INSERT INTO `wishlist` VALUES (1),(2),(3),(4),(5),(6),(7),(8),(9),(10),(11),(12),(13),(15),(16),(17),(18),(19);
/*!40000 ALTER TABLE `wishlist` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wishlist_games`
--

DROP TABLE IF EXISTS `wishlist_games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wishlist_games` (
  `id_game` int(10) unsigned NOT NULL,
  `id_wishlist` int(10) unsigned NOT NULL,
  `id_platform` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_game`,`id_wishlist`,`id_platform`),
  KEY `FK11` (`id_wishlist`),
  KEY `FK13` (`id_platform`),
  CONSTRAINT `FK10` FOREIGN KEY (`id_game`) REFERENCES `games` (`id_game`) ON UPDATE CASCADE,
  CONSTRAINT `FK11` FOREIGN KEY (`id_wishlist`) REFERENCES `wishlist` (`id_wishlist`) ON UPDATE CASCADE,
  CONSTRAINT `FK13` FOREIGN KEY (`id_platform`) REFERENCES `platforms` (`id_platform`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlist_games`
--

LOCK TABLES `wishlist_games` WRITE;
/*!40000 ALTER TABLE `wishlist_games` DISABLE KEYS */;
INSERT INTO `wishlist_games` VALUES (1,1,1),(1,3,1),(2,1,2);
/*!40000 ALTER TABLE `wishlist_games` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-20 14:50:43
