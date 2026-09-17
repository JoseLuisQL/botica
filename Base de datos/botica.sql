-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-06-2022 a las 22:48:06
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.3.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `botica`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencia`
--

CREATE TABLE `asistencia` (
  `id_asistencia` int(10) NOT NULL,
  `unico` varchar(25) NOT NULL,
  `user_id` int(10) NOT NULL,
  `hora_entrada` time NOT NULL,
  `fecha_entrada` date NOT NULL,
  `hora_base` time NOT NULL,
  `hora_salida` time NOT NULL,
  `fecha_salida` date NOT NULL,
  `min_tardanza` time NOT NULL,
  `asistencia` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `baja_sunat`
--

CREATE TABLE `baja_sunat` (
  `id_baja` int(10) NOT NULL,
  `id_doc1` int(10) NOT NULL,
  `numero` varchar(8) NOT NULL,
  `fecha` date NOT NULL,
  `aceptado_baja` varchar(100) NOT NULL,
  `xml` varchar(30) NOT NULL,
  `ticket` varchar(20) NOT NULL,
  `has_cpe` varchar(100) NOT NULL,
  `cod_sunat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id_caja` int(10) NOT NULL,
  `usuario_inicio` int(3) NOT NULL,
  `fec_reg` datetime NOT NULL,
  `fecha` date NOT NULL,
  `inicio` float NOT NULL,
  `cierre` float NOT NULL,
  `tienda` int(2) NOT NULL,
  `usuario_cierre` int(3) NOT NULL,
  `faltante` decimal(7,2) NOT NULL,
  `fecha_cierre` datetime NOT NULL,
  `entrada` decimal(10,2) NOT NULL,
  `salida` decimal(10,2) NOT NULL,
  `turno` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`id_caja`, `usuario_inicio`, `fec_reg`, `fecha`, `inicio`, `cierre`, `tienda`, `usuario_cierre`, `faltante`, `fecha_cierre`, `entrada`, `salida`, `turno`) VALUES
(37, 1, '2021-11-22 12:19:08', '2021-11-22', 0, 0, 1, 0, '0.00', '0000-00-00 00:00:00', '0.00', '0.00', 'Mañana');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito`
--

CREATE TABLE `carrito` (
  `id_carrito` int(10) UNSIGNED NOT NULL,
  `clave` varchar(10) NOT NULL,
  `id_usuario` int(10) NOT NULL,
  `id_producto` int(10) NOT NULL,
  `cantidad` double NOT NULL,
  `precio` double NOT NULL,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(10) NOT NULL,
  `nom_cat` varchar(50) CHARACTER SET utf8 NOT NULL,
  `des_cat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nom_cat`, `des_cat`) VALUES
(1, 'FARMACOS/ETICO', 'FARMACOS/ETICO'),
(2, 'PRODUCTOS PARA BEBE', 'PRODUCTOS PARA BEBE'),
(3, 'GALENICOS', 'GALENICOS'),
(4, 'GENERICOS', 'GENERICOS'),
(5, 'FARMACOS/OTC', 'FARMACOS/OTC'),
(6, 'PRODUCTOS DE TOCADOR', 'PRODUCTOS DE TOCADOR'),
(8, 'PERFUMERIA', 'PERFUMERIA'),
(9, 'JUGUETES', 'JUGUETES'),
(10, 'PRODUCTOS LACTEOS', 'PRODUCTOS LACTEOS'),
(11, 'MULTIVITAMINICO', 'MULTIVITAMINICO'),
(12, 'ACCES MEDICO QUIRURGICO1', 'ACCES MEDICO QUIRURGICO1'),
(13, 'VARIOS', 'VARIOS'),
(14, 'ASD', 'ASD'),
(15, 'ANTIMICOTICOS', 'ANTIMICOTICOS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre_cliente` varchar(255) NOT NULL,
  `telefono_cliente` char(30) NOT NULL,
  `email_cliente` varchar(64) NOT NULL,
  `direccion_cliente` varchar(255) NOT NULL,
  `status_cliente` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `doc` varchar(15) NOT NULL,
  `dni` varchar(10) NOT NULL,
  `vendedor` varchar(100) NOT NULL,
  `pais` text NOT NULL,
  `departamento` text NOT NULL,
  `provincia` text NOT NULL,
  `distrito` text NOT NULL,
  `cuenta` text NOT NULL,
  `tipo1` int(2) NOT NULL,
  `tienda` int(10) NOT NULL,
  `users` decimal(12,2) NOT NULL,
  `deuda` decimal(8,2) NOT NULL,
  `debe` decimal(8,2) NOT NULL,
  `documento` varchar(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre_cliente`, `telefono_cliente`, `email_cliente`, `direccion_cliente`, `status_cliente`, `date_added`, `doc`, `dni`, `vendedor`, `pais`, `departamento`, `provincia`, `distrito`, `cuenta`, `tipo1`, `tienda`, `users`, `deuda`, `debe`, `documento`) VALUES
(1, 'CLIENTES VARIOS', '', '', '', 0, '0000-00-00 00:00:00', '0', '11111111', '', '', '', '', '', '', 0, 0, '1.00', '0.00', '0.00', '11111111'),
(257, 'Administrador', 'telefono', 'admin@admin.com', 'domicilio', 0, '0000-00-00 00:00:00', '0', '41364119', '1', '', '', '', '', '', 0, 0, '0.00', '0.00', '0.00', '41364119');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id_comentario` int(10) NOT NULL,
  `id_producto` int(10) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `comentario` text NOT NULL,
  `correo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id_comentario`, `id_producto`, `nombre`, `comentario`, `correo`) VALUES
(1, 11408, 'asd1', 'asd', 'as');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comprobante_pago`
--

CREATE TABLE `comprobante_pago` (
  `id_comprobante` int(2) NOT NULL,
  `cod_comprobante` varchar(3) NOT NULL,
  `des_comprobante` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `comprobante_pago`
--

INSERT INTO `comprobante_pago` (`id_comprobante`, `cod_comprobante`, `des_comprobante`) VALUES
(1, '01', 'Factura'),
(2, '03', 'Boleta de Venta'),
(3, '100', 'Guia'),
(4, '02', 'Recibo por Honorarios'),
(5, '00', 'Otros (especificar)'),
(6, '05', 'Boleto de compa&ntilde;a de aviaci&oacute;n comercial por el servicio de transporte a&eacute;reo de pasajeros'),
(7, '16', 'Boleto de viaje emitido por las empresas de transporte p&uacute;blico interprovincial de pasajeros dentro del pa&sacute;s'),
(8, '15', 'Boleto emitido por las empresas de transporte p&uacute;blico urbano de pasajeros'),
(9, '19', 'Boleto o entrada por atracciones y espect&aacute;culos p&uacute;blicos'),
(10, '06', 'Carta de porte a&eacute;reo por el servicio de transporte de carga a&eacute;rea'),
(11, '24', 'Certificado de pago de regal&iacute;as emitidas por PERUPETRO S.A'),
(12, '91', 'Comprobante de No Domiciliado                                                 '),
(13, '20', 'Comprobante de Retenci&oacute;n'),
(14, '22', 'Comprobante por Operaciones No Habituales'),
(15, '21', 'Conocimiento de embarque por el servicio de transporte de carga mar&iacute;tima'),
(16, '53', 'Declaraci&oacute;n de Mensajer&iacute;a o Courier                                         '),
(17, '50', 'Declaraci&oacute;n &uacute;nica de Aduanas - Importaci&oacute;n definitiva                 '),
(18, '52', 'Despacho Simplificado - Importaci&oacute;n Simplificada                        '),
(19, '25', 'Documento de Atribuci&oacute;n (Ley del Impuesto General a las Ventas e Impuesto Selectivo al Consumo, Art. 19, &uacute;ltimo p?rrafo, R.S. Nro 022-98-SUNAT).'),
(20, '34', 'Pago trabajador'),
(21, '35', 'Documento del Part&iacute;cipe'),
(22, '13', 'Documento emitido por bancos, instituciones financieras, crediticias y de seguros que se encuentren bajo el control de la Superintendencia de Banca y Seguros'),
(23, '17', 'Documento emitido por la Iglesia Cat&oacute;lica por el arrendamiento de bienes inmuebles'),
(24, '18', 'Documento emitido por las Administradoras Privadas de Fondo de Pensiones que se encuentran bajo la supervisi&oacute;n de la Superintendencia de Administradoras Privadas de Fondos de Pensiones'),
(25, '29', 'Documentos emitidos por la COFOPRI en calidad de oferta de venta de terrenos, los correspondientes a las subastas p&uacute;blicas y a la retribuci&oacute;n de los servicios que presta'),
(26, '30', 'Documentos emitidos por las empresas que desempe&ntilde;an el rol adquirente en los sistemas de pago mediante tarjetas de cr&eacute;dito y d&eacute;bito'),
(27, '32', 'Documentos emitidos por las empresas recaudadoras de la denominada Garant&iacute;a de Red Principal a la que hace referencia el numeral 7.6 del art&iacute;culo 7 de la Ley Nro 27133 ? Ley de Promoci&oacute;n del Desarrollo de la Industria del Gas Natural'),
(28, '37', 'Documentos que emitan los concesionarios del servicio de revisiones t&eacute;cnicas vehiculares, por la prestaci&oacute;n de dicho servicio'),
(29, '96', 'Exceso de cr&eacute;dito fiscal por retiro de bienes                           '),
(30, '09', 'Gu?a de remisi&oacute;n - Remitente'),
(31, '31', 'Gu&iacute;a de Remisi&oacute;n - Transportista'),
(32, '54', 'Liquidaci&oacute;n de Cobranza                                                     '),
(33, '04', 'Liquidaci&oacute;n de compra'),
(34, '07', 'Nota de cr&eacute;dito'),
(35, '97', 'Nota de Cr&eacute;dito - No Domiciliado'),
(36, '87', 'Nota de Cr&eacute;dito Especial'),
(37, '08', 'Nota de d&eacute;bito'),
(38, '98', 'Nota de D&eacute;bito - No Domiciliado'),
(39, '88', 'Nota de D&eacute;bito Especial'),
(40, '99', 'Otros -Consolidado de Boletas de Venta'),
(41, '11', 'P&oacute;liza emitida por las Bolsas de Valores, Bolsas de Productos o Agentes de Intermediaci&oacute;n por operaciones realizadas en las Bolsas de Valores o Productos o fuera de las mismas, autorizadas por CONASEV'),
(42, '23', 'P&oacute;lizas de Adjudicaci&oacute;n emitidas con ocasi&oacute;n del remate o adjudicaci&oacute;n de bienes por venta forzada, por los martilleros o las entidades que rematen o subasten bienes por cuenta de terceros'),
(43, '36', 'Recibo de Distribuci&oacute;n de Gas Natural'),
(44, '10', 'Recibo por Arrendamiento'),
(45, '26', 'Recibo por el Pago de la Tarifa por Uso de Agua Superficial con fines agrarios y por el pago de la Cuota para la ejecuci&oacute;n de una determinada obra o actividad acordada por la Asamblea General de la Comisi&oacute;n de Regantes o Resoluci&oacute;n expedida por el Jefe de la Unidad de Aguas y de Riego (Decreto Supremo Nro 003-90-AG, Arts. 28 y 48)'),
(46, '14', 'Recibo por servicios p&uacute;blicos de suministro de energ&iacute;a el&eacute;ctrica, agua, tel&eacute;fono, telex y telegr&aacute;ficos y otros servicios complementarios que se incluyan en el recibo de servicio p&uacute;blico.'),
(47, '27', 'Seguro Complementario de Trabajo de Riesgo'),
(48, '28', 'Tarifa Unificada de Uso de Aeropuerto'),
(49, '12', 'Ticket o cinta emitido por m&aacute;quina registradora');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas`
--

CREATE TABLE `consultas` (
  `id` int(10) NOT NULL,
  `tipo` int(2) NOT NULL,
  `a1` text NOT NULL,
  `a2` text NOT NULL,
  `a3` text NOT NULL,
  `a4` text NOT NULL,
  `a5` text NOT NULL,
  `a6` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `consultas`
--

INSERT INTO `consultas` (`id`, `tipo`, `a1`, `a2`, `a3`, `a4`, `a5`, `a6`) VALUES
(2238, 71, '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacto`
--

CREATE TABLE `contacto` (
  `id_contacto` int(10) UNSIGNED NOT NULL,
  `nom_cont` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fecha` datetime NOT NULL,
  `tema` varchar(100) NOT NULL,
  `mensaje` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas`
--

CREATE TABLE `cuentas` (
  `id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `cod_cue` int(4) NOT NULL,
  `nom_cue` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datosempresa`
--

CREATE TABLE `datosempresa` (
  `nom_emp` varchar(200) NOT NULL,
  `id_emp` int(2) NOT NULL,
  `tienda` int(10) NOT NULL,
  `des_emp` text NOT NULL,
  `mis_emp` text NOT NULL,
  `vis_emp` text NOT NULL,
  `tel_emp` varchar(200) NOT NULL,
  `dir_emp` varchar(300) NOT NULL,
  `email_emp` text NOT NULL,
  `face_emp` varchar(200) NOT NULL,
  `tiwter_emp` text NOT NULL,
  `youtube_emp` text NOT NULL,
  `linkedin_emp` text NOT NULL,
  `dolar` float NOT NULL,
  `alerta` double NOT NULL,
  `logo` varchar(20) NOT NULL,
  `fotovision` varchar(20) NOT NULL,
  `fotomision` varchar(20) NOT NULL,
  `slider1` varchar(20) NOT NULL,
  `slider2` varchar(20) NOT NULL,
  `slider3` varchar(20) NOT NULL,
  `slider4` varchar(20) NOT NULL,
  `slider5` varchar(20) NOT NULL,
  `comentario1` text NOT NULL,
  `comentario2` text NOT NULL,
  `comentario3` text NOT NULL,
  `comentario4` text NOT NULL,
  `comentario5` text NOT NULL,
  `precio2` decimal(7,2) NOT NULL,
  `precio3` decimal(7,2) NOT NULL,
  `fac_ele` int(2) NOT NULL,
  `usuariosol` varchar(30) NOT NULL,
  `clavesol` varchar(30) NOT NULL,
  `clave` varchar(50) NOT NULL,
  `conversion` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `datosempresa`
--

INSERT INTO `datosempresa` (`nom_emp`, `id_emp`, `tienda`, `des_emp`, `mis_emp`, `vis_emp`, `tel_emp`, `dir_emp`, `email_emp`, `face_emp`, `tiwter_emp`, `youtube_emp`, `linkedin_emp`, `dolar`, `alerta`, `logo`, `fotovision`, `fotomision`, `slider1`, `slider2`, `slider3`, `slider4`, `slider5`, `comentario1`, `comentario2`, `comentario3`, `comentario4`, `comentario5`, `precio2`, `precio3`, `fac_ele`, `usuariosol`, `clavesol`, `clave`, `conversion`) VALUES
('ECONOMIFARMA SAC', 1, 1, 'Somos una microempresa dedicada a la dispensacion, suministro de medicamentos, la calidad nos convierte en el prestador de servicios farmaceutico mas confiable del mercado.\r\n', 'Contribuimos a la salud de nuestros usuarios con productos farmacÃ©uticos de calidad, comprometidos con el mejoramiento continuo de los servicios que prestamos a nuestros clientes, nos destacamos por la profesionalidad y amabilidad de nuestro personal.', '', '', '', '', 'facebook1', 'twitter1', 'youtube1', 'linkedin1', 3.2, 5, 'logo.jpg', 'vision.jpg', 'mision.jpg', 'fotoHRtLZR2r.jpg', 'fotogMheCAPJ.jpg', 'fotogc7lAaze.jpg', '', '', 'comentario11', 'comentario21', 'comentario31', 'comentario41', 'comentario516', '10.00', '20.00', 1, 'BOTICOL1', 'Boticol12345', 'uxYj5bxB64CT7W3s', 100);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_factura`
--

CREATE TABLE `detalle_factura` (
  `id_detalle` int(11) NOT NULL,
  `id_cliente` int(10) NOT NULL,
  `id_vendedor` int(10) NOT NULL,
  `numero_factura` int(11) NOT NULL,
  `ot` varchar(20) NOT NULL,
  `id_producto` varchar(100) NOT NULL,
  `cantidad` decimal(7,2) NOT NULL,
  `precio_venta` decimal(7,2) NOT NULL,
  `tienda` int(2) NOT NULL,
  `activo` int(1) NOT NULL,
  `ven_com` int(2) NOT NULL,
  `fecha` datetime NOT NULL,
  `precio_compra` decimal(7,2) NOT NULL,
  `tipo_doc` int(2) NOT NULL,
  `inv_ini` double NOT NULL,
  `moneda` decimal(4,2) NOT NULL,
  `folio` varchar(5) NOT NULL,
  `val1` decimal(7,2) NOT NULL,
  `val2` decimal(7,2) NOT NULL,
  `mone` decimal(12,2) NOT NULL,
  `t1` varchar(12) NOT NULL,
  `t2` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detalle_factura`
--

INSERT INTO `detalle_factura` (`id_detalle`, `id_cliente`, `id_vendedor`, `numero_factura`, `ot`, `id_producto`, `cantidad`, `precio_venta`, `tienda`, `activo`, `ven_com`, `fecha`, `precio_compra`, `tipo_doc`, `inv_ini`, `moneda`, `folio`, `val1`, `val2`, `mone`, `t1`, `t2`) VALUES
(9719, 1, 1, 1, '1', '13111', '1.00', '1.00', 1, 1, 1, '2021-12-05 02:33:50', '0.70', 2, 1993, '1.00', 'B003', '0.00', '0.00', '0.00', 'unidad', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento`
--

CREATE TABLE `documento` (
  `id_documento` int(2) NOT NULL,
  `tipo` varchar(14) NOT NULL,
  `numero` double NOT NULL,
  `tienda1` varchar(10) NOT NULL,
  `tienda2` varchar(10) NOT NULL,
  `tienda3` varchar(10) NOT NULL,
  `tienda4` varchar(10) NOT NULL,
  `tienda5` varchar(10) NOT NULL,
  `tienda6` varchar(10) NOT NULL,
  `tienda7` int(10) NOT NULL,
  `folio1` varchar(5) NOT NULL,
  `folio2` varchar(5) NOT NULL,
  `folio3` varchar(5) NOT NULL,
  `folio4` varchar(5) NOT NULL,
  `folio5` varchar(5) NOT NULL,
  `folio6` varchar(5) NOT NULL,
  `folio7` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `documento`
--

INSERT INTO `documento` (`id_documento`, `tipo`, `numero`, `tienda1`, `tienda2`, `tienda3`, `tienda4`, `tienda5`, `tienda6`, `tienda7`, `folio1`, `folio2`, `folio3`, `folio4`, `folio5`, `folio6`, `folio7`) VALUES
(1, 'factura', 0, '0', '0', '0', '0', '0', '0', 0, 'F003', 'F002', 'F003', 'F004', 'F005', 'F006', 'F007'),
(2, 'boleta', 0, '0', '0', '0', '0', '0', '0', 0, 'B003', 'B002', 'B003', 'B004', 'B005', 'B006', 'B007'),
(3, 'guia', 0, '0', '0', '0', '0', '0', '0', 0, 'T001', 'T002', 'T003', 'T004', 'T005', 'T006', 'T007'),
(4, 'remision', 0, '0', '0', '0', '0', '0', '0', 0, 'T001', 'T002', 'T003', 'T004', 'T005', 'T006', 'T007'),
(5, 'nota_debito', 0, '0', '0', '0', '0', '0', '0', 0, 'F003', 'F002', 'F003', 'F004', 'F005', 'F006', 'F007'),
(6, 'nota_credito', 0, '0', '0', '0', '0', '0', '0', 0, 'F003', 'F002', 'F003', 'F004', 'F005', 'F006', 'F007'),
(7, 'Resumen', 0, '0', '0', '0', '0', '0', '0', 0, 'F001', 'F002', 'F003', 'F004', 'F005', 'F006', 'F007'),
(8, 'cotizacion', 0, '0', '0', '0', '0', '0', '0', 0, 'C003', 'C002', 'C003', 'C004', 'C005', 'C006', 'C007'),
(9, 'nota_debito1', 0, '0', '0', '0', '0', '0', '0', 0, 'B003', 'B002', 'B003', 'B004', 'B005', 'B006', 'B007'),
(10, 'nota_credito', 0, '0', '0', '0', '0', '0', '0', 0, 'B003', 'B002', 'B003', 'B004', 'B005', 'B006', 'B007'),
(12, 'traslado', 0, '0', '0', '0', '0', '0', '0', 0, 'T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documentos_electronicos`
--

CREATE TABLE `documentos_electronicos` (
  `id_doc` int(10) NOT NULL,
  `ruc` int(11) NOT NULL,
  `obs` text DEFAULT NULL,
  `url_xml` text NOT NULL,
  `hash_cpe` text NOT NULL,
  `hash_cdr` text NOT NULL,
  `msj_sunat` text NOT NULL,
  `ruta_cdr` text NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `doc` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facturas`
--

CREATE TABLE `facturas` (
  `id_factura` int(11) NOT NULL,
  `numero_factura` varchar(30) NOT NULL,
  `fecha_factura` datetime NOT NULL,
  `cod_hash` varchar(40) NOT NULL,
  `doc_mod` varchar(20) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `baja` varchar(30) NOT NULL,
  `id_vendedor` int(11) NOT NULL,
  `condiciones` int(1) NOT NULL,
  `total_venta` decimal(7,2) NOT NULL,
  `deuda_total` decimal(7,2) NOT NULL,
  `estado_factura` text NOT NULL,
  `tienda` int(2) NOT NULL,
  `ven_com` int(2) NOT NULL,
  `activo` int(2) NOT NULL,
  `servicio` int(2) NOT NULL,
  `moneda` double NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `obs` varchar(200) NOT NULL,
  `cuenta1` decimal(7,3) NOT NULL,
  `fec_eli` date NOT NULL,
  `dias` int(2) NOT NULL,
  `folio` varchar(5) NOT NULL,
  `des` int(2) NOT NULL,
  `aceptado` varchar(100) NOT NULL,
  `resumen` int(2) NOT NULL,
  `motivo` varchar(10) NOT NULL,
  `tipo` int(2) NOT NULL,
  `turno` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `facturas`
--

INSERT INTO `facturas` (`id_factura`, `numero_factura`, `fecha_factura`, `cod_hash`, `doc_mod`, `id_cliente`, `baja`, `id_vendedor`, `condiciones`, `total_venta`, `deuda_total`, `estado_factura`, `tienda`, `ven_com`, `activo`, `servicio`, `moneda`, `nombre`, `obs`, `cuenta1`, `fec_eli`, `dias`, `folio`, `des`, `aceptado`, `resumen`, `motivo`, `tipo`, `turno`) VALUES
(5408, '1', '2021-12-05 02:33:50', '7mjR1QCej5LLHRd/cIgaraueO5g=', '1', 1, '0', 1, 1, '1.00', '0.00', '2', 1, 1, 1, 1, 1, '1', '0', '0.000', '2018-11-11', 0, 'B003', 1, 'Aceptada', 0, '0', 0, 'Mañana');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos`
--

CREATE TABLE `fotos` (
  `id_foto` int(10) NOT NULL,
  `nom_foto` varchar(30) NOT NULL,
  `archivo` text NOT NULL,
  `largo` varchar(10) NOT NULL,
  `ancho` varchar(10) NOT NULL,
  `ubi_pag` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `fotos`
--

INSERT INTO `fotos` (`id_foto`, `nom_foto`, `archivo`, `largo`, `ancho`, `ubi_pag`) VALUES
(15, 'logo', 'logo.jpg', '394', '102', 'logo'),
(18, 'Quienes somos', 'quienesomos.jpg', '360', '203', 'quienesomos'),
(20, 'mision', 'mision.jpg', '800', '600', 'fotomision'),
(22, 'vision', 'vision.jpg', '800', '600', 'fotovision'),
(23, 'slider1', 'fotoHRtLZR2r.jpg', '870', '421', 'slider1'),
(24, 'slider2', 'fotogMheCAPJ.jpg', '870', '421', 'slider2'),
(25, 'slider3', 'fotogc7lAaze.jpg', '870', '424', 'slider3'),
(26, 'nombre1', 'vision.jpg', '340', '340', 'fotovision');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guia`
--

CREATE TABLE `guia` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_doc` int(10) NOT NULL,
  `serie` varchar(4) NOT NULL,
  `guia` int(8) NOT NULL,
  `dir_par` varchar(100) NOT NULL,
  `dom_lleg` text NOT NULL,
  `cont_lleg` text NOT NULL,
  `tel_lleg` text NOT NULL,
  `fecha_lleg` date NOT NULL,
  `vehiculo` text NOT NULL,
  `inscripcion` text NOT NULL,
  `lic` text NOT NULL,
  `fecha` date NOT NULL,
  `CODMOTIVO_TRASLADO` varchar(2) NOT NULL,
  `MOTIVO_TRASLADO` varchar(10) NOT NULL,
  `PESO` decimal(10,3) NOT NULL,
  `NUMERO_PAQUETES` int(5) NOT NULL,
  `UBIGEO_DESTINO` varchar(10) NOT NULL,
  `UBIGEO_PARTIDA` varchar(10) NOT NULL,
  `NRO_DOCUMENTO_TRANSPORTE` int(11) NOT NULL,
  `RAZON_SOCIAL_TRANSPORTE` varchar(150) NOT NULL,
  `CODTIPO_TRANSPORTISTA` varchar(2) NOT NULL,
  `hash_cpe` varchar(100) NOT NULL,
  `cod_sunat` varchar(100) NOT NULL,
  `aceptado_guia` varchar(100) NOT NULL,
  `doc_guia` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `id_inventario` int(10) NOT NULL,
  `id_producto` int(10) NOT NULL,
  `usuario` int(4) NOT NULL,
  `fecha` datetime NOT NULL,
  `inventario` decimal(12,2) NOT NULL,
  `inv_ini` decimal(12,2) NOT NULL,
  `tienda` int(2) NOT NULL,
  `motivo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id_inventario`, `id_producto`, `usuario`, `fecha`, `inventario`, `inv_ini`, `tienda`, `motivo`) VALUES
(14, 13118, 1, '2022-03-11 11:14:39', '9.00', '8.00', 1, ''),
(15, 13118, 1, '2022-03-11 11:14:49', '8.00', '9.00', 1, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `laborales`
--

CREATE TABLE `laborales` (
  `id_laboral` int(10) NOT NULL,
  `cod_var` varchar(10) NOT NULL,
  `variables` text NOT NULL,
  `des_var` text NOT NULL,
  `col_var` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `laborales`
--

INSERT INTO `laborales` (`id_laboral`, `cod_var`, `variables`, `des_var`, `col_var`) VALUES
(1, 'DF', 'DESCANSO FISICO', 'DESCANSO FISICO', '#8080ff'),
(0, 'A', 'ASISTENCIA', 'ASISTENCIA', '#2E9AFE'),
(3, 'V', 'VACACIONES', 'VACACIONES', '#ffff00'),
(4, 'LM', 'LICENCIA MATERNIDAD', 'LICENCIA MATERNIDAD', '#0080c0'),
(5, 'DM', 'DESCANSO MEDICO', 'DESCANSO MEDICO', '#ff00ff');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lote`
--

CREATE TABLE `lote` (
  `id_lote` int(12) NOT NULL,
  `id_producto` int(12) NOT NULL,
  `fec_vto` date NOT NULL,
  `fec_fab` date NOT NULL,
  `lote` varchar(50) NOT NULL,
  `tienda` int(2) NOT NULL,
  `inicial` decimal(12,2) NOT NULL,
  `final` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `lote`
--

INSERT INTO `lote` (`id_lote`, `id_producto`, `fec_vto`, `fec_fab`, `lote`, `tienda`, `inicial`, `final`) VALUES
(46, 13118, '2023-09-20', '2021-12-23', '1', 1, '8.00', '8.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lote1`
--

CREATE TABLE `lote1` (
  `id_lote1` int(12) NOT NULL,
  `id_lote` int(12) NOT NULL,
  `fec_lote` datetime NOT NULL,
  `id_detalle` int(12) NOT NULL,
  `can_lote` decimal(12,2) NOT NULL,
  `pre_lote` decimal(12,2) NOT NULL,
  `tipo` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `lote1`
--

INSERT INTO `lote1` (`id_lote1`, `id_lote`, `fec_lote`, `id_detalle`, `can_lote`, `pre_lote`, `tipo`) VALUES
(69, 46, '2021-12-23 03:19:57', 0, '8.00', '0.00', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(10) NOT NULL,
  `id_pago` int(10) NOT NULL,
  `id_factura` int(10) NOT NULL,
  `pago` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `precios`
--

CREATE TABLE `precios` (
  `id_precios` int(12) NOT NULL,
  `id_producto` int(12) NOT NULL,
  `p1` decimal(12,2) NOT NULL,
  `p2` decimal(12,2) NOT NULL,
  `p3` decimal(12,2) NOT NULL,
  `c1` decimal(12,2) NOT NULL,
  `c2` decimal(12,2) NOT NULL,
  `c3` decimal(12,2) NOT NULL,
  `i1` decimal(12,2) NOT NULL,
  `i2` decimal(12,2) NOT NULL,
  `i3` decimal(12,2) NOT NULL,
  `s1` decimal(12,2) NOT NULL,
  `s2` decimal(12,2) NOT NULL,
  `s3` decimal(12,2) NOT NULL,
  `tienda` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `precios`
--

INSERT INTO `precios` (`id_precios`, `id_producto`, `p1`, `p2`, `p3`, `c1`, `c2`, `c3`, `i1`, `i2`, `i3`, `s1`, `s2`, `s3`, `tienda`) VALUES
(14, 13111, '1.00', '10.00', '100.00', '0.70', '7.00', '70.00', '1000.00', '0.00', '0.00', '1000.00', '0.00', '0.00', 1),
(15, 13117, '15.50', '0.00', '0.00', '12.50', '0.00', '0.00', '1.00', '0.00', '0.00', '1.00', '0.00', '0.00', 1),
(16, 13118, '19.50', '0.00', '0.00', '15.50', '0.00', '0.00', '8.00', '0.00', '0.00', '8.00', '0.00', '0.00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id_producto` int(11) NOT NULL,
  `codigo_producto` varchar(15) NOT NULL,
  `nombre_producto` text NOT NULL,
  `status_producto` tinyint(4) NOT NULL,
  `date_added` datetime NOT NULL,
  `precio_producto` decimal(7,2) NOT NULL,
  `costo_producto` decimal(7,2) NOT NULL,
  `mon_costo` decimal(4,2) NOT NULL,
  `mon_venta` int(2) NOT NULL,
  `des1` varchar(50) NOT NULL,
  `des2` varchar(50) NOT NULL,
  `des3` varchar(50) NOT NULL,
  `b1` decimal(12,2) NOT NULL,
  `b2` decimal(12,2) NOT NULL,
  `b3` decimal(12,2) NOT NULL,
  `b4` decimal(12,2) NOT NULL,
  `b5` decimal(12,2) NOT NULL,
  `b6` decimal(12,2) NOT NULL,
  `b7` decimal(12,2) NOT NULL,
  `cat_pro` int(2) NOT NULL,
  `pro_ser` int(2) NOT NULL,
  `foto1` varchar(100) NOT NULL,
  `foto2` varchar(100) NOT NULL,
  `foto3` varchar(100) NOT NULL,
  `foto4` varchar(100) NOT NULL,
  `web` int(2) NOT NULL,
  `pre_web` decimal(7,2) NOT NULL,
  `descripcion` text NOT NULL,
  `descripcion1` text NOT NULL,
  `megusta` int(10) NOT NULL,
  `nomegusta` int(10) NOT NULL,
  `valor2` decimal(7,2) NOT NULL,
  `valor3` decimal(7,2) NOT NULL,
  `und_pro` int(3) NOT NULL,
  `a1` decimal(12,2) NOT NULL,
  `a2` decimal(12,2) NOT NULL,
  `a3` decimal(12,2) NOT NULL,
  `a4` decimal(12,2) NOT NULL,
  `a5` decimal(12,2) NOT NULL,
  `a6` decimal(12,2) NOT NULL,
  `a7` decimal(12,2) NOT NULL,
  `min` decimal(10,2) NOT NULL,
  `barras` varchar(15) NOT NULL,
  `mon` decimal(10,2) NOT NULL,
  `c1` decimal(12,2) NOT NULL,
  `c2` decimal(12,2) NOT NULL,
  `c3` decimal(12,2) NOT NULL,
  `c4` decimal(12,2) NOT NULL,
  `c5` decimal(12,2) NOT NULL,
  `c6` decimal(12,2) NOT NULL,
  `c7` decimal(12,2) NOT NULL,
  `proveedor` varchar(300) NOT NULL,
  `blister` int(5) NOT NULL,
  `caja` int(5) NOT NULL,
  `p1` decimal(12,2) NOT NULL,
  `p2` decimal(12,2) NOT NULL,
  `bli` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id_producto`, `codigo_producto`, `nombre_producto`, `status_producto`, `date_added`, `precio_producto`, `costo_producto`, `mon_costo`, `mon_venta`, `des1`, `des2`, `des3`, `b1`, `b2`, `b3`, `b4`, `b5`, `b6`, `b7`, `cat_pro`, `pro_ser`, `foto1`, `foto2`, `foto3`, `foto4`, `web`, `pre_web`, `descripcion`, `descripcion1`, `megusta`, `nomegusta`, `valor2`, `valor3`, `und_pro`, `a1`, `a2`, `a3`, `a4`, `a5`, `a6`, `a7`, `min`, `barras`, `mon`, `c1`, `c2`, `c3`, `c4`, `c5`, `c6`, `c7`, `proveedor`, `blister`, `caja`, `p1`, `p2`, `bli`) VALUES
(13111, '1', 'producto prueba', 0, '2021-11-29 11:35:24', '1.00', '0.70', '1.00', 1, '', '', '', '1992.00', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', 1, 1, 'nuevo.jpg', 'nuevo.jpg', 'nuevo.jpg', 'nuevo.jpg', 0, '1.00', '', '', 0, 0, '0.00', '0.00', 1, '1.00', '1.00', '1.00', '1.00', '1.00', '1.00', '1.00', '40.00', '667079808905', '0.00', '0.70', '0.70', '0.70', '0.70', '0.70', '0.70', '0.70', '', 10, 100, '7.00', '70.00', 'docena');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resumen_documentos`
--

CREATE TABLE `resumen_documentos` (
  `id_resumen` int(10) NOT NULL,
  `numero` varchar(8) NOT NULL,
  `fecha` date NOT NULL,
  `aceptado_resumen` varchar(100) NOT NULL,
  `xml` varchar(30) NOT NULL,
  `ticket` varchar(20) NOT NULL,
  `hash_cpe` varchar(100) NOT NULL,
  `cod_sunat` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ruc`
--

CREATE TABLE `ruc` (
  `id` int(11) NOT NULL,
  `ruc` text NOT NULL,
  `nombre` text NOT NULL,
  `direccion` text NOT NULL,
  `departamento` text NOT NULL,
  `provincia` text NOT NULL,
  `distrito` text NOT NULL,
  `telefono` text NOT NULL,
  `email` text NOT NULL,
  `web` text NOT NULL,
  `rubro` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicio`
--

CREATE TABLE `servicio` (
  `id_servicio` int(10) NOT NULL,
  `id_cliente` int(10) NOT NULL,
  `user_id` int(10) NOT NULL,
  `doc_servicio` varchar(30) NOT NULL,
  `tienda` int(2) NOT NULL,
  `nom_ser` varchar(100) NOT NULL,
  `tipo` int(2) NOT NULL,
  `pre_ser` decimal(5,2) NOT NULL,
  `ade_ser` decimal(5,2) NOT NULL,
  `fecha` varchar(20) NOT NULL,
  `des_ser` text NOT NULL,
  `car1` varchar(200) NOT NULL,
  `car2` varchar(200) NOT NULL,
  `car3` varchar(200) NOT NULL,
  `car4` varchar(200) NOT NULL,
  `car5` varchar(200) NOT NULL,
  `car6` varchar(200) NOT NULL,
  `com_ser` text NOT NULL,
  `ter_ser` int(2) NOT NULL,
  `cancelado` int(2) NOT NULL,
  `telefono1` varchar(100) NOT NULL,
  `guia` varchar(100) NOT NULL,
  `tip_doc` int(2) NOT NULL,
  `activo` int(2) NOT NULL,
  `detalle` int(10) NOT NULL,
  `fecha_emision` datetime NOT NULL,
  `fecha_reparado` datetime NOT NULL,
  `saliente` datetime NOT NULL,
  `desechado` datetime NOT NULL,
  `aceptar_guia` int(2) NOT NULL,
  `reparado` int(2) NOT NULL,
  `entregado` int(10) NOT NULL,
  `id_reparado` int(10) NOT NULL,
  `id_entregado` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id_servicio` int(11) NOT NULL,
  `nom_servicio` text NOT NULL,
  `cod_servicio` varchar(10) NOT NULL,
  `pre_servicio` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sub_tipo`
--

CREATE TABLE `sub_tipo` (
  `id_sub_tipo` int(2) NOT NULL,
  `id_tipo` int(2) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `sub_tipo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sub_tipo`
--

INSERT INTO `sub_tipo` (`id_sub_tipo`, `id_tipo`, `nombre`, `sub_tipo`) VALUES
(1, 1, 'Laptop', 'Marca'),
(2, 1, 'Laptop', 'Modelo'),
(3, 1, 'Laptop', 'Nro Serie'),
(4, 1, 'Laptop', 'Procesador'),
(5, 1, 'Laptop', 'Memoria Ram'),
(6, 1, 'Laptop', 'Disco Duro'),
(7, 2, 'Computadora', 'Marca'),
(8, 2, 'Computadora', 'Modelo'),
(9, 2, 'Computadora', 'Placa'),
(10, 2, 'Computadora', 'Procesador'),
(11, 2, 'Computadora', 'Memoria Ram'),
(12, 2, 'Computadora', 'Disco Duro'),
(13, 3, 'Impresora', 'Tipo'),
(14, 3, 'Impresora', 'Marca'),
(15, 3, 'Impresora', 'Modelo'),
(16, 3, 'Impresora', 'Nro Serie'),
(17, 4, 'Monitor', 'Marca'),
(18, 4, 'Monitor', 'Modelo'),
(19, 4, 'Monitor', 'Nro Serie'),
(20, 4, 'Monitor', 'Tamaño de Pantalla');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursal`
--

CREATE TABLE `sucursal` (
  `id_sucursal` int(10) NOT NULL,
  `tienda` int(10) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `ruc` varchar(20) NOT NULL,
  `direccion` text NOT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(100) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `ubigeo` varchar(10) NOT NULL,
  `caja` int(2) NOT NULL,
  `dep_suc` varchar(100) NOT NULL,
  `pro_suc` varchar(100) NOT NULL,
  `dis_suc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `sucursal`
--

INSERT INTO `sucursal` (`id_sucursal`, `tienda`, `nombre`, `ruc`, `direccion`, `correo`, `telefono`, `foto`, `ubigeo`, `caja`, `dep_suc`, `pro_suc`, `dis_suc`) VALUES
(1, 1, 'Botica 1', '10334257199', 'DIRECCION DE LA BOTICA', '', '921164816', 'sucursal1.jpg', '', 1, 'LIMA', 'LIMA', 'LIMA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo`
--

CREATE TABLE `tipo` (
  `id_tipo` int(2) NOT NULL,
  `tipo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo`
--

INSERT INTO `tipo` (`id_tipo`, `tipo`) VALUES
(1, 'Laptops'),
(2, 'Computadoras'),
(3, 'Impresoras'),
(4, 'Monitores');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tmp`
--

CREATE TABLE `tmp` (
  `id_tmp` int(11) NOT NULL,
  `id_producto` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `cantidad_tmp` decimal(7,2) NOT NULL,
  `precio_tmp` double(8,2) DEFAULT NULL,
  `session_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tienda` decimal(7,2) NOT NULL,
  `fecha1` date NOT NULL,
  `fecha2` date NOT NULL,
  `lote` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `tmp`
--

INSERT INTO `tmp` (`id_tmp`, `id_producto`, `cantidad_tmp`, `precio_tmp`, `session_id`, `tienda`, `fecha1`, `fecha2`, `lote`) VALUES
(12296, '13111', '1.00', 7.00, 'dn48ahielnaktuhkolr7grl5p5', '2.00', '0000-00-00', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transferencia`
--

CREATE TABLE `transferencia` (
  `id_detalle` int(12) NOT NULL,
  `motivo` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `transferencia`
--

INSERT INTO `transferencia` (`id_detalle`, `motivo`) VALUES
(9399, 'Envio para distribuidor'),
(9400, 'Envio para distribuidor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ultimo`
--

CREATE TABLE `ultimo` (
  `id_ultimo` int(12) NOT NULL,
  `ultimo` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `ultimo`
--

INSERT INTO `ultimo` (`id_ultimo`, `ultimo`) VALUES
(34, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `und`
--

CREATE TABLE `und` (
  `id_und` int(2) NOT NULL,
  `nom_und` varchar(100) NOT NULL,
  `cod_und` varchar(4) NOT NULL,
  `xml_und` varchar(4) NOT NULL,
  `etiqueta` varchar(5) NOT NULL,
  `contiene` int(2) NOT NULL,
  `und1` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `und`
--

INSERT INTO `und` (`id_und`, `nom_und`, `cod_und`, `xml_und`, `etiqueta`, `contiene`, `und1`) VALUES
(1, 'UNIDAD                           ', '07', 'NIU', 'UND', 1, 1),
(2, 'BOBINAS                                               ', '', '4A', '', 1, 0),
(3, 'BALDE                                                 ', '', 'BJ', 'BAL', 1, 1),
(4, 'BARRILES                                              ', '10', 'BLL', 'BAR', 1, 1),
(5, 'BOLSA                                                 ', '', 'BG', 'BOL', 2, 1),
(6, 'BOTELLAS                                              ', '', 'BO', 'BOT', 1, 1),
(7, 'CAJA                                                  ', '12', 'BX', 'CAJA', 2, 1),
(8, 'CARTONES                                              ', '', 'CT', 'CAR', 1, 1),
(9, 'CENTIMETRO CUADRADO                                   ', '', 'CMK', 'CM2', 1, 0),
(10, 'CENTIMETRO CUBICO                                     ', '', 'CMQ', 'CM3', 1, 0),
(11, 'CENTIMETRO LINEAL                                     ', '', 'CMT', 'CM', 1, 0),
(12, 'CIENTO DE UNIDADES                                    ', '', 'CEN', '', 1, 0),
(13, 'CILINDRO                                              ', '', 'CY', 'CIL', 1, 1),
(14, 'CONOS                                                 ', '', 'CJ', 'CONO', 1, 0),
(15, 'DOCENA                                                ', '', 'DZN', 'DOC', 2, 1),
(16, 'DOCENA POR 10**6                                      ', '', 'DZP', 'DOC1', 1, 0),
(17, 'FARDO                                                 ', '', 'BE', 'FAR', 1, 0),
(18, 'GALON INGLES (4,545956L)', '', 'GLI', 'GAL', 1, 0),
(19, 'GRAMO                                                 ', '06', 'GRM', 'GRM', 1, 0),
(20, 'GRUESA                                                ', '', 'GRO', '', 1, 0),
(21, 'HECTOLITRO                                            ', '', 'HLT', 'HLT', 1, 0),
(22, 'HOJA                                                  ', '', 'LEF', 'HOJA ', 1, 1),
(23, 'JUEGO                                                 ', '', 'SET', '', 1, 0),
(24, 'KILOGRAMO                                             ', '01', 'KGM', 'KGM', 1, 0),
(25, 'KILOMETRO                                             ', '', 'KTM', 'KTM', 1, 0),
(26, 'KILOVATIO HORA                                        ', '', 'KWH', 'KWH', 1, 0),
(27, 'KIT                                                   ', '', 'KT', 'KIT', 1, 1),
(28, 'LATAS                                                 ', '11', 'CA', 'LAT', 1, 1),
(29, 'LIBRAS                                                ', '02', 'LBR', 'LBR', 1, 0),
(30, 'LITRO                                                 ', '08', 'LTR', 'LTR', 1, 0),
(31, 'MEGAWATT HORA                                         ', '', 'MWH', '', 1, 0),
(32, 'METRO                                                 ', '15', 'MTR', 'MTR', 1, 0),
(33, 'METRO CUADRADO                                        ', '', 'MTK', 'MTK', 1, 0),
(34, 'METRO CUBICO                                          ', '14', 'MTQ', 'MTQ', 1, 0),
(35, 'MILIGRAMOS                                            ', '', 'MGM', 'MGM', 1, 0),
(36, 'MILILITRO                                             ', '', 'MLT', 'MLT', 1, 0),
(37, 'MILIMETRO                                             ', '', 'MMT', 'MMT', 1, 0),
(38, 'MILIMETRO CUADRADO                                    ', '', 'MMK', 'MMK', 1, 0),
(39, 'MILIMETRO CUBICO                                      ', '', 'MMQ', 'MMQ', 1, 0),
(40, 'MILLARES                                              ', '13', 'MLL', 'MILL', 2, 0),
(41, 'MILLON DE UNIDADES                                    ', '', 'UM', '', 1, 0),
(42, 'ONZAS                                                 ', '', 'ONZ', 'ONZ', 1, 0),
(43, 'PALETAS                                               ', '', 'PF', 'PAL', 1, 0),
(44, 'PAQUETE                                               ', '', 'PK', 'PAQ', 1, 1),
(45, 'PAR                                                   ', '', 'PR', 'PAR', 2, 1),
(46, 'PIES                                                  ', '', 'FOT', 'PIES', 1, 0),
(47, 'PIES CUADRADOS                                        ', '', 'FTK', 'PIES2', 1, 0),
(48, 'PIES CUBICOS                                          ', '', 'FTQ', 'PIES3', 1, 0),
(49, 'PIEZAS                                                ', '', 'C62', 'PIEZ', 1, 0),
(50, 'PLACAS                                                ', '', 'PG', 'PLAC', 1, 0),
(51, 'PLIEGO                                                ', '', 'ST', 'PLI', 1, 0),
(52, 'PULGADAS                                              ', '', 'INH', 'PUL', 1, 0),
(53, 'RESMA                                                 ', '', 'RM', 'RES', 1, 0),
(54, 'TAMBOR                                                ', '', 'DR', '', 1, 0),
(55, 'TONELADA CORTA                                        ', '05', 'STN', 'STN', 1, 0),
(56, 'TONELADA LARGA                                        ', '03', 'LTN', 'LTN', 1, 0),
(57, 'TONELADAS                                             ', '04', 'TNE', 'TON', 1, 0),
(58, 'TUBOS                                                 ', '', 'TU', 'TUBO', 1, 1),
(59, 'UNIDAD (SERVICIOS) ', '', 'ZZ', 'SER', 1, 0),
(60, 'US GALON (3,7843 L)', '', 'GLL', 'GAL', 1, 0),
(61, 'YARDA                                                 ', '', 'YRD', 'YRD', 1, 0),
(62, 'YARDA CUADRADA                                        ', '', 'YDK', 'YDK', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL COMMENT 'auto incrementing user_id of each user, unique index',
  `nombres` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `clave` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  `hora` time NOT NULL,
  `user_email` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s email, unique',
  `date_added` datetime NOT NULL,
  `accesos` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `dni` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `domicilio` text COLLATE utf8_unicode_ci NOT NULL,
  `telefono` text COLLATE utf8_unicode_ci NOT NULL,
  `sucursal` int(2) NOT NULL,
  `foto` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `nombres`, `clave`, `user_name`, `hora`, `user_email`, `date_added`, `accesos`, `dni`, `domicilio`, `telefono`, `sucursal`, `foto`) VALUES
(1, 'Administrador', '123456', 'facweb', '08:00:00', 'admin@admin.com', '2016-05-21 15:06:00', '1.1.1.1.1..1.1.1.1.1.1.1.1.1.1.1.1.1.1.1..1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1.1......1.1', '41364119', 'domicilio', 'telefono', 1, 'usuario1.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(10) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `clave` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  ADD PRIMARY KEY (`id_asistencia`),
  ADD UNIQUE KEY `unico` (`unico`);

--
-- Indices de la tabla `baja_sunat`
--
ALTER TABLE `baja_sunat`
  ADD PRIMARY KEY (`id_baja`);

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id_caja`);

--
-- Indices de la tabla `carrito`
--
ALTER TABLE `carrito`
  ADD PRIMARY KEY (`id_carrito`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`),
  ADD UNIQUE KEY `nom_cat` (`nom_cat`);

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`id_comentario`);

--
-- Indices de la tabla `comprobante_pago`
--
ALTER TABLE `comprobante_pago`
  ADD PRIMARY KEY (`id_comprobante`);

--
-- Indices de la tabla `consultas`
--
ALTER TABLE `consultas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `contacto`
--
ALTER TABLE `contacto`
  ADD PRIMARY KEY (`id_contacto`);

--
-- Indices de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `datosempresa`
--
ALTER TABLE `datosempresa`
  ADD PRIMARY KEY (`id_emp`);

--
-- Indices de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `numero_cotizacion` (`numero_factura`,`id_producto`);

--
-- Indices de la tabla `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`id_documento`);

--
-- Indices de la tabla `documentos_electronicos`
--
ALTER TABLE `documentos_electronicos`
  ADD PRIMARY KEY (`id_doc`);

--
-- Indices de la tabla `facturas`
--
ALTER TABLE `facturas`
  ADD PRIMARY KEY (`id_factura`);

--
-- Indices de la tabla `fotos`
--
ALTER TABLE `fotos`
  ADD PRIMARY KEY (`id_foto`);

--
-- Indices de la tabla `guia`
--
ALTER TABLE `guia`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`id_inventario`);

--
-- Indices de la tabla `laborales`
--
ALTER TABLE `laborales`
  ADD PRIMARY KEY (`id_laboral`);

--
-- Indices de la tabla `lote`
--
ALTER TABLE `lote`
  ADD PRIMARY KEY (`id_lote`);

--
-- Indices de la tabla `lote1`
--
ALTER TABLE `lote1`
  ADD PRIMARY KEY (`id_lote1`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `precios`
--
ALTER TABLE `precios`
  ADD PRIMARY KEY (`id_precios`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `resumen_documentos`
--
ALTER TABLE `resumen_documentos`
  ADD PRIMARY KEY (`id_resumen`);

--
-- Indices de la tabla `ruc`
--
ALTER TABLE `ruc`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `servicio`
--
ALTER TABLE `servicio`
  ADD PRIMARY KEY (`id_servicio`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id_servicio`),
  ADD UNIQUE KEY `cod` (`cod_servicio`),
  ADD UNIQUE KEY `nom` (`nom_servicio`(10));

--
-- Indices de la tabla `sub_tipo`
--
ALTER TABLE `sub_tipo`
  ADD PRIMARY KEY (`id_sub_tipo`);

--
-- Indices de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  ADD PRIMARY KEY (`id_sucursal`);

--
-- Indices de la tabla `tipo`
--
ALTER TABLE `tipo`
  ADD PRIMARY KEY (`id_tipo`);

--
-- Indices de la tabla `tmp`
--
ALTER TABLE `tmp`
  ADD PRIMARY KEY (`id_tmp`);

--
-- Indices de la tabla `transferencia`
--
ALTER TABLE `transferencia`
  ADD PRIMARY KEY (`id_detalle`);

--
-- Indices de la tabla `ultimo`
--
ALTER TABLE `ultimo`
  ADD PRIMARY KEY (`id_ultimo`);

--
-- Indices de la tabla `und`
--
ALTER TABLE `und`
  ADD PRIMARY KEY (`id_und`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asistencia`
--
ALTER TABLE `asistencia`
  MODIFY `id_asistencia` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `baja_sunat`
--
ALTER TABLE `baja_sunat`
  MODIFY `id_baja` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id_caja` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `carrito`
--
ALTER TABLE `carrito`
  MODIFY `id_carrito` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=259;

--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `id_comentario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `consultas`
--
ALTER TABLE `consultas`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2239;

--
-- AUTO_INCREMENT de la tabla `contacto`
--
ALTER TABLE `contacto`
  MODIFY `id_contacto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cuentas`
--
ALTER TABLE `cuentas`
  MODIFY `id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `detalle_factura`
--
ALTER TABLE `detalle_factura`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9720;

--
-- AUTO_INCREMENT de la tabla `documento`
--
ALTER TABLE `documento`
  MODIFY `id_documento` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `documentos_electronicos`
--
ALTER TABLE `documentos_electronicos`
  MODIFY `id_doc` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `facturas`
--
ALTER TABLE `facturas`
  MODIFY `id_factura` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5409;

--
-- AUTO_INCREMENT de la tabla `fotos`
--
ALTER TABLE `fotos`
  MODIFY `id_foto` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `guia`
--
ALTER TABLE `guia`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `inventario`
--
ALTER TABLE `inventario`
  MODIFY `id_inventario` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `laborales`
--
ALTER TABLE `laborales`
  MODIFY `id_laboral` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `lote`
--
ALTER TABLE `lote`
  MODIFY `id_lote` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de la tabla `lote1`
--
ALTER TABLE `lote1`
  MODIFY `id_lote1` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `precios`
--
ALTER TABLE `precios`
  MODIFY `id_precios` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13119;

--
-- AUTO_INCREMENT de la tabla `resumen_documentos`
--
ALTER TABLE `resumen_documentos`
  MODIFY `id_resumen` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `ruc`
--
ALTER TABLE `ruc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12052;

--
-- AUTO_INCREMENT de la tabla `servicio`
--
ALTER TABLE `servicio`
  MODIFY `id_servicio` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id_servicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `sub_tipo`
--
ALTER TABLE `sub_tipo`
  MODIFY `id_sub_tipo` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `sucursal`
--
ALTER TABLE `sucursal`
  MODIFY `id_sucursal` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo`
--
ALTER TABLE `tipo`
  MODIFY `id_tipo` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `tmp`
--
ALTER TABLE `tmp`
  MODIFY `id_tmp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12313;

--
-- AUTO_INCREMENT de la tabla `transferencia`
--
ALTER TABLE `transferencia`
  MODIFY `id_detalle` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9401;

--
-- AUTO_INCREMENT de la tabla `ultimo`
--
ALTER TABLE `ultimo`
  MODIFY `id_ultimo` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `und`
--
ALTER TABLE `und`
  MODIFY `id_und` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto incrementing user_id of each user, unique index', AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
