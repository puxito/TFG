-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 02-06-2024 a las 12:20:26
-- Versión del servidor: 8.0.36-0ubuntu0.22.04.1
-- Versión de PHP: 8.1.2-1ubuntu2.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `BD_FitFood`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `idCategoria` int NOT NULL,
  `nombreCategoria` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comidas`
--

CREATE TABLE `comidas` (
  `idComida` int NOT NULL,
  `nombreComida` varchar(45) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `hcarbonoTotales` decimal(6,2) DEFAULT NULL,
  `caloriasTotales` decimal(6,2) DEFAULT NULL,
  `grasasTotales` decimal(6,2) DEFAULT NULL,
  `proteinasTotales` decimal(6,2) DEFAULT NULL,
  `idUsuarioFK` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comidasProductos`
--

CREATE TABLE `comidasProductos` (
  `idComProd` int NOT NULL,
  `idComidaFK` int NOT NULL,
  `idProductoFK` int NOT NULL,
  `cantidad` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `idEvento` int NOT NULL,
  `idUsuario` int NOT NULL,
  `title` varchar(60) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `color` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci DEFAULT '#c8c8c8'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `idUsuarioFK` int NOT NULL,
  `idProductoFK` int NOT NULL,
  `idFavorito` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int NOT NULL,
  `nombreProducto` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `cantidadProducto` decimal(6,2) NOT NULL,
  `hcarbonoProducto` decimal(6,2) DEFAULT NULL,
  `caloriasProducto` decimal(6,2) NOT NULL,
  `grasasProducto` decimal(6,2) NOT NULL,
  `proteinasProducto` decimal(6,2) NOT NULL,
  `imgProducto` varchar(100) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `idCategoriaFK` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idRol` int NOT NULL,
  `nombreRol` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int NOT NULL,
  `nombreUsuario` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `apellidosUsuario` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `correoElectronicoUsuario` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fechaNacimientoUsuario` date NOT NULL,
  `fechaRegistroUsuario` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `contraseña` varchar(100) COLLATE utf8mb4_spanish2_ci NOT NULL,
  `imagenUsuario` varchar(200) COLLATE utf8mb4_spanish2_ci NOT NULL DEFAULT 'users/default.png',
  `idRolFK` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Indices de la tabla `comidas`
--
ALTER TABLE `comidas`
  ADD PRIMARY KEY (`idComida`);

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`idEvento`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD PRIMARY KEY (`idFavorito`),
  ADD KEY `idUsuarioFK` (`idUsuarioFK`),
  ADD KEY `idProductoFK` (`idProductoFK`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `idCategoriaFK` (`idCategoriaFK`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUsuario`),
  ADD KEY `idRolFK` (`idRolFK`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idCategoria` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `comidas`
--
ALTER TABLE `comidas`
  MODIFY `idComida` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `idEvento` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `favoritos`
--
ALTER TABLE `favoritos`
  MODIFY `idFavorito` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `idRol` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`);

--
-- Filtros para la tabla `favoritos`
--
ALTER TABLE `favoritos`
  ADD CONSTRAINT `favoritos_ibfk_1` FOREIGN KEY (`idUsuarioFK`) REFERENCES `usuarios` (`idUsuario`),
  ADD CONSTRAINT `favoritos_ibfk_2` FOREIGN KEY (`idProductoFK`) REFERENCES `productos` (`idProducto`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`idCategoriaFK`) REFERENCES `categorias` (`idCategoria`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`idRolFK`) REFERENCES `roles` (`idRol`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
