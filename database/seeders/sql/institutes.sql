-- Adminer 4.8.1 MySQL 10.4.10-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `institutes`;
CREATE TABLE `institutes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('DIPLOMA','BACHELORS') COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sliderone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slidertwo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sliderthree` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `institutes` (`id`, `type`, `title`, `phone`, `logo`, `banner`, `sliderone`, `slidertwo`, `sliderthree`, `description`, `created_at`, `updated_at`) VALUES
(1,	'BACHELORS',	'Mewar University',	'0722222222',	NULL,	NULL,	NULL,	NULL,	NULL,	'Mewar University',	'2023-07-03 10:09:04',	'2023-07-03 10:09:04'),
(2,	'BACHELORS',	'University of lagos',	'431243124324',	NULL,	NULL,	NULL,	NULL,	NULL,	'University of lagos',	'2023-07-03 10:09:17',	'2023-07-03 10:09:17'),
(3,	'BACHELORS',	'University of kenya',	'431243124324',	NULL,	NULL,	NULL,	NULL,	NULL,	'University of kenya',	'2023-07-03 10:09:29',	'2023-07-03 10:09:29'),
(4,	'BACHELORS',	'Univesity of Delhi',	'431243124324',	NULL,	NULL,	NULL,	NULL,	NULL,	'Univesity of Delhi',	'2023-07-03 10:09:39',	'2023-07-03 10:09:39'),
(5,	'DIPLOMA',	'Mewar Polytechnic',	'431243124324',	NULL,	NULL,	NULL,	NULL,	NULL,	'Mewar Polytechnic',	'2023-07-03 10:10:35',	'2023-07-03 10:10:35'),
(6,	'DIPLOMA',	'Ibadan Polytechnic',	'431243124324',	NULL,	NULL,	NULL,	NULL,	NULL,	'Ibadan Polytechnic',	'2023-07-03 10:10:46',	'2023-07-03 10:10:46'),
(7,	'DIPLOMA',	'Nairobi Polytechnic',	'431243124324',	NULL,	NULL,	NULL,	NULL,	NULL,	'Nairobi Polytechnic',	'2023-07-03 10:10:58',	'2023-07-03 10:10:58'),
(8,	'DIPLOMA',	'Lagos Polytechnic',	'431243124324',	NULL,	NULL,	NULL,	NULL,	NULL,	'Lagos Polytechnic',	'2023-07-03 10:11:12',	'2023-07-03 10:11:12');

-- 2023-07-03 13:11:37
