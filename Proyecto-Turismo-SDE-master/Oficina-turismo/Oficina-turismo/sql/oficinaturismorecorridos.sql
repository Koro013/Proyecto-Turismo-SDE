-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-04-2025 a las 23:10:18
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `oficinaturismorecorridos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `IdCategoria` int(11) NOT NULL,
  `Descripcion` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`IdCategoria`, `Descripcion`) VALUES
(1, 'Cultural'),
(2, 'Aventura'),
(3, 'Naturaleza');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `chatbot`
--

CREATE TABLE `chatbot` (
  `IdChatbot` int(11) NOT NULL,
  `RespuestasPrecargadas` varchar(255) DEFAULT NULL,
  `HistorialDeConsultas` varchar(255) DEFAULT NULL,
  `IdLugar` int(11) DEFAULT NULL,
  `IdRecorrido` int(11) DEFAULT NULL,
  `IdUsuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `chatbot`
--

INSERT INTO `chatbot` (`IdChatbot`, `RespuestasPrecargadas`, `HistorialDeConsultas`, `IdLugar`, `IdRecorrido`, `IdUsuario`) VALUES
(1, 'El Museo Histórico está abierto de 09:00 a 17:00. Entrada: $200', 'Consulta sobre horarios y costos del Museo Histórico', 1, NULL, 1),
(2, 'El Parque Nacional es ideal para familias. Horario: 08:00-18:00', 'Consulta sobre actividades en el Parque Nacional', 2, 2, 1),
(3, 'El Recorrido Histórico incluye una visita al Museo Histórico y la Catedral Metropolitana.', 'Consulta sobre el Recorrido Histórico', 3, 1, 2),
(4, 'El Sendero del Bosque tiene una duración aproximada de 4 horas. Entrada: $50', 'Consulta sobre el Sendero del Bosque', 5, 5, 3),
(5, 'El Recorrido de Aventura incluye actividades extremas en el Parque de Aventuras.', 'Consulta sobre el Recorrido de Aventura', 7, 3, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `destinos`
--

CREATE TABLE `destinos` (
  `IdLugar` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Ubicacion` varchar(255) DEFAULT NULL,
  `ImagenDelLugar` varchar(255) DEFAULT NULL,
  `Horario` varchar(50) DEFAULT NULL,
  `CostoDeVisita` decimal(10,2) DEFAULT NULL,
  `EdadRecomendada` int(11) DEFAULT NULL,
  `Disponibilidad` tinyint(1) DEFAULT 1,
  `IdCategoria` int(11) NOT NULL,
  `Latitud` decimal(10,6) DEFAULT NULL,
  `Longitud` decimal(10,6) DEFAULT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `destinos`
--

INSERT INTO `destinos` (`IdLugar`, `Nombre`, `Ubicacion`, `ImagenDelLugar`, `Horario`, `CostoDeVisita`, `EdadRecomendada`, `Disponibilidad`, `IdCategoria`, `Latitud`, `Longitud`, `descripcion`) VALUES
(1, 'Museo Histórico', 'Centro de la ciudad', 'museohistorico.png', '09:00-17:00', 200.00, 12, 1, 1, NULL, NULL, NULL),
(2, 'Parque Nacional', 'Zona rural', 'parquenacional.png', '08:00-18:00', 150.00, 5, 1, 3, -25.968700, -61.990300, 'El Parque Nacional Copo es un área protegida que conserva especies únicas del Chaco seco. Ideal para los amantes de la naturaleza.'),
(3, 'Catedral Metropolitana', 'Plaza principal', 'catedral.png', '08:00-20:00', 0.00, 0, 1, 1, -27.795100, -64.261500, 'La Catedral Metropolitana es uno de los templos religiosos más antiguos e importantes de la provincia, ubicada en el corazón de la ciudad.'),
(4, 'Lago Azul', 'Zona montañosa', 'lagoazul.png', '07:00-19:00', 100.00, 6, 1, 3, NULL, NULL, NULL),
(5, 'Sendero del Bosque', 'Bosque nacional', 'senderobosque.png', '06:00-18:00', 50.00, 10, 1, 3, NULL, NULL, NULL),
(6, 'Museo de Arte Moderno', 'Zona céntrica', 'arte_moderno.png', '10:00-18:00', 250.00, 15, 1, 1, NULL, NULL, NULL),
(7, 'Parque de Aventuras', 'Zona norte', 'aventuras.png', '09:00-20:00', 300.00, 12, 1, 2, NULL, NULL, NULL),
(8, 'Cañón del Águila', 'Zona sur', 'canonaguila.png', '06:00-17:00', 350.00, 18, 1, 2, NULL, NULL, NULL),
(9, 'Jardín Botánico', 'Zona este', 'jardinbotanico.png', '09:00-18:00', 120.00, 5, 1, 3, -27.789000, -64.260500, 'El Jardín Botánico exhibe especies autóctonas y exóticas en un entorno ideal para paseos educativos y familiares.'),
(10, 'Ruinas Arqueológicas', 'Zona oeste', 'ruinas.png', '08:00-16:00', 200.00, 10, 1, 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutas`
--

CREATE TABLE `rutas` (
  `IdRecorrido` int(11) NOT NULL,
  `Nombre` varchar(100) NOT NULL,
  `Duracion` int(11) NOT NULL,
  `CostoDelRecorrido` decimal(10,2) DEFAULT NULL,
  `Descripcion` varchar(100) DEFAULT NULL,
  `EdadRecomendada` int(11) DEFAULT NULL,
  `IdCategoria` int(11) NOT NULL,
  `IdLugar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rutas`
--

INSERT INTO `rutas` (`IdRecorrido`, `Nombre`, `Duracion`, `CostoDelRecorrido`, `Descripcion`, `EdadRecomendada`, `IdCategoria`, `IdLugar`) VALUES
(1, 'Recorrido Histórico', 120, 850.00, 'Un paseo por los principales hitos históricos.', 12, 1, 1),
(2, 'Recorrido Natural', 180, 800.00, 'Explora el Parque Nacional y el Lago Azul.', 8, 3, 2),
(3, 'Recorrido de Aventura', 150, 1000.00, 'Actividades extremas en el Parque de Aventuras.', 15, 2, 7),
(4, 'Ruta Cultural', 200, 750.00, 'Visita a museos y la Catedral Metropolitana.', 10, 1, 3),
(5, 'Sendero del Bosque', 240, 600.00, 'Un recorrido tranquilo por el bosque.', 10, 3, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rutas_lugares`
--

CREATE TABLE `rutas_lugares` (
  `id` int(11) NOT NULL,
  `IdRecorrido` int(11) NOT NULL,
  `IdLugar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `rutas_lugares`
--

INSERT INTO `rutas_lugares` (`id`, `IdRecorrido`, `IdLugar`) VALUES
(1, 1, 1),
(2, 1, 3),
(3, 2, 2),
(4, 2, 4),
(5, 4, 3),
(6, 4, 6),
(7, 5, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `IdUsuario` int(11) NOT NULL,
  `Tipo` enum('Visitante','Admin') NOT NULL,
  `Permisos` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`IdUsuario`, `Tipo`, `Permisos`) VALUES
(1, 'Visitante', 'Consulta lugares y recorridos'),
(2, 'Admin', 'Gestión completa del sistema'),
(3, 'Visitante', 'Consulta lugares y recorridos'),
(4, 'Admin', 'Gestión completa del sistema');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password_hash`) VALUES
(1, 'admin', '$2y$10$YcIPiQ3ylCrRNR9wQ2kVwO3Ng5.xHtIM8JmHGLvVkcU6nfd54azRu'),
(2, 'admin2', '$2y$10$7QkeuM7vZyGWDnXIzbUgIOOe6uov26ihBy0oVuNsKxhq5IQzC5rHG');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`IdCategoria`);

--
-- Indices de la tabla `chatbot`
--
ALTER TABLE `chatbot`
  ADD PRIMARY KEY (`IdChatbot`),
  ADD KEY `IdLugar` (`IdLugar`),
  ADD KEY `IdRecorrido` (`IdRecorrido`),
  ADD KEY `IdUsuario` (`IdUsuario`);

--
-- Indices de la tabla `destinos`
--
ALTER TABLE `destinos`
  ADD PRIMARY KEY (`IdLugar`),
  ADD KEY `IdCategoria` (`IdCategoria`);

--
-- Indices de la tabla `rutas`
--
ALTER TABLE `rutas`
  ADD PRIMARY KEY (`IdRecorrido`),
  ADD KEY `IdCategoria` (`IdCategoria`),
  ADD KEY `IdLugar` (`IdLugar`);

--
-- Indices de la tabla `rutas_lugares`
--
ALTER TABLE `rutas_lugares`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IdRecorrido` (`IdRecorrido`),
  ADD KEY `IdLugar` (`IdLugar`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`IdUsuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `IdCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `chatbot`
--
ALTER TABLE `chatbot`
  MODIFY `IdChatbot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `destinos`
--
ALTER TABLE `destinos`
  MODIFY `IdLugar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `rutas`
--
ALTER TABLE `rutas`
  MODIFY `IdRecorrido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `rutas_lugares`
--
ALTER TABLE `rutas_lugares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `IdUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `chatbot`
--
ALTER TABLE `chatbot`
  ADD CONSTRAINT `chatbot_ibfk_1` FOREIGN KEY (`IdLugar`) REFERENCES `destinos` (`IdLugar`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `chatbot_ibfk_2` FOREIGN KEY (`IdRecorrido`) REFERENCES `rutas` (`IdRecorrido`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `chatbot_ibfk_3` FOREIGN KEY (`IdUsuario`) REFERENCES `usuario` (`IdUsuario`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `destinos`
--
ALTER TABLE `destinos`
  ADD CONSTRAINT `destinos_ibfk_1` FOREIGN KEY (`IdCategoria`) REFERENCES `categorias` (`IdCategoria`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `rutas`
--
ALTER TABLE `rutas`
  ADD CONSTRAINT `rutas_ibfk_1` FOREIGN KEY (`IdCategoria`) REFERENCES `categorias` (`IdCategoria`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rutas_ibfk_2` FOREIGN KEY (`IdLugar`) REFERENCES `destinos` (`IdLugar`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `rutas_lugares`
--
ALTER TABLE `rutas_lugares`
  ADD CONSTRAINT `rutas_lugares_ibfk_1` FOREIGN KEY (`IdRecorrido`) REFERENCES `rutas` (`IdRecorrido`) ON DELETE CASCADE,
  ADD CONSTRAINT `rutas_lugares_ibfk_2` FOREIGN KEY (`IdLugar`) REFERENCES `destinos` (`IdLugar`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
