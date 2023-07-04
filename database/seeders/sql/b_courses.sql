-- Adminer 4.8.1 MySQL 10.4.10-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `courses`;
CREATE TABLE `courses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('DIPLOMA','BACHELORS') COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fees` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `courses` (`id`, `type`, `title`, `fees`, `description`, `created_at`, `updated_at`) VALUES
(1,	'BACHELORS',	'Bachelors in Mining',	'2000',	'Bachelors in Mining',	'2023-07-03 08:56:53',	'2023-07-03 08:56:53'),
(2,	'BACHELORS',	'Bachelors in Computer',	'2000',	'Bachelors in Computer',	'2023-07-03 08:57:08',	'2023-07-03 08:57:08'),
(3,	'BACHELORS',	'Bachelors in Electrical',	'2000',	'Bachelors in Electrical',	'2023-07-03 08:57:21',	'2023-07-03 08:57:21'),
(4,	'BACHELORS',	'Bachelors in Software Engineering',	'2000',	'Bachelors in Software Engineering',	'2023-07-03 08:57:34',	'2023-07-03 08:57:34'),
(5,	'BACHELORS',	'Bachelors in Geology',	'3444',	'Bachelors in Geology',	'2023-07-03 08:57:45',	'2023-07-03 08:57:45');

-- 2023-07-03 12:00:59
