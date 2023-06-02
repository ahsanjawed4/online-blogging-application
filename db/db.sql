/*
SQLyog Ultimate v12.5.0 (64 bit)
MySQL - 10.4.27-MariaDB : Database - 16412_ahsan_jawed
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`16412_ahsan_jawed` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `16412_ahsan_jawed`;

/*Table structure for table `blog` */

DROP TABLE IF EXISTS `blog`;

CREATE TABLE `blog` (
  `blog_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `blog_title` varchar(11) DEFAULT NULL,
  `post_per_page` int(11) DEFAULT NULL,
  `blog_background_image` text DEFAULT NULL,
  `blog_status` enum('Active','InActive') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`blog_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `blog` */

insert  into `blog`(`blog_id`,`user_id`,`blog_title`,`post_per_page`,`blog_background_image`,`blog_status`,`created_at`,`updated_at`) values 
(19,1,'Real Madrid',2,'774688962_real_madrid.jpg','Active','2023-05-17 09:46:13','2023-05-23 06:10:04'),
(20,1,'RMA',8,'1766261528_rm_2.jpg','Active','2023-05-17 09:48:55','2023-05-20 15:32:21'),
(21,1,'KO',12,'1498929806_ko.jpg','Active','2023-05-17 10:08:51','2023-05-20 15:32:18'),
(23,1,'ko_4',2,'1816353517_ko.jpg','Active','2023-05-17 10:13:27','2023-05-21 16:46:12'),
(24,13,'FCB',20,'997465985_rm_2.jpg','Active','2023-05-17 10:22:55','2023-05-17 10:23:21');

/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_title` varchar(100) DEFAULT NULL,
  `category_description` text DEFAULT NULL,
  `category_status` enum('Active','InActive') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `category` */

insert  into `category`(`category_id`,`category_title`,`category_description`,`category_status`,`created_at`,`updated_at`) values 
(9,'Dramas','Kurulus Osman is best','Active','2023-05-17 10:16:56','2023-05-21 16:20:03'),
(10,'sport','sport is life','Active','2023-05-17 12:08:27','2023-05-21 16:20:01'),
(11,'cat_1','this is cat_1','Active','2023-05-20 11:40:56','2023-05-21 16:19:57'),
(12,'cat_2','this is cat_2','Active','2023-05-20 11:41:07','2023-05-21 16:19:54');

/*Table structure for table `following_blog` */

DROP TABLE IF EXISTS `following_blog`;

CREATE TABLE `following_blog` (
  `follow_id` int(11) NOT NULL AUTO_INCREMENT,
  `follower_id` int(11) DEFAULT NULL,
  `blog_following_id` int(11) DEFAULT NULL,
  `status` enum('Followed','Unfollowed') DEFAULT 'Followed',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`follow_id`),
  KEY `blog_following_id` (`blog_following_id`),
  KEY `follower_id` (`follower_id`),
  CONSTRAINT `following_blog_ibfk_1` FOREIGN KEY (`blog_following_id`) REFERENCES `blog` (`blog_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `following_blog_ibfk_2` FOREIGN KEY (`follower_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `following_blog` */

insert  into `following_blog`(`follow_id`,`follower_id`,`blog_following_id`,`status`,`created_at`,`updated_at`) values 
(5,1,24,'Unfollowed','2023-05-17 10:28:14','2023-05-23 07:10:47'),
(6,14,23,'Followed','2023-05-20 15:13:35','2023-05-20 15:14:36'),
(7,14,19,'Followed','2023-05-20 15:13:57','2023-05-20 15:13:57'),
(8,14,20,'Followed','2023-05-20 15:14:05','2023-05-20 15:14:05'),
(9,14,21,'Followed','2023-05-20 15:14:13','2023-05-20 15:14:13'),
(10,14,24,'Followed','2023-05-20 15:14:42','2023-05-20 15:14:42'),
(11,13,23,'Followed','2023-05-20 15:16:08','2023-05-20 15:16:08'),
(12,13,21,'Followed','2023-05-20 15:16:13','2023-05-20 15:16:13'),
(13,13,19,'Followed','2023-05-20 15:16:27','2023-05-20 15:16:27'),
(14,13,20,'Followed','2023-05-20 15:16:37','2023-05-20 15:16:37');

/*Table structure for table `post` */

DROP TABLE IF EXISTS `post`;

CREATE TABLE `post` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) DEFAULT NULL,
  `post_title` varchar(200) NOT NULL,
  `post_summary` text NOT NULL,
  `post_description` longtext NOT NULL,
  `featured_image` text DEFAULT NULL,
  `post_status` enum('Active','InActive') DEFAULT NULL,
  `is_comment_allowed` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`post_id`),
  KEY `blog_id` (`blog_id`),
  CONSTRAINT `post_ibfk_1` FOREIGN KEY (`blog_id`) REFERENCES `blog` (`blog_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `post` */

insert  into `post`(`post_id`,`blog_id`,`post_title`,`post_summary`,`post_description`,`featured_image`,`post_status`,`is_comment_allowed`,`created_at`,`updated_at`) values 
(54,21,'post_1','post summary','post description','2070293050_12.jpg','Active',1,'2023-05-18 11:47:02','2023-05-18 11:47:02'),
(55,19,'post_2','summary_2','description_2','1014241122_real_madrid.jpg','Active',0,'2023-05-18 11:48:50','2023-05-18 11:48:50'),
(56,20,'post_3','post summary','post description','1507080173_real_madrid.jpg','Active',1,'2023-05-18 12:19:36','2023-05-18 12:19:36'),
(63,23,'post_4','post 4 summary','post 5 description','2117986082_images.jpg','Active',1,'2023-05-20 10:02:43','2023-05-20 10:02:43'),
(64,20,'post rma','post summary','post description','802644080_ko.jpg','Active',1,'2023-05-20 11:12:39','2023-05-20 11:12:39'),
(65,24,'arsal post','post summar','post description','1733904737_rm_2.jpg','Active',1,'2023-05-20 11:15:15','2023-05-20 11:15:15'),
(66,19,'UCL','ucl is best','ucl is greatest','1673021870_rm_2.jpg','Active',1,'2023-05-20 12:29:21','2023-05-20 12:29:21'),
(67,23,'Hh','DDS','SCSC','591297077_rm_2.jpg','Active',1,'2023-05-20 12:40:57','2023-05-20 12:40:57'),
(68,19,'my post','post summary','post description','644906052_images.jpg','Active',1,'2023-05-21 16:27:43','2023-05-21 16:27:43');

/*Table structure for table `post_atachment` */

DROP TABLE IF EXISTS `post_atachment`;

CREATE TABLE `post_atachment` (
  `post_atachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `post_attachment_title` varchar(200) DEFAULT NULL,
  `post_attachment_path` text DEFAULT NULL,
  `is_active` enum('Active','InActive') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`post_atachment_id`),
  KEY `fk1` (`post_id`),
  CONSTRAINT `fk1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=157 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `post_atachment` */

insert  into `post_atachment`(`post_atachment_id`,`post_id`,`post_attachment_title`,`post_attachment_path`,`is_active`,`created_at`,`updated_at`) values 
(140,55,'my place','531263216_12.jpg','Active','2023-05-18 11:48:51','2023-05-18 11:48:51'),
(141,55,'my place 2','749128738_real_madrid.jpg','Active','2023-05-18 11:48:51','2023-05-18 11:48:51'),
(152,63,'att1','2134713175_12.jpg','Active','2023-05-20 10:02:43','2023-05-20 10:02:43'),
(153,63,'att2','1173426958_real_madrid.jpg','Active','2023-05-20 10:02:43','2023-05-20 10:02:43'),
(154,63,'att3','710817167_ko.jpg','Active','2023-05-20 10:02:43','2023-05-20 10:02:43'),
(155,68,'aa222','278978664_rm_2.jpg','Active','2023-05-21 16:27:44','2023-05-21 16:27:44'),
(156,68,'att3','1799258272_images.jpg','Active','2023-05-21 16:27:44','2023-05-21 16:27:44');

/*Table structure for table `post_category` */

DROP TABLE IF EXISTS `post_category`;

CREATE TABLE `post_category` (
  `post_category_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`post_category_id`),
  KEY `post_id` (`post_id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `post_category_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `post_category_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `post_category` */

insert  into `post_category`(`post_category_id`,`post_id`,`category_id`,`created_at`,`updated_at`) values 
(65,54,10,'2023-05-18 11:47:02','2023-05-18 11:47:02'),
(66,54,9,'2023-05-18 11:47:02','2023-05-18 11:47:02'),
(67,55,10,'2023-05-18 11:48:50','2023-05-18 11:48:50'),
(68,55,9,'2023-05-18 11:48:50','2023-05-18 11:48:50'),
(69,56,10,'2023-05-18 12:19:36','2023-05-18 12:19:36'),
(70,56,9,'2023-05-18 12:19:36','2023-05-18 12:19:36'),
(84,64,10,'2023-05-20 11:12:39','2023-05-20 11:12:39'),
(85,64,9,'2023-05-20 11:12:40','2023-05-20 11:12:40'),
(86,65,10,'2023-05-20 11:15:16','2023-05-20 11:15:16'),
(87,56,11,'2023-05-20 11:42:52','2023-05-20 11:42:52'),
(88,56,12,'2023-05-20 11:43:02','2023-05-20 11:43:02'),
(89,66,12,'2023-05-20 12:29:22','2023-05-20 12:29:22'),
(90,66,11,'2023-05-20 12:29:22','2023-05-20 12:29:22'),
(91,66,10,'2023-05-20 12:29:22','2023-05-20 12:29:22'),
(92,66,9,'2023-05-20 12:29:22','2023-05-20 12:29:22'),
(93,67,12,'2023-05-20 12:40:57','2023-05-20 12:40:57'),
(94,67,11,'2023-05-20 12:40:57','2023-05-20 12:40:57'),
(95,67,10,'2023-05-20 12:40:57','2023-05-20 12:40:57'),
(96,67,9,'2023-05-20 12:40:57','2023-05-20 12:40:57'),
(97,68,12,'2023-05-21 16:27:43','2023-05-21 16:27:43'),
(98,68,11,'2023-05-21 16:27:43','2023-05-21 16:27:43'),
(99,68,10,'2023-05-21 16:27:43','2023-05-21 16:27:43'),
(100,68,9,'2023-05-21 16:27:43','2023-05-21 16:27:43'),
(152,63,10,'2023-05-23 23:49:32','2023-05-23 23:49:32'),
(153,63,9,'2023-05-23 23:49:32','2023-05-23 23:49:32');

/*Table structure for table `post_comment` */

DROP TABLE IF EXISTS `post_comment`;

CREATE TABLE `post_comment` (
  `post_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `is_active` enum('Active','InActive') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`post_comment_id`),
  KEY `user_id` (`user_id`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `post_comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `post_comment_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `post_comment` */

insert  into `post_comment`(`post_comment_id`,`post_id`,`user_id`,`comment`,`is_active`,`created_at`) values 
(5,54,1,'Such a perfect picture','Active','2023-05-20 16:23:48'),
(6,54,1,'Wow, what a masterpiece','Active','2023-05-20 09:25:04'),
(7,54,1,'How come your every post is so perfect!\n','Active','2023-05-20 09:26:57'),
(8,54,1,'I can’t help but feel jealous\n','Active','2023-05-20 09:27:13'),
(9,56,1,'I\'m running out of comments to share on your pictures ','Active','2023-05-20 09:27:34'),
(10,56,1,'Stop copying me. By the way, this time, you copied well.\n','Active','2023-05-20 09:27:54'),
(11,56,1,'You are stunning!','Active','2023-05-20 09:28:05'),
(12,56,1,'Just when I couldn’t love you more. You posted this pic, and my jaw dropped to the floor\n','Active','2023-05-20 09:28:21'),
(13,54,13,'You have the beautiful features of a sea mermaid. \n','Active','2023-05-20 09:29:02'),
(14,54,13,'You have the beautiful features of a sea mermaid','Active','2023-05-20 09:29:16'),
(15,54,13,'Stop being too perfect\n','Active','2023-05-20 09:29:26'),
(16,54,13,'It is my pleasure to see such beauty\n','Active','2023-05-20 09:30:11'),
(17,56,13,'It is my pleasure to see such beauty.\n','Active','2023-05-20 09:30:35'),
(18,56,13,'Astonishing natural beauty with tremendous charm and gorgeousness.\n','Active','2023-05-20 09:30:57'),
(19,56,13,'This picture is astounding','Active','2023-05-20 09:31:08'),
(20,56,13,'This is the most remarkable thing I have seen today. \n','Active','2023-05-20 09:31:17'),
(21,54,14,'You are like sunshine when it is raining in my life. \n','Active','2023-05-20 09:31:53'),
(22,54,14,'Stop being too perfect','Active','2023-05-20 09:32:05'),
(23,56,14,'Your beauty is one of the things I like about you. ','Active','2023-05-20 09:32:18'),
(24,56,1,'hello brother','Active','2023-05-20 09:49:09'),
(25,56,1,'hy ahsan','Active','2023-05-20 09:53:55'),
(26,54,1,'good to see you mate','Active','2023-05-20 10:00:37'),
(27,56,1,'wow amazing','Active','2023-05-20 10:49:42'),
(28,56,1,'welldone','Active','2023-05-20 10:50:49'),
(29,56,1,'aaaa','Active','2023-05-20 10:51:33'),
(30,56,1,'wow','Active','2023-05-20 10:53:19'),
(31,56,1,'ahsan jawed it is working','Active','2023-05-20 10:55:45'),
(32,54,1,'just posts are perfect','Active','2023-05-20 22:37:04'),
(33,68,1,'good to see you mat','Active','2023-05-22 21:21:52'),
(34,54,1,'Mashallah','Active','2023-05-23 21:28:28'),
(35,54,1,'wah wah bro','Active','2023-05-23 21:29:35');

/*Table structure for table `role` */

DROP TABLE IF EXISTS `role`;

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_type` varchar(50) NOT NULL,
  `is_active` enum('Active','InActive') DEFAULT 'Active',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `role` */

insert  into `role`(`role_id`,`role_type`,`is_active`) values 
(1,'admin','Active'),
(2,'user','InActive');

/*Table structure for table `setting` */

DROP TABLE IF EXISTS `setting`;

CREATE TABLE `setting` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `setting_key` varchar(100) DEFAULT NULL,
  `setting_value` varchar(100) DEFAULT NULL,
  `setting_status` enum('Active','InActive') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`setting_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `setting_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `setting` */

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` text NOT NULL,
  `gender` enum('Male','Female','other') DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `user_image` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `is_approved` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `is_active` enum('Active','InActive') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`user_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user` */

insert  into `user`(`user_id`,`role_id`,`first_name`,`last_name`,`email`,`password`,`gender`,`date_of_birth`,`user_image`,`address`,`is_approved`,`is_active`,`created_at`,`updated_at`) values 
(1,1,'ahsan','jawed','ahsan@gmail.com','ahsan123','Male','2001-01-26','1221991119_12.jpg','hyderabad','Approved','Active','2023-05-11 09:18:17','2023-05-22 00:19:17'),
(13,1,'arsalan','malana','arsal@gmail.com','ahsan123','Female','2023-05-19','1270706170_user_img.jpg','karachi','Approved','Active','2023-05-17 09:29:28','2023-05-17 10:22:21'),
(14,2,'hamza','arain','hamza@gmail.com','ahsan123','Male','2023-05-09','1929346793_user_img.jpg','bypass','Approved','Active','2023-05-17 09:30:45','2023-05-22 00:19:31'),
(23,2,'ahscs','sjjc','malanaarsal@gmail.com','ahsan123','Male','2023-05-12','1610049195_ahsan.JPEG','house#13','Pending','Active','2023-05-21 17:48:13','2023-05-23 07:10:31');

/*Table structure for table `user_feedback` */

DROP TABLE IF EXISTS `user_feedback`;

CREATE TABLE `user_feedback` (
  `feedback_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`feedback_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*Data for the table `user_feedback` */

insert  into `user_feedback`(`feedback_id`,`user_id`,`user_name`,`user_email`,`feedback`,`created_at`,`updated_at`) values 
(1,1,'ahsans jawed','ahsan@gmail.com','nice to ,meet you','2023-05-21 10:02:59','2023-05-21 10:02:59'),
(2,1,'ahsan jawed','ahsan@gmail.com','now updated','2023-05-21 10:03:50','2023-05-21 10:03:50'),
(6,NULL,'hamza arain','hamza@gmail.com','ahdwq;qd','2023-05-21 10:06:54','2023-05-21 10:06:54'),
(7,NULL,'hamza arain','hamza@gmail.com','ahdwq;qd','2023-05-21 10:09:12','2023-05-21 10:09:12'),
(8,1,'ahsan jawed','ahsan@gmail.com','wow','2023-05-21 10:12:44','2023-05-21 10:12:44'),
(9,NULL,'sergio ramos','sergio@gmail.com','i am sergio','2023-05-21 23:58:51','2023-05-21 23:58:51'),
(10,NULL,'abc def','abc@gmail.com','i want to be a registered user','2023-05-22 00:23:11','2023-05-22 00:23:11');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
