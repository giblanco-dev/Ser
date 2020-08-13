-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-08-2020 a las 21:59:08
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.2.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `ser`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `his_clinica_gen`
--

CREATE TABLE `his_clinica_gen` (
  `id_paciente` int(6) NOT NULL,
  `fecha_captura` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `hcg2` text NOT NULL,
  `hcg3` text NOT NULL,
  `hcg4` text NOT NULL,
  `hcg5` text NOT NULL,
  `hcg6` text NOT NULL,
  `hcg7` text NOT NULL,
  `hcg8` text NOT NULL,
  `hcg9` text NOT NULL,
  `hcg10` text NOT NULL,
  `hcg11` text NOT NULL,
  `hcg12` text NOT NULL,
  `hcg13` text NOT NULL,
  `hcg14` text NOT NULL,
  `hcg15` text NOT NULL,
  `hcg16` text NOT NULL,
  `hcg17` text NOT NULL,
  `hcg18` text NOT NULL,
  `hcg19` text NOT NULL,
  `hcg20` text NOT NULL,
  `hcg21` text NOT NULL,
  `hcg22` text NOT NULL,
  `hcg23` text NOT NULL,
  `hcg24` text NOT NULL,
  `hcg25` text NOT NULL,
  `hcg26` text NOT NULL,
  `hcg27` text NOT NULL,
  `hcg28` text NOT NULL,
  `hcg29` text NOT NULL,
  `hcg30` text NOT NULL,
  `hcg31` text NOT NULL,
  `hcg32` text NOT NULL,
  `medico` varchar(100) NOT NULL,
  `usuario_captura` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `niveles`
--

CREATE TABLE `niveles` (
  `id` int(11) NOT NULL,
  `nivel` varchar(10) NOT NULL,
  `descripcion` varchar(15) NOT NULL,
  `ruta` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `niveles`
--

INSERT INTO `niveles` (`id`, `nivel`, `descripcion`, `ruta`) VALUES
(1, 'recepcion', 'Recepción', '../../recep'),
(2, 'medico', 'Médico', '../../consulta'),
(3, 'caja', 'Caja', '../../caja'),
(4, 'terapias', 'Terapias', '../../terap'),
(5, 'farmacia', 'Farmacia', '../../farma'),
(6, 'almacen', 'Almacén', '../../almacen'),
(7, 'admin', 'Administración', '../');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `paciente`
--

CREATE TABLE `paciente` (
  `id_paciente` int(6) NOT NULL,
  `nombres` varchar(300) NOT NULL,
  `a_paterno` varchar(100) NOT NULL,
  `a_materno` varchar(100) NOT NULL,
  `fecha_captura` timestamp NOT NULL DEFAULT current_timestamp(),
  `genero` varchar(10) NOT NULL,
  `calle` varchar(50) NOT NULL,
  `num_domicilio` varchar(20) NOT NULL,
  `colonia` varchar(50) NOT NULL,
  `cod_postal` varchar(6) NOT NULL,
  `muni_alcaldia` varchar(50) NOT NULL,
  `estado` varchar(50) NOT NULL,
  `tel_recados` varchar(10) DEFAULT NULL,
  `tel_casa` varchar(10) DEFAULT NULL,
  `tel_movil` varchar(10) DEFAULT NULL,
  `tel_oficina` varchar(10) DEFAULT NULL,
  `ext_tel` varchar(5) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `fecha_nacimiento` date NOT NULL,
  `ocupacion` varchar(300) DEFAULT NULL,
  `nombre_titular` varchar(300) DEFAULT NULL,
  `fecha_alta` date NOT NULL,
  `usuario_captura` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `paciente`
--

INSERT INTO `paciente` (`id_paciente`, `nombres`, `a_paterno`, `a_materno`, `fecha_captura`, `genero`, `calle`, `num_domicilio`, `colonia`, `cod_postal`, `muni_alcaldia`, `estado`, `tel_recados`, `tel_casa`, `tel_movil`, `tel_oficina`, `ext_tel`, `email`, `fecha_nacimiento`, `ocupacion`, `nombre_titular`, `fecha_alta`, `usuario_captura`) VALUES
(1, 'Janet Yazmin ', 'Reyes', 'Antonio', '2020-07-15 21:49:46', 'Femenino', 'Francisco Villa ', '32', 'El pedregal', '00000', 'Xochimilco', 'Ciudad de México', '', '', '5544981386', '', '', '', '1993-01-03', '', '', '2020-07-15', 4),
(2, 'jonathan', 'cortes', 'rivera', '2020-07-23 21:46:41', 'Masculino', 'Playa Mocambo', '17', 'Miramar', '53809', 'Naucalpan', 'México', '', '5552943330', '5586967251', '', '', '', '2000-06-23', 'Estudiante', '', '2020-07-23', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(3) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `usuario` varchar(25) NOT NULL,
  `password` varchar(8) NOT NULL,
  `nivel` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `nombre`, `apellido`, `usuario`, `password`, `nivel`) VALUES
(1, 'Gabriel', 'Blanco', 'gblanco', 'admin91', 'admin'),
(2, 'Mónica', 'Martínez', 'mmartinez', 'shaker', 'recepcion'),
(3, 'Usuario', 'Test', 'test', '12345', 'recepcion'),
(4, 'Janet', 'Reyes', 'jreyes', '21330', 'recepcion');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `his_clinica_gen`
--
ALTER TABLE `his_clinica_gen`
  ADD PRIMARY KEY (`id_paciente`);

--
-- Indices de la tabla `niveles`
--
ALTER TABLE `niveles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nivel_2` (`nivel`);

--
-- Indices de la tabla `paciente`
--
ALTER TABLE `paciente`
  ADD PRIMARY KEY (`id_paciente`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nivel` (`nivel`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `niveles`
--
ALTER TABLE `niveles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `id_paciente` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
