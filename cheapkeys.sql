-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-06-2022 a las 23:59:04
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

--
-- Volcado de datos para la tabla `billing`
--

INSERT INTO `billing` (`id_billing`, `id_user`, `billing_name`, `billing_state`, `billing_direction`, `billing_postal`, `billing_poblation`, `billing_country`, `billing_province`, `billin_tlfo`) VALUES
(1, 2, 'Joselito Perez', 0, 'Calle de Prueba 1', '28941', 'Humanes', 'ES', 'Madrid', '625324504'),
(2, 2, 'Joselito Perez', 1, 'Calle de Prueba 1', '28941', 'Humanes', 'ES', 'Madrid', '625324504');

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

--
-- Volcado de datos para la tabla `card`
--

INSERT INTO `card` (`id_card`, `card_number`, `card_cvv`, `card__expire`, `card_name`, `card_user`, `card_state`) VALUES
(8, '4011924761051986', '123', '01/28', 'Antonio Perez', 2, 0),
(9, '4011924761051986', '123', '01/28', 'Antonio Perez', 2, 1);

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
(2, 2, '39.90', 0),
(3, 3, '0.00', 1),
(4, 4, '0.00', 1),
(5, 5, '0.00', 1),
(6, 6, '0.00', 1),
(7, 7, '0.00', 1),
(8, 8, '0.00', 1),
(9, 9, '0.00', 1),
(10, 10, '0.00', 1),
(11, 2, '100.00', 0),
(12, 2, '69.98', 0),
(13, 2, '0.00', 1);

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

--
-- Volcado de datos para la tabla `cart_products`
--

INSERT INTO `cart_products` (`id_cart`, `id_game`, `id_platform`, `cant`, `price`) VALUES
(2, 1, 1, 2, 19.95),
(11, 6, 3, 2, 50.00),
(12, 14, 6, 1, 29.99),
(12, 15, 6, 1, 39.99);

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
  `game_date` date NOT NULL,
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

INSERT INTO `features` (`id_feature`, `game_desc`, `game_developer`, `game_distributor`, `game_stock`, `game_date`, `min_req`, `max_req`, `game_price`, `game_discount`, `game_valoration`, `game_pegi`) VALUES
(1, '<p class=\"desc__text\">\r\n    Minecraft es un juego de aventuras sandbox, desarrollado y publicado por Mojang. En el juego, la tarea del jugador\r\n    es crear construcciones a partir de varios tipos de materiales que tienen que extraer en un entorno de mundo\r\n    abierto. Los jugadores de Minecraft pueden participar en varios modos de juego, incluido el modo Supervivencia,\r\n    Creativo y Aventura. El juego también ofrece un modo multijugador, donde los jugadores pueden cooperar en la obra de\r\n    construcciones o competir entre sí en el modo PvP. Minecraft para Xbox One recibió críticas favorables de los\r\n    críticos y se ha convertido en un fenómeno cultural con millones de fanáticos dedicados.\r\n</p>\r\n\r\n<h3 class=\"desc__title\">\r\n    Construye el mundo de tus sueños\r\n</h3>\r\n\r\n<p class=\"desc__text\">\r\n    El jugador inicia un juego de Minecraft en un entorno abierto generado por procedimientos, que consta de bosques,\r\n    llanuras, colinas y otras áreas. Su trabajo consiste en utilizar cualquier material que pueda encontrar para\r\n    edificar construcciones. Los materiales del juego aparecen en forma de bloques, a partir de los cuales el jugador\r\n    puede construir. Cada tipo de bloques tiene propiedades diferentes y puede ser utilizado para diferentes propósitos.\r\n    El jugador puede visitar otros planos, Nether y The End, donde puede encontrar recursos y elementos exclusivos.\r\n    Explorando el mundo de Minecraft, el jugador puede encontrar varias criaturas: desde animales, que pueden ser\r\n    cazados para conseguir comida y materiales de artesanía, hasta monstruos peligrosos, como enredaderas que comen\r\n    bloques.\r\n</p>', 'Mojang', 'Xbox Games Studios', 4, '2011-11-18', '{\r\n  \"OS\": \"Windows 7\",\r\n  \"Procesador\": \"Intel Core i3-3210 3.2 GHz\",\r\n  \"RAM\": \"2GB RAM\",\r\n  \"Almacenamiento\": \"4GB\",\r\n  \"Grafica\": \"Nvidia GeForce 400 Series\"\r\n}', '{\r\n  \"OS\": \"Windows 10\",\r\n  \"Procesador\": \"Intel Core i5-4690 3.5GHz \",\r\n  \"RAM\": \"4GB RAM\",\r\n  \"Almacenamiento\": \"4GB\",\r\n  \"Grafica\": \"GeForce 700 Series \"\r\n}', '19.95', 0, '6.5', 3),
(2, ' <p class=\"desc__text\">\r\n    Lanzado en 2016, Bioshock: The Collection es la combinación definitiva de los tres títulos de Bioshock, junto con sus DLC. Reunidos en un solo paquete, cada uno de los juegos se ha renovado significativamente y cuenta con gráficos mejorados, con mayor resolución y efectos visuales mejorados.\r\n</p>\r\n<p class=\"desc__text\">\r\n    Gloriosamente remasterizado en 1080p. BioShock: The Collection incluye todo el contenido para un jugador de BioShock, BioShock 2 y BioShock Infinite, junto con todos los DLC, como el pack Columbia\'s Finest o las dos partes del DLC de la historia Burial at Sea. Ahora puedes disfrutar del mítico FPS con elementos de RPG en una resolución de 1920x1080 a 60 fps.\r\n</p>\r\n<h3 class=\"desc__title\">\r\n    Disfruta del juego con la mejor calidad\r\n</h3>\r\n<p class=\"desc__text\">\r\n   La trilogía de BioShock comienza con Bioshock. Como náufrago de un avión siniestrado, entras en un faro, que resulta ser la entrada a la ciudad submarina de Rapture. Concebida como una utopía, la vida en Rapture debía transcurrir sin la molestia de ningún dolor terrenal. Y así fue, hasta el descubrimiento de ADAM, una sustancia que proporciona habilidades sobrehumanas. Esto resultó ser el principio del fin de la utopía de Rapture.\r\n</p>\r\n<h3 class=\"desc__title\">\r\n    De vuelta al principio: BioShock\r\n</h3>\r\n<p class=\"desc__text\">\r\n     Las tensiones sociales provocaron conflictos entre facciones. Ahora Rapture es una ciudad colapsada, capturada por locos mutantes que habitan en las ruinas. La única forma de sobrevivir allí en este momento es usar ADAM. Conseguirlo, sin embargo, conlleva retos extremadamente peligrosos. Cargado con todo un arsenal de armas, exploras las ruinas submarinas enfrentándote a innumerables obstáculos en tu camino. Desde robot y mutantes, hasta Little Sisters y sus Big Daddies, te encontrarás con decenas de enemigos en tu camino. Prepárate para modificar tu ADN, ya que puede proporcionarte herramientas aún más mortíferas.\r\n</p>', '2K Boston', '2K', 5, '2020-05-29', '{\r\n   \"Almacenamiento\": \"20.7GB\",\r\n   \"Red\": \"Conexión de red constante\"\r\n }', '{\r\n   \"Almacenamiento\": \"20.7GB\",\r\n   \"Red\": \"Conexión de red constante\"\r\n }', '22.65', 10, '0.0', 18),
(3, '<p class=\"desc__text\">\r\n    En Deathloop asumes el papel de un asesino, llamado Colt, al que le toca vivir en una fiesta perpetua en el fin del mundo. El juego está ambientado en la isla de Blackreef, que se basa en las Islas Feroe en los años 60, donde los isleños se divierten toda la noche, reiniciando a la medianoche al día anterior. Esto significa que pueden hacer lo que quieran, porque no lo recordarán ¡Y estarán bien!.\r\n</p>\r\n<p class=\"desc__text\">\r\n    Sin embargo, Colt puede y quiere recordar, y es su misión terminar la fiesta de una vez por todas. La isla solía ser una base militar experimental, con una misión ultra secreta llamada AEON, que fue diseñada para perseguir la inmortalidad. Pero el ejército se fue hace mucho y los habitantes han invertido mucho tiempo en la isla, disfrutando de una existencia despreocupada de las mismas 24 horas una y otra vez.\r\n</p>\r\n<h3 class=\"desc__title\">\r\n    Información adicional\r\n</h3>\r\n<p class=\"desc__text\">\r\n   Los desarrolladores del juego lo describen como \'Cluedo invertido\' y el nombre es bueno. Debes resolver e implementar cómo cometer ocho asesinatos perfectos. Sin embargo, no todo va contra Colt, porque además de las armas, tiene poderes sobrenaturales, con los que puede empujar a las personas por un acantilado sin tocarlas: Karnesis, así como otros poderes, llamados Slabs, como Aether, Telekinesis, Masquerade y teletransporte a corta distancia. Hay una forma de dar fuerza a Colt de forma permanente, pero tendrás que encontrarla tú mismo.\r\n</p>', 'Arkane Studios', 'Bethesda Softworks', 0, '2021-11-14', '{\r\n  \"OS\": \"64 bit Windows 10\",\r\n  \"Procesador\": \"i5-8400 o Ryzen 5 1600\",\r\n  \"Memoria\": \"12 GB RAM\",\r\n  \"Gráfica\": \"GTX 1060 o Radeon RX 580\",\r\n  \"DirectX\": \"Version 12\",\r\n  \"Almacenamiento\": \"30 GB\"\r\n}', '{\r\n  \"OS\": \"64 bit Windows 10\",\r\n  \"Procesador\": \"i7-9700K o Ryzen 7 2700X\",\r\n  \"Memoria\": \"16 GB RAM\",\r\n  \"Gráfica\": \"RTX 2060 o Radeon RX 5700\",\r\n  \"DirectX\": \"Version 12\",\r\n  \"Almacenamiento\": \"30 GB\"\r\n}', '49.99', 35, '2.0', 18),
(4, '<p class=\"desc__text\">\r\n    En Deathloop asumes el papel de un asesino, llamado Colt, al que le toca vivir en una fiesta perpetua en el fin del mundo. El juego está ambientado en la isla de Blackreef, que se basa en las Islas Feroe en los años 60, donde los isleños se divierten toda la noche, reiniciando a la medianoche al día anterior. Esto significa que pueden hacer lo que quieran, porque no lo recordarán ¡Y estarán bien!.\r\n</p>\r\n<p class=\"desc__text\">\r\n    Sin embargo, Colt puede y quiere recordar, y es su misión terminar la fiesta de una vez por todas. La isla solía ser una base militar experimental, con una misión ultra secreta llamada AEON, que fue diseñada para perseguir la inmortalidad. Pero el ejército se fue hace mucho y los habitantes han invertido mucho tiempo en la isla, disfrutando de una existencia despreocupada de las mismas 24 horas una y otra vez.\r\n</p>\r\n<h3 class=\"desc__title\">\r\n    Información adicional\r\n</h3>\r\n<p class=\"desc__text\">\r\n   Los desarrolladores del juego lo describen como \'Cluedo invertido\' y el nombre es bueno. Debes resolver e implementar cómo cometer ocho asesinatos perfectos. Sin embargo, no todo va contra Colt, porque además de las armas, tiene poderes sobrenaturales, con los que puede empujar a las personas por un acantilado sin tocarlas: Karnesis, así como otros poderes, llamados Slabs, como Aether, Telekinesis, Masquerade y teletransporte a corta distancia. Hay una forma de dar fuerza a Colt de forma permanente, pero tendrás que encontrarla tú mismo.\r\n</p>', 'Arkane Studios', 'Bethesda Softworks', 1, '2021-09-14', '{\r\n  \"OS\": \"64 bit Windows 10\",\r\n  \"Procesador\": \"i7-9700K o Ryzen 7 2700X\",\r\n  \"Memoria\": \"16 GB RAM\",\r\n  \"Gráfica\": \"RTX 2060 o Radeon RX 5700\",\r\n  \"DirectX\": \"Version 12\",\r\n  \"Almacenamiento\": \"30 GB\"\r\n}', '{\r\n  \"OS\": \"64 bit Windows 10\",\r\n  \"Procesador\": \"i7-9700K o Ryzen 7 2700X\",\r\n  \"Memoria\": \"16 GB RAM\",\r\n  \"Gráfica\": \"RTX 2060 o Radeon RX 5700\",\r\n  \"DirectX\": \"Version 12\",\r\n  \"Almacenamiento\": \"30 GB\"\r\n}', '49.99', 25, '5.4', 18),
(5, '<p class=\"desc__text\">\r\n	Grand Theft Auto V es un videojuego de acción y aventura desarrollado por Rockstar North y publicado en 2013 por Rockstar Games. El juego se centra sobre todo en los atracos, persecuciones policiales, tiroteos y el logro de los objetivos, incluso si eso significa infringir la ley de vez en cuando. Premium Online Edition es un paquete conveniente que reúne tanto el juego básico de GTA V como Criminal Enterprise Starter Pack para ayudarte a comenzar y desarrollar tu negocio criminal de modo online mucho más rápido.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Historia\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	La historia de GTA 5 gira en torno a tres personajes jugables: el ladrón retirado - Michael, su compañero de crimen impulsivo y mentalmente desequilibrado - Trevor, y Franklin, que trabajaba como embargador de coches de lujo y con pasado en pandillas. Michael cortó todos los lazos con el pasado y vivió una vida feliz bajo el programa de protección de testigos, pero la paz no duró demasiado, ya que accidentalmente se metió bajo la piel del líder del Cartel de Madrazo. Pagar la deuda de Michael llamó la atención de Trevor, quien decidió reunirse con su viejo amigo.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Gameplay\r\n</h2> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	GTA 5 es un juego de acción y aventura que se juega desde una perspectiva en primera y tercera persona. El juego ofrece un gran mundo abierto para explorar. El mundo vive su propia vida: las carreteras de la ciudad están llenas de automóviles y peatones con los que se puede interactuar. Una gran cantidad de libertad te permite violar fácilmente la ley robando vehículos o atacando a las personas. Eso sí, hacerlo atraerá la atención de la policía local.\r\n</p> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	El juego presenta un ciclo completo de día y noche y ofrece varias actividades paralelas en las que puedes participar sin intervenir en las misiones principales de la historia. Entre las cuales, puedes encontrar jugar golf, tenis, ir al cine o navegar por Internet en el juego.\r\n</p> \r\n', 'Rockstar North', 'Rockstar Games', 4, '2015-04-14', '{\r\n  \"OS\": \"Windows 7\",\r\n  \"Procesador\": \"Intel Core 2 Q6600 o  AMD Phenom 9850\",\r\n  \"RAM\": \"4GB RAM\",\r\n  \"Almacenamiento\": \"72GB\",\r\n  \"Grafica\": \"Nvidia 9800 GT o AMD HD 4870\",\r\n  \"Tarjeta de sonido\" : \"Compatible con DirectX 10\"\r\n}', '{\r\n  \"OS\": \"Windows 7\",\r\n  \"Procesador\": \"Intel Core i5 3470 o  AMD X8 FX-8350\",\r\n  \"RAM\": \"8GB RAM\",\r\n  \"Almacenamiento\": \"72GB\",\r\n  \"Grafica\": \"Nvidia GTX 660 o AMD HD 7870\",\r\n  \"Tarjeta de sonido\" : \"Compatible con DirectX 10\"\r\n}', '19.00', 5, '0.0', 18),
(6, '<p class=\"desc__text\">\r\n	Sniper Elite 5 es otra entrega de la legendaria serie de juegos de acción, desarrollada y lanzada en 2022 por Rebellion. Esta vez, viajarás a la Francia de 1944 para enfrentarte a una lucha que determinará el destino de la Segunda Guerra Mundial. Se trata de una parte mejorada en la que descubrirás unos gráficos aún mejores y más detallados y un pulido modo multijugador.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title--primary\">\r\n	Historia\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	Karl Fairburne viaja a la costa de Bretaña para unirse a las fuerzas aliadas francesas. Aunque la lucha parece estar igualada al principio, llega a sus manos un proyecto secreto nazi: la Operación Kraken. Parece que los aliados no tienen ninguna posibilidad en esta guerra. ¿Será capaz de acudir en su ayuda?\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title--primary\">\r\n	Jugabilidad\r\n\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	Sniper Elite 5 es un videojuego de disparos realista que se centra en completar misiones en una extensa campaña de aventuras. Ve al campo de batalla y detén al enemigo a toda costa. Para lograrlo, puedes utilizar ataques sorpresa o un rifle de francotirador. Elige el mejor lugar y apunta a tu oponente, sopesando factores como el terreno, el clima y el tipo de arma. Mejora tu rifle como quieras, ajustando nuevos elementos y munición.\r\n\r\n</p> \r\n\r\n<p class=\"desc__text\">\r\n	El videojuego Sniper introducirá varias mejoras, entre ellas una Kill Cam mejorada. Observa tus mejores tareas en cámara lenta para ser testigo de los efectos más exitosos de tus disparos. Aprende de ellos y sé aún mejor. Descubre el extenso modo multijugador, donde podrás jugar en cooperación o en la campaña PvP online. Elige cooperar y compartir el equipo adquirido con el equipo, o únete a la brutal partida en la que todos luchan contra otros jugadores. En Sniper 5, también puedes jugar en el papel de un francotirador alemán para eliminar a los jugadores en sus campañas.\r\n\r\n</p> ', 'Rebellion', 'Rebellion', 4, '2022-05-26', '{\r\n   \"Almacenamiento\": \"80.63GB\",\r\n   \"Red\": \"Conexión de red constante\"\r\n }', '{\r\n   \"Almacenamiento\": \"80.63GB\",\r\n   \"Red\": \"Conexión de red constante\"\r\n }', '60.00', 0, '7.3', 18),
(7, '<p class=\"desc__text\">\r\n	Sniper Elite 5 es otra entrega de la legendaria serie de juegos de acción, desarrollada y lanzada en 2022 por Rebellion. Esta vez, viajarás a la Francia de 1944 para enfrentarte a una lucha que determinará el destino de la Segunda Guerra Mundial. Se trata de una parte mejorada en la que descubrirás unos gráficos aún mejores y más detallados y un pulido modo multijugador.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title--primary\">\r\n	Historia\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	Karl Fairburne viaja a la costa de Bretaña para unirse a las fuerzas aliadas francesas. Aunque la lucha parece estar igualada al principio, llega a sus manos un proyecto secreto nazi: la Operación Kraken. Parece que los aliados no tienen ninguna posibilidad en esta guerra. ¿Será capaz de acudir en su ayuda?\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title--primary\">\r\n	Jugabilidad\r\n\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	Sniper Elite 5 es un videojuego de disparos realista que se centra en completar misiones en una extensa campaña de aventuras. Ve al campo de batalla y detén al enemigo a toda costa. Para lograrlo, puedes utilizar ataques sorpresa o un rifle de francotirador. Elige el mejor lugar y apunta a tu oponente, sopesando factores como el terreno, el clima y el tipo de arma. Mejora tu rifle como quieras, ajustando nuevos elementos y munición.\r\n\r\n</p> \r\n\r\n<p class=\"desc__text\">\r\n	El videojuego Sniper introducirá varias mejoras, entre ellas una Kill Cam mejorada. Observa tus mejores tareas en cámara lenta para ser testigo de los efectos más exitosos de tus disparos. Aprende de ellos y sé aún mejor. Descubre el extenso modo multijugador, donde podrás jugar en cooperación o en la campaña PvP online. Elige cooperar y compartir el equipo adquirido con el equipo, o únete a la brutal partida en la que todos luchan contra otros jugadores. En Sniper 5, también puedes jugar en el papel de un francotirador alemán para eliminar a los jugadores en sus campañas.\r\n\r\n</p> ', 'Rebellion', 'Rebellion', 2, '2022-05-26', '{\r\n  \"OS\": \"Windows 10\",\r\n  \"Procesador\": \"Intel Core i3-8100\",\r\n  \"RAM\": \"8GB RAM\",\r\n  \"Almacenamiento\": \"85GB\",\r\n  \"Grafica\": \"Nvidia GTX 1660\"\r\n}', '{\r\n  \"OS\": \"Windows 10\",\r\n  \"Procesador\": \"Intel Core i5-8400\",\r\n  \"RAM\": \"16GB RAM\",\r\n  \"Almacenamiento\": \"85GB\",\r\n  \"Grafica\": \"Nvidia RTX 2060\"\r\n}', '50.00', 0, '0.0', 18),
(8, '<p class=\"desc__text\">\r\n	Grand Theft Auto V es un videojuego de acción y aventura desarrollado por Rockstar North y publicado en 2013 por Rockstar Games. El juego se centra sobre todo en los atracos, persecuciones policiales, tiroteos y el logro de los objetivos, incluso si eso significa infringir la ley de vez en cuando. Premium Online Edition es un paquete conveniente que reúne tanto el juego básico de GTA V como Criminal Enterprise Starter Pack para ayudarte a comenzar y desarrollar tu negocio criminal de modo online mucho más rápido.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Historia\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	La historia de GTA 5 gira en torno a tres personajes jugables: el ladrón retirado - Michael, su compañero de crimen impulsivo y mentalmente desequilibrado - Trevor, y Franklin, que trabajaba como embargador de coches de lujo y con pasado en pandillas. Michael cortó todos los lazos con el pasado y vivió una vida feliz bajo el programa de protección de testigos, pero la paz no duró demasiado, ya que accidentalmente se metió bajo la piel del líder del Cartel de Madrazo. Pagar la deuda de Michael llamó la atención de Trevor, quien decidió reunirse con su viejo amigo.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Gameplay\r\n</h2> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	GTA 5 es un juego de acción y aventura que se juega desde una perspectiva en primera y tercera persona. El juego ofrece un gran mundo abierto para explorar. El mundo vive su propia vida: las carreteras de la ciudad están llenas de automóviles y peatones con los que se puede interactuar. Una gran cantidad de libertad te permite violar fácilmente la ley robando vehículos o atacando a las personas. Eso sí, hacerlo atraerá la atención de la policía local.\r\n</p> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	El juego presenta un ciclo completo de día y noche y ofrece varias actividades paralelas en las que puedes participar sin intervenir en las misiones principales de la historia. Entre las cuales, puedes encontrar jugar golf, tenis, ir al cine o navegar por Internet en el juego.\r\n</p> \r\n', 'Rockstar North', 'Rockstar Games', 0, '2015-04-14', '{\r\n   \"Almacenamiento\": \"72GB\",\r\n   \"Red\": \"Conexión de red en modo online\"\r\n }', '{\r\n   \"Almacenamiento\": \"72GB\",\r\n   \"Red\": \"Conexión de red en modo online\"\r\n }', '19.00', 0, '0.0', 18),
(9, '<p class=\"desc__text\">\r\n	Grand Theft Auto V es un videojuego de acción y aventura desarrollado por Rockstar North y publicado en 2013 por Rockstar Games. El juego se centra sobre todo en los atracos, persecuciones policiales, tiroteos y el logro de los objetivos, incluso si eso significa infringir la ley de vez en cuando. Premium Online Edition es un paquete conveniente que reúne tanto el juego básico de GTA V como Criminal Enterprise Starter Pack para ayudarte a comenzar y desarrollar tu negocio criminal de modo online mucho más rápido.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Historia\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	La historia de GTA 5 gira en torno a tres personajes jugables: el ladrón retirado - Michael, su compañero de crimen impulsivo y mentalmente desequilibrado - Trevor, y Franklin, que trabajaba como embargador de coches de lujo y con pasado en pandillas. Michael cortó todos los lazos con el pasado y vivió una vida feliz bajo el programa de protección de testigos, pero la paz no duró demasiado, ya que accidentalmente se metió bajo la piel del líder del Cartel de Madrazo. Pagar la deuda de Michael llamó la atención de Trevor, quien decidió reunirse con su viejo amigo.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Gameplay\r\n</h2> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	GTA 5 es un juego de acción y aventura que se juega desde una perspectiva en primera y tercera persona. El juego ofrece un gran mundo abierto para explorar. El mundo vive su propia vida: las carreteras de la ciudad están llenas de automóviles y peatones con los que se puede interactuar. Una gran cantidad de libertad te permite violar fácilmente la ley robando vehículos o atacando a las personas. Eso sí, hacerlo atraerá la atención de la policía local.\r\n</p> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	El juego presenta un ciclo completo de día y noche y ofrece varias actividades paralelas en las que puedes participar sin intervenir en las misiones principales de la historia. Entre las cuales, puedes encontrar jugar golf, tenis, ir al cine o navegar por Internet en el juego.\r\n</p> \r\n', 'Rockstar North', 'Rockstar Games', 0, '2015-04-14', '{\r\n   \"Almacenamiento\": \"70GB\",\r\n   \"Red\": \"Conexión de red en modo online\"\r\n }', '{\r\n   \"Almacenamiento\": \"70GB\",\r\n   \"Red\": \"Conexión de red en modo online\"\r\n }', '9.95', 0, '0.0', 18),
(10, '<h2 class=\"desc__title\">\r\n	Historia\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	Conoce a los heroicos soldados de la Segunda Guerra Mundial y dirígelos en las batallas más importantes en los campos de batalla de todos los rincones del mundo. Juega como la francotiradora - Polina Petrova, un especialista en explosivos - Lucas Riggs, el soldado francés Arthur Kingsley, y un excelente explorador Wade Jackson. Vive una desafiante campaña de estrategia en el Frente Oriental, África del Norte, el Frente Occidental y el Pacífico. Es el día del triunfo y el día en que te levantas como parte de la historia.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Gameplay emocionante\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	CoD Vanguard es un shooter en primera persona en el que tendrás la oportunidad de jugar una inspiradora campaña y manejar un gran arsenal de armas. Conoce a los héroes de la historia y enfréntate a las desafiantes tareas que se te plantean. Cada misión requerirá el uso de tu ingenio, tu sentido de la estrategia y la fuerza para sacrificarte por un bien mayor.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Muchos frentes, infinitos resultados posibles\r\n</h2> \r\n<p class=\"desc__text\">\r\nParticipa en las misiones de los cuatro frentes de la Segunda Guerra Mundial. Explora los mapas, escabúllete, dispara y planifica tus acciones. Recoge equipo, compra nuevas armaduras y mejora las armas. Participa en ricas historias de personajes con corazón de león en el conflicto más brutal de la historia de la humanidad.\r\n</p> ', 'Sledgehammer \n', 'Activision', 0, '2021-11-05', '{\r\n  \"OS\": \"64 bit Windows 10\",\r\n  \"Procesador\": \"i3-4340 o FX-6300\",\r\n  \"Memoria\": \"8 GB RAM\",\r\n  \"Gráfica\": \"GTX 960 o Radeon RX 470\",\r\n  \"Almacenamiento\": \"177 GB\"\r\n}', '{\r\n  \"OS\": \"64 bit Windows 10\",\r\n  \"Procesador\": \"i5-2500k o Ryzen 5 1600X\",\r\n  \"Memoria\": \"12 GB RAM\",\r\n  \"Gráfica\": \"GTX 1060 o Radeon RX 580\",\r\n  \"Almacenamiento\": \"177 GB\"\r\n}', '49.99', 20, '0.0', 18),
(11, '<h2 class=\"desc__title\">\r\n	Historia\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	Conoce a los heroicos soldados de la Segunda Guerra Mundial y dirígelos en las batallas más importantes en los campos de batalla de todos los rincones del mundo. Juega como la francotiradora - Polina Petrova, un especialista en explosivos - Lucas Riggs, el soldado francés Arthur Kingsley, y un excelente explorador Wade Jackson. Vive una desafiante campaña de estrategia en el Frente Oriental, África del Norte, el Frente Occidental y el Pacífico. Es el día del triunfo y el día en que te levantas como parte de la historia.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Gameplay emocionante\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	CoD Vanguard es un shooter en primera persona en el que tendrás la oportunidad de jugar una inspiradora campaña y manejar un gran arsenal de armas. Conoce a los héroes de la historia y enfréntate a las desafiantes tareas que se te plantean. Cada misión requerirá el uso de tu ingenio, tu sentido de la estrategia y la fuerza para sacrificarte por un bien mayor.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Muchos frentes, infinitos resultados posibles\r\n</h2> \r\n<p class=\"desc__text\">\r\nParticipa en las misiones de los cuatro frentes de la Segunda Guerra Mundial. Explora los mapas, escabúllete, dispara y planifica tus acciones. Recoge equipo, compra nuevas armaduras y mejora las armas. Participa en ricas historias de personajes con corazón de león en el conflicto más brutal de la historia de la humanidad.\r\n</p> ', 'Sledgehammer \n', 'Activision', 2, '2021-11-05', '{\r\n   \"Almacenamiento\": \"70GB\",\r\n   \"Red\": \"Conexión de red en modo online\"\r\n }', '{\r\n   \"Almacenamiento\": \"70GB\",\r\n   \"Red\": \"Conexión de red en modo online\"\r\n }', '49.99', 0, '0.0', 18),
(12, '<h2 class=\"desc__title\">\r\n	Historia y personajes\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	Como el nombre del juego puede sugerir, la acción del título se desarrolla en los tiempos actuales, donde la línea entre el bien y el mal en el campo de batalla es más borrosa que nunca. Distinguir a los amigos de los enemigos es a menudo difícil y complicado: no todos los enemigos llevan uniforme. Combinando este hecho con la realidad de la guerra, los soldados del letal grupo Tier One tienen que evaluar rápidamente la amenaza y responder en consecuencia, causando a menudo la muerte de civiles inocentes para salvar a más gente o para garantizar su propia seguridad.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Capitán Price\r\n</h2> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	En Call of Duty: Modern Warfare el Capitán Price hace su regreso, pero esta vez es interpretado por Barry Sloane en lugar de Billy Murray. Esto significa no sólo hacer una imitación del personaje, sino más bien reiniciarlo por completo para la nueva generación, al igual que el propio juego es un reinicio de la serie Modern Warfare para representar mejor una imagen actual de la guerra real que ha cambiado drásticamente a lo largo de los años.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Jugabilidad\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	CoD: Modern Warfare se juega desde la perspectiva en primera persona. El juego te permite jugar en el papel de los operadores de nivel uno mientras se encargan de misiones peligrosas que podrían cambiar el equilibrio de poder mundial. Las misiones serán muy variadas, dándote la oportunidad tanto de escabullirte detrás de las líneas enemigas eligiendo objetivos uno a uno desde una distancia segura como de enfrentarte a tus oponentes cara a cara en encuentros cuerpo a cuerpo. Durante las misiones, dispondrás de un amplio abanico de equipos y armas. \r\n</p> \r\n\r\n<p class=\"desc__text\">\r\n	Cada arma se comporta de forma natural y auténtica, lo que te da una sensación mucho más profunda y una mejor impresión de estar disparando realmente. Esto ha sido posible gracias a la colaboración de veteranos del SAS, la CIA y los Navy SEAL que han compartido sus valiosos conocimientos y experiencia.\r\n\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Modos de juego\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	Modern Warfare puede jugarse tanto en modo individual como en multijugador con amigos y otras personas. A los que jueguen en solitario les espera una extensa y épica campaña argumental llena de peligrosas misiones y duras decisiones morales, ya que la guerra nunca es simplemente blanca o negra. Para los que prefieran la experiencia online, los desarrolladores han preparado tanto el modo multijugador tradicional como el modo cooperativo, en el que se puede formar un equipo para afrontar juntos retos únicos. Por otra parte, cabe mencionar que los propietarios de las versiones del juego para ordenador y consola podrán jugar juntos en línea, ya que el juego cuenta con un multijugador multiplataforma.\r\n</p> \r\n\r\n\r\n', 'Infinity Ward', 'Activision', 4, '2019-10-25', '{\r\n  \"OS\": \"64 bit Windows 10\",\r\n  \"Procesador\": \"i3-4340 o FX-6300\",\r\n  \"Memoria\": \"8 GB RAM\",\r\n  \"Gráfica\": \"GTX 670 o Radeon HD 7950\",\r\n  \"Almacenamiento\": \"175 GB\"\r\n}', '{\r\n  \"OS\": \"64 bit Windows 10\",\r\n  \"Procesador\": \"i5-2500K o R5-1600X\",\r\n  \"Memoria\": \"12 GB RAM\",\r\n  \"Gráfica\": \"GTX 970 o Radeon R9 390\",\r\n  \"Almacenamiento\": \"175 GB\"\r\n}', '29.99', 0, '0.0', 18),
(13, '<h2 class=\"desc__title\">\r\n	Historia y personajes\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	Como el nombre del juego puede sugerir, la acción del título se desarrolla en los tiempos actuales, donde la línea entre el bien y el mal en el campo de batalla es más borrosa que nunca. Distinguir a los amigos de los enemigos es a menudo difícil y complicado: no todos los enemigos llevan uniforme. Combinando este hecho con la realidad de la guerra, los soldados del letal grupo Tier One tienen que evaluar rápidamente la amenaza y responder en consecuencia, causando a menudo la muerte de civiles inocentes para salvar a más gente o para garantizar su propia seguridad.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Capitán Price\r\n</h2> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	En Call of Duty: Modern Warfare el Capitán Price hace su regreso, pero esta vez es interpretado por Barry Sloane en lugar de Billy Murray. Esto significa no sólo hacer una imitación del personaje, sino más bien reiniciarlo por completo para la nueva generación, al igual que el propio juego es un reinicio de la serie Modern Warfare para representar mejor una imagen actual de la guerra real que ha cambiado drásticamente a lo largo de los años.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Jugabilidad\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	CoD: Modern Warfare se juega desde la perspectiva en primera persona. El juego te permite jugar en el papel de los operadores de nivel uno mientras se encargan de misiones peligrosas que podrían cambiar el equilibrio de poder mundial. Las misiones serán muy variadas, dándote la oportunidad tanto de escabullirte detrás de las líneas enemigas eligiendo objetivos uno a uno desde una distancia segura como de enfrentarte a tus oponentes cara a cara en encuentros cuerpo a cuerpo. Durante las misiones, dispondrás de un amplio abanico de equipos y armas. \r\n</p> \r\n\r\n<p class=\"desc__text\">\r\n	Cada arma se comporta de forma natural y auténtica, lo que te da una sensación mucho más profunda y una mejor impresión de estar disparando realmente. Esto ha sido posible gracias a la colaboración de veteranos del SAS, la CIA y los Navy SEAL que han compartido sus valiosos conocimientos y experiencia.\r\n\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Modos de juego\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	Modern Warfare puede jugarse tanto en modo individual como en multijugador con amigos y otras personas. A los que jueguen en solitario les espera una extensa y épica campaña argumental llena de peligrosas misiones y duras decisiones morales, ya que la guerra nunca es simplemente blanca o negra. Para los que prefieran la experiencia online, los desarrolladores han preparado tanto el modo multijugador tradicional como el modo cooperativo, en el que se puede formar un equipo para afrontar juntos retos únicos. Por otra parte, cabe mencionar que los propietarios de las versiones del juego para ordenador y consola podrán jugar juntos en línea, ya que el juego cuenta con un multijugador multiplataforma.\r\n</p> \r\n\r\n\r\n', 'Infinity Ward', 'Activision', 2, '2019-10-25', '{\r\n   \"Almacenamiento\": \"70GB\",\r\n   \"Red\": \"Conexión de red en modo online\"\r\n }', '{\r\n   \"Almacenamiento\": \"70GB\",\r\n   \"Red\": \"Conexión de red en modo online\"\r\n }', '29.99', 0, '9.9', 18),
(14, '<h2 class=\"desc__title\">\r\n	Historia y personajes\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	Como el nombre del juego puede sugerir, la acción del título se desarrolla en los tiempos actuales, donde la línea entre el bien y el mal en el campo de batalla es más borrosa que nunca. Distinguir a los amigos de los enemigos es a menudo difícil y complicado: no todos los enemigos llevan uniforme. Combinando este hecho con la realidad de la guerra, los soldados del letal grupo Tier One tienen que evaluar rápidamente la amenaza y responder en consecuencia, causando a menudo la muerte de civiles inocentes para salvar a más gente o para garantizar su propia seguridad.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Capitán Price\r\n</h2> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	En Call of Duty: Modern Warfare el Capitán Price hace su regreso, pero esta vez es interpretado por Barry Sloane en lugar de Billy Murray. Esto significa no sólo hacer una imitación del personaje, sino más bien reiniciarlo por completo para la nueva generación, al igual que el propio juego es un reinicio de la serie Modern Warfare para representar mejor una imagen actual de la guerra real que ha cambiado drásticamente a lo largo de los años.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Jugabilidad\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	CoD: Modern Warfare se juega desde la perspectiva en primera persona. El juego te permite jugar en el papel de los operadores de nivel uno mientras se encargan de misiones peligrosas que podrían cambiar el equilibrio de poder mundial. Las misiones serán muy variadas, dándote la oportunidad tanto de escabullirte detrás de las líneas enemigas eligiendo objetivos uno a uno desde una distancia segura como de enfrentarte a tus oponentes cara a cara en encuentros cuerpo a cuerpo. Durante las misiones, dispondrás de un amplio abanico de equipos y armas. \r\n</p> \r\n\r\n<p class=\"desc__text\">\r\n	Cada arma se comporta de forma natural y auténtica, lo que te da una sensación mucho más profunda y una mejor impresión de estar disparando realmente. Esto ha sido posible gracias a la colaboración de veteranos del SAS, la CIA y los Navy SEAL que han compartido sus valiosos conocimientos y experiencia.\r\n\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Modos de juego\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	Modern Warfare puede jugarse tanto en modo individual como en multijugador con amigos y otras personas. A los que jueguen en solitario les espera una extensa y épica campaña argumental llena de peligrosas misiones y duras decisiones morales, ya que la guerra nunca es simplemente blanca o negra. Para los que prefieran la experiencia online, los desarrolladores han preparado tanto el modo multijugador tradicional como el modo cooperativo, en el que se puede formar un equipo para afrontar juntos retos únicos. Por otra parte, cabe mencionar que los propietarios de las versiones del juego para ordenador y consola podrán jugar juntos en línea, ya que el juego cuenta con un multijugador multiplataforma.\r\n</p> \r\n\r\n\r\n', 'Infinity Ward', 'Activision', 1, '2019-10-25', '{\r\n   \"Almacenamiento\": \"70GB\",\r\n   \"Red\": \"Conexión de red en modo online\"\r\n }', '{\r\n   \"Almacenamiento\": \"70GB\",\r\n   \"Red\": \"Conexión de red en modo online\"\r\n }', '29.99', 30, '0.0', 18),
(15, '<p class=\"desc__text\">\r\n	Batman: Arkham City es la secuela directa del premiado y respetado entre la comunidad de jugadores, Batman: Arkham Asylum, juego de acción TPP creado por el equipo británico de desarrolladores de Rocksteady con la colaboración de Warner Bros. Interactive. En el juego, al igual que en Arkham Asylum, el jugador asume el papel del héroe del título. Como corresponde a cualquier superhéroe que se respete, nuestro trabajo es luchar contra el crimen con una variedad de herramientas de alta tecnología y, por supuesto, con nuestros puños. Conoce a todos los enemigos icónicos de Batman, como El Acertijo, Hiedra Venenosa, Dos Caras, Deadshot, El Pingüino, Mr. Freeze y muchos más.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Una historia profunda y no lineal\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	La historia presentada en Batman: AC comienza unos meses después de los acontecimientos de Arkham Asylum. El director del manicomio, Quincy Sharp, se atribuye injustamente las acciones heroicas que le han otorgado el puesto de nuevo alcalde de Gotham City. Tras conseguir el poder y el dinero, compró una enorme zona de tugurios de la ciudad, dejando a cientos de ciudadanos de clase baja sin un techo.\r\n</p> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	Después, el nuevo alcalde ordenó construir enormes muros alrededor de la zona y colocó a los criminales más peligrosos en su interior. Ese fue el nacimiento de Arkham City. En lugar de matarse unos a otros, los criminales encerrados en esta nueva zona empezaron a crear bandas organizadas, volviéndose aún más peligrosos que antes. Arkham City se convirtió en la ciudad del crimen por excelencia, supervisada por Hugo Strange, un misterioso individuo nombrado por el comandante. Strange da a sus \"protegidos\" total libertad, con una sola regla: nadie escapa.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	Mecánica de juego nueva y mejorada\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	La mecánica de juego de Arkham City es muy similar a la que tuvimos ocasión de ver en el juego anterior. Sin embargo, los desarrolladores hicieron todo lo posible para mejorar las ya excelentes soluciones utilizadas en Arkham Asylum.\r\n</p> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	Esta vez los encuentros con grupos de enemigos son aún más espectaculares que antes. Hay un montón de nuevos movimientos y medios para eliminar a los enemigos. Vale la pena mencionar que el combate es ahora más desafiante, ya que los enemigos no te darán mucho tiempo para reaccionar. Sus ataques están coordinados y son extremadamente peligrosos. Te encontrarás con matones equipados con cuchillos, pistolas, escudos antidisturbios, pistolas paralizantes, etc. y supondrán una verdadera amenaza con bastante frecuencia. Por supuesto, podemos intentar un enfoque más sutil y sigiloso y eliminar a nuestros enemigos en silencio, sin dejar que vean lo que se avecina. El combate no es la única actividad disponible en Arkham City.\r\n</p> \r\n', 'Rocksteady Studios', 'Warner Bros', 0, '2012-09-07', '{\r\n  \"OS\": \"Windows 7\",\r\n  \"Procesador\": \"Core 2 duo o Athlon X2 4800\",\r\n  \"Memoria\": \"2 GB RAM\",\r\n  \"Gráfica\": \"8800 GT o ATI 3850HD\",\r\n  \"DirectX\": \"9.0c\",\r\n  \"Almacenamiento\": \"17 GB\"\r\n}', '{\r\n  \"OS\": \"Windows 7\",\r\n  \"Procesador\": \"Core 2 duo o Athlon X2 4800\",\r\n  \"Memoria\": \"2 GB RAM\",\r\n  \"Gráfica\": \"8800 GT o ATI 3850HD\",\r\n  \"DirectX\": \"9.0c\",\r\n  \"Almacenamiento\": \"17 GB\"\r\n}', '2.95', 0, '0.0', 16),
(16, '<p class=\"desc__text\">\r\n	Assetto Corsa fue desarrollado por el estudio italiano Kumos Simulazioni. Los desarrolladores se centraron en crear el simulador de carreras más realista. En el juego, los jugadores tienen acceso a más de 170 autos con licencia oficial, incluidos prototipos innovadores y máquinas legendarias de las series F1 y GT. Cada automóvil ha sido diseñado cuidadosamente, con extrema atención a los detalles para brindar la experiencia más realista.\r\n</p> \r\n\r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	La mecánica de juego realista te va a proporcionar una experiencia casi real\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	Assetto Corsa utiliza el motor original, creado especialmente para el juego. Al crear Assetto Corsa, los desarrolladores de Kumos Simulazioni invitaron a conductores profesionales para preparar un modelo de conducción realista, recreando las estadísticas y características de cada automóvil.\r\n</p> \r\n\r\n', 'Kunos Simulazioni', 'Kunos Simulazioni', 5, '2014-12-19', '{\r\n  \"OS\": \"64 bit Windows 10\",\r\n  \"Procesador\": \"i3-4340 o FX-6300\",\r\n  \"Memoria\": \"8 GB RAM\",\r\n  \"Gráfica\": \"GTX 960 o Radeon RX 470\",\r\n  \"Almacenamiento\": \"60 GB\"\r\n}', '{\r\n  \"OS\": \"64 bit Windows 10\",\r\n  \"Procesador\": \"i5-5600K o Ryzen 5 3600X\",\r\n  \"Memoria\": \"8 GB RAM\",\r\n  \"Gráfica\": \"GTX 1060 o Radeon RX 580\",\r\n  \"Almacenamiento\": \"60 GB\"\r\n}', '19.99', 0, '0.0', 12),
(17, '<p class=\"desc__text\">\r\n	Assetto Corsa fue desarrollado por el estudio italiano Kumos Simulazioni. Los desarrolladores se centraron en crear el simulador de carreras más realista. En el juego, los jugadores tienen acceso a más de 170 autos con licencia oficial, incluidos prototipos innovadores y máquinas legendarias de las series F1 y GT. Cada automóvil ha sido diseñado cuidadosamente, con extrema atención a los detalles para brindar la experiencia más realista.\r\n</p> \r\n\r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	La mecánica de juego realista te va a proporcionar una experiencia casi real\r\n</h2> \r\n\r\n<p class=\"desc__text\">\r\n	Assetto Corsa utiliza el motor original, creado especialmente para el juego. Al crear Assetto Corsa, los desarrolladores de Kumos Simulazioni invitaron a conductores profesionales para preparar un modelo de conducción realista, recreando las estadísticas y características de cada automóvil.\r\n</p> \r\n\r\n', 'Kunos Simulazioni', 'Kunos Simulazioni', 2, '2014-12-19', '{\r\n  \"OS\": \"64 bit Windows 10\",\r\n  \"Procesador\": \"i3-4340 o FX-6300\",\r\n  \"Memoria\": \"8 GB RAM\",\r\n  \"Gráfica\": \"GTX 960 o Radeon RX 470\",\r\n  \"Almacenamiento\": \"60 GB\"\r\n}', '{\r\n  \"OS\": \"64 bit Windows 10\",\r\n  \"Procesador\": \"i5-5600K o Ryzen 5 3600X\",\r\n  \"Memoria\": \"8 GB RAM\",\r\n  \"Gráfica\": \"GTX 1060 o Radeon RX 580\",\r\n  \"Almacenamiento\": \"60 GB\"\r\n}', '19.99', 0, '0.0', 12),
(18, '\r\n<p class=\"desc__text\">\r\n	Assassin\'s Creed Valhalla para PC es la duodécima entrega de los juegos de Assassin\'s Creed, y este tiene lugar en el siglo IX (comenzando en 873 d.C.) llevándote por Europa mientras mueves tu clan desde una Noruega gravemente superpoblada y devastada por la guerra a Inglaterra, tierra verde de paz, prosperidad y campos fértiles para cultivar. Reino Unido puede tener la reputación de ser un lugar frío y lluvioso, pero en comparación con la desolación casi ártica, no es un sustituto tan malo. Es un juego de aventuras y acción de mundo abierto.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	¿Qué hacer?\r\n</h2> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	Los hermanos Eivor y Sigurd son los líderes de su intrépido grupo de vikingos y tú juegas como Eivor, que puede ser hombre o mujer. Sin embargo, no te preocupes por tu género, ya que puedes cambiarlo sobre la marcha, incluso en el fragor de la batalla si de repente te apetece un cambio.\r\n\r\nSi el combate no es lo tuyo, todavía hay mucho por hacer en el juego. Visita el establo para comprar caballos, entra en la cabaña de pesca antes de ir a los arroyos y lagos, y mantén tu equipo actualizado en la cabaña de caza. Incluso hay un aviario donde puedes personalizar tus cuervos con detalles como destellos blancos en sus alas. Como beneficio adicional, tus capturas de pesca o tus éxitos de caza se pueden vender a cambio de varias recompensas o como moneda del juego. Al ser vikingo, por supuesto, querrás mantener tu acceso al mar en buen estado y también hay un astillero donde puedes reparar, mantener, construir y reemplazar tu barco.\r\n</p> \r\n\r\n<p class=\"desc__text\">\r\n	\r\nEstarás ocupado al principio, aprendiendo habilidades y creando nuevos artículos, incluso mientras siembras y cultivas y disfrutarás de batallas ocasionales mientras los asaltantes intentan tomar lo que tienes. Establecer una panadería, una granja de ganado y una cervecería asegurarán que tú y tu clan estáis bien alimentados, mientras que Gunnar, el herrero, te forja algunas armas asombrosas.\r\n\r\n</p> \r\n\r\n<p class=\"desc__text\">\r\n	Vale la pena mantener al cartógrafo contento, con una amistad duradera y algunas monedas de oro, ya que puede ofrecerte mapas especiales de vez en cuando, que pueden orientarte en direcciones de incursión rentables.\r\n\r\n</p> \r\n\r\n<p class=\"desc__text\">\r\n	Cuando decidas participar en una incursión, puedes elegir a tus guerreros entre un puñado de ajustes preestablecidos, los cuales se pueden personalizar ligeramente en un equipo cohesionado. Pero no todo son batallas: puedes asistir a bodas de tribus, beber demasiado y terminar con una resaca terrible y bien merecida después de las batallas de rap que tu personaje estará muy feliz de enviar al basurero de su memoria.\r\n</p> ', 'Ubisoft', 'Ubisoft', 0, '2020-11-10', '{\r\n  \"OS\": \"Windows 10\",\r\n  \"Procesador\": \"i5-4460 o Ryzen 3 1200\",\r\n  \"Memoria\": \"8 GB RAM\",\r\n  \"Gráfica\": \"GTX 960 o Radeon R9 380\",\r\n  \"DirectX\": \"9.0c\",\r\n  \"Almacenamiento\": \"50 GB\"\r\n}', '{\r\n  \"OS\": \"Windows 10\",\r\n  \"Procesador\": \"i7-4790 o Ryzen 5 1600\",\r\n  \"Memoria\": \"8 GB RAM\",\r\n  \"Gráfica\": \"GTX 1060 o Radeon RX 570\",\r\n  \"DirectX\": \"9.0c\",\r\n  \"Almacenamiento\": \"50 GB\"\r\n}', '59.00', 45, '0.0', 18),
(19, '\r\n<p class=\"desc__text\">\r\n	Assassin\'s Creed Valhalla para PC es la duodécima entrega de los juegos de Assassin\'s Creed, y este tiene lugar en el siglo IX (comenzando en 873 d.C.) llevándote por Europa mientras mueves tu clan desde una Noruega gravemente superpoblada y devastada por la guerra a Inglaterra, tierra verde de paz, prosperidad y campos fértiles para cultivar. Reino Unido puede tener la reputación de ser un lugar frío y lluvioso, pero en comparación con la desolación casi ártica, no es un sustituto tan malo. Es un juego de aventuras y acción de mundo abierto.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	¿Qué hacer?\r\n</h2> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	Los hermanos Eivor y Sigurd son los líderes de su intrépido grupo de vikingos y tú juegas como Eivor, que puede ser hombre o mujer. Sin embargo, no te preocupes por tu género, ya que puedes cambiarlo sobre la marcha, incluso en el fragor de la batalla si de repente te apetece un cambio.\r\n\r\nSi el combate no es lo tuyo, todavía hay mucho por hacer en el juego. Visita el establo para comprar caballos, entra en la cabaña de pesca antes de ir a los arroyos y lagos, y mantén tu equipo actualizado en la cabaña de caza. Incluso hay un aviario donde puedes personalizar tus cuervos con detalles como destellos blancos en sus alas. Como beneficio adicional, tus capturas de pesca o tus éxitos de caza se pueden vender a cambio de varias recompensas o como moneda del juego. Al ser vikingo, por supuesto, querrás mantener tu acceso al mar en buen estado y también hay un astillero donde puedes reparar, mantener, construir y reemplazar tu barco.\r\n</p> \r\n\r\n<p class=\"desc__text\">\r\n	\r\nEstarás ocupado al principio, aprendiendo habilidades y creando nuevos artículos, incluso mientras siembras y cultivas y disfrutarás de batallas ocasionales mientras los asaltantes intentan tomar lo que tienes. Establecer una panadería, una granja de ganado y una cervecería asegurarán que tú y tu clan estáis bien alimentados, mientras que Gunnar, el herrero, te forja algunas armas asombrosas.\r\n\r\n</p> \r\n\r\n<p class=\"desc__text\">\r\n	Vale la pena mantener al cartógrafo contento, con una amistad duradera y algunas monedas de oro, ya que puede ofrecerte mapas especiales de vez en cuando, que pueden orientarte en direcciones de incursión rentables.\r\n\r\n</p> \r\n\r\n<p class=\"desc__text\">\r\n	Cuando decidas participar en una incursión, puedes elegir a tus guerreros entre un puñado de ajustes preestablecidos, los cuales se pueden personalizar ligeramente en un equipo cohesionado. Pero no todo son batallas: puedes asistir a bodas de tribus, beber demasiado y terminar con una resaca terrible y bien merecida después de las batallas de rap que tu personaje estará muy feliz de enviar al basurero de su memoria.\r\n</p> ', 'Ubisoft', 'Ubisoft', 0, '2020-11-10', '{\r\n   \"Almacenamiento\": \"70GB\",\r\n   \"Red\": \"Conexión de red en modo online\"\r\n }\r\n', '{\r\n   \"Almacenamiento\": \"70GB\",\r\n   \"Red\": \"Conexión de red en modo online\"\r\n }\r\n', '49.99', 0, '0.0', 18);
INSERT INTO `features` (`id_feature`, `game_desc`, `game_developer`, `game_distributor`, `game_stock`, `game_date`, `min_req`, `max_req`, `game_price`, `game_discount`, `game_valoration`, `game_pegi`) VALUES
(20, '\r\n<p class=\"desc__text\">\r\n	Assassin\'s Creed Valhalla para PC es la duodécima entrega de los juegos de Assassin\'s Creed, y este tiene lugar en el siglo IX (comenzando en 873 d.C.) llevándote por Europa mientras mueves tu clan desde una Noruega gravemente superpoblada y devastada por la guerra a Inglaterra, tierra verde de paz, prosperidad y campos fértiles para cultivar. Reino Unido puede tener la reputación de ser un lugar frío y lluvioso, pero en comparación con la desolación casi ártica, no es un sustituto tan malo. Es un juego de aventuras y acción de mundo abierto.\r\n</p> \r\n\r\n\r\n<h2 class=\"desc__title\">\r\n	¿Qué hacer?\r\n</h2> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	Los hermanos Eivor y Sigurd son los líderes de su intrépido grupo de vikingos y tú juegas como Eivor, que puede ser hombre o mujer. Sin embargo, no te preocupes por tu género, ya que puedes cambiarlo sobre la marcha, incluso en el fragor de la batalla si de repente te apetece un cambio.\r\n\r\nSi el combate no es lo tuyo, todavía hay mucho por hacer en el juego. Visita el establo para comprar caballos, entra en la cabaña de pesca antes de ir a los arroyos y lagos, y mantén tu equipo actualizado en la cabaña de caza. Incluso hay un aviario donde puedes personalizar tus cuervos con detalles como destellos blancos en sus alas. Como beneficio adicional, tus capturas de pesca o tus éxitos de caza se pueden vender a cambio de varias recompensas o como moneda del juego. Al ser vikingo, por supuesto, querrás mantener tu acceso al mar en buen estado y también hay un astillero donde puedes reparar, mantener, construir y reemplazar tu barco.\r\n</p> \r\n\r\n<p class=\"desc__text\">\r\n	\r\nEstarás ocupado al principio, aprendiendo habilidades y creando nuevos artículos, incluso mientras siembras y cultivas y disfrutarás de batallas ocasionales mientras los asaltantes intentan tomar lo que tienes. Establecer una panadería, una granja de ganado y una cervecería asegurarán que tú y tu clan estáis bien alimentados, mientras que Gunnar, el herrero, te forja algunas armas asombrosas.\r\n\r\n</p> \r\n\r\n<p class=\"desc__text\">\r\n	Vale la pena mantener al cartógrafo contento, con una amistad duradera y algunas monedas de oro, ya que puede ofrecerte mapas especiales de vez en cuando, que pueden orientarte en direcciones de incursión rentables.\r\n\r\n</p> \r\n\r\n<p class=\"desc__text\">\r\n	Cuando decidas participar en una incursión, puedes elegir a tus guerreros entre un puñado de ajustes preestablecidos, los cuales se pueden personalizar ligeramente en un equipo cohesionado. Pero no todo son batallas: puedes asistir a bodas de tribus, beber demasiado y terminar con una resaca terrible y bien merecida después de las batallas de rap que tu personaje estará muy feliz de enviar al basurero de su memoria.\r\n</p> ', 'Ubisoft', 'Ubisoft', 3, '2020-11-10', '{\r\n   \"Almacenamiento\": \"70GB\",\r\n   \"Red\": \"Conexión de red en modo online\"\r\n }\r\n', '{\r\n   \"Almacenamiento\": \"70GB\",\r\n   \"Red\": \"Conexión de red en modo online\"\r\n }\r\n', '45.99', 0, '0.0', 18),
(21, '<p class=\"desc__text\">\r\n	Hotline Miami es un juego de acción de alto octanaje que rebosa brutalidad, disparos duros y combates cuerpo a cuerpo que aplastan el cráneo. Ambientado en un Miami alternativo de 1989, asumirás el papel de un misterioso antihéroe que se lanza a asesinar a los bajos fondos a instancias de las voces de tu contestador automático. Pronto te encontrarás luchando por entender qué está pasando y por qué eres propenso a estos actos de violencia.\r\n</p> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	Confía en tu ingenio para salir airoso de situaciones aparentemente imposibles, ya que te encuentras constantemente en inferioridad numérica respecto a los despiadados enemigos. La acción es implacable y cada disparo es mortal, por lo que cada movimiento debe ser rápido y decisivo si esperas sobrevivir y desvelar las siniestras fuerzas que impulsan el derramamiento de sangre. El inconfundible estilo visual de Hotline Miami, su banda sonora y una cadena de acontecimientos surrealistas te harán cuestionar tu propia sed de sangre mientras te llevan al límite con un desafío brutalmente implacable.\r\n\r\n</p> ', 'Dennaton Games', 'Devolver Digital', 4, '2012-10-23', '{\r\n  \"OS\": \"Windows 7\",\r\n  \"Procesador\": \"1.2Ghz\",\r\n  \"Memoria\": \"512 MB RAM\",\r\n  \"Gráfica\": \"DirectX 8 compatible\",\r\n  \"Almacenamiento\": \"250MB\"\r\n}', '{\r\n  \"OS\": \"Windows 7\",\r\n  \"Procesador\": \"1.4Ghz\",\r\n  \"Memoria\": \"1GB RAM\",\r\n  \"Gráfica\": \"DirectX 8 compatible\",\r\n  \"Almacenamiento\": \"250MB\"\r\n}', '2.25', 0, '0.0', 18),
(22, '<p class=\"desc__text\">\r\n	Hotline Miami es un juego de acción de alto octanaje que rebosa brutalidad, disparos duros y combates cuerpo a cuerpo que aplastan el cráneo. Ambientado en un Miami alternativo de 1989, asumirás el papel de un misterioso antihéroe que se lanza a asesinar a los bajos fondos a instancias de las voces de tu contestador automático. Pronto te encontrarás luchando por entender qué está pasando y por qué eres propenso a estos actos de violencia.\r\n</p> \r\n\r\n\r\n<p class=\"desc__text\">\r\n	Confía en tu ingenio para salir airoso de situaciones aparentemente imposibles, ya que te encuentras constantemente en inferioridad numérica respecto a los despiadados enemigos. La acción es implacable y cada disparo es mortal, por lo que cada movimiento debe ser rápido y decisivo si esperas sobrevivir y desvelar las siniestras fuerzas que impulsan el derramamiento de sangre. El inconfundible estilo visual de Hotline Miami, su banda sonora y una cadena de acontecimientos surrealistas te harán cuestionar tu propia sed de sangre mientras te llevan al límite con un desafío brutalmente implacable.\r\n\r\n</p> ', 'Dennaton Games', 'Devolver Digital', 1, '2012-10-23', '{\r\n   \"Almacenamiento\": \"250MB\",\r\n   \"Red\": \"Conexión de red en modo online\"\r\n }\r\n', '{\r\n   \"Almacenamiento\": \"250MB\",\r\n   \"Red\": \"Conexión de red en modo online\"\r\n }\r\n', '2.25', 25, '0.0', 18);

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
(6, 'Sniper Elite 5', 'sniper_elite_5'),
(14, 'Call of Duty Modern Warfare', 'call_of_duty_modern_warfare'),
(15, 'Call of Duty Vanguard', 'call_of_duty_vanguard'),
(16, 'Batman Arkham City', 'batman_arkham_city'),
(20, 'Hotline Miami\n', 'hotline_miami'),
(22, 'Assetto Corsa', 'assetto_corsa'),
(23, 'Assassins´s Creed Valhalla', 'assassins_creed_valhalla');

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
(5, 4, 9),
(6, 15, 10),
(5, 15, 11),
(3, 14, 12),
(6, 14, 13),
(5, 14, 14),
(3, 16, 15),
(3, 22, 16),
(4, 22, 17),
(4, 23, 18),
(5, 23, 19),
(6, 23, 20),
(3, 20, 21),
(2, 20, 22);

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
(1, 1, 1, 1, 'MVZTDSVM2MH4JKB'),
(2, 1, 1, 1, 'F608B4XOLF70FWV'),
(3, 1, 1, NULL, 'Y3B8FSUTZBA5DMS'),
(4, 1, 1, NULL, 'J2OSFRF08K6Z2ZR'),
(5, 1, 1, NULL, 'VRXYKW21057UWTK'),
(6, 1, 1, NULL, 'BPNMRAYFS9SNDDU'),
(7, 2, 2, NULL, '716CCFNMDBUN7L6'),
(8, 2, 2, NULL, 'ZJ39MY2JID9EXE2'),
(9, 2, 2, NULL, 'J0H6YADC3LVAGVP'),
(10, 2, 2, NULL, '6WKMHZ2MP4P06VH'),
(11, 2, 2, NULL, 'L79H8BM1XWVNA8J'),
(12, 6, 3, NULL, 'TU6EI7ACFMDU7QN'),
(13, 3, 4, NULL, 'P1UQL5B5VWCOB0O'),
(14, 3, 4, NULL, 'COQ834I3LYMRSLG'),
(15, 3, 4, NULL, 'EIVUQUAEE2COTPZ'),
(16, 3, 4, NULL, 'R9OP3YVNFD0PNHF'),
(17, 5, 6, NULL, 'Q68414VV767UPPG'),
(18, 5, 6, NULL, '79HV0XHPAE27CYM'),
(19, 5, 6, NULL, 'GBUDBOIGZUM8L0G'),
(20, 5, 6, NULL, 'E7PXOFF7VCI483I'),
(21, 3, 6, 2, '1B8N69C56IJLAI4'),
(22, 3, 6, 2, 'WTYOUUCSS2GQ4AY'),
(23, 3, 6, NULL, 'MN1XKZR829OLZGX'),
(24, 3, 6, NULL, 'VSJPZY3A30FTLE5'),
(25, 6, 15, 3, 'B7U4MVFTVP63BO1'),
(26, 6, 15, NULL, 'SR9IZTO5E1YWAX3'),
(27, 5, 15, NULL, 'SJFEA7S1WDOS5M9'),
(28, 5, 15, NULL, 'DZO7M0XPAQY1P46'),
(29, 3, 14, NULL, 'A2UPRHE82ZUGH6W'),
(30, 3, 14, NULL, 'TZEQY0JMKCWB4MU'),
(31, 3, 14, NULL, 'SDTBE97QVCL4AQI'),
(32, 3, 14, NULL, 'KVHT1MVY4YJ4OJH'),
(33, 6, 14, 3, 'NZ5PHZGCHITK949'),
(34, 6, 14, NULL, 'PXKOT9IP67LHZAG'),
(35, 5, 14, NULL, 'UMVD5GN53DND6MO'),
(36, 3, 20, NULL, 'W56LG2R60I9QYOQ'),
(37, 3, 20, NULL, 'AHMXMQSDTRSYKFN'),
(38, 3, 20, NULL, 'DBWT96LKNHU326L'),
(39, 3, 20, NULL, '54P6IO7ZD7BC31K'),
(40, 2, 20, NULL, '9UB7CN6IG6EOQYF'),
(41, 3, 22, NULL, 'HN5JTYOXXKY4GHU'),
(42, 3, 22, NULL, '0RYLS5HA73GOMRQ'),
(43, 3, 22, NULL, 'LBD1SNININ6IJ4P'),
(44, 3, 22, NULL, 'R39PQOFUOTCV9BB'),
(45, 4, 22, NULL, 'ARI8IH01D1ADQYR'),
(46, 4, 22, NULL, 'JFYKIDV4T89DWBO'),
(47, 3, 22, NULL, 'CG8SQUKE8MRHYII'),
(48, 6, 23, NULL, '1C86SLHP0E847UO'),
(49, 6, 23, NULL, 'GGTG2KTMZA1DOFQ'),
(50, 6, 23, NULL, 'F7TPFGB96D5JG5F');

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
(44, 'sniperElite5Info', 'Imagen del videojuego Sniper Elite 5', 1, 0),
(45, 'ac1_info', 'Imagen del videojuego Assetto Corsa', 1, 0),
(46, 'ac1', 'Imagen del videojuego Assetto Corsa', 0, 1),
(47, 'ac2', 'Imagen del videojuego Assetto Corsa', 0, 0),
(48, 'ac3', 'Imagen del videojuego Assetto Corsa', 0, 0),
(49, 'ac4', 'Imagen del videojuego Assetto Corsa', 0, 0),
(50, 'ac5', 'Imagen del videojuego Assetto Corsa', 0, 0),
(51, 'ac6', 'Imagen del videojuego Assetto Corsa', 0, 0),
(52, 'bac_info', 'Imagen del videojuego Batman Arkham City', 1, 0),
(53, 'bac1', 'Imagen del videojuego Batman Arkham City', 0, 1),
(54, 'bac2', 'Imagen del videojuego Batman Arkham City', 0, 1),
(55, 'bac3', 'Imagen del videojuego Batman Arkham City', 0, 1),
(56, 'bac4', 'Imagen del videojuego Batman Arkham City', 0, 1),
(57, 'bac5', 'Imagen del videojuego Batman Arkham City', 0, 1),
(58, 'bac6', 'Imagen del videojuego Batman Arkham City', 0, 1),
(59, 'cdmw_info', 'Imagen del videojuego Call of duty Modern Warfare', 1, 0),
(60, 'cdmw', 'Imagen del videojuego Call of duty Modern Warfare', 0, 1),
(61, 'cdmw2', 'Imagen del videojuego Call of duty Modern Warfare', 0, 0),
(62, 'cdmw3', 'Imagen del videojuego Call of duty Modern Warfare', 0, 0),
(63, 'cdmw4', 'Imagen del videojuego Call of duty Modern Warfare', 0, 0),
(64, 'cdv_info', 'Imagen del videojuego Call of duty Vanguard', 1, 0),
(65, 'cdv', 'Imagen del videojuego Call of duty Vanguard', 0, 1),
(66, 'cdv2', 'Imagen del videojuego Call of duty Vanguard', 0, 0),
(67, 'cdv3', 'Imagen del videojuego Call of duty Vanguard', 0, 0),
(68, 'cdv4', 'Imagen del videojuego Call of duty Vanguard', 0, 0),
(69, 'cdv5', 'Imagen del videojuego Call of duty Vanguard', 0, 0),
(70, 'hotline_info', 'Imagen del videojuego Hotline Miami', 1, 0),
(71, 'hotline', 'Imagen del videojuego Hotline Miami', 0, 1),
(72, 'hotline2', 'Imagen del videojuego Hotline Miami', 0, 0),
(73, 'hotline3', 'Imagen del videojuego Hotline Miami', 0, 0),
(74, 'hotline4', 'Imagen del videojuego Hotline Miami', 0, 0),
(75, 'hotline5', 'Imagen del videojuego Hotline Miami', 0, 0),
(76, 'hotline6', 'Imagen del videojuego Hotline Miami', 0, 0),
(171, 'acv_info', 'Imagen del videojuego assassins creed valhalla', 1, 0),
(172, 'acv', 'Imagen del videojuego assassins creed valhalla', 0, 1),
(173, 'acv2', 'Imagen del videojuego assassins creed valhalla', 0, 0),
(174, 'acv3', 'Imagen del videojuego assassins creed valhalla', 0, 0),
(175, 'acv4', 'Imagen del videojuego assassins creed valhalla', 0, 0);

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
(44, 6, 5),
(45, 22, 3),
(45, 22, 4),
(46, 22, 3),
(46, 22, 4),
(47, 22, 3),
(47, 22, 4),
(48, 22, 3),
(48, 22, 4),
(49, 22, 3),
(49, 22, 4),
(50, 22, 3),
(50, 22, 4),
(51, 22, 3),
(51, 22, 4),
(52, 16, 3),
(53, 16, 3),
(54, 16, 3),
(55, 16, 3),
(56, 16, 3),
(57, 16, 3),
(58, 16, 3),
(59, 14, 3),
(59, 14, 5),
(59, 14, 6),
(60, 14, 3),
(60, 14, 5),
(60, 14, 6),
(61, 14, 3),
(61, 14, 5),
(61, 14, 6),
(62, 14, 3),
(62, 14, 5),
(62, 14, 6),
(63, 14, 3),
(63, 14, 5),
(63, 14, 6),
(64, 15, 5),
(64, 15, 6),
(65, 15, 5),
(65, 15, 6),
(66, 15, 5),
(66, 15, 6),
(67, 15, 5),
(67, 15, 6),
(68, 15, 5),
(68, 15, 6),
(69, 15, 5),
(69, 15, 6),
(70, 20, 2),
(70, 20, 3),
(71, 20, 2),
(71, 20, 3),
(72, 20, 2),
(72, 20, 3),
(73, 20, 2),
(73, 20, 3),
(74, 20, 2),
(74, 20, 3),
(75, 20, 2),
(75, 20, 3),
(76, 20, 2),
(76, 20, 3),
(171, 23, 4),
(172, 23, 4),
(173, 23, 4),
(174, 23, 4),
(175, 23, 4);

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

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`id_order`, `id_user`, `order_date`, `order_total`, `id_billing`, `id_cart`, `id_card`) VALUES
(1, 2, '2022-06-14', '39.90', 2, 2, 9),
(2, 2, '2022-06-14', '100.00', 2, 11, 9),
(3, 2, '2022-06-14', '69.98', 2, 12, 9);

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

--
-- Volcado de datos para la tabla `reviews`
--

INSERT INTO `reviews` (`id_platform`, `id_game`, `id_user`, `review_calification`, `review_desc`, `review_date`) VALUES
(1, 1, 2, '8.0', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vitae dui libero. Donec ac pharetra magna. Aliquam convallis lacinia sagittis. Integer nunc erat, auctor sit amet porttitor ac, luctus vel nunc. Aenean lacinia risus at arcu porttitor nulla.', '2022-06-08 22:00:35'),
(1, 1, 3, '8.0', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vitae dui libero. Donec ac pharetra magna. Aliquam convallis lacinia sagittis. Integer nunc erat, auctor sit amet porttitor ac, luctus vel nunc. Aenean lacinia risus at arcu porttitor nulla.', '2022-06-09 14:00:40'),
(1, 1, 4, '9.0', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vitae dui libero. Donec ac pharetra magna. Aliquam convallis lacinia sagittis. Integer nunc erat, auctor sit amet porttitor ac, luctus vel nunc. Aenean lacinia risus at arcu porttitor nulla.', '2022-01-10 00:00:00'),
(1, 1, 5, '8.0', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vitae dui libero. Donec ac pharetra magna. Aliquam convallis lacinia sagittis. Integer nunc erat, auctor sit amet porttitor ac, luctus vel nunc. Aenean lacinia risus at arcu porttitor nulla.', '2022-01-10 00:00:00'),
(1, 1, 6, '5.5', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vitae dui libero. Donec ac pharetra magna. Aliquam convallis lacinia sagittis. Integer nunc erat, auctor sit amet porttitor ac, luctus vel nunc. Aenean lacinia risus at arcu porttitor nulla.', '2022-01-10 00:00:00'),
(1, 1, 7, '0.5', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vitae dui libero. Donec ac pharetra magna. Aliquam convallis lacinia sagittis. Integer nunc erat, auctor sit amet porttitor ac, luctus vel nunc. Aenean lacinia risus at arcu porttitor nulla.', '2022-01-10 00:00:00'),
(3, 3, 2, '2.0', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vitae dui libero. Donec ac pharetra magna. Aliquam convallis lacinia sagittis. Integer nunc erat, auctor sit amet porttitor ac, luctus vel nunc. Aenean lacinia risus at arcu porttitor nulla.', '2022-01-12 00:00:00'),
(5, 6, 2, '7.3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vitae dui libero. Donec ac pharetra magna. Aliquam convallis lacinia sagittis. Integer nunc erat, auctor sit amet porttitor ac, luctus vel nunc.', '2022-06-14 22:18:17'),
(6, 3, 3, '3.5', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vitae dui libero. Donec ac pharetra magna. Aliquam convallis lacinia sagittis. Integer nunc erat, auctor sit amet porttitor ac, luctus vel nunc. Aenean lacinia risus at arcu porttitor nulla.', '2022-01-10 00:00:00'),
(6, 3, 4, '7.3', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vitae dui libero. Donec ac pharetra magna. Aliquam convallis lacinia sagittis. Integer nunc erat, auctor sit amet porttitor ac, luctus vel nunc. Aenean lacinia risus at arcu porttitor nulla.', '2022-01-10 00:00:00'),
(6, 14, 2, '9.9', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque vitae dui libero. Donec ac pharetra magna. Aliquam convallis lacinia sagittis. Integer nunc erat, auctor sit amet porttitor ac, luctus vel nunc.', '2022-06-14 22:17:42');

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
(2, 'usuario 1', 'sagaraque@gmail.com', '$2y$13$LOfZHJ.XqBCToaiM9.w5te51r3Ej3OhL7QEYfyiw/Vk9eatQrmWda', 'default', 'ROLE_USER', 'ACTIVE', 24),
(3, 'usuario2', 'email1@gmail.com', '$2a$10$DHcXQgSuR111rBMm4wgo2ewtFKN087nNtyc7mfNghqau2j4.hAKdC', 'default', 'ROLE_USER', 'ACTIVE', 25),
(4, 'usuario3', 'email2@gmail.com', '$2a$10$V1VRVjbFJM3emyLvYaP79O/g6lgxW1FnyuPBB.JdfH1QLxYSGdznm', 'default', 'ROLE_USER', 'ACTIVE', 26),
(5, 'usuario4', 'email3@gmail.com', '$2a$10$F6inVPiUkIMU41bGznMwJefkrCdypjQEah904/Iosewjq/JCcnL0S', 'default', 'ROLE_USER', 'ACTIVE', 27),
(6, 'usuario5', 'email4@gmail.com', '$2a$10$AYc0pr5CFvOU6MYwb1CNYuv9CLdm/Lh.YzGov6lXHq8mDWexiCXKe', 'default', 'ROLE_USER', 'ACTIVE', 28),
(7, 'usuario6', 'email5@gmail.com', '$2a$10$6g7Rf/Rq91cM1tWE13pSMeUuTfEa7dvBLjllZK20wlC1uSRtXCnGm', 'default', 'ROLE_USER', 'ACTIVE', 29),
(8, 'usuario7', 'email6@gmail.com', '$2a$10$vZC6cti8orHZII4iDfAZlexruND4rswoDziZdyWKYvaUbYS5jbYey', 'default', 'ROLE_USER', 'ACTIVE', 30),
(9, 'usuario8', 'email7@gmail.com', '$2a$10$hANVVVZ2zu1nujumLWn/ae2VG8wzrqoFScaENFHPEbasMNWoHttAi', 'default', 'ROLE_USER', 'ACTIVE', 31),
(10, 'usuario9', 'email8@gmail.com', '$2a$10$JvMdXuqNrE6dMXJALzT3P.nFxg9jZsjZagkYumt60wP9gEgEu2pde', 'default', 'ROLE_USER', 'ACTIVE', 32);

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
(24),
(25),
(26),
(27),
(28),
(29),
(30),
(31),
(32);

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
-- Volcado de datos para la tabla `wishlist_games`
--

INSERT INTO `wishlist_games` (`id_game`, `id_wishlist`, `id_platform`) VALUES
(1, 24, 1),
(3, 24, 3),
(4, 24, 3),
(6, 24, 5),
(15, 24, 6),
(20, 24, 2),
(22, 24, 3);

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
  MODIFY `id_billing` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `card`
--
ALTER TABLE `card`
  MODIFY `id_card` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `cart`
--
ALTER TABLE `cart`
  MODIFY `id_cart` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `features`
--
ALTER TABLE `features`
  MODIFY `id_feature` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `games`
--
ALTER TABLE `games`
  MODIFY `id_game` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `game_keys`
--
ALTER TABLE `game_keys`
  MODIFY `id_key` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `media`
--
ALTER TABLE `media`
  MODIFY `id_media` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `platforms`
--
ALTER TABLE `platforms`
  MODIFY `id_platform` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id_wishlist` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

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
