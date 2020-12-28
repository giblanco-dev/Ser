-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-11-2020 a las 23:47:08
-- Versión del servidor: 10.4.13-MariaDB
-- Versión de PHP: 7.4.7

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
-- Estructura de tabla para la tabla `cita`
--

CREATE TABLE `cita` (
  `id_cita` int(11) NOT NULL,
  `id_paciente` int(6) NOT NULL,
  `medico` int(3) NOT NULL,
  `fecha` date NOT NULL,
  `horario` time NOT NULL,
  `registrado` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_registra` int(3) NOT NULL,
  `tipo` int(2) NOT NULL,
  `confirma` int(1) NOT NULL,
  `consulta` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `cita`
--

INSERT INTO `cita` (`id_cita`, `id_paciente`, `medico`, `fecha`, `horario`, `registrado`, `user_registra`, `tipo`, `confirma`, `consulta`) VALUES
(1, 2, 6, '2020-08-14', '17:06:00', '2020-08-13 22:07:18', 3, 0, 0, 0),
(2, 3, 5, '2020-08-28', '14:34:00', '2020-08-28 03:34:30', 3, 0, 0, 0),
(3, 2, 7, '2020-08-29', '19:57:00', '2020-08-28 03:34:57', 3, 0, 0, 0),
(4, 1, 0, '2020-08-29', '16:40:00', '2020-08-28 03:35:21', 3, 1, 0, 0),
(5, 4, 0, '2020-08-31', '14:40:00', '2020-08-28 03:36:08', 3, 1, 0, 0),
(6, 2, 5, '2020-08-30', '09:59:00', '2020-08-30 13:59:39', 3, 0, 0, 0),
(7, 3, 8, '2020-08-30', '11:02:00', '2020-08-30 14:00:01', 3, 0, 0, 0),
(8, 4, 5, '2020-08-30', '01:00:00', '2020-08-30 14:00:15', 3, 0, 0, 0),
(9, 3, 5, '2020-08-30', '18:52:00', '2020-08-30 17:52:28', 3, 0, 0, 0),
(10, 1, 0, '2020-08-30', '15:55:00', '2020-08-30 17:55:32', 3, 3, 0, 0),
(11, 4, 0, '2020-08-30', '16:05:00', '2020-08-30 18:05:43', 3, 1, 0, 0),
(12, 2, 0, '2020-08-30', '17:06:00', '2020-08-30 18:06:23', 3, 2, 0, 0),
(13, 3, 6, '2020-08-30', '16:48:00', '2020-08-30 18:48:41', 3, 0, 0, 0),
(14, 3, 0, '2020-08-30', '21:48:00', '2020-08-31 02:48:05', 3, 0, 0, 0),
(15, 1, 5, '2020-09-09', '21:33:00', '2020-09-10 00:33:58', 3, 0, 0, 0),
(16, 3, 0, '2020-09-09', '20:35:00', '2020-09-10 00:35:34', 3, 1, 0, 0),
(17, 3, 6, '2020-09-09', '11:24:00', '2020-09-10 01:24:08', 3, 0, 0, 0),
(18, 3, 8, '2020-09-12', '18:37:00', '2020-09-12 22:43:24', 3, 3, 0, 0),
(19, 3, 5, '2020-09-20', '10:00:00', '2020-09-20 15:00:20', 3, 0, 1, 0),
(20, 1, 5, '2020-09-20', '10:20:00', '2020-09-20 15:06:24', 3, 0, 1, 0),
(21, 3, 6, '2020-09-20', '16:00:00', '2020-09-20 15:08:34', 3, 0, 0, 0),
(22, 3, 3, '2020-09-27', '12:13:00', '2020-09-27 17:07:48', 9, 0, 2, 0),
(23, 1, 3, '2020-09-27', '15:24:00', '2020-09-27 17:24:15', 9, 0, 2, 0),
(24, 4, 3, '2020-09-27', '17:31:00', '2020-09-27 17:32:00', 9, 0, 2, 0),
(25, 1, 0, '2020-09-27', '15:41:00', '2020-09-27 17:41:13', 9, 0, 2, 0),
(26, 2, 3, '2020-09-27', '15:41:00', '2020-09-27 17:41:30', 9, 0, 2, 0),
(27, 3, 5, '2020-09-27', '19:30:00', '2020-09-28 00:27:09', 9, 0, 3, 0),
(28, 1, 3, '2020-09-28', '09:02:00', '2020-09-28 05:03:03', 9, 0, 2, 0),
(29, 3, 3, '2020-09-28', '19:36:00', '2020-09-29 00:37:17', 9, 0, 2, 0),
(30, 2, 6, '2020-09-28', '19:42:00', '2020-09-29 00:39:11', 9, 0, 3, 0),
(31, 3, 3, '2020-10-14', '19:47:00', '2020-10-15 00:47:40', 9, 0, 2, 0),
(32, 2, 3, '2020-10-14', '20:01:00', '2020-10-15 01:02:07', 9, 0, 2, 0),
(33, 1, 6, '2020-10-14', '21:03:00', '2020-10-15 01:03:43', 9, 0, 1, 0),
(34, 3, 3, '2020-10-20', '22:15:00', '2020-10-21 03:15:57', 9, 0, 3, 0),
(35, 1, 3, '2020-10-20', '23:22:00', '2020-10-21 03:21:41', 9, 0, 2, 1),
(36, 2, 3, '2020-10-20', '22:54:00', '2020-10-21 03:54:14', 9, 0, 2, 1),
(37, 4, 3, '2020-10-20', '23:49:00', '2020-10-21 04:49:40', 9, 0, 2, 0),
(38, 3, 3, '2020-10-21', '01:00:00', '2020-10-21 05:00:46', 9, 0, 2, 0),
(39, 1, 3, '2020-10-21', '02:00:00', '2020-10-21 05:01:10', 9, 0, 2, 0),
(40, 1, 3, '2020-10-22', '19:40:00', '2020-10-23 00:41:05', 9, 0, 2, 1),
(45, 1, 6, '2020-10-25', '10:15:00', '2020-10-25 16:15:15', 9, 0, 2, 0),
(46, 2, 91, '2020-10-25', '10:34:00', '2020-10-25 16:15:44', 9, 91, 3, 0),
(47, 1, 92, '2020-10-25', '11:15:00', '2020-10-25 16:16:00', 9, 92, 3, 0),
(48, 3, 2, '2020-10-25', '11:18:00', '2020-10-25 16:18:28', 9, 90, 2, 0),
(49, 3, 3, '2020-10-25', '14:20:00', '2020-10-25 16:20:20', 9, 0, 2, 0),
(50, 1, 8, '2020-10-25', '13:20:00', '2020-10-25 16:21:04', 9, 90, 2, 0),
(51, 2, 3, '2020-10-25', '14:53:00', '2020-10-25 16:53:42', 9, 0, 2, 0),
(52, 1, 5, '2020-10-28', '09:53:00', '2020-10-25 17:54:03', 9, 0, 1, 0),
(53, 1, 8, '2020-10-27', '14:04:00', '2020-10-25 18:04:16', 9, 90, 1, 0),
(54, 1, 7, '2020-10-28', '14:11:00', '2020-10-25 18:11:16', 9, 0, 1, 0),
(55, 3, 3, '2020-10-26', '16:11:00', '2020-10-25 18:11:44', 9, 0, 1, 0),
(56, 2, 3, '2020-10-28', '15:16:00', '2020-10-25 18:16:19', 9, 0, 1, 0),
(57, 3, 92, '2020-10-30', '14:17:00', '2020-10-25 18:17:53', 9, 92, 1, 0),
(58, 1, 6, '2020-10-26', '14:18:00', '2020-10-25 18:18:22', 9, 0, 1, 0),
(59, 4, 3, '2020-10-25', '16:19:00', '2020-10-25 18:19:30', 9, 0, 2, 0),
(60, 4, 5, '2020-11-04', '14:31:00', '2020-10-25 18:31:25', 9, 0, 2, 0),
(61, 3, 3, '2020-11-02', '16:17:00', '2020-11-02 18:17:57', 9, 0, 2, 0),
(62, 19, 3, '2020-11-02', '14:04:00', '2020-11-02 19:04:09', 9, 0, 2, 0),
(63, 1, 3, '2020-11-02', '15:08:00', '2020-11-02 19:09:01', 9, 0, 2, 0),
(64, 2, 3, '2020-11-02', '14:10:00', '2020-11-02 19:11:02', 9, 0, 2, 0),
(65, 1, 3, '2020-11-04', '22:15:00', '2020-11-05 04:15:24', 9, 0, 2, 1),
(66, 1, 3, '2020-11-05', '21:22:00', '2020-11-06 03:22:07', 9, 0, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consulta`
--

CREATE TABLE `consulta` (
  `id_cita` int(11) NOT NULL,
  `nota_evolucion` text NOT NULL,
  `ta` varchar(20) NOT NULL,
  `temp` varchar(20) NOT NULL,
  `fre_c` varchar(20) NOT NULL,
  `fre_r` varchar(20) NOT NULL,
  `peso` varchar(20) NOT NULL,
  `talla` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `consulta`
--

INSERT INTO `consulta` (`id_cita`, `nota_evolucion`, `ta`, `temp`, `fre_c`, `fre_r`, `peso`, `talla`) VALUES
(22, '', '120/60', '35.4', '120', '120', '56', '1.65'),
(23, '', '120/60', '35.4', '120', '2', '1', '2'),
(24, '', '120/60', '36.8', '120', '120', 'x', '1.60'),
(25, '', '120/60', '38', '123', '125', '75', '1.75'),
(28, '', '', '', '', '', 'x', ''),
(29, '', '120/60', '34', '120', '120', '89', '1.80'),
(31, '', '120/60', '35.4', '25', '56', '70', '1.65'),
(32, '', '120/60', '36.8', '25', '125', '56', '1.60'),
(35, 'Actualización de la nota de evolución', '120/60', '35.4', '120', '120', '89', '1.80'),
(36, 'Segunda nota de evolución de prueba\r\n        ', '120/60', '36.8', '56', '125', '70', '1.65'),
(37, '', '120/60', '37', '25', '56', '89', '1.70'),
(38, '', '', '', '', '', 'x', ''),
(39, '', '', '', '', '', 'x', ''),
(40, '\r\n        Esta es una nota de evolución de prueba\r\n\r\nActualiza nota de evolución', '120/60', '35.4', '120', '120', '89', '1.80'),
(44, '', '', '', '', '', 'x', ''),
(45, '', '', '', '', '', 'x', ''),
(46, '', '', '', '', '', 'x', ''),
(47, '', '', '', '', '', 'x', ''),
(48, '', '', '', '', '', 'x', ''),
(49, '', '', '', '', '', 'x', ''),
(50, '', '', '', '', '', 'x', ''),
(51, '', '', '', '', '', 'x', ''),
(59, '', '', '', '', '', 'x', ''),
(60, '', '', '', '', '', 'x', ''),
(61, '', 'sdf', 'sdf', 'asdf', 'asdf', 'x', '1.63'),
(62, '', '120/60', '35.4', '25', '56', '56', '1.80'),
(63, '', '', '', '', '', 'x', ''),
(64, '', '', '', '', '', 'x', ''),
(65, 'Esta es una nota de prueba del 04/11/2020\r\n  ', '120/60', '36.8', '120', '120', '58', '1.60'),
(66, '\r\n        ok', '', '', '', '', 'x', '');

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

--
-- Volcado de datos para la tabla `his_clinica_gen`
--

INSERT INTO `his_clinica_gen` (`id_paciente`, `fecha_captura`, `hcg2`, `hcg3`, `hcg4`, `hcg5`, `hcg6`, `hcg7`, `hcg8`, `hcg9`, `hcg10`, `hcg11`, `hcg12`, `hcg13`, `hcg14`, `hcg15`, `hcg16`, `hcg17`, `hcg18`, `hcg19`, `hcg20`, `hcg21`, `hcg22`, `hcg23`, `hcg24`, `hcg25`, `hcg26`, `hcg27`, `hcg28`, `hcg29`, `hcg30`, `hcg31`, `hcg32`, `medico`, `usuario_captura`) VALUES
(3, '2020-08-13 04:51:58', 'ty', 'ui', 'utiu', 'uiy', 'yuiy', 'yiu', 'yui', 'yiu', 'yiuy', 'iy', 'iuy', 'uiy', 'uyi', 'yuiy', 'yiuy', 'iyi', 'yiu', 'yiu', 'yiiu', 'yiu', 'yiuy', 'iuyi', 'yi', 'iui', 'yiu', 'iuy', 'iyiu', 'uiyiuhj', 'vu', 'hjghj', 'goi', 'emartinez', 3);

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
(2, 'jonathan', 'cortes', 'rivera', '2020-07-23 21:46:41', 'Masculino', 'Playa Mocambo', '17', 'Miramar', '53809', 'Naucalpan', 'México', '', '5552943330', '5586967251', '', '', '', '2000-06-23', 'Estudiante', '', '2020-07-23', 2),
(3, 'gabriel', 'blanco', 'morales', '2020-08-13 04:51:14', 'Masculino', 'jkhj', 'hlk', 'klhk', '56789', 'khlk', 'México', '', '5567053964', '5567053964', '8890987654', '226', 'gabrielibm.91@gmail.com', '1990-08-09', 'Soporte Técnico', 'Adriana Mtz', '2020-08-12', 3),
(4, 'HJVSHJ', 'NJDVB', 'jdbvjk', '2020-08-13 22:13:17', 'Femenino', 'kcvn', 'lñsdnvk', 'vsndkj', '678096', 'bsdvhjjh', 'Ciudad de México', '', '7809765409', '7865432109', '', '', 'mail@prueba.com', '1990-09-12', '', '', '2020-08-12', 3),
(18, 'guillermo', 'Morales', 'Sandoval', '2020-11-02 18:49:24', 'Masculino', 'Daniela', '6', 'Nativitas', '56335', 'Chicoloapan', 'México', '5598741236', '5552698741', '5536214598', '8890987654', '123', 'cachetes@gmail.com', '1994-03-08', 'Chef', 'Iván', '2020-11-01', 9),
(19, 'Teófilo', 'Blanco', 'Evangelista', '2020-11-02 18:52:02', 'Masculino', 'Daniela', '6', 'Nativitas', '56335', 'Chimalhuacán', 'México', '', '5562824140', '5569328574', '', '', '', '1960-02-01', 'Obrero', 'María de los Angeles Morales Sandoval', '2020-11-02', 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_cita`
--

CREATE TABLE `tipos_cita` (
  `id_tipo_cita` int(2) NOT NULL,
  `descrip_cita` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipos_cita`
--

INSERT INTO `tipos_cita` (`id_tipo_cita`, `descrip_cita`) VALUES
(0, 'Consulta'),
(90, 'Dental'),
(91, 'Factor Crecimiento'),
(92, 'Pellet');

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
(2, 'Dra Mónica', 'Martínez', 'mmartinez', 'shaker', 'recepcion'),
(3, 'Médico', 'Test', 'test_m', '12345', 'medico'),
(4, 'Janet', 'Reyes', 'jreyes', '21330', 'recepcion'),
(5, 'Dr. Enrique', 'Martínez', 'emartinez', '12345678', 'medico'),
(6, 'Dr. Guillermo', 'León', 'gleon', '12345678', 'medico'),
(7, 'Dra. Angélica', 'Mosqueda', 'amosqueda', '12345678', 'medico'),
(8, 'Dra. Claudia', 'Ferreira', 'cferreira', '12345678', 'medico'),
(9, 'Recep', 'Test', 'test_r', '12345', 'recepcion');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`id_cita`),
  ADD KEY `tipo` (`tipo`);

--
-- Indices de la tabla `consulta`
--
ALTER TABLE `consulta`
  ADD PRIMARY KEY (`id_cita`) USING BTREE;

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
-- Indices de la tabla `tipos_cita`
--
ALTER TABLE `tipos_cita`
  ADD PRIMARY KEY (`id_tipo_cita`);

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
-- AUTO_INCREMENT de la tabla `cita`
--
ALTER TABLE `cita`
  MODIFY `id_cita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT de la tabla `niveles`
--
ALTER TABLE `niveles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `paciente`
--
ALTER TABLE `paciente`
  MODIFY `id_paciente` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
