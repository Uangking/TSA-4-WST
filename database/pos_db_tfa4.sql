
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `pos_db_tfa4` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `pos_db_tfa4`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;


-- Original records and TFA4 migration history. Sample passwords are NULL for local initialization.

INSERT INTO `customers` (`id`, `full_name`, `email`, `phone`, `created_at`) VALUES ('1', 'Ariana Santos', 'ariana.santos@example.com', '+63 917 111 2233', '2026-10-03 09:00:00');
INSERT INTO `customers` (`id`, `full_name`, `email`, `phone`, `created_at`) VALUES ('2', 'Miguel Reyes', 'miguel.reyes@example.com', '+63 918 222 3344', '2026-10-03 09:05:00');
INSERT INTO `customers` (`id`, `full_name`, `email`, `phone`, `created_at`) VALUES ('3', 'Sofia Lim', 'sofia.lim@example.com', '+63 919 333 4455', '2026-10-03 09:10:00');
INSERT INTO `customers` (`id`, `full_name`, `email`, `phone`, `created_at`) VALUES ('4', 'Daniel Cruz', 'daniel.cruz@example.com', '+63 920 444 5566', '2026-10-03 09:15:00');
INSERT INTO `customers` (`id`, `full_name`, `email`, `phone`, `created_at`) VALUES ('5', 'Liza Mendoza', 'liza.mendoza@example.com', '+63 921 555 6677', '2026-10-03 09:20:00');
INSERT INTO `users` (`id`, `username`, `full_name`, `created_at`, `avatar`, `password`) VALUES ('1', 'admin01', 'Renee Bautista', '2026-10-03 10:00:00', NULL, NULL);
INSERT INTO `users` (`id`, `username`, `full_name`, `created_at`, `avatar`, `password`) VALUES ('2', 'mgr_santos', 'Ethan Santos', '2026-10-03 10:05:00', NULL, NULL);
INSERT INTO `users` (`id`, `username`, `full_name`, `created_at`, `avatar`, `password`) VALUES ('3', 'cashier_lee', 'Mia Lee', '2026-10-03 10:10:00', NULL, NULL);
INSERT INTO `users` (`id`, `username`, `full_name`, `created_at`, `avatar`, `password`) VALUES ('4', 'mgr_fernandez', 'Julian Fernandez', '2026-10-03 10:15:00', NULL, NULL);
INSERT INTO `users` (`id`, `username`, `full_name`, `created_at`, `avatar`, `password`) VALUES ('5', 'cashier_vega', 'Kyla Vega', '2026-10-03 10:20:00', NULL, NULL);
INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES ('1', '2026-10-03-000001', 'App\\Database\\Migrations\\CreateCustomersAndUsers', 'default', 'App', '1791024000', '1');
INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES ('2', '2026-10-10-000001', 'App\\Database\\Migrations\\AddAvatarToUsers', 'default', 'App', '1791638332', '1');
INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES ('3', '2026-10-11-000001', 'App\\Database\\Migrations\\AddPasswordToUsers', 'default', 'App', '1791651524', '2');
