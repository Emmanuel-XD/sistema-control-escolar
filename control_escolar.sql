-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-10-2023 a las 18:30:53
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `control_escolar`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumnos`
--

CREATE TABLE `alumnos` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `curp` varchar(150) NOT NULL,
  `edad` varchar(50) NOT NULL,
  `birthdate` date NOT NULL,
  `id_grado` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `alumnos`
--

INSERT INTO `alumnos` (`id`, `id_user`, `nombre`, `apellido`, `correo`, `telefono`, `curp`, `edad`, `birthdate`, `id_grado`, `fecha`) VALUES
(4, 0, 'Hector', 'Gomez Chavez', 'campos12@gmail.com', '99111656701', 'WDSGDFSGN', '21', '2023-08-20', 1, '2023-08-28 23:56:22'),
(6, 0, 'Danna', 'Cardenas Argaez', 'dia@gmai.com', '99111656701', 'MATY000319MYNRMNA9', '21', '2023-10-16', 1, '2023-10-16 14:21:14'),
(7, 23, 'Jafet ', 'Munoz Medina', 'ejemplo@gmail.com', '99111656701', 'MATY000319MYNRMNA9', '21', '2023-10-27', 2, '2023-10-16 20:57:53');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacion`
--

CREATE TABLE `calificacion` (
  `id` int(11) NOT NULL,
  `promedio` int(50) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `calificacion`
--

INSERT INTO `calificacion` (`id`, `promedio`, `fecha`) VALUES
(1, 100, '2023-10-16 16:57:14');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacion_eval`
--

CREATE TABLE `calificacion_eval` (
  `id` int(11) NOT NULL,
  `id_calificacion` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `id_evaluacion` int(11) NOT NULL,
  `id_periodo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `calificacion_eval`
--

INSERT INTO `calificacion_eval` (`id`, `id_calificacion`, `id_alumno`, `id_materia`, `id_evaluacion`, `id_periodo`) VALUES
(1, 1, 6, 24, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `categoria` varchar(100) NOT NULL,
  `registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`, `registro`) VALUES
(1, 'COMPUTACION', '2023-10-17 21:38:05'),
(2, 'LABORATORIO', '2023-10-17 21:38:28'),
(3, 'LIMPIEZA', '2023-10-17 21:38:41');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `especialidades`
--

CREATE TABLE `especialidades` (
  `id` int(11) NOT NULL,
  `especialidad` varchar(100) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `especialidades`
--

INSERT INTO `especialidades` (`id`, `especialidad`, `fecha`) VALUES
(1, 'Informactica', '2023-08-19 23:47:08'),
(2, 'Ciencias & Tecnologias', '2023-08-28 23:40:02'),
(3, 'Literatura', '2023-08-19 23:47:34'),
(4, 'Lenguas Extrangeras', '2023-08-19 23:47:52'),
(5, 'Matematicas Aplicadas', '2023-08-19 23:48:29');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evaluacion`
--

CREATE TABLE `evaluacion` (
  `id` int(11) NOT NULL,
  `evaluacion` varchar(150) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `evaluacion`
--

INSERT INTO `evaluacion` (`id`, `evaluacion`, `fecha_registro`) VALUES
(1, 'Primera Evaluacion', '2023-10-16 16:04:14'),
(2, 'Segunda Evaluacion', '2023-10-16 16:04:14'),
(3, 'Tercera Evaluacion', '2023-10-16 16:20:59');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grados`
--

CREATE TABLE `grados` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `duracion` varchar(50) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `grados`
--

INSERT INTO `grados` (`id`, `descripcion`, `duracion`, `fecha`) VALUES
(1, '1A', '6 meses', '2023-08-28 23:34:18'),
(2, '1B', '3 meses', '2023-08-19 23:41:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `descripcion` varchar(150) NOT NULL,
  `cantidad` int(50) NOT NULL,
  `existencia` int(50) NOT NULL,
  `unidad` varchar(150) NOT NULL,
  `id_profesor` int(11) NOT NULL,
  `id_categoria` int(11) NOT NULL,
  `status` varchar(100) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id`, `codigo`, `descripcion`, `cantidad`, `existencia`, `unidad`, `id_profesor`, `id_categoria`, `status`, `fecha`) VALUES
(1, '01', 'Proyector Epson', 5, 4, 'UND', 2, 1, 'Disponible', '2023-10-17 21:39:51'),
(2, '02', 'Cable HDMI', 5, 4, 'PZA', 1, 1, 'Disponible', '2023-10-19 15:45:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias`
--

CREATE TABLE `materias` (
  `id` int(11) NOT NULL,
  `materia` varchar(100) NOT NULL,
  `id_profesor` int(11) NOT NULL,
  `id_periodo` int(11) NOT NULL,
  `id_grado` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `materias`
--

INSERT INTO `materias` (`id`, `materia`, `id_profesor`, `id_periodo`, `id_grado`, `fecha`) VALUES
(1, 'Matematicas', 2, 2, 2, '2023-10-16 14:56:38'),
(9, 'Quimica ', 2, 2, 2, '2023-10-16 15:53:06'),
(12, 'Historia Universal', 2, 3, 2, '2023-10-16 14:56:46'),
(15, 'Diseño Web', 1, 3, 2, '2023-10-16 14:56:24'),
(16, 'TICS', 1, 3, 1, '2023-10-16 14:57:09'),
(17, 'Temas Selectos de Fisica', 1, 3, 1, '2023-10-16 14:56:55'),
(18, 'Base de datos', 1, 2, 2, '2023-10-16 14:53:09'),
(19, 'Filosofia', 2, 3, 1, '2023-10-16 14:56:31'),
(24, 'Diseño Grafico', 1, 2, 1, '2023-10-16 14:42:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodos`
--

CREATE TABLE `periodos` (
  `id` int(11) NOT NULL,
  `periodo` varchar(150) NOT NULL,
  `date_in` date NOT NULL,
  `date_fin` date NOT NULL,
  `registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `periodos`
--

INSERT INTO `periodos` (`id`, `periodo`, `date_in`, `date_fin`, `registro`) VALUES
(2, 'Periodo Ago - Dic', '2023-06-07', '2023-12-15', '2023-10-16 14:33:41'),
(3, 'Periodo Ene - Jun', '2024-01-08', '2024-06-21', '2023-10-16 14:56:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE `permisos` (
  `id` int(11) NOT NULL,
  `rol` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `rol`) VALUES
(1, 'Administrador'),
(2, 'Profesor'),
(3, 'Alumno');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `id` int(11) NOT NULL,
  `id_profesor` int(11) NOT NULL,
  `id_materia` int(11) NOT NULL,
  `id_material` int(11) NOT NULL,
  `fecha_slt` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `hora_in` time NOT NULL,
  `hora_fin` time NOT NULL,
  `cant` int(50) NOT NULL,
  `status` varchar(50) NOT NULL,
  `fecha_registrado` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`id`, `id_profesor`, `id_materia`, `id_material`, `fecha_slt`, `fecha_fin`, `hora_in`, `hora_fin`, `cant`, `status`, `fecha_registrado`) VALUES
(30, 2, 18, 2, '2023-10-23', '2023-10-27', '11:20:00', '00:20:00', 1, 'Solicitar', '2023-10-19 16:19:13'),
(33, 1, 1, 1, '2023-10-19', '2023-10-21', '00:27:00', '03:27:00', 1, 'Aprobado', '2023-10-19 16:27:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `profesores`
--

CREATE TABLE `profesores` (
  `id` int(11) NOT NULL,
  `cedula` varchar(100) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(100) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `curp` varchar(150) NOT NULL,
  `edad` varchar(50) NOT NULL,
  `fecha_na` date NOT NULL,
  `id_especialidad` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `profesores`
--

INSERT INTO `profesores` (`id`, `cedula`, `nombres`, `apellidos`, `correo`, `curp`, `edad`, `fecha_na`, `id_especialidad`, `fecha`) VALUES
(1, '0145756', 'Alexander', 'Castillo Cervantes', 'lex@gmail.com', 'SDFGSDFGOJDSH', '34', '2000-08-02', 1, '2023-08-28 23:48:04'),
(2, '527532', 'Emmanuel', 'Gomez Chavez', 'example@gmail.com', 'MNRFHGRTHRH6868', '22', '2023-08-20', 5, '2023-08-20 15:31:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `password` varchar(300) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_rol` int(11) NOT NULL,
  `imagen` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `usuario`, `correo`, `password`, `fecha`, `id_rol`, `imagen`) VALUES
(5, 'Administrador', 'admin@gmail.com', '$2y$05$rSGStdVtYXAeIMxNwVR1suYBn4LT7zwImjLKvEMTT7Rxx1kKlCA8W', '2023-08-19 22:40:13', 1, ''),
(20, 'Emanuel', 'saul@gmail.com', '$2y$05$4rVBmwaaBu2Auh.XH87jFeNmrPdsgDL9JFL680q/QwKIeLpNpu7BW', '2023-08-29 00:37:24', 1, ''),
(23, 'Ejemplo', 'ejemplo@gmail.com ', '$2y$05$VGeHmc3z9KnnwF8lALF4mezwN.MOURssoB8wM.INCwBxfJDphazba', '2023-10-16 20:40:09', 3, '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `calificacion_eval`
--
ALTER TABLE `calificacion_eval`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `evaluacion`
--
ALTER TABLE `evaluacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `grados`
--
ALTER TABLE `grados`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `materias`
--
ALTER TABLE `materias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `periodos`
--
ALTER TABLE `periodos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `profesores`
--
ALTER TABLE `profesores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alumnos`
--
ALTER TABLE `alumnos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `calificacion`
--
ALTER TABLE `calificacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `calificacion_eval`
--
ALTER TABLE `calificacion_eval`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `especialidades`
--
ALTER TABLE `especialidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `evaluacion`
--
ALTER TABLE `evaluacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `grados`
--
ALTER TABLE `grados`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `materias`
--
ALTER TABLE `materias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `periodos`
--
ALTER TABLE `periodos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `profesores`
--
ALTER TABLE `profesores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
