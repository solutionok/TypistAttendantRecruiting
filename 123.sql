/*
SQLyog Community v13.1.1 (64 bit)
MySQL - 10.1.34-MariaDB : Database - tasagents_db
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`tasagents_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin */;

USE `tasagents_db`;

/*Table structure for table `applicants` */

DROP TABLE IF EXISTS `applicants`;

CREATE TABLE `applicants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicant_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  `apply_result` text COLLATE utf8mb4_unicode_ci,
  `capture_file` text COLLATE utf8mb4_unicode_ci,
  `passed` int(11) DEFAULT NULL,
  `pass_date` date DEFAULT NULL,
  `assessor_note` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

/*Data for the table `applicants` */

insert  into `applicants`(`id`,`applicant_id`,`job_id`,`created_at`,`updated_at`,`apply_result`,`capture_file`,`passed`,`pass_date`,`assessor_note`) values 
(1,81,6,'2019-04-25','2019-04-25','{\"recording_text\":\"asdf asdf asdf asdf asdf asdf asdf asdf\",\"started\":true,\"time\":\"00 : 06\",\"text\":\"asdf asdf asdf asdf asdf asdf asdf asdf\",\"evaluated\":\"<span style=\\\"color:#28a745\\\">asdf</span> <span style=\\\"color:#28a745\\\">asdf</span> <span style=\\\"color:#28a745\\\">asdf</span> <span style=\\\"color:#28a745\\\">asdf</span> <span style=\\\"color:#28a745\\\">asdf</span> <span style=\\\"color:#28a745\\\">asdf</span> <span style=\\\"color:#28a745\\\">asdf</span> <span style=\\\"color:#28a745\\\">asdf</span>\",\"typo\":0,\"accuracy\":\"100.0\",\"finished\":true,\"recordingStarted\":true}','app/applicant_recording/5cc0d0da02db4.webm',0,NULL,NULL);

/*Table structure for table `job` */

DROP TABLE IF EXISTS `job`;

CREATE TABLE `job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_bin,
  `description` text COLLATE utf8mb4_bin,
  `owner_id` int(11) DEFAULT NULL,
  `active_status` int(11) DEFAULT NULL,
  `zipcode` text COLLATE utf8mb4_bin,
  `test_type` int(11) DEFAULT '1' COMMENT '1:onetime type and record, 2: question and answer',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

/*Data for the table `job` */

insert  into `job`(`id`,`name`,`description`,`owner_id`,`active_status`,`zipcode`,`test_type`,`created_at`,`updated_at`) values 
(1,'ffffffffffffff','sssssssssssssssssxxxx',81,NULL,'12312312',2,'2019-03-26 09:32:50','2019-04-23 20:17:36'),
(6,'adfasdf','hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello wdorld hello world hellod hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world hello world&nbsp;',81,NULL,'asdf',1,'2019-04-23 18:51:27','2019-04-23 20:17:28');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

/*Data for the table `migrations` */

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

/*Table structure for table `quiz` */

DROP TABLE IF EXISTS `quiz`;

CREATE TABLE `quiz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` int(11) DEFAULT NULL,
  `recording_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `recording_audio` text COLLATE utf8mb4_unicode_ci,
  `qtype` int(11) DEFAULT NULL,
  `order_val` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `test_trigger` (`job_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

/*Data for the table `quiz` */

insert  into `quiz`(`id`,`job_id`,`recording_text`,`recording_audio`,`qtype`,`order_val`,`created_at`,`updated_at`) values 
(3,1,'f f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f ff f f f f',NULL,2,1,'2019-03-26 09:37:33','2019-04-23 20:07:54'),
(4,6,'asdf asdf asdf asdf asdf asdf asdf asdf',NULL,3,1,'2019-04-23 19:03:28','2019-04-24 14:39:06');

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `setting_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

/*Data for the table `settings` */

insert  into `settings`(`setting_name`,`setting_value`) values 
('admin_test_page_search_date','2019-02-09,2019-05-11'),
('review_page_search_date_1','2019-01-29,2019-03-08'),
('review_page_search_date_81','2019-01-27,2019-02-28');

/*Table structure for table `traning` */

DROP TABLE IF EXISTS `traning`;

CREATE TABLE `traning` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicant_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `apply_result` text COLLATE utf8mb4_unicode_ci,
  `capture_file` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

/*Data for the table `traning` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` char(100) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` text COLLATE utf8mb4_unicode_ci,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `isadmin` int(11) DEFAULT NULL,
  `phone` text COLLATE utf8mb4_unicode_ci,
  `resume_file` text COLLATE utf8mb4_unicode_ci,
  `orderinfo` text COLLATE utf8mb4_unicode_ci,
  `email_verified_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `email_unique` (`email`) USING BTREE,
  KEY `id` (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=161 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`password`,`remember_token`,`updated_at`,`created_at`,`isadmin`,`phone`,`resume_file`,`orderinfo`,`email_verified_at`) values 
(1,'Admin1','admin@example.com','$2y$10$uENszYNLI7MZ8434SrGIYuq1jmgRnRGBr2e.3JgsY/J0n0.Uh0Z/C','f7QiZGV9qC0jaJg0LFP8ABcsEyNJXsrROp5RHk7eXlHXYO3xU8FkRFmMGl78','2019-03-08 10:39:53','2018-12-22 07:16:58',1,'9995556664',NULL,NULL,'2019-03-07 19:43:43'),
(81,'Assessor 1','assessor@example.com','$2y$10$8MQjjxrSUaKoGvj2ui55lOmhIW2kwVXn1BR3kIEHmSFS5dvWwU4H.','bONPUjDAyPCQffGkxMVEyUttE26OHjCWdokxqVR6UCPDyYgx4cmfINW2aMSH','2019-04-22 23:50:25','2019-01-15 12:53:35',2,'9876543210','/app/resume/5cbdc6a1d9f7b.pdf','{\"adc\":{\"signature\":\"\",\"date\":\"\",\"contact_number\":\"\"},\"main\":{\"firstname\":\"x\",\"middlename\":\"x\",\"lastname\":\"x\",\"date\":\"x\",\"ssn\":\"x\",\"present_address\":\"x\",\"apt\":\"x\",\"city\":\"x\",\"state\":\"\",\"zipcode\":\"\",\"telephone_no\":\"x\",\"howlong_addr\":\"x\",\"age18\":0,\"detail_age\":\"\",\"position_for\":\"x\",\"is_fulltime\":\"1\",\"date_start\":\"04/10/2019\",\"is_parttime\":\"1\",\"arrested\":\"1\",\"crime\":\"1\",\"crime_detail\":\"x\",\"driver_license\":1,\"transportation\":\"Taxi/Uber/Lyft\",\"driver_licence_number\":\"\",\"state_of_issue\":\"A\",\"expiration_date\":\"\",\"accident_violation\":\"1\",\"accident_violation_count\":\"\"},\"background\":[{\"degree\":\"x\",\"school\":\"x\",\"location\":\"x\",\"years\":\"x\",\"major\":\"x\"}],\"personal_specified\":{\"armed_force\":\"1\",\"national_guard\":1,\"speciality\":\"x\",\"enterdate\":\"04/01/2019\",\"dischargedate\":\"04/22/2019\"},\"notes\":[{\"empname\":\"x\",\"supervisor\":\"x\",\"fulladdress\":\"x\",\"emp_start_end\":\"x\",\"city\":\"x\",\"state\":\"x\",\"zipcode\":\"x\",\"pay_salary\":\"x\",\"phone_no\":\"x\",\"lastjob\":\"x\",\"reason_leaving\":\"x\",\"lastjob_detail\":\"x\"}],\"contactable_to_employer\":\"1\",\"completed_self\":\"1\",\"completed_who\":\"x\",\"addition_info\":\"xxxxxxxxxx\"}','2019-03-23 01:50:50'),
(160,'A Level Test (2019)','coolpluto1114@gmail.com','$2y$10$f20Ds.3jLpJO.cviGjP4POiENLBFycms6Uem2jAZqDTdP7dOTlWte','zoZBRv3wL9cXrB3kDF3e7OHFiB2EEpb8W6OeGYV5F4xnrW6o77SSl6L60s57','2019-03-26 11:33:35','2019-03-26 11:04:08',0,'2342342341',NULL,NULL,'2019-03-26 11:33:35');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
