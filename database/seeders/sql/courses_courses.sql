-- Adminer 4.8.1 MySQL 10.4.10-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `courses_courses`;
CREATE TABLE `courses_courses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `one_id` bigint(20) unsigned NOT NULL,
  `two_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `courses_courses_one_id_foreign` (`one_id`),
  KEY `courses_courses_two_id_foreign` (`two_id`),
  CONSTRAINT `courses_courses_one_id_foreign` FOREIGN KEY (`one_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `courses_courses_two_id_foreign` FOREIGN KEY (`two_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `courses_courses` (`id`, `one_id`, `two_id`, `created_at`, `updated_at`) VALUES
(1,	1,	6,	NULL,	NULL),
(2,	2,	7,	NULL,	NULL),
(3,	3,	8,	NULL,	NULL),
(4,	4,	7,	NULL,	NULL),
(5,	5,	6,	NULL,	NULL);

-- 2023-07-03 13:51:18
