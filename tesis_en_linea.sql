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
(6,	4,	'sadfasdf2',	1,	0),
(7,	6,	'Generales de usuario',	1,	1);

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
(1,	'prueba1',	1,	0),
(2,	'prueba2',	2,	0),
(3,	'prueba3',	3,	0),
(4,	'prueba4',	4,	0),
(5,	'prueba5',	5,	0),
(6,	'Datos Generales',	1,	1),
(7,	'Base del proyecto',	2,	1),
(8,	'DELIMITACIÓN DEL PROYECTO',	3,	1);

DROP TABLE IF EXISTS `preguntas`;
CREATE TABLE `preguntas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_grupo` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `titulo` text NOT NULL,
  `orden` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `preguntas` (`id`, `id_grupo`, `nombre`, `titulo`, `orden`, `estado`) VALUES
(1,	0,	'',	'prueba1',	1,	1),
(2,	0,	'',	'prueba2',	2,	1),
(3,	0,	'',	'prueba3',	3,	1),
(4,	0,	'',	'prueba4',	4,	1),
(5,	0,	'',	'prueba5',	5,	1),
(6,	4,	'',	'sadfasdf2',	1,	0),
(7,	3,	'',	'asdfasdf',	1,	0),
(8,	7,	'nombre',	'nombre',	1,	1);

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
(2,	'Edgar',	'Sanchez',	'edgarsanchez@mail.com',	'64405c9d68896131884c9a75cd4fdc4b',	2,	'0000-00-00 00:00:00',	1,	NULL,	'�PNG\r\n\Z\n\0\0\0\rIHDR\0\0\0^\0\0\0^\0\0\0�ңn\0\0\0bKGD\0�\0�\0�����\0\0\0	pHYs\0\0�\0\0��+\0\0\0tIME�(*I4\0\0\0tEXtComment\0Created with GIMPW�\0\0 \0IDATxڭ]Y����=@\0�!9�f�-�d\'q�!��T%��T*�S~C���Z����\\qR�mIv,Y�h8������9�5!p{�T\Z͐з��ӧ��r����\"��a�W.��?���b!�ѯ�������{���\\.�ڵW}_�_��},���͟%I������_�67�~�U7��&����7-�6����V}F��\r���y�v�ֽ)m�,äf����i/]�8���,/�f�d9�*�^���:����YF���mag[�_gx\Zj�B��~�6��m��Xi�]\r�jU���곶�����]����0$I��KVAצk�w֦��e�m��]��-t�3<��.�O��>��V9�&\0+�S���u��z�6����U�w���o\"YF3c�Ť��6�*�g-���`��:���v��U7�-���WѹM��+t���Y��%MY7B�*~�j��b�zUڣ�4+8�����\nW��6X���Ӷڴ���ie1�U޳\n�W~Ճo��&J�K\\�)�̺�`��;�5ï㷫�����k�z�u�n�X�k��%O�DK���u^�f������v�o\n̛r[��K��医<~W�X3�\Zj�ٴ�6�x��cW~[hY�x�]��:���n��K��ds�6�\r�h�m���������ۦ�jSr�N��6A[ǚ�a��&^��KZ��g���:1-�����mv�\r�Y��iʹ�$�e1������X,~`5Yo�&]_����b���n�i�p�]YϮ-��Oo��u������u���c�5�aU?��l��\0����Y�s��oc�UY�mx�������O���,�Rp�m6�j։H?U1c�7��R�m4�MZ<\0X�i�$�o����M����m߻.��X㯻f�:y޻n[oҥo��o*|�6�m�V6��\\.�������mo|S�̢`�0x[�kX�p�ؾ�|��`�Hv��:�tf�$3�(�|a�f(��1���y� ��8(��\0a��<!\0�ib�X�4MDQ�0�1L�|M6�6#�Ɛ�8�.j�&I�\\w�f�a���$I`Y�|�1,��h4B��F�VC>�Gb�8��X,�!�����	�4�3��v����u�����2Ms}�u~�N�ɒq	g���4�NE���11��Q*�0��a�6�$A���f��f�,�|�rY<?I��)��e�M4yS�ƶ�ϪP-���������̹���4<�<�\"L�S\\]]a<c4\Z�.�w���$I0����>��l6C�RA>��ؔ$	l��X��}�F��M{�ktrS1xM}�khp����\\.�(���>�����v��w�f3�r9L&Y� ��.&�	�0D�P�������Ʀ�N^^���ʦT9�m��67�m�J���	+�NI�fkO�,��QI@\0۶��>...`�6�A�^G�P���[u����D�u}<�t�������M�O�9�\"V�����˗���r�$AE���d�a\"I��sL�S��y�E8���l&�_�0�I�nS�Z�^k]f�-+���	�n��\\�4P�1\Z޲,�!�q�X �\"ض�(��^G���^��UN��M��U���\\[d�i�6�M�D�m�e!C���c�pB��1Ð����\0�~_E�p�����q0��%�2Npqx}�41\Z�E�\0�u]\nY��|��V*��zetr��s��4d����\'O�`�X��ܿa\"�\"�f����q\0�`0@�R�p8����a�6��\"���k�նm���w���}a-�^������q�q��|.���ѻ�D���f�F��rpw���l6C�����%Z�j��Ƹ�\nRו�(g��{�X�����)I���7�@.��pss�8��O�P�]1���xg�$p]W�8�\"Y�7�xC~�n�1��;�O��מm�0�b��m�X,�L&(\n(����v[��Z��0A Ŭ9�?rU�j�[���-�B\'-˂i��N��V�K�$����tP(P*��h��.�2��|߇��X,��zh��B\'�HY�!�U,�Jb|n�$I��>����؋/��_�q�Z�\nn��۰!}����\0`qk\n�����m�K�<��(�J(�(�H��R	�^���Z\r�����RI���8x��� ���%z���WǙ7E���K�̲P*�d������\"�q0\Z����Ű�e�����{{{h6�K\Z�mK��(c��ӱA�x˲p||�j�*��.nnn��\n��Az�M��m���\\N����|��9���lV{\rOͅe�&<��^�T����!z���:\\���Ņ�{�x��9�|��%�N��m��UC\n�MuZ4�j�\Z��:�ͦ|YM��A����}�V\0��ONN�!�ݮ`���(\n��ϟ?���9l�fa���ߧ�z,�x����w�y��¶mx����+|��W¦l�����ዋ��m���e2�,�e����#�z���5!�M�B�fSp����/���Ņ���WWWx�왬�a�����m�P(���\0��/^��eY������bH�����Q�9�I�X���j�P*�P.����Q��*�0��������l����^��M����Z����M��n�I�\'�������v2�qss�0P.�%�$��L&��f(���J�b�N�V��b>���}�a(4Sc*�DSD>\0�woڶm��e�z=�x��|�fST·��o�E��A.����9�}�]��y��u�oV�6�\Z��i2����<;;�$C��W�^���\n���rab>���*��l�J�\"\"�a(\nH��^��\"C�|��nW����ZO�ωŮ��X,�\\.��<yX����� �\n��p{��%�V������`�2�,Iw�p����t۲,�C<}����L�$A�^u:�f3�\"KB��8p������4�*��r91x�TXq��B���p��h���(j�����V��<\00�����fV���O�ǫR�4������B�\0�a� �\nLF<ϓ\"�x<������m�j��������op���l�^�z\Z6�\")�$I\"��eY��3Q*\nr�N��(�2)��N�+������V�|^.�$	�����b�F����cA�b��(��`\Z���e���[\'-���:�\ZhX�\'0�2��I�i�\"��b��8�1����Z̪��u���O���r��:i�L&�<O�8�qrr�F�!��\"DǨT*������	E��@����.�р�G.���|��u]	�:�n��Y�e�B�:��\n���\\.�ѣG���o0\Z�`��$K����=�i��b:�\nO&����4����K|6� �i\n7g>��	\r���!F���*����f3,�j&��R)R�lZ�I�1?�H���F���&z���!��)\\���������3&VL�=�v�����Mަ�HC�e>�4�f3�������\\�`��*.//%�XW_�F}ܦ����a����y���b�J������<T*H���}}��O�\"�������A�����K��Z���������A�	w�d2A�^GE�O��}Y�0�	�̶^�K<�j�&�إa)��cC�`0@��Er6��Ν;(\n����u]�j�0���믿����E\n����1��������G�?�$��\\W��7�L.��y�jSz��PJ�m�^���;�$	*�\n<������\'���m�6�d��9�`0@��@E��x	Fؽ��vẮ*\0��zx���@�V��[�հX,DR��jF�z	�_C8b�������R��c�&J��~����V�aooocp��y:�0>�x�?>����}x���d\"�/\ndonn����l��p8�5\Z\r16�XY[���0V���0����d\"�͜XG����T.�E�ݮ(��1��.�U��i�~�X��T*���}ߗm�4(��\\E�������+�\r/���Q�V�j��	�&?�R	�Bᵂ���R����Hv?O3*���A�T�a��0MS�>Mwi��4��Jl[,?d�ɘ^��	&������ȭ����$A��]��a:���P({�q��9f����`\0lT*<|�>\r���������t:����0J=g][ʺ^!��ҋ���Yj�E����%۶E����߬Ri=��n�T*a0����2j�\Z�<y��A�A�.�4��PG�1M�=�˗/���Dc�`Y��\"�ժpx���p���k��s�R�:,ߦ��8==�1ȑ!�!�Z��q��������8����3���{��jKI�N�	G���f�)F�g\"Ġ}yy�r��w�}�V�b�Z\r�Z\r�RI�!� 6C^o�4@m����Vy�.h�a���2x��\"C�����LT��pvv��O���}��e���bQ����C�������Z�J%K��S���X8��i4����8�1�L$X:����z�~��R7��j899E�*\n�T*KZ��Dj����3�9�G�\\y�e��<�z�\n���҉uss�b����3��<�b������Ţ��b�;w�������x���өM�	�f>(M{��3�g�q��t*As0���GGG��f\0 ���x<��T*8<<\\�[Y�����>]c��\\��L�S��m�z�\nA��k��h��?��l6���_�{]ׅeY������)J��<y\"�qVݑ�֪%3Wjb��|��t:���	:������XQ3����U��Ţ��۴�m���zΕ�h0���a\n��vw]����GGGb�_��W���/P�V��ܽ{�BA\n�JE𛱄��ZJ	��mK���>�|>���5���P�Tpyy�v��������h�Z(����y�/*��������zHŒ����l�R���Ɵ����h�b��V�%�M�R���#l�F��ċ/�1J��ZZ���iLg�=���T�y�1777�����!���P.���W_��/��������9i���t�Ӹ��o޻w��/^`0H`d\'?�K-����<���j�����Z��P(��,��m�rMA	-���b�(ͱ��tI�$�gɏI\Z+hz�!�{�YW��u43�7�,Y���~_�\r��r��~���0�ϥ B��a�j��^��qP�VE���Y*��_�xNm%kښA��4�L$�S\"�@:	4\\Q�\'�bMض�%�~���mv����Z�����qA�R��~��b�(,����d\"c�j#����i���Ӂ�e=\Z����4M��/}7���ea:��^��gY�^O�\"��f�qS���|/\0�^Ioc��^�888�f�b�(ܞ<���U�V{-�R<�:	�I�|>]E�K��u^�v\0��o��R���p(����}:��TC�; =&��iʩ�Ȭ�%-�e���T�0�Ӌ/��l�Z888�eI�L!�c\\^^b2���h�CQf�DLOM h��]�߱���H(b&Mg�F�o.5�\\.\'̊�����c0f��\Z+�Y��&�ӨV�8==��!.��qpxx���}����c��s�Z-��I;��,D���jx��1J��xUDmd�\r�L��զ!��˶mi�e>��3f��a3�k���fw;�W��Ih�Z\0+I4\Z\rt�]�F#iyf���y8>>�`J�P�j������0(2q\n�\0{{{��WWW`q�\ri�����hO����}ض�F�!��\\T��l/ɐu�6\r!��˚��S�&��E�c��^麮�u����h���v���zh4\Z2�h4pyy�|>/L���Q��7��p8�p8|m8�7L�PE�a�*�P�jM�|��PI���!����~[Ɔ&������\\�X�{Ԣ �U�t+�����d�{���X,b8�T*	7�V���)����K�<��1\Z�����e=����p�Z��F��u+��3M�~_�9`5Lw�Q�e�y���q��}Y��`����\nϞ=C�דF.�)���H\Z�����G�}�\n?�m�FQ���v�N���@y�ͦPG�tL(ADQ��h���.�o��O���&!��ɤ	\0�;��Pa}�8NOOő�����tp||���#ܻw���G�V[�7�Z0c���f�Rs������,ˉ�L��777�<O4{˲����u�����J��8GE�N{z�A4���ͲT�X,0�N��`4I��\'�����|��%��:,�B�^G������N��9���;aptM�W������ ��1�}��WI�`<�����(q>��!�iupV��ө�h�����ݠ{,�-��Y:���b�����c4�M�j5��eL&���[K�)���===��y�}_�4��l�˗/����/w��f]]]��,�%��B�`�\04�>�?���!��:��Z�&���ft���5��eFRN\r���Z�\"�ϣ�n���F���l�?��R	��׿ppp���у�y:���c\\\\\\�ѣG����<ϓ�s�5��<>��3|���pُ�<B;��S���Kޡ͛���H�L�t��]�I��X;����b��P1�b��>\\b����a2�spp�8�Q.�����^�\'�>~�!�8Ƨ�~�j��?�����i������J�\"�,��\n��H&�����>Z��������R��iO�X,���x���6K�Һ�N�g��k\ng�rd&\Z��9�6��:	�K�˙��x���}4�M$I���C�|��~�fs	\"�����<����pqq�>�\0��I�!�T���O�<�?��\\]]	l�Qt���S�:ć��H����_��H����\"��G��T�:�z40��.��	��+�u]���q�^�\'�!�t�\\.c6��V��޽{r6��:p���h4��tpss���K<}�<��y���Z�%z���o��j���;����ג@ao��0=������W���061��m�܂ܲ�L�њ�릧�� k�<آ��c<�Y	��T�U��9K�M;���͍\\c<���mٍZ\0��Q%m�Z������_����jV��E���3ZX�6\"���2 �\r@�m�����\Z=L@��v�r]�y\nhlG��A/�V�R.$T�gO�D� \r%�S7�ޯ�zv���G}����g�I�#�gh) ]�#�e&�����ape$���ZxC��<؇�ժcid*��K�ө(�ZE��)%p��5�FC����ZQa8J^�Qڀ����6r�U�_�����o+�DH������ܲ���\Z+�Y�����1�ǔ��Y�z�rY�[7W�ec�e���.~.��x<�k:�#�i�&NNN:���$ɮxL�VC�ٔ�!Bw�N53�ew���V�%���n����Y����`���6@�Mu?w9�f/��e����֊&;��$<�A;F�ل뺸����1�x�B:\0x����hN�^�Z��\n�x,���G�w����XuY��}_4=�A�J\'6��=�C	�y���yΝ;w�ؚ�hX�U�gPb 6S�\")���z�b�v[\Zd	c�i\n+��Ba���� ����ݯG>�(���)>��#�����I�ړ)0�����a�i�a4c\"�PAdv���z��Z��D����b\Z�:�Dӱ���жmI�+���a���X۶���b�(��b;�����Sﬂ���>���0>�HO��.T�IH{�������\r<R�L�ݾw�ܑ������k8�}3�kzˠ�%bgx/46\rO������q˙j�5��H�M�|��3���������C��:������T��5C��t��L&\"G�q���c�Ț+�����T	)�n��ݿ���~�)F������zܓ�H�!����M����!3Ԣ!�>ˑL�\'�iN����:\rOso�t���B� ����y8;;=�P����*��u2�w)�D/������pqq������{���us-�B�ߗ�B���Df�x��N����8#�P���:K������YXJX 5����	>81�T����<��믿^��,�5=ؖ�a��H�#��E�,Ķm<y���ײ���r��ԡY�dmw4\ZI�m:�b0��;�sЁ��6������nFcJ�:���� ��������=T?�>���E�O޽{I���ӧ��qz7�#д�A��;�`ooAȀ����q�)�������T�x��t:�����]��Y�*����猆X����@����X�\"�Ҵ/k̆I	w\Z��(������7�\\b\ni���H�m�črţG����$Q�m)vi�>�uF9��Nh�\nJFFx�`k�nW>�3Y�+*��H��C����M�`��D/I����\Z�X��nD�V��{�.�{����\0\04IDAT�%��Ao�\\�-��<~����Z����\n�|_|��(�����eC�%/�\'�`S}�&�\"Y��|A���f��z�*Ca�S,�k�f��Xi�\0�`��<���=8=����>�#��Z\"�Th�{�=9̍1�r����� ���o~��.�B�>��I�a0C��%e��s\'褋�u��d2Yzڣ�����0���\'}�����jVa�����h�\\SԴԫ�_=;� IM\\���a��?�9:����륩qgJͼ��Ǐ��_�I���Ç2��\0+��%���e��	��G}8K�T$�qJ��}i$��P.��AU��5����耑$�l��p(���y(��K]�����{�2�O�&�j53�u]��������h���y�q��?���d���hY��1��.J���&*�\n��8���C����á����d�\0��6�ө�\"a��������ǟ0�N�S�z=��Y��j\\f�\'޳�Q����Vixɚ��5���R�eZ��Qd�K}�������-�B��Y:/��U�Td�Ng�$�g�#H\'u�\Z;������l����*�\n@�>�\0\0\0\0IEND�B`�'),
(5,	'Dionisio',	'Estevez',	'destevez@telecomnetworks.net',	'090044f12add642ff61f4700a1bdd32c',	4,	'2013-08-20 18:28:20',	1,	NULL,	NULL),
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

-- 2015-01-20 03:43:23