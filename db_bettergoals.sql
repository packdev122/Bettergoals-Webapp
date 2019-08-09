/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.5.5-10.1.31-MariaDB : Database - bettergoals
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`bettergoals` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `bettergoals`;

/*Table structure for table `about_me` */

DROP TABLE IF EXISTS `about_me`;

CREATE TABLE `about_me` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `live_place_id` int(10) unsigned NOT NULL,
  `work_place_id` int(10) unsigned NOT NULL,
  `contact_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `about_me` */

insert  into `about_me`(`id`,`user_id`,`live_place_id`,`work_place_id`,`contact_id`,`created_at`,`updated_at`,`doctor_id`) values (4,1,26,23,'1','2018-08-23 03:36:19','2018-08-30 16:56:50',1);

/*Table structure for table `announcements` */

DROP TABLE IF EXISTS `announcements`;

CREATE TABLE `announcements` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `action_text` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `action_url` text COLLATE utf8_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `announcements` */

/*Table structure for table `api_tokens` */

DROP TABLE IF EXISTS `api_tokens`;

CREATE TABLE `api_tokens` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `metadata` text COLLATE utf8_unicode_ci NOT NULL,
  `transient` tinyint(4) NOT NULL DEFAULT '0',
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `api_tokens_token_unique` (`token`),
  KEY `api_tokens_user_id_expires_at_index` (`user_id`,`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `api_tokens` */

/*Table structure for table `appointments` */

DROP TABLE IF EXISTS `appointments`;

CREATE TABLE `appointments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `team_id` int(10) unsigned NOT NULL,
  `psa_id` int(10) unsigned DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category_id` int(10) unsigned DEFAULT NULL,
  `contact_id` int(10) unsigned DEFAULT NULL,
  `organisation_id` int(10) unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attendees` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `checkin` tinyint(1) DEFAULT NULL,
  `all_day` tinyint(1) DEFAULT NULL,
  `send_sms` tinyint(1) DEFAULT NULL,
  `checkin_datetime` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `detail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pwd_count` int(11) DEFAULT NULL,
  `carer_count` int(11) DEFAULT NULL,
  `is_reminder` int(11) DEFAULT NULL,
  `video` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `appointments` */

insert  into `appointments`(`id`,`team_id`,`psa_id`,`photo`,`category_id`,`contact_id`,`organisation_id`,`title`,`start_date`,`end_date`,`address`,`attendees`,`checkin`,`all_day`,`send_sms`,`checkin_datetime`,`created_at`,`updated_at`,`detail`,`pwd_count`,`carer_count`,`is_reminder`,`video`,`thumbnail`) values (49,1,NULL,'/img/default.png',NULL,NULL,NULL,'Test Sms111','2018-09-20 07:00:00',NULL,NULL,NULL,NULL,NULL,0,NULL,'2018-09-05 15:59:58','2018-09-05 15:59:58','1111',NULL,NULL,1,'5b8ffd7c26c14_video.mp4','5b8ffd7c26c14_thumb.jpg'),(50,1,NULL,'/img/default.png',NULL,1,NULL,'Test video upload','2018-08-09 07:00:00','2018-08-09 07:00:00','',NULL,NULL,NULL,0,NULL,'2018-09-05 16:32:44','2018-09-05 16:32:44','111',NULL,NULL,NULL,'5b9005271f539_video.mp4','5b9005271f539_thumb.jpg'),(51,1,NULL,'/img/default.png',NULL,1,19,'Test video upload1','2018-09-09 07:00:00','2018-09-09 07:00:00','',NULL,NULL,NULL,0,NULL,'2018-09-05 16:33:20','2018-09-06 05:51:09','111',NULL,38,NULL,'5b90054e14ac1_video.mp4','5b90054e14ac1_thumb.jpg'),(52,1,NULL,'/img/default.png',NULL,NULL,NULL,'Test Sms111','2018-09-27 06:30:00',NULL,NULL,NULL,NULL,NULL,0,NULL,'2018-09-05 16:57:02','2018-09-05 16:57:02','',NULL,NULL,1,'5b900adbe6634_video.mp4','5b900adbe6634_thumb.jpg'),(53,1,NULL,'/img/default.png',NULL,NULL,NULL,'12345','2018-09-16 07:30:00',NULL,NULL,NULL,NULL,NULL,0,NULL,'2018-09-05 16:57:46','2018-09-06 03:02:14','123456',NULL,NULL,1,'5b900b077d944_video.mp4','5b900b077d944_thumb.jpg'),(54,1,NULL,'/img/default.png',NULL,NULL,NULL,'111111111','2018-09-29 07:00:00',NULL,NULL,NULL,NULL,NULL,0,NULL,'2018-09-05 16:59:52','2018-09-05 17:03:22','',NULL,NULL,1,'5b900c5858041_video.mp4','5b900c5858041_thumb.jpg'),(55,1,NULL,'/img/default.png',NULL,NULL,NULL,'test video log','2018-09-20 07:30:00','2018-09-20 08:30:00','',NULL,NULL,NULL,0,NULL,'2018-09-06 03:26:57','2018-09-06 03:26:57','11111',NULL,1,NULL,'','');

/*Table structure for table `categories` */

DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `categories` */

/*Table structure for table `contacts` */

DROP TABLE IF EXISTS `contacts`;

CREATE TABLE `contacts` (
  `team_id` int(10) unsigned NOT NULL,
  `org_contact_id` int(11) DEFAULT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `organisation` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `contacts` */

insert  into `contacts`(`team_id`,`org_contact_id`,`name`,`phone`,`mobile`,`email`,`address`,`id`,`created_at`,`updated_at`,`organisation`,`photo`) values (1,NULL,'Lucas Stephen','12234343423',NULL,'admin@semmfbanks.com.ng','1 Hamburg Turnpike, Wayne, NJ 07470, USA',1,'2018-08-20 20:08:08','2018-08-26 18:15:17','','/public/profiles/9JuPX8FFtnOptiXcJ6hd8WLh3KI2ECjQ8u8O3NZk.png'),(1,NULL,'222222','22222',NULL,'','Sta Fe 2788, S2000KTL Rosario, Santa Fe, Argentina',2,'2018-08-20 21:02:03','2018-08-20 21:02:03',NULL,''),(1,NULL,'Test User','18634243231',NULL,'lucasstephen1995122@gmail.com','Australia',3,'2018-08-30 16:56:35','2018-08-30 16:56:35',NULL,'');

/*Table structure for table `favourite_things` */

DROP TABLE IF EXISTS `favourite_things`;

CREATE TABLE `favourite_things` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `favourite_things` */

insert  into `favourite_things`(`id`,`user_id`,`name`,`photo`,`note`,`created_at`,`updated_at`) values (25,1,'waling on the beach','',NULL,'2018-09-06 03:05:20','2018-09-06 03:05:20'),(26,1,'talking the friends','',NULL,'2018-09-06 03:05:20','2018-09-06 03:05:20');

/*Table structure for table `invitations` */

DROP TABLE IF EXISTS `invitations`;

CREATE TABLE `invitations` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `team_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `invitations_token_unique` (`token`),
  KEY `invitations_team_id_index` (`team_id`),
  KEY `invitations_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `invitations` */

/*Table structure for table `invoices` */

DROP TABLE IF EXISTS `invoices`;

CREATE TABLE `invoices` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `provider_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `total` decimal(8,2) DEFAULT NULL,
  `tax` decimal(8,2) DEFAULT NULL,
  `card_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_zip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vat_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoices_created_at_index` (`created_at`),
  KEY `invoices_user_id_index` (`user_id`),
  KEY `invoices_team_id_index` (`team_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `invoices` */

/*Table structure for table `medications` */

DROP TABLE IF EXISTS `medications`;

CREATE TABLE `medications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `medications` */

insert  into `medications`(`id`,`user_id`,`name`,`photo`,`note`,`created_at`,`updated_at`) values (8,1,'Bad Colds','',NULL,'2018-09-06 03:05:20','2018-09-06 03:05:20');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'2017_01_11_010053_create_performance_indicators_table',1),(2,'2017_01_11_010054_create_announcements_table',1),(3,'2017_01_11_010056_create_users_table',1),(4,'2017_01_11_010059_create_password_resets_table',1),(5,'2017_01_11_010103_create_api_tokens_table',1),(6,'2017_01_11_010108_create_subscriptions_table',1),(7,'2017_01_11_010114_create_invoices_table',1),(8,'2017_01_11_010121_create_notifications_table',1),(9,'2017_01_11_010129_create_teams_table',1),(10,'2017_01_11_010138_create_team_users_table',1),(11,'2017_01_11_010148_create_invitations_table',1),(12,'2017_01_11_085216_add_pwd_to_users_table',1),(13,'2017_01_23_005911_create_categories_table',1),(14,'2017_01_23_051718_create_contacts_table',1),(15,'2017_01_30_001417_create_organisations_table',1),(16,'2017_01_30_011734_create_appointments_table',1),(17,'2017_02_09_010138_create_tasks_table',1),(18,'2017_02_23_075521_create_notes_table',1),(19,'2017_03_13_033517_create_photos_table',1),(20,'2017_04_17_162136_add_details_to_appointments_table',1),(21,'2017_04_19_054853_add_order_to_tasks_table',1),(22,'2017_04_25_044846_add_organisations_to_contacts_table',1),(23,'2017_05_01_235923_add_detail_to_tasks_table',1),(24,'2017_05_27_235923_add_checkin_to_tasks_table',1),(25,'2017_06_19_162136_add_pwd_count_carer_count_to_appointments_table',1),(26,'2017_06_19_162137_add_pwd_count_carer_count_to_tasks_table',1),(27,'2017_07_05_011902_add_photo_to_contacts_table',1),(28,'2017_07_05_032639_add_photo_to_organisations_table',1),(29,'2017_07_07_002812_add_emergency_contact_to_users_table',1),(30,'2017_07_13_230829_make_detail_nullable_in_appointments_table',1),(31,'2018_08_21_050129_create_about_table',2),(32,'2018_08_27_023828_add_doctor_to_about_me_table',3),(33,'2018_08_27_152129_create_favourite_table',4),(34,'2018_08_27_152129_create_medication_table',4),(35,'2018_08_31_050329_create_reminder_table',5),(36,'2018_08_31_050429_change_about_table',6),(37,'2018_09_03_023828_add_new_to_reminder_table',7),(38,'2018_09_03_033517_create_reminder_photos_table',7),(39,'2018_09_04_023828_add_reminder_to_appointment_table',8),(40,'2018_09_04_183828_add_video_to_appointment_table',9),(41,'2018_09_04_233828_add_thumb_to_appointment_table',10),(42,'2018_09_05_143828_add_video_to_task_table',11),(43,'2018_09_05_223828_add_thumb_to_task_table',12);

/*Table structure for table `notes` */

DROP TABLE IF EXISTS `notes`;

CREATE TABLE `notes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `appointment_id` int(10) unsigned NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notes_appointment_id_foreign` (`appointment_id`),
  CONSTRAINT `notes_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `notes` */

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `icon` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `action_text` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `action_url` text COLLATE utf8_unicode_ci,
  `read` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_user_id_created_at_index` (`user_id`,`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `notifications` */

insert  into `notifications`(`id`,`user_id`,`created_by`,`icon`,`body`,`action_text`,`action_url`,`read`,`created_at`,`updated_at`) values ('65c4b20c-ac27-4271-84f9-0d2b12599794',1,NULL,'fa-users','Lucas Stephen checked in at Test Sms | 03/09/2018 3:05pm',NULL,NULL,0,'2018-09-03 05:05:35','2018-09-03 05:05:35'),('6c2472d8-caf5-46e3-a982-5fbd781b9740',1,NULL,'fa-clock-o','Your trial period will expire on March 2nd.','Subscribe','/settings#/subscription',1,'2018-08-14 20:01:47','2018-08-14 20:02:20'),('97f6da14-2eec-4c57-9c77-9622527ae43e',4,NULL,'fa-clock-o','Your trial period will expire on March 9th.','Subscribe','/settings#/subscription',0,'2018-08-21 03:01:03','2018-08-21 03:01:03');

/*Table structure for table `organisations` */

DROP TABLE IF EXISTS `organisations`;

CREATE TABLE `organisations` (
  `team_id` int(10) unsigned NOT NULL,
  `name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mobile` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `organisations` */

insert  into `organisations`(`team_id`,`name`,`phone`,`mobile`,`email`,`address`,`website`,`id`,`created_at`,`updated_at`,`photo`) values (1,'Bettergoals','',NULL,'','Sydney NSW 2000, Australia','',19,'2018-08-22 15:13:08','2018-08-22 15:13:08','/public/profiles/9JuPX8FFtnOptiXcJ6hd8WLh3KI2ECjQ8u8O3NZk.png'),(1,'BestGoals','',NULL,'','Australian Capital Territory, Australia','',20,'2018-08-22 15:16:48','2018-08-23 03:31:26',''),(1,'My company','',NULL,'','Beijing, China','',21,'2018-08-22 15:24:21','2018-08-22 15:24:21','/public/profiles/9JuPX8FFtnOptiXcJ6hd8WLh3KI2ECjQ8u8O3NZk.png'),(1,'My home place','',NULL,'','Srilanta Resort, Mu 6 Klongnin Beach Krabi Ko Lanta District, Krabi, Thailand','',22,'2018-08-22 16:46:14','2018-08-22 16:46:14',''),(1,'My test place','',NULL,'','Australia Fair Shopping Centre, Marine Parade, Southport QLD, Australia','',23,'2018-08-23 03:35:13','2018-08-23 03:35:13',''),(1,'My home place','',NULL,'','New South Wales Border, 237-239 Piggabeen Rd, Currumbin Waters QLD 4223, Australia','',24,'2018-08-23 04:37:15','2018-08-23 04:51:47','/img/icon-with.svg'),(1,'Home','',NULL,'','1-25 Harbour Street, Sydney, New South Wales, Australia','',25,'2018-08-23 05:52:03','2018-08-23 05:52:03',''),(1,'Home1','',NULL,'','1-25 Harbour St, Sydney, New South Wales, Australia','',26,'2018-08-23 06:03:45','2018-08-23 06:03:45',''),(1,'My home place','12234343423',NULL,'admin@admin.com','Lorem Street','',27,'2018-09-02 17:42:23','2018-09-02 17:42:23',''),(1,'My home place','12234343423',NULL,'','Quebec, Canada','',28,'2018-09-06 06:04:13','2018-09-06 06:04:13','/img/icon-with.svg'),(1,'22222','123423532463',NULL,'','Sta Fe 2261, S2000KTA Rosario, Santa Fe, Argentina','',29,'2018-09-06 06:05:55','2018-09-06 06:05:55','/img/icon-where.svg');

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `performance_indicators` */

DROP TABLE IF EXISTS `performance_indicators`;

CREATE TABLE `performance_indicators` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `monthly_recurring_revenue` decimal(8,2) NOT NULL,
  `yearly_recurring_revenue` decimal(8,2) NOT NULL,
  `daily_volume` decimal(8,2) NOT NULL,
  `new_users` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `performance_indicators_created_at_index` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `performance_indicators` */

/*Table structure for table `photos` */

DROP TABLE IF EXISTS `photos`;

CREATE TABLE `photos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `appointment_id` int(10) unsigned NOT NULL,
  `team_id` int(10) unsigned NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `photos_appointment_id_foreign` (`appointment_id`),
  CONSTRAINT `photos_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `photos` */

/*Table structure for table `reminder` */

DROP TABLE IF EXISTS `reminder`;

CREATE TABLE `reminder` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `send_sms` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `details` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `checkin` int(11) DEFAULT NULL,
  `checkin_datetime` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `reminder` */

insert  into `reminder`(`id`,`user_id`,`send_sms`,`title`,`start_date`,`photo`,`details`,`created_at`,`updated_at`,`checkin`,`checkin_datetime`) values (1,1,1,'Test Sms1111444','2018-09-06 09:00:00','/img/default.png','My details','2018-09-03 21:13:08','2018-09-03 07:56:02',NULL,NULL),(2,1,1,'Test','2018-08-16 07:00:00','','','2018-08-30 21:45:40','2018-08-30 21:45:40',NULL,NULL),(3,1,1,'Test Sms','2018-09-13 07:00:00','','21313','2018-09-02 17:40:22','2018-09-02 17:40:22',NULL,NULL),(4,1,1,'111','2018-09-26 07:30:00','','234234234234','2018-09-02 17:41:47','2018-09-02 17:41:47',NULL,NULL),(5,1,1,'23232','2018-09-21 07:00:00','','232323','2018-09-02 17:42:04','2018-09-02 17:42:04',NULL,NULL),(6,1,1,'Test Sms','2018-09-14 07:00:00','','1212222','2018-09-02 17:43:03','2018-09-02 17:43:03',NULL,NULL),(7,1,1,'Test','2018-09-20 07:00:00','','retertertert','2018-09-02 17:49:58','2018-09-02 17:49:58',NULL,NULL),(8,1,1,'Test','2018-09-20 06:00:00','','23123123','2018-09-02 17:50:58','2018-09-02 17:50:58',NULL,NULL),(9,1,1,'111','2018-09-20 06:30:00','','123123123123','2018-09-02 17:54:08','2018-09-02 17:54:08',NULL,NULL),(10,1,1,'1112222','2018-09-20 07:00:00','','232323','2018-09-02 17:59:11','2018-09-03 07:56:55',NULL,NULL),(11,1,1,'Test','2018-09-13 06:30:00','','213213','2018-09-02 18:00:46','2018-09-02 18:00:46',NULL,NULL),(12,1,1,'Test','2018-09-12 07:00:00','','12123123123','2018-09-02 18:02:42','2018-09-02 18:02:42',NULL,NULL),(13,1,1,'Test','2018-09-06 07:00:00','','123213123213','2018-09-02 18:03:14','2018-09-02 18:03:14',NULL,NULL),(14,1,1,'Test Sms','2018-09-13 07:00:00','','23123123','2018-09-02 18:03:53','2018-09-02 18:03:53',NULL,NULL),(15,1,1,'Test Sms','2018-09-13 06:30:00','','dsfsdfdsf','2018-09-02 18:16:45','2018-09-02 18:16:45',NULL,NULL),(16,1,1,'Test','2018-09-28 06:30:00','','asdsdfsdfsdf','2018-09-02 18:17:20','2018-09-02 18:17:20',NULL,NULL),(17,1,1,'Test Sms','2018-09-20 06:30:00','','213123','2018-09-02 18:19:16','2018-09-02 18:19:16',NULL,NULL),(18,1,1,'Test Sms','2018-09-20 06:30:00','','213123213','2018-09-02 18:20:36','2018-09-02 18:20:36',NULL,NULL),(19,1,1,'123123','2018-09-14 06:30:00','','123123123','2018-09-02 18:23:09','2018-09-02 18:23:09',NULL,NULL),(20,1,1,'111','2018-09-12 06:30:00','','','2018-09-02 18:25:16','2018-09-02 18:25:16',NULL,NULL),(21,1,1,'12321','2018-09-13 06:30:00','','','2018-09-02 18:25:58','2018-09-02 18:25:58',NULL,NULL),(22,1,1,'Test Sms111','2018-09-20 07:30:00','','1111','2018-09-03 15:26:27','2018-09-03 15:26:27',NULL,NULL),(23,1,1,'My Test ','2018-09-27 07:00:00','','111111','2018-09-03 15:27:47','2018-09-03 15:27:47',NULL,NULL),(24,1,1,'222','2018-09-21 06:30:00','','2222','2018-09-03 15:28:04','2018-09-03 15:28:04',NULL,NULL);

/*Table structure for table `reminder_photos` */

DROP TABLE IF EXISTS `reminder_photos`;

CREATE TABLE `reminder_photos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `reminder_id` int(10) unsigned NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `reminder_photos` */

/*Table structure for table `subscriptions` */

DROP TABLE IF EXISTS `subscriptions`;

CREATE TABLE `subscriptions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_plan` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `subscriptions` */

/*Table structure for table `tasks` */

DROP TABLE IF EXISTS `tasks`;

CREATE TABLE `tasks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `appointment_id` int(10) unsigned NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `contact_id` int(11) DEFAULT NULL,
  `organisation_id` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_date` timestamp NULL DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `attendees` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `send_sms` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order` tinyint(4) NOT NULL,
  `detail` text COLLATE utf8_unicode_ci,
  `checkin` tinyint(1) DEFAULT NULL,
  `checkin_datetime` timestamp NULL DEFAULT NULL,
  `pwd_count` int(11) DEFAULT NULL,
  `carer_count` int(11) DEFAULT NULL,
  `video` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tasks_appointment_id_foreign` (`appointment_id`),
  CONSTRAINT `tasks_appointment_id_foreign` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `tasks` */

insert  into `tasks`(`id`,`team_id`,`appointment_id`,`category_id`,`contact_id`,`organisation_id`,`title`,`start_date`,`end_date`,`address`,`attendees`,`send_sms`,`created_at`,`updated_at`,`order`,`detail`,`checkin`,`checkin_datetime`,`pwd_count`,`carer_count`,`video`,`thumbnail`) values (11,1,51,NULL,1,19,'my ready','2018-09-06 11:08:08','2018-09-09 07:30:00','',NULL,0,'2018-09-06 03:07:29','2018-09-06 03:08:08',10,'1111',NULL,NULL,NULL,NULL,'','');

/*Table structure for table `team_subscriptions` */

DROP TABLE IF EXISTS `team_subscriptions`;

CREATE TABLE `team_subscriptions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `team_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `stripe_plan` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `team_subscriptions` */

/*Table structure for table `team_users` */

DROP TABLE IF EXISTS `team_users`;

CREATE TABLE `team_users` (
  `team_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  UNIQUE KEY `team_users_team_id_user_id_unique` (`team_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `team_users` */

insert  into `team_users`(`team_id`,`user_id`,`role`) values (1,1,'owner'),(1,3,'pwd'),(2,4,'owner');

/*Table structure for table `teams` */

DROP TABLE IF EXISTS `teams`;

CREATE TABLE `teams` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo_url` text COLLATE utf8_unicode_ci,
  `stripe_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `current_billing_plan` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_brand` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_last_four` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_address_line_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_zip` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_country` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vat_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extra_billing_information` text COLLATE utf8_unicode_ci,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `teams_slug_unique` (`slug`),
  KEY `teams_owner_id_index` (`owner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `teams` */

insert  into `teams`(`id`,`owner_id`,`name`,`slug`,`photo_url`,`stripe_id`,`current_billing_plan`,`card_brand`,`card_last_four`,`card_country`,`billing_address`,`billing_address_line_2`,`billing_city`,`billing_state`,`billing_zip`,`billing_country`,`vat_id`,`extra_billing_information`,`trial_ends_at`,`created_at`,`updated_at`) values (1,1,'Digitura',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2018-08-14 20:01:57','2018-08-14 20:01:57','2018-08-14 20:01:57'),(2,4,'My team',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2018-08-21 03:01:10','2018-08-21 03:01:10','2018-08-21 03:01:10');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `photo_url` text COLLATE utf8_unicode_ci,
  `uses_two_factor_auth` tinyint(4) NOT NULL DEFAULT '0',
  `authy_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `country_code` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `two_factor_reset_code` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `current_team_id` int(11) DEFAULT NULL,
  `stripe_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `current_billing_plan` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_brand` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_last_four` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `card_country` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_address_line_2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_city` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_state` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_zip` varchar(25) COLLATE utf8_unicode_ci DEFAULT NULL,
  `billing_country` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  `vat_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extra_billing_information` text COLLATE utf8_unicode_ci,
  `trial_ends_at` timestamp NULL DEFAULT NULL,
  `last_read_announcements_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `pwd` tinyint(1) DEFAULT NULL,
  `emergency_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `emergency_phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`password`,`remember_token`,`photo_url`,`uses_two_factor_auth`,`authy_id`,`country_code`,`phone`,`two_factor_reset_code`,`current_team_id`,`stripe_id`,`current_billing_plan`,`card_brand`,`card_last_four`,`card_country`,`billing_address`,`billing_address_line_2`,`billing_city`,`billing_state`,`billing_zip`,`billing_country`,`vat_id`,`extra_billing_information`,`trial_ends_at`,`last_read_announcements_at`,`created_at`,`updated_at`,`pwd`,`emergency_name`,`emergency_phone`) values (1,'Lucas Stephen','lucasstephen1995122@gmail.com','$2y$10$mwoj/8IrSei3zrJyoL4aVu/hgAy0NkGFVgS2eltKf8WizJqfpao0K','kJWytFGS04iIHoC0BLKc4uMl1JCrUjo1ag7A7CmuZJqxKKieMVAYACzk8oN2','/public/profiles/9JuPX8FFtnOptiXcJ6hd8WLh3KI2ECjQ8u8O3NZk.png',0,NULL,NULL,'61432991187',NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-02 20:01:47','2018-08-14 20:01:47','2018-08-14 20:01:47','2018-08-22 16:39:45',NULL,NULL,NULL),(3,'Dinusha Pathirana1','bciar1@yandex.com','$2y$10$mwoj/8IrSei3zrJyoL4aVu/hgAy0NkGFVgS2eltKf8WizJqfpao0K',NULL,NULL,0,NULL,NULL,'61432991187',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,'Lucas Stephen','lucas@gmail.com','$2y$10$hra3Z7bxuFrjcyWk1ejpTedIa0ueuk0VQTwJ/QAkRtge269BEaTIa','u5kwjf5WvS75T3AgGgS9xBgtbZTBwHWEObWZHFxo3YJh6dYBLRIDWI6ROBUt',NULL,0,NULL,NULL,'61432991187',NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2019-03-09 03:01:03','2018-08-21 03:01:03','2018-08-21 03:01:03','2018-08-21 03:01:11',NULL,NULL,NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
