-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-03-2025 a las 16:15:02
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
-- Base de datos: `recfacial`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tajuste`
--

CREATE TABLE `tajuste` (
  `ID_AJUSTE` int(11) NOT NULL,
  `NOM_AJUSTE` varchar(20) DEFAULT NULL,
  `VALOR_AJUSTE` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tajuste`
--

INSERT INTO `tajuste` (`ID_AJUSTE`, `NOM_AJUSTE`, `VALOR_AJUSTE`) VALUES
(1, 'MaxLoginRq', '3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbio`
--

CREATE TABLE `tbio` (
  `COD_BIO` int(11) NOT NULL,
  `COD_TIPO_BIO` int(11) DEFAULT NULL,
  `DATO_BIO` text DEFAULT NULL,
  `COD_EMPLEADO` int(11) DEFAULT NULL,
  `FEC_ALTA` datetime DEFAULT NULL,
  `NOM_USUARIO_ALTA` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tbio`
--

INSERT INTO `tbio` (`COD_BIO`, `COD_TIPO_BIO`, `DATO_BIO`, `COD_EMPLEADO`, `FEC_ALTA`, `NOM_USUARIO_ALTA`) VALUES
(1, 1, 'dadsdsdsdsds', 1, '2025-03-20 11:45:48', 'Admon');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `templeado`
--

CREATE TABLE `templeado` (
  `COD_EMPLEADO` int(11) NOT NULL,
  `COD_USUARIO` int(11) DEFAULT NULL,
  `NOM_EMPLEADO` varchar(20) DEFAULT NULL,
  `APE1_EMPLEADO` varchar(20) DEFAULT NULL,
  `APE2_EMPLEADO` varchar(20) DEFAULT NULL,
  `CONTACTO_EMPLEADO` varchar(20) DEFAULT NULL,
  `FEC_ALTA` datetime DEFAULT NULL,
  `NOM_USUARIO_ALTA` varchar(20) DEFAULT NULL,
  `FEC_BAJA` datetime DEFAULT NULL,
  `NOM_USUARIO_BAJA` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `templeado`
--

INSERT INTO `templeado` (`COD_EMPLEADO`, `COD_USUARIO`, `NOM_EMPLEADO`, `APE1_EMPLEADO`, `APE2_EMPLEADO`, `CONTACTO_EMPLEADO`, `FEC_ALTA`, `NOM_USUARIO_ALTA`, `FEC_BAJA`, `NOM_USUARIO_BAJA`) VALUES
(1, 2, 'Juan', 'Perez', 'Gomez', 'juanpg@local.com', '2025-03-20 11:32:41', 'admon', NULL, NULL),
(3, 1, 'Juan', 'Perez', 'Gomez', 'juanpg@local.com', '2025-03-20 11:34:57', 'admon', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmarcaje`
--

CREATE TABLE `tmarcaje` (
  `COD_MARCAJE` bigint(20) NOT NULL,
  `COD_TIPO_MARCAJE` int(11) DEFAULT NULL,
  `COD_EMPLEADO` int(11) DEFAULT NULL,
  `COD_BIO` int(11) DEFAULT NULL,
  `DES_FOTO` varchar(20) DEFAULT NULL,
  `COD_TIPO_ACCESO` int(11) DEFAULT NULL,
  `FEC_MARCAJE` datetime DEFAULT NULL,
  `HOR_MARCAJE` datetime DEFAULT NULL,
  `FEC_GRABACION` datetime DEFAULT NULL,
  `HOR_GRABACION` datetime DEFAULT NULL,
  `IND_INCIDENCIA` tinyint(1) DEFAULT NULL,
  `IND_PENDIENTE` tinyint(1) DEFAULT NULL,
  `DES_OBSERVACIONES` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tmarcaje`
--

INSERT INTO `tmarcaje` (`COD_MARCAJE`, `COD_TIPO_MARCAJE`, `COD_EMPLEADO`, `COD_BIO`, `DES_FOTO`, `COD_TIPO_ACCESO`, `FEC_MARCAJE`, `HOR_MARCAJE`, `FEC_GRABACION`, `HOR_GRABACION`, `IND_INCIDENCIA`, `IND_PENDIENTE`, `DES_OBSERVACIONES`) VALUES
(1, 1, 1, 1, 'foto', 1, '2025-03-20 11:48:24', NULL, '2025-03-20 11:48:24', NULL, 0, 0, 'observaciones');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `trol`
--

CREATE TABLE `trol` (
  `COD_ROL` int(11) NOT NULL,
  `NOM_ROL` varchar(20) DEFAULT NULL,
  `DES_ROL` varchar(100) DEFAULT NULL,
  `FEC_ALTA` datetime DEFAULT NULL,
  `NOM_USUARIO_ALTA` varchar(20) DEFAULT NULL,
  `FEC_BAJA` datetime DEFAULT NULL,
  `NOM_USUARIO_BAJA` varchar(20) DEFAULT NULL,
  `PRIVILEGIOS` text DEFAULT NULL COMMENT 'Array de privilegios'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `trol`
--

INSERT INTO `trol` (`COD_ROL`, `NOM_ROL`, `DES_ROL`, `FEC_ALTA`, `NOM_USUARIO_ALTA`, `FEC_BAJA`, `NOM_USUARIO_BAJA`, `PRIVILEGIOS`) VALUES
(1, 'MdCrear', 'Crear MD', '2025-03-20 11:40:27', 'Admon', NULL, NULL, 'O:17:\"Clases\\Privilegio\":20:{s:27:\"\0Clases\\Privilegio\0empCrear\";b:0;s:31:\"\0Clases\\Privilegio\0empModificar\";b:0;s:26:\"\0Clases\\Privilegio\0empBaja\";b:0;s:27:\"\0Clases\\Privilegio\0usrCrear\";b:0;s:31:\"\0Clases\\Privilegio\0usrModificar\";b:0;s:26:\"\0Clases\\Privilegio\0usrBaja\";b:0;s:33:\"\0Clases\\Privilegio\0usrGenerarPass\";b:0;s:33:\"\0Clases\\Privilegio\0marCrearPropio\";b:0;s:37:\"\0Clases\\Privilegio\0marConsultarPropio\";b:0;s:27:\"\0Clases\\Privilegio\0marCrear\";b:0;s:31:\"\0Clases\\Privilegio\0marModificar\";b:0;s:30:\"\0Clases\\Privilegio\0marEliminar\";b:0;s:31:\"\0Clases\\Privilegio\0marConsultar\";b:0;s:26:\"\0Clases\\Privilegio\0marAuth\";b:0;s:27:\"\0Clases\\Privilegio\0bioCrear\";b:0;s:30:\"\0Clases\\Privilegio\0bioEliminar\";b:0;s:27:\"\0Clases\\Privilegio\0rolCrear\";b:0;s:31:\"\0Clases\\Privilegio\0rolModificar\";b:0;s:30:\"\0Clases\\Privilegio\0rolEliminar\";b:0;s:35:\"\0Clases\\Privilegio\0ajustesModificar\";b:0;}'),
(2, 'MdCrear', 'Crear MD', '2025-03-20 11:48:41', 'Admon', NULL, NULL, 'O:17:\"Clases\\Privilegio\":20:{s:27:\"\0Clases\\Privilegio\0empCrear\";b:0;s:31:\"\0Clases\\Privilegio\0empModificar\";b:0;s:26:\"\0Clases\\Privilegio\0empBaja\";b:0;s:27:\"\0Clases\\Privilegio\0usrCrear\";b:0;s:31:\"\0Clases\\Privilegio\0usrModificar\";b:0;s:26:\"\0Clases\\Privilegio\0usrBaja\";b:0;s:33:\"\0Clases\\Privilegio\0usrGenerarPass\";b:0;s:33:\"\0Clases\\Privilegio\0marCrearPropio\";b:0;s:37:\"\0Clases\\Privilegio\0marConsultarPropio\";b:0;s:27:\"\0Clases\\Privilegio\0marCrear\";b:0;s:31:\"\0Clases\\Privilegio\0marModificar\";b:0;s:30:\"\0Clases\\Privilegio\0marEliminar\";b:0;s:31:\"\0Clases\\Privilegio\0marConsultar\";b:0;s:26:\"\0Clases\\Privilegio\0marAuth\";b:0;s:27:\"\0Clases\\Privilegio\0bioCrear\";b:0;s:30:\"\0Clases\\Privilegio\0bioEliminar\";b:0;s:27:\"\0Clases\\Privilegio\0rolCrear\";b:0;s:31:\"\0Clases\\Privilegio\0rolModificar\";b:0;s:30:\"\0Clases\\Privilegio\0rolEliminar\";b:0;s:35:\"\0Clases\\Privilegio\0ajustesModificar\";b:0;}');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ttbio`
--

CREATE TABLE `ttbio` (
  `COD_TIPO_BIO` int(11) NOT NULL,
  `DES_TIPO_BIO` varchar(20) DEFAULT NULL,
  `FEC_ALTA` datetime DEFAULT NULL,
  `NOM_USUARIO_ALTA` varchar(20) DEFAULT NULL,
  `FEC_BAJA` datetime DEFAULT NULL,
  `NOM_USUARIO_BAJA` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ttbio`
--

INSERT INTO `ttbio` (`COD_TIPO_BIO`, `DES_TIPO_BIO`, `FEC_ALTA`, `NOM_USUARIO_ALTA`, `FEC_BAJA`, `NOM_USUARIO_BAJA`) VALUES
(1, 'Facial', '2025-03-16 11:39:02', 'Admon', NULL, NULL),
(2, 'RFID', '2025-03-16 11:39:02', 'Admon', NULL, NULL),
(3, 'Teclado', '2025-03-20 11:54:22', 'Admon', NULL, NULL),
(7, 'Keypad', '2025-03-20 12:16:02', 'Admon', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ttipoacceso`
--

CREATE TABLE `ttipoacceso` (
  `COD_TIPO_ACCESO` int(11) NOT NULL,
  `DES_TIPO_ACCESO` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ttipoacceso`
--

INSERT INTO `ttipoacceso` (`COD_TIPO_ACCESO`, `DES_TIPO_ACCESO`) VALUES
(1, 'RecFacial'),
(2, 'RFID');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ttransacciones`
--

CREATE TABLE `ttransacciones` (
  `COD_TRANSACCION` bigint(20) NOT NULL,
  `TIP_TRANS` varchar(5) DEFAULT NULL,
  `DESC_TRANS` varchar(30) DEFAULT NULL,
  `COD_OBJ` int(11) DEFAULT NULL,
  `NOM_OBJ` varchar(20) DEFAULT NULL,
  `COD_USUARIO` int(11) DEFAULT NULL,
  `FEC_SIS` datetime DEFAULT NULL,
  `HOR_SIS` datetime DEFAULT NULL,
  `IP_USUARIO` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ttransacciones`
--

INSERT INTO `ttransacciones` (`COD_TRANSACCION`, `TIP_TRANS`, `DESC_TRANS`, `COD_OBJ`, `NOM_OBJ`, `COD_USUARIO`, `FEC_SIS`, `HOR_SIS`, `IP_USUARIO`) VALUES
(6, 'mod_u', 'Modificación del usuario Admon', 1, 'tUsuario', 1, '2025-03-20 13:30:43', NULL, '127.0.0.1'),
(7, 'mod_u', 'Modificación del usuario Admon', 1, 'tUsuario', 1, '2025-03-20 13:31:02', NULL, '127.0.0.1'),
(8, 'mod_u', 'Modificación del usuario Admon', 1, 'tUsuario', 1, '2025-03-20 13:31:17', NULL, '127.0.0.1'),
(9, 'mod_u', 'Modificación del usuario Admon', 1, 'tUsuario', 1, '2025-03-20 13:36:53', NULL, '127.0.0.1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tusuario`
--

CREATE TABLE `tusuario` (
  `COD_USUARIO` int(11) NOT NULL,
  `NOM_LOGIN` varchar(20) DEFAULT NULL,
  `DES_CONTRASENA` varchar(100) DEFAULT NULL,
  `DES_CORREO` varchar(20) DEFAULT NULL,
  `FEC_ALTA` datetime DEFAULT NULL,
  `NOM_USUARIO_ALTA` varchar(20) DEFAULT NULL,
  `FEC_BAJA` datetime DEFAULT NULL,
  `NOM_USUARIO_BAJA` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tusuario`
--

INSERT INTO `tusuario` (`COD_USUARIO`, `NOM_LOGIN`, `DES_CONTRASENA`, `DES_CORREO`, `FEC_ALTA`, `NOM_USUARIO_ALTA`, `FEC_BAJA`, `NOM_USUARIO_BAJA`) VALUES
(1, 'Admon', '$2y$10$wmG1sV.DKtBGmElbfJvdNezoKWvene1rOui8jJU48e01USIybXdVO', 'benito@sefue.com', '2025-03-20 12:32:57', 'Admon', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tusuariorol`
--

CREATE TABLE `tusuariorol` (
  `COD_USUARIO` int(11) DEFAULT NULL,
  `COD_ROL` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tusuariorol`
--

INSERT INTO `tusuariorol` (`COD_USUARIO`, `COD_ROL`) VALUES
(1, 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tajuste`
--
ALTER TABLE `tajuste`
  ADD PRIMARY KEY (`ID_AJUSTE`);

--
-- Indices de la tabla `tbio`
--
ALTER TABLE `tbio`
  ADD PRIMARY KEY (`COD_BIO`),
  ADD KEY `COD_EMPLEADO` (`COD_EMPLEADO`),
  ADD KEY `COD_TIPO_BIO` (`COD_TIPO_BIO`);

--
-- Indices de la tabla `templeado`
--
ALTER TABLE `templeado`
  ADD PRIMARY KEY (`COD_EMPLEADO`),
  ADD UNIQUE KEY `COD_USUARIO` (`COD_USUARIO`);

--
-- Indices de la tabla `tmarcaje`
--
ALTER TABLE `tmarcaje`
  ADD PRIMARY KEY (`COD_MARCAJE`),
  ADD KEY `COD_EMPLEADO` (`COD_EMPLEADO`),
  ADD KEY `COD_BIO` (`COD_BIO`),
  ADD KEY `COD_TIPO_ACCESO` (`COD_TIPO_ACCESO`);

--
-- Indices de la tabla `trol`
--
ALTER TABLE `trol`
  ADD PRIMARY KEY (`COD_ROL`);

--
-- Indices de la tabla `ttbio`
--
ALTER TABLE `ttbio`
  ADD PRIMARY KEY (`COD_TIPO_BIO`);

--
-- Indices de la tabla `ttipoacceso`
--
ALTER TABLE `ttipoacceso`
  ADD PRIMARY KEY (`COD_TIPO_ACCESO`);

--
-- Indices de la tabla `ttransacciones`
--
ALTER TABLE `ttransacciones`
  ADD PRIMARY KEY (`COD_TRANSACCION`),
  ADD KEY `COD_USUARIO` (`COD_USUARIO`);

--
-- Indices de la tabla `tusuario`
--
ALTER TABLE `tusuario`
  ADD PRIMARY KEY (`COD_USUARIO`);

--
-- Indices de la tabla `tusuariorol`
--
ALTER TABLE `tusuariorol`
  ADD KEY `COD_USUARIO` (`COD_USUARIO`),
  ADD KEY `COD_ROL` (`COD_ROL`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tajuste`
--
ALTER TABLE `tajuste`
  MODIFY `ID_AJUSTE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tbio`
--
ALTER TABLE `tbio`
  MODIFY `COD_BIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `templeado`
--
ALTER TABLE `templeado`
  MODIFY `COD_EMPLEADO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tmarcaje`
--
ALTER TABLE `tmarcaje`
  MODIFY `COD_MARCAJE` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `trol`
--
ALTER TABLE `trol`
  MODIFY `COD_ROL` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ttbio`
--
ALTER TABLE `ttbio`
  MODIFY `COD_TIPO_BIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `ttipoacceso`
--
ALTER TABLE `ttipoacceso`
  MODIFY `COD_TIPO_ACCESO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `ttransacciones`
--
ALTER TABLE `ttransacciones`
  MODIFY `COD_TRANSACCION` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `tusuario`
--
ALTER TABLE `tusuario`
  MODIFY `COD_USUARIO` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tbio`
--
ALTER TABLE `tbio`
  ADD CONSTRAINT `tbio_ibfk_1` FOREIGN KEY (`COD_EMPLEADO`) REFERENCES `templeado` (`COD_EMPLEADO`),
  ADD CONSTRAINT `tbio_ibfk_2` FOREIGN KEY (`COD_TIPO_BIO`) REFERENCES `ttbio` (`COD_TIPO_BIO`);

--
-- Filtros para la tabla `tmarcaje`
--
ALTER TABLE `tmarcaje`
  ADD CONSTRAINT `tmarcaje_ibfk_1` FOREIGN KEY (`COD_EMPLEADO`) REFERENCES `templeado` (`COD_EMPLEADO`),
  ADD CONSTRAINT `tmarcaje_ibfk_2` FOREIGN KEY (`COD_BIO`) REFERENCES `tbio` (`COD_BIO`),
  ADD CONSTRAINT `tmarcaje_ibfk_3` FOREIGN KEY (`COD_TIPO_ACCESO`) REFERENCES `ttipoacceso` (`COD_TIPO_ACCESO`);

--
-- Filtros para la tabla `ttransacciones`
--
ALTER TABLE `ttransacciones`
  ADD CONSTRAINT `ttransacciones_ibfk_1` FOREIGN KEY (`COD_USUARIO`) REFERENCES `tusuario` (`COD_USUARIO`);

--
-- Filtros para la tabla `tusuario`
--
ALTER TABLE `tusuario`
  ADD CONSTRAINT `tusuario_ibfk_1` FOREIGN KEY (`COD_USUARIO`) REFERENCES `templeado` (`COD_USUARIO`);

--
-- Filtros para la tabla `tusuariorol`
--
ALTER TABLE `tusuariorol`
  ADD CONSTRAINT `tusuariorol_ibfk_1` FOREIGN KEY (`COD_USUARIO`) REFERENCES `tusuario` (`COD_USUARIO`),
  ADD CONSTRAINT `tusuariorol_ibfk_2` FOREIGN KEY (`COD_ROL`) REFERENCES `trol` (`COD_ROL`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
