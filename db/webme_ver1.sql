/*
SQLyog Ultimate v12.3.2 (64 bit)
MySQL - 10.1.21-MariaDB : Database - webme
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`webme` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `webme`;

/*Table structure for table `cms_page` */

DROP TABLE IF EXISTS `cms_page`;

CREATE TABLE `cms_page` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` text,
  `content` text NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_active` smallint(6) DEFAULT '1',
  `sort_order` smallint(6) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `cms_page` */

insert  into `cms_page`(`id`,`title`,`alias`,`description`,`content`,`updated_at`,`created_at`,`is_active`,`sort_order`) values 
(1,'page 1 ed nngg','page-1','content page 1','content page 1','2017-03-04 18:29:00','2017-02-28 22:38:53',1,0),
(2,'content 2','content-2','content 2','content 2','2017-03-03 23:31:07','2017-02-28 22:39:26',1,0),
(3,'tit edit','ali','des','con','2017-03-07 22:22:24','2017-03-06 22:57:40',0,0),
(4,'tit','ali','des','con','2017-03-07 22:17:06','2017-03-07 22:17:06',1,0);

/*Table structure for table `contact_message` */

DROP TABLE IF EXISTS `contact_message`;

CREATE TABLE `contact_message` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_show` smallint(6) DEFAULT '0',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `sort_order` smallint(6) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `contact_message` */

insert  into `contact_message`(`id`,`email`,`name`,`message`,`is_show`,`updated_at`,`created_at`,`sort_order`) values 
(1,'nam@ac.com','Nam Luu','hello',0,'2017-02-28 23:18:55','2017-02-28 23:18:55',0),
(2,'nam@ac.com','Nam Luu','hello',0,'2017-02-28 23:22:14','2017-02-28 23:22:14',0),
(3,'nam@ac.com','Nam Luu','test 2',0,'2017-03-01 22:01:23','2017-03-01 22:01:23',0),
(4,'nam@ac.com','Nam Luu','test 3',0,'2017-03-01 22:04:42','2017-03-01 22:04:42',0),
(5,'nam@ac.com','nam','nam',0,'2017-03-04 22:02:18','2017-03-04 22:02:18',0),
(6,'nam@ac.com','Nam Luu','abc',0,'2017-03-04 22:02:55','2017-03-04 22:02:55',0),
(7,'nam@ac.com','Nam Luu','aaa',0,'2017-03-04 22:03:38','2017-03-04 22:03:38',0),
(8,'nam@ac.com','aaa','aaaa',0,'2017-03-07 22:29:59','2017-03-07 22:29:59',0);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_active` smallint(6) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `user` */

/*Table structure for table `user_admin` */

DROP TABLE IF EXISTS `user_admin`;

CREATE TABLE `user_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `is_active` smallint(6) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `user_admin` */

insert  into `user_admin`(`id`,`username`,`password`,`email`,`role`,`is_active`) values 
(1,'namluu','6effcdc640d88b52ae80182a223ac0e4','namluu@ac.com','admin',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
