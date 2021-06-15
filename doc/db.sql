/*
SQLyog Ultimate v11.31 (32 bit)
MySQL - 10.1.37-MariaDB : Database - blankon_store
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `product3_attributes` */

DROP TABLE IF EXISTS `product3_attributes`;

CREATE TABLE `product3_attributes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` smallint(5) unsigned NOT NULL,
  `type_attribute_id` smallint(5) unsigned NOT NULL,
  `value` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `type_attribute_id` (`type_attribute_id`),
  CONSTRAINT `product3_attributes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product3_product` (`id`),
  CONSTRAINT `product3_attributes_ibfk_2` FOREIGN KEY (`type_attribute_id`) REFERENCES `product3_product_type_x_group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `product3_code_type` */

DROP TABLE IF EXISTS `product3_code_type`;

CREATE TABLE `product3_code_type` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `product3_codes` */

DROP TABLE IF EXISTS `product3_codes`;

CREATE TABLE `product3_codes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` smallint(5) unsigned NOT NULL,
  `type_id` tinyint(3) unsigned NOT NULL,
  `code` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product3_codes_ibfk_product` (`product_id`),
  KEY `product3_codes_ibfk_type` (`type_id`),
  CONSTRAINT `product3_codes_ibfk_product` FOREIGN KEY (`product_id`) REFERENCES `product3_product` (`id`),
  CONSTRAINT `product3_codes_ibfk_type` FOREIGN KEY (`type_id`) REFERENCES `product3_code_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `product3_input_type` */

DROP TABLE IF EXISTS `product3_input_type`;

CREATE TABLE `product3_input_type` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(30) CHARACTER SET utf8 DEFAULT NULL,
  `dictioanry_class` varchar(50) DEFAULT NULL,
  `validate_rule` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `product3_price_type` */

DROP TABLE IF EXISTS `product3_price_type`;

CREATE TABLE `product3_price_type` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `product3_product` */

DROP TABLE IF EXISTS `product3_product`;

CREATE TABLE `product3_product` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(256) CHARACTER SET utf8 DEFAULT NULL COMMENT 'Name',
  `description` text CHARACTER SET utf8 COMMENT 'Description',
  `unit_id` tinyint(3) unsigned DEFAULT NULL COMMENT 'Unit',
  `product_type_id` smallint(5) unsigned DEFAULT NULL COMMENT 'Type',
  PRIMARY KEY (`id`),
  KEY `product_type_id` (`product_type_id`),
  KEY `unit_id` (`unit_id`),
  CONSTRAINT `product3_product_ibfk_1` FOREIGN KEY (`product_type_id`) REFERENCES `product3_product_type` (`id`),
  CONSTRAINT `product3_product_ibfk_2` FOREIGN KEY (`unit_id`) REFERENCES `product3_unit` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `product3_product_group` */

DROP TABLE IF EXISTS `product3_product_group`;

CREATE TABLE `product3_product_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` smallint(5) unsigned NOT NULL,
  `group_id` smallint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `product3_product_group_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product3_product` (`id`),
  CONSTRAINT `product3_product_group_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `product_group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `product3_product_price` */

DROP TABLE IF EXISTS `product3_product_price`;

CREATE TABLE `product3_product_price` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` smallint(5) unsigned NOT NULL,
  `price_type_id` tinyint(3) unsigned NOT NULL,
  `price` decimal(12,4) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `price_type_id` (`price_type_id`),
  CONSTRAINT `product3_product_price_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product3_product` (`id`),
  CONSTRAINT `product3_product_price_ibfk_2` FOREIGN KEY (`price_type_id`) REFERENCES `product3_price_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `product3_product_type` */

DROP TABLE IF EXISTS `product3_product_type`;

CREATE TABLE `product3_product_type` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `unit_id` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `unit_id` (`unit_id`),
  CONSTRAINT `product3_product_type_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `product3_unit` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `product3_product_type_x_group` */

DROP TABLE IF EXISTS `product3_product_type_x_group`;

CREATE TABLE `product3_product_type_x_group` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `product_type_id` smallint(5) unsigned NOT NULL,
  `group_id` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_type_id` (`product_type_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `product3_product_type_x_group_ibfk_1` FOREIGN KEY (`product_type_id`) REFERENCES `product3_product_type` (`id`),
  CONSTRAINT `product3_product_type_x_group_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `product_group` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `product3_type_attributes` */

DROP TABLE IF EXISTS `product3_type_attributes`;

CREATE TABLE `product3_type_attributes` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `product_type_id` smallint(5) unsigned NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `input_type_id` tinyint(5) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `input_type_id` (`input_type_id`),
  KEY `product_type_id` (`product_type_id`),
  CONSTRAINT `product3_type_attributes_ibfk_1` FOREIGN KEY (`input_type_id`) REFERENCES `product3_input_type` (`id`),
  CONSTRAINT `product3_type_attributes_ibfk_2` FOREIGN KEY (`product_type_id`) REFERENCES `product3_product_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `product3_unit` */

DROP TABLE IF EXISTS `product3_unit`;

CREATE TABLE `product3_unit` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `code` char(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
