-- Adminer 4.1.0 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `alertas`;
CREATE TABLE `alertas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_agente` int(11) DEFAULT NULL,
  `id_emisor` int(11) NOT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `url_audio` text NOT NULL,
  `audio` varchar(255) NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `fecha_creada` datetime NOT NULL,
  `fecha_visto` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Alerta_Usuario` (`id_agente`),
  CONSTRAINT `FK_Id_Agente` FOREIGN KEY (`id_agente`) REFERENCES `usuarios` (`id`),
  CONSTRAINT `alertas_ibfk_1` FOREIGN KEY (`id_agente`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `alertas` (`id`, `id_agente`, `id_emisor`, `estado`, `url_audio`, `audio`, `asunto`, `fecha_creada`, `fecha_visto`) VALUES
(1,	20,	0,	'2',	'',	'140530131928_1686_5108600356',	'New Evaluation!',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(2,	20,	0,	'2',	'',	'140530131928_1686_5108600356',	'New Evaluation!',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(3,	20,	0,	'1',	'',	'140530121226_1686_5013664508',	'New Evaluation!',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `grupos`;
CREATE TABLE `grupos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pagina` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `orden` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `grupos` (`id`, `id_pagina`, `titulo`, `orden`, `estado`) VALUES
(1,	0,	'prueba1',	1,	1),
(2,	0,	'prueba2',	2,	1),
(3,	0,	'prueba3',	3,	1),
(4,	0,	'prueba4',	4,	1),
(5,	0,	'prueba5',	5,	1),
(6,	4,	'sadfasdf2',	1,	1);

DROP TABLE IF EXISTS `mensajes`;
CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_emisor` int(11) DEFAULT NULL,
  `id_receptor` int(11) DEFAULT NULL,
  `mensaje` text,
  `asunto` varchar(255) DEFAULT NULL,
  `fecha_leido` datetime DEFAULT NULL,
  `fecha_creado` datetime DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Mensaje_Id_Receptor` (`id_receptor`),
  CONSTRAINT `FK_Mensaje_Id_Receptor` FOREIGN KEY (`id_receptor`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `mensajes` (`id`, `id_emisor`, `id_receptor`, `mensaje`, `asunto`, `fecha_leido`, `fecha_creado`, `estado`) VALUES
(1,	2,	20,	'<font color=\"#f83a22\" size=\"5\">E</font>mail de prueba<br>',	'New Evaluation!',	'0000-00-00 00:00:00',	'2014-06-10 00:00:00',	'2'),
(2,	20,	2,	'Respuesta2',	'2',	'0000-00-00 00:00:00',	'2014-06-10 00:00:00',	'2'),
(3,	2,	20,	'Respuesta3',	'20',	'0000-00-00 00:00:00',	'2014-06-10 00:00:00',	'2'),
(4,	20,	2,	'Respuesta2',	'2',	'0000-00-00 00:00:00',	'2014-06-10 00:00:00',	'2'),
(5,	20,	2,	'asdasdsad',	'2',	'0000-00-00 00:00:00',	'2014-06-10 00:00:00',	'2'),
(6,	2,	20,	'Respuesta3',	'20',	'0000-00-00 00:00:00',	'2014-06-10 00:00:00',	'2'),
(7,	20,	2,	'Respuesta10',	'2',	'0000-00-00 00:00:00',	'2014-06-10 00:00:00',	'2'),
(8,	20,	2,	'Respuesta10',	'2',	'0000-00-00 00:00:00',	'2014-06-10 00:00:00',	'2'),
(9,	20,	2,	'Respuesta10',	'2',	'0000-00-00 00:00:00',	'2014-06-10 00:00:00',	'2'),
(10,	20,	2,	'Respuesta10',	'2',	'0000-00-00 00:00:00',	'2014-06-10 00:00:00',	'2'),
(11,	20,	2,	'Respuesta11',	'2',	'0000-00-00 00:00:00',	'2014-06-10 00:00:00',	'2'),
(12,	20,	2,	'Respuesta11',	'2',	'0000-00-00 00:00:00',	'2014-06-10 00:00:00',	'2'),
(13,	2,	20,	'asdfasdfasdfasdf<br><font color=\"#9fe1e7\">asdfasdfasdfasdf<br>asdfasdfasdfasdf</font><br>asdfasdfasdfasdf<br>',	'20',	'0000-00-00 00:00:00',	'2014-06-11 00:00:00',	'2'),
(14,	20,	2,	'mensajeeeeeeeeeee',	'asuntooooo',	'0000-00-00 00:00:00',	'2014-06-11 00:00:00',	'2'),
(16,	20,	2,	'asdfsadfsadfsdasdfa',	'asdfasdf',	'0000-00-00 00:00:00',	'2014-06-11 00:00:00',	'1'),
(17,	2,	20,	'asdfasdfsdafsdaf',	'asdfasdf',	'0000-00-00 00:00:00',	'2014-06-11 00:00:00',	'1'),
(18,	2,	2,	'Email para 2',	'Email para 2',	'0000-00-00 00:00:00',	'2014-06-16 00:00:00',	'1'),
(19,	2,	72,	'Email para 2',	'Email para 2',	'0000-00-00 00:00:00',	'2014-06-16 00:00:00',	'1');

DROP TABLE IF EXISTS `paginas`;
CREATE TABLE `paginas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` text NOT NULL,
  `orden` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `paginas` (`id`, `titulo`, `orden`, `estado`) VALUES
(1,	'prueba1',	1,	1),
(2,	'prueba2',	2,	1),
(3,	'prueba3',	3,	1),
(4,	'prueba4',	4,	1),
(5,	'prueba5',	5,	1);

DROP TABLE IF EXISTS `preguntas`;
CREATE TABLE `preguntas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_grupo` int(11) NOT NULL,
  `titulo` text NOT NULL,
  `orden` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `preguntas` (`id`, `id_grupo`, `titulo`, `orden`, `estado`) VALUES
(1,	0,	'prueba1',	1,	1),
(2,	0,	'prueba2',	2,	1),
(3,	0,	'prueba3',	3,	1),
(4,	0,	'prueba4',	4,	1),
(5,	0,	'prueba5',	5,	1),
(6,	4,	'sadfasdf2',	1,	1),
(7,	3,	'asdfasdf',	1,	1);

DROP TABLE IF EXISTS `tipos_usuario`;
CREATE TABLE `tipos_usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `tipos_usuario` (`id`, `usuario`) VALUES
(1,	'Administrador_Sistema'),
(2,	'Administrador'),
(3,	'Supervisor'),
(4,	'Agente');

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `apellido` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `md5` varchar(255) NOT NULL,
  `tipo` int(2) NOT NULL,
  `fechaReg` datetime DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1',
  `id_callcenter` varchar(255) DEFAULT NULL,
  `avatar` mediumblob,
  PRIMARY KEY (`id`),
  KEY `tipo` (`tipo`),
  CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`tipo`) REFERENCES `tipos_usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `md5`, `tipo`, `fechaReg`, `estado`, `id_callcenter`, `avatar`) VALUES
(1,	'admin',	'admin',	'admin@telecomnetworks.net',	'21232f297a57a5a743894a0e4a801fc3',	1,	'2014-03-26 00:00:00',	1,	NULL,	NULL),
(2,	'Emily',	'Ingram',	'eingram@telecomnetworks.net',	'c73b4a904959372499f9e47450fc34b3',	2,	'0000-00-00 00:00:00',	1,	NULL,	'����\0JFIF\0\0\0\0\0\0��\0�\0								\n								\Z!\Z\"$\"$		\r��\0\0`\0`\"\0��\0\0\0\0\0\0\0\0\0\0\0\0\0\0��\0C\0\0\0\0\0\0\"!2B#1Rbr3AQaq�S�����Cc�����$���s����\0\Z\0\0\0\0\0\0\0\0\0\0\0\0\0��\0&\0\0\0\0\0\0\0\0\0!1\"AQ�2a���\0\0\0?\0��\n���Eë�U��-�e�:2(\\��$,�h�U� Iu�dp�5Y��WC��d��k�V�-��!�e�xNh{z�F1�={�П��H������C�~���hp���v3�f��Ѫ�GS�.�/�T!7�2���M]�h�HJJ5MP�@L%����=�!�7G\nq��	͢�Ә�(�`���X��0���\0���*����\0�Br30�u��e�OS���z�KH���Y��˷�d��L\\��X��{�@�g��,;l;��<ł���:KKD�ʁ�.\"�X�%��Zi���Q	Q��~�,��$\\@Ԥ���K)���5#�y{��F����jզ�ӧ��k�-\"B�Zx��		p�4��:����f�̉����T�iL9j��5V���|>[O;\Z�,��4�s\"Msʋ�4t��,1P���^aF`Cq�َ6��WB�5T�\n���ר�QY��a�F1�cN0�����,�J��X�9�f�� �׼���a\r��CX$*[9���ի,z���9�� ;�`��&�u��:,\"_��cH�?��t�#��Sk1:�IU��Q�B5}��m9&p҆8��K/��k��=}��R�f�?Ԑ���C�����˳\0&�)=C5��]2�/�������譂DKz?x�b�>qƃ�v�,)|�!���������7=�s��M��f���[�p�6sľ�ONS2�q\n�љ�V9o��;�?Z	8��Q\n\n�˘E�S�^<��׻�hӶ(�.�~�1��l�=���c߷a��K��DI�\"-:y��v�^px?r��_��,]z9�(�G�fi\0S��f��6p�wB��@��b�XZ�R�c,�}%l�m�c!�dlk�Q&H�K�)E��	i�Ұ/|w�X؈�ƒX�b\\T�����ى~0;��݋��%��wR+a	4xt\rl�?=��[G�d��Ơ~�Ř�T��%��~�lߘ��Yf4����eU,���wi�~��{Sy�0�Q��u^�|�;��a�GP���^�{/9)K�6#P�3��(G%��Ľ�B��l)w_�L�ic*���h�@�����0�=���^3k�*\n��	�%��W�c\ZwC�Om�6�e��/��!i�N��[ƪ��fW�#�;��a�*���Ej�����_372Z��dUsSU�ئ�Ne��NR^j��^\nX�!1Y\n�D�t@��[���j/�U�/���D���J��r+5N\"�C��{o*�\0B���\rE���k۹�n��.�x���>_�.�_�o�I峇�[�͋�waVT��]�._%�6��%}�-P�k\"�R<>l骄�f��(�C�lVYIz5�<����6#oH�#/�awG��8B�ϳSƑ��.�_�����cW�5>K)@/=Ǟ�m18@�jt�+�YJF4�F4���</GV�%������/Qz\Z^�,%�a_��?�ж�\0̨���򎪋�͇��d��Xѓ��_�.Q����ޮ��i`�+gxYͫ�We���yz��_��.�c50�D����\04����6[��*�\0�li��5�\n̘$TM!\"����~�.ZC�2?Y�Ū�Y�����^\"�CRơ.!�	�������d)�>�Ȫz��a�t�ڻ�%N�J��[\r�@RO���H\r5W��*�\\Ug�@돹ҥ�\r�I/�|K�	ڬ��L\ZD�o/��ݍk�Ea�LeL&j�����vXb�jVװ���I�fP$�`>�K.F�YHFy3.K�z�!^ye�$\"K\"�.���b�����V=��%9@����Di��P�Gw�il%ՓR�xY��C�b����\"f��e\"�yfc$^*�ͨ�l��~�S�F64��,KP���+o���j�[�,e5�+��*�?~�0��2��m7�f���٫��څ���e<���5�e�KW{U�\'�l��Wp��,b�4Y�L*O�Վ6�n����s�E�MM�&ə`��bDR��F=�1�8��N>�X�!u�I�m���k<����U�:c�-�iv�����2\"c9�����K���~��a�\Z�i;��Is+}T���%8C�c\n�{�g��{\\���5�\0�K3����Np3��R���]��6&$2�t��%�kx������]�ڿ�<��K���Ql$zġ�w���b���C�\\����$<����F����6<�K�{����{����YMD�2͘B}}�[A���#��YxG��\Zayr�?h>R!�[3h��Y�-\"����]�������Te\"Im,�iKM��GH��D<^V���F�=���|%�]��/�7ۚ���|�ȩ�L@�MT�K��f�\0B��H\\�K�Z�\Z����ƹ���J���Z72D�D��{l�*�*�Y�!���߂�$���1k�G�ۏ�eՏQ��͹[�����z|V�n����N��	R5		r[_h����\Z��Kx���}�܊q�L�1b�i��\\�p��3AK:�=◣J-�� g��4������`�gfW��}dѫP�L0*�ۿ��=+�m�%4�jX�%���|=ݶw_3�Ce��\\c2$����K�iS�\rK\0u0�<\Z\\Q���V���L��^f���Ƿ{w�����w�HYj�f��G�G��c���Y�B\'��j%I�y�ǚ�|�%��Z�oyL����dD��9��XF4�>k<��dr>��E[Z��w����&�},,����X��سg�RS4T+�\"���V`�]Ŗ:i!�HGM%�\0�[\"��Z�)�b�!椨/�=p�Y$����{��يޘz}굺S,fe�T�4��\"��W,a���Q���z6�$K�\0�,y��E��v�X[�&v�Q2��	f�x����/ID�IEGH�F�*��|p�Hq�p�=q���#0h��8��jf�����@�yJ4��\0~\\#����ƥ0K���ķ�V?�/��I�*�e$$��\ZJ�k(B8i����1��e��a��\0J����ȎS�e���۾�iz5�jg��nId>�6vL��X�]�.o��{<�-BV%6�It�5X�(\nb-qp�O3��'),
(5,	'Dionisio',	'Estevez',	'destevez@telecomnetworks.net',	'f77538d26d37221483971c3323d5f050',	4,	'2013-08-20 18:28:20',	1,	NULL,	NULL),
(6,	'Omar',	'Collado',	'ocallado@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:31:30',	1,	NULL,	NULL),
(7,	'Leonel',	'Jimenez',	'ljimenez@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:37:30',	1,	NULL,	NULL),
(9,	'Loryan',	'Lozano',	'llozano@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:27:22',	1,	NULL,	NULL),
(10,	'Saul',	'Nuñez',	'snunez@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:34:58',	1,	NULL,	NULL),
(11,	'James',	'Polanco',	'jpolanco@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-20 18:32:05',	1,	NULL,	NULL),
(12,	'Venny',	'Rodriguez',	'vrodriguez@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:36:04',	1,	NULL,	NULL),
(14,	'Juan',	'Cortacio',	'jcortacio@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-20 18:30:24',	1,	NULL,	NULL),
(16,	'Alejandro',	'Gadea',	'agadea@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-09-26 19:17:04',	1,	'1222',	NULL),
(18,	'Micaela',	'Melgar',	'spuentes@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:30:26',	1,	NULL,	NULL),
(19,	'Ismael',	'Madera Guillen',	'iguillen@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-20 18:31:49',	1,	NULL,	NULL),
(20,	'Lautaro',	'Carbajal',	'juanbarla@gmail.com',	'f77538d26d37221483971c3323d5f050',	4,	'2013-08-21 08:23:22',	1,	'1686',	NULL),
(21,	'Rodrigo',	'Beltran',	'fbonilla@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:34:28',	1,	NULL,	NULL),
(22,	'Daniel',	'Tomikian',	'rinoa@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-20 18:25:55',	1,	NULL,	NULL),
(23,	'Roberto',	'Garcia',	'rgarcia@telecomnetworks.net',	'f77538d26d37221483971c3323d5f050',	4,	'2013-08-21 08:33:52',	1,	NULL,	NULL),
(24,	'Flora',	'Berton',	'fberton@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-20 18:29:39',	1,	NULL,	NULL),
(25,	'Maria Alejandra',	'Provenzza',	'mprovenzza@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:28:22',	1,	NULL,	NULL),
(26,	'Mario',	'Tornelli',	'mtornelli@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:30:01',	1,	NULL,	NULL),
(27,	'Jonny',	'Fernandez',	'jfernandez@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:18:54',	1,	NULL,	NULL),
(28,	'Raul',	'Alravez',	'mgonzalez@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:33:01',	1,	NULL,	NULL),
(29,	'Erika',	'Herfurth',	'ygonzalez@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-20 18:28:50',	1,	NULL,	NULL),
(30,	'Solanyis',	'Fernandez',	'sfernandez@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:35:22',	1,	NULL,	NULL),
(31,	'Yazmin',	'Tavarez',	'ytavarez@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:37:09',	1,	NULL,	NULL),
(32,	'Jonathan',	'Fernandez',	'jofernandez@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-20 18:32:41',	1,	NULL,	NULL),
(34,	'Robinson',	'Madera',	'rmadera@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:34:09',	1,	NULL,	NULL),
(35,	'Christian',	'Vera',	'cvera@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-20 18:25:28',	1,	NULL,	NULL),
(36,	'Cesar',	'Madera',	'cmadera@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-20 18:24:45',	1,	NULL,	NULL),
(37,	'Juan Ramon',	'Peña',	'jpena@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:22:44',	1,	NULL,	NULL),
(38,	'Luis',	'Bonilla',	'lbonilla@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:27:38',	1,	NULL,	NULL),
(39,	'Chantelle',	'Baez',	'cbaez@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-20 18:24:57',	1,	NULL,	NULL),
(40,	'Juan',	'Hernandez',	'jhernandez@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:20:52',	1,	NULL,	NULL),
(41,	'Lendy',	'Lopez',	'llopez@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:26:06',	1,	NULL,	NULL),
(42,	'Christian',	'Jimenez',	'cjimenez@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-20 18:25:19',	1,	NULL,	NULL),
(43,	'Ramon',	'Bueno',	'rbueno@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:32:09',	1,	NULL,	NULL),
(45,	'Valentina',	'Alpuin ',	'valpuin@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:35:39',	1,	NULL,	NULL),
(46,	'Ines',	'Rodriguez',	'irodriguez@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-20 18:31:31',	1,	NULL,	NULL),
(47,	'Natalia',	'Lorda',	'sblanco@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:31:15',	1,	NULL,	NULL),
(48,	'Pavel',	'Mulet',	'pmulet@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:31:56',	1,	NULL,	NULL),
(49,	'Aldonza',	'Azcona',	'aazcona@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2014-01-02 18:05:14',	1,	NULL,	NULL),
(50,	'Wilber',	'Mercedes',	'wmercedes@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:37:47',	1,	NULL,	NULL),
(51,	'Herby',	'Romulus',	'hromulus@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-20 18:31:03',	1,	NULL,	NULL),
(62,	'Ruben',	'Ventura',	'rventura@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:34:43',	1,	NULL,	NULL),
(63,	'Roberto',	'Alvarez',	'roalvarez@telecomnetworks.net',	'f8032d5cae3de20fcec887f395ec9a6a',	4,	'2013-08-21 08:33:31',	1,	NULL,	NULL),
(72,	'Juan',	'Barla',	'juanbarla@hotmail.com',	'f77538d26d37221483971c3323d5f050',	4,	'0000-00-00 00:00:00',	1,	NULL,	NULL),
(77,	'Hector',	'Cabrera',	'hcabrera@telecomnetworks.net',	'4297f44b13955235245b2497399d7a93',	4,	'0000-00-00 00:00:00',	1,	NULL,	NULL);

-- 2015-01-19 13:52:55
