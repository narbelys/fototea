--
-- Dumping data for table `categories`
--
TRUNCATE `categories`;
INSERT INTO `categories` (`id`, `description`, `order`) VALUES
(1, 'Producci&oacute;n de fotograf&iacute;as', 1),
(2, 'Edici&oacute;n de fotograf&iacute;as', 2),
(3, 'Producci&oacute;n y edici&oacute;n de videos', 3);

--
-- Dumping data for table `categories_event`
--
TRUNCATE `categories_event`;
INSERT INTO `categories_event` (`id`, `id_cat`, `description`) VALUES
(1, 1, 'Bodas'),
(2, 1, 'Autos'),
(3, 1, 'Compromisos'),
(4, 1, 'Corporativo'),
(5, 1, 'Cumplea&ntilde;os'),
(6, 1, 'Eventos y Cultural'),
(7, 1, 'Familia'),
(8, 1, 'Inmobiliario'),
(9, 1, 'Inmobiliario'),
(10, 1, 'Maternidad'),
(11, 1, 'Modelos y Actuaci&oacute;n'),
(12, 1, 'Negocios'),
(13, 1, 'Ni&ntilde;os y beb&eacute;s'),
(14, 1, 'Producto'),
(15, 1, 'Publicidad y Comercial'),
(16, 1, 'Retratos'),
(17, 2, 'Creativa'),
(18, 2, 'T&eacute;cnica'),
(19, 3, 'Bodas'),
(20, 3, 'Compromisos'),
(21, 3, 'Cursos'),
(22, 3, 'Demostraci&oacute;n de productos'),
(23, 3, 'Educaci&oacute;n'),
(24, 3, 'Entrevistas'),
(25, 3, 'Eventos y Cultural'),
(26, 3, 'Familia'),
(27, 3, 'Publicidad y Comercial'),
(28, 3, 'Testimoniales'),
(29, 3, 'Video Explicativo');

