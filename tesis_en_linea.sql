-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2015 at 05:39 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tesis_en_linea`
--

-- --------------------------------------------------------

--
-- Table structure for table `alertas`
--

CREATE TABLE IF NOT EXISTS `alertas` (
`id` int(11) NOT NULL,
  `id_agente` int(11) DEFAULT NULL,
  `id_emisor` int(11) NOT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `url_audio` text NOT NULL,
  `audio` varchar(255) NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `fecha_creada` datetime NOT NULL,
  `fecha_visto` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alertas`
--

INSERT INTO `alertas` (`id`, `id_agente`, `id_emisor`, `estado`, `url_audio`, `audio`, `asunto`, `fecha_creada`, `fecha_visto`) VALUES
(1, 20, 0, '2', '', '140530131928_1686_5108600356', 'New Evaluation!', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 20, 0, '2', '', '140530131928_1686_5108600356', 'New Evaluation!', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 20, 0, '1', '', '140530121226_1686_5013664508', 'New Evaluation!', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `inputs`
--

CREATE TABLE IF NOT EXISTS `inputs` (
`id` int(11) NOT NULL,
  `id_pagina` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  `label` text NOT NULL,
  `tipo_input` varchar(255) NOT NULL,
  `required` int(11) NOT NULL DEFAULT '1',
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inputs`
--

INSERT INTO `inputs` (`id`, `id_pagina`, `orden`, `estado`, `label`, `tipo_input`, `required`, `nombre`) VALUES
(3, 2, 1, 1, 'Por favor ingresa tu nombre', 'texto', 0, 'nombre'),
(4, 2, 1, 1, 'asdasd', 'texto', 0, 'otro1'),
(5, 2, 1, 1, 'y otro mas', 'texto', 0, 'yotromas'),
(7, 2, 4, 1, 'gggggggg', 'texto', 0, 'ggggggg'),
(8, 2, 6, 1, 'fffffffffffffffff', 'texto', 0, 'ffffffffff'),
(12, 2, 6, 1, 'gfhjgfhjgfhj', 'texto', 0, 'gfhjghfj'),
(13, 2, 7, 1, 'tyuityuityu', 'texto', 0, 'tyuityui'),
(14, 2, 8, 1, 'ghkjghjkghkj', 'texto', 0, 'ghjkghkj'),
(16, 4, 9, 1, 'como estas @nombre? ', 'texto', 0, 'saludo'),
(17, 4, 9, 1, 'otrodeprueba', 'texto', 0, 'otrodeprueba');

-- --------------------------------------------------------

--
-- Table structure for table `input_select`
--

CREATE TABLE IF NOT EXISTS `input_select` (
`id` int(11) NOT NULL,
  `id_input` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL COMMENT 'comun,multiselect',
  `carga` varchar(255) NOT NULL COMMENT 'de donde carga los elementos: manualmente,  de la tabla respuesta_select,de las respuestas de un usuario,de las respuestas de todos los usuarios (eliminando las duplicadas (trim(ucword(strtolower()))))'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `input_texto`
--

CREATE TABLE IF NOT EXISTS `input_texto` (
`id` int(11) NOT NULL,
  `id_input` int(11) NOT NULL,
  `respuestas_requeridas` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `input_texto`
--

INSERT INTO `input_texto` (`id`, `id_input`, `respuestas_requeridas`) VALUES
(1, 1, '1'),
(2, 2, '1'),
(3, 3, '1'),
(4, 4, '1'),
(5, 5, '1'),
(6, 6, '1'),
(7, 7, '1'),
(8, 8, '1'),
(9, 9, '1'),
(10, 10, '1'),
(11, 11, '1'),
(12, 12, '1'),
(13, 13, '1'),
(14, 14, '1'),
(15, 15, '1'),
(16, 16, '1'),
(17, 17, '1');

-- --------------------------------------------------------

--
-- Table structure for table `mensajes`
--

CREATE TABLE IF NOT EXISTS `mensajes` (
`id` int(11) NOT NULL,
  `id_emisor` int(11) DEFAULT NULL,
  `id_receptor` int(11) DEFAULT NULL,
  `mensaje` text,
  `asunto` varchar(255) DEFAULT NULL,
  `fecha_leido` datetime DEFAULT NULL,
  `fecha_creado` datetime DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mensajes`
--

INSERT INTO `mensajes` (`id`, `id_emisor`, `id_receptor`, `mensaje`, `asunto`, `fecha_leido`, `fecha_creado`, `estado`) VALUES
(1, 2, 20, '<font color="#f83a22" size="5">E</font>mail de prueba<br>', 'New Evaluation!', '0000-00-00 00:00:00', '2014-06-10 00:00:00', '2'),
(2, 20, 2, 'Respuesta2', '2', '0000-00-00 00:00:00', '2014-06-10 00:00:00', '2'),
(3, 2, 20, 'Respuesta3', '20', '0000-00-00 00:00:00', '2014-06-10 00:00:00', '2'),
(4, 20, 2, 'Respuesta2', '2', '0000-00-00 00:00:00', '2014-06-10 00:00:00', '2'),
(5, 20, 2, 'asdasdsad', '2', '0000-00-00 00:00:00', '2014-06-10 00:00:00', '2'),
(6, 2, 20, 'Respuesta3', '20', '0000-00-00 00:00:00', '2014-06-10 00:00:00', '2'),
(7, 20, 2, 'Respuesta10', '2', '0000-00-00 00:00:00', '2014-06-10 00:00:00', '2'),
(8, 20, 2, 'Respuesta10', '2', '0000-00-00 00:00:00', '2014-06-10 00:00:00', '2'),
(9, 20, 2, 'Respuesta10', '2', '0000-00-00 00:00:00', '2014-06-10 00:00:00', '2'),
(10, 20, 2, 'Respuesta10', '2', '0000-00-00 00:00:00', '2014-06-10 00:00:00', '2'),
(11, 20, 2, 'Respuesta11', '2', '0000-00-00 00:00:00', '2014-06-10 00:00:00', '2'),
(12, 20, 2, 'Respuesta11', '2', '0000-00-00 00:00:00', '2014-06-10 00:00:00', '2'),
(13, 2, 20, 'asdfasdfasdfasdf<br><font color="#9fe1e7">asdfasdfasdfasdf<br>asdfasdfasdfasdf</font><br>asdfasdfasdfasdf<br>', '20', '0000-00-00 00:00:00', '2014-06-11 00:00:00', '2'),
(14, 20, 2, 'mensajeeeeeeeeeee', 'asuntooooo', '0000-00-00 00:00:00', '2014-06-11 00:00:00', '2'),
(16, 20, 2, 'asdfsadfsadfsdasdfa', 'asdfasdf', '0000-00-00 00:00:00', '2014-06-11 00:00:00', '1'),
(17, 2, 20, 'asdfasdfsdafsdaf', 'asdfasdf', '0000-00-00 00:00:00', '2014-06-11 00:00:00', '1'),
(18, 2, 2, 'Email para 2', 'Email para 2', '0000-00-00 00:00:00', '2014-06-16 00:00:00', '1'),
(19, 2, 72, 'Email para 2', 'Email para 2', '0000-00-00 00:00:00', '2014-06-16 00:00:00', '1');

-- --------------------------------------------------------

--
-- Table structure for table `paginas`
--

CREATE TABLE IF NOT EXISTS `paginas` (
`id` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `orden` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paginas`
--

INSERT INTO `paginas` (`id`, `titulo`, `orden`, `estado`) VALUES
(2, 'Base del Proyecto', 6, 1),
(4, 'Y otra mas', 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `respuestas`
--

CREATE TABLE IF NOT EXISTS `respuestas` (
`id` int(11) NOT NULL,
  `id_input` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `respuestas`
--

INSERT INTO `respuestas` (`id`, `id_input`, `tipo`, `id_usuario`, `estado`) VALUES
(1, 3, 'texto', 5, 1),
(2, 4, 'texto', 5, 1),
(3, 5, 'texto', 5, 1),
(4, 7, 'texto', 5, 1),
(5, 8, 'texto', 5, 1),
(6, 12, 'texto', 5, 1),
(7, 13, 'texto', 5, 1),
(8, 14, 'texto', 5, 1),
(9, 3, 'texto', 5, 1),
(10, 4, 'texto', 5, 1),
(11, 5, 'texto', 5, 1),
(12, 7, 'texto', 5, 1),
(13, 8, 'texto', 5, 1),
(14, 12, 'texto', 5, 1),
(15, 13, 'texto', 5, 1),
(16, 14, 'texto', 5, 1),
(17, 3, 'texto', 5, 1),
(18, 4, 'texto', 5, 1),
(19, 5, 'texto', 5, 1),
(20, 7, 'texto', 5, 1),
(21, 8, 'texto', 5, 1),
(22, 12, 'texto', 5, 1),
(23, 13, 'texto', 5, 1),
(24, 14, 'texto', 5, 1),
(25, 3, 'texto', 5, 1),
(26, 4, 'texto', 5, 1),
(27, 5, 'texto', 5, 1),
(28, 7, 'texto', 5, 1),
(29, 8, 'texto', 5, 1),
(30, 12, 'texto', 5, 1),
(31, 13, 'texto', 5, 1),
(32, 14, 'texto', 5, 1),
(33, 3, 'texto', 5, 1),
(34, 4, 'texto', 5, 1),
(35, 5, 'texto', 5, 1),
(36, 7, 'texto', 5, 1),
(37, 8, 'texto', 5, 1),
(38, 12, 'texto', 5, 1),
(39, 13, 'texto', 5, 1),
(40, 14, 'texto', 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `respuesta_texto`
--

CREATE TABLE IF NOT EXISTS `respuesta_texto` (
`id` int(11) NOT NULL,
  `id_respuesta` int(11) NOT NULL,
  `texto` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `respuesta_texto`
--

INSERT INTO `respuesta_texto` (`id`, `id_respuesta`, `texto`) VALUES
(1, 1, 'a'),
(2, 2, 'b'),
(3, 3, 'c'),
(4, 4, 'd'),
(5, 5, 'e'),
(6, 6, 'f'),
(7, 7, 'g'),
(8, 8, 'h'),
(9, 9, 'a'),
(10, 10, 'b'),
(11, 11, 'c'),
(12, 12, 'd'),
(13, 13, 'e'),
(14, 14, 'f'),
(15, 15, 'g'),
(16, 16, 'h'),
(17, 17, 'a'),
(18, 18, 'b'),
(19, 19, 'c'),
(20, 20, 'd'),
(21, 21, 'e'),
(22, 22, 'f'),
(23, 23, 'g'),
(24, 24, 'h'),
(25, 25, 'a'),
(26, 26, 'b'),
(27, 27, 'c'),
(28, 28, 'd'),
(29, 29, 'e'),
(30, 30, 'f'),
(31, 31, 'g'),
(32, 32, 'h'),
(33, 33, 'a'),
(34, 34, 'b'),
(35, 35, 'c'),
(36, 36, 'd'),
(37, 37, 'e'),
(38, 38, 'f'),
(39, 39, 'g'),
(40, 40, 'h');

-- --------------------------------------------------------

--
-- Table structure for table `select_collections`
--

CREATE TABLE IF NOT EXISTS `select_collections` (
`id` int(11) NOT NULL,
  `id_select` int(11) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tipos_usuario`
--

CREATE TABLE IF NOT EXISTS `tipos_usuario` (
`id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tipos_usuario`
--

INSERT INTO `tipos_usuario` (`id`, `usuario`) VALUES
(1, 'Administrador_Sistema'),
(2, 'Administrador'),
(3, 'Supervisor'),
(4, 'Agente');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
`id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `md5` varchar(255) NOT NULL,
  `tipo` int(2) NOT NULL,
  `fechaReg` datetime DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `id_callcenter` varchar(255) DEFAULT NULL,
  `avatar` mediumblob
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `md5`, `tipo`, `fechaReg`, `estado`, `id_callcenter`, `avatar`) VALUES
(1, 'admin', 'admin', 'admin@telecomnetworks.net', '21232f297a57a5a743894a0e4a801fc3', 1, '2014-03-26 00:00:00', 1, NULL, NULL),
(2, 'Edgar', 'Sanchez', 'edgarsanchez@mail.com', '64405c9d68896131884c9a75cd4fdc4b', 2, '0000-00-00 00:00:00', 1, NULL, 0xefbfbd504e470d0a1a0a0000000d494844520000005e0000005e0806000000efbfbdd2a36e00000006624b474400efbfbd00efbfbd00efbfbdefbfbdefbfbdefbfbdefbfbd000000097048597300000eefbfbd00000eefbfbd01efbfbd2b0e1b0000000774494d4507efbfbd011403282a490734070000001974455874436f6d6d656e74004372656174656420776974682047494d5057efbfbd0e17000020004944415478daad5d59efbfbdefbfbdefbfbdefbfbd3d04400004efbfbd2139efbfbd66efbfbd192defbfbd642771efbfbd21efbfbdefbfbd5425efbfbdefbfbd542aefbfbd537e43efbfbdefbfbdefbfbd5aefbfbdefbfbdefbfbdefbfbd5c7152efbfbd6d49762c59efbfbd6838efbfbd17efbfbdefbfbdefbfbdefbfbdefbfbd39efbfbd3521701b7befbfbd541acd9004d0b7efbfbdefbfbdd3a7efbfbdefbfbd72efbfbdefbfbdefbfbdefbfbd22efbfbdefbfbd61efbfbd572eefbfbdefbfbd3fefbfbdefbfbdefbfbd6221efbfbdd1afefbfbdefbfbd0cefbfbdefbfbdefbfbdefbfbdefbfbd7befbfbdefbfbdefbfbd5c2eefbfbddab5577d165fefbfbd5fefbfbdefbfbd7d2c16efbfbdefbfbdefbfbdcd9f2549efbfbdefbfbdefbfbdefbfbdefbfbdefbfbd5fefbfbd3637efbfbd7eefbfbd5537efbfbdefbfbd26efbfbd0cefbfbdefbfbdefbfbd372defbfbd36efbfbdefbfbd0befbfbdefbfbd01567d46efbfbdefbfbd0defbfbdefbfbdefbfbd79efbfbd76efbfbdd6bd296defbfbd2cc3a41f6617efbfbdefbfbdefbfbdefbfbd692f5defbfbd38efbfbdefbfbdefbfbd2c2fefbfbd66efbfbd6439efbfbd2aefbfbd5eefbfbdefbfbdefbfbd3aefbfbdefbfbdefbfbdefbfbd5946efbfbdefbfbdefbfbd6d61675befbfbd5f67781a6aefbfbd42efbfbdefbfbd7eefbfbd36efbfbdefbfbd6defbfbdefbfbd5869efbfbd5d0defbfbd6a55efbfbdefbfbdefbfbdeab3b6efbfbdefbfbdefbfbdefbfbdefbfbd5defbfbdefbfbdefbfbdefbfbd300c2449efbfbdefbfbd4b5641d7a66befbfbd77d6a6efbfbdefbfbd65efbfbd6defbfbdefbfbd5defbfbdefbfbd2d74efbfbd333cefbfbdefbfbd2eefbfbd4f1befbfbdefbfbd3eefbfbdefbfbd5639efbfbd260803002befbfbd53efbfbd1befbfbdefbfbd7513efbfbdefbfbd7aefbfbd36efbfbdefbfbdefbfbdefbfbd55efbfbd771befbfbdefbfbdefbfbd6f22115946330c63efbfbdc5a4efbfbdefbfbd36efbfbd2aefbfbd672defbfbdefbfbdefbfbd60efbfbdefbfbd3aefbfbdefbfbdefbfbd76efbfbdefbfbd5537efbfbd2defbfbdefbfbdefbfbd57d1b94defbfbdefbfbd2b74efbfbdefbfbdefbfbd59efbfbdefbfbd254d593742efbfbd2a7eefbfbd6aefbfbdefbfbd621befbfbd7a55daa3efbfbd1e342b38efbfbdefbfbdefbfbdefbfbdefbfbd0a1657efbfbdefbfbd3658efbfbdefbfbdefbfbdd3b6dab4efbfbdefbfbdefbfbd696531efbfbd55deb30aefbfbd57197ed5836fefbfbdefbfbd264aefbfbd4b5cefbfbd29efbfbdccbaefbfbd601befbfbdefbfbd3befbfbd35c3afe3b7abefbfbdefbfbdefbfbdefbfbdefbfbd196b131defbfbd7aefbfbd75efbfbd6eefbfbd58efbfbd6befbfbdefbfbd254fefbfbd444befbfbdefbfbdefbfbd755eefbfbd0e66efbfbdefbfbdefbfbdefbfbdefbfbdefbfbd76efbfbd6f0acc9b16725befbfbdefbfbd4befbfbdefbfbde58cbbee9a953c7e57efbfbd580533efbfbd1a6aefbfbd0ed9b4efbfbd36197fefbfbd78efbfbdefbfbd6357197e5b6859efbfbd78efbfbd5defbfbdefbfbd3aefbfbdefbfbdefbfbd6eefbfbdefbfbd4befbfbdefbfbd641d73efbfbd360fefbfbd0defbfbd68efbfbd6defbfbdefbfbdefbfbdefbfbdefbfbdefbfbd0cefbfbdefbfbdefbfbddba6efbfbd6a5372efbfbd4eefbfbdefbfbd36415bc79aefbfbd196117efbfbdefbfbd26035eefbfbdefbfbd4b5aefbfbdefbfbd67efbfbdefbfbdefbfbd3a312defbfbdefbfbdefbfbdefbfbdefbfbd6d76efbfbd0defbfbd59efbfbdefbfbd69cab9efbfbd24efbfbd0b1c6531efbfbdefbfbdefbfbdefbfbdefbfbdefbfbd582c7e6035596fefbfbd265d5fefbfbdefbfbdefbfbdefbfbd62efbfbd0cefbfbdefbfbd0e6eefbfbd69efbfbd70efbfbd5d59cfae102d18efbfbdefbfbd4f6fefbfbdefbfbd75efbfbdefbfbdefbfbd08efbfbdefbfbdefbfbd75efbfbdefbfbdefbfbd1c63efbfbd35efbfbd61553fefbfbdefbfbd6cefbfbdefbfbd00efbfbdefbfbdefbfbdefbfbd59efbfbd73efbfbdefbfbd6f63efbfbd5559efbfbd6d78efbfbdefbfbdefbfbdefbfbdefbfbdefbfbdefbfbd4fefbfbdefbfbdefbfbd2cefbfbd5270efbfbd6d36efbfbd0e6ad689483f553163efbfbd1137efbfbd1eefbfbd52efbfbd6d34efbfbd4d5a3c0058efbfbd69efbfbd24efbfbd6f1b07efbfbdefbfbdefbfbdefbfbd4defbfbdefbfbdefbfbdefbfbd6ddfbb2eefbfbdefbfbd58e3afbb66efbfbd3a791bdebb6e5b6fd2a56fefbfbdefbfbd6f2a7cefbfbd3603efbfbd6d0eefbfbd0e5636efbfbdefbfbd5c2eefbfbd03efbfbdefbfbd0befbfbd02efbfbdefbfbdefbfbd6d6f7c53efbfbdcca260efbfbd30785befbfbd6b0758efbfbd70efbfbd14d8be0befbfbd7cefbfbdefbfbd60efbfbd4876efbfbdefbfbd3aefbfbd746618efbfbd2433efbfbd28efbfbd7c1e6118efbfbd6628efbfbdefbfbd31efbfbdefbfbdefbfbd791eefbfbd20efbfbdefbfbd382816efbfbd08efbfbd006118efbfbdefbfbd3c2100efbfbd6962efbfbd58efbfbd344d445104efbfbd3010efbfbd314cefbfbd7c4d36efbfbd3623efbfbdc690efbfbd38efbfbd2e1b6aefbfbd2649efbfbd1c5c77efbfbd66efbfbd6118efbfbdefbfbdefbfbd24496059efbfbd7c1fefbfbd312cefbfbdefbfbd683442efbfbdefbfbd46efbfbd56433eefbfbd47100462efbfbd38efbfbdefbfbd582c10efbfbd21efbfbdefbfbdefbfbdefbfbdc29aefbfbd09efbfbd34efbfbd33efbfbdefbfbd76efbfbdefbfbd04efbfbd12efbfbd75efbfbdefbfbdefbfbdefbfbdefbfbd324d737defbfbd751b7eefbfbd4eefbfbdc992710967efbfbd01efbfbdefbfbd34efbfbd4e114511efbfbdefbfbdefbfbd311c0e31efbfbdefbfbd512aefbfbd30efbfbdefbfbd61efbfbd36efbfbd244118efbfbdefbfbdefbfbd66efbfbdefbfbd66efbfbd2c0befbfbd7c1eefbfbd72593c3f4912efbfbdefbfbd29efbfbdefbfbd65efbfbd4d347953efbfbdc6b6efbfbdcfaa502defbfbdefbfbdefbfbd11efbfbdefbfbdefbfbdefbfbdefbfbdefbfbdccb9efbfbdefbfbdefbfbd343cefbfbd3cefbfbd224cefbfbd535c5d5d613c1e63341aefbfbd2eefbfbd77efbfbdefbfbdefbfbd244930efbfbdefbfbdefbfbdefbfbd3e0cefbfbdefbfbd6c3643efbfbd52413eefbfbdefbfbdd89424096cefbfbdefbfbd58efbfbdefbfbd7defbfbd46efbfbdefbfbd4d7befbfbd6b74725331781b4d7defbfbd6b6870efbfbdefbfbdefbfbdefbfbd5c2eefbfbd28efbfbdefbfbdefbfbd3eefbfbdefbfbdefbfbdefbfbdefbfbd761104efbfbdefbfbd77efbfbd6633efbfbd72394c261359efbfbd2008efbfbdefbfbd2e26efbfbd09efbfbd3044efbfbd5010efbfbdefbfbdefbfbdefbfbdefbfbd10efbfbdefbfbdc6a61defbfbd4e5e5eefbfbdefbfbdefbfbdcaa65439efbfbd6defbfbdefbfbd3637efbfbd6defbfbd4aefbfbdefbfbdefbfbd092befbfbd4e0749efbfbd08666b4fefbfbd2c0befbfbdefbfbd0c511449400600dbb6efbfbdefbfbd3e2e2e2e60efbfbd361cefbfbd41efbfbd5e47efbfbd50efbfbdefbfbdefbfbd5b75efbfbdefbfbd0befbfbdefbfbd44efbfbd757d3cefbfbd741fefbfbd1eefbfbdefbfbdefbfbdefbfbdefbfbdefbfbd4defbfbd4fefbfbd39efbfbd2256efbfbdefbfbdefbfbdefbfbdefbfbdcb9718efbfbdefbfbdefbfbd72efbfbd24411445efbfbdefbfbd0cefbfbd6408efbfbd076118224912efbfbdefbfbd734cefbfbd53efbfbdefbfbd7914efbfbd4538efbfbdefbfbdefbfbd6c26efbfbd5fefbfbd30efbfbd49efbfbd6e53efbfbd5aefbfbd5e6b5d66efbfbd2d2befbfbdefbfbdefbfbd0919efbfbd6e17efbfbdefbfbd5c16efbfbd3450efbfbd311adeb22c18efbfbd21efbfbd71efbfbd5820efbfbd22d8b6efbfbd28efbfbdefbfbd5e47efbfbdefbfbd18efbfbd5eefbfbdefbfbd554e7fefbfbd16efbfbd4defbfbdefbfbd55efbfbdefbfbd04efbfbd5c5b0b64efbfbd69efbfbd36efbfbd1b4defbfbd441004efbfbd6d1befbfbd65210c43efbfbdefbfbdefbfbd63efbfbd7042efbfbd18efbfbd310cc390efbfbdefbfbdefbfbdefbfbd0100efbfbd7e5f0c1f45efbfbd70efbfbdefbfbdefbfbd18efbfbd01efbfbd7130efbfbdefbfbd25efbfbd324e7071787defbfbd34311aefbfbd10451106efbfbd0100efbfbd755d140a0559efbfbdefbfbd7c0eefbfbdefbfbd562aefbfbdefbfbd7a657472efbfbdefbfbd73efbfbdefbfbd3464efbfbdefbfbdefbfbdefbfbd274fefbfbd60efbfbd58efbfbdefbfbddcbf7f1f611822efbfbd22efbfbd66efbfbdefbfbdefbfbdefbfbd711c00efbfbd603040efbfbd52efbfbd7038efbfbdefbfbdefbfbdefbfbd61efbfbd36efbfbdefbfbd22efbfbdefbfbdefbfbd6befbfbdd5b66d18efbfbdefbfbdefbfbd77efbfbdefbfbdefbfbd7d612defbfbd5eefbfbd1208efbfbdefbfbdefbfbdefbfbd01efbfbd711cefbfbd71efbfbdefbfbd7c2eefbfbdefbfbdefbfbdd1bbefbfbd0f44efbfbdefbfbdefbfbd6618efbfbd46efbfbdefbfbd72701c0777efbfbdefbfbdefbfbd6c3643efbfbdefbfbdefbfbdefbfbdefbfbd255aefbfbd166aefbfbdefbfbdc6b8efbfbd0a52d79501efbfbd2867efbfbdefbfbd7befbfbd58efbfbdefbfbdefbfbdefbfbdefbfbd2949efbfbdefbfbdefbfbd37efbfbd402eefbfbd13efbfbd707373efbfbd38efbfbdefbfbd4fefbfbd50efbfbd5d31180cefbfbdefbfbdefbfbd7867efbfbd24705d57efbfbd38efbfbd2259efbfbd37efbfbd78437eefbfbd6eefbfbd311eefbfbdefbfbd3befbfbd0c4fefbfbdefbfbd06d79e6d1806efbfbd30efbfbd62efbfbdefbfbd6defbfbd582c16efbfbd4c2628140a2816efbfbdefbfbdefbfbd18efbfbd765befbfbdefbfbd5aefbfbdefbfbd300c04412010c5ac39efbfbd3f721d55efbfbd6aefbfbd5befbfbdefbfbdefbfbd2defbfbd42272dcb8269efbfbdefbfbd4eefbfbdefbfbd56efbfbd4b0fefbfbd24efbfbdefbfbdefbfbdefbfbd74502814502aefbfbdefbfbd68efbfbdefbfbd2eefbfbd32efbfbd10efbfbd7cdf87efbfbdefbfbd582c16efbfbdefbfbd7a68efbfbdefbfbd180c064227efbfbd4859131befbfbd1d2106efbfbd12552cefbfbd4a627c6eefbfbd2449efbfbdefbfbd3eefbfbdefbfbdefbfbdefbfbdd88b172fefbfbdefbfbd5fefbfbd12711cefbfbd5aefbfbd0a046eefbfbdefbfbddbb0217defbfbdefbfbdefbfbdefbfbd0060716b160a05efbfbdefbfbdefbfbdefbfbdefbfbd6defbfbd0c4befbfbd123cefbfbd13efbfbd28efbfbd4a2816efbfbd2816efbfbd48efbfbd04efbfbd5209efbfbd5e0fefbfbdefbfbd1cefbfbd5a0defbfbdefbfbd0cefbfbdefbfbd04efbfbd5249efbfbdefbfbdefbfbd3878efbfbdefbfbd01efbfbd20efbfbdefbfbdefbfbd257aefbfbdefbfbdefbfbd571cc7993745efbfbdefbfbdefbfbd4befbfbdccb2502aefbfbd6411efbfbdefbfbdefbfbd11efbfbdefbfbdefbfbd22efbfbd71301aefbfbdefbfbdefbfbdefbfbdc5b0efbfbd65efbfbdefbfbdefbfbd06efbfbdefbfbd187b7b7b6836efbfbd4b1aefbfbd6d4befbfbdefbfbd2863efbfbdefbfbdd3b141efbfbd78cbb2707c7cefbfbd6aefbfbd2a0fefbfbdefbfbd2e6e6e6eefbfbdefbfbd0aefbfbdefbfbd04417a13efbfbd4defbfbdefbfbd6d1befbfbdefbfbd1cefbfbd5c4e16efbfbdefbfbdefbfbd10efbfbd7c1eefbfbd7fefbfbd39efbfbdefbfbdee9287efbfbd6c567b1f0d4fcd851065efbfbd263cefbfbd13efbfbd5eefbfbd54efbfbdefbfbdefbfbdefbfbd217aefbfbd1eefbfbdefbfbd3a5cefbfbdefbfbdefbfbdc585efbfbd7b18efbfbd78efbfbdefbfbd39efbfbd7cefbfbdefbfbd25efbfbd4eefbfbdefbfbd6defbfbdefbfbd55430aefbfbd164d0b755a34efbfbd6aefbfbd1aefbfbdefbfbd3aefbfbdcda67c10594defbfbdefbfbd41efbfbdefbfbd16efbfbdefbfbd7d1fefbfbd560b00efbfbdefbfbd4f4e4e10efbfbd21efbfbdddae60efbfbdefbfbdefbfbd28140aefbfbdefbfbdcf9f3fefbfbdefbfbdefbfbd396cefbfbd166661efbfbdefbfbd18efbfbddfa7efbfbd057a2c17efbfbd78efbfbdefbfbdefbfbdefbfbd77efbfbd7907efbfbdefbfbdc2b66d78efbfbdefbfbdefbfbdefbfbd2b7cefbfbdefbfbd57c2a66cefbfbdefbfbdefbfbdefbfbdefbfbd04e18b8b0befbfbdefbfbd6defbfbdefbfbdefbfbd6532efbfbd2cefbfbd65efbfbdefbfbdefbfbdefbfbd23efbfbd7aefbfbdefbfbdefbfbd3521efbfbd4d1befbfbd4201efbfbd665370efbfbdefbfbdefbfbdefbfbd2fefbfbdefbfbdefbfbdc585efbfbdefbfbd0cefbfbd57575778efbfbdec99acefbfbd6118efbfbdefbfbdefbfbdefbfbdefbfbd6defbfbd5028efbfbdefbfbdefbfbd00efbfbdefbfbd082f5eefbfbdefbfbd6559efbfbdefbfbdefbfbdefbfbdefbfbdefbfbd6248efbfbdefbfbdefbfbdefbfbdefbfbd51efbfbd39efbfbd49efbfbd58efbfbdefbfbdefbfbd6aefbfbd502aefbfbd502eefbfbdefbfbdefbfbdefbfbd51efbfbdefbfbd052aefbfbd30efbfbdefbfbdefbfbdefbfbdefbfbdefbfbdefbfbdefbfbd6cefbfbdefbfbdefbfbdefbfbd5eefbfbdefbfbd4defbfbdefbfbdefbfbdefbfbd5aefbfbdefbfbdefbfbdefbfbd4defbfbdefbfbd6eefbfbd49efbfbd27efbfbdefbfbdefbfbd01efbfbdefbfbdefbfbdefbfbd76321eefbfbd71737303efbfbd30502eefbfbd25efbfbd24efbfbdefbfbd4c26efbfbdefbfbd662816efbfbd08efbfbd10efbfbd4a05efbfbd6211efbfbd4e07efbfbd560befbfbdefbfbd623eefbfbdefbfbdefbfbd7defbfbd61283453632aefbfbd4453443e007fefbfbd77056fdab66defbfbdefbfbd65efbfbd7a3defbfbd0c78efbfbdefbfbd7c1eefbfbd665354ce870f1fefbfbdefbfbd6fefbfbd45efbfbdefbfbd412eefbfbdefbfbdefbfbdefbfbd39efbfbd7defbfbd5defbfbdefbfbd79efbfbdefbfbd75efbfbd6f56efbfbd36efbfbd1aefbfbdefbfbd690532efbfbdefbfbdefbfbd17efbfbd3c3b3befbfbd240c43efbfbdefbfbd57efbfbd5eefbfbdefbfbdefbfbd0aefbfbdefbfbd0cefbfbd72196118623eefbfbdefbfbdefbfbd2aefbfbdefbfbd6cefbfbd4aefbfbd2222efbfbd611828140a48efbfbd04efbfbd5e0fefbfbdefbfbd220c43efbfbd7cefbfbd12efbfbd6e57efbfbdefbfbdefbfbd10efbfbd195a4fefbfbdcf89c5aeefbfbdefbfbd582cefbfbd5c2eefbfbdefbfbd3c7958efbfbdefbfbdefbfbdefbfbdefbfbd200804efbfbd0aefbfbdefbfbd707befbfbdefbfbd2517efbfbd56efbfbdefbfbdefbfbdefbfbdefbfbdefbfbd60efbfbd32efbfbd2c49771befbfbd70efbfbd0eefbfbdefbfbdefbfbd74dbb22c0cefbfbd433c7defbfbd14efbfbdefbfbdefbfbd124cefbfbd2441efbfbd5e1703753a1defbfbd6633efbfbd22064b42efbfbdefbfbd38701c07efbfbdefbfbd18efbfbdefbfbd04171717efbfbdefbfbd1b34efbfbd2aefbfbdefbfbd72393178efbfbd541258711c07efbfbdefbfbd42efbfbdefbfbdefbfbd70efbfbdefbfbd6804efbfbdefbfbdefbfbd286a18efbfbdefbfbdefbfbdefbfbdefbfbd56efbfbdefbfbd3c0f00301eefbfbdefbfbdefbfbdefbfbdefbfbd6656efbfbdefbfbdefbfbd4fefbfbdc7ab52efbfbd34efbfbdefbfbdefbfbdefbfbdefbfbdefbfbd42efbfbd0400efbfbd61efbfbd2008efbfbd0a084c463ccf9322efbfbd783cefbfbd04efbfbdefbfbdefbfbdefbfbd1f0c06efbfbd6d1befbfbd6a15efbfbdefbfbd08efbfbdefbfbdefbfbdefbfbdefbfbdefbfbd6f70efbfbdefbfbd10efbfbd6cefbfbd5eefbfbd7a1a36efbfbd2229efbfbd244922efbfbdefbfbd6559efbfbdefbfbd33512a140a72efbfbd4eefbfbdefbfbd28efbfbd32291f1defbfbd01efbfbd4eefbfbd2befbfbdefbfbdefbfbdefbfbdefbfbdefbfbd56efbfbd7c5e2eefbfbd24091cefbfbd11efbfbdefbfbdefbfbdefbfbd62efbfbd46efbfbdefbfbdefbfbdefbfbd630441efbfbd62efbfbdefbfbd28efbfbd1004efbfbd601aefbfbdefbfbdefbfbd65efbfbd16efbfbdefbfbd5b272defbfbdefbfbdefbfbd3aefbfbd1a6858efbfbd2730efbfbd32efbfbdefbfbd49efbfbd69efbfbd22efbfbdefbfbd62efbfbdefbfbd38efbfbd31efbfbdefbfbdefbfbdefbfbd5accaaefbfbdefbfbd75efbfbdefbfbdefbfbd1e4fefbfbdefbfbdefbfbd72efbfbdefbfbd3a69efbfbd4c26efbfbd3c4f14efbfbd38efbfbd717272efbfbd46efbfbd21efbfbdefbfbd22441cc7a8542aefbfbdefbfbdefbfbdefbfbdefbfbd03efbfbd0945efbfbdefbfbd19400befbfbdefbfbdefbfbdefbfbd2eefbfbdd180efbfbd472eefbfbd0eefbfbdefbfbd7cefbfbdefbfbd755d09efbfbd3aefbfbd6eefbfbdefbfbd59efbfbd65efbfbd42efbfbd3aefbfbdefbfbd0aefbfbdefbfbd18efbfbd5c2eefbfbdd1a347efbfbdefbfbdefbfbd6f301aefbfbd60efbfbdefbfbd244befbfbdefbfbdefbfbdefbfbd3defbfbd69efbfbdefbfbd623aefbfbd0a064f2613efbfbdefbfbdefbfbdefbfbd34efbfbd1eefbfbdefbfbdefbfbd4b7c36efbfbd20efbfbd690a37673eefbfbdefbfbd090defbfbdefbfbd1defbfbd2146efbfbdefbfbdefbfbd172aefbfbdefbfbdefbfbdefbfbd66332c160befbfbd6a26efbfbdefbfbd522952efbfbd6c5aefbfbd49efbfbd313fefbfbd48efbfbd12efbfbdefbfbd46efbfbd05efbfbdefbfbd267aefbfbd1eefbfbdefbfbd21efbfbdefbfbd295cefbfbd15efbfbdefbfbdefbfbdefbfbd10efbfbdefbfbdefbfbdefbfbd3326564cefbfbd3defbfbd1376efbfbdefbfbdefbfbdefbfbdefbfbd4ddea6efbfbd480643efbfbd653eefbfbd0b34efbfbd6633efbfbdefbfbdefbfbdefbfbdefbfbd03efbfbd11efbfbd5cefbfbd60efbfbdefbfbd2a2e2f2f25efbfbd58575fefbfbd467ddca6efbfbdefbfbdefbfbdefbfbd61efbfbdefbfbdefbfbdefbfbd79efbfbdefbfbdefbfbd6211efbfbd4a05efbfbdefbfbd04efbfbdefbfbdefbfbdefbfbd3c542a151c1c1c48efbfbdefbfbdefbfbd7f7d7defbfbdefbfbd4fefbfbd22efbfbdefbfbdefbfbdefbfbdefbfbd18efbfbdefbfbd104110efbfbdefbfbdefbfbd07efbfbdefbfbd4befbfbdefbfbd5aefbfbdefbfbdefbfbdefbfbdefbfbdefbfbdefbfbdefbfbdefbfbd41efbfbd091077efbfbd643241efbfbd5e471445efbfbd4fefbfbdefbfbd7d59efbfbd300cefbfbd09efbfbdccb65eefbfbd4b3cefbfbd6aefbfbd26efbfbdd8a56129efbfbd11efbfbd6343efbfbd603040efbfbdefbfbd14457236efbfbdefbfbdce9d3b28140a08efbfbd10efbfbdefbfbdefbfbd755defbfbd6aefbfbd30efbfbdefbfbdefbfbdebafbfefbfbdefbfbdefbfbdefbfbd1145110aefbfbd02efbfbdefbfbdefbfbd311eefbfbdefbfbdefbfbdefbfbdefbfbdefbfbdefbfbdefbfbd47efbfbd3fefbfbd2417efbfbdefbfbd5c57efbfbdefbfbd37efbfbd4c2eefbfbdefbfbd79efbfbd6a18537aefbfbdefbfbd504a16efbfbd6defbfbd5eefbfbd01efbfbdefbfbd3b180cefbfbd24092aefbfbd0a3cefbfbdefbfbdefbfbdefbfbdefbfbdefbfbd27efbfbdefbfbdefbfbd6defbfbd36efbfbd64efbfbdefbfbd39efbfbd603040efbfbdefbfbd401445efbfbdefbfbd780946d8bdefbfbdefbfbd76e1baae042a00efbfbdefbfbd7a78efbfbdefbfbd050cefbfbd40efbfbd56efbfbdefbfbd5befbfbdd5b0582c4452efbfbdefbfbd6a46efbfbd1e197a09efbfbd135f433862efbfbdefbfbdefbfbdefbfbdefbfbdefbfbdefbfbd52efbfbdefbfbd1e63efbfbd264aefbfbdefbfbd047eefbfbdefbfbdefbfbdefbfbd56efbfbd616f6f6f6370efbfbdefbfbd793aefbfbd303eefbfbd78efbfbd3f3eefbfbdefbfbdefbfbdefbfbd7d78efbfbdefbfbdefbfbd64220fefbfbd072f140a12646f6e6eefbfbdefbfbdefbfbdefbfbd016cefbfbdefbfbd703814efbfbd351a0d3136efbfbd58595befbfbd0befbfbdefbfbd3056efbfbd18efbfbdefbfbd30efbfbdefbfbdefbfbdefbfbd6422efbfbd17cd9c5847efbfbdefbfbdefbfbdefbfbd542eefbfbd114511efbfbdddae28efbfbdefbfbd31efbfbdefbfbd2eefbfbd55efbfbdefbfbd69efbfbd7eefbfbd58efbfbdefbfbd542aefbfbdefbfbdefbfbd7ddf976defbfbd3428efbfbdefbfbd5c1445efbfbdefbfbdefbfbdefbfbdefbfbdefbfbdefbfbd2befbfbd0d082fefbfbd04efbfbdefbfbd51efbfbd56efbfbd066aefbfbdefbfbd090eefbfbd03263fefbfbd5209efbfbd42e1b582efbfbdefbfbdefbfbd52efbfbdefbfbdefbfbdefbfbd4876143f4f332aefbfbd1616efbfbd1defbfbd41efbfbd54efbfbd611818efbfbdefbfbd304d53efbfbd3e4d157769efbfbdefbfbd34efbfbdefbfbd4a6c5b2c163f64efbfbd14c9985eefbfbdefbfbd09261befbfbdefbfbdefbfbdefbfbdefbfbdefbfbdc8adefbfbdefbfbdefbfbd0512efbfbd2441efbfbdefbfbd5defbfbdefbfbd613aefbfbdefbfbdefbfbd5028087befbfbd71efbfbdefbfbd3966efbfbd19efbfbdefbfbdefbfbd146000086c542a153c7cefbfbd100f1f3e140defbfbd06efbfbdefbfbd18efbfbdefbfbd08efbfbdefbfbdefbfbdefbfbd743aefbfbd1eefbfbdefbfbdefbfbd304a3d675d5bcaba5e21efbfbdefbfbdd28befbfbdefbfbdefbfbd596aefbfbd45efbfbdefbfbdefbfbd14efbfbd25dbb6450fefbfbdefbfbdefbfbdefbfbddfac52693defbfbdefbfbd6eefbfbd542a613018efbfbdefbfbdefbfbdefbfbd326aefbfbd1aefbfbd3c79efbfbd0417efbfbd41efbfbd0b4110efbfbd2eefbfbd34efbfbd06efbfbd5047efbfbd314d13efbfbd1e3defbfbdcb972fefbfbdefbfbdefbfbd441c63efbfbd605916efbfbdefbfbd22efbfbdd5aa7078efbfbdefbfbdefbfbd70efbfbdefbfbdefbfbd6b1c1d1defbfbdefbfbd73efbfbd52efbfbd3a2cdfa6efbfbdefbfbd383d3d15efbfbd31c89121efbfbd2101efbfbd5aefbfbdefbfbd71efbfbdefbfbd04efbfbdefbfbd1fefbfbdefbfbd1213efbfbdefbfbd38efbfbdefbfbdefbfbdefbfbd33efbfbdefbfbdefbfbd7befbfbdefbfbd6a4b49efbfbd4eefbfbd0947efbfbd08efbfbdefbfbd66efbfbd2946efbfbd6722c4a07d7979efbfbd72efbfbdefbfbd77efbfbd7d17efbfbd560befbfbd6211efbfbd5a0defbfbd5a0defbfbd5249efbfbd21efbfbd201036435e6f18efbfbd34406defbfbdefbfbdefbfbd12efbfbd5679efbfbd2e0368efbfbd61efbfbdefbfbdefbfbd3278efbfbdefbfbd220c43efbfbdefbfbdefbfbdefbfbdefbfbd4c54efbfbdefbfbd707676efbfbdefbfbd4fefbfbdefbfbdefbfbd7defbfbdefbfbd65efbfbdefbfbdefbfbd6251efbfbdefbfbdefbfbdefbfbd43efbfbdefbfbdefbfbdefbfbdefbfbdefbfbdefbfbd5aefbfbd4a254befbfbdefbfbd53efbfbdefbfbdefbfbd5838efbfbdefbfbd6934efbfbdefbfbdefbfbdefbfbd38efbfbd31efbfbd4c24583aefbfbdefbfbdefbfbdefbfbd7a0befbfbd7e1f17171718efbfbdefbfbd5237efbfbdefbfbd6a383939110645efbfbd2a140aefbfbd542a4b5aefbfbdefbfbd446aefbfbdefbfbdefbfbdefbfbd33efbfbd39efbfbd47efbfbd5c7903efbfbd65efbfbdefbfbd3cefbfbd7aefbfbd0aefbfbdefbfbdefbfbdd289757373efbfbd62efbfbdefbfbdefbfbdefbfbd33efbfbdefbfbd0f1e3cefbfbd62efbfbdefbfbdefbfbdefbfbd0506efbfbd01efbfbdc5a204efbfbdefbfbd62efbfbd3b77efbfbdefbfbdefbfbdefbfbd18efbfbdefbfbdefbfbd78efbfbdefbfbd19efbfbdd3a9144defbfbd09efbfbd66123e284d137befbfbdefbfbd337fefbfbd67efbfbd71efbfbdefbfbd742a41733018efbfbdefbfbdefbfbd04474747efbfbdefbfbd660020efbfbd13efbfbdefbfbd783cefbfbd07efbfbd542a383c3c5cefbfbd5b59efbfbdefbfbdefbfbdefbfbdefbfbd3e5d63efbfbdefbfbd5cefbfbdefbfbd4cefbfbd53efbfbdefbfbd6defbfbd7aefbfbd0a4110efbfbdefbfbd6befbfbdefbfbd68efbfbdefbfbd1f3f16efbfbdefbfbd6c36efbfbdefbfbdefbfbd5fefbfbd7b5dd7856559efbfbdefbfbdefbfbdefbfbdefbfbdefbfbd294aefbfbd12efbfbd3c7922efbfbd7156dd91efbfbdd6aa253357066a62efbfbd16efbfbd7cefbfbdefbfbd743aefbfbdefbfbdefbfbd093aefbfbd0e06efbfbd010cefbfbdefbfbdefbfbdefbfbd115851330c03efbfbdefbfbdefbfbdefbfbd55efbfbdefbfbdc5a2efbfbdefbfbddbb4efbfbd6defbfbdefbfbdefbfbd7ace95efbfbd683018efbfbdefbfbdefbfbd1c61180aefbfbdefbfbd76775d17efbfbdefbfbd18efbfbdefbfbd1047474762efbfbd5fefbfbdefbfbd57efbfbdefbfbdefbfbd2f50efbfbd56efbfbdefbfbddcbd7b17efbfbd42410a13efbfbd4a45f09bb1840befbfbdefbfbd5a4a09efbfbd15efbfbd6d4befbfbdefbfbdefbfbd1c3eefbfbd7c3eefbfbdefbfbdefbfbd35efbfbdefbfbdefbfbd50efbfbd54707979efbfbd76efbfbdefbfbdefbfbdefbfbdefbfbd1eefbfbdefbfbdefbfbd68efbfbd5a28efbfbdefbfbd180eefbfbdefbfbd79efbfbd2f2aefbfbdefbfbdefbfbdefbfbdefbfbdefbfbdefbfbdefbfbd7a48c592efbfbdefbfbdefbfbdefbfbd6cefbfbd52efbfbdefbfbdefbfbd05c69fefbfbdefbfbdefbfbdefbfbd68efbfbd62efbfbdefbfbd56efbfbd25efbfbd4defbfbd52efbfbdefbfbdefbfbd12236cefbfbd46efbfbdefbfbdc48b172f10efbfbd314aefbfbdefbfbd085a5aefbfbdefbfbdefbfbd694c6715efbfbd3defbfbdefbfbdefbfbd54efbfbd79efbfbd31373737efbfbdefbfbdefbfbdefbfbd10efbfbd21efbfbdefbfbdefbfbd502eefbfbdefbfbdefbfbd575fefbfbdefbfbd2fefbfbdefbfbdefbfbdefbfbdefbfbdefbfbdefbfbdefbfbd3969efbfbdefbfbdefbfbd74efbfbd1fd3b8efbfbdefbfbd1e6fdebb77efbfbdefbfbd172f5e60301848606427163fefbfbd184b012defbfbdefbfbdefbfbdefbfbd3cefbfbdefbfbdefbfbd6a15efbfbdefbfbdefbfbdefbfbdefbfbd5aefbfbdefbfbd5028efbfbdefbfbd2cefbfbdefbfbd6defbfbd724d41092defbfbd17efbfbd0306efbfbd62efbfbd28cdb1efbfbdefbfbd7449efbfbd24efbfbd67c98f491a2b687aefbfbd21efbfbd7befbfbd055957efbfbdefbfbd7534330befbfbd37efbfbd2c59efbfbdefbfbd10efbfbd7e5fefbfbd0defbfbdefbfbd72efbfbdefbfbd7eefbfbd0fefbfbdefbfbd30efbfbdcfa52042efbfbdefbfbd61efbfbd6aefbfbdefbfbd5eefbfbd07efbfbd7150efbfbd5645efbfbdefbfbdefbfbd592aefbfbdefbfbd5fefbfbd784e6d256bda9a41efbfbdefbfbd34efbfbd4c24efbfbd532208efbfbd403a09345c51efbfbd27efbfbd624dd8b6efbfbd25efbfbd7eefbfbdefbfbdefbfbd6d76efbfbdefbfbdefbfbdefbfbd5aefbfbdefbfbdefbfbdefbfbdefbfbd711c0441efbfbd52efbfbdefbfbd7eefbfbdefbfbd62efbfbd282cefbfbdefbfbdefbfbdefbfbd64220363efbfbd1e6a23efbfbdefbfbdefbfbdefbfbd69efbfbdefbfbdefbfbdd381efbfbd653d1aefbfbd1cefbfbdefbfbdefbfbd344defbfbdefbfbd2f7d37efbfbdefbfbd14efbfbd65613aefbfbdefbfbd5eefbfbdefbfbd6713165917efbfbd5e4fefbfbd22efbfbdefbfbd66efbfbd7153efbfbdefbfbdefbfbd7c2f0018efbfbd5e496f6316efbfbdefbfbd5e1cefbfbd383838efbfbd66efbfbd62efbfbd28dc9e3cefbfbdefbfbdefbfbd0255efbfbd567b2defbfbd523cefbfbd3a09efbfbd49efbfbd7c3e175d45efbfbd4befbfbdefbfbd755eefbfbd7600efbfbdefbfbd6fefbfbdefbfbd52efbfbdefbfbdefbfbd7028efbfbdefbfbdefbfbdefbfbd7d3aefbfbdefbfbd5443efbfbd3b203d26efbfbd0befbfbd69caa9efbfbdc8acefbfbd252defbfbd65efbfbdefbfbd06efbfbd54efbfbd30efbfbdd38b2fefbfbdefbfbd6cefbfbd5a38383810efbfbd6549efbfbd4c21efbfbd635c5e5e6232efbfbdefbfbdefbfbd68efbfbd435166efbfbd444c4f4d0f2068efbfbdefbfbd5defbfbddfb1efbfbdefbfbdefbfbd482862264d6718efbfbd46efbfbd6f2e1035efbfbd5c2e27cc8aefbfbdefbfbdefbfbd1eefbfbdefbfbd633066efbfbdefbfbd1a2befbfbd031259efbfbdefbfbd26efbfbdd3a856efbfbd383d3d15efbfbdefbfbd212eefbfbd0fefbfbd71707878efbfbdefbfbdefbfbd7defbfbdefbfbdefbfbdefbfbd63efbfbdefbfbd73efbfbd5a2defbfbdefbfbd493b1befbfbdefbfbd2c4418efbfbdefbfbdefbfbd6a78efbfbdefbfbd314aefbfbdefbfbd781c55446d64efbfbd0d0cefbfbd4cefbfbdefbfbdd5a621efbfbdefbfbdcbb66d69efbfbd653eefbfbdefbfbd3366efbfbdefbfbdc2996133efbfbd6befbfbdefbfbdefbfbd6677023befbfbd571defbfbdefbfbd4968efbfbd5a002b4912341a0d74efbfbd5defbfbd4623697966efbfbdefbfbdefbfbd79383e3eefbfbd604a01efbfbd50efbfbd6aefbfbdefbfbdefbfbdefbfbdefbfbdefbfbd302832710aefbfbd007b7b7befbfbdefbfbd185757576071efbfbd030d69efbfbdefbfbd0fefbfbdefbfbdefbfbd684fefbfbdefbfbdefbfbdefbfbd7dd8b6efbfbd46efbfbd21efbfbdefbfbd5c54efbfbd0eefbfbd6c15172f0802c99075efbfbd360d21efbfbd1defbfbdcb9aefbfbdefbfbd53efbfbd26efbfbd02efbfbd45efbfbd63efbfbdefbfbd5ee9baae14efbfbd75efbfbdefbfbdefbfbdefbfbd68efbfbdefbfbdefbfbd76efbfbdefbfbdefbfbd7a68341a3202efbfbd6834707979efbfbd7c3e2f4cefbfbdefbfbdefbfbd025114efbfbdefbfbd37efbfbdefbfbd7038efbfbd70387c6d38efbfbd374c15efbfbd5045efbfbd61efbfbd2aefbfbd50efbfbd1f6a4defbfbd7cefbfbdefbfbd5049efbfbdefbfbdefbfbd21efbfbd19efbfbdefbfbdefbfbd7e5bc68626efbfbdefbfbdefbfbdefbfbdefbfbdefbfbd5cefbfbd58efbfbd7bd4a22013efbfbd55efbfbd742befbfbdefbfbdefbfbdefbfbdefbfbd64efbfbd7befbfbdefbfbdefbfbd582c62381cefbfbd542a0937efbfbd56efbfbdefbfbdefbfbd2907efbfbdefbfbdefbfbdefbfbd1c4befbfbd3cefbfbdefbfbd311aefbfbdefbfbdefbfbdefbfbdefbfbd653defbfbdefbfbd1013efbfbdefbfbd70efbfbd5aefbfbdefbfbd0e46efbfbdefbfbd752befbfbdefbfbd1e334d13efbfbd7e5fefbfbd3960354c77efbfbd51efbfbd65efbfbd79efbfbdefbfbdefbfbd71efbfbdefbfbd7d59efbfbdefbfbd60efbfbdefbfbdefbfbdefbfbd0acf9e3d43efbfbdd793462eefbfbd29efbfbdefbfbdefbfbd481a08efbfbdefbfbdefbfbd0e16efbfbd05efbfbd47efbfbd1e7defbfbd0a3fefbfbd6defbfbd4651efbfbdefbfbdefbfbd76efbfbd4e07efbfbdefbfbdefbfbd7f01400679efbfbdcda65047efbfbd74164c28414451efbfbdefbfbd68efbfbdefbfbdefbfbd2eefbfbd6fefbfbdefbfbd4fefbfbdefbfbdefbfbd261321efbfbdefbfbdc9a40900efbfbd3b1befbfbdefbfbd5061067defbfbd384e4f4fc591efbfbdefbfbdefbfbdefbfbdefbfbd74707c7cefbfbdefbfbdefbfbd23dcbb770fefbfbdefbfbdefbfbd47efbfbd565befbfbd37efbfbd5a3063efbfbdefbfbd0fefbfbd66efbfbd5273efbfbdefbfbd08efbfbdefbfbdefbfbdefbfbd2c11cb89efbfbd4cefbfbdefbfbd10373737efbfbd3c4f347bcbb2efbfbdefbfbdefbfbdefbfbd75efbfbdefbfbdefbfbdefbfbdefbfbd4aefbfbdefbfbd384745efbfbd4e7b7aefbfbd41347fefbfbdefbfbd1cefbfbdcdb254efbfbd582c30efbfbd4eefbfbdefbfbd60341049c29fefbfbdefbfbd27efbfbdefbfbdefbfbdefbfbdefbfbd7cefbfbdefbfbd25efbfbdefbfbd3a2cefbfbd42efbfbd5e47efbfbdefbfbd02efbfbd13efbfbdefbfbd04efbfbd4e07efbfbd7fefbfbd39efbfbdefbfbdefbfbd3b617074084defbfbd57efbfbdefbfbdefbfbdefbfbdefbfbd16efbfbd20efbfbdefbfbd311c0eefbfbd7defbfbdefbfbd5749efbfbd603c1eefbfbdefbfbdefbfbdefbfbdefbfbd28713eefbfbd0fefbfbd0321efbfbd06691d757056efbfbdefbfbdd3a9efbfbd68efbfbdefbfbdefbfbdefbfbdefbfbddda07b2cefbfbd2defbfbdefbfbd593aefbfbdefbfbdefbfbd0f62efbfbdefbfbdefbfbdefbfbdefbfbd6334efbfbd4defbfbd6a35efbfbdefbfbd654c2613efbfbdefbfbdefbfbd5b4befbfbd29efbfbdefbfbdefbfbd3d3d3defbfbdefbfbd79efbfbd7d5fefbfbd0534efbfbdefbfbd6cefbfbdcb972fefbfbdefbfbdefbfbdefbfbd022f77efbfbdefbfbd665d5d5defbfbdefbfbd2c191eefbfbd1125efbfbdefbfbd42efbfbd60efbfbd003418efbfbd3eefbfbd3fefbfbdefbfbdefbfbd1721efbfbd0befbfbd0b3aefbfbdefbfbd5aefbfbd26efbfbdefbfbdefbfbd6674efbfbdefbfbdefbfbd7f35efbfbdefbfbd6546524e0d07efbfbdefbfbdefbfbd5aefbfbd22efbfbdcfa3efbfbd6eefbfbdefbfbdefbfbd46efbfbdefbfbdefbfbd6cefbfbd0f3fefbfbd10efbfbd5209efbfbdefbfbdd7bf707070efbfbdefbfbdefbfbd13d183efbfbd793aefbfbdefbfbdefbfbd635c5c5cefbfbdd1a347efbfbdefbfbdefbfbdefbfbd1104013ccf93efbfbd73efbfbd35efbfbdefbfbd3c3eefbfbdefbfbd337cefbfbdefbfbdefbfbd1270d98fefbfbd3c423befbfbdefbfbd53efbfbdefbfbdefbfbd4bdea11302cd9befbfbdefbfbdefbfbd48efbfbd4cefbfbd74efbfbdefbfbd5defbfbd49efbfbdefbfbd583befbfbd17efbfbdefbfbdefbfbd62efbfbdefbfbd5031efbfbd62efbfbdefbfbd3e5c62efbfbd14061fefbfbdefbfbdefbfbd611832efbfbd737070efbfbd38efbfbd512eefbfbdefbfbdefbfbdefbfbdefbfbd5eefbfbd27efbfbd3e1f7eefbfbd21efbfbd38c6a7efbfbd7eefbfbd6aefbfbdefbfbd3fefbfbdefbfbdefbfbdefbfbdefbfbd69efbfbdefbfbdefbfbdefbfbdefbfbdefbfbd4aefbfbd22efbfbd2cefbfbdefbfbd0aefbfbdefbfbd4826efbfbdefbfbd02efbfbdefbfbdefbfbd3e5aefbfbd16efbfbdefbfbdefbfbdefbfbdefbfbdefbfbdefbfbd52efbfbd06efbfbd13100e694fefbfbd582cefbfbdefbfbdefbfbd78efbfbdefbfbd05efbfbd364befbfbdd2baefbfbd4e16efbfbd67efbfbd0819efbfbd6b0a67efbfbd7264261aefbfbdefbfbd39efbfbd36efbfbdefbfbd033a09efbfbd4b0e0f0f0512efbfbd18cb99efbfbdefbfbd78efbfbdefbfbdefbfbd7d34efbfbd4d2449efbfbdefbfbdefbfbd43efbfbd7cefbfbd12efbfbd7e1fefbfbd66730922efbfbdefbfbdefbfbdefbfbdefbfbd3cefbfbdefbfbdefbfbdefbfbd707171efbfbd0f3eefbfbd00efbfbdefbfbd49efbfbd0521efbfbd54efbfbdefbfbdefbfbd144fefbfbd3cefbfbd3fefbfbdefbfbd0f5c5d5d096cefbfbd5174efbfbdefbfbdefbfbd5314efbfbd3ac487efbfbdefbfbd48efbfbdefbfbdefbfbdefbfbd5fefbfbdefbfbd48efbfbdefbfbdefbfbdefbfbd22efbfbdefbfbd47efbfbdefbfbd54efbfbd3aefbfbd7a3430efbfbdefbfbd2eefbfbdefbfbd0912efbfbd04efbfbd2befbfbd755defbfbdefbfbdefbfbd71efbfbd5eefbfbd27efbfbd0221efbfbd74efbfbd5c2e6336efbfbdefbfbd56efbfbdefbfbddebd7b7236efbfbdefbfbd133a70efbfbdefbfbdefbfbd6834efbfbdefbfbd74707373efbfbdefbfbdefbfbd4b3c7defbfbd140f1e3cefbfbdefbfbd79efbfbdefbfbdefbfbd5aefbfbd257aefbfbdefbfbdefbfbd6fefbfbdefbfbd6aefbfbdefbfbd7fefbfbd3befbfbdefbfbdefbfbdefbfbdd79240616fefbfbdefbfbd303defbfbd1b04efbfbdefbfbdefbfbdefbfbdefbfbd57efbfbdefbfbdefbfbd1c30360b31efbfbdefbfbd6defbfbddc82dcb2efbfbd4cefbfbdd19aefbfbdeba6a7efbfbdefbfbd206befbfbd3cd8a2efbfbdefbfbd633c1eefbfbd5909efbfbdefbfbd54efbfbd55efbfbdefbfbd397f4befbfbd4d3b19efbfbdefbfbdefbfbdcd8d5c633c1e0befbfbdefbfbdefbfbd6dd98d5a00efbfbdefbfbd51256defbfbd5aefbfbdefbfbdefbfbd7fefbfbdefbfbdefbfbd7f5fefbfbdefbfbdefbfbd190cefbfbd6a56efbfbdefbfbd1e45efbfbd1cefbfbdefbfbd05335a58efbfbd3622efbfbdefbfbd0eefbfbd3220efbfbd100d401defbfbd036defbfbdefbfbdefbfbd08efbfbdefbfbd1a3d4c40efbfbdefbfbd76efbfbd725defbfbd790a686c47efbfbdefbfbd412fefbfbd56efbfbd522e2454efbfbd674fefbfbd440eefbfbd200d25efbfbd5337efbfbddeafefbfbd047a76efbfbdefbfbdefbfbd471f7d04efbfbdefbfbdefbfbdefbfbd67efbfbd49efbfbd23efbfbd676829205defbfbd23efbfbd6526efbfbdefbfbdefbfbdefbfbdefbfbd61706524efbfbdefbfbdefbfbd5a7843efbfbdefbfbd3cd887efbfbdd5aa631869642aefbfbdefbfbd4befbfbdd3a928efbfbd5a45efbfbdefbfbd29257012efbfbdefbfbd35efbfbd4643efbfbd0cefbfbdefbfbdefbfbd5a511461381c4a5eefbfbd1551da80efbfbdefbfbdefbfbdefbfbd3672efbfbd0555efbfbd5fefbfbdefbfbdefbfbdefbfbdefbfbd6f7f2befbfbd4448efbfbdefbfbdefbfbdefbfbdefbfbdefbfbddcb2efbfbd06efbfbd1befbfbd01121a2befbfbd59efbfbdefbfbdefbfbd16efbfbdefbfbd31efbfbdc794efbfbdefbfbd59efbfbd7a1defbfbd7259efbfbd5b3757efbfbd6563efbfbd65efbfbdefbfbdefbfbd072e7e2eefbfbdefbfbd783cefbfbd6b3aefbfbd23efbfbd69efbfbd264e4e4e1004013aefbfbdefbfbdefbfbd24c9ae780c4cefbfbd5643efbfbdd994efbfbd21420f771619efbfbd4e143533efbfbd0e6577efbfbdefbfbd1f7fefbfbd56efbfbd25efbfbdefbfbdefbfbd6eefbfbdefbfbd01efbfbd1defbfbd590210efbfbdefbfbdefbfbdefbfbd60efbfbdefbfbdefbfbd3640efbfbd4d753f0b770639efbfbd662fefbfbd17efbfbd0765efbfbdefbfbdefbfbdefbfbdd68a263befbfbdefbfbd243cefbfbd413b46efbfbdd984ebbab8efbfbdefbfbdefbfbdefbfbd310802efbfbd78efbfbd42123a0078efbfbdefbfbd1906efbfbdefbfbd684eefbfbd5eefbfbd5aefbfbdefbfbd0aefbfbd04781f2cefbfbdefbfbd19efbfbd471c1f1fefbfbd77efbfbdefbfbdefbfbd18efbfbd587506591cefbfbdefbfbd7d5f340f3defbfbd41efbfbd4a2736efbfbdefbfbd3defbfbd4309efbfbd79efbfbdefbfbdefbfbd7906ce9d3b77efbfbdd89aefbfbd68195807efbfbd55efbfbd675062203653efbfbd2229efbfbdefbfbd18efbfbd7a1defbfbd6211efbfbd765b1a640963efbfbd690a2b1befbfbdefbfbd42610108efbfbdefbfbdefbfbdefbfbd2010efbfbdefbfbdefbfbdefbfbdddaf473eefbfbd28efbfbdefbfbdefbfbd293eefbfbdefbfbd23efbfbdefbfbdefbfbdefbfbdefbfbd49efbfbdda93291130efbfbdefbfbdefbfbdefbfbdefbfbd61efbfbd18690fefbfbd61346322efbfbd50416476efbfbdefbfbdefbfbd7aefbfbdefbfbd5aefbfbdefbfbd44efbfbdefbfbdefbfbd03efbfbd621aefbfbd3aefbfbd7f44d3b1efbfbdefbfbd11efbfbd1dd0b66d49efbfbd2befbfbdefbfbdefbfbd61efbfbdefbfbdefbfbd5818dbb6efbfbdefbfbdefbfbd62efbfbd28efbfbdefbfbd62113befbfbdefbfbdefbfbdefbfbd01efbfbd53efac8201efbfbdefbfbdefbfbd193eefbfbdefbfbdefbfbd1f303eefbfbd484fefbfbdefbfbd2e54efbfbd0f49487befbfbdefbfbdefbfbdefbfbdefbfbdefbfbdefbfbd0d3c52efbfbd4cefbfbdddbe77efbfbddc91efbfbdefbfbdefbfbdefbfbdefbfbdefbfbd7f6b38efbfbd7d33efbfbd1d6b7acba0efbfbd25621667782f34360d4fefbfbdefbfbdefbfbdefbfbdefbfbdefbfbd711ccb996aefbfbd35efbfbdefbfbd48efbfbd4defbfbd7cefbfbd13efbfbd33efbfbdefbfbdefbfbdefbfbdefbfbdefbfbd1f0cefbfbdefbfbd161eefbfbd43efbfbdefbfbd3aefbfbdefbfbdefbfbdefbfbd0cefbfbdefbfbd54efbfbdefbfbd3543efbfbdefbfbd740702efbfbdefbfbd4c262247efbfbd71efbfbdefbfbdefbfbd63efbfbd14c89a2befbfbdefbfbdefbfbdefbfbd16efbfbd540929efbfbd6e0befbfbdefbfbdddbf7f1fefbfbdefbfbd04efbfbd7eefbfbd2946efbfbdefbfbdefbfbdefbfbdefbfbd0befbfbd7adc93efbfbd480cefbfbd21efbfbdefbfbdefbfbdefbfbd4defbfbdefbfbdefbfbdefbfbd2133d4a221efbfbdc2963ecb914cefbfbd27efbfbd694eefbfbdefbfbdefbfbdefbfbd3a0d4f736f1defbfbd74efbfbdefbfbd15efbfbd42efbfbd20efbfbd0fefbfbdefbfbdefbfbd79383b3b133defbfbd50efbfbdefbfbdefbfbdefbfbd2aefbfbdefbfbd0c7532efbfbd7729efbfbd442fefbfbdefbfbdefbfbd01efbfbdefbfbdefbfbd707171efbfbdefbfbdefbfbdefbfbdefbfbdefbfbd7befbfbdefbfbdefbfbd7573012defbfbd42efbfbddf97efbfbd42efbfbd10efbfbdefbfbd4466efbfbd78efbfbdefbfbd4eefbfbdefbfbdefbfbdefbfbd3823efbfbd50efbfbdefbfbdefbfbd3a4b1fefbfbdefbfbdefbfbd02efbfbdefbfbd0eefbfbd59584a582035efbfbdefbfbd19efbfbdefbfbd093e3831efbfbd54efbfbdefbfbdefbfbd0cefbfbd3cefbfbdefbfbdebafbf5eefbfbdefbfbd2cefbfbd353dd896efbfbd61efbfbdefbfbd48efbfbd23efbfbd1fefbfbd45efbfbd2cc4b66d3c79efbfbd04efbfbdefbfbdd7b2efbfbdefbfbdefbfbd72efbfbdefbfbdd4a159efbfbd646d77341a49efbfbd6d3aefbfbd62301808efbfbdefbfbd3befbfbd0773d081efbfbdefbfbd36efbfbdefbfbdefbfbd11efbfbdefbfbd0fefbfbd6e46634aefbfbd3aefbfbdefbfbdefbfbdefbfbd20efbfbdefbfbdefbfbdefbfbdefbfbdefbfbdefbfbdefbfbd3d543fefbfbd3eefbfbdefbfbdefbfbd45efbfbd4f03debd7b1749efbfbdefbfbdefbfbdd3a7efbfbdefbfbd717a37efbfbd231019d0b4efbfbd4106efbfbdefbfbd3befbfbd606f6f0f4110c880efbfbdefbfbdefbfbdefbfbd0471efbfbd29efbfbdefbfbdefbfbdefbfbdefbfbdefbfbdefbfbd54efbfbd18781defbfbdefbfbd743aefbfbdefbfbdefbfbdefbfbdefbfbd5defbfbdefbfbd59efbfbd2aefbfbdefbfbd10efbfbdefbfbde78c86141358efbfbdefbfbd151eefbfbd18efbfbd40efbfbdefbfbd03efbfbdefbfbd58efbfbd22efbfbdd2b42f6bcc864909771aefbfbdefbfbd28efbfbdefbfbdefbfbdefbfbdefbfbdefbfbd37efbfbd5c620a69efbfbdefbfbdefbfbd48efbfbd6defbfbdc48d72c5a347efbfbdefbfbdefbfbdefbfbd2451efbfbd6d297669efbfbd3eefbfbd754639efbfbdefbfbd4e68efbfbd0a4a464678efbfbd60076b17efbfbd6e573eefbfbd3359efbfbd1b062b2aefbfbdefbfbd48efbfbdefbfbd43efbfbdefbfbd13efbfbdefbfbd4defbfbd601eefbfbdefbfbd442f49efbfbdefbfbdefbfbdefbfbd1aefbfbd58efbfbd19efbfbd6e44efbfbd56efbfbdefbfbd7befbfbd2eefbfbd7befbfbdefbfbd15efbfbdefbfbd0000023449444154efbfbd25efbfbdefbfbd0b416fefbfbd01175c1cefbfbd2defbfbdefbfbd3c7eefbfbdefbfbdefbfbdefbfbd5aefbfbdefbfbdefbfbdefbfbd0aefbfbd7c1e5f7cefbfbd05efbfbd28efbfbdefbfbdefbfbdefbfbdefbfbd6543efbfbd252fefbfbd27efbfbd60537defbfbd26efbfbd2259efbfbdefbfbd7c41efbfbdefbfbdefbfbd66efbfbdefbfbd7aefbfbd2a4361efbfbd532cefbfbd6befbfbd66efbfbd1fefbfbd0c5869efbfbd00efbfbd0560efbfbd1cefbfbd1c3cefbfbdefbfbd1eefbfbd3d383defbfbdefbfbdefbfbdefbfbd3eefbfbd23efbfbdefbfbd5a032214efbfbd54681806efbfbd7befbfbd3d39cc8d31efbfbd72efbfbdefbfbdefbfbdefbfbdefbfbd20efbfbdefbfbdefbfbd6f7eefbfbdefbfbd0f1f2e1defbfbd42efbfbd3eefbfbdefbfbd49efbfbd0f61300c43efbfbdefbfbd2565efbfbdefbfbd167327e8a48befbfbd75efbfbdefbfbd6432597a16daa3efbfbdefbfbdefbfbdefbfbdefbfbd30efbfbdefbfbdefbfbd1206277defbfbdefbfbdefbfbd1defbfbdefbfbd6a5661efbfbdefbfbdefbfbdefbfbdefbfbd68efbfbd5c53d4b4d4abefbfbd5f3d3befbfbd20494d5cefbfbdefbfbdefbfbd61efbfbdefbfbd3fefbfbd393aefbfbd0eefbfbdefbfbdefbfbdeba5a97106674acdbcefbfbdefbfbdc78fefbfbdefbfbd5fefbfbd0249efbfbdefbfbdefbfbdc3873218efbfbdefbfbd002befbfbdefbfbd1c25efbfbdefbfbd05efbfbd65efbfbdefbfbd09efbfbdefbfbd477d38124befbfbd5424efbfbd13714aefbfbdefbfbd7d6924efbfbdefbfbd502eefbfbdefbfbd4155efbfbd01efbfbd35efbfbdefbfbdefbfbdefbfbde8809124efbfbd6cefbfbdefbfbd7028efbfbdefbfbdefbfbd7928efbfbdefbfbd4b5defbfbdefbfbdefbfbdefbfbdefbfbd7befbfbd32efbfbd4fefbfbd26efbfbd6a353308021c1c1cefbfbd755defbfbdefbfbdefbfbdefbfbdefbfbdefbfbdefbfbdefbfbd68efbfbdefbfbdefbfbd79efbfbd71efbfbdefbfbd3fefbfbd197fefbfbdefbfbd1f64efbfbdefbfbdefbfbd685916efbfbdefbfbd31efbfbdefbfbd2e4aefbfbd12efbfbdefbfbd262aefbfbd0a06efbfbdefbfbd380befbfbdefbfbdefbfbd43efbfbdefbfbdefbfbdefbfbdc3a1efbfbdefbfbdefbfbdefbfbd64efbfbd00efbfbd08efbfbd36efbfbdd3a9efbfbd226118efbfbdefbfbdefbfbdefbfbdefbfbd1cefbfbdefbfbdefbfbdc79f30efbfbd4eefbfbd53efbfbd7a3defbfbdefbfbd59efbfbdefbfbd6a5c66efbfbd27deb3efbfbd51efbfbdefbfbdefbfbdefbfbd566978c99aefbfbdefbfbd35efbfbdefbfbdefbfbd52efbfbd06655a16efbfbdefbfbd51640eefbfbd4b1f7defbfbd11efbfbdefbfbdefbfbdefbfbdefbfbdefbfbd2defbfbd42efbfbdefbfbd593a2fefbfbdefbfbd55efbfbd5464efbfbd4e67efbfbd2416efbfbd066703efbfbd23482775efbfbd1a3befbfbd191f18efbfbdefbfbdefbfbdefbfbdefbfbd6c1defbfbdefbfbdefbfbd01efbfbd2aefbfbd0a40efbfbd3eefbfbd0000000049454e44efbfbd4260efbfbd),
(5, 'Dionisio', 'Estevez', 'destevez@telecomnetworks.net', '090044f12add642ff61f4700a1bdd32c', 4, '2013-08-20 18:28:20', 1, NULL, NULL),
(6, 'Omar', 'Collado', 'ocallado@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:31:30', 1, NULL, NULL),
(7, 'Leonel', 'Jimenez', 'ljimenez@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:37:30', 1, NULL, NULL),
(9, 'Loryan', 'Lozano', 'llozano@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:27:22', 1, NULL, NULL),
(10, 'Saul', 'Nuñez', 'snunez@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:34:58', 1, NULL, NULL),
(11, 'James', 'Polanco', 'jpolanco@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-20 18:32:05', 1, NULL, NULL),
(12, 'Venny', 'Rodriguez', 'vrodriguez@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:36:04', 1, NULL, NULL),
(14, 'Juan', 'Cortacio', 'jcortacio@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-20 18:30:24', 1, NULL, NULL),
(16, 'Alejandro', 'Gadea', 'agadea@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-09-26 19:17:04', 1, '1222', NULL),
(18, 'Micaela', 'Melgar', 'spuentes@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:30:26', 1, NULL, NULL),
(19, 'Ismael', 'Madera Guillen', 'iguillen@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-20 18:31:49', 1, NULL, NULL),
(20, 'Lautaro', 'Carbajal', 'juanbarla@gmail.com', 'f77538d26d37221483971c3323d5f050', 4, '2013-08-21 08:23:22', 1, '1686', NULL),
(21, 'Rodrigo', 'Beltran', 'fbonilla@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:34:28', 1, NULL, NULL),
(22, 'Daniel', 'Tomikian', 'rinoa@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-20 18:25:55', 1, NULL, NULL),
(23, 'Roberto', 'Garcia', 'rgarcia@telecomnetworks.net', 'f77538d26d37221483971c3323d5f050', 4, '2013-08-21 08:33:52', 1, NULL, NULL),
(24, 'Flora', 'Berton', 'fberton@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-20 18:29:39', 1, NULL, NULL),
(25, 'Maria Alejandra', 'Provenzza', 'mprovenzza@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:28:22', 1, NULL, NULL),
(26, 'Mario', 'Tornelli', 'mtornelli@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:30:01', 1, NULL, NULL),
(27, 'Jonny', 'Fernandez', 'jfernandez@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:18:54', 1, NULL, NULL),
(28, 'Raul', 'Alravez', 'mgonzalez@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:33:01', 1, NULL, NULL),
(29, 'Erika', 'Herfurth', 'ygonzalez@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-20 18:28:50', 1, NULL, NULL),
(30, 'Solanyis', 'Fernandez', 'sfernandez@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:35:22', 1, NULL, NULL),
(31, 'Yazmin', 'Tavarez', 'ytavarez@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:37:09', 1, NULL, NULL),
(32, 'Jonathan', 'Fernandez', 'jofernandez@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-20 18:32:41', 1, NULL, NULL),
(34, 'Robinson', 'Madera', 'rmadera@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:34:09', 1, NULL, NULL),
(35, 'Christian', 'Vera', 'cvera@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-20 18:25:28', 1, NULL, NULL),
(36, 'Cesar', 'Madera', 'cmadera@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-20 18:24:45', 1, NULL, NULL),
(37, 'Juan Ramon', 'Peña', 'jpena@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:22:44', 1, NULL, NULL),
(38, 'Luis', 'Bonilla', 'lbonilla@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:27:38', 1, NULL, NULL),
(39, 'Chantelle', 'Baez', 'cbaez@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-20 18:24:57', 1, NULL, NULL),
(40, 'Juan', 'Hernandez', 'jhernandez@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:20:52', 1, NULL, NULL),
(41, 'Lendy', 'Lopez', 'llopez@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:26:06', 1, NULL, NULL),
(42, 'Christian', 'Jimenez', 'cjimenez@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-20 18:25:19', 1, NULL, NULL),
(43, 'Ramon', 'Bueno', 'rbueno@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:32:09', 1, NULL, NULL),
(45, 'Valentina', 'Alpuin ', 'valpuin@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:35:39', 1, NULL, NULL),
(46, 'Ines', 'Rodriguez', 'irodriguez@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-20 18:31:31', 1, NULL, NULL),
(47, 'Natalia', 'Lorda', 'sblanco@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:31:15', 1, NULL, NULL),
(48, 'Pavel', 'Mulet', 'pmulet@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:31:56', 1, NULL, NULL),
(49, 'Aldonza', 'Azcona', 'aazcona@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2014-01-02 18:05:14', 1, NULL, NULL),
(50, 'Wilber', 'Mercedes', 'wmercedes@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:37:47', 1, NULL, NULL),
(51, 'Herby', 'Romulus', 'hromulus@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-20 18:31:03', 1, NULL, NULL),
(62, 'Ruben', 'Ventura', 'rventura@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:34:43', 1, NULL, NULL),
(63, 'Roberto', 'Alvarez', 'roalvarez@telecomnetworks.net', 'f8032d5cae3de20fcec887f395ec9a6a', 4, '2013-08-21 08:33:31', 1, NULL, NULL),
(72, 'Juan', 'Barla', 'juanbarla@hotmail.com', 'f77538d26d37221483971c3323d5f050', 4, '0000-00-00 00:00:00', 1, NULL, NULL),
(77, 'Hector', 'Cabrera', 'hcabrera@telecomnetworks.net', '4297f44b13955235245b2497399d7a93', 4, '0000-00-00 00:00:00', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `usuario_formulario`
--

CREATE TABLE IF NOT EXISTS `usuario_formulario` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_ultima_pagina_completa` int(11) NOT NULL,
  `terminado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alertas`
--
ALTER TABLE `alertas`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_Alerta_Usuario` (`id_agente`);

--
-- Indexes for table `inputs`
--
ALTER TABLE `inputs`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `input_select`
--
ALTER TABLE `input_select`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `input_texto`
--
ALTER TABLE `input_texto`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mensajes`
--
ALTER TABLE `mensajes`
 ADD PRIMARY KEY (`id`), ADD KEY `FK_Mensaje_Id_Receptor` (`id_receptor`);

--
-- Indexes for table `paginas`
--
ALTER TABLE `paginas`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `respuestas`
--
ALTER TABLE `respuestas`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `respuesta_texto`
--
ALTER TABLE `respuesta_texto`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `select_collections`
--
ALTER TABLE `select_collections`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tipos_usuario`
--
ALTER TABLE `tipos_usuario`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
 ADD PRIMARY KEY (`id`), ADD KEY `tipo` (`tipo`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alertas`
--
ALTER TABLE `alertas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `inputs`
--
ALTER TABLE `inputs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `input_select`
--
ALTER TABLE `input_select`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `input_texto`
--
ALTER TABLE `input_texto`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `mensajes`
--
ALTER TABLE `mensajes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `paginas`
--
ALTER TABLE `paginas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `respuestas`
--
ALTER TABLE `respuestas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `respuesta_texto`
--
ALTER TABLE `respuesta_texto`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `select_collections`
--
ALTER TABLE `select_collections`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tipos_usuario`
--
ALTER TABLE `tipos_usuario`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=78;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `alertas`
--
ALTER TABLE `alertas`
ADD CONSTRAINT `FK_Id_Agente` FOREIGN KEY (`id_agente`) REFERENCES `usuarios` (`id`),
ADD CONSTRAINT `alertas_ibfk_1` FOREIGN KEY (`id_agente`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `mensajes`
--
ALTER TABLE `mensajes`
ADD CONSTRAINT `FK_Mensaje_Id_Receptor` FOREIGN KEY (`id_receptor`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `usuarios`
--
ALTER TABLE `usuarios`
ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`tipo`) REFERENCES `tipos_usuario` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
