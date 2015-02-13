-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2015 at 05:33 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tu_tesis_en_linea`
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
  `nombre` varchar(255) NOT NULL,
  `ayuda` varchar(250) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inputs`
--

-- --------------------------------------------------------

--
-- Table structure for table `input_select`
--

CREATE TABLE IF NOT EXISTS `input_select` (
`id` int(11) NOT NULL,
  `id_input` int(11) NOT NULL,
  `tipo` varchar(255) NOT NULL COMMENT 'comun,multiselect',
  `respuestas_requeridas` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `input_select`
--


-- --------------------------------------------------------

--
-- Table structure for table `input_texto`
--

CREATE TABLE IF NOT EXISTS `input_texto` (
`id` int(11) NOT NULL,
  `id_input` int(11) NOT NULL,
  `respuestas_requeridas` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `input_texto`
--


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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

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
(16, 20, 2, 'asdfsadfsadfsdasdfa', 'asdfasdf', '0000-00-00 00:00:00', '2014-06-11 00:00:00', '2'),
(17, 2, 20, 'asdfasdfsdafsdaf', 'asdfasdf', '0000-00-00 00:00:00', '2014-06-11 00:00:00', '1'),
(18, 2, 2, 'Email para 2', 'Email para 2', '0000-00-00 00:00:00', '2014-06-16 00:00:00', '2'),
(19, 2, 72, 'Email para 2', 'Email para 2', '0000-00-00 00:00:00', '2014-06-16 00:00:00', '1'),
(20, 2, 2, 'Saludos&nbsp;', 'prueba', '0000-00-00 00:00:00', '2015-02-01 00:00:00', '2');

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
) ENGINE=InnoDB AUTO_INCREMENT=217 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `respuestas`
--


-- --------------------------------------------------------

--
-- Table structure for table `respuesta_select`
--

CREATE TABLE IF NOT EXISTS `respuesta_select` (
  `id` int(11) NOT NULL,
  `id_respuesta` int(11) NOT NULL,
  `id_select` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `respuesta_select`
--

-- --------------------------------------------------------

--
-- Table structure for table `respuesta_texto`
--

CREATE TABLE IF NOT EXISTS `respuesta_texto` (
`id` int(11) NOT NULL,
  `id_respuesta` int(11) NOT NULL,
  `texto` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `respuesta_texto`
--

-- --------------------------------------------------------

--
-- Table structure for table `select_collections`
--

CREATE TABLE IF NOT EXISTS `select_collections` (
  `id` int(11) NOT NULL,
  `id_input` int(11) NOT NULL,
  `id_select` int(11) NOT NULL,
  `value` text NOT NULL,
  `orden` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `select_collections`
--

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
(2, 'Edgar Fabiel', 'Sánchez Díaz', 'edgarfabiel@gmail.com', '5cf983105a58db2dc8cbc84032509f93', 2, '0000-00-00 00:00:00', 1, NULL, 0xffd8ffe000104a46494600010100000100010000ffe1009445786966000049492a0008000000020031010200070000002600000069870400010000002e00000000000000476f6f676c650000020000900700040000003032323086920700400000004c0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000ffdb0084000302020808090808070909090909090509090809080909090509090709090909050508080806050905090807050a0505070815090907050c0e16081807080908010304040605060a0606080d0d0c080c0c0808080d0c08080808080808080808080808080808080808080808080808080808080808080808080808080808080808ffc00011080088008803011100021101031101ffc4001d000001040301010000000000000000000008020304090506070100ffc40044100002010301050407050603070500000001020300041112050621223107134161080914325171a1425262818223729192c1f0b1b2d143a2a3d2e1e2f12433538393ffc4001b01010002030101000000000000000000000001020304060507ffc400251101000202010403010100030000000000000102031104051221311322415161142352ffda000c03010002110311003f00b108a2a0951c540bd141e18a81061aa0414a0f956a868aabecd9c0a2adb46de68a1b24c754d249294ee0922a020a5032f15047922a083710d506ca8b5b01d5140b02812d40d3d515d9a2f43689b4b6b470a3492b84455d4ce7a28f36e8a17c6a92b44ec2076d9eb14b4b2d516cc8d6e2501984ac4f74349c10cb805f570f748e05bc570d4db2c51a3ee1fad303865bfb3456025286090b6ae00a8d0fa4f5ca1e1d349e151debfc6ed5d97fa7d6c8da3208d8bdb33185477a54062e083a9b3f61c68d7e2194f5069de7c6242c76bc7328921757461c194821b048ea3cc7d2afdcc5307f554e98665e54aefa8124503322d0429a3aa0d8552b603c8941ed44a24d915554db25030f1d12afff004fbf4a592195b626cf974b84ff00d6321e75d4032c4af9c29d275b2a9e00ae6a93bfd6c56263d2b95b69ac8c4488da79b80cf5e186d7c5cf28e3a49d4340f3ac3368afeb622979fc30e20ca365949f7b217087075065383863a707e073d540a89b44feaff1cb29b336d0fb0fa994f53c0bfee29e20a9e60de0387caf5889fd56635f8297d183d2d6e7675c4705ec93496c5913413ac459f77de19c3f8693f7ba751598d262b1695a9eeeedc8ee618ae216d51c88aea7f091f697e2a7cfaeaac959ee79f6c5db7646aea94b443dd145cd3a50439d2833d1ad650e8a0f1aa25126eaaabea0c06fa6f4c3636b737972da22b686e2691bc42c6a5c855fb4cfee05fb4c545130a7edccdc06dad3dc6d5be25bda2e2e26d0493adddcb12afd74a16d2aaa4647c005c73fcee5db1c78759c1e1fc9eddc360f65b681347b345862a78c609623a71ebf5ae46fcecb69f6eb2bc1a563d27df762d64aa74411a13ab8e81cb91821570395bee1353ff372ff00568e9f8e7f1cd37afb1ab56560b0a46c4364c7cbd0f2f2f01f8ba1ad8a73f27f5ad97a6e3fe06dde1dda7b1b82afa9963649030393a32083aba613872f0c72d761c6cbf2d5c672707c575cafa2c6d949f6359946d5a44ca78e4a9ef19d471fc0e8ff0022b5b78a752f232ee6ceb2056c35ce20a07156acb91225043952aa33882b285114096a89449b22aaa9245455350b3eb1ddb8d16c108a481717b631385fb8ab24d86f2d7144df30b58b24b3e18dc867dc1d8e2deda088f2e11320f0d24f31cf9e72df3ae1b9f7bde7c3e8bd3e2b8ebe65d5f7674bf4653c3c083a71fe5af1ed8a75f67b119bba7ead8ef365e1757e79fad63f8edbf4c9f244439cef314c9d4475f88fe9592d86dfc62ae6a872edf776d5a3138f8e863e4d903f998e9aea3a6de691a72bd571c5ebdc313d5a5b6e47d9d340fa888c5b95cf4cab4b113f3748e2fc957e15d2d3eb3b727c988b56206469ad8689c55a0501565df355c45952a246614548f48a06d8544a2486aaaa4d20f4e0be9bdba02ef60dd6465ede5d9b749f8447771894ff00f83cca7c8d6a669d37b8d5dc84ade2b18237125cbbb2191523814b00edd3dd5e76f3f80f91ae3f913336fabbbe3e3aebecdbb72f78edfbb2f6f1bc415758122489ad469c9559911db4e557954f1e1c08207999ab688f2f5f8f4a44f86c37fbe82528879438c1f0d5819c7e67a56ad2d3bf6dbbe2ae9ccf79af6d514ab58dd00da8fb42248c9818c72839272dee2a9c60e70066bd3f3af6f37b236d1bb45d800595c0cb3a14d699e27958363a7e9f31f2adde2648dbcce7629f8c4d7abe6d12dad248e67449e516e521664592554ef64668a2c87755128e650786a3d01c7514cd168d391e4e09ac6c5f07add790754d4a0bab2efaae199454cc0ca2d4055034d51211555091513e13688980fbe973b224960802ea28deda8173c8d218b526a5cf336956d1aba6971e273e073af674fd2e2b7ae83fad992d93d4f960e3ae2b9ccf33f8ebf0c4c7b4edadb2242aaa7ede9d2992463ef3f1e50bef693d4d685a267dbd6a7dbdc31fbc5bb52c4d1b01918566d2412abc799718e64fbb91f6bf2ad69a6c5b5fc66aff0064b88c1cabc6fccaeb9f8679973d478ab0fe3579886ada23f8e61befb28c90cf10230d1ccaa4f4c907837956df1ebdb1b79d7fbfd5dc3b1bdd912ed0b5485832da9370f2af4d0a8a8abf06ef6460857e0253d2ba0e9f4dcf739bead96294ec1715d238c2e2a07d6b2859140c3d064c502a810e2a2436c2aaa1baac7b566277a6adda7ee91bdb49e0033269578b8f1ef233a942be469ef71dcebc8e0edd2b072295b47a7a7c3cb386c10f6aec692da6304c85244080a9c6572a08e604a307521b94f8f91ae17978ed8a7cbbae2e68c93b89277a36a6b65190a005e2c40e1d00fa7bb5a115b64f4e92336a355847da92c3a13448bab1cc4be4f0ea1589caf1e5f323e157b63984cde7f872cb6b9eef470d2780c1ce9c7f1f0c36af8560d4b14da7f8d4548795171ab53aae0004b12c001a4f060cd8e56f0cd7b1c4c537fabc2e5722314ec5e7615d924bb356e5ae0a1925740046c5c451c7ab4f36179a567663d70153f2eb78d83e3f0e279bc9f9ecea2cb5bef29f2ad03e959428d03325064d281ca06d854486c8aa8f08a2ba36c28790bde93f6822bd826e9de42ba879a395cff290bfa7ceb95eab8bf5d6f49cd31e2ce49b4f665bcd212c81801c1b8f29c7d9fba17c56b95ae59af877b8a2bee0a1bb50360145c019ce09cfef70cf4f2ad89cd330d9dc10258add5d42a80472f281fee8ff003356b566665a99ad0c9f603bba2f769db83c52166ba7fc421c140bf391914f96aaec7815d386ea59771a1c98e1f4e1e5d3f8574910e4ab1e7724e9a0505a0501571f1a08f31a0caad0281a0f0bd4486ddaaa1ba0e59da17a51eefecb263bcda56cb2a8c9b689fda2e17c0eab5b7ef258b8ff00f284f3c500db63da04bbe926d27b44ee57678b25b4b772ad24d1cbdfb4ad70e0e8ef6631c38894b0409a41258bb791ccc336abdce0668aceacd22d3da2ddca4a8721b4b230c32b03c7503e0c7c180e3f9e3909c31169dbb0c7966237596c0fbd7c0e98b0dd38f4ff0055fa5638a469b51925a65cecbbabb93bb895999caaa22ae7f99471666f7b4d67c348996966cb3fd7bbcdda24db9bb536693fb4596ce5f6c849cab0f68f762619e6453efa0e2c887982815d9717176c38ce667ee9d0e1eccbd20f646d7553b3ef609242aa5adcc8ab711123dd96d5b12657dde4041e5c67c77b7a97996c73adc3a186aba8507a05d5c258d04798d04c59a8886077f37fecf665b3de6d19d2dede3d21e49351d258e1551143492bb784512b1f78f8120b4058ed03d681b12d8ba5841737acbc1643a6de073f7b5bebb9d3fbd6e33e55434e03be3eb55db12645859d9db0e6019d64b871e7a9a48e3ca8fbd07ce868397695e93db7f6b061b4369dcbc6d9fd8a38b785b3e0d6d6eb14528fc32abff8555673fd9d711c63231f6b8004730fe8bc2ac0edf55b6d53ed3b514f1d69b34fc0280d3fbdfc4f37fd2b064fb4af36ed81d5dacf63905fa995408ee42f06c605c0c0e59b00805bdd12e3874391815e5f2f89df1e1e9703a84e3b6a43eecfec26e6597ba109424f3b39216207ed3b710c147da19cfd9d55e062e365b4f6cc3aac9cfc315d886dcbec7adb66c44ae1e5239e72003c7aac4bc7ba5fab7893c00e8b8dc3ae3f6e4f93cd9cb3a8564fac92fcbeda8a207847676ec3f0f793cd9fe6083f857aaf3028595eba3820b290570ca48643e0430c1529f797a55c11fd917a6feddd95a57da0de4238771765a5e1f08ae09efe2e1ca1958e3ceaabec5cee07acd365ce146d1b6b9b57c0d4f1e9b88b3f9149d47e86fce8af6ec45ee3f6f7b1f68a8f61bfb7909ff646558e55f1c35ac8565cfeea9a9da3b1bd3ce7e1e1f2f3e5fbc1853b91a466b8a8559147abed1000fd6b9bf2047b2f662bf33bddde48a0fbaa14431171f889b8d3fbadf0a6d68574fb374febd5b3c6a162e740b81fdffe682263271e1550e4e39ba74d3560757aaa187b56d50403fb0d9ec3e2c5669174afe6c33e558f5a53d887f4d4dab73147b3ee61bb9e3c4ef1ac50cac9ecf22c2ee932a4486569134b296e7d2a309a72ec7256d13e178d55caafb6fdd44b6d7d6db566be758edc4726a9944370f32a2f7ca229925f6d93f626d5cab467547d252c36295a5237305ed16f43ab75aeee66b484dfa24772d0c4668a36d51a3b2f32ab1e3c3ded3c70c59416c6a6d5b446fb948954d7ac1e70778ae147fb3b6d991e7f4bc99ff883fb345c34490f1cf97d3e1fac5584d4f7470c5131071d78516da39bb643956208e208e0548e20af9ad44c222db1cdeaf5edd2ea4ba6d9d753c92c722308fbe91e428e88cc9dd3b92540d262d2b8e0e83ecae314c32c46d6072559aa776dede8eda19ae66388e08e69643f7638d0bb9fd2aa6b231428b3b5ced4ae36bdf5d6d0ba625e691caa13916b18388a28bc152d534c5cbd719eac726c43538e7a04c8d40d3d144b913233f1d3f5e03e940677ab036df77b46fa1f196cf23e71ddc23fcb23563b775bcc32cc6bd898f4c858aedec6c75aa98dfdae6620b7751c8af6f1b4b80da431efdf9c0c089738d55ec7130d35bbb47264989fab01d85ee3c57bb65e0964b76836440925bc68a524bd95a68c472ccaaeb14b1ecc757e4488859dac98682ba4f9f9e7b65b5418371398909d20801bfc3ad6a4cf72f2a6cf4cfda9df6f16d46eba24b58f3f78c765029ff7b52d644b88163f97d547fa55c4b07a7ca83d693afe9a087752e463fbc55a510da3b13ed59b656d1b5ba400e8922f7ba290ea467c94a853f875d62966895d86ecef225ddbc17517feddc4514880f550ea0e1bc3284943e7556b64f6d0bd2fb7916db7736dc8eda3365751293f69ee07731aff00f6bc813f3acac30a3d8eef8fcfafce8d884b86e282409a81e53450fc67948f870fcbfed1cb404a7abf36ef73bc366a4e04c97d09fc5fb06900fe6856a2373f585b7ffa18b05ddbdedebed19637103bc29785e651ed08e4fb2c6f173bbc76a8436a85a3d68ef8ef72457a18bc46acc5698fc713d9bdad4761bd2b7709923b7492288070029b2b895925d2a35950a74dc0577e06184f0c606b67a4dbf192b2b25bc019595bc411fc7fe5ad49af6af2a30edcf6a77bb5b6b3939d5b436aaeafbda2e648c7e4c1463f4d5d2d0fbefaf0feb561f35c6281992e28215e5f7d0313f3e007d0d040b6705802786467c748eb9a1b5dff00a3e6d58a4d8db35a07d6a2d914b608d32066122fe97d6be6029f8560572061f5b47692f158eccd988e317735c5cca07568ed42c68aff0085e49da51f16817ee915958aaac3827ab324a6dbddf123f76aa94a82e78d04f8ee281e8a4e3e44607cc74fe6fe941bc7643bdcd63b42cee938186689875c364e83a947160c18a945f79750abf6f74ecd77fb5875df694cd72b3cf1471b44b6f17b32a12ee8b16a12098028c10bbc49a4108bdeaf524d743c5e25b346ab0f2b919e31789091da2ed04f6eba98c71f30d4228cbf3abea6234962ea21279b469193c31d47abcac78f8f8bb35b96be0bdb35b7bf0b5fddedec0db32def58f06b0b5b963e38f6459496f3ebef1f0ae16f69aceed0f77cc46a65443b436b1959a56f7e46791c75e673adbea7555c40173c681a96ea822c97d8a0c74d779d47f2febfd68220baf8505a2fab4f7f2e2e3665cdbcc55a3b692dfbac6352779de6be51c557f649f9f7bf1ad6b324846f590f69ad7fbc97516a0d1d825b59c7a7a65504d36afc5dfcd2c45be08959dad50c093fc6acc927edae789e3e1fe1c2894e8ae282645735512bda3231f0e34426d9df6086071e39fba4f8d64c7bf92227d2db8ad276316d3b5a768edee2566324b1a945d40a2a140579386954caeb6c0279fae787d378b7a63c51f1c7971dc9c56cb7f3e9a76d0dda9249c5ddca309352e31186d602fbcf10f79570142aa9d40ea3d39f57270ef7de4bb671e7ac7fd741edda5ef5bda6e4cb39c238d876912e794a493da476c397a655a51cabe3f0ae0395e72fadc3dfc731dbab4a9ba4bafa74fe3c3e9585b08cf77410e5bdf3a081717f411c4fc071e19c8a28435c50167eaeceda92c36a7b1cdab45f010a81d1667741131fbdce045f295cf406b0da19c2befd6f8497f77777d39fda5ddc5edcbf1ce1e799a471f205b4fcbe42b3b030c1ea07a26c11faa827453d04a4b9a42e911dc556448b6bbc1fefa1e3fdfe9a989f308ff1dfbb03892789f5b02d096d087385270cadc0e3947205e6fb5d0e2be81d1bcd66d3f8e67a85f53a76edbbbbacb1c52eb8dc4924c8b08984611d94aa16b872a17ba60d2bae0691acf1d0d8c7d4fa9da63b29e99f83c3d796ebe9e7bf8f65bafb0b64b481a6bb4d9a66209fdb47636b1b48dc7070f72f6edd0674e4e315c2ded133feba18c710ad896f3c7cea108935c66822cb3d1443967a0534c4e00f871a06ceaf8d065b7577b25b3b886ea03a6486449236c03a191832f03c1b881cad495aafffd9),
(5, 'Pablo', 'Guerrero', 'pablodbk@gmail.com', '090044f12add642ff61f4700a1bdd32c', 4, '2013-08-20 18:28:20', 1, NULL, NULL),
(20, 'Lautaro', 'Carbajal', 'juanbarla@gmail.com', '8c0f3c20875d2d8676c165fd18d9514b', 4, '2013-08-21 08:23:22', 1, '1686', NULL),
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
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `input_select`
--
ALTER TABLE `input_select`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `input_texto`
--
ALTER TABLE `input_texto`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT for table `mensajes`
--
ALTER TABLE `mensajes`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `paginas`
--
ALTER TABLE `paginas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `respuestas`
--
ALTER TABLE `respuestas`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=217;
--
-- AUTO_INCREMENT for table `respuesta_texto`
--
ALTER TABLE `respuesta_texto`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=168;
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
