-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-09-2020 a las 21:32:31
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `indicadores`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `uf`
--

CREATE TABLE `uf` (
  `id` int(11) NOT NULL,
  `valor` float NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `uf`
--

INSERT INTO `uf` (`id`, `valor`, `fecha`) VALUES
(20662, 28698.3, '2020-09-20'),
(20663, 28697.3, '2020-09-19'),
(20664, 28696.4, '2020-09-18'),
(20665, 28695.4, '2020-09-17'),
(20666, 28694.5, '2020-09-16'),
(20667, 28693.5, '2020-09-15'),
(20668, 28692.6, '2020-09-14'),
(20669, 28691.6, '2020-09-13'),
(20670, 28690.6, '2020-09-12'),
(20671, 28689.7, '2020-09-11'),
(20672, 28688.7, '2020-09-10'),
(20673, 28687.8, '2020-09-09'),
(20674, 28686.8, '2020-09-08'),
(20675, 28685.9, '2020-09-07'),
(20676, 28685, '2020-09-06'),
(20677, 28684.1, '2020-09-05'),
(20678, 28683.1, '2020-09-04'),
(20679, 28682.2, '2020-09-03'),
(20680, 28681.3, '2020-09-02'),
(20681, 28680.4, '2020-09-01'),
(20682, 28679.4, '2020-08-31'),
(20683, 28678.5, '2020-08-30'),
(20684, 28677.6, '2020-08-29'),
(20685, 28676.7, '2020-08-28'),
(20686, 28675.8, '2020-08-27'),
(20687, 28674.8, '2020-08-26'),
(20688, 28673.9, '2020-08-25'),
(20689, 28673, '2020-08-24'),
(20690, 28672.1, '2020-08-23');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `uf`
--
ALTER TABLE `uf`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `uf`
--
ALTER TABLE `uf`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20691;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
