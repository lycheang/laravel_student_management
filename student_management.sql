CREATE DATABASE  IF NOT EXISTS `php_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `php_db`;
-- MySQL dump 10.13  Distrib 8.0.29, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: php_db
-- ------------------------------------------------------
-- Server version	8.0.29

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `attendances`
--

DROP TABLE IF EXISTS `attendances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `attendances` (
  `attendance_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint unsigned NOT NULL,
  `subject_id` bigint unsigned NOT NULL,
  `attendance_date` date NOT NULL,
  `status` enum('present','absent') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'absent',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`attendance_id`),
  KEY `attendances_student_id_foreign` (`student_id`),
  CONSTRAINT `attendances_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendances`
--

LOCK TABLES `attendances` WRITE;
/*!40000 ALTER TABLE `attendances` DISABLE KEYS */;
INSERT INTO `attendances` VALUES (1,1,2,'2025-08-24','present','2025-08-23 23:45:17','2025-08-23 23:45:34'),(2,1,1,'2025-08-24','present','2025-08-23 23:47:23','2025-08-23 23:47:23'),(3,1,4,'2025-08-26','present','2025-08-24 23:53:48','2025-08-25 22:01:22'),(4,1,4,'2025-08-26','present','2025-08-25 00:59:31','2025-08-25 10:00:22'),(5,1,3,'2025-08-26','present','2025-08-25 01:00:00','2025-08-25 10:00:45'),(6,1,1,'2025-08-26','absent','2025-08-25 01:37:47','2025-08-25 10:03:12'),(7,2,1,'2025-08-25','present','2025-08-25 08:03:14','2025-08-25 08:03:14'),(8,3,1,'2025-08-25','absent','2025-08-25 08:03:27','2025-08-25 08:03:27');
/*!40000 ALTER TABLE `attendances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_08_23_115740_create_students_table',1),(5,'2025_08_23_120018_create_teachers_table',1),(6,'2025_08_24_045933_create_subjects_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('7F4HJxnpspxQrl9TxkukKLhnngsJx7KDrQfC2JQv',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZkgwUXdjWEdhR2RRYkxxakQyN05xVzFDWHllVXZPRVpPV1NBektKTiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=',1756184557),('ffuj1xFHfV5eQvWA1LiMGkPgqae8YeSmHqg136R2',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoicWY1M1F4UHEwRkpjTTM3RFFuNTQ1NEF1ZjhSUDBSTUNtSDVpaGRMMCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kYXNoYm9hcmQiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=',1756141861),('Hohkzj7YsSismrvBTn9zzxuqmvQfT3R8aO1aKfOr',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZWVaRzFsUzZMbTFWYk9DSjJ3QWVuWExoSUxReHU4amRJUU1PdWZNeCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdWJqZWN0cyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1756187938);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `students` (
  `student_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `student_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `student_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL DEFAULT '2000-01-01',
  `major` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `is_graduate` tinyint(1) NOT NULL DEFAULT '0',
  `enrollment_date` date NOT NULL,
  `graduation_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`student_id`),
  UNIQUE KEY `students_student_email_unique` (`student_email`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,'Guadalupe O\'Connell','$2y$12$AVUol5iYKg12zr3uf4reeONInjfN.YFOSjM3ruELeRtzXYLT.HO0O','jakubowski.nicolette@example.com','students/2025-08-25.jpeg','Male','6671 Paucek Summit Apt. 045East Romaland, AL 58494-3483','+1-260-346-0076111','2025-08-25','Arts',1,1,'2025-08-25',NULL,'2025-08-23 23:42:47','2025-08-25 09:39:50',NULL),(2,'Casimir Paucek','$2y$12$QHrhplRTqcW7F.KV4fiDhOw6BL8gTPsTBZCbYycvr5YSYjCm.oDMq','akuvalis@example.org','as.jpeg','Male','2484 Gerlach Crescent Apt. 148\nPort Cleta, IL 94994','+1-484-716-2046','2006-10-09','Arts',1,0,'2024-11-17',NULL,'2025-08-23 23:42:47','2025-08-23 23:42:47',NULL),(3,'Darien Volkman','$2y$12$wlNOhLjOaSMCcxmGs7lniO55Flh81yIhrUXvNKTznp8bhUrDN7FS2','green91@example.org','as.jpeg','Male','61196 Smitham Track\nNew Creolaburgh, VA 94856','+1 (404) 581-7890','2005-12-14','Arts',1,0,'2024-03-17',NULL,'2025-08-23 23:42:47','2025-08-23 23:42:47',NULL),(4,'Jeffry Rolfson','$2y$12$qu4P/SgVmVaa/8En6wO1ueEJpUkGfyyEJWhCYm5OQkukfjQ14Tjt6','brendon79@example.org','as.jpeg','Male','889 Noemie Lake\nElnoraside, AZ 66856','+1 (607) 280-1087','1999-07-22','Science',0,0,'2023-10-02',NULL,'2025-08-23 23:42:47','2025-08-23 23:42:47',NULL),(5,'Nico Macejkovic','$2y$12$rjIn2VrKqpzQtiJSPma5MucRBWj17piJDi9Cm14tunmaNuT3XEb2S','esta69@example.org','as.jpeg','Male','3048 Schamberger Estates\nMadelinestad, FL 69799','1-520-851-2823','2005-09-23','Computer Science',1,0,'2025-04-15',NULL,'2025-08-23 23:42:47','2025-08-23 23:42:47',NULL),(6,'Flavie Ratke','$2y$12$Psrr1QQuiMUTPJ9Z72CuDO5UK0rJncWc4.lNGophMZ2ZUvr4CBDzC','oleannon@example.com','as.jpeg','Male','344 Birdie Ramp Suite 375\nHermannville, AZ 57939','+1-219-480-8660','1998-02-11','Science',1,0,'2025-05-13',NULL,'2025-08-23 23:42:47','2025-08-23 23:42:47',NULL),(7,'Miss Baby Schuster DDS','$2y$12$CsobUcI9hshsl1aaPe1Tg.TR8u96k2Aw32jyTIBCRNGhqEs0Zu18S','erika95@example.org','as.jpeg','Female','811 Smitham Plaza Apt. 126\r\nSouth Ruthie, NM 59182-5672','954-242-2620','2025-08-24','Science',1,0,'2025-08-24',NULL,'2025-08-23 23:42:47','2025-08-23 23:46:44',NULL),(8,'Mr. Joshuah Ullrich','$2y$12$z4lyqJ82HZyMdTBXeqtMCOkyzV29KvX8zE0ilcdDQ2tX26qID3uRu','ekassulke@example.net','as.jpeg','Female','2606 Jaskolski Rest Suite 934\nConroyhaven, LA 18810','+1 (740) 638-8838','2006-10-04','Science',1,0,'2023-03-21',NULL,'2025-08-23 23:42:47','2025-08-23 23:42:47',NULL),(9,'Raegan Ondricka II','$2y$12$0uYHKBFzQSLLrK//kCCJkOQgzePJnQf7wp9z5Va0rMot2cJlkpr3K','stark.lyric@example.com','as.jpeg','Male','124 Morar Glen Suite 950\nPort Brice, OR 06527','973-588-1632','2004-11-19','Business',1,0,'2024-11-11',NULL,'2025-08-23 23:42:47','2025-08-23 23:42:47',NULL),(10,'Kevin O\'Hara','$2y$12$IqbQam4OuC1buvtk7MZ9hubh1M4iSwziN6YAAk6fS1h5g12/wZUOq','erdman.cristina@example.net','as.jpeg','Female','89494 Ashleigh Turnpike Suite 144\nBreitenbergmouth, UT 47115','+1 (480) 539-6025','2005-11-19','Business',1,0,'2025-07-19',NULL,'2025-08-23 23:42:47','2025-08-25 09:39:28','2025-08-25 09:39:28'),(11,'Mercedes Lakin','$2y$12$GE6zYkqzJCKvfcmXCP/hXu5yFxT.KND.2n6khswGMU6P0.lEDSr0e','arianna.gottlieb@example.net','as.jpeg','Male','9748 Mueller View Suite 455\nLake Karolannville, IL 00945-6148','856.394.3765','2004-07-10','Engineering',1,0,'2021-09-04',NULL,'2025-08-23 23:42:47','2025-08-23 23:42:47',NULL),(12,'Dr. Ryann Schoen','$2y$12$NtKB4sSwB1ANQ0SjhpNljukQDDpqVudD/z5bgs7Ly6vWsWqUKUr0O','travon.fay@example.net','as.jpeg','Female','3342 Vince Neck Suite 694\nNew Annamae, OK 07661','+1-910-624-4345','2005-12-01','Business',1,0,'2022-01-09',NULL,'2025-08-23 23:42:47','2025-08-23 23:42:47',NULL),(13,'Tate Kassulke','$2y$12$w6zv196kX5Vf4PLdEajr..RIQH3CKUXOc.DDehfH7J6LNmwR4IKzG','alysa.little@example.com','as.jpeg','Male','100 Tomas Gardens\nNorth Loyton, MO 57991-5137','1-864-249-3746','2004-02-28','Business',1,0,'2024-11-17',NULL,'2025-08-23 23:42:47','2025-08-23 23:42:47',NULL),(14,'Reggie Metz V','$2y$12$9BhdALJ2bdS/XvJjrL9y/eRg9DqXZZM3UydOpr014HTFwC0uBzJde','fstroman@example.org','as.jpeg','Male','12746 Brice Trail Suite 991\nPurdyside, CO 77279','+1 (812) 352-8818','2002-12-15','Engineering',1,0,'2023-06-23',NULL,'2025-08-23 23:42:47','2025-08-23 23:42:47',NULL),(15,'Salma Steuber','$2y$12$yPKccmbmJsl/RMi8zvQM0OyEDR7se1a1vOpOT5h17L0khoJN2HV/2','jernser@example.net','as.jpeg','Male','8674 Sporer Burg\nPort Johnathon, ID 11004','706.400.0863','2003-04-25','Engineering',1,0,'2025-04-27',NULL,'2025-08-23 23:42:47','2025-08-23 23:42:47',NULL),(16,'Jack Kling Sr.','$2y$12$4leFSqVaJfFXnnXGfzTxp.BEx3zPKGMoKoUG6v/i.bnWYGbXhODLi','nathaniel.nader@example.net','as.jpeg','Male','275 Bud Station Suite 475\nArlobury, MS 19542','(501) 891-2958','2001-09-10','Arts',0,0,'2022-07-21',NULL,'2025-08-23 23:42:47','2025-08-23 23:42:47',NULL),(17,'Prof. Ben Hartmann','$2y$12$W3bLebU31TXgfeasvHj8nOjtfO1gIzzcPuehL/yBq5irNUv.VtO/a','mckenzie.zora@example.com','as.jpeg','Female','1695 Amparo Row Apt. 131\nLake Paristown, SD 21143','+1-820-950-8389','2006-08-12','Computer Science',1,0,'2024-03-14',NULL,'2025-08-23 23:42:47','2025-08-23 23:42:47',NULL),(18,'Polly Ortiz','$2y$12$M/seKGBBT29nmDBQ2ZFNZeBnv7zxvyWCM.oJYjltl6lXnqRMc7SjO','jasper74@example.com','as.jpeg','Male','1032 Reichert Overpass\nPort Nikolas, WI 62425-2588','878.869.2609','2005-02-01','Engineering',0,0,'2024-09-29',NULL,'2025-08-23 23:42:47','2025-08-23 23:42:47',NULL),(19,'Kennith Murphy','$2y$12$ZJGWvBgMUc9I9FGvrBHbmu6kkAdwW1wm1V4WNscDIPTOkO58teNxu','amiya.kautzer@example.com','as.jpeg','Male','97979 Rosemarie Groves Suite 322\nBeahanborough, OK 57587-0271','(234) 576-2025','2003-06-10','Business',1,0,'2022-05-13',NULL,'2025-08-23 23:42:47','2025-08-23 23:42:47',NULL),(20,'Valentine O\'Conner','$2y$12$T5sCcIYPhZqseYeIg8L4vuRIDSg/nCgrY0aqrj3ewwNSevcfxx.AG','paucek.darrick@example.org','as.jpeg','Female','31670 Rempel Turnpike Apt. 034\r\nEast Miguel, IN 53524-4799','+1.920.713.1711','1999-05-31','Engineering',1,1,'2024-02-15',NULL,'2025-08-23 23:42:47','2025-08-25 00:07:02',NULL),(21,'Ly BunChheang','$2y$12$WTDFMrjS1.MsmPnMHNegfeibfAPRPmR7C3fEzaWsKGwG2au3jRO7G','chheanggs@gmail.com','students/834d8dmUsaDelDoOq8HBGrB6ZUr17hYN4WHvfGk9.jpg','Male','Dey Huy\r\nDey Lo','089876718','2025-08-25','Science',1,0,'2025-08-25','2029-08-25','2025-08-25 02:06:11','2025-08-25 02:06:11',NULL),(22,'Ly BunChheang','$2y$12$G9j0J6CTOvYN4i05boaku.s60GCbYfRPT0A8ppngxAvFCqQZwddc.','chheanggss@gmail.com','students/2025-08-25-163129.gif','Male','Dey Huy\r\nDey Lo','089876718','2025-08-25','Arts',1,0,'2025-08-25','2029-08-25','2025-08-25 09:31:29','2025-08-25 09:31:29',NULL);
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subjects`
--

DROP TABLE IF EXISTS `subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `subjects` (
  `subject_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `subject_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher_id` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`subject_id`),
  KEY `subjects_teacher_id_foreign` (`teacher_id`),
  CONSTRAINT `subjects_teacher_id_foreign` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`teacher_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subjects`
--

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;
INSERT INTO `subjects` VALUES (1,'Computer_Scince',1,'2025-08-23 23:42:52','2025-08-23 23:43:46',NULL),(2,'Biology',2,'2025-08-23 23:42:53','2025-08-23 23:43:52',NULL),(3,'law',3,'2025-08-23 23:42:53','2025-08-23 23:44:02',NULL),(4,'Logistic',4,'2025-08-23 23:42:53','2025-08-23 23:44:10',NULL),(5,'Finance',5,'2025-08-23 23:42:53','2025-08-25 00:47:54','2025-08-25 00:47:54'),(6,'Finance',3,'2025-08-25 00:48:13','2025-08-25 00:48:13',NULL);
/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `teachers`
--

DROP TABLE IF EXISTS `teachers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `teachers` (
  `teacher_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `teacher_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `teacher_password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`teacher_id`),
  UNIQUE KEY `teachers_teacher_email_unique` (`teacher_email`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `teachers`
--

LOCK TABLES `teachers` WRITE;
/*!40000 ALTER TABLE `teachers` DISABLE KEYS */;
INSERT INTO `teachers` VALUES (1,'Prof. Jena Smith','allan.will@example.net','$2y$12$N9QueblN4f5Y2XDokfGTa.lxxY5yA1LRYb1of.rLvN7WaQ22Oov5S','teachers/2025-08-26.gif','(713) 291-1351',1,'2025-08-23 23:42:53','2025-08-25 21:57:27',NULL),(2,'Khalid Prosacco','raynor.eve@example.com','$2y$12$5xXnPhbomq0lGH5kL2ZNFOmcJZ0YmJWnq6PDvZN4Z6VjB2daBhzNO','students/2025-08-25.jpeg','1-838-210-2725',1,'2025-08-23 23:42:53','2025-08-25 10:05:01',NULL),(3,'Martina Heidenreich','ernser.andreane@example.org','$2y$12$J0GZEquXCAU2BA.2AyYrCeV9t8LAo/uEUMeRc8j4xEsV3EfoFXlke','as.jpeg','1-740-956-0019',1,'2025-08-23 23:42:53','2025-08-23 23:42:53',NULL),(4,'Earl Dare','hardy.skiles@example.net','$2y$12$fnj2ur4.YseRWrpBG1UQeOgXY5nP/BR/Ym/l7NgcRHVKTyI7/e1Uy','as.jpeg','+1-754-950-0030',1,'2025-08-23 23:42:53','2025-08-23 23:42:53',NULL),(5,'Maurice Welch Sr.','littel.ashtyn@example.org','$2y$12$dqX36TzVm0RxBJdAUIbSTOTbs3nqDscJsJQ6k6kT.QP1oaT9MCL7K','as.jpeg','+1 (551) 473-4590',1,'2025-08-23 23:42:53','2025-08-23 23:42:53',NULL),(6,'Judge Herzog IV','elenora.jacobson@example.net','$2y$12$yxX0195F6R34d7sRjUIkBuy5iNnoJxmOOL3iIWGrfcC8wDoKNPepe','as.jpeg','(781) 718-2010',1,'2025-08-23 23:43:03','2025-08-23 23:43:03',NULL),(7,'Adalberto Brakus','bechtelar.akeem@example.org','$2y$12$jmmEBK/Me78G2cBlcUEmr.hYcs8V2DvgzH1flzhzJ9/eIDBLGs9Yq','as.jpeg','934.778.7390',1,'2025-08-23 23:43:03','2025-08-23 23:43:03',NULL),(8,'Mrs. Alva Streich MD','adalberto51@example.org','$2y$12$gm5ZfmgjuBCcgmp9Zb8InegiXO2QtuvPUanFztt7/03yl/9ZZ0ilO','as.jpeg','1-848-367-3430',1,'2025-08-23 23:43:03','2025-08-23 23:43:03',NULL),(9,'Elmo Grimes','glennie35@example.com','$2y$12$SFy.PMgyOXbKj4.2YBUo5evLU/6vm1s1OgzVjGRUcrglYmEOwcPFy','as.jpeg','534.407.8068',1,'2025-08-23 23:43:03','2025-08-23 23:43:03',NULL),(10,'Jeromy Wiza','christy.reynolds@example.net','$2y$12$yTAQ8SojGslTjmtbRJTZa.xAkmlydu3VgKaU9r3KhfVXLj5Nf.0.S','as.jpeg','+1-815-808-2781',1,'2025-08-23 23:43:03','2025-08-23 23:43:03',NULL),(11,'Ms. Delfina Tillman Sr.','koelpin.russell@example.com','$2y$12$6UGzFQhwIPJFMAnIRerjnucf9WEhGZQmaLR4rhnkaWC44ezthhDj6','as.jpeg','+1 (629) 978-4823',1,'2025-08-23 23:43:03','2025-08-23 23:43:03',NULL),(12,'Libby Spencer','nicolas.janae@example.com','$2y$12$DT16uZc18pxNqowFFqFuKuIxugvsfhJFSS3Ol8hD8zFVyyZoTTPRi','as.jpeg','+14352259156',1,'2025-08-23 23:43:03','2025-08-23 23:43:03',NULL),(13,'Penelope Rohan','wcorwin@example.com','$2y$12$4WhAFDHJ37jKeCR.rWSV2udQTGCUeF8U4GpePALAL9tpGrYrpvndG','as.jpeg','+1-516-273-3077',1,'2025-08-23 23:43:03','2025-08-23 23:43:03',NULL),(14,'Paxton O\'Connell','parisian.leland@example.org','$2y$12$RnQXeLS98l.Y2UEXjl5Rp.5wf6B0CB63gmA5.ObQfHp1WGk0Pfw1y','as.jpeg','423.914.8807',1,'2025-08-23 23:43:03','2025-08-23 23:43:03',NULL),(15,'Dion Dietrich','okulas@example.net','$2y$12$dAAzIR4G/Ij2kdv3glUX8.Rm92LAR0ksfIVg89P4t/zSfd3K2tBNS','as.jpeg','1-951-742-5573',1,'2025-08-23 23:43:03','2025-08-23 23:43:03',NULL),(16,'Ly BunChheang','chheanggs@gmail.com','$2y$12$mG1eOKEeDxlCg94qN1eveu6ikz37T1IhtrFApgBh5cPYbxVRm/ama','teachers/2025-08-26.jpg','089876718',1,'2025-08-25 08:22:45','2025-08-25 21:59:17',NULL),(17,'Ly BunChheang','chheanggs@gmail.coma','$2y$12$Gn0sqgOEAfuaKGBGdwwwqOzN3aaLQ12cWYIC42POHHAuLwkYAqygO',NULL,'089876718',1,'2025-08-25 10:07:50','2025-08-25 10:07:50',NULL),(18,'Ly BunChheang','chheanaggs@gmail.com','$2y$12$JOHiXCTTt5w3oCf6oXLC5eBgYxN4mjHHfTHM2tJ8v92gUiDfZSGCG','teachers/2025-08-26-045801.png','089876718',1,'2025-08-25 21:58:02','2025-08-25 21:58:31',NULL);
/*!40000 ALTER TABLE `teachers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Test User','test@example.com','2025-08-24 00:56:59','$2y$12$tYcxNKAiKm4eORr9oZlk8eabs6YvZJvw6ZhhnMhk7254q97cARbn.','Vj07qZD5ki96kKqvCwrOylnMEhOoa6EPgx3DLed14HK4I2jG5uENHzh0AuKB','2025-08-24 00:57:00','2025-08-24 00:57:00'),(2,'bunchheang','lbc@gmail.com',NULL,'$2y$12$agwKR7CEQHZFScXxvYbqG.HhK7EWlyUdT1L9sjquY7rWUQThme6HO',NULL,'2025-08-24 01:30:38','2025-08-24 01:30:38');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-08-26 13:05:02
