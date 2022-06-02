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
INSERT INTO `billing` VALUES (1,1,'Sergio Araque García','ACTIVE','Calle de Manolito3','28931','Humanes','España','Madrid','698376502'),(2,1,'Sergio Araque García','DELETED','Calle Joselito 3 3ºA','28945','Mostoles','España','Madrid','697302178');
/*!40000 ALTER TABLE `billing` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `card`
--

DROP TABLE IF EXISTS `card`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `card` (
  `id_card` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `card_number` varchar(19) NOT NULL,
  `card_cvv` varchar(3) NOT NULL,
  `card_name` varchar(100) NOT NULL,
  `card_user` int(10) unsigned NOT NULL,
  `card_state` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id_card`),
  KEY `FK28` (`card_user`),
  CONSTRAINT `FK28` FOREIGN KEY (`card_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `card`
--

LOCK TABLES `card` WRITE;
/*!40000 ALTER TABLE `card` DISABLE KEYS */;
INSERT INTO `card` VALUES (1,'4011317773263584','123','Joselito Perez',1,1),(2,'4016156835285218','321','Pepe Martinez',1,1);
/*!40000 ALTER TABLE `card` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cart`
--

LOCK TABLES `cart` WRITE;
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` VALUES (8,1,19.95,0),(9,20,0.00,1),(10,1,19.95,0),(11,1,19.95,0),(12,1,19.95,0),(13,1,19.90,0),(14,1,19.95,0),(15,1,0.00,1);
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
INSERT INTO `cart_products` VALUES (8,1,1,1),(10,1,1,1),(11,1,1,1),(12,1,1,1),(13,4,5,2),(14,1,1,1);
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
  `game_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `features`
--

LOCK TABLES `features` WRITE;
/*!40000 ALTER TABLE `features` DISABLE KEYS */;
INSERT INTO `features` VALUES (1,'<p class=\"desc__text\">\r\n    Minecraft es un juego de aventuras sandbox, desarrollado y publicado por Mojang. En el juego, la tarea del jugador\r\n    es crear construcciones a partir de varios tipos de materiales que tienen que extraer en un entorno de mundo\r\n    abierto. Los jugadores de Minecraft pueden participar en varios modos de juego, incluido el modo Supervivencia,\r\n    Creativo y Aventura. El juego también ofrece un modo multijugador, donde los jugadores pueden cooperar en la obra de\r\n    construcciones o competir entre sí en el modo PvP. Minecraft para Xbox One recibió críticas favorables de los\r\n    críticos y se ha convertido en un fenómeno cultural con millones de fanáticos dedicados.\r\n</p>\r\n\r\n<h3 class=\"desc__title\">\r\n    Construye el mundo de tus sueños\r\n</h3>\r\n\r\n<p class=\"desc__text\">\r\n    El jugador inicia un juego de Minecraft en un entorno abierto generado por procedimientos, que consta de bosques,\r\n    llanuras, colinas y otras áreas. Su trabajo consiste en utilizar cualquier material que pueda encontrar para\r\n    edificar construcciones. Los materiales del juego aparecen en forma de bloques, a partir de los cuales el jugador\r\n    puede construir. Cada tipo de bloques tiene propiedades diferentes y puede ser utilizado para diferentes propósitos.\r\n    El jugador puede visitar otros planos, Nether y The End, donde puede encontrar recursos y elementos exclusivos.\r\n    Explorando el mundo de Minecraft, el jugador puede encontrar varias criaturas: desde animales, que pueden ser\r\n    cazados para conseguir comida y materiales de artesanía, hasta monstruos peligrosos, como enredaderas que comen\r\n    bloques.\r\n</p>','Mojang','Xbox Games Studios',3,'minecraft_java_edition','2011-11-18','LAUNCHED','{\r\n  \"OS\": \"Windows 7\",\r\n  \"Procesador\": \"Intel Core i3-3210 3.2 GHz\",\r\n  \"RAM\": \"2GB RAM\",\r\n  \"Almacenamiento\": \"4GB\",\r\n  \"Grafica\": \"Nvidia GeForce 400 Series\"\r\n}','{\r\n  \"OS\": \"Windows 10\",\r\n  \"Procesador\": \"Intel Core i5-4690 3.5GHz \",\r\n  \"RAM\": \"4GB RAM\",\r\n  \"Almacenamiento\": \"4GB\",\r\n  \"Grafica\": \"GeForce 700 Series \"\r\n}',19.95,0,7.3,3),(2,' <p class=\"desc__text\">\r\n    Lanzado en 2016, Bioshock: The Collection es la combinación definitiva de los tres títulos de Bioshock, junto con sus DLC. Reunidos en un solo paquete, cada uno de los juegos se ha renovado significativamente y cuenta con gráficos mejorados, con mayor resolución y efectos visuales mejorados.\r\n</p>\r\n<p class=\"desc__text\">\r\n    Gloriosamente remasterizado en 1080p. BioShock: The Collection incluye todo el contenido para un jugador de BioShock, BioShock 2 y BioShock Infinite, junto con todos los DLC, como el pack Columbia\'s Finest o las dos partes del DLC de la historia Burial at Sea. Ahora puedes disfrutar del mítico FPS con elementos de RPG en una resolución de 1920x1080 a 60 fps.\r\n</p>\r\n<h3 class=\"desc__title\">\r\n    Disfruta del juego con la mejor calidad\r\n</h3>\r\n<p class=\"desc__text\">\r\n   La trilogía de BioShock comienza con Bioshock. Como náufrago de un avión siniestrado, entras en un faro, que resulta ser la entrada a la ciudad submarina de Rapture. Concebida como una utopía, la vida en Rapture debía transcurrir sin la molestia de ningún dolor terrenal. Y así fue, hasta el descubrimiento de ADAM, una sustancia que proporciona habilidades sobrehumanas. Esto resultó ser el principio del fin de la utopía de Rapture.\r\n</p>\r\n<h3 class=\"desc__title\">\r\n    De vuelta al principio: BioShock\r\n</h3>\r\n<p class=\"desc__text\">\r\n     Las tensiones sociales provocaron conflictos entre facciones. Ahora Rapture es una ciudad colapsada, capturada por locos mutantes que habitan en las ruinas. La única forma de sobrevivir allí en este momento es usar ADAM. Conseguirlo, sin embargo, conlleva retos extremadamente peligrosos. Cargado con todo un arsenal de armas, exploras las ruinas submarinas enfrentándote a innumerables obstáculos en tu camino. Desde robot y mutantes, hasta Little Sisters y sus Big Daddies, te encontrarás con decenas de enemigos en tu camino. Prepárate para modificar tu ADN, ya que puede proporcionarte herramientas aún más mortíferas.\r\n</p>','2K Boston','2K',0,'bioshock_the_collection','2020-05-29','LAUNCHED','{\r\n   \"Almacenamiento\": \"20.7GB\",\r\n   \"Red\": \"Conexión de red constante\"\r\n }','{\r\n   \"Almacenamiento\": \"20.7GB\",\r\n   \"Red\": \"Conexión de red constante\"\r\n }',22.65,25,0.0,18),(3,'<p class=\"desc__text\">\r\n    En Deathloop asumes el papel de un asesino, llamado Colt, al que le toca vivir en una fiesta perpetua en el fin del mundo. El juego está ambientado en la isla de Blackreef, que se basa en las Islas Feroe en los años 60, donde los isleños se divierten toda la noche, reiniciando a la medianoche al día anterior. Esto significa que pueden hacer lo que quieran, porque no lo recordarán ¡Y estarán bien!.\r\n</p>\r\n<p class=\"desc__text\">\r\n    Sin embargo, Colt puede y quiere recordar, y es su misión terminar la fiesta de una vez por todas. La isla solía ser una base militar experimental, con una misión ultra secreta llamada AEON, que fue diseñada para perseguir la inmortalidad. Pero el ejército se fue hace mucho y los habitantes han invertido mucho tiempo en la isla, disfrutando de una existencia despreocupada de las mismas 24 horas una y otra vez.\r\n</p>\r\n<h3 class=\"desc__title\">\r\n    Información adicional\r\n</h3>\r\n<p class=\"desc__text\">\r\n   Los desarrolladores del juego lo describen como \'Cluedo invertido\' y el nombre es bueno. Debes resolver e implementar cómo cometer ocho asesinatos perfectos. Sin embargo, no todo va contra Colt, porque además de las armas, tiene poderes sobrenaturales, con los que puede empujar a las personas por un acantilado sin tocarlas: Karnesis, así como otros poderes, llamados Slabs, como Aether, Telekinesis, Masquerade y teletransporte a corta distancia. Hay una forma de dar fuerza a Colt de forma permanente, pero tendrás que encontrarla tú mismo.\r\n</p>','Arkane Studios','Bethesda Softworks',56,'deathloop','2021-11-14','LAUNCHED','{\r\n  \"OS\": \"64 bit Windows 10\",\r\n  \"Procesador\": \"i5-8400 o Ryzen 5 1600\",\r\n  \"Memoria\": \"12 GB RAM\",\r\n  \"Gráfica\": \"GTX 1060 o Radeon RX 580\",\r\n  \"DirectX\": \"Version 12\",\r\n  \"Almacenamiento\": \"30 GB\"\r\n}','{\r\n  \"OS\": \"64 bit Windows 10\",\r\n  \"Procesador\": \"i7-9700K o Ryzen 7 2700X\",\r\n  \"Memoria\": \"16 GB RAM\",\r\n  \"Gráfica\": \"RTX 2060 o Radeon RX 5700\",\r\n  \"DirectX\": \"Version 12\",\r\n  \"Almacenamiento\": \"30 GB\"\r\n}',49.99,0,0.0,18),(4,'<p class=\"desc__text\">\r\n    En Deathloop asumes el papel de un asesino, llamado Colt, al que le toca vivir en una fiesta perpetua en el fin del mundo. El juego está ambientado en la isla de Blackreef, que se basa en las Islas Feroe en los años 60, donde los isleños se divierten toda la noche, reiniciando a la medianoche al día anterior. Esto significa que pueden hacer lo que quieran, porque no lo recordarán ¡Y estarán bien!.\r\n</p>\r\n<p class=\"desc__text\">\r\n    Sin embargo, Colt puede y quiere recordar, y es su misión terminar la fiesta de una vez por todas. La isla solía ser una base militar experimental, con una misión ultra secreta llamada AEON, que fue diseñada para perseguir la inmortalidad. Pero el ejército se fue hace mucho y los habitantes han invertido mucho tiempo en la isla, disfrutando de una existencia despreocupada de las mismas 24 horas una y otra vez.\r\n</p>\r\n<h3 class=\"desc__title\">\r\n    Información adicional\r\n</h3>\r\n<p class=\"desc__text\">\r\n   Los desarrolladores del juego lo describen como \'Cluedo invertido\' y el nombre es bueno. Debes resolver e implementar cómo cometer ocho asesinatos perfectos. Sin embargo, no todo va contra Colt, porque además de las armas, tiene poderes sobrenaturales, con los que puede empujar a las personas por un acantilado sin tocarlas: Karnesis, así como otros poderes, llamados Slabs, como Aether, Telekinesis, Masquerade y teletransporte a corta distancia. Hay una forma de dar fuerza a Colt de forma permanente, pero tendrás que encontrarla tú mismo.\r\n</p>','Arkane Studios','Bethesda Softworks',25,'deathloop','2021-09-14','LAUNCHED','{\r\n  \"OS\": \"64 bit Windows 10\",\r\n  \"Procesador\": \"i7-9700K o Ryzen 7 2700X\",\r\n  \"Memoria\": \"16 GB RAM\",\r\n  \"Gráfica\": \"RTX 2060 o Radeon RX 5700\",\r\n  \"DirectX\": \"Version 12\",\r\n  \"Almacenamiento\": \"30 GB\"\r\n}','{\r\n  \"OS\": \"64 bit Windows 10\",\r\n  \"Procesador\": \"i7-9700K o Ryzen 7 2700X\",\r\n  \"Memoria\": \"16 GB RAM\",\r\n  \"Gráfica\": \"RTX 2060 o Radeon RX 5700\",\r\n  \"DirectX\": \"Version 12\",\r\n  \"Almacenamiento\": \"30 GB\"\r\n}',49.99,50,0.0,18),(5,'<p class=\"desc__text\">\r\n	Grand Theft Auto V es un videojuego de acción y aventura desarrollado por Rockstar North y publicado en 2013 por Rockstar Games. El juego se centra sobre todo en los atracos, persecuciones policiales, tiroteos y el logro de los objetivos, incluso si eso significa infringir la ley de vez en cuando. Premium Online Edition es un paquete conveniente que reúne tanto el juego básico de GTA V como Criminal Enterprise Starter Pack para ayudarte a comenzar y desarrollar tu negocio criminal de modo online mucho más rápido.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Historia\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	La historia de GTA 5 gira en torno a tres personajes jugables: el ladrón retirado - Michael, su compañero de crimen impulsivo y mentalmente desequilibrado - Trevor, y Franklin, que trabajaba como embargador de coches de lujo y con pasado en pandillas. Michael cortó todos los lazos con el pasado y vivió una vida feliz bajo el programa de protección de testigos, pero la paz no duró demasiado, ya que accidentalmente se metió bajo la piel del líder del Cartel de Madrazo. Pagar la deuda de Michael llamó la atención de Trevor, quien decidió reunirse con su viejo amigo.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Gameplay\r\n</h2> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	GTA 5 es un juego de acción y aventura que se juega desde una perspectiva en primera y tercera persona. El juego ofrece un gran mundo abierto para explorar. El mundo vive su propia vida: las carreteras de la ciudad están llenas de automóviles y peatones con los que se puede interactuar. Una gran cantidad de libertad te permite violar fácilmente la ley robando vehículos o atacando a las personas. Eso sí, hacerlo atraerá la atención de la policía local.\r\n</p> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	El juego presenta un ciclo completo de día y noche y ofrece varias actividades paralelas en las que puedes participar sin intervenir en las misiones principales de la historia. Entre las cuales, puedes encontrar jugar golf, tenis, ir al cine o navegar por Internet en el juego.\r\n</p> \r\n','Rockstar North','Rockstar Games',124,'grand_theft_auto_v','2015-04-14','LAUNCHED','{\r\n  \"OS\": \"Windows 7\",\r\n  \"Procesador\": \"Intel Core 2 Q6600 o  AMD Phenom 9850\",\r\n  \"RAM\": \"4GB RAM\",\r\n  \"Almacenamiento\": \"72GB\",\r\n  \"Grafica\": \"Nvidia 9800 GT o AMD HD 4870\",\r\n  \"Tarjeta de sonido\" : \"Compatible con DirectX 10\"\r\n}','{\r\n  \"OS\": \"Windows 7\",\r\n  \"Procesador\": \"Intel Core i5 3470 o  AMD X8 FX-8350\",\r\n  \"RAM\": \"8GB RAM\",\r\n  \"Almacenamiento\": \"72GB\",\r\n  \"Grafica\": \"Nvidia GTX 660 o AMD HD 7870\",\r\n  \"Tarjeta de sonido\" : \"Compatible con DirectX 10\"\r\n}',19.00,0,8.5,18),(6,'<p class=\"desc__text\">\r\n	Sniper Elite 5 es otra entrega de la legendaria serie de juegos de acción, desarrollada y lanzada en 2022 por Rebellion. Esta vez, viajarás a la Francia de 1944 para enfrentarte a una lucha que determinará el destino de la Segunda Guerra Mundial. Se trata de una parte mejorada en la que descubrirás unos gráficos aún mejores y más detallados y un pulido modo multijugador.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title--primary\">\r\n	Historia\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	Karl Fairburne viaja a la costa de Bretaña para unirse a las fuerzas aliadas francesas. Aunque la lucha parece estar igualada al principio, llega a sus manos un proyecto secreto nazi: la Operación Kraken. Parece que los aliados no tienen ninguna posibilidad en esta guerra. ¿Será capaz de acudir en su ayuda?\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title--primary\">\r\n	Jugabilidad\r\n\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	Sniper Elite 5 es un videojuego de disparos realista que se centra en completar misiones en una extensa campaña de aventuras. Ve al campo de batalla y detén al enemigo a toda costa. Para lograrlo, puedes utilizar ataques sorpresa o un rifle de francotirador. Elige el mejor lugar y apunta a tu oponente, sopesando factores como el terreno, el clima y el tipo de arma. Mejora tu rifle como quieras, ajustando nuevos elementos y munición.\r\n\r\n</p> \r\n\r\n<p class=\"desc__text\">\r\n	El videojuego Sniper introducirá varias mejoras, entre ellas una Kill Cam mejorada. Observa tus mejores tareas en cámara lenta para ser testigo de los efectos más exitosos de tus disparos. Aprende de ellos y sé aún mejor. Descubre el extenso modo multijugador, donde podrás jugar en cooperación o en la campaña PvP online. Elige cooperar y compartir el equipo adquirido con el equipo, o únete a la brutal partida en la que todos luchan contra otros jugadores. En Sniper 5, también puedes jugar en el papel de un francotirador alemán para eliminar a los jugadores en sus campañas.\r\n\r\n</p> ','Rebellion','Rebellion',12,'sniper_elite_5','2022-05-26','LAUNCHED','{\r\n   \"Almacenamiento\": \"80.63GB\",\r\n   \"Red\": \"Conexión de red constante\"\r\n }','{\r\n   \"Almacenamiento\": \"80.63GB\",\r\n   \"Red\": \"Conexión de red constante\"\r\n }',60.00,21,0.0,18),(7,'<p class=\"desc__text\">\r\n	Sniper Elite 5 es otra entrega de la legendaria serie de juegos de acción, desarrollada y lanzada en 2022 por Rebellion. Esta vez, viajarás a la Francia de 1944 para enfrentarte a una lucha que determinará el destino de la Segunda Guerra Mundial. Se trata de una parte mejorada en la que descubrirás unos gráficos aún mejores y más detallados y un pulido modo multijugador.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title--primary\">\r\n	Historia\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	Karl Fairburne viaja a la costa de Bretaña para unirse a las fuerzas aliadas francesas. Aunque la lucha parece estar igualada al principio, llega a sus manos un proyecto secreto nazi: la Operación Kraken. Parece que los aliados no tienen ninguna posibilidad en esta guerra. ¿Será capaz de acudir en su ayuda?\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title--primary\">\r\n	Jugabilidad\r\n\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	Sniper Elite 5 es un videojuego de disparos realista que se centra en completar misiones en una extensa campaña de aventuras. Ve al campo de batalla y detén al enemigo a toda costa. Para lograrlo, puedes utilizar ataques sorpresa o un rifle de francotirador. Elige el mejor lugar y apunta a tu oponente, sopesando factores como el terreno, el clima y el tipo de arma. Mejora tu rifle como quieras, ajustando nuevos elementos y munición.\r\n\r\n</p> \r\n\r\n<p class=\"desc__text\">\r\n	El videojuego Sniper introducirá varias mejoras, entre ellas una Kill Cam mejorada. Observa tus mejores tareas en cámara lenta para ser testigo de los efectos más exitosos de tus disparos. Aprende de ellos y sé aún mejor. Descubre el extenso modo multijugador, donde podrás jugar en cooperación o en la campaña PvP online. Elige cooperar y compartir el equipo adquirido con el equipo, o únete a la brutal partida en la que todos luchan contra otros jugadores. En Sniper 5, también puedes jugar en el papel de un francotirador alemán para eliminar a los jugadores en sus campañas.\r\n\r\n</p> ','Rebellion','Rebellion',12,'sniper_elite_5','2022-05-26','LAUNCHED','{\r\n  \"OS\": \"Windows 10\",\r\n  \"Procesador\": \"Intel Core i3-8100\",\r\n  \"RAM\": \"8GB RAM\",\r\n  \"Almacenamiento\": \"85GB\",\r\n  \"Grafica\": \"Nvidia GTX 1660\"\r\n}','{\r\n  \"OS\": \"Windows 10\",\r\n  \"Procesador\": \"Intel Core i5-8400\",\r\n  \"RAM\": \"16GB RAM\",\r\n  \"Almacenamiento\": \"85GB\",\r\n  \"Grafica\": \"Nvidia RTX 2060\"\r\n}',50.00,0,0.0,18),(8,'<p class=\"desc__text\">\r\n	Grand Theft Auto V es un videojuego de acción y aventura desarrollado por Rockstar North y publicado en 2013 por Rockstar Games. El juego se centra sobre todo en los atracos, persecuciones policiales, tiroteos y el logro de los objetivos, incluso si eso significa infringir la ley de vez en cuando. Premium Online Edition es un paquete conveniente que reúne tanto el juego básico de GTA V como Criminal Enterprise Starter Pack para ayudarte a comenzar y desarrollar tu negocio criminal de modo online mucho más rápido.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Historia\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	La historia de GTA 5 gira en torno a tres personajes jugables: el ladrón retirado - Michael, su compañero de crimen impulsivo y mentalmente desequilibrado - Trevor, y Franklin, que trabajaba como embargador de coches de lujo y con pasado en pandillas. Michael cortó todos los lazos con el pasado y vivió una vida feliz bajo el programa de protección de testigos, pero la paz no duró demasiado, ya que accidentalmente se metió bajo la piel del líder del Cartel de Madrazo. Pagar la deuda de Michael llamó la atención de Trevor, quien decidió reunirse con su viejo amigo.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Gameplay\r\n</h2> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	GTA 5 es un juego de acción y aventura que se juega desde una perspectiva en primera y tercera persona. El juego ofrece un gran mundo abierto para explorar. El mundo vive su propia vida: las carreteras de la ciudad están llenas de automóviles y peatones con los que se puede interactuar. Una gran cantidad de libertad te permite violar fácilmente la ley robando vehículos o atacando a las personas. Eso sí, hacerlo atraerá la atención de la policía local.\r\n</p> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	El juego presenta un ciclo completo de día y noche y ofrece varias actividades paralelas en las que puedes participar sin intervenir en las misiones principales de la historia. Entre las cuales, puedes encontrar jugar golf, tenis, ir al cine o navegar por Internet en el juego.\r\n</p> \r\n','Rockstar North','Rockstar Games',124,'grand_theft_auto_v','2015-04-14','LAUNCHED','{\r\n   \"Almacenamiento\": \"72GB\",\r\n   \"Red\": \"Conexión de red en modo online\"\r\n }','{\r\n   \"Almacenamiento\": \"72GB\",\r\n   \"Red\": \"Conexión de red en modo online\"\r\n }',19.00,10,8.2,18),(9,'<p class=\"desc__text\">\r\n	Grand Theft Auto V es un videojuego de acción y aventura desarrollado por Rockstar North y publicado en 2013 por Rockstar Games. El juego se centra sobre todo en los atracos, persecuciones policiales, tiroteos y el logro de los objetivos, incluso si eso significa infringir la ley de vez en cuando. Premium Online Edition es un paquete conveniente que reúne tanto el juego básico de GTA V como Criminal Enterprise Starter Pack para ayudarte a comenzar y desarrollar tu negocio criminal de modo online mucho más rápido.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Historia\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	La historia de GTA 5 gira en torno a tres personajes jugables: el ladrón retirado - Michael, su compañero de crimen impulsivo y mentalmente desequilibrado - Trevor, y Franklin, que trabajaba como embargador de coches de lujo y con pasado en pandillas. Michael cortó todos los lazos con el pasado y vivió una vida feliz bajo el programa de protección de testigos, pero la paz no duró demasiado, ya que accidentalmente se metió bajo la piel del líder del Cartel de Madrazo. Pagar la deuda de Michael llamó la atención de Trevor, quien decidió reunirse con su viejo amigo.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Gameplay\r\n</h2> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	GTA 5 es un juego de acción y aventura que se juega desde una perspectiva en primera y tercera persona. El juego ofrece un gran mundo abierto para explorar. El mundo vive su propia vida: las carreteras de la ciudad están llenas de automóviles y peatones con los que se puede interactuar. Una gran cantidad de libertad te permite violar fácilmente la ley robando vehículos o atacando a las personas. Eso sí, hacerlo atraerá la atención de la policía local.\r\n</p> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	El juego presenta un ciclo completo de día y noche y ofrece varias actividades paralelas en las que puedes participar sin intervenir en las misiones principales de la historia. Entre las cuales, puedes encontrar jugar golf, tenis, ir al cine o navegar por Internet en el juego.\r\n</p> \r\n','Rockstar North','Rockstar Games',17,'grand_theft_auto_v','2015-04-14','LAUNCHED','{\r\n   \"Almacenamiento\": \"70GB\",\r\n   \"Red\": \"Conexión de red en modo online\"\r\n }','{\r\n   \"Almacenamiento\": \"70GB\",\r\n   \"Red\": \"Conexión de red en modo online\"\r\n }',9.95,0,9.0,18);
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_keys`
--

LOCK TABLES `game_keys` WRITE;
/*!40000 ALTER TABLE `game_keys` DISABLE KEYS */;
INSERT INTO `game_keys` VALUES (1,1,1,6,'ER99IO5BE3Q9QFR'),(5,1,1,NULL,'6KI8C2NLO469PTK'),(6,1,1,NULL,'DE9JO489N96I434'),(7,1,1,NULL,'1RPI39H758E5CNR');
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `games`
--

LOCK TABLES `games` WRITE;
/*!40000 ALTER TABLE `games` DISABLE KEYS */;
INSERT INTO `games` VALUES (1,'Minecraft: Java Edition','minecraft_java_edition'),(2,'Bioshock: The Collection','bioshock_the_collection'),(3,'DEATHLOOP ','deathloop'),(4,'Grand Theft Auto V','grand_theft_auto_v'),(5,'Escape From Tarkov','escape_from_tarkov'),(6,'Sniper Elite 5','sniper_elite_5'),(7,'No Man´s Sky','no_mans_sky'),(8,'Bully Scholarship Edition','bully_scholarship_edition'),(9,'Dying Light','dying_light'),(10,'Cyberpunk 2077','cyberpunk_2077'),(11,'Assassin`s Creed Odyssey','assassins_creed_odyssey'),(12,'Dune: Spice Wars','dune_spice_wars');
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
INSERT INTO `games_platform` VALUES (1,1,1),(2,2,2),(3,3,3),(6,3,4),(3,4,5),(5,6,6),(3,6,7),(6,4,8),(5,4,9);
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
  `media_url` varchar(100) NOT NULL,
  `media_alt` varchar(100) NOT NULL,
  `media_InfoImg` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_media`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media`
--

LOCK TABLES `media` WRITE;
/*!40000 ALTER TABLE `media` DISABLE KEYS */;
INSERT INTO `media` VALUES (1,'minecraft','Imagen del videojuego minecraft',0),(2,'minecraft2','Imagen del videojuego Minecraft',0),(3,'minecraft3','Imagen del videojuego Minecraft',0),(4,'minecraft4','Imagen del videojuego Minecraft',0),(5,'minecraftInfo','Imagen del videojuego Minecraft',1),(6,'bioshokCollectionInfo','Portada del videojuego bioshock',1),(7,'bioshock','Imagen del videojuego Bioshock',0),(8,'bioshock2','Imagen del videojuego Bioshock',0),(9,'bioshock3','Imagen del videojuego Bioshock',0),(10,'bioshock4','Imagen del videojuego Bioshock',0),(11,'bioshock5','Imagen del videojuego Bioshock',0),(12,'deathloop','Imagen del videojuego Deathloop',0),(13,'deathloop2','Imagen del videojuego Deathloop',0),(14,'deathloop3','Imagen del videojuego Deathloop',0),(15,'deathloop4','Imagen del videojuego Deathloop',0),(16,'deathloop5','Imagen del videojuego Deathloop',0),(17,'deathloop6','Imagen del videojuego Deathloop',0),(18,'deathloopInfo','Imagen del videojuego Deathloop',1),(19,'gtav','Imagen del videojuego GTA V',0),(21,'gtav2','Imagen del videojuego GTA V',0),(23,'gtav3','Imagen del videojuego GTA V',0),(25,'gtav4','Imagen del videojuego GTA V',0),(27,'gtav5','Imagen del videojuego GTA V',0),(29,'gtav6','Imagen del videojuego GTA V',0),(31,'gtavInfo','Imagen del videojuego GTA V',1),(32,'sniperElite5','Imagen del videojuego Sniper Elite 5',0),(34,'sniperElite5_2','Imagen del videojuego Sniper Elite 5',0),(36,'sniperElite5_3','Imagen del videojuego Sniper Elite 5',0),(38,'sniperElite5_4','Imagen del videojuego Sniper Elite 5',0),(40,'sniperElite5_5','Imagen del videojuego Sniper Elite 5',0),(42,'sniperElite5_6','Imagen del videojuego Sniper Elite 5',0),(44,'sniperElite5Info','Imagen del videojuego Sniper Elite 5',1);
/*!40000 ALTER TABLE `media` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `media_games`
--

DROP TABLE IF EXISTS `media_games`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `media_games` (
  `id_media` int(10) unsigned NOT NULL,
  `id_game` int(10) unsigned NOT NULL,
  `id_platform` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_media`,`id_game`,`id_platform`),
  KEY `FK24` (`id_platform`),
  KEY `FK25` (`id_game`),
  CONSTRAINT `FK23` FOREIGN KEY (`id_media`) REFERENCES `media` (`id_media`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK24` FOREIGN KEY (`id_platform`) REFERENCES `platforms` (`id_platform`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `FK25` FOREIGN KEY (`id_game`) REFERENCES `games` (`id_game`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `media_games`
--

LOCK TABLES `media_games` WRITE;
/*!40000 ALTER TABLE `media_games` DISABLE KEYS */;
INSERT INTO `media_games` VALUES (1,1,1),(2,1,1),(3,1,1),(4,1,1),(5,1,1),(6,2,2),(7,2,2),(8,2,2),(9,2,2),(10,2,2),(11,2,2),(12,3,3),(12,3,6),(13,3,3),(13,3,6),(14,3,3),(14,3,6),(15,3,3),(15,3,6),(16,3,3),(16,3,6),(17,3,3),(17,3,6),(18,3,3),(18,3,6),(19,4,3),(19,4,5),(19,4,6),(21,4,3),(21,4,5),(21,4,6),(23,4,3),(23,4,5),(23,4,6),(25,4,3),(25,4,5),(25,4,6),(27,4,3),(27,4,5),(27,4,6),(29,4,3),(29,4,5),(29,4,6),(31,4,3),(31,4,5),(31,4,6),(32,6,3),(32,6,5),(34,6,3),(34,6,5),(36,6,3),(36,6,5),(38,6,3),(38,6,5),(40,6,3),(40,6,5),(42,6,3),(42,6,5),(44,6,3),(44,6,5);
/*!40000 ALTER TABLE `media_games` ENABLE KEYS */;
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
  `id_cart` int(10) unsigned NOT NULL,
  `id_card` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_order`),
  KEY `FK2` (`id_user`),
  KEY `FK3` (`id_billing`),
  KEY `FK27` (`id_cart`),
  KEY `FK34` (`id_card`),
  CONSTRAINT `FK2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE,
  CONSTRAINT `FK27` FOREIGN KEY (`id_cart`) REFERENCES `cart` (`id_cart`) ON UPDATE CASCADE,
  CONSTRAINT `FK3` FOREIGN KEY (`id_billing`) REFERENCES `billing` (`id_billing`) ON UPDATE CASCADE,
  CONSTRAINT `FK34` FOREIGN KEY (`id_card`) REFERENCES `card` (`id_card`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (6,1,'2022-06-02',19.95,1,14,1);
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `platforms`
--

LOCK TABLES `platforms` WRITE;
/*!40000 ALTER TABLE `platforms` DISABLE KEYS */;
INSERT INTO `platforms` VALUES (1,'windows'),(2,'switch'),(3,'steam'),(4,'ubisoft'),(5,'playstation'),(6,'xbox');
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Usuario 1','usuario1@gmail.com','$2y$13$ZWPufYV41vuE4fkPue.A6.Ks.9K64rOFfDlrTjIP3fkADex3cmthe','default','ROLE_USER','ACTIVE',1),(2,'Usuario 2','usuario2@gmail.com','$2a$10$rtRzzL0PtMXebGJjlQTpbuLWNSpdfyjYjLIu8P.s95UcbMNghSfDi','default','ROLE_USER','ACTIVE',2),(3,'Usuario 3','usuario3@gmail.com','$2a$10$RBTzjNTPCn6AelYEaGYcRu/PKadqFXczCyorGbNOSNQGhs6H6uRa.','default','ROLE_USER','ACTIVE',3),(4,'Usuario 4','usuario4@gmail.com','$2a$10$Y8lklhtnC7Ca9/Um8xLR6uqQUehBdh3qFkLayAHwf7FCAltETI1hm','default','ROLE_USER','ACTIVE',4),(5,'Usuario 5','usuario5@gmail.com',' $2a$10$JBQktfx3fF17/ZSs9iGhUe/VOZcXpiYCF9GY4cXxbAhw6gxEOkvH','default','ROLE_USER','ACTIVE',5),(6,'Usuario 6','usuario6@gmail.com',' $2a$10$5yLnm6EsTPQ0DtoHINa.FuH8M6PxRchhle2KbT.giS5QVHvS6UN2','default','ROLE_USER','ACTIVE',6),(7,'Usuario 7','usuario7@gmail.com',' $2a$10$cVRvLqM0eGR45kYXIWm/SeBGv29mPKmFv0GIAJoaiazWpmyb7R5a','default','ROLE_USER','ACTIVE',7),(8,'Usuario 8','usuario8@gmail.com',' $2a$10$E139RnijNmvzLRuIDDTFmeGA/cT69NWfdxbno6nXMBv470GjcLnI','default','ROLE_USER','ACTIVE',8),(9,'registro','registro@gmail.com','$2y$13$f2XP065Sh3.Vpld1M1O8PucTIlsFo6wt5T9jCGygsBpmAZJbCPBEm','default','ROLE_USER','ACTIVE',9),(10,'pruebaRegistro','pruebaregistro@gmail.com','$2y$13$WMWDtr.PgDhino9XoXDGVe18CpPXR2PY74fglPakZ4rW3WhnKxTtm','default','ROLE_USER','ACTIVE',10),(11,'prueba2','prueba2@gmail.com','$2y$13$QrOv8jP/jbMKEiiXgrV09epUuxXc9vILd4bGzSu9PeJ8dFdUlGGTy','default','','',11),(12,'prueba3','prueba3@gmail.com','$2y$13$bxzyaaIhsOyvA9L9whB0Fuf03JOoj4NDNl3DRakV.l7UNyW7LA4zC','default','','',12),(13,'prueba4','prueba4@gmail.com','$2y$13$7rjR1LENH8hoPCiqWhCk7uNLBE2nNC7bGAgWAy6fO/Aa0b8sGGwgK','default','ROLE_USER','ACTIVE',13),(14,'prueba5','prueba5@gmail.com','$2y$13$IXnsJErSNNt1A2HP2oU4Ouj8gfJL3PJUbd7Ajnp4dhQHHyy.NC3Hm','\'default\'','','',15),(15,'prueba6','prueba6@gmail.com','$2y$13$/618bAQK4RebmKfC4INzfewzKfN7NnRJdIVXstaCUB7BOVJtyrYB6','default','ROLE_USER','ACTIVE',16),(16,'prueba7','prueba7@gmail.com','$2y$13$UjEp9CY9JciwrsDmPP2xDejqGHI3KWr5WPX0xhumiir9zMX6k.lFW','default','ROLE_USER','ACTIVE',17),(17,'prueba8','prueba8@gmail.com','$2y$13$12D9Tg9lRPeFDbwcqC5WP.WlYFEgHMxqODGSvG6BdWdBLN9Ib91aS','default','ROLE_USER','ACTIVE',18),(18,'12345','usuario1@gamil.com','$2y$13$/sps0OxO9ta0neudIqegxuCoyWWCdZP6gInp9UVj6KPvPmkWleIdK','default','ROLE_USER','ACTIVE',19),(20,'usuario19','usuario19@gmail.com','$2y$13$Ol17E8hys9j/apj1hnTE6OVvc6PC37JGhKlng3rKrAhhpqMKgUv3K','default','ROLE_USER','ACTIVE',21);
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
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wishlist`
--

LOCK TABLES `wishlist` WRITE;
/*!40000 ALTER TABLE `wishlist` DISABLE KEYS */;
INSERT INTO `wishlist` VALUES (1),(2),(3),(4),(5),(6),(7),(8),(9),(10),(11),(12),(13),(15),(16),(17),(18),(19),(21);
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

-- Dump completed on 2022-06-02 17:02:16
