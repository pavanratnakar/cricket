/*
SQLyog Enterprise - MySQL GUI v8.18 
MySQL - 5.1.37 : Database - test
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`test` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `test`;

/*Table structure for table `fixture` */

DROP TABLE IF EXISTS `fixture`;

CREATE TABLE `fixture` (
  `match_id` int(11) NOT NULL,
  `match_team_1` int(11) DEFAULT NULL,
  `match_team_2` int(11) DEFAULT NULL,
  `match_winner` int(11) DEFAULT NULL,
  `match_type` int(11) DEFAULT NULL,
  `match_time` datetime DEFAULT NULL,
  PRIMARY KEY (`match_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `fixture` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
