-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-06-2022 a las 01:35:51
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `cheapkeys`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `billing`
--

CREATE TABLE `billing` (
  `id_billing` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `billing_name` text NOT NULL,
  `billing_state` tinyint(1) NOT NULL DEFAULT 1,
  `billing_direction` varchar(150) NOT NULL,
  `billing_postal` varchar(5) NOT NULL,
  `billing_poblation` varchar(100) NOT NULL,
  `billing_country` varchar(100) NOT NULL,
  `billing_province` varchar(100) NOT NULL,
  `billin_tlfo` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `card`
--

CREATE TABLE `card` (
  `id_card` int(10) UNSIGNED NOT NULL,
  `card_number` varchar(19) NOT NULL,
  `card_cvv` varchar(3) NOT NULL,
  `card__expire` text NOT NULL,
  `card_name` varchar(100) NOT NULL,
  `card_user` int(10) UNSIGNED NOT NULL,
  `card_state` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart`
--

CREATE TABLE `cart` (
  `id_cart` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `cart_total` decimal(5,2) NOT NULL DEFAULT 0.00,
  `cart_state` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cart`
--

INSERT INTO `cart` (`id_cart`, `id_user`, `cart_total`, `cart_state`) VALUES
(1, 1, '0.00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart_products`
--

CREATE TABLE `cart_products` (
  `id_cart` int(10) UNSIGNED NOT NULL,
  `id_game` int(11) UNSIGNED NOT NULL,
  `id_platform` int(10) UNSIGNED NOT NULL,
  `cant` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `price` float(5,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `features`
--

CREATE TABLE `features` (
  `id_feature` int(10) UNSIGNED NOT NULL,
  `game_desc` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `game_developer` varchar(100) NOT NULL,
  `game_distributor` varchar(100) NOT NULL,
  `game_stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `game_slug` text NOT NULL,
  `game_date` date NOT NULL,
  `game_state` enum('LAUNCHED','RESERVE') NOT NULL,
  `min_req` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`min_req`)),
  `max_req` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`max_req`)),
  `game_price` decimal(5,2) UNSIGNED NOT NULL,
  `game_discount` int(3) UNSIGNED NOT NULL DEFAULT 0,
  `game_valoration` decimal(2,1) UNSIGNED NOT NULL,
  `game_pegi` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `features`
--

INSERT INTO `features` (`id_feature`, `game_desc`, `game_developer`, `game_distributor`, `game_stock`, `game_slug`, `game_date`, `game_state`, `min_req`, `max_req`, `game_price`, `game_discount`, `game_valoration`, `game_pegi`) VALUES
(1, '<p class=\"desc__text\">\r\n    Minecraft es un juego de aventuras sandbox, desarrollado y publicado por Mojang. En el juego, la tarea del jugador\r\n    es crear construcciones a partir de varios tipos de materiales que tienen que extraer en un entorno de mundo\r\n    abierto. Los jugadores de Minecraft pueden participar en varios modos de juego, incluido el modo Supervivencia,\r\n    Creativo y Aventura. El juego también ofrece un modo multijugador, donde los jugadores pueden cooperar en la obra de\r\n    construcciones o competir entre sí en el modo PvP. Minecraft para Xbox One recibió críticas favorables de los\r\n    críticos y se ha convertido en un fenómeno cultural con millones de fanáticos dedicados.\r\n</p>\r\n\r\n<h3 class=\"desc__title\">\r\n    Construye el mundo de tus sueños\r\n</h3>\r\n\r\n<p class=\"desc__text\">\r\n    El jugador inicia un juego de Minecraft en un entorno abierto generado por procedimientos, que consta de bosques,\r\n    llanuras, colinas y otras áreas. Su trabajo consiste en utilizar cualquier material que pueda encontrar para\r\n    edificar construcciones. Los materiales del juego aparecen en forma de bloques, a partir de los cuales el jugador\r\n    puede construir. Cada tipo de bloques tiene propiedades diferentes y puede ser utilizado para diferentes propósitos.\r\n    El jugador puede visitar otros planos, Nether y The End, donde puede encontrar recursos y elementos exclusivos.\r\n    Explorando el mundo de Minecraft, el jugador puede encontrar varias criaturas: desde animales, que pueden ser\r\n    cazados para conseguir comida y materiales de artesanía, hasta monstruos peligrosos, como enredaderas que comen\r\n    bloques.\r\n</p>', 'Mojang', 'Xbox Games Studios', 0, 'minecraft_java_edition', '2011-11-18', 'LAUNCHED', '{\r\n  \"OS\": \"Windows 7\",\r\n  \"Procesador\": \"Intel Core i3-3210 3.2 GHz\",\r\n  \"RAM\": \"2GB RAM\",\r\n  \"Almacenamiento\": \"4GB\",\r\n  \"Grafica\": \"Nvidia GeForce 400 Series\"\r\n}', '{\r\n  \"OS\": \"Windows 10\",\r\n  \"Procesador\": \"Intel Core i5-4690 3.5GHz \",\r\n  \"RAM\": \"4GB RAM\",\r\n  \"Almacenamiento\": \"4GB\",\r\n  \"Grafica\": \"GeForce 700 Series \"\r\n}', '19.95', 0, '7.3', 3),
(2, ' <p class=\"desc__text\">\r\n    Lanzado en 2016, Bioshock: The Collection es la combinación definitiva de los tres títulos de Bioshock, junto con sus DLC. Reunidos en un solo paquete, cada uno de los juegos se ha renovado significativamente y cuenta con gráficos mejorados, con mayor resolución y efectos visuales mejorados.\r\n</p>\r\n<p class=\"desc__text\">\r\n    Gloriosamente remasterizado en 1080p. BioShock: The Collection incluye todo el contenido para un jugador de BioShock, BioShock 2 y BioShock Infinite, junto con todos los DLC, como el pack Columbia\'s Finest o las dos partes del DLC de la historia Burial at Sea. Ahora puedes disfrutar del mítico FPS con elementos de RPG en una resolución de 1920x1080 a 60 fps.\r\n</p>\r\n<h3 class=\"desc__title\">\r\n    Disfruta del juego con la mejor calidad\r\n</h3>\r\n<p class=\"desc__text\">\r\n   La trilogía de BioShock comienza con Bioshock. Como náufrago de un avión siniestrado, entras en un faro, que resulta ser la entrada a la ciudad submarina de Rapture. Concebida como una utopía, la vida en Rapture debía transcurrir sin la molestia de ningún dolor terrenal. Y así fue, hasta el descubrimiento de ADAM, una sustancia que proporciona habilidades sobrehumanas. Esto resultó ser el principio del fin de la utopía de Rapture.\r\n</p>\r\n<h3 class=\"desc__title\">\r\n    De vuelta al principio: BioShock\r\n</h3>\r\n<p class=\"desc__text\">\r\n     Las tensiones sociales provocaron conflictos entre facciones. Ahora Rapture es una ciudad colapsada, capturada por locos mutantes que habitan en las ruinas. La única forma de sobrevivir allí en este momento es usar ADAM. Conseguirlo, sin embargo, conlleva retos extremadamente peligrosos. Cargado con todo un arsenal de armas, exploras las ruinas submarinas enfrentándote a innumerables obstáculos en tu camino. Desde robot y mutantes, hasta Little Sisters y sus Big Daddies, te encontrarás con decenas de enemigos en tu camino. Prepárate para modificar tu ADN, ya que puede proporcionarte herramientas aún más mortíferas.\r\n</p>', '2K Boston', '2K', 0, 'bioshock_the_collection', '2020-05-29', 'LAUNCHED', '{\r\n   \"Almacenamiento\": \"20.7GB\",\r\n   \"Red\": \"Conexión de red constante\"\r\n }', '{\r\n   \"Almacenamiento\": \"20.7GB\",\r\n   \"Red\": \"Conexión de red constante\"\r\n }', '22.65', 25, '0.0', 18),
(3, '<p class=\"desc__text\">\r\n    En Deathloop asumes el papel de un asesino, llamado Colt, al que le toca vivir en una fiesta perpetua en el fin del mundo. El juego está ambientado en la isla de Blackreef, que se basa en las Islas Feroe en los años 60, donde los isleños se divierten toda la noche, reiniciando a la medianoche al día anterior. Esto significa que pueden hacer lo que quieran, porque no lo recordarán ¡Y estarán bien!.\r\n</p>\r\n<p class=\"desc__text\">\r\n    Sin embargo, Colt puede y quiere recordar, y es su misión terminar la fiesta de una vez por todas. La isla solía ser una base militar experimental, con una misión ultra secreta llamada AEON, que fue diseñada para perseguir la inmortalidad. Pero el ejército se fue hace mucho y los habitantes han invertido mucho tiempo en la isla, disfrutando de una existencia despreocupada de las mismas 24 horas una y otra vez.\r\n</p>\r\n<h3 class=\"desc__title\">\r\n    Información adicional\r\n</h3>\r\n<p class=\"desc__text\">\r\n   Los desarrolladores del juego lo describen como \'Cluedo invertido\' y el nombre es bueno. Debes resolver e implementar cómo cometer ocho asesinatos perfectos. Sin embargo, no todo va contra Colt, porque además de las armas, tiene poderes sobrenaturales, con los que puede empujar a las personas por un acantilado sin tocarlas: Karnesis, así como otros poderes, llamados Slabs, como Aether, Telekinesis, Masquerade y teletransporte a corta distancia. Hay una forma de dar fuerza a Colt de forma permanente, pero tendrás que encontrarla tú mismo.\r\n</p>', 'Arkane Studios', 'Bethesda Softworks', 55, 'deathloop', '2021-11-14', 'LAUNCHED', '{\r\n  \"OS\": \"64 bit Windows 10\",\r\n  \"Procesador\": \"i5-8400 o Ryzen 5 1600\",\r\n  \"Memoria\": \"12 GB RAM\",\r\n  \"Gráfica\": \"GTX 1060 o Radeon RX 580\",\r\n  \"DirectX\": \"Version 12\",\r\n  \"Almacenamiento\": \"30 GB\"\r\n}', '{\r\n  \"OS\": \"64 bit Windows 10\",\r\n  \"Procesador\": \"i7-9700K o Ryzen 7 2700X\",\r\n  \"Memoria\": \"16 GB RAM\",\r\n  \"Gráfica\": \"RTX 2060 o Radeon RX 5700\",\r\n  \"DirectX\": \"Version 12\",\r\n  \"Almacenamiento\": \"30 GB\"\r\n}', '49.99', 0, '5.0', 18),
(4, '<p class=\"desc__text\">\r\n    En Deathloop asumes el papel de un asesino, llamado Colt, al que le toca vivir en una fiesta perpetua en el fin del mundo. El juego está ambientado en la isla de Blackreef, que se basa en las Islas Feroe en los años 60, donde los isleños se divierten toda la noche, reiniciando a la medianoche al día anterior. Esto significa que pueden hacer lo que quieran, porque no lo recordarán ¡Y estarán bien!.\r\n</p>\r\n<p class=\"desc__text\">\r\n    Sin embargo, Colt puede y quiere recordar, y es su misión terminar la fiesta de una vez por todas. La isla solía ser una base militar experimental, con una misión ultra secreta llamada AEON, que fue diseñada para perseguir la inmortalidad. Pero el ejército se fue hace mucho y los habitantes han invertido mucho tiempo en la isla, disfrutando de una existencia despreocupada de las mismas 24 horas una y otra vez.\r\n</p>\r\n<h3 class=\"desc__title\">\r\n    Información adicional\r\n</h3>\r\n<p class=\"desc__text\">\r\n   Los desarrolladores del juego lo describen como \'Cluedo invertido\' y el nombre es bueno. Debes resolver e implementar cómo cometer ocho asesinatos perfectos. Sin embargo, no todo va contra Colt, porque además de las armas, tiene poderes sobrenaturales, con los que puede empujar a las personas por un acantilado sin tocarlas: Karnesis, así como otros poderes, llamados Slabs, como Aether, Telekinesis, Masquerade y teletransporte a corta distancia. Hay una forma de dar fuerza a Colt de forma permanente, pero tendrás que encontrarla tú mismo.\r\n</p>', 'Arkane Studios', 'Bethesda Softworks', 25, 'deathloop', '2021-09-14', 'LAUNCHED', '{\r\n  \"OS\": \"64 bit Windows 10\",\r\n  \"Procesador\": \"i7-9700K o Ryzen 7 2700X\",\r\n  \"Memoria\": \"16 GB RAM\",\r\n  \"Gráfica\": \"RTX 2060 o Radeon RX 5700\",\r\n  \"DirectX\": \"Version 12\",\r\n  \"Almacenamiento\": \"30 GB\"\r\n}', '{\r\n  \"OS\": \"64 bit Windows 10\",\r\n  \"Procesador\": \"i7-9700K o Ryzen 7 2700X\",\r\n  \"Memoria\": \"16 GB RAM\",\r\n  \"Gráfica\": \"RTX 2060 o Radeon RX 5700\",\r\n  \"DirectX\": \"Version 12\",\r\n  \"Almacenamiento\": \"30 GB\"\r\n}', '49.99', 50, '0.0', 18),
(5, '<p class=\"desc__text\">\r\n	Grand Theft Auto V es un videojuego de acción y aventura desarrollado por Rockstar North y publicado en 2013 por Rockstar Games. El juego se centra sobre todo en los atracos, persecuciones policiales, tiroteos y el logro de los objetivos, incluso si eso significa infringir la ley de vez en cuando. Premium Online Edition es un paquete conveniente que reúne tanto el juego básico de GTA V como Criminal Enterprise Starter Pack para ayudarte a comenzar y desarrollar tu negocio criminal de modo online mucho más rápido.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Historia\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	La historia de GTA 5 gira en torno a tres personajes jugables: el ladrón retirado - Michael, su compañero de crimen impulsivo y mentalmente desequilibrado - Trevor, y Franklin, que trabajaba como embargador de coches de lujo y con pasado en pandillas. Michael cortó todos los lazos con el pasado y vivió una vida feliz bajo el programa de protección de testigos, pero la paz no duró demasiado, ya que accidentalmente se metió bajo la piel del líder del Cartel de Madrazo. Pagar la deuda de Michael llamó la atención de Trevor, quien decidió reunirse con su viejo amigo.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Gameplay\r\n</h2> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	GTA 5 es un juego de acción y aventura que se juega desde una perspectiva en primera y tercera persona. El juego ofrece un gran mundo abierto para explorar. El mundo vive su propia vida: las carreteras de la ciudad están llenas de automóviles y peatones con los que se puede interactuar. Una gran cantidad de libertad te permite violar fácilmente la ley robando vehículos o atacando a las personas. Eso sí, hacerlo atraerá la atención de la policía local.\r\n</p> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	El juego presenta un ciclo completo de día y noche y ofrece varias actividades paralelas en las que puedes participar sin intervenir en las misiones principales de la historia. Entre las cuales, puedes encontrar jugar golf, tenis, ir al cine o navegar por Internet en el juego.\r\n</p> \r\n', 'Rockstar North', 'Rockstar Games', 124, 'grand_theft_auto_v', '2015-04-14', 'LAUNCHED', '{\r\n  \"OS\": \"Windows 7\",\r\n  \"Procesador\": \"Intel Core 2 Q6600 o  AMD Phenom 9850\",\r\n  \"RAM\": \"4GB RAM\",\r\n  \"Almacenamiento\": \"72GB\",\r\n  \"Grafica\": \"Nvidia 9800 GT o AMD HD 4870\",\r\n  \"Tarjeta de sonido\" : \"Compatible con DirectX 10\"\r\n}', '{\r\n  \"OS\": \"Windows 7\",\r\n  \"Procesador\": \"Intel Core i5 3470 o  AMD X8 FX-8350\",\r\n  \"RAM\": \"8GB RAM\",\r\n  \"Almacenamiento\": \"72GB\",\r\n  \"Grafica\": \"Nvidia GTX 660 o AMD HD 7870\",\r\n  \"Tarjeta de sonido\" : \"Compatible con DirectX 10\"\r\n}', '19.00', 0, '8.5', 18),
(6, '<p class=\"desc__text\">\r\n	Sniper Elite 5 es otra entrega de la legendaria serie de juegos de acción, desarrollada y lanzada en 2022 por Rebellion. Esta vez, viajarás a la Francia de 1944 para enfrentarte a una lucha que determinará el destino de la Segunda Guerra Mundial. Se trata de una parte mejorada en la que descubrirás unos gráficos aún mejores y más detallados y un pulido modo multijugador.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title--primary\">\r\n	Historia\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	Karl Fairburne viaja a la costa de Bretaña para unirse a las fuerzas aliadas francesas. Aunque la lucha parece estar igualada al principio, llega a sus manos un proyecto secreto nazi: la Operación Kraken. Parece que los aliados no tienen ninguna posibilidad en esta guerra. ¿Será capaz de acudir en su ayuda?\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title--primary\">\r\n	Jugabilidad\r\n\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	Sniper Elite 5 es un videojuego de disparos realista que se centra en completar misiones en una extensa campaña de aventuras. Ve al campo de batalla y detén al enemigo a toda costa. Para lograrlo, puedes utilizar ataques sorpresa o un rifle de francotirador. Elige el mejor lugar y apunta a tu oponente, sopesando factores como el terreno, el clima y el tipo de arma. Mejora tu rifle como quieras, ajustando nuevos elementos y munición.\r\n\r\n</p> \r\n\r\n<p class=\"desc__text\">\r\n	El videojuego Sniper introducirá varias mejoras, entre ellas una Kill Cam mejorada. Observa tus mejores tareas en cámara lenta para ser testigo de los efectos más exitosos de tus disparos. Aprende de ellos y sé aún mejor. Descubre el extenso modo multijugador, donde podrás jugar en cooperación o en la campaña PvP online. Elige cooperar y compartir el equipo adquirido con el equipo, o únete a la brutal partida en la que todos luchan contra otros jugadores. En Sniper 5, también puedes jugar en el papel de un francotirador alemán para eliminar a los jugadores en sus campañas.\r\n\r\n</p> ', 'Rebellion', 'Rebellion', 10, 'sniper_elite_5', '2022-05-26', 'LAUNCHED', '{\r\n   \"Almacenamiento\": \"80.63GB\",\r\n   \"Red\": \"Conexión de red constante\"\r\n }', '{\r\n   \"Almacenamiento\": \"80.63GB\",\r\n   \"Red\": \"Conexión de red constante\"\r\n }', '60.00', 21, '0.0', 18),
(7, '<p class=\"desc__text\">\r\n	Sniper Elite 5 es otra entrega de la legendaria serie de juegos de acción, desarrollada y lanzada en 2022 por Rebellion. Esta vez, viajarás a la Francia de 1944 para enfrentarte a una lucha que determinará el destino de la Segunda Guerra Mundial. Se trata de una parte mejorada en la que descubrirás unos gráficos aún mejores y más detallados y un pulido modo multijugador.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title--primary\">\r\n	Historia\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	Karl Fairburne viaja a la costa de Bretaña para unirse a las fuerzas aliadas francesas. Aunque la lucha parece estar igualada al principio, llega a sus manos un proyecto secreto nazi: la Operación Kraken. Parece que los aliados no tienen ninguna posibilidad en esta guerra. ¿Será capaz de acudir en su ayuda?\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title--primary\">\r\n	Jugabilidad\r\n\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	Sniper Elite 5 es un videojuego de disparos realista que se centra en completar misiones en una extensa campaña de aventuras. Ve al campo de batalla y detén al enemigo a toda costa. Para lograrlo, puedes utilizar ataques sorpresa o un rifle de francotirador. Elige el mejor lugar y apunta a tu oponente, sopesando factores como el terreno, el clima y el tipo de arma. Mejora tu rifle como quieras, ajustando nuevos elementos y munición.\r\n\r\n</p> \r\n\r\n<p class=\"desc__text\">\r\n	El videojuego Sniper introducirá varias mejoras, entre ellas una Kill Cam mejorada. Observa tus mejores tareas en cámara lenta para ser testigo de los efectos más exitosos de tus disparos. Aprende de ellos y sé aún mejor. Descubre el extenso modo multijugador, donde podrás jugar en cooperación o en la campaña PvP online. Elige cooperar y compartir el equipo adquirido con el equipo, o únete a la brutal partida en la que todos luchan contra otros jugadores. En Sniper 5, también puedes jugar en el papel de un francotirador alemán para eliminar a los jugadores en sus campañas.\r\n\r\n</p> ', 'Rebellion', 'Rebellion', 12, 'sniper_elite_5', '2022-05-26', 'LAUNCHED', '{\r\n  \"OS\": \"Windows 10\",\r\n  \"Procesador\": \"Intel Core i3-8100\",\r\n  \"RAM\": \"8GB RAM\",\r\n  \"Almacenamiento\": \"85GB\",\r\n  \"Grafica\": \"Nvidia GTX 1660\"\r\n}', '{\r\n  \"OS\": \"Windows 10\",\r\n  \"Procesador\": \"Intel Core i5-8400\",\r\n  \"RAM\": \"16GB RAM\",\r\n  \"Almacenamiento\": \"85GB\",\r\n  \"Grafica\": \"Nvidia RTX 2060\"\r\n}', '50.00', 0, '0.0', 18),
(8, '<p class=\"desc__text\">\r\n	Grand Theft Auto V es un videojuego de acción y aventura desarrollado por Rockstar North y publicado en 2013 por Rockstar Games. El juego se centra sobre todo en los atracos, persecuciones policiales, tiroteos y el logro de los objetivos, incluso si eso significa infringir la ley de vez en cuando. Premium Online Edition es un paquete conveniente que reúne tanto el juego básico de GTA V como Criminal Enterprise Starter Pack para ayudarte a comenzar y desarrollar tu negocio criminal de modo online mucho más rápido.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Historia\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	La historia de GTA 5 gira en torno a tres personajes jugables: el ladrón retirado - Michael, su compañero de crimen impulsivo y mentalmente desequilibrado - Trevor, y Franklin, que trabajaba como embargador de coches de lujo y con pasado en pandillas. Michael cortó todos los lazos con el pasado y vivió una vida feliz bajo el programa de protección de testigos, pero la paz no duró demasiado, ya que accidentalmente se metió bajo la piel del líder del Cartel de Madrazo. Pagar la deuda de Michael llamó la atención de Trevor, quien decidió reunirse con su viejo amigo.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Gameplay\r\n</h2> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	GTA 5 es un juego de acción y aventura que se juega desde una perspectiva en primera y tercera persona. El juego ofrece un gran mundo abierto para explorar. El mundo vive su propia vida: las carreteras de la ciudad están llenas de automóviles y peatones con los que se puede interactuar. Una gran cantidad de libertad te permite violar fácilmente la ley robando vehículos o atacando a las personas. Eso sí, hacerlo atraerá la atención de la policía local.\r\n</p> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	El juego presenta un ciclo completo de día y noche y ofrece varias actividades paralelas en las que puedes participar sin intervenir en las misiones principales de la historia. Entre las cuales, puedes encontrar jugar golf, tenis, ir al cine o navegar por Internet en el juego.\r\n</p> \r\n', 'Rockstar North', 'Rockstar Games', 124, 'grand_theft_auto_v', '2015-04-14', 'LAUNCHED', '{\r\n   \"Almacenamiento\": \"72GB\",\r\n   \"Red\": \"Conexión de red en modo online\"\r\n }', '{\r\n   \"Almacenamiento\": \"72GB\",\r\n   \"Red\": \"Conexión de red en modo online\"\r\n }', '19.00', 10, '8.2', 18),
(9, '<p class=\"desc__text\">\r\n	Grand Theft Auto V es un videojuego de acción y aventura desarrollado por Rockstar North y publicado en 2013 por Rockstar Games. El juego se centra sobre todo en los atracos, persecuciones policiales, tiroteos y el logro de los objetivos, incluso si eso significa infringir la ley de vez en cuando. Premium Online Edition es un paquete conveniente que reúne tanto el juego básico de GTA V como Criminal Enterprise Starter Pack para ayudarte a comenzar y desarrollar tu negocio criminal de modo online mucho más rápido.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Historia\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	La historia de GTA 5 gira en torno a tres personajes jugables: el ladrón retirado - Michael, su compañero de crimen impulsivo y mentalmente desequilibrado - Trevor, y Franklin, que trabajaba como embargador de coches de lujo y con pasado en pandillas. Michael cortó todos los lazos con el pasado y vivió una vida feliz bajo el programa de protección de testigos, pero la paz no duró demasiado, ya que accidentalmente se metió bajo la piel del líder del Cartel de Madrazo. Pagar la deuda de Michael llamó la atención de Trevor, quien decidió reunirse con su viejo amigo.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Gameplay\r\n</h2> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	GTA 5 es un juego de acción y aventura que se juega desde una perspectiva en primera y tercera persona. El juego ofrece un gran mundo abierto para explorar. El mundo vive su propia vida: las carreteras de la ciudad están llenas de automóviles y peatones con los que se puede interactuar. Una gran cantidad de libertad te permite violar fácilmente la ley robando vehículos o atacando a las personas. Eso sí, hacerlo atraerá la atención de la policía local.\r\n</p> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	El juego presenta un ciclo completo de día y noche y ofrece varias actividades paralelas en las que puedes participar sin intervenir en las misiones principales de la historia. Entre las cuales, puedes encontrar jugar golf, tenis, ir al cine o navegar por Internet en el juego.\r\n</p> \r\n', 'Rockstar North', 'Rockstar Games', 17, 'grand_theft_auto_v', '2015-04-14', 'LAUNCHED', '{\r\n   \"Almacenamiento\": \"70GB\",\r\n   \"Red\": \"Conexión de red en modo online\"\r\n }', '{\r\n   \"Almacenamiento\": \"70GB\",\r\n   \"Red\": \"Conexión de red en modo online\"\r\n }', '9.95', 0, '9.0', 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `games`
--

CREATE TABLE `games` (
  `id_game` int(11) UNSIGNED NOT NULL,
  `game_name` varchar(150) NOT NULL,
  `game_slug` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `games`
--

INSERT INTO `games` (`id_game`, `game_name`, `game_slug`) VALUES
(1, 'Minecraft: Java Edition', 'minecraft_java_edition'),
(2, 'Bioshock: The Collection', 'bioshock_the_collection'),
(3, 'DEATHLOOP ', 'deathloop'),
(4, 'Grand Theft Auto V', 'grand_theft_auto_v'),
(5, 'Escape From Tarkov', 'escape_from_tarkov'),
(6, 'Sniper Elite 5', 'sniper_elite_5'),
(7, 'No Man´s Sky', 'no_mans_sky'),
(8, 'Bully Scholarship Edition', 'bully_scholarship_edition'),
(9, 'Dying Light', 'dying_light'),
(10, 'Cyberpunk 2077', 'cyberpunk_2077'),
(11, 'Assassin`s Creed Odyssey', 'assassins_creed_odyssey'),
(12, 'Dune: Spice Wars', 'dune_spice_wars');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `games_platform`
--

CREATE TABLE `games_platform` (
  `id_platform` int(10) UNSIGNED NOT NULL,
  `game_id` int(10) UNSIGNED NOT NULL,
  `id_feature` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `games_platform`
--

INSERT INTO `games_platform` (`id_platform`, `game_id`, `id_feature`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(6, 3, 4),
(3, 4, 5),
(5, 6, 6),
(3, 6, 7),
(6, 4, 8),
(5, 4, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `game_keys`
--

CREATE TABLE `game_keys` (
  `id_key` int(10) UNSIGNED NOT NULL,
  `id_platform` int(10) UNSIGNED NOT NULL,
  `id_game` int(10) UNSIGNED NOT NULL,
  `id_order` int(10) UNSIGNED DEFAULT NULL,
  `key_value` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `game_keys`
--

INSERT INTO `game_keys` (`id_key`, `id_platform`, `id_game`, `id_order`, `key_value`) VALUES
(1, 1, 1, NULL, 'ER99IO5BE3Q9QFR'),
(5, 1, 1, NULL, '6KI8C2NLO469PTK'),
(6, 1, 1, NULL, 'DE9JO489N96I434'),
(7, 5, 1, NULL, '1RPI39H758E5CNR'),
(21, 3, 3, NULL, '123456789675545'),
(22, 3, 3, NULL, 'OSE8HTROOE26HP4');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `media`
--

CREATE TABLE `media` (
  `id_media` int(10) UNSIGNED NOT NULL,
  `media_url` varchar(100) NOT NULL,
  `media_alt` varchar(100) NOT NULL,
  `media_InfoImg` tinyint(1) NOT NULL DEFAULT 0,
  `media_principal` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `media`
--

INSERT INTO `media` (`id_media`, `media_url`, `media_alt`, `media_InfoImg`, `media_principal`) VALUES
(1, 'minecraft', 'Imagen del videojuego minecraft', 0, 1),
(2, 'minecraft2', 'Imagen del videojuego Minecraft', 0, 0),
(3, 'minecraft3', 'Imagen del videojuego Minecraft', 0, 0),
(4, 'minecraft4', 'Imagen del videojuego Minecraft', 0, 0),
(5, 'minecraftInfo', 'Imagen del videojuego Minecraft', 1, 0),
(6, 'bioshokCollectionInfo', 'Portada del videojuego bioshock', 1, 0),
(7, 'bioshock', 'Imagen del videojuego Bioshock', 0, 1),
(8, 'bioshock2', 'Imagen del videojuego Bioshock', 0, 0),
(9, 'bioshock3', 'Imagen del videojuego Bioshock', 0, 0),
(10, 'bioshock4', 'Imagen del videojuego Bioshock', 0, 0),
(11, 'bioshock5', 'Imagen del videojuego Bioshock', 0, 0),
(12, 'deathloop', 'Imagen del videojuego Deathloop', 0, 1),
(13, 'deathloop2', 'Imagen del videojuego Deathloop', 0, 0),
(14, 'deathloop3', 'Imagen del videojuego Deathloop', 0, 0),
(15, 'deathloop4', 'Imagen del videojuego Deathloop', 0, 0),
(16, 'deathloop5', 'Imagen del videojuego Deathloop', 0, 0),
(17, 'deathloop6', 'Imagen del videojuego Deathloop', 0, 0),
(18, 'deathloopInfo', 'Imagen del videojuego Deathloop', 1, 0),
(19, 'gtav', 'Imagen del videojuego GTA V', 0, 1),
(21, 'gtav2', 'Imagen del videojuego GTA V', 0, 0),
(23, 'gtav3', 'Imagen del videojuego GTA V', 0, 0),
(25, 'gtav4', 'Imagen del videojuego GTA V', 0, 0),
(27, 'gtav5', 'Imagen del videojuego GTA V', 0, 0),
(29, 'gtav6', 'Imagen del videojuego GTA V', 0, 0),
(31, 'gtavInfo', 'Imagen del videojuego GTA V', 1, 0),
(32, 'sniperElite5', 'Imagen del videojuego Sniper Elite 5', 0, 1),
(34, 'sniperElite5_2', 'Imagen del videojuego Sniper Elite 5', 0, 0),
(36, 'sniperElite5_3', 'Imagen del videojuego Sniper Elite 5', 0, 0),
(38, 'sniperElite5_4', 'Imagen del videojuego Sniper Elite 5', 0, 0),
(40, 'sniperElite5_5', 'Imagen del videojuego Sniper Elite 5', 0, 0),
(42, 'sniperElite5_6', 'Imagen del videojuego Sniper Elite 5', 0, 0),
(44, 'sniperElite5Info', 'Imagen del videojuego Sniper Elite 5', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `media_games`
--

CREATE TABLE `media_games` (
  `id_media` int(10) UNSIGNED NOT NULL,
  `id_game` int(10) UNSIGNED NOT NULL,
  `id_platform` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `media_games`
--

INSERT INTO `media_games` (`id_media`, `id_game`, `id_platform`) VALUES
(1, 1, 1),
(2, 1, 1),
(3, 1, 1),
(4, 1, 1),
(5, 1, 1),
(6, 2, 2),
(7, 2, 2),
(8, 2, 2),
(9, 2, 2),
(10, 2, 2),
(11, 2, 2),
(12, 3, 3),
(12, 3, 6),
(13, 3, 3),
(13, 3, 6),
(14, 3, 3),
(14, 3, 6),
(15, 3, 3),
(15, 3, 6),
(16, 3, 3),
(16, 3, 6),
(17, 3, 3),
(17, 3, 6),
(18, 3, 3),
(18, 3, 6),
(19, 4, 3),
(19, 4, 5),
(19, 4, 6),
(21, 4, 3),
(21, 4, 5),
(21, 4, 6),
(23, 4, 3),
(23, 4, 5),
(23, 4, 6),
(25, 4, 3),
(25, 4, 5),
(25, 4, 6),
(27, 4, 3),
(27, 4, 5),
(27, 4, 6),
(29, 4, 3),
(29, 4, 5),
(29, 4, 6),
(31, 4, 3),
(31, 4, 5),
(31, 4, 6),
(32, 6, 3),
(32, 6, 5),
(34, 6, 3),
(34, 6, 5),
(36, 6, 3),
(36, 6, 5),
(38, 6, 3),
(38, 6, 5),
(40, 6, 3),
(40, 6, 5),
(42, 6, 3),
(42, 6, 5),
(44, 6, 3),
(44, 6, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id_order` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `order_date` date NOT NULL DEFAULT current_timestamp(),
  `order_total` decimal(5,2) NOT NULL DEFAULT 0.00,
  `id_billing` int(10) UNSIGNED NOT NULL,
  `id_cart` int(10) UNSIGNED NOT NULL,
  `id_card` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `platforms`
--

CREATE TABLE `platforms` (
  `id_platform` int(10) UNSIGNED NOT NULL,
  `platform_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `platforms`
--

INSERT INTO `platforms` (`id_platform`, `platform_name`) VALUES
(1, 'windows'),
(2, 'switch'),
(3, 'steam'),
(4, 'ubisoft'),
(5, 'playstation'),
(6, 'xbox');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reviews`
--

CREATE TABLE `reviews` (
  `id_platform` int(10) UNSIGNED NOT NULL,
  `id_game` int(10) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `review_calification` decimal(2,1) NOT NULL,
  `review_desc` varchar(255) NOT NULL,
  `review_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_pass` varchar(100) NOT NULL,
  `user_img` varchar(50) NOT NULL DEFAULT 'default',
  `user_rol` enum('ROLE_USER','ROLE_ADMIN') NOT NULL DEFAULT 'ROLE_USER',
  `user_state` enum('ACTIVE','DELETED') NOT NULL DEFAULT 'ACTIVE',
  `user_wishlist` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `user_name`, `user_email`, `user_pass`, `user_img`, `user_rol`, `user_state`, `user_wishlist`) VALUES
(1, 'Usuario 1', 'usuario1@gmail.com', '$2y$13$mJabL5oWUfjKPjPhXA7AOutQbTHBgEyrT6ixCTrqEy.cC6RJQqN/2', 'default', 'ROLE_USER', 'ACTIVE', 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wishlist`
--

CREATE TABLE `wishlist` (
  `id_wishlist` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `wishlist`
--

INSERT INTO `wishlist` (`id_wishlist`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(15),
(16),
(17),
(18),
(19),
(21),
(22),
(23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `wishlist_games`
--

CREATE TABLE `wishlist_games` (
  `id_game` int(10) UNSIGNED NOT NULL,
  `id_wishlist` int(10) UNSIGNED NOT NULL,
  `id_platform` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`id_billing`),
  ADD KEY `FK1` (`id_user`);

--
-- Indices de la tabla `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`id_card`),
  ADD KEY `FK28` (`card_user`);

--
-- Indices de la tabla `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `fk18` (`id_user`);

--
-- Indices de la tabla `cart_products`
--
ALTER TABLE `cart_products`
  ADD PRIMARY KEY (`id_cart`,`id_game`,`id_platform`),
  ADD KEY `Fk21` (`id_platform`),
  ADD KEY `FK22` (`id_game`);

--
-- Indices de la tabla `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`id_feature`);

--
-- Indices de la tabla `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`id_game`);

--
-- Indices de la tabla `games_platform`
--
ALTER TABLE `games_platform`
  ADD PRIMARY KEY (`id_platform`,`game_id`),
  ADD KEY `FK5` (`game_id`),
  ADD KEY `FK6` (`id_platform`),
  ADD KEY `FK20` (`id_feature`);

--
-- Indices de la tabla `game_keys`
--
ALTER TABLE `game_keys`
  ADD PRIMARY KEY (`id_key`),
  ADD UNIQUE KEY `key_value` (`key_value`),
  ADD KEY `FK7` (`id_platform`),
  ADD KEY `FK8` (`id_game`),
  ADD KEY `FK9` (`id_order`);

--
-- Indices de la tabla `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id_media`);

--
-- Indices de la tabla `media_games`
--
ALTER TABLE `media_games`
  ADD PRIMARY KEY (`id_media`,`id_game`,`id_platform`),
  ADD KEY `FK24` (`id_platform`),
  ADD KEY `FK25` (`id_game`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `FK2` (`id_user`),
  ADD KEY `FK3` (`id_billing`),
  ADD KEY `FK27` (`id_cart`),
  ADD KEY `FK34` (`id_card`);

--
-- Indices de la tabla `platforms`
--
ALTER TABLE `platforms`
  ADD PRIMARY KEY (`id_platform`);

--
-- Indices de la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id_platform`,`id_game`,`id_user`),
  ADD KEY `FK14` (`id_game`),
  ADD KEY `FK15` (`id_user`),
  ADD KEY `FK16` (`id_platform`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `EmailIndex` (`user_email`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_name_2` (`user_name`,`user_email`),
  ADD KEY `FK4` (`user_wishlist`);

--
-- Indices de la tabla `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id_wishlist`);

--
-- Indices de la tabla `wishlist_games`
--
ALTER TABLE `wishlist_games`
  ADD PRIMARY KEY (`id_game`,`id_wishlist`,`id_platform`),
  ADD KEY `FK11` (`id_wishlist`),
  ADD KEY `FK13` (`id_platform`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `billing`
--
ALTER TABLE `billing`
  MODIFY `id_billing` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `card`
--
ALTER TABLE `card`
  MODIFY `id_card` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `features`
--
ALTER TABLE `features`
  MODIFY `id_feature` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `games`
--
ALTER TABLE `games`
  MODIFY `id_game` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `game_keys`
--
ALTER TABLE `game_keys`
  MODIFY `id_key` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `media`
--
ALTER TABLE `media`
  MODIFY `id_media` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `platforms`
--
ALTER TABLE `platforms`
  MODIFY `id_platform` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id_wishlist` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `billing`
--
ALTER TABLE `billing`
  ADD CONSTRAINT `FK1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `card`
--
ALTER TABLE `card`
  ADD CONSTRAINT `FK28` FOREIGN KEY (`card_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk18` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `cart_products`
--
ALTER TABLE `cart_products`
  ADD CONSTRAINT `FK19` FOREIGN KEY (`id_cart`) REFERENCES `cart` (`id_cart`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK22` FOREIGN KEY (`id_game`) REFERENCES `games` (`id_game`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `Fk21` FOREIGN KEY (`id_platform`) REFERENCES `platforms` (`id_platform`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `games_platform`
--
ALTER TABLE `games_platform`
  ADD CONSTRAINT `FK20` FOREIGN KEY (`id_feature`) REFERENCES `features` (`id_feature`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `FK5` FOREIGN KEY (`game_id`) REFERENCES `games` (`id_game`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK6` FOREIGN KEY (`id_platform`) REFERENCES `platforms` (`id_platform`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `game_keys`
--
ALTER TABLE `game_keys`
  ADD CONSTRAINT `FK7` FOREIGN KEY (`id_platform`) REFERENCES `platforms` (`id_platform`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK8` FOREIGN KEY (`id_game`) REFERENCES `games` (`id_game`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK9` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `media_games`
--
ALTER TABLE `media_games`
  ADD CONSTRAINT `FK23` FOREIGN KEY (`id_media`) REFERENCES `media` (`id_media`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `FK24` FOREIGN KEY (`id_platform`) REFERENCES `platforms` (`id_platform`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `FK25` FOREIGN KEY (`id_game`) REFERENCES `games` (`id_game`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `FK2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK27` FOREIGN KEY (`id_cart`) REFERENCES `cart` (`id_cart`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK3` FOREIGN KEY (`id_billing`) REFERENCES `billing` (`id_billing`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK34` FOREIGN KEY (`id_card`) REFERENCES `card` (`id_card`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `FK14` FOREIGN KEY (`id_game`) REFERENCES `games` (`id_game`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK15` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Fk16` FOREIGN KEY (`id_platform`) REFERENCES `platforms` (`id_platform`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `FK4` FOREIGN KEY (`user_wishlist`) REFERENCES `wishlist` (`id_wishlist`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `wishlist_games`
--
ALTER TABLE `wishlist_games`
  ADD CONSTRAINT `FK10` FOREIGN KEY (`id_game`) REFERENCES `games` (`id_game`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK11` FOREIGN KEY (`id_wishlist`) REFERENCES `wishlist` (`id_wishlist`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK13` FOREIGN KEY (`id_platform`) REFERENCES `platforms` (`id_platform`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
