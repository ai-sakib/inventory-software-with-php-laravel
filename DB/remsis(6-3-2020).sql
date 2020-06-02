/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.4.8-MariaDB : Database - remsis
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `admin_roles` */

DROP TABLE IF EXISTS `admin_roles`;

CREATE TABLE `admin_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `admin_roles` */

insert  into `admin_roles`(`id`,`name`,`status`,`created_at`,`updated_at`,`created_by`) values (1,'Super Admin',1,'2020-04-11 10:11:07','2020-04-11 10:11:07',3),(2,'Sub Admin',1,'2020-04-11 11:22:54','2020-04-11 11:22:54',4),(3,'Employee',1,'2020-04-12 11:58:06','2020-04-12 11:58:06',1);

/*Table structure for table `customers` */

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(91) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tax` double DEFAULT 0,
  `uid` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(91) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `customers` */

insert  into `customers`(`id`,`name`,`tax`,`uid`,`address`,`phone`,`email`,`image`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`) values (2,'Mithun',0,'c-00000001','Mirpur Shagufta Office Plot 503, Road 05, Block A','017*******','mithun@gmail.com','2-20200408172522.jpg',1,'2020-04-14 20:51:23','2020-04-14 14:51:23',NULL,NULL),(3,'Saurav Ganguly',5,'c-00000001','N/A','1111','saurav@gmail.com','3-20200410063209.jpg',1,'2020-04-15 00:52:38','2020-04-14 18:52:38',NULL,NULL);

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `item_categories` */

DROP TABLE IF EXISTS `item_categories`;

CREATE TABLE `item_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(91) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `item_categories` */

insert  into `item_categories`(`id`,`name`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`) values (2,'Goods',1,'2020-04-14 01:06:33','2020-04-13 19:06:33',NULL,NULL),(3,'Biscuits',1,'2020-05-09 14:12:39','2020-05-09 08:12:39',NULL,NULL);

/*Table structure for table `items` */

DROP TABLE IF EXISTS `items`;

CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(91) COLLATE utf8_unicode_ci DEFAULT NULL,
  `uid` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `details` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `retail_price` double DEFAULT NULL,
  `wholesale_price` double DEFAULT NULL,
  `purchase_price` double DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `items` */

insert  into `items`(`id`,`name`,`uid`,`category_id`,`details`,`retail_price`,`wholesale_price`,`purchase_price`,`image`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`) values (1,'iPhone 6','i-00000001',2,'This is excellent!',100,90,60,'1-20200212200343.jpg',1,'2020-04-08 16:20:36','2020-04-08 10:20:36',NULL,NULL),(4,'Britol Buiscuit','i-00000002',3,'Nice',100,70,30,'4-20200313101057.jpg',1,'2020-03-14 23:29:25','2020-03-15 06:29:25',NULL,NULL),(5,'Olympic','i-00000003',3,'Nice  All!',10,8,5,'5-20200313101023.jpg',1,'2020-04-08 16:19:50','2020-04-08 10:19:50',NULL,NULL),(6,'iPad Pro','i-00000004',2,'Nice all !',60000,50000,30000,'6-20200414162214.jpg',1,'2020-04-14 22:22:14','2020-04-14 16:22:14',NULL,NULL);

/*Table structure for table `locations` */

DROP TABLE IF EXISTS `locations`;

CREATE TABLE `locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(91) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `locations` */

insert  into `locations`(`id`,`name`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`) values (2,'Uttara',1,'2020-04-09 00:03:07','2020-04-08 18:03:07',1,NULL),(3,'Mirpur',1,'2020-04-12 15:58:29','2020-04-12 09:58:29',NULL,NULL),(4,'Mirpur DOHS',1,'2020-04-09 18:31:11','2020-04-09 12:31:11',NULL,NULL),(5,'Pallabi',1,'2020-04-09 18:31:12','2020-04-09 12:31:12',NULL,NULL),(6,'Mohammadpur',1,'2020-04-12 15:58:28','2020-04-12 09:58:28',NULL,NULL);

/*Table structure for table `main_menu_permission` */

DROP TABLE IF EXISTS `main_menu_permission`;

CREATE TABLE `main_menu_permission` (
  `id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `main_menu_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `main_menu_permission` */

insert  into `main_menu_permission`(`id`,`role_id`,`main_menu_id`) values (21,1,1),(22,1,2),(23,1,3),(24,1,7),(25,1,8),(26,1,6),(27,3,1),(28,3,8),(29,3,6),(30,2,1),(31,2,2),(32,2,3),(33,2,7),(34,2,8),(35,2,6);

/*Table structure for table `main_menus` */

DROP TABLE IF EXISTS `main_menus`;

CREATE TABLE `main_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serial_no` int(11) DEFAULT NULL,
  `name` varchar(33) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(22) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `main_menus` */

insert  into `main_menus`(`id`,`serial_no`,`name`,`icon`,`status`) values (1,1,'Modules','fas fa-cog',0),(2,5,'Stock In','fa fa-home',1),(3,10,'Stock Out','fas fa-user',1),(4,20,'Developers','fa fa-desktop',1),(5,15,'Admin','fa fa-user',1),(6,14,'Stock Status','fa fa-bell',1),(7,11,'Transfer','fas fa-exchange-alt',1),(8,12,'Adjustment','fa fa-adjust',1);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1);

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

insert  into `password_resets`(`email`,`token`,`created_at`) values ('sakib2439@gmail.com','$2y$10$oaL0xUcfmfCkrGPrtkfNSOuBi3xTtnKUaqFWdgAhjgGD87Q9dOgeW','2020-04-10 06:08:29');

/*Table structure for table `prices` */

DROP TABLE IF EXISTS `prices`;

CREATE TABLE `prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `retail_price` double DEFAULT NULL,
  `wholesale_price` double DEFAULT NULL,
  `purchase_price` double DEFAULT NULL,
  `effective_date` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `prices` */

insert  into `prices`(`id`,`item_id`,`retail_price`,`wholesale_price`,`purchase_price`,`effective_date`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`) values (1,1,100,80,50,NULL,1,'2020-02-15 19:27:22','2020-02-15 19:27:22',NULL,NULL),(2,1,100,90,60,NULL,1,'2020-02-15 19:27:58','2020-02-15 19:27:58',NULL,NULL),(3,4,100,70,30,NULL,1,'2020-03-12 19:52:31','2020-03-12 19:52:31',NULL,NULL),(4,5,10,8,5,NULL,1,'2020-03-13 10:10:23','2020-03-13 10:10:23',NULL,NULL),(5,4,100,70,30,NULL,1,'2020-03-13 10:10:57','2020-03-13 10:10:57',NULL,NULL),(6,5,10,8,5,NULL,1,'2020-03-20 08:46:41','2020-03-20 08:46:41',NULL,NULL),(7,5,10,8,5,NULL,1,'2020-04-08 16:59:17','2020-04-08 16:59:17',NULL,NULL),(8,5,10,8,5,NULL,1,'2020-04-08 17:00:31','2020-04-08 17:00:31',NULL,NULL),(9,5,10,8,5,NULL,1,'2020-04-08 17:02:48','2020-04-08 17:02:48',NULL,NULL),(10,6,60000,50000,30000,NULL,1,'2020-04-14 16:21:40','2020-04-14 16:21:40',NULL,NULL),(11,6,60000,50000,30000,NULL,1,'2020-04-14 16:22:14','2020-04-14 16:22:14',NULL,NULL);

/*Table structure for table `project` */

DROP TABLE IF EXISTS `project`;

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `logo` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `project` */

insert  into `project`(`id`,`name`,`email`,`phone`,`address`,`logo`) values (1,'REMSIS','office@remsis.com','017********','Hello !','REMSIS-20200321175008.png');

/*Table structure for table `sales_types` */

DROP TABLE IF EXISTS `sales_types`;

CREATE TABLE `sales_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(91) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `sales_types` */

insert  into `sales_types`(`id`,`name`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`) values (1,'Retail',1,'2020-02-16 01:39:06','0000-00-00 00:00:00',NULL,NULL),(2,'Wholesale',1,'2020-02-16 01:39:18','0000-00-00 00:00:00',NULL,NULL);

/*Table structure for table `stock_in` */

DROP TABLE IF EXISTS `stock_in`;

CREATE TABLE `stock_in` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `supplier_id` int(11) DEFAULT NULL,
  `stock_in_date` date DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `tax` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `paid` double DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `remarks` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `stock_in` */

insert  into `stock_in`(`id`,`supplier_id`,`stock_in_date`,`location_id`,`total_price`,`tax`,`discount`,`paid`,`status`,`remarks`,`created_by`,`updated_by`) values (1,2,'2020-03-13',3,NULL,NULL,NULL,0,1,'Nice All !',NULL,NULL),(2,2,'2020-03-13',3,NULL,NULL,NULL,0,1,'Nice !',NULL,NULL),(3,2,'2020-03-11',3,90,NULL,NULL,0,1,'Nice !',NULL,NULL),(4,2,'2020-03-13',2,215,NULL,NULL,0,1,NULL,NULL,NULL),(5,2,'2020-03-10',3,90,NULL,NULL,0,1,NULL,NULL,NULL),(6,2,'2020-03-12',2,60,NULL,NULL,0,1,NULL,NULL,NULL),(7,2,'2020-03-14',2,65,NULL,NULL,0,1,NULL,NULL,NULL),(8,2,'2020-03-14',3,30,NULL,NULL,0,1,NULL,NULL,NULL),(9,2,'2020-03-17',3,9500,NULL,NULL,0,1,NULL,NULL,NULL),(10,2,'2020-03-17',2,9500,NULL,NULL,0,1,NULL,NULL,NULL),(11,2,'2020-03-19',5,9700,NULL,NULL,0,1,NULL,NULL,NULL),(12,2,'2020-03-24',3,5,NULL,NULL,0,1,NULL,NULL,NULL),(13,2,'2020-04-02',5,5,NULL,NULL,5,1,NULL,NULL,NULL),(14,2,'2020-04-04',5,5,NULL,NULL,5,1,NULL,NULL,NULL),(15,2,'2020-04-09',6,5,NULL,NULL,5,1,NULL,NULL,NULL),(16,2,'2020-04-09',6,125,NULL,NULL,125,1,NULL,NULL,NULL),(17,2,'2020-04-14',6,9500,NULL,NULL,9500,1,NULL,NULL,NULL),(18,3,'2020-04-15',6,20.6,2,10,20.6,1,NULL,NULL,NULL);

/*Table structure for table `stock_in_details` */

DROP TABLE IF EXISTS `stock_in_details`;

CREATE TABLE `stock_in_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_in_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `stock_in_details` */

insert  into `stock_in_details`(`id`,`stock_in_id`,`item_id`,`quantity`,`price`,`created_by`,`updated_by`) values (1,1,4,1,30,NULL,NULL),(2,1,1,1,60,NULL,NULL),(3,2,1,1,60,NULL,NULL),(4,2,4,1,30,NULL,NULL),(5,3,4,1,30,NULL,NULL),(6,3,1,1,60,NULL,NULL),(7,4,4,1,30,NULL,NULL),(8,4,5,1,5,NULL,NULL),(9,4,1,3,60,NULL,NULL),(10,5,4,1,30,NULL,NULL),(11,5,1,1,60,NULL,NULL),(12,6,1,1,60,NULL,NULL),(13,7,5,1,5,NULL,NULL),(14,7,1,1,60,NULL,NULL),(15,8,4,1,30,NULL,NULL),(16,9,5,100,5,NULL,NULL),(17,9,4,100,30,NULL,NULL),(18,9,1,100,60,NULL,NULL),(19,10,5,100,5,NULL,NULL),(20,10,4,100,30,NULL,NULL),(21,10,1,100,60,NULL,NULL),(22,11,5,100,5,NULL,NULL),(23,11,1,100,60,NULL,NULL),(24,11,4,100,32,NULL,NULL),(25,12,5,1,5,NULL,NULL),(26,13,5,1,5,NULL,NULL),(27,14,5,1,5,NULL,NULL),(28,15,5,1,5,NULL,NULL),(29,16,5,1,5,NULL,NULL),(30,16,4,4,30,NULL,NULL),(31,17,5,100,5,NULL,NULL),(32,17,4,100,30,NULL,NULL),(33,17,1,100,60,NULL,NULL),(34,18,4,1,30,NULL,NULL);

/*Table structure for table `stock_moves` */

DROP TABLE IF EXISTS `stock_moves`;

CREATE TABLE `stock_moves` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `trans_no` int(11) DEFAULT NULL,
  `stock_type` int(11) DEFAULT NULL,
  `from_location_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `stock_move_date` datetime DEFAULT NULL,
  `price` double DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `stock_moves` */

insert  into `stock_moves`(`id`,`item_id`,`trans_no`,`stock_type`,`from_location_id`,`location_id`,`quantity`,`stock_move_date`,`price`,`created_by`,`updated_by`) values (1,4,1,1,NULL,3,1,'2020-03-13 00:00:00',30,NULL,NULL),(2,1,1,1,NULL,3,1,'2020-03-13 00:00:00',60,NULL,NULL),(3,1,2,1,NULL,3,1,'2020-03-13 00:00:00',60,NULL,NULL),(4,4,2,1,NULL,3,1,'2020-03-13 00:00:00',30,NULL,NULL),(5,4,3,1,NULL,3,1,'2020-03-11 00:00:00',30,NULL,NULL),(6,1,3,1,NULL,3,1,'2020-03-11 00:00:00',60,NULL,NULL),(7,4,4,1,NULL,2,1,'2020-03-13 00:00:00',30,NULL,NULL),(8,5,4,1,NULL,2,1,'2020-03-13 00:00:00',5,NULL,NULL),(9,1,4,1,NULL,2,3,'2020-03-13 00:00:00',60,NULL,NULL),(10,4,5,1,NULL,3,1,'2020-03-10 00:00:00',30,NULL,NULL),(11,1,5,1,NULL,3,1,'2020-03-10 00:00:00',60,NULL,NULL),(12,1,6,1,NULL,2,1,'2020-03-12 00:00:00',60,NULL,NULL),(13,5,7,1,NULL,2,1,'2020-03-14 00:00:00',5,NULL,NULL),(14,1,7,1,NULL,2,1,'2020-03-14 00:00:00',60,NULL,NULL),(15,4,8,1,NULL,3,1,'2020-03-14 00:00:00',30,NULL,NULL),(16,5,2,2,NULL,3,-1,'1970-01-01 00:00:00',8,NULL,NULL),(17,1,3,2,NULL,3,-1,'1970-01-01 00:00:00',90,NULL,NULL),(18,5,4,2,NULL,3,-1,'1970-01-01 00:00:00',8,NULL,NULL),(19,4,4,2,NULL,3,-3,'1970-01-01 00:00:00',70,NULL,NULL),(20,1,4,2,NULL,3,-2,'1970-01-01 00:00:00',90,NULL,NULL),(21,5,9,1,NULL,3,100,'2020-03-17 00:00:00',5,NULL,NULL),(22,4,9,1,NULL,3,100,'2020-03-17 00:00:00',30,NULL,NULL),(23,1,9,1,NULL,3,100,'2020-03-17 00:00:00',60,NULL,NULL),(24,5,10,1,NULL,2,100,'2020-03-17 00:00:00',5,NULL,NULL),(25,4,10,1,NULL,2,100,'2020-03-17 00:00:00',30,NULL,NULL),(26,1,10,1,NULL,2,100,'2020-03-17 00:00:00',60,NULL,NULL),(27,5,11,1,NULL,5,100,'2020-03-19 00:00:00',5,NULL,NULL),(28,1,11,1,NULL,5,100,'2020-03-19 00:00:00',60,NULL,NULL),(29,4,11,1,NULL,5,100,'2020-03-19 00:00:00',32,NULL,NULL),(30,5,1,3,NULL,3,-1,'1970-01-01 00:00:00',NULL,NULL,NULL),(31,5,1,3,NULL,5,1,'1970-01-01 00:00:00',NULL,NULL,NULL),(32,1,2,3,NULL,5,-10,'1970-01-01 00:00:00',NULL,NULL,NULL),(33,1,2,3,NULL,4,10,'1970-01-01 00:00:00',NULL,NULL,NULL),(34,4,2,3,NULL,5,-10,'1970-01-01 00:00:00',NULL,NULL,NULL),(35,4,2,3,NULL,4,10,'1970-01-01 00:00:00',NULL,NULL,NULL),(36,5,12,1,NULL,3,1,'2020-03-24 00:00:00',5,NULL,NULL),(37,5,3,3,NULL,5,-10,'1970-01-01 00:00:00',NULL,NULL,NULL),(38,5,3,3,5,4,10,'1970-01-01 00:00:00',NULL,NULL,NULL),(39,1,3,3,NULL,5,-90,'1970-01-01 00:00:00',NULL,NULL,NULL),(40,1,3,3,5,4,90,'1970-01-01 00:00:00',NULL,NULL,NULL),(41,4,3,3,NULL,5,-90,'1970-01-01 00:00:00',NULL,NULL,NULL),(42,4,3,3,5,4,90,'1970-01-01 00:00:00',NULL,NULL,NULL),(43,5,13,1,NULL,5,1,'2020-04-02 00:00:00',5,NULL,NULL),(44,5,4,3,NULL,5,-1,'2020-04-02 00:00:00',NULL,NULL,NULL),(45,5,4,3,5,4,1,'2020-04-02 00:00:00',NULL,NULL,NULL),(46,5,1,4,NULL,5,-1,'2020-04-03 00:00:00',NULL,NULL,NULL),(47,5,2,4,NULL,5,4,'2020-04-03 00:00:00',NULL,NULL,NULL),(48,5,3,4,NULL,4,1,'2020-04-04 00:00:00',NULL,NULL,NULL),(49,5,14,1,NULL,5,1,'2020-04-04 00:00:00',5,NULL,NULL),(50,5,5,2,NULL,5,-1,'1970-01-01 00:00:00',10,NULL,NULL),(51,5,5,3,NULL,5,-1,'2020-04-05 00:00:00',NULL,NULL,NULL),(52,5,5,3,5,3,1,'2020-04-05 00:00:00',NULL,NULL,NULL),(53,5,15,1,NULL,6,1,'2020-04-09 00:00:00',5,NULL,NULL),(54,5,16,1,NULL,6,1,'2020-04-09 00:00:00',5,NULL,NULL),(55,4,16,1,NULL,6,4,'2020-04-09 00:00:00',30,NULL,NULL),(56,5,4,4,NULL,6,-1,'2020-04-09 00:00:00',NULL,NULL,NULL),(57,5,6,2,NULL,4,-1,'1970-01-01 00:00:00',10,NULL,NULL),(58,5,6,3,NULL,5,-1,'2020-04-12 00:00:00',NULL,NULL,NULL),(59,5,6,3,5,6,1,'2020-04-12 00:00:00',NULL,NULL,NULL),(60,5,5,4,NULL,6,1,'2020-04-12 00:00:00',NULL,NULL,NULL),(61,5,6,4,NULL,6,-1,'2020-04-13 00:00:00',NULL,NULL,NULL),(62,5,7,2,NULL,6,-1,'1970-01-01 00:00:00',10,NULL,NULL),(63,4,7,2,NULL,6,-1,'1970-01-01 00:00:00',100,NULL,NULL),(64,5,8,2,NULL,4,-1,'1970-01-01 00:00:00',10,NULL,NULL),(65,4,8,2,NULL,4,-1,'1970-01-01 00:00:00',100,NULL,NULL),(66,1,8,2,NULL,4,-2,'1970-01-01 00:00:00',100,NULL,NULL),(67,5,9,2,NULL,6,-1,'1970-01-01 00:00:00',10,NULL,NULL),(68,4,9,2,NULL,6,-1,'1970-01-01 00:00:00',100,NULL,NULL),(69,5,10,2,NULL,4,-1,'1970-01-01 00:00:00',10,NULL,NULL),(70,4,10,2,NULL,4,-1,'1970-01-01 00:00:00',100,NULL,NULL),(71,4,11,2,NULL,6,-1,'1970-01-01 00:00:00',100,NULL,NULL),(72,5,12,2,NULL,4,-7,'1970-01-01 00:00:00',10,NULL,NULL),(73,5,17,1,NULL,6,100,'2020-04-14 00:00:00',5,NULL,NULL),(74,4,17,1,NULL,6,100,'2020-04-14 00:00:00',30,NULL,NULL),(75,1,17,1,NULL,6,100,'2020-04-14 00:00:00',60,NULL,NULL),(76,5,13,2,NULL,6,-1,'1970-01-01 00:00:00',10,NULL,NULL),(77,4,14,2,NULL,6,-1,'1970-01-01 00:00:00',100,NULL,NULL),(78,5,15,2,NULL,6,-1,'1970-01-01 00:00:00',10,NULL,NULL),(79,4,18,1,NULL,6,1,'2020-04-15 00:00:00',30,NULL,NULL);

/*Table structure for table `stock_out` */

DROP TABLE IF EXISTS `stock_out`;

CREATE TABLE `stock_out` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `sales_type_id` int(11) DEFAULT NULL,
  `stock_out_date` datetime DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `total_price` double DEFAULT NULL,
  `tax` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `paid` double DEFAULT NULL,
  `remarks` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `stock_out` */

insert  into `stock_out`(`id`,`customer_id`,`sales_type_id`,`stock_out_date`,`location_id`,`total_price`,`tax`,`discount`,`paid`,`remarks`,`created_by`,`updated_by`) values (1,2,NULL,'2020-03-14 00:00:00',NULL,NULL,NULL,NULL,0,'Nice',NULL,NULL),(2,2,NULL,'2020-03-14 00:00:00',NULL,8,NULL,NULL,8,'Nice',NULL,NULL),(3,2,2,'2020-03-14 00:00:00',3,90,NULL,NULL,90,'Nice !',NULL,NULL),(4,2,2,'2020-03-14 00:00:00',3,398,NULL,NULL,398,'Nice All !',NULL,NULL),(5,2,1,'2020-04-05 00:00:00',5,10,NULL,NULL,10,NULL,NULL,NULL),(6,2,1,'2020-04-10 00:00:00',4,10,NULL,NULL,10,NULL,NULL,NULL),(7,3,1,'2020-04-13 00:00:00',6,110,5,10,110,'HEllo !',NULL,NULL),(8,3,1,'2020-04-13 00:00:00',4,315.5,5,10,315.5,NULL,NULL,NULL),(9,3,1,'2020-04-13 00:00:00',6,105.5,5,10,105.5,NULL,1,NULL),(10,3,1,'2020-04-14 00:00:00',4,115.5,5,0,115.5,NULL,1,NULL),(11,3,1,'2020-04-14 00:00:00',6,105,5,0,105,NULL,1,NULL),(12,3,1,'2020-04-14 00:00:00',4,73.5,5,0,73.5,NULL,1,NULL),(13,3,1,'2020-04-14 00:00:00',6,10.5,5,0,10.5,NULL,1,NULL),(14,2,1,'2020-04-14 00:00:00',6,100,0,0,100,NULL,1,NULL),(15,3,1,'2020-04-15 00:00:00',6,9.5,5,1,9.5,NULL,1,NULL);

/*Table structure for table `stock_out_details` */

DROP TABLE IF EXISTS `stock_out_details`;

CREATE TABLE `stock_out_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stock_out_id` int(11) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` double DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `stock_out_details` */

insert  into `stock_out_details`(`id`,`stock_out_id`,`item_id`,`quantity`,`price`,`created_by`,`updated_by`) values (1,1,5,1,8,NULL,NULL),(2,2,5,1,8,NULL,NULL),(3,3,1,1,90,NULL,NULL),(4,4,5,1,8,NULL,NULL),(5,4,4,3,70,NULL,NULL),(6,4,1,2,90,NULL,NULL),(7,5,5,1,10,NULL,NULL),(8,6,5,1,10,NULL,NULL),(9,7,5,1,10,NULL,NULL),(10,7,4,1,100,NULL,NULL),(11,8,5,1,10,NULL,NULL),(12,8,4,1,100,NULL,NULL),(13,8,1,2,100,NULL,NULL),(14,9,5,1,10,NULL,NULL),(15,9,4,1,100,NULL,NULL),(16,10,5,1,10,NULL,NULL),(17,10,4,1,100,NULL,NULL),(18,11,4,1,100,NULL,NULL),(19,12,5,7,10,NULL,NULL),(20,13,5,1,10,NULL,NULL),(21,14,4,1,100,NULL,NULL),(22,15,5,1,10,NULL,NULL);

/*Table structure for table `sub_menu_permission` */

DROP TABLE IF EXISTS `sub_menu_permission`;

CREATE TABLE `sub_menu_permission` (
  `id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `sub_menu_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `sub_menu_permission` */

insert  into `sub_menu_permission`(`id`,`role_id`,`sub_menu_id`) values (49,1,1),(50,1,2),(51,1,3),(52,1,4),(53,1,5),(54,1,6),(55,1,7),(56,1,8),(57,1,9),(58,1,16),(59,1,17),(60,1,18),(61,1,19),(62,1,14),(63,1,15),(64,3,1),(65,3,2),(66,3,3),(67,3,4),(68,3,5),(69,3,18),(70,3,19),(71,3,14),(72,3,15),(73,2,1),(74,2,2),(75,2,3),(76,2,4),(77,2,5),(78,2,6),(79,2,7),(80,2,8),(81,2,9),(82,2,16),(83,2,17),(84,2,18),(85,2,19),(86,2,14),(87,2,15);

/*Table structure for table `sub_menus` */

DROP TABLE IF EXISTS `sub_menus`;

CREATE TABLE `sub_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serial_no` int(11) DEFAULT NULL,
  `main_menu_id` int(11) DEFAULT NULL,
  `name` varchar(33) COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(33) COLLATE utf8_unicode_ci DEFAULT NULL,
  `icon` varchar(22) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `sub_menus` */

insert  into `sub_menus`(`id`,`serial_no`,`main_menu_id`,`name`,`link`,`icon`,`status`) values (1,1,1,'Location','locations','fa fa-home',1),(2,5,1,'Item Category','item-categories','fa fa-home',1),(3,10,1,'Items','items','fa fa-home',1),(4,15,1,'Customers','customers','fa fa-home',1),(5,20,1,'Suppliers','suppliers','fa fa-home',1),(6,5,2,'Stock In','stock-in','fa fa-home',1),(7,10,2,'Stock In Lists','stock-in-lists','fa fa-home',1),(8,5,3,'Stock Out','stock-out','fa fa-home',1),(9,10,3,'Stock Out Lists','stock-out-lists','fa fa-home',1),(10,5,4,'Main Menu','main-menu','fa fa-home',1),(12,10,4,'Sub Menu','sub-menu','fa fa-home',1),(13,20,5,'Project Details','project','fa fa-tasks',1),(14,5,6,'Location Wise','location-wise-stock-status','fa fa-home',1),(15,10,6,'Product Wise','product-wise-stock-status','fa fa-home',1),(16,5,7,'Transfer','transfer','fa fa-home',1),(17,10,7,'History','transfers-history','fa fa-home',1),(18,5,8,'Adjust Products','adjust-products','fa fa-home',1),(19,10,8,'History','adjustment-history','fa fa-home',1),(20,25,5,'Change Password','change-password','fa fa-home',1),(21,10,5,'Admin Roles','admin-roles','fa fa-home',1),(22,15,5,'Stystem Users','users','fa fa-home',1),(23,5,5,'Admin Priority','admin-priority','fa fa-home',1);

/*Table structure for table `suppliers` */

DROP TABLE IF EXISTS `suppliers`;

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(91) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tax` double DEFAULT 0,
  `uid` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(91) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `suppliers` */

insert  into `suppliers`(`id`,`name`,`tax`,`uid`,`address`,`phone`,`email`,`image`,`status`,`created_at`,`updated_at`,`created_by`,`updated_by`) values (2,'Danish Ltd.',5,'c-00000001','Kakrail','0111**********','danish@gmail.com','2-20200408181635.png',1,'2020-04-15 18:32:28','2020-04-15 12:32:28',NULL,NULL),(3,'Mini Militia',0,'c-00000001','sdasd','01666666','mini@gmail.com',NULL,1,'2020-04-15 19:59:10','2020-04-15 13:59:10',NULL,NULL);

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) DEFAULT 1,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`role_id`,`email`,`email_verified_at`,`password`,`remember_token`,`created_at`,`updated_at`,`created_by`,`status`) values (1,'Asiful Islam Sakib',1,'sakib2439@gmail.com',NULL,'$2y$10$a4H9sbVCwStKFFaZs8tDTuN5f/DINcIavQz2bOkpKQCVjh1WpFawW',NULL,'2020-04-12 12:28:32','2020-04-12 12:28:32',1,1),(2,'Zahidur Rahman',1,'zahidur.diu@gmail.com',NULL,'$2y$10$OxrwLX0fkjAOtv80ITA3deTYRis2MHL262MHhh4bGMCEOsqFF7sae',NULL,'2020-04-12 12:29:59','2020-04-12 12:29:59',1,1),(3,'Nasim Ul Haque',2,'nasim.noyon111@gmail.com',NULL,'$2y$10$wc.7p4Z6rnTEpOma9Ccf7.dhdAEEoyl.nHqSC7YuiOtqLRm6rx1zC',NULL,'2020-04-12 12:30:37','2020-04-12 19:20:25',1,1),(4,'Didarul Islam',3,'didarulalpha@gmail.com',NULL,'$2y$10$QeFaE8q5MXT9EaG6dd.YYel.X7ZZs6tZmjLJxeyBc8ca.MqtQeBai',NULL,'2020-04-12 12:31:07','2020-04-12 12:31:07',1,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
