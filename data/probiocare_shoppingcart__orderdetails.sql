-- MySQL dump 10.13  Distrib 8.0.33, for Win64 (x86_64)
--
-- Host: localhost    Database: probiocare
-- ------------------------------------------------------
-- Server version	8.0.33

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
-- Table structure for table `shoppingcart__orderdetails`
--

DROP TABLE IF EXISTS `shoppingcart__orderdetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `shoppingcart__orderdetails` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int unsigned NOT NULL,
  `product_id` int unsigned NOT NULL,
  `price` double NOT NULL,
  `qty` int NOT NULL,
  `total` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shoppingcart__orderdetails_order_id_foreign` (`order_id`),
  CONSTRAINT `shoppingcart__orderdetails_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `shoppingcart__orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shoppingcart__orderdetails`
--

LOCK TABLES `shoppingcart__orderdetails` WRITE;
/*!40000 ALTER TABLE `shoppingcart__orderdetails` DISABLE KEYS */;
INSERT INTO `shoppingcart__orderdetails` VALUES (1,1,2,189000,1,189000,'2024-04-01 21:14:57','2024-04-01 21:14:57'),(2,2,2,189000,1,189000,'2024-04-01 21:29:05','2024-04-01 21:29:05'),(3,3,2,189000,1,189000,'2024-04-01 21:31:41','2024-04-01 21:31:41'),(4,4,2,189000,1,189000,'2024-04-01 21:32:36','2024-04-01 21:32:36'),(5,5,2,189000,1,189000,'2024-04-15 02:45:04','2024-04-15 02:45:04'),(6,6,2,189000,1,189000,'2024-04-15 02:48:59','2024-04-15 02:48:59'),(7,7,2,189000,1,189000,'2024-04-15 02:49:02','2024-04-15 02:49:02'),(8,8,2,189000,1,189000,'2024-04-15 02:49:21','2024-04-15 02:49:21'),(9,9,2,189000,1,189000,'2024-04-15 02:49:37','2024-04-15 02:49:37'),(10,10,2,189000,1,189000,'2024-04-15 02:59:21','2024-04-15 02:59:21'),(11,11,2,189,2,378,'2024-04-22 01:09:56','2024-04-22 01:09:56'),(12,12,2,189,2,378,'2024-04-22 01:09:59','2024-04-22 01:09:59'),(13,13,2,189,2,378,'2024-04-22 01:10:08','2024-04-22 01:10:08'),(14,14,2,189,2,378,'2024-04-22 01:10:09','2024-04-22 01:10:09'),(15,15,2,189,2,378,'2024-04-22 01:10:11','2024-04-22 01:10:11'),(16,16,2,189,2,378,'2024-04-22 01:10:14','2024-04-22 01:10:14'),(17,17,2,189,2,378,'2024-04-22 01:10:17','2024-04-22 01:10:17'),(18,18,2,189,2,378,'2024-04-22 01:10:19','2024-04-22 01:10:19'),(19,19,2,189,2,378,'2024-04-22 01:10:22','2024-04-22 01:10:22'),(20,20,2,189,2,378,'2024-04-22 01:10:25','2024-04-22 01:10:25'),(21,21,2,189,2,378,'2024-04-22 01:10:27','2024-04-22 01:10:27'),(22,22,2,189,2,378,'2024-04-22 01:10:30','2024-04-22 01:10:30'),(23,23,2,189,2,378,'2024-04-22 01:10:32','2024-04-22 01:10:32'),(24,24,2,189,2,378,'2024-04-22 01:10:35','2024-04-22 01:10:35'),(25,25,2,189,2,378,'2024-04-22 01:10:38','2024-04-22 01:10:38'),(26,26,2,189,2,378,'2024-04-22 01:10:40','2024-04-22 01:10:40'),(27,27,2,189,2,378,'2024-04-22 01:10:43','2024-04-22 01:10:43'),(28,28,2,189,2,378,'2024-04-22 01:10:46','2024-04-22 01:10:46'),(29,29,2,189,3,567,'2024-04-22 01:11:10','2024-04-22 01:11:10'),(30,30,2,189,3,567,'2024-04-22 01:11:19','2024-04-22 01:11:19'),(31,31,2,189,3,567,'2024-04-22 01:11:21','2024-04-22 01:11:21'),(32,32,2,189,3,567,'2024-04-22 01:11:24','2024-04-22 01:11:24'),(33,33,2,189,3,567,'2024-04-22 01:11:26','2024-04-22 01:11:26'),(34,34,2,189,3,567,'2024-04-22 01:11:28','2024-04-22 01:11:28'),(35,35,2,189,3,567,'2024-04-22 01:11:31','2024-04-22 01:11:31'),(36,36,2,189,3,567,'2024-04-22 01:11:33','2024-04-22 01:11:33'),(37,37,2,189,3,567,'2024-04-22 01:11:36','2024-04-22 01:11:36'),(38,38,2,189,3,567,'2024-04-22 01:13:05','2024-04-22 01:13:05'),(39,39,2,189,3,567,'2024-04-22 01:13:08','2024-04-22 01:13:08'),(40,40,2,189,3,567,'2024-04-22 01:14:23','2024-04-22 01:14:23'),(41,41,2,189,3,567,'2024-04-22 01:15:49','2024-04-22 01:15:49'),(42,42,2,189,3,567,'2024-04-22 01:17:00','2024-04-22 01:17:00'),(43,43,2,189,3,567,'2024-04-22 01:17:47','2024-04-22 01:17:47'),(44,44,2,189,3,567,'2024-04-22 01:30:22','2024-04-22 01:30:22'),(45,45,2,189,3,567,'2024-04-22 01:33:24','2024-04-22 01:33:24'),(46,46,2,189,3,567,'2024-04-22 01:34:47','2024-04-22 01:34:47'),(47,47,2,189,3,567,'2024-04-22 01:35:17','2024-04-22 01:35:17'),(48,48,2,189,3,567,'2024-04-22 01:40:38','2024-04-22 01:40:38'),(49,49,2,189,3,567,'2024-04-22 01:42:00','2024-04-22 01:42:00'),(50,50,2,189,3,567,'2024-04-22 01:42:28','2024-04-22 01:42:28'),(51,51,2,189,3,567,'2024-04-22 01:43:01','2024-04-22 01:43:01'),(52,52,2,189,3,567,'2024-04-22 01:43:37','2024-04-22 01:43:37'),(53,53,2,189,3,567,'2024-04-22 01:48:26','2024-04-22 01:48:26'),(54,54,2,189,3,567,'2024-04-22 01:49:59','2024-04-22 01:49:59'),(55,55,2,189,3,567,'2024-04-22 01:55:56','2024-04-22 01:55:56'),(56,56,2,189,3,567,'2024-04-22 02:00:11','2024-04-22 02:00:11'),(57,57,2,189,3,567,'2024-04-22 02:07:27','2024-04-22 02:07:27'),(58,58,2,189,3,567,'2024-04-22 02:08:09','2024-04-22 02:08:09'),(59,59,2,189,3,567,'2024-04-22 02:11:17','2024-04-22 02:11:17'),(60,60,2,189,3,567,'2024-04-22 02:14:31','2024-04-22 02:14:31'),(61,61,2,189,3,567,'2024-04-22 02:15:26','2024-04-22 02:15:26'),(62,62,2,189,3,567,'2024-04-22 02:16:32','2024-04-22 02:16:32'),(63,63,2,189,3,567,'2024-04-22 02:17:38','2024-04-22 02:17:38'),(64,64,2,189,3,567,'2024-04-22 02:19:39','2024-04-22 02:19:39'),(65,65,2,189,3,567,'2024-04-22 02:21:09','2024-04-22 02:21:09'),(66,66,2,189,3,567,'2024-04-22 02:21:37','2024-04-22 02:21:37'),(67,67,2,189,1,189,'2024-04-23 19:55:37','2024-04-23 19:55:37'),(68,68,2,189,1,189,'2024-04-23 19:59:42','2024-04-23 19:59:42'),(69,69,2,189,1,189,'2024-04-23 20:08:28','2024-04-23 20:08:28'),(70,70,2,189,1,189,'2024-04-23 20:08:32','2024-04-23 20:08:32'),(71,71,2,189,1,189,'2024-04-23 20:08:36','2024-04-23 20:08:36'),(72,72,2,189,1,189,'2024-04-23 20:08:45','2024-04-23 20:08:45'),(73,73,2,189,1,189,'2024-04-23 21:17:46','2024-04-23 21:17:46'),(74,74,2,189,1,189,'2024-04-23 21:18:02','2024-04-23 21:18:02'),(75,75,2,189,1,189,'2024-04-23 21:20:22','2024-04-23 21:20:22'),(76,76,2,189,1,189,'2024-04-24 02:16:59','2024-04-24 02:16:59'),(77,77,2,189,2,378,'2024-04-24 02:22:04','2024-04-24 02:22:04'),(78,78,2,189,1,189,'2024-04-24 02:30:21','2024-04-24 02:30:21'),(79,79,2,189,1,189,'2024-04-24 02:30:44','2024-04-24 02:30:44'),(80,80,2,189,1,189,'2024-04-24 02:35:35','2024-04-24 02:35:35'),(81,81,2,189,1,189,'2024-04-24 02:36:51','2024-04-24 02:36:51'),(82,82,2,189,1,189,'2024-04-24 02:38:04','2024-04-24 02:38:04'),(83,83,2,189,1,189,'2024-04-24 02:52:37','2024-04-24 02:52:37'),(84,84,2,189,1,189,'2024-05-03 19:42:11','2024-05-03 19:42:11'),(85,85,2,189,1,189,'2024-05-03 19:44:38','2024-05-03 19:44:38'),(86,86,2,189,1,189,'2024-05-03 19:47:41','2024-05-03 19:47:41'),(87,87,1,525,1,525,'2024-05-03 19:49:09','2024-05-03 19:49:09'),(88,88,2,155,1,155,'2024-05-10 01:55:40','2024-05-10 01:55:40'),(89,88,1,374,1,374,'2024-05-10 01:55:40','2024-05-10 01:55:40'),(90,89,8,476,1,476,'2024-05-13 04:30:17','2024-05-13 04:30:17'),(91,89,7,412,1,412,'2024-05-13 04:30:17','2024-05-13 04:30:17'),(92,90,8,476,2,952,'2024-05-13 04:33:03','2024-05-13 04:33:03'),(93,90,7,412,1,412,'2024-05-13 04:33:03','2024-05-13 04:33:03'),(94,91,8,476,2,952,'2024-05-13 04:36:40','2024-05-13 04:36:40'),(95,92,8,476,2,952,'2024-05-13 04:41:02','2024-05-13 04:41:02'),(96,94,8,476,1,476,'2024-05-13 04:45:10','2024-05-13 04:45:10'),(97,95,8,476,2,952,'2024-05-13 04:47:32','2024-05-13 04:47:32'),(98,96,8,476,1,476,'2024-05-13 04:55:24','2024-05-13 04:55:24'),(99,97,8,476,1,476,'2024-05-13 04:57:52','2024-05-13 04:57:52'),(100,97,7,412,1,412,'2024-05-13 04:57:52','2024-05-13 04:57:52'),(101,98,8,476,1,476,'2024-05-13 04:58:14','2024-05-13 04:58:14'),(102,98,7,412,1,412,'2024-05-13 04:58:14','2024-05-13 04:58:14');
/*!40000 ALTER TABLE `shoppingcart__orderdetails` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-05-18  9:20:41
