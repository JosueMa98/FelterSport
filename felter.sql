-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-12-2024 a las 02:14:39
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `felter`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nombre_categoria` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nombre_categoria`) VALUES
(1, 'Gym'),
(2, 'Box'),
(3, 'Natación'),
(4, 'Tenis'),
(5, 'Futbol'),
(6, 'Beisbol'),
(7, 'Basquetbol');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalles_pedidos`
--

CREATE TABLE `detalles_pedidos` (
  `id_detalle` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalles_pedidos`
--

INSERT INTO `detalles_pedidos` (`id_detalle`, `id_pedido`, `id_producto`, `cantidad`, `precio_unitario`) VALUES
(1, 1, 4, 1, 350.00),
(2, 2, 8, 1, 100.00),
(3, 3, 6, 2, 500.00),
(4, 3, 2, 1, 700.00),
(9, 6, 11, 1, 2000.00),
(10, 7, 6, 1, 500.00),
(15, 8, 8, 1, 100.00),
(16, 9, 9, 1, 150.00),
(17, 10, 11, 1, 2000.00),
(18, 11, 2, 1, 700.00),
(19, 12, 11, 1, 2000.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `fecha_pedido` datetime DEFAULT current_timestamp(),
  `total` decimal(10,2) NOT NULL,
  `direccion_entrega` text NOT NULL,
  `estado` enum('pendiente','enviado','entregado','pagado') DEFAULT 'pendiente',
  `fecha_entrega` date DEFAULT NULL,
  `visible_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_usuario`, `fecha_pedido`, `total`, `direccion_entrega`, `estado`, `fecha_entrega`, `visible_admin`) VALUES
(1, 10, '2024-12-03 18:20:32', 0.00, '', '', NULL, 0),
(2, 10, '2024-12-03 18:57:29', 0.00, '', 'enviado', '2024-12-05', 0),
(3, 10, '2024-12-03 19:18:10', 0.00, '', 'enviado', '2024-12-05', 0),
(4, 10, '2024-12-03 19:44:27', 0.00, '', 'enviado', '2024-12-05', 0),
(5, 10, '2024-12-03 19:57:50', 0.00, '', 'enviado', '2024-12-01', 0),
(6, 10, '2024-12-03 19:59:00', 0.00, '', 'enviado', '2024-12-12', 0),
(7, 10, '2024-12-03 20:10:10', 0.00, '', 'enviado', '2024-12-04', 0),
(8, 10, '2024-12-03 20:13:55', 100.00, 'a', 'enviado', '2024-12-12', 1),
(9, 11, '2024-12-03 20:56:35', 150.00, '', 'pagado', NULL, 1),
(10, 12, '2024-12-03 20:58:58', 2000.00, '', 'pagado', NULL, 1),
(11, 11, '2024-12-03 21:08:43', 700.00, 'Bahia agiabampo 1579 colonia Nuevo Culican. Culiacan, Sinaloa', 'pagado', NULL, 1),
(12, 10, '2024-12-04 00:59:04', 2000.00, 'a', 'pagado', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `nombre_producto` varchar(255) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `imagen_url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `id_categoria`, `nombre_producto`, `descripcion`, `precio`, `stock`, `imagen_url`) VALUES
(1, 7, 'Balón Básquet', 'Balón oficial para partidos de básquetbol', 450.00, 19, 'img/balon_basquet.jpg'),
(2, 5, 'Balón Nike', 'Balón de fútbol Nike profesional', 700.00, 15, 'img/balon_nike.jpg'),
(3, 5, 'Espinillera', 'Espinilleras para fútbol', 300.00, 50, 'img/espinillera.jpeg'),
(4, 1, 'Faja Gym', 'Faja para levantamiento de pesas', 350.00, 25, 'img/faja_gym.jpg'),
(5, 3, 'Goggles', 'Goggles profesionales para natación', 200.00, 30, 'img/goggles.jpeg'),
(6, 2, 'Guantes Box', 'Guantes profesionales para boxeo', 500.00, 10, 'img/guantes_box.jpg'),
(7, 4, 'Raqueta', 'Raqueta para partidos de tenis', 800.00, 12, 'img/raqueta.jpeg'),
(8, 1, 'Straps', 'Correas para levantamiento de pesas', 100.00, 40, 'img/straps.jpeg'),
(9, 3, 'Gorro', 'Gorro deportivo para natación', 150.00, 25, 'img/gorro.jpeg'),
(11, 2, 'Careta de box', 'Protector De Cabeza Cleto Reyes Tradicional Barra Rojo', 2000.00, 5, 'img/careta_box.webp'),
(12, 6, 'Bat', 'Bat de beisbol', 966.00, 10, 'img/Bat.jpeg'),
(13, 1, 'Coderas para pesas', 'Vendas para Codo Felter Fitness Negras 1 Par', 333.00, 100, 'img/coderas_gym.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `contraseña` varchar(255) DEFAULT NULL,
  `tipo_usuario` enum('cliente','admin') DEFAULT 'cliente',
  `nombre` varchar(100) DEFAULT NULL,
  `direccion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `correo`, `contraseña`, `tipo_usuario`, `nombre`, `direccion`) VALUES
(1, 'L20171583@culiacan.tecnm.mx', '$2y$10$nQpLHPG7dzXhzcbsQIh/Se4xnaST7uaOtvZm76yalZRWixPLz8VHW', 'admin', 'Josue', NULL),
(10, 'correo@gmail.com', '$2y$10$UkcuG7HSUfx5VGK288mC3ukC3T9CV628N09iWTDHWARJGU6G4Iddq', 'cliente', 'a', 'a'),
(11, 'correo1@gmail.com', '$2y$10$mes09OyfN4sHZyWSWOz.6uh91HyTasHb8lB3ww0SmSWqNZPW0.Tom', 'cliente', 'Karina', 'Bahia agiabampo 1579 colonia Nuevo Culican. Culiacan, Sinaloa'),
(12, 'correo2@gmail.com', '$2y$10$0Q9wFElSubciFfGA57zKEe2b3dQ.3RgCQ77qKGuNhWOJfO3A7ZL7W', 'cliente', 'karen', 'mexico');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indices de la tabla `detalles_pedidos`
--
ALTER TABLE `detalles_pedidos`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_pedido` (`id_pedido`),
  ADD KEY `id_producto` (`id_producto`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `detalles_pedidos`
--
ALTER TABLE `detalles_pedidos`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalles_pedidos`
--
ALTER TABLE `detalles_pedidos`
  ADD CONSTRAINT `detalles_pedidos_ibfk_1` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`),
  ADD CONSTRAINT `detalles_pedidos_ibfk_2` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
