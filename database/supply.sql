CREATE DATABASE  IF NOT EXISTS `supply` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `supply`;
-- MySQL dump 10.13  Distrib 8.0.45, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: supply
-- ------------------------------------------------------
-- Server version	9.6.0

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
SET @MYSQLDUMP_TEMP_LOG_BIN = @@SESSION.SQL_LOG_BIN;
SET @@SESSION.SQL_LOG_BIN= 0;

--
-- GTID state at the beginning of the backup 
--

SET @@GLOBAL.GTID_PURGED=/*!80000 '+'*/ '96498148-19cc-11f1-957a-0a0027000009:1-26620';

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
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
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
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
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
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
-- Table structure for table `forecasts`
--

DROP TABLE IF EXISTS `forecasts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `forecasts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `forecast_period` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `forecast_demand` int NOT NULL,
  `demand_growth` decimal(5,2) NOT NULL,
  `current_stock` int NOT NULL,
  `inventory_coverage_days` int NOT NULL,
  `status` enum('Increasing','Stable','Decreasing') COLLATE utf8mb4_unicode_ci NOT NULL,
  `recommendation` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `forecasts`
--

LOCK TABLES `forecasts` WRITE;
/*!40000 ALTER TABLE `forecasts` DISABLE KEYS */;
/*!40000 ALTER TABLE `forecasts` ENABLE KEYS */;
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
  `attempts` smallint unsigned NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_07_25_070538_create_forecasts_table',1);
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
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `unit_type` varchar(50) NOT NULL,
  `unit_cost` decimal(12,2) NOT NULL,
  `current_stock` int NOT NULL DEFAULT '0',
  `reorder_point` int NOT NULL DEFAULT '0',
  `reorder_quantity` int NOT NULL,
  `priority_level` enum('High','Medium','Low') NOT NULL,
  `supplier_id` int DEFAULT NULL,
  PRIMARY KEY (`product_id`),
  KEY `supplier_id` (`supplier_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
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
INSERT INTO `sessions` VALUES ('SZ4Pb3bYcZeCz7mhBeKFRM2ljGaq4BoriDG8Layb',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36 Edg/150.0.0.0','eyJfdG9rZW4iOiIyWFg4Rkt5Q3B1ak52S1J1U1BmbmNjUFhjQkxVak9PU0ZKcmh0RGtZIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL3N1cHBseS50ZXN0XC9wcm9jdXJlbWVudFwvcG8tbWFuYWdlbWVudCIsInJvdXRlIjoicHJvY3VyZW1lbnQucG8tbWFuYWdlbWVudCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX19',1784990690);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suppliers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `sub_categories` varchar(255) DEFAULT NULL,
  `payment_terms` varchar(100) DEFAULT NULL,
  `rating` decimal(3,2) DEFAULT NULL,
  `delivery_schedule` varchar(100) DEFAULT NULL,
  `performance_score` int DEFAULT NULL,
  `status` enum('Active','Under Review','Inactive') NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'Galax',NULL,'Graphics','Overclocking Series GPUs','Net 30',2.50,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(2,'QNAP Systems',NULL,'Storage','Network Attached Storage (NAS)','Net 30',3.90,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(3,'Raidmax',NULL,'Power Supply','Modular Power Supplies','Net 30',2.00,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(4,'QNAP Systems',NULL,'Storage','Network Attached Storage (NAS)','Net 60',3.70,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(5,'Barrow',NULL,'Cooling','Water Cooling Fittings & Pumps','Net 60',1.60,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(6,'Silverstone Technology',NULL,'Power Supply','Compact SFX & ATX PSUs','COD',2.20,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(7,'Western Digital',NULL,'Storage','NVMe M.2 SSDs & HDDs','COD',3.90,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(8,'Gigabyte Technology',NULL,'Components','Motherboards & Expansion Cards','Net 30',4.60,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(9,'Vetroo',NULL,'Cooling','RGB Air & Liquid Coolers','Net 30',2.90,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(10,'Sapphire Technology',NULL,'Graphics','AMD Custom Partner GPUs','Net 60',4.80,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(11,'G.Skill International',NULL,'Components','High-Performance DDR5 RAM','Net 30',3.70,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(12,'Inno3D',NULL,'Graphics','Gaming Graphics Cards','Net 30',2.20,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(13,'SanDisk',NULL,'Storage','Flash Storage Solutions','COD',3.10,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(14,'Be Quiet!',NULL,'Power Supply','Low-Noise Power Supplies','COD',3.90,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(15,'Great Wall Corporation',NULL,'Power Supply','Standard & Modular PSUs','Net 60',3.90,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(16,'Synology',NULL,'Storage','Data Storage & NAS Hardware','Net 60',3.60,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(17,'Kuroutoshikou',NULL,'Graphics','PC Components & Graphics','COD',1.60,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(18,'Cougar Gaming',NULL,'Power Supply','80+ Certified Power Supplies','Net 60',1.40,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(19,'Gelid Solutions',NULL,'Cooling','Thermal Compounds & Fans','Net 60',4.10,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(20,'Netac Technology',NULL,'Storage','Portable & Internal SSDs','COD',2.10,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(21,'Azza',NULL,'Power Supply','Digital Power Units','Net 30',2.20,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(22,'Seagate Technology',NULL,'Storage','High-Capacity Enterprise Storage','Net 60',4.30,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(23,'XFX',NULL,'Graphics','AMD Radeon Graphics','Net 60',4.20,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(24,'Aerocool',NULL,'Cooling','Case Fans & Cooling Kits','Net 30',3.40,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(25,'Sirfa Electronics',NULL,'Power Supply','Power Conversion Units','Net 60',2.50,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(26,'Antec',NULL,'Power Supply','High-Current Power Units','Net 30',4.20,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(27,'Prolimatech',NULL,'Cooling','High-End Heatsinks','Net 60',3.20,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(28,'Zotac Technology',NULL,'Graphics','Mini PCs & NVIDIA GPUs','Net 30',4.90,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(29,'Silverstone Technology',NULL,'Power Supply','Compact SFX & ATX PSUs','COD',2.10,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(30,'Fractal Design',NULL,'Components','Chassis & PC Components','COD',1.90,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(31,'PNY Technologies',NULL,'Graphics','NVIDIA Quadro & GeForce GPUs','COD',4.00,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(32,'Sirfa Electronics',NULL,'Power Supply','Power Conversion Units','Net 60',1.30,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(33,'QNAP Systems',NULL,'Storage','Network Attached Storage (NAS)','COD',1.20,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(34,'Rosewill',NULL,'Power Supply','PC Power Components','Net 60',4.60,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(35,'Gunnir',NULL,'Graphics','Intel Arc Custom Partner Cards','Net 60',3.10,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(36,'SanDisk',NULL,'Storage','Flash Storage Solutions','COD',2.10,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(37,'Swiftech',NULL,'Cooling','Liquid Cooling Systems','Net 30',1.20,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(38,'Yeston',NULL,'Graphics','Stylized Custom Graphics Cards','COD',3.10,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(39,'Netac Technology',NULL,'Storage','Portable & Internal SSDs','COD',3.80,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(40,'Scythe',NULL,'Cooling','Compact CPU Air Coolers','Net 30',1.90,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(41,'NVIDIA Corporation',NULL,'Graphics','GPUs & AI Accelerators','Net 60',2.50,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(42,'Lexar',NULL,'Storage','Performance SSDs & Memory','COD',2.30,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(43,'Biwin Storage',NULL,'Storage','Embedded Storage Components','Net 60',3.00,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(44,'EK Water Blocks (EKWB)',NULL,'Cooling','Custom Loop Liquid Cooling','COD',1.90,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(45,'Sabrent',NULL,'Storage','High-Speed PCIe NVMe SSDs','Net 30',1.20,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(46,'Sapphire Technology',NULL,'Graphics','AMD Custom Partner GPUs','COD',2.30,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(47,'XFX',NULL,'Graphics','AMD Radeon Graphics','Net 60',4.60,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(48,'HuntKey Power',NULL,'Power Supply','Power Delivery Systems','Net 60',1.60,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(49,'InnoDisk',NULL,'Storage','Industrial Flash Storage','COD',2.90,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(50,'TeamGroup',NULL,'Storage','T-Force Gaming Storage','Net 60',1.10,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(51,'Samsung Electronics',NULL,'Storage','Enterprise & Consumer SSDs','Net 30',2.80,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(52,'Watercool',NULL,'Cooling','HEATKILLER Custom Loops','COD',2.20,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(53,'ADATA Technology',NULL,'Storage','Solid State Storage','Net 60',4.10,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(54,'Synology',NULL,'Storage','Data Storage & NAS Hardware','COD',5.00,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(55,'Alphacool',NULL,'Cooling','Radiators & Water Cooling','COD',3.30,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(56,'Other World Computing (OWC)',NULL,'Storage','Mac & PC Storage Solutions','Net 60',4.20,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(57,'Great Wall Corporation',NULL,'Power Supply','Standard & Modular PSUs','Net 60',3.40,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(58,'Inno3D',NULL,'Graphics','Gaming Graphics Cards','Net 30',1.30,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(59,'NZXT',NULL,'Cooling','Kraken Liquid Coolers','Net 60',1.40,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(60,'Thermalright',NULL,'Cooling','High-Performance Heatsinks','Net 60',1.10,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(61,'InnoDisk',NULL,'Storage','Industrial Flash Storage','Net 30',2.90,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(62,'Western Digital',NULL,'Storage','NVMe M.2 SSDs & HDDs','Net 60',2.90,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(63,'XFX',NULL,'Graphics','AMD Radeon Graphics','Net 30',2.90,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(64,'InnoDisk',NULL,'Storage','Industrial Flash Storage','COD',2.40,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(65,'Jonsbo',NULL,'Cooling','Aesthetic CPU Coolers','Net 60',2.20,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(66,'Lexar',NULL,'Storage','Performance SSDs & Memory','Net 30',1.90,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(67,'Cooler Master',NULL,'Cooling','Liquid AIO Coolers & Fans','Net 60',1.20,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(68,'SK Hynix',NULL,'Storage','NAND Flash & NVMe SSDs','Net 30',3.00,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(69,'Transcend Information',NULL,'Storage','Flash Modules & SSDs','Net 30',3.10,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(70,'Antec',NULL,'Power Supply','High-Current Power Units','Net 60',1.60,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(71,'Kioxia Corporation',NULL,'Storage','BiCS FLASH Memory SSDs','Net 30',3.90,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(72,'Apevia',NULL,'Power Supply','Budget Gaming PSUs','Net 60',3.60,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(73,'Leadtek Research',NULL,'Graphics','NVIDIA Professional Graphics','COD',2.10,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(74,'Arctic',NULL,'Cooling','Thermal Paste & Liquid Coolers','COD',4.90,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(75,'Zotac Technology',NULL,'Graphics','Mini PCs & NVIDIA GPUs','COD',2.10,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(76,'High Power (Sirtec)',NULL,'Power Supply','Desktop Power Systems','COD',3.50,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(77,'Other World Computing (OWC)',NULL,'Storage','Mac & PC Storage Solutions','COD',2.20,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(78,'Patriot Memory',NULL,'Storage','Viper Gaming SSDs','Net 60',1.10,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(79,'NZXT',NULL,'Cooling','Kraken Liquid Coolers','Net 60',2.80,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(80,'Colorful Technology',NULL,'Graphics','Motherboards & Custom GPUs','COD',2.80,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(81,'Antec',NULL,'Power Supply','High-Current Power Units','Net 30',1.90,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(82,'Other World Computing (OWC)',NULL,'Storage','Mac & PC Storage Solutions','COD',4.70,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(83,'Kuroutoshikou',NULL,'Graphics','PC Components & Graphics','Net 60',4.70,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(84,'Vetroo',NULL,'Cooling','RGB Air & Liquid Coolers','Net 30',2.70,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(85,'Intel Corporation',NULL,'Graphics','Arc Graphics & Processors','Net 30',2.10,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(86,'Transcend Information',NULL,'Storage','Flash Modules & SSDs','COD',3.20,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(87,'Fractal Design',NULL,'Components','Chassis & PC Components','Net 30',3.90,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(88,'Endorfy (SilentiumPC)',NULL,'Cooling','Silent CPU Coolers','Net 60',4.40,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(89,'Bykski',NULL,'Cooling','GPU Water Blocks & Pumps','Net 60',2.40,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(90,'SK Hynix',NULL,'Storage','NAND Flash & NVMe SSDs','Net 60',3.80,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(91,'Seasonic Electronics',NULL,'Power Supply','ATX & SFX Power Supplies','COD',1.90,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(92,'Super Flower Computer',NULL,'Power Supply','High-Efficiency PSUs','Net 60',3.60,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(93,'ADATA Technology',NULL,'Storage','Solid State Storage','Net 30',2.60,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(94,'Corsair Gaming',NULL,'Cooling','iCUE Liquid CPU Coolers','COD',1.60,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(95,'Crucial (Micron)',NULL,'Storage','DRAM & Consumer SSDs','Net 30',1.60,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(96,'Prolimatech',NULL,'Cooling','High-End Heatsinks','Net 30',4.10,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(97,'Bykski',NULL,'Cooling','GPU Water Blocks & Pumps','Net 30',5.00,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(98,'Thermalright',NULL,'Cooling','High-Performance Heatsinks','Net 60',2.60,'Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(99,'Azza',NULL,'Power Supply','Digital Power Units','Net 60',3.10,'Monthly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33'),(100,'Sabrent',NULL,'Storage','High-Speed PCIe NVMe SSDs','Net 60',2.10,'Bi-Weekly',NULL,'Active','2026-07-25 04:33:33','2026-07-25 04:33:33');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
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
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'supply'
--
SET @@SESSION.SQL_LOG_BIN = @MYSQLDUMP_TEMP_LOG_BIN;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-25 22:53:54
