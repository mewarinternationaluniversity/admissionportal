-- Adminer 4.8.1 MySQL 10.4.10-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `institutes_courses`;
CREATE TABLE `institutes_courses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `institute_id` bigint(20) unsigned NOT NULL,
  `course_id` bigint(20) unsigned NOT NULL,
  `seats` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fees` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `institutes_courses_institute_id_foreign` (`institute_id`),
  KEY `institutes_courses_course_id_foreign` (`course_id`),
  CONSTRAINT `institutes_courses_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `institutes_courses_institute_id_foreign` FOREIGN KEY (`institute_id`) REFERENCES `institutes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `institutes_courses` (`id`, `institute_id`, `course_id`, `seats`, `fees`, `created_at`, `updated_at`) VALUES
(1,	5,	6,	NULL,	'22',	NULL,	NULL),
(2,	1,	1,	'22',	'33',	NULL,	NULL),
(3,	1,	2,	'44',	'23',	NULL,	NULL),
(4,	1,	4,	'43',	'74',	NULL,	NULL),
(5,	5,	8,	NULL,	'54',	NULL,	NULL),
(6,	6,	7,	NULL,	'12',	NULL,	NULL),
(7,	7,	8,	NULL,	'22',	NULL,	NULL),
(8,	7,	7,	NULL,	'42',	NULL,	NULL),
(9,	8,	6,	NULL,	'32',	NULL,	NULL),
(10,	8,	7,	NULL,	'32',	NULL,	NULL),
(11,	8,	8,	NULL,	'22',	NULL,	NULL),
(12,	1,	3,	'22',	'32',	NULL,	NULL),
(13,	1,	5,	'22',	'22',	NULL,	NULL),
(14,	2,	1,	'232',	'22',	NULL,	NULL),
(15,	2,	3,	'22',	'33',	NULL,	NULL),
(16,	2,	5,	'22',	'22',	NULL,	NULL),
(17,	3,	1,	'22',	'22',	NULL,	NULL),
(18,	3,	5,	'22',	'22',	NULL,	NULL),
(19,	4,	4,	'22',	'33',	NULL,	NULL),
(20,	4,	3,	'22',	'33',	NULL,	NULL),
(21,	4,	1,	'22',	'33',	NULL,	NULL),
(22,	4,	5,	'22',	'223',	NULL,	NULL);

-- 2023-07-03 13:49:49
