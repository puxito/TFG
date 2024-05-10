-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 09-05-2024 a las 11:31:04
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
  `nombreCategoria` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`idCategoria`, `nombreCategoria`) VALUES
(1, 'Carnes'),
(2, 'Embutidos'),
(3, 'Pescados'),
(4, 'Mariscos'),
(5, 'Lacteos'),
(6, 'Panes'),
(7, 'Cereales'),
(8, 'Frutos Secos'),
(9, 'Pastas'),
(10, 'Vegetales'),
(11, 'Frutas'),
(12, 'Especias'),
(13, 'Salsas'),
(14, 'Legumbres'),
(15, 'Aceites'),
(16, 'Vinagres'),
(17, 'Agua'),
(18, 'Batidos'),
(19, 'Zumos'),
(20, 'Refrescos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comidas`
--

CREATE TABLE `comidas` (
  `idComida` int NOT NULL,
  `nombreComida` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `comidas`
--

INSERT INTO `comidas` (`idComida`, `nombreComida`) VALUES
(1, 'Desayuno'),
(2, 'Almuerzo'),
(3, 'Merienda'),
(4, 'Cena');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comidasproductos`
--

CREATE TABLE `comidasproductos` (
  `idComidaFK` int NOT NULL,
  `idProductoFK` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dietas`
--

CREATE TABLE `dietas` (
  `idDieta` int NOT NULL,
  `nombreDieta` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `tipoDieta` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `observacionesDieta` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `dietas`
--

INSERT INTO `dietas` (`idDieta`, `nombreDieta`, `tipoDieta`, `observacionesDieta`) VALUES
(1, 'Dieta 1', 'Volumen', 'N/A'),
(2, 'Dieta 2', 'Definicion', 'N/A'),
(3, 'Dieta 3', 'Equilibrada', 'N/A'),
(4, 'Dieta 4', 'Volumen', 'N/A'),
(5, 'Dieta 5', 'Definicion', 'N/A'),
(6, 'Dieta 6', 'Equilibrada', 'N/A'),
(7, 'Dieta 7', 'Volumen', 'N/A'),
(8, 'Dieta 8', 'Definicion', 'N/A'),
(9, 'Dieta 9', 'Equilibrada', 'N/A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dietascomidas`
--

CREATE TABLE `dietascomidas` (
  `idDietaFK` int NOT NULL,
  `idComidaFK` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `idProducto` int NOT NULL,
  `nombreProducto` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `cantidadProducto` decimal(6,2) NOT NULL,
  `caloriasProducto` decimal(6,2) NOT NULL,
  `grasasProducto` decimal(6,2) NOT NULL,
  `proteinasProducto` decimal(6,2) NOT NULL,
  `imagenProducto` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `idCategoriaFK` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`idProducto`, `nombreProducto`, `cantidadProducto`, `caloriasProducto`, `grasasProducto`, `proteinasProducto`, `imagenProducto`, `idCategoriaFK`) VALUES
(1, 'Pechuga de Pollo', '1.00', '104.00', '3.57', '28.04', 'N/A', 1),
(2, 'Solomillo de Cerdo', '1.00', '133.00', '4.05', '22.49', 'N/A', 1),
(3, 'Pechuga de Pavo', '1.00', '167.00', '5.98', '26.94', 'N/A', 1),
(4, 'Solomillo de Ternera', '1.00', '110.00', '2.59', '20.20', 'N/A', 1),
(5, 'Chuletón de Ternera', '1.00', '142.00', '7.02', '21.02', 'N/A', 1),
(6, 'Chuletón de Cerdo', '1.00', '149.00', '8.53', '20.13', 'N/A', 1),
(7, 'Carne Ternera picada', '1.00', '136.00', '5.97', '21.86', 'N/A', 1),
(8, 'Salchicha de Cerdo', '1.00', '118.00', '6.05', '22.64', 'N/A', 1),
(9, 'Salchicha de Pollo', '1.00', '111.00', '5.36', '19.48', 'N/A', 1),
(10, 'Jamón Serrano', '1.00', '110.00', '2.59', '20.20', 'N/A', 2),
(11, 'Jamón York', '1.00', '125.00', '4.46', '17.86', 'N/A', 2),
(12, 'Chorizo', '1.00', '346.00', '28.10', '19.30', 'N/A', 2),
(13, 'Salchichón', '1.00', '189.00', '8.04', '17.08', 'N/A', 2),
(14, 'Lomo Embuchado', '1.00', '173.00', '6.08', '27.58', 'N/A', 2),
(15, 'Fuet', '1.00', '206.00', '12.86', '23.71', 'N/A', 2),
(16, 'Chopped', '1.00', '193.00', '10.68', '21.81', 'N/A', 2),
(17, 'Mortadela', '1.00', '311.00', '25.39', '16.37', 'N/A', 2),
(18, 'Morcilla', '1.00', '379.00', '34.50', '14.60', 'N/A', 2),
(19, 'Foie Gras', '1.00', '462.00', '43.84', '11.40', 'N/A', 2),
(20, 'Atún ', '1.00', '144.00', '4.90', '23.33', 'N/A', 3),
(21, 'Bacalao', '1.00', '82.00', '0.67', '17.81', 'N/A', 3),
(22, 'Boquerón o Anchoa', '1.00', '406.00', '18.75', '12.50', 'N/A', 3),
(23, 'Merluza', '1.00', '78.00', '0.88', '17.54', 'N/A', 3),
(24, 'Pez Espada', '1.00', '144.00', '6.65', '19.66', 'N/A', 3),
(25, 'Rape', '1.00', '76.00', '1.52', '14.48', 'N/A', 3),
(26, 'Sardina', '1.00', '208.00', '11.45', '24.62', 'N/A', 3),
(27, 'Dorada', '1.00', '156.00', '4.67', '19.78', 'N/A', 3),
(28, 'Lubina', '1.00', '114.00', '3.69', '18.86', 'N/A', 3),
(29, 'Salmón', '1.00', '127.00', '4.40', '20.50', 'N/A', 3),
(30, 'Bogavante', '1.00', '88.00', '0.85', '18.88', 'N/A', 4),
(31, 'Cigala', '1.00', '74.00', '0.65', '18.36', 'N/A', 4),
(32, 'Gamba', '1.00', '71.00', '0.00', '17.86', 'N/A', 4),
(33, 'Cangrejo', '1.00', '77.00', '0.95', '15.97', 'N/A', 4),
(34, 'Langosta', '1.00', '90.00', '0.89', '18.73', 'N/A', 4),
(35, 'Langostino', '1.00', '75.00', '0.57', '18.01', 'N/A', 4),
(36, 'Percebe', '1.00', '72.00', '0.67', '17.11', 'N/A', 4),
(37, 'Almeja', '1.00', '68.00', '0.63', '16.43', 'N/A', 4),
(38, 'Coquina', '1.00', '64.00', '0.59', '15.28', 'N/A', 4),
(39, 'Mejillón', '1.00', '66.00', '0.68', '15.95', 'N/A', 4),
(40, 'Ostra', '1.00', '71.00', '0.71', '16.02', 'N/A', 4),
(41, 'Vieira', '1.00', '73.00', '0.70', '15.98', 'N/A', 4),
(42, 'Calamar', '1.00', '82.00', '0.82', '18.31', 'N/A', 4),
(43, 'Pulpo', '1.00', '84.00', '0.84', '18.74', 'N/A', 4),
(44, 'Choco o Sepia', '1.00', '81.00', '0.81', '18.55', 'N/A', 4),
(45, 'Leche', '1.00', '62.00', '3.33', '3.33', 'N/A', 5),
(46, 'Leche Condensada', '1.00', '8.70', '7.91', '54.40', 'N/A', 5),
(47, 'Leche Evaporada', '1.00', '6.30', '5.90', '49.70', 'N/A', 5),
(48, 'Leche de Almendras', '1.00', '1.06', '0.42', '6.78', 'N/A', 5),
(49, 'Leche de Avena', '1.00', '0.98', '0.57', '6.11', 'N/A', 5),
(50, 'Leche de Coco', '1.00', '2.08', '0.21', '2.92', 'N/A', 5),
(51, 'Leche de Soja', '1.00', '1.72', '0.34', '1.85', 'N/A', 5),
(52, 'Queso ', '1.00', '21.43', '17.86', '3.57', 'N/A', 5),
(53, 'Queso ricotta', '1.00', '11.29', '11.29', '6.45', 'N/A', 5),
(54, 'Yogur', '1.00', '0.37', '10.30', '3.64', 'N/A', 5),
(55, 'Mantequilla', '1.00', '81.11', '0.85', '0.06', 'N/A', 5),
(56, 'Mantequilla de Cacahuetes', '1.00', '102.03', '0.67', '0.09', 'N/A', 5),
(57, 'Nata', '1.00', '33.94', '2.67', '8.59', 'N/A', 5),
(58, 'Helado', '1.00', '11.00', '3.80', '28.20', 'N/A', 5),
(59, 'Pan Blanco ', '1.00', '3.49', '9.30', '74.42', 'N/A', 6),
(60, 'Pan Integral', '1.00', '6.45', '9.68', '45.16', 'N/A', 6),
(61, 'Pan de Centeno', '1.00', '3.30', '8.50', '48.30', 'N/A', 6),
(62, 'Pan de Masa Madre', '1.00', '4.48', '6.94', '69.01', 'N/A', 6),
(63, 'Pan Multicereales', '1.00', '4.53', '10.67', '47.54', 'N/A', 6),
(64, 'Baguette', '1.00', '0.00', '8.93', '53.57', 'N/A', 6),
(65, 'Chapata', '1.00', '0.00', '9.13', '61.01', 'N/A', 6),
(66, 'Pan Brioche', '1.00', '4.26', '11.32', '38.75', 'N/A', 6),
(67, 'Bagel', '1.00', '5.28', '10.69', '42.36', 'N/A', 6),
(68, 'Mollete', '1.00', '4.79', '9.97', '41.09', 'N/A', 6),
(69, 'Arroz', '1.00', '0.28', '2.67', '27.99', 'N/A', 7),
(70, 'Maíz', '1.00', '4.74', '9.42', '74.26', 'N/A', 7),
(71, 'Centeno', '1.00', '1.63', '10.34', '75.86', 'N/A', 7),
(72, 'Trigo', '1.00', '1.27', '7.49', '42.53', 'N/A', 7),
(73, 'Avena', '1.00', '7.03', '17.30', '66.22', 'N/A', 7),
(74, 'Cebada', '1.00', '1.16', '9.91', '77.72', 'N/A', 7),
(75, 'Quinoa', '1.00', '6.07', '14.12', '64.16', 'N/A', 7),
(76, 'Espelta', '1.00', '2.43', '14.57', '70.19', 'N/A', 7),
(77, 'Mijo', '1.00', '4.22', '11.02', '72.85', 'N/A', 7),
(78, 'Avellanas', '1.00', '60.75', '14.95', '16.70', 'N/A', 8),
(79, 'Cacahuetes', '1.00', '49.24', '25.80', '16.13', 'N/A', 8),
(80, 'Almendras', '1.00', '50.00', '20.00', '20.00', 'N/A', 8),
(81, 'Nueces', '1.00', '64.29', '14.29', '14.29', 'N/A', 8),
(82, 'Piñones', '1.00', '68.37', '13.69', '13.08', 'N/A', 8),
(83, 'Pistachos', '1.00', '45.32', '20.16', '27.17', 'N/A', 8),
(84, 'Castañas', '1.00', '2.20', '3.17', '52.96', 'N/A', 8),
(85, 'Semillas de Calabaza', '1.00', '49.05', '30.23', '10.71', 'N/A', 8),
(86, 'Anacardos', '1.00', '43.85', '18.22', '30.19', 'N/A', 8),
(87, 'Nueces de Macadamia', '1.00', '75.77', '7.91', '13.82', 'N/A', 8),
(88, 'Semillas de Girasol', '1.00', '51.46', '20.78', '20.00', 'N/A', 8),
(89, 'Macarrones', '1.00', '0.11', '4.53', '26.61', 'N/A', 9),
(90, 'Gnocchi', '1.00', '0.08', '4.38', '25.71', 'N/A', 9),
(91, 'Pasta de Hojas', '1.00', '0.07', '4.29', '25.02', 'N/A', 9),
(92, 'Espaguetis', '1.00', '0.21', '8.86', '30.88', 'N/A', 9),
(93, 'Tallarines', '1.00', '0.20', '8.75', '29.45', 'N/A', 9),
(94, 'Fettuccine', '1.00', '0.19', '8.73', '28.98', 'N/A', 9),
(95, 'Tagliatelle', '1.00', '0.18', '8.52', '28.91', 'N/A', 9),
(96, 'Ravioli', '1.00', '0.17', '8.69', '28.86', 'N/A', 9),
(97, 'Tortellini', '1.00', '0.18', '8.54', '28.76', 'N/A', 9),
(98, 'Lechuga', '1.00', '0.15', '1.36', '2.87', 'N/A', 10),
(99, 'Tomate', '1.00', '0.20', '0.88', '3.89', 'N/A', 10),
(100, 'Cebolla', '1.00', '0.10', '1.10', '9.34', 'N/A', 10),
(101, 'Berenjena', '1.00', '0.18', '0.98', '5.88', 'N/A', 10),
(102, 'Calabacin', '1.00', '0.32', '1.21', '3.11', 'N/A', 10),
(103, 'Cebolleta', '1.00', '0.73', '3.27', '4.35', 'N/A', 10),
(104, 'Pimiento Verde', '1.00', '0.33', '0.96', '6.67', 'N/A', 10),
(105, 'Pimiento Rojo', '1.00', '0.30', '0.99', '6.03', 'N/A', 10),
(106, 'Pepino', '1.00', '0.11', '0.65', '3.63', 'N/A', 10),
(107, 'Coliflor', '1.00', '0.22', '1.61', '3.75', 'N/A', 10),
(108, 'Espinaca', '1.00', '0.26', '2.97', '3.75', 'N/A', 10),
(109, 'Acelga', '1.00', '0.08', '1.88', '4.13', 'N/A', 10),
(110, 'Brocoli', '1.00', '0.41', '2.38', '7.18', 'N/A', 10),
(111, 'Alcachofa', '1.00', '0.15', '3.27', '10.51', 'N/A', 10),
(112, 'Zanahoria', '1.00', '0.24', '0.93', '9.58', 'N/A', 10),
(113, 'Calabaza', '1.00', '0.10', '1.00', '6.50', 'N/A', 10),
(114, 'Remolacha', '1.00', '0.17', '1.61', '9.56', 'N/A', 10),
(115, 'Patata', '1.00', '0.09', '2.05', '17.49', 'N/A', 10),
(116, 'Boniato', '1.00', '0.51', '2.49', '8.82', 'N/A', 10),
(117, 'Yuca', '1.00', '0.47', '2.03', '7.67', 'N/A', 10),
(118, 'Ajo', '1.00', '0.00', '0.00', '0.00', 'N/A', 10),
(119, 'Apio', '1.00', '14.00', '0.17', '2.97', 'N/A', 10),
(120, 'Puerro', '1.00', '12.00', '0.15', '2.60', 'N/A', 10),
(121, 'Esparrago', '1.00', '16.00', '0.20', '2.87', 'N/A', 10),
(122, 'Fresa', '1.00', '32.00', '0.30', '0.67', 'N/A', 11),
(123, 'Melocotón', '1.00', '42.00', '0.00', '0.91', 'N/A', 11),
(124, 'Ciruela', '1.00', '250.00', '0.00', '0.00', 'N/A', 11),
(125, 'Frambuesa', '1.00', '52.00', '0.00', '1.20', 'N/A', 11),
(126, 'Arándano', '1.00', '46.00', '0.00', '0.46', 'N/A', 11),
(127, 'Mandarina', '1.00', '53.00', '0.00', '0.81', 'N/A', 11),
(128, 'Naranja', '1.00', '97.00', '0.00', '1.50', 'N/A', 11),
(129, 'Mango', '1.00', '60.00', '0.00', '0.82', 'N/A', 11),
(130, 'Limón', '1.00', '70.00', '0.00', '1.12', 'N/A', 11),
(131, 'Kiwi', '1.00', '58.00', '0.00', '1.06', 'N/A', 11),
(132, 'Piña', '1.00', '50.00', '0.00', '0.54', 'N/A', 11),
(133, 'Manzana', '1.00', '62.00', '0.00', '0.19', 'N/A', 11),
(134, 'Uva Morada', '1.00', '93.00', '0.00', '5.60', 'N/A', 11),
(135, 'Uva Blanca', '1.00', '88.00', '0.00', '5.50', 'N/A', 11),
(136, 'Coco', '1.00', '354.00', '0.00', '3.33', 'N/A', 11),
(137, 'Plátano', '1.00', '89.00', '0.00', '1.09', 'N/A', 11),
(138, 'Cereza', '1.00', '32.00', '0.00', '0.43', 'N/A', 11),
(139, 'Higo', '1.00', '74.00', '0.00', '0.75', 'N/A', 11),
(140, 'Melón', '1.00', '34.00', '0.00', '0.82', 'N/A', 11),
(141, 'Pera', '1.00', '57.00', '0.00', '0.36', 'N/A', 11),
(142, 'Sandía', '1.00', '30.00', '0.00', '0.61', 'N/A', 11),
(143, 'Granada', '1.00', '83.00', '0.00', '1.67', 'N/A', 11),
(144, 'Albaricoque', '1.00', '48.00', '0.00', '1.40', 'N/A', 11),
(145, 'Lima', '1.00', '30.00', '0.00', '0.70', 'N/A', 11),
(146, 'Aguacate', '1.00', '160.00', '0.00', '2.00', 'N/A', 11),
(147, 'Mora', '1.00', '43.00', '0.00', '1.39', 'N/A', 11),
(148, 'Sal', '1.00', '0.00', '0.00', '0.00', 'N/A', 12),
(149, 'Pimienta', '1.00', '0.00', '0.00', '0.00', 'N/A', 12),
(150, 'Cúrcuma', '1.00', '0.00', '0.00', '0.00', 'N/A', 12),
(151, 'Orégano', '1.00', '0.00', '0.00', '0.00', 'N/A', 12),
(152, 'Comino', '1.00', '0.00', '0.00', '0.00', 'N/A', 12),
(153, 'Curry', '1.00', '0.00', '0.00', '0.00', 'N/A', 12),
(154, 'Pimentón Rojo', '1.00', '0.00', '0.00', '0.00', 'N/A', 12),
(155, 'Canela', '1.00', '0.00', '0.00', '0.00', 'N/A', 12),
(156, 'Romero', '1.00', '0.00', '0.00', '0.00', 'N/A', 12),
(157, 'Laurel', '1.00', '0.00', '0.00', '0.00', 'N/A', 12),
(158, 'Tomillo', '1.00', '0.00', '0.00', '0.00', 'N/A', 12),
(159, 'Albahaca', '1.00', '0.00', '0.00', '0.00', 'N/A', 12),
(160, 'Ázafran', '1.00', '0.00', '0.00', '0.00', 'N/A', 12),
(161, 'Perejil', '1.00', '0.00', '0.00', '0.00', 'N/A', 12),
(162, 'Vainilla', '1.00', '0.00', '0.00', '0.00', 'N/A', 12),
(163, 'Ketchup', '1.00', '50.00', '0.00', '1.45', 'N/A', 13),
(164, 'Mayonesa', '1.00', '55.00', '0.00', '1.69', 'N/A', 13),
(165, 'Mostaza', '1.00', '48.00', '0.00', '1.37', 'N/A', 13),
(166, 'Alioli', '1.00', '57.00', '0.00', '1.73', 'N/A', 13),
(167, 'Salsa Barbacoa', '1.00', '43.00', '0.00', '1.39', 'N/A', 13),
(168, 'Salsa de Tomate', '1.00', '30.00', '0.00', '1.16', 'N/A', 13),
(169, 'Salsa de Soja', '1.00', '33.00', '0.00', '0.00', 'N/A', 13),
(170, 'Salsa Picante o Tabasco', '1.00', '90.00', '0.00', '0.00', 'N/A', 13),
(171, 'Salsa Mojo Picón', '1.00', '182.00', '0.00', '3.03', 'N/A', 13),
(172, 'Salsa Agridulce', '1.00', '154.00', '0.00', '0.27', 'N/A', 13),
(173, 'Alfalfa', '1.00', '371.00', '9.74', '36.17', 'N/A', 14),
(174, 'Altramuces', '1.00', '367.00', '9.73', '33.71', 'N/A', 14),
(175, 'Frijoles o Habichuelas', '1.00', '284.00', '6.71', '40.05', 'N/A', 14),
(176, 'Garbanzos', '1.00', '378.00', '6.04', '20.47', 'N/A', 14),
(177, 'Guisantes', '1.00', '81.00', '0.40', '5.42', 'N/A', 14),
(178, 'Habas', '1.00', '341.00', '1.22', '19.51', 'N/A', 14),
(179, 'Judías Verdes', '1.00', '31.00', '0.22', '1.83', 'N/A', 14),
(180, 'Lentejas', '1.00', '352.00', '1.06', '24.63', 'N/A', 14),
(181, 'Aceite de Oliva', '1.00', '884.00', '100.00', '0.00', 'N/A', 15),
(182, 'Aceite de Girasol', '1.00', '884.00', '100.00', '0.00', 'N/A', 15),
(183, 'Aceite de Maíz', '1.00', '884.00', '100.00', '0.00', 'N/A', 15),
(184, 'Aceite de Palma', '1.00', '884.00', '100.00', '0.00', 'N/A', 15),
(185, 'Vinagre Blanco', '1.00', '0.00', '0.00', '0.00', 'N/A', 16),
(186, 'Vinagre de Vino', '1.00', '0.00', '0.00', '0.00', 'N/A', 16),
(187, 'Vinagre de Manzana', '1.00', '21.00', '0.00', '0.00', 'N/A', 16),
(188, 'Vinagre de Jerez', '1.00', '33.00', '0.00', '0.00', 'N/A', 16),
(189, 'Vinagre de Módena', '1.00', '40.00', '0.00', '0.00', 'N/A', 16),
(190, 'Vinagre de Sidra', '1.00', '35.00', '0.00', '0.00', 'N/A', 16),
(191, 'Agua Mineral', '1.00', '0.00', '0.00', '0.00', 'N/A', 17),
(192, 'Agua con Gas', '1.00', '0.00', '0.00', '0.00', 'N/A', 17),
(193, 'Batido de Chocolate', '1.00', '119.00', '3.39', '4.24', 'N/A', 18),
(194, 'Batido de Vainilla', '1.00', '161.00', '6.71', '3.36', 'N/A', 18),
(195, 'Batido de Fresa', '1.00', '134.00', '4.59', '3.92', 'N/A', 18),
(196, 'Zumo de Naranja', '1.00', '46.00', '0.00', '0.83', 'N/A', 19),
(197, 'Zumo de Melocotón', '1.00', '39.00', '0.00', '0.00', 'N/A', 19),
(198, 'Zumo de Manzana', '1.00', '49.00', '0.00', '0.00', 'N/A', 19),
(199, 'Zumo de Piña', '1.00', '50.00', '0.00', '0.00', 'N/A', 19),
(200, 'Zumo de Tomate', '1.00', '17.00', '0.00', '0.83', 'N/A', 19),
(201, 'Zumo de Uva', '1.00', '40.00', '0.00', '0.00', 'N/A', 19),
(202, 'Zumo de Frutos Rojos', '1.00', '37.00', '0.00', '0.00', 'N/A', 19),
(203, 'Zumo de Mandarina', '1.00', '45.00', '0.00', '0.21', 'N/A', 19),
(204, 'Zumo de Mango', '1.00', '51.00', '0.00', '0.00', 'N/A', 19),
(205, 'Zumo de Pera', '1.00', '48.00', '0.00', '0.00', 'N/A', 19),
(206, 'Zumo de Mora', '1.00', '43.00', '0.00', '0.00', 'N/A', 19),
(207, 'Zumo de Fresa', '1.00', '45.00', '0.00', '0.00', 'N/A', 19),
(208, 'Zumo de Frambuesa', '1.00', '41.00', '0.00', '0.00', 'N/A', 19),
(209, 'Refresco Cola', '1.00', '42.00', '0.25', '0.00', 'N/A', 20),
(210, 'Refresco Naranja', '1.00', '48.00', '0.00', '0.00', 'N/A', 20),
(211, 'Refresco Limon', '1.00', '50.00', '0.00', '0.00', 'N/A', 20),
(212, 'Bedida Isotónica', '1.00', '26.00', '0.00', '0.00', 'N/A', 20),
(213, 'Bedia Energétcia', '1.00', '43.00', '0.00', '0.46', 'N/A', 20),
(214, 'Bebida Té', '1.00', '32.00', '0.00', '0.00', 'N/A', 20);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `idRol` int NOT NULL,
  `nombreRol` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`idRol`, `nombreRol`) VALUES
(1, 'Administrador'),
(2, 'Dietista'),
(3, 'Cliente');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `idUsuario` int NOT NULL,
  `nombreUsuario` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `apellidosUsuario` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `correoElectronicoUsuario` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `fechaNacimientoUsuario` date NOT NULL,
  `fechaRegistroUsuario` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `contraseña` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `imagenUsuario` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL DEFAULT 'users/img_663760cae5a20_gordito.jpg',
  `idRolFK` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`idUsuario`, `nombreUsuario`, `apellidosUsuario`, `correoElectronicoUsuario`, `fechaNacimientoUsuario`, `fechaRegistroUsuario`, `contraseña`, `imagenUsuario`, `idRolFK`) VALUES
(1, 'Iván', 'Castañeda Álvarez', 'ivanrani2004@gmail.com', '2004-12-15', '2024-04-25 10:55:32', '$2y$10$oFB.JnFn3/7wvHB1suWVyOkbkbHk.A3Gwj76V6LSaJ3A9GsePibJi', 'users/img_663a79ba73167__bf52e4ed-454b-49ab-95f8-e9ae785f7111.jpeg', 1),
(2, 'Francisco', 'Dona Villar', 'frandonete@gmail.com', '2002-05-10', '2024-04-25 21:31:35', '$2y$10$tpaR1YNdMTv4IIh5/GnyR.DvHjjrzyWDCbd8gauLnbbiE5ta/zdnC', 'N/A', 3),
(3, 'Vicente', 'Llamas Moreno', 'abueloyayo@gmail.com', '1997-03-15', '2024-04-25 21:33:56', '$2y$10$mCZT4pydmApyasjTNGSQdemPloUfFw.3NYX4/MlZzADQstoauqIj2', 'users/img_6637e24319eb2_canelita.jpeg', 3),
(4, 'Irene', 'Vaquero Parra', 'irenevaqueroparra@gmail.com', '2006-10-09', '2024-04-25 21:57:52', '$2y$10$vV8X8ljpE3Ggpt1hXu2YaO1swTFsvbXifScaFRBNrUQZOByb0V.cC', 'N/A', 3),
(5, 'Marcos', 'Diaz Reyes', 'marcochurumbel@gmail.com', '2003-06-22', '2024-04-27 10:20:01', '$2y$10$X3e/2.gs4jdc1PpbQQpTNOVbVw8eezQJ.lMoeG0JGXLS/3dJLCfx.', 'N/A', 3),
(11, 'Tony', 'Tetillas Electrolíticas', 'tetillapezonera@gmail.com', '2024-02-08', '2024-05-02 22:15:47', '$2y$10$mkzoZgBoqOJrVZHuAvlO/eg/4BSMVy9PCkrh.J7z8UqhAKnuKe5VO', 'users/default.jpg', 3),
(12, 'Mario', 'Lorca Gorda', 'gorditasabrosa@gmail.com', '2004-12-15', '2024-05-05 10:44:43', '$2y$10$GLVRI/8VoLmKkEgkDV52.Oql59aNdSSZ6y6dHNishm9eeSpyHGO8e', 'users/img_66376349c1033_minecraft-1-logo-png-transparent.png', 3),
(13, 'Manolo', 'Lama', 'studium13@gmail.es', '2012-12-12', '2024-05-05 19:48:04', '$2y$10$KeJMrUEejfhw4kva8syFr.Bs/i.tgbgMQ2bkG39.3ANosaT/xtH8C', 'users/img_663760cae5a20_gordito.jpg', 3),
(14, 'Pablo', 'Gonzalez', 'pablostudium@gmail.com', '2024-05-06', '2024-05-07 18:58:41', '$2y$10$A7OPl6O9J4kJ2j/Fls1VUO56U/YiJ/IGhW/0fcRh3f4exwLJ5Wj9q', 'users/img_663760cae5a20_gordito.jpg', 3),
(15, 'Nuria', 'Peña Sáez', 'nuria@viscaelbarsa.com', '2009-07-05', '2024-05-07 20:47:29', '$2y$10$wzCj1PIP1ejuz.4QfXBhWe.I.UGd7m2/p0C4P/nv54OiXpeYFEAJS', 'users/img_663760cae5a20_gordito.jpg', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariosdietas`
--

CREATE TABLE `usuariosdietas` (
  `idUsuarioFK` int NOT NULL,
  `idDietaFK` int NOT NULL
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
-- Indices de la tabla `comidasproductos`
--
ALTER TABLE `comidasproductos`
  ADD KEY `ForeignKey6_idx` (`idComidaFK`),
  ADD KEY `ForeignKey7_idx` (`idProductoFK`);

--
-- Indices de la tabla `dietas`
--
ALTER TABLE `dietas`
  ADD PRIMARY KEY (`idDieta`);

--
-- Indices de la tabla `dietascomidas`
--
ALTER TABLE `dietascomidas`
  ADD KEY `ForeignKey4_idx` (`idDietaFK`),
  ADD KEY `ForeignKey5_idx` (`idComidaFK`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`idProducto`),
  ADD KEY `ForeignKey8_idx` (`idCategoriaFK`);

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
  ADD KEY `ForeignKey1_idx` (`idRolFK`);

--
-- Indices de la tabla `usuariosdietas`
--
ALTER TABLE `usuariosdietas`
  ADD KEY `ForeignKey2_idx` (`idUsuarioFK`),
  ADD KEY `ForeignKey3_idx` (`idDietaFK`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idCategoria` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `comidas`
--
ALTER TABLE `comidas`
  MODIFY `idComida` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `dietas`
--
ALTER TABLE `dietas`
  MODIFY `idDieta` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `idProducto` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=215;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUsuario` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `comidasproductos`
--
ALTER TABLE `comidasproductos`
  ADD CONSTRAINT `ForeignKey6` FOREIGN KEY (`idComidaFK`) REFERENCES `comidas` (`idComida`),
  ADD CONSTRAINT `ForeignKey7` FOREIGN KEY (`idProductoFK`) REFERENCES `productos` (`idProducto`);

--
-- Filtros para la tabla `dietascomidas`
--
ALTER TABLE `dietascomidas`
  ADD CONSTRAINT `ForeignKey4` FOREIGN KEY (`idDietaFK`) REFERENCES `dietas` (`idDieta`),
  ADD CONSTRAINT `ForeignKey5` FOREIGN KEY (`idComidaFK`) REFERENCES `comidas` (`idComida`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `ForeignKey8` FOREIGN KEY (`idCategoriaFK`) REFERENCES `categorias` (`idCategoria`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `ForeignKey1` FOREIGN KEY (`idRolFK`) REFERENCES `roles` (`idRol`);

--
-- Filtros para la tabla `usuariosdietas`
--
ALTER TABLE `usuariosdietas`
  ADD CONSTRAINT `ForeignKey2` FOREIGN KEY (`idUsuarioFK`) REFERENCES `usuarios` (`idUsuario`),
  ADD CONSTRAINT `ForeignKey3` FOREIGN KEY (`idDietaFK`) REFERENCES `dietas` (`idDieta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
