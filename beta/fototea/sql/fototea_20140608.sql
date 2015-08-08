-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 07-06-2014 a las 23:54:54
-- Versión del servidor: 5.5.32-0ubuntu0.13.04.1
-- Versión de PHP: 5.4.9-4ubuntu2.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `fototea_fot`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE IF NOT EXISTS `tmp_project` (
  `pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_cod` varchar(250) COLLATE utf8_spanish_ci NOT NULL,
  `pro_tit` text COLLATE utf8_spanish_ci NOT NULL,
  `pro_descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `pro_budget` float DEFAULT NULL,
  `pro_date` datetime NOT NULL,
  `pro_date_end` datetime NOT NULL,
  `pro_cant` int(11) NOT NULL,
  `pro_length` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `pro_country` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `pro_state` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `pro_city` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `pro_address` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `pro_cp` int(11) NOT NULL,
  `pro_type` int(11) NOT NULL,
  `pro_category` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pro_status` varchar(2) COLLATE utf8_spanish_ci NOT NULL,
  `pro_cdate` datetime NOT NULL,
  PRIMARY KEY (`pro_id`),
  UNIQUE KEY `pro_cod` (`pro_cod`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci AUTO_INCREMENT=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


ALTER TABLE  `tmp_project` CHANGE  `user_id`  `user_id` INT( 11 ) NULL;

ALTER TABLE  `tmp_project` ADD  `pro_tmp_id` TEXT NOT NULL AFTER  `pro_id`