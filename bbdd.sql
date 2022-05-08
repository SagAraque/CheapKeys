-- MariaDB dump 10.19  Distrib 10.4.21-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: cheapkeys
-- ------------------------------------------------------
-- Server version	10.4.21-MariaDB

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
-- Table structure for table `game_keys`
--

DROP TABLE IF EXISTS `game_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game_keys` (
  `key_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `key_value` varchar(15) NOT NULL,
  `Id_game` int(10) unsigned NOT NULL,
  `Id_order` int(10) unsigned DEFAULT NULL,
  `Platform` enum('Steam','Origin','Epic Games','Windows','Switch','Xbox','PlayStation') NOT NULL,
  PRIMARY KEY (`key_id`),
  UNIQUE KEY `unique_key` (`key_value`),
  KEY `fk_id_game_key` (`Id_game`),
  KEY `fk_id_order_key` (`Id_order`),
  CONSTRAINT `fk_id_game_key` FOREIGN KEY (`Id_game`) REFERENCES `games` (`id_game`) ON UPDATE CASCADE,
  CONSTRAINT `fk_id_order_key` FOREIGN KEY (`Id_order`) REFERENCES `orders` (`id_order`) ON UPDATE CASCADE
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
  `game_name` varchar(250) NOT NULL,
  `game_desc` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `game_price` decimal(5,2) unsigned NOT NULL,
  `game_discount` int(11) NOT NULL,
  `game_plataform` varchar(150) NOT NULL,
  `game_developer` varchar(50) NOT NULL,
  `game_distributor` varchar(50) NOT NULL,
  `game_date` date NOT NULL DEFAULT current_timestamp(),
  `game_pegi` int(10) unsigned NOT NULL,
  `game_valoration` decimal(3,1) unsigned NOT NULL DEFAULT 0.0,
  `game_stock` int(10) unsigned NOT NULL DEFAULT 0,
  `game_state` enum('Launched','Reserve') NOT NULL,
  `Min_req` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`Min_req`)),
  `Max_req` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`Max_req`)),
  `game_slug` varchar(250) NOT NULL,
  PRIMARY KEY (`id_game`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` VALUES (1,'Minecraft: Java Edition','{\r\n  \"title\": [\r\n    null,\r\n    \"Construye el mundo de tus sueños\"\r\n  ],\r\n  \"content\": [\r\n    \"Minecraft es un juego de aventuras sandbox, desarrollado y publicado por Mojang. En el juego, la tarea del jugador es crear construcciones a partir de varios tipos de materiales que tienen que extraer en un entorno de mundo abierto. Los jugadores de Minecraft pueden participar en varios modos de juego, incluido el modo Supervivencia, Creativo y Aventura. El juego también ofrece un modo multijugador, donde los jugadores pueden cooperar en la obra de construcciones o competir entre sí en el modo PvP. Minecraft para Xbox One recibió críticas favorables de los críticos y se ha convertido en un fenómeno cultural con millones de fanáticos dedicados.\",\r\n    \"El jugador inicia un juego de Minecraft en un entorno abierto generado por procedimientos, que consta de bosques, llanuras, colinas y otras áreas. Su trabajo consiste en utilizar cualquier material que pueda encontrar para edificar construcciones. Los materiales del juego aparecen en forma de bloques, a partir de los cuales el jugador puede construir. Cada tipo de bloques tiene propiedades diferentes y puede ser utilizado para diferentes propósitos. El jugador puede visitar otros planos, Nether y The End, donde puede encontrar recursos y elementos exclusivos. Explorando el mundo de Minecraft, el jugador puede encontrar varias criaturas: desde animales, que pueden ser cazados para conseguir comida y materiales de artesanía, hasta monstruos peligrosos, como enredaderas que comen bloques.\"\r\n  ]\r\n}',19.95,0,'Windows','Mojang','Xbox Games Studios','2011-11-18',7,7.3,25,'Launched','{\r\n  \"OS\": \"Windows 7\",\r\n  \"Procesador\": \"Intel Core i3-3210 3.2 GHz\",\r\n  \"RAM\": \"2GB RAM\",\r\n  \"Almacenamiento\": \"4GB\",\r\n  \"Grafica\": \"Nvidia GeForce 400 Series\"\r\n}','{\r\n  \"OS\": \"Windows 10\",\r\n  \"Procesador\": \"Intel Core i5-4690 3.5GHz \",\r\n  \"RAM\": \"4GB RAM\",\r\n  \"Almacenamiento\": \"4GB\",\r\n  \"Grafica\": \"GeForce 700 Series \"\r\n}','minecraft_java_edition'),(2,'Bioshock: The Collection (Nintendo Switch)','{\r\n  \"title\": [\r\n    null,\r\n    \"Disfruta del juego con la mejor calidad\",\r\n    \"De vuelta al principio: BioShock\",\r\n    null\r\n  ],\r\n  \"content\": [\r\n    \"Lanzado en 2016, Bioshock: The Collection es la combinación definitiva de los tres títulos de Bioshock, junto con sus DLC. Reunidos en un solo paquete, cada uno de los juegos se ha renovado significativamente y cuenta con gráficos mejorados, con mayor resolución y efectos visuales mejorados.\",\r\n    \"Gloriosamente remasterizado en 1080p. BioShock: The Collection incluye todo el contenido para un jugador de BioShock, BioShock 2 y BioShock Infinite, junto con todos los DLC, como el pack Columbia\'s Finest o las dos partes del DLC de la historia Burial at Sea. Ahora puedes disfrutar del mítico FPS con elementos de RPG en una resolución de 1920x1080 a 60 fps.\",\r\n    \"La trilogía de BioShock comienza con Bioshock. Como náufrago de un avión siniestrado, entras en un faro, que resulta ser la entrada a la ciudad submarina de Rapture. Concebida como una utopía, la vida en Rapture debía transcurrir sin la molestia de ningún dolor terrenal. Y así fue, hasta el descubrimiento de ADAM, una sustancia que proporciona habilidades sobrehumanas. Esto resultó ser el principio del fin de la utopía de Rapture.\",\r\n    \"Las tensiones sociales provocaron conflictos entre facciones. Ahora Rapture es una ciudad colapsada, capturada por locos mutantes que habitan en las ruinas. La única forma de sobrevivir allí en este momento es usar ADAM. Conseguirlo, sin embargo, conlleva retos extremadamente peligrosos. Cargado con todo un arsenal de armas, exploras las ruinas submarinas enfrentándote a innumerables obstáculos en tu camino.\\n\\nDesde robot y mutantes, hasta Little Sisters y sus Big Daddies, te encontrarás con decenas de enemigos en tu camino. Prepárate para modificar tu ADN, ya que puede proporcionarte herramientas aún más mortíferas.\"\r\n  ]\r\n}',22.65,25,'Switch','2K Boston','2K','2020-05-29',18,0.0,0,'Launched','{\r\n  \"Almacenamiento\": \"20.7GB\",\r\n  \"Red\": \"Conexión de red constante\"\r\n}','{\r\n  \"Almacenamiento\": \"20.7GB\",\r\n  \"Red\": \"Conexión de red constante\"\r\n}','bioshock_the_collection_nintendo_switch');
/*!40000 ALTER TABLE `games` ENABLE KEYS */;
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
  `media_alt` varchar(100) DEFAULT NULL,
  `media_url` varchar(50) NOT NULL,
  `media_infoImg` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_media`,`id_game`),
  KEY `fk_id_game_media` (`id_game`),
  CONSTRAINT `fk_id_game_media` FOREIGN KEY (`id_game`) REFERENCES `games` (`id_game`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
INSERT INTO `media` VALUES (1,1,'Imagen del videojuego minecraft','minecraft',0),(2,1,'Nombre del videojuego minecraft frente a un paisaje del juego','static/img/games/minecraftInfo.webp',1),(3,2,'Portada del videojuego bioshock','static/img/games/bioshokCollectionInfo.webp',1),(4,2,'Imagen de los protagonistas del videojuego bioshock','bioshock',0),(5,1,'Imagen del videojuego Minecraft','minecraft2',0),(6,1,'Imagen del videojuego Minecraft','minecraft3',0),(7,1,'Imagen del videojuego Minecraft','minecraft4',0),(8,2,'Imagen del videojuego Bioshock','bioshock2',0),(9,2,'Imagen del videojuego Bioshock','bioshock3',0),(10,2,'Imagen del videojuego Bioshock','bioshock4',0),(11,2,'Imagen del videojuego Bioshock','bioshock5',0);
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
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `order_total` decimal(5,2) unsigned NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id_order`),
  KEY `fk_id_user_order` (`id_user`),
  CONSTRAINT `fk_id_user_order` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE
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
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `id_user` int(10) unsigned NOT NULL,
  `id_game` int(10) unsigned NOT NULL,
  `review_calification` decimal(3,1) NOT NULL,
  `review_desc` varchar(250) NOT NULL,
  `review_date` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_user`,`id_game`),
  KEY `fk_id_game_review` (`id_game`),
  CONSTRAINT `fk_id_game_review` FOREIGN KEY (`id_game`) REFERENCES `games` (`id_game`) ON UPDATE CASCADE,
  CONSTRAINT `fk_id_user_review` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,1,8.8,'Buen juego la verdad, desde que lo compré me paso todo el día con los cubitos','2022-05-03 18:00:48'),(2,1,10.0,'¿Perdona? ¿El kebab por donde queda?','2022-05-03 18:00:48'),(3,1,3.0,'Me esperaba más de este sandbox de bloques creado por Mojang en 2011. Después de jugar Elden Ring esto me parece super sencillo, además, para que voy a minar para pillarme una pecherita si la puedo pedir por Amazon. Para pensar señores','2022-05-03 18:02:45'),(4,1,5.6,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta justo ac ipsum fermentum porta. Praesent nunc metus, consequat sed neque sed, elementum vehicula mi. Suspendisse potenti. Aenean eu mollis neque. Ut dictum euismod sem, ut pharetra.','2022-05-06 17:51:09'),(5,1,6.0,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta justo ac ipsum fermentum porta. Praesent nunc metus, consequat sed neque sed, elementum vehicula mi. Suspendisse potenti. Aenean eu mollis neque. Ut dictum euismod sem, ut pharetra.','2022-05-06 17:51:09'),(6,1,9.0,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta justo ac ipsum fermentum porta. Praesent nunc metus, consequat sed neque sed, elementum vehicula mi. Suspendisse potenti. Aenean eu mollis neque. Ut dictum euismod sem, ut pharetra.','2022-05-06 17:51:09'),(7,1,8.8,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta justo ac ipsum fermentum porta. Praesent nunc metus, consequat sed neque sed, elementum vehicula mi. Suspendisse potenti. Aenean eu mollis neque. Ut dictum euismod sem, ut pharetra.','2022-05-06 17:51:09'),(8,1,10.0,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec porta justo ac ipsum fermentum porta. Praesent nunc metus, consequat sed neque sed, elementum vehicula mi. Suspendisse potenti. Aenean eu mollis neque. Ut dictum euismod sem, ut pharetra.','2022-05-06 17:51:09');
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
  `user_name` varchar(30) NOT NULL,
  `user_pass` varchar(60) NOT NULL,
  `user_img` varchar(60) NOT NULL DEFAULT 'default.jpg',
  `user_email` varchar(100) NOT NULL,
  `user_age` int(2) unsigned NOT NULL,
  `user_rol` varchar(45) NOT NULL DEFAULT 'ROLE_USER',
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `user_name` (`user_name`,`user_email`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Usuario 1','$2a$10$yNz02Xb3gQWrRVdfbmFMtei4LFBb24aJaPRHnrvPXKW4qEzI2cTrO','default.jpg','sagaraque@gmail.com',20,'ROLE_USER'),(2,'Usuario 2','$2a$10$GqdFFyjinUH2nsYCpabhiOt0X04nDPKOI/am08DjLA1dcWgqNiUuq','default.jpg','truxml@gmail.com',19,'ROLE_USER'),(3,'Usuario 3','$2a$10$GWRlD8rwwiNmeXP2p..rKOKOX1TJ2EM6ZN2A8IH9WKwFA/wVgPkUe','default.jpg','usuario3@gmail.com',17,'ROLE_USER'),(4,'Usuario 4','$2a$10$X/5IDerhs2hxRJsmpYFxBuP/ZCrkUGF1muiUHYxUbF4GYM9KZsDqK','default.jpg','usuario4@gmail.com',16,'ROLE_USER'),(5,'Usuario 5','$2a$10$rFfjgUEmoqTsaee3OcML0.U97ZjYggdtsAuHIoyXn9lh21Xd8ifqe','default.jpg','usuario5@gmail.com',22,'ROLE_USER'),(6,'Usuario 6','$2a$10$6qVQBlmIl7Q/en0xikKe0uWelafegIPRmid/dYOvhN2lOeJg6FD9O','default.jpg','usuario6@gmail.com',16,'ROLE_USER'),(7,'Usuario 7','$2a$10$VfggzreqN8QwjXFwzCS8o.oYDnCgKxnEggf.VMROeuPufH84RwR22','default.jpg','usuario7@gmail.com',34,'ROLE_USER'),(8,'Usuario 8','$2a$10$VQ3TexUHzKC6fjlAaUSl/ugV/JaKQ/sZvs2K/55NCluTWUl2PWrfi','default.jpg','usuario8@gmail.com',23,'ROLE_USER');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-09  1:15:02
