-- phpMyAdmin SQL Dump
-- version 5.2.2deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 12, 2026 at 03:20 PM
-- Server version: 8.4.7-0ubuntu0.25.04.1
-- PHP Version: 8.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kaniv`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` bigint UNSIGNED NOT NULL,
  `front_page_photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `passport_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `civil_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('medical_support','financial_support','iqama_visa_residency','ticket') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `application_type_id` bigint UNSIGNED DEFAULT NULL,
  `approved_amount` decimal(15,3) DEFAULT NULL,
  `approved_date` date DEFAULT NULL,
  `submitted_by` bigint UNSIGNED NOT NULL,
  `reviewed_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `unit_id` bigint UNSIGNED DEFAULT NULL,
  `area_id` bigint UNSIGNED DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `front_page_photo`, `name`, `passport_no`, `civil_id`, `mobile_number`, `category`, `application_type_id`, `approved_amount`, `approved_date`, `submitted_by`, `reviewed_by`, `created_at`, `updated_at`, `unit_id`, `area_id`, `status`) VALUES
(12, 'applications/hwUnxGGQEEhrrrxoejLNz7GXA8PyMDjGleyFbhW3.png', 'test application', 'test123', '290030806169', '9995412326', 'medical_support', 1, 500.000, '2025-12-05', 4, 4, '2025-12-05 10:52:25', '2025-12-05 12:11:19', 8, 1, 'paid'),
(13, 'applications/ocXzGlUkW6sMz6o7T4lu2PNXvt7hMmIrRe7tb7mJ.png', 'shafeer', 'A123456', '283032100000', '00000000', 'medical_support', 1, 50.000, '2025-12-09', 7, 8, '2025-12-09 08:20:27', '2025-12-09 08:24:35', 25, 6, 'paid'),
(14, 'applications/Hm1Sf0xK4v2oWEZL6pz8B3hLDOFsdiuQu2okQwfj.jpg', 'ANAGHA ASHOK', 'WB537262', '298050703948', '97242346', 'financial_support', 2, 100.000, '2025-12-22', 11, 8, '2025-12-15 17:49:32', '2025-12-22 08:30:10', 9, 1, 'payable'),
(15, 'applications/pwRwMo3URSyiNL68KikBtp2CocW0QZg5CMytuKqi.jpg', 'USMAN KABEER', '0', '268051209258', '66960815', 'financial_support', 2, 75.000, '2025-12-22', 10, 8, '2025-12-16 04:43:11', '2025-12-22 08:32:23', 16, 4, 'payable'),
(16, 'applications/rBHUIdPF7JKDP7n5LVGMgAMm601XFHQ39sDOIdSH.jpg', 'NASAR PARABAN', '1', '275102602523', '98526799', 'medical_support', 2, 100.000, '2025-12-22', 10, 8, '2025-12-16 04:45:34', '2025-12-22 08:33:03', 15, 4, 'payable'),
(17, 'applications/R6Uti6fz0bJOf32rzRDhCwaBZY6WxqrjQakYBNuD.jpg', 'BINDU PANIKASHERI', '3', '275012703697', '69027395', 'medical_support', 2, 75.000, '2025-12-22', 10, 8, '2025-12-16 04:47:41', '2025-12-22 08:32:43', 17, 4, 'payable'),
(18, 'applications/11K6vidQHsopsrwEpcqd5uUt0BGyMtqmME63zUUH.jpg', 'NAVASUDDIN', '4', '271053010876', '97391706', 'medical_support', 2, 75.000, '2025-12-22', 10, 8, '2025-12-16 04:57:57', '2025-12-22 08:32:03', 18, 4, 'payable'),
(19, 'applications/XjCCm8YWC3Q0JPk9CcSF8NfPjEfKBfDQT2gJmqfR.jpg', 'SHOJU JHON', '5', '261021902631', '55970399', 'medical_support', 2, 100.000, '2025-12-22', 10, 8, '2025-12-16 04:59:49', '2025-12-22 08:31:35', 18, 4, 'payable'),
(20, 'applications/0EgOka2frfj5HLuA4FHb9ZklkYqw6Haz3kuGcwGA.jpg', 'SREEJA RAVI', '6', '273052809104', '66296493', 'financial_support', 2, 60.000, '2025-12-22', 10, 8, '2025-12-16 05:04:07', '2026-01-19 20:16:20', 19, 4, 'paid'),
(21, 'applications/SlaHWgug7IdA61Sjn0429IDZNqd782eUuvX1SVk2.jpg', 'Pramodhini', 'W3388380', '276031802361', '+965 9788 6831', 'medical_support', 3, 75.000, '2025-12-22', 11, 8, '2025-12-22 06:09:52', '2026-01-19 20:16:06', 4, 1, 'paid'),
(22, 'applications/woabg2P9Ze6WV2udmCVx2YCEZ1H5YnQX2nh2MeM7.jpg', 'Muhammed Anoos', 'R5033572', '298101202968', '00919074302947', 'medical_support', 2, NULL, NULL, 12, NULL, '2025-12-30 09:44:55', '2025-12-30 09:44:55', 37, 5, 'pending'),
(23, 'applications/aKtUOy45EcyRplazuUGCRIPSW6vEHJmgWwH4CJrl.png', 'Test', 'PT12345665885', '283000000000', '973000000000', 'medical_support', 2, NULL, NULL, 7, 8, '2026-01-03 07:19:18', '2026-01-14 08:42:13', 25, 6, 'rejected'),
(24, 'applications/eCkNknWXIzta7ULXuSlib6jgXVbJxCvQynML3U3l.png', 'test2', 'K0123', '012345678910', '0123', 'ticket', NULL, 55.000, '2026-01-03', 14, 4, '2026-01-03 12:20:39', '2026-01-03 12:28:10', 34, 5, 'paid'),
(25, 'applications/xBfiaUVMYyo6MXSPtEeK2cTlsYVifKseJoDpTsTQ.jpg', 'Jayakrishnan', '000000', '288092909347', '66955495', 'financial_support', 3, 75.000, '2026-01-14', 11, 8, '2026-01-14 08:05:33', '2026-01-14 12:54:09', 7, 1, 'paid'),
(26, 'applications/Pj6xe7YFD87MpSIneJ33VgqkXvbWf36TAFmLn2TT.jpg', 'NISHA MOL', 'ABC', '278010807437', '51676031', 'medical_support', 3, NULL, NULL, 10, NULL, '2026-01-26 21:40:04', '2026-01-26 21:40:04', 21, 4, 'pending'),
(27, 'applications/VrfnxJaZoa1Hlk4CSqOinZt46Cd5stlrTFkQgS46.jpg', 'MUHAMMED ALI', 'A', '270051105134', '66250841', 'financial_support', 3, NULL, NULL, 10, NULL, '2026-01-26 21:45:07', '2026-01-26 21:45:07', 18, 4, 'pending'),
(28, 'applications/pMqcxOljQJKmNIIwUdD442O2sfMIph8UKBHPadje.jpg', 'MARY STELLA', 'A', '269052706613', '51617329', 'financial_support', 3, NULL, NULL, 10, NULL, '2026-01-26 21:47:04', '2026-01-27 09:20:53', 16, 4, 'pending'),
(29, 'applications/sbtZQmjxqjhCD3dNuOSrk0vZ0BTGvRni8eAMZpqm.jpg', 'AHMED NAVEED', '2', '284051805076', '98848643', 'medical_support', 3, NULL, NULL, 10, NULL, '2026-01-26 21:48:28', '2026-01-27 09:20:37', 16, 4, 'pending'),
(30, 'applications/Ccm8ev5lBYTTBePkmS0TlggBzdQK3p5FGEnuFi6P.jpg', 'RAJEEVAN', '2', '266011605054', '55072986', 'medical_support', 3, NULL, NULL, 10, NULL, '2026-01-27 17:36:43', '2026-01-27 17:36:43', 17, 4, 'pending'),
(31, 'applications/Ouj9MeBtGkWylRsmxGveMwqbl6Fx1P9vgMxWLb3q.jpg', 'SAMAD KIDARATHIL', 'P4624361', '276052019616', '69643917', 'financial_support', 3, 75.000, '2026-01-31', 13, 4, '2026-01-28 07:27:58', '2026-01-31 13:28:39', 41, 7, 'payable'),
(32, 'applications/Se9NH6lja0b3IXgvAY8Sw11gblREGoSZOoODmfSw.jpg', 'Afsal', 'B6045034', '289121507975', '50186486', 'medical_support', 3, 100.000, '2026-01-31', 13, 4, '2026-01-28 07:36:29', '2026-01-31 13:28:28', 41, 7, 'payable'),
(33, 'applications/KIFcoI8CTEz6g11Rnr1qVRWjeEI2QD7bbPP6Ac5k.jpg', 'BIJU GOPINATH', '.', '281041516138', '67064738', 'medical_support', 3, NULL, NULL, 12, NULL, '2026-02-02 16:33:16', '2026-02-02 16:33:16', 36, 5, 'pending'),
(34, 'applications/Iw9g164WKPdRBfrjZLfQtIa3NpoDcgW9b23YVjMX.jpg', 'Fathimath Zuhra', 'W8549608', '289070607852', '66108089', 'financial_support', 3, NULL, NULL, 12, NULL, '2026-02-02 16:39:06', '2026-02-02 16:39:06', 34, 5, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `application_types`
--

CREATE TABLE `application_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `application_types`
--

INSERT INTO `application_types` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Nov 2025', 0, '2025-11-14 21:41:07', '2025-12-22 02:57:43'),
(2, 'Dec 2025', 1, '2025-12-22 02:57:38', '2025-12-22 02:57:38'),
(3, 'Jan 2026', 1, '2025-12-22 02:57:56', '2025-12-22 02:57:56');

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mekhala_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`, `mekhala_id`) VALUES
(1, 'Farwaniya', 'Farwaniya', 1, '2025-10-28 12:01:59', '2025-11-15 05:52:45', 2),
(2, 'Kuwait City', 'Kuwait City', 1, '2025-10-28 12:03:26', '2025-11-15 05:53:10', 2),
(3, 'Fahaheel', 'Fahaheel', 1, '2025-10-28 12:05:19', '2025-10-28 12:22:11', 1),
(4, 'Abbasiya', 'Abbasiya', 1, '2025-10-28 12:05:33', '2025-10-28 13:02:59', 2),
(5, 'Salmiya', 'Salmiya', 1, '2025-10-28 12:05:47', '2025-11-15 05:53:20', 1),
(6, 'Riggae', 'Riggae', 1, '2025-10-28 12:06:00', '2025-11-15 11:07:54', 2),
(7, 'Abu Haleefa', 'Abu Haleefa', 1, '2025-11-15 05:53:45', '2025-11-15 05:53:45', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE `collections` (
  `id` bigint UNSIGNED NOT NULL,
  `unit_id` bigint UNSIGNED NOT NULL,
  `amount` decimal(15,3) NOT NULL,
  `collection_status` enum('payable','received','forwarded','center_received') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'payable',
  `collection_date` date NOT NULL,
  `term` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` int DEFAULT NULL,
  `entered_by` bigint UNSIGNED NOT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `collections`
--

INSERT INTO `collections` (`id`, `unit_id`, `amount`, `collection_status`, `collection_date`, `term`, `type`, `year`, `entered_by`, `notes`, `created_at`, `updated_at`) VALUES
(60, 46, 20.250, 'payable', '2025-12-05', 'Monthly', 'November_2025', NULL, 6, NULL, '2025-12-05 12:16:50', '2026-01-11 03:09:16'),
(61, 47, 30.750, 'payable', '2025-12-05', 'Monthly', 'November_2025', NULL, 6, NULL, '2025-12-05 12:16:50', '2026-01-11 03:08:56'),
(62, 48, 40.250, 'received', '2025-12-05', 'Monthly', 'November_2025', NULL, 6, NULL, '2025-12-05 12:16:50', '2025-12-08 20:10:05'),
(63, 49, 10.750, 'received', '2025-12-05', 'Monthly', 'November_2025', NULL, 6, NULL, '2025-12-05 12:16:50', '2025-12-08 20:10:05'),
(64, 50, 30.750, 'received', '2025-12-05', 'Monthly', 'November_2025', NULL, 6, NULL, '2025-12-05 12:16:50', '2025-12-08 20:10:05'),
(65, 51, 10.250, 'received', '2025-12-05', 'Monthly', 'November_2025', NULL, 6, NULL, '2025-12-05 12:16:50', '2025-12-08 20:10:05'),
(66, 52, 75.000, 'received', '2025-12-05', 'Monthly', 'November_2025', NULL, 6, NULL, '2025-12-05 12:16:50', '2025-12-08 20:10:05'),
(67, 53, 75.000, 'received', '2025-12-05', 'Monthly', 'November_2025', NULL, 6, NULL, '2025-12-05 12:16:50', '2025-12-08 20:10:05'),
(68, 25, 0.000, 'received', '2025-12-01', 'Blanket_2025', 'Blanket Collection', NULL, 7, NULL, '2025-12-09 08:16:15', '2025-12-15 16:57:25'),
(69, 26, 0.000, 'received', '2025-12-01', 'Blanket_2025', 'Blanket Collection', NULL, 7, NULL, '2025-12-09 08:16:15', '2025-12-15 16:57:44'),
(70, 27, 0.000, 'received', '2025-12-01', 'Blanket_2025', 'Blanket Collection', NULL, 7, NULL, '2025-12-09 08:16:15', '2025-12-15 16:58:05'),
(71, 25, 52.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 7, NULL, '2025-12-15 15:52:00', '2025-12-15 16:39:42'),
(72, 26, 50.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 7, NULL, '2025-12-15 15:52:00', '2025-12-15 16:39:42'),
(73, 27, 13.500, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 7, NULL, '2025-12-15 15:52:00', '2025-12-15 16:39:42'),
(74, 28, 20.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 7, NULL, '2025-12-15 15:52:00', '2025-12-15 16:39:42'),
(75, 15, 33.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 10, NULL, '2025-12-15 16:15:19', '2025-12-15 16:44:33'),
(76, 16, 25.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 10, NULL, '2025-12-15 16:15:19', '2025-12-15 16:44:33'),
(77, 17, 38.500, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 10, NULL, '2025-12-15 16:15:19', '2025-12-15 16:44:33'),
(78, 18, 50.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 10, NULL, '2025-12-15 16:15:19', '2025-12-15 16:44:33'),
(79, 19, 40.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 10, NULL, '2025-12-15 16:15:19', '2025-12-15 16:44:33'),
(80, 20, 23.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 10, NULL, '2025-12-15 16:15:19', '2025-12-15 16:43:54'),
(81, 21, 15.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 10, NULL, '2025-12-15 16:15:19', '2025-12-15 16:43:54'),
(82, 22, 7.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 10, NULL, '2025-12-15 16:15:19', '2025-12-15 16:43:54'),
(83, 23, 7.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 10, NULL, '2025-12-15 16:15:19', '2025-12-15 16:43:54'),
(84, 24, 8.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 10, NULL, '2025-12-15 16:15:19', '2025-12-15 16:43:54'),
(85, 4, 45.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 11, NULL, '2025-12-15 16:40:12', '2025-12-15 16:42:28'),
(86, 5, 40.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 11, NULL, '2025-12-15 16:40:12', '2025-12-15 16:42:28'),
(87, 6, 40.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 11, NULL, '2025-12-15 16:40:12', '2025-12-15 16:42:28'),
(88, 7, 69.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 11, NULL, '2025-12-15 16:40:12', '2025-12-15 16:42:28'),
(89, 8, 40.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 11, NULL, '2025-12-15 16:40:12', '2026-01-19 17:34:09'),
(90, 9, 60.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 11, NULL, '2025-12-15 16:40:12', '2025-12-15 16:42:28'),
(91, 10, 17.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 11, NULL, '2025-12-15 16:40:12', '2025-12-15 16:43:07'),
(92, 11, 11.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 11, NULL, '2025-12-15 16:40:12', '2025-12-15 16:43:07'),
(93, 12, 8.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 11, NULL, '2025-12-15 16:40:12', '2025-12-15 16:43:07'),
(94, 13, 12.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 11, NULL, '2025-12-15 16:40:12', '2025-12-15 16:43:07'),
(95, 14, 14.500, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 11, NULL, '2025-12-15 16:40:12', '2025-12-15 16:43:18'),
(96, 29, 42.500, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 9, NULL, '2025-12-15 16:40:38', '2025-12-15 16:41:20'),
(97, 30, 40.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 9, NULL, '2025-12-15 16:40:38', '2025-12-15 16:41:20'),
(98, 31, 40.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 9, NULL, '2025-12-15 16:40:38', '2025-12-15 16:41:20'),
(99, 32, 31.000, 'received', '2025-12-15', 'December_2025', 'Monthly Collection', NULL, 9, NULL, '2025-12-15 16:40:38', '2025-12-15 16:41:20'),
(100, 25, 500.000, 'received', '2025-12-24', 'Blanket_2025', 'Blanket Collection', NULL, 7, NULL, '2025-12-24 15:18:52', '2026-01-09 13:01:48'),
(101, 33, 40.000, 'received', '2025-12-30', 'December_2025', 'Monthly Collection', NULL, 12, NULL, '2025-12-30 14:43:33', '2026-01-01 13:48:34'),
(102, 34, 40.000, 'received', '2025-12-30', 'December_2025', 'Monthly Collection', NULL, 12, NULL, '2025-12-30 14:43:33', '2026-01-01 13:48:34'),
(103, 35, 3.000, 'received', '2025-12-30', 'December_2025', 'Monthly Collection', NULL, 12, NULL, '2025-12-30 14:43:33', '2026-01-01 13:48:34'),
(104, 36, 40.000, 'received', '2025-12-30', 'December_2025', 'Monthly Collection', NULL, 12, NULL, '2025-12-30 14:43:33', '2026-01-01 13:48:34'),
(105, 37, 25.500, 'received', '2025-12-30', 'December_2025', 'Monthly Collection', NULL, 12, NULL, '2025-12-30 14:43:33', '2026-01-01 13:48:34'),
(106, 38, 5.500, 'received', '2025-12-30', 'December_2025', 'Monthly Collection', NULL, 12, NULL, '2025-12-30 14:43:33', '2026-01-01 13:48:48'),
(107, 39, 10.000, 'received', '2025-12-30', 'December_2025', 'Monthly Collection', NULL, 12, NULL, '2025-12-30 14:43:33', '2026-01-01 13:48:48'),
(108, 33, 125.000, 'received', '2025-12-30', 'Blanket_2025', 'Blanket Collection', NULL, 12, NULL, '2025-12-30 14:44:51', '2026-01-01 13:47:53'),
(109, 34, 122.000, 'received', '2025-12-30', 'Blanket_2025', 'Blanket Collection', NULL, 12, NULL, '2025-12-30 14:44:51', '2026-01-01 13:48:34'),
(110, 35, 4.000, 'received', '2025-12-30', 'Blanket_2025', 'Blanket Collection', NULL, 12, NULL, '2025-12-30 14:44:51', '2026-01-01 13:47:53'),
(111, 36, 50.000, 'received', '2025-12-30', 'Blanket_2025', 'Blanket Collection', NULL, 12, NULL, '2025-12-30 14:44:51', '2026-01-01 13:48:34'),
(112, 37, 14.000, 'received', '2025-12-30', 'Blanket_2025', 'Blanket Collection', NULL, 12, NULL, '2025-12-30 14:44:51', '2026-01-01 13:48:34'),
(113, 38, 182.500, 'payable', '2025-12-30', 'Blanket_2025', 'Blanket Collection', NULL, 12, NULL, '2025-12-30 14:44:51', '2025-12-30 14:44:51'),
(114, 39, 138.000, 'payable', '2025-12-30', 'Blanket_2025', 'Blanket Collection', NULL, 12, NULL, '2025-12-30 14:44:51', '2025-12-30 14:44:51'),
(115, 46, 50.000, 'received', '2025-12-30', 'December_2025', 'Monthly Collection', NULL, 6, NULL, '2025-12-30 19:27:30', '2026-01-01 13:47:53'),
(116, 47, 40.000, 'received', '2025-12-30', 'December_2025', 'Monthly Collection', NULL, 6, NULL, '2025-12-30 19:27:30', '2026-01-01 13:47:53'),
(117, 48, 32.000, 'received', '2025-12-30', 'December_2025', 'Monthly Collection', NULL, 6, NULL, '2025-12-30 19:27:30', '2026-01-01 13:47:53'),
(118, 49, 42.500, 'received', '2025-12-30', 'December_2025', 'Monthly Collection', NULL, 6, NULL, '2025-12-30 19:27:30', '2026-01-01 13:47:53'),
(119, 50, 22.000, 'received', '2025-12-30', 'December_2025', 'Monthly Collection', NULL, 6, NULL, '2025-12-30 19:27:30', '2026-01-01 13:47:53'),
(120, 51, 31.000, 'received', '2025-12-30', 'December_2025', 'Monthly Collection', NULL, 6, NULL, '2025-12-30 19:27:30', '2026-01-01 13:47:53'),
(121, 52, 42.500, 'received', '2025-12-30', 'December_2025', 'Monthly Collection', NULL, 6, NULL, '2025-12-30 19:27:30', '2026-01-01 13:47:53'),
(122, 53, 4.750, 'received', '2025-12-30', 'December_2025', 'Monthly Collection', NULL, 6, NULL, '2025-12-30 19:27:30', '2026-01-01 13:47:53'),
(123, 40, 24.000, 'payable', '2025-12-20', 'December_2025', 'Monthly Collection', NULL, 13, NULL, '2026-01-02 11:50:33', '2026-01-02 11:50:33'),
(124, 41, 21.500, 'payable', '2025-12-22', 'December_2025', 'Monthly Collection', NULL, 13, NULL, '2026-01-02 11:51:59', '2026-01-02 11:51:59'),
(125, 42, 40.000, 'payable', '2025-12-22', 'December_2025', 'Monthly Collection', NULL, 13, NULL, '2026-01-02 11:51:59', '2026-01-02 11:51:59'),
(126, 43, 40.000, 'payable', '2025-12-22', 'December_2025', 'Monthly Collection', NULL, 13, NULL, '2026-01-02 11:51:59', '2026-01-02 11:51:59'),
(127, 44, 18.250, 'payable', '2025-12-22', 'December_2025', 'Monthly Collection', NULL, 13, NULL, '2026-01-02 11:51:59', '2026-01-02 11:51:59'),
(128, 45, 17.500, 'payable', '2025-12-22', 'December_2025', 'Monthly Collection', NULL, 13, NULL, '2026-01-02 11:51:59', '2026-01-02 11:51:59'),
(129, 40, 52.000, 'payable', '2025-12-31', 'Blanket_2025', 'Blanket Collection', NULL, 13, NULL, '2026-01-02 11:54:29', '2026-01-02 11:54:29'),
(130, 41, 25.500, 'payable', '2025-12-31', 'Blanket_2025', 'Blanket Collection', NULL, 13, NULL, '2026-01-02 11:54:29', '2026-01-02 11:54:29'),
(131, 42, 32.000, 'payable', '2025-12-31', 'Blanket_2025', 'Blanket Collection', NULL, 13, NULL, '2026-01-02 11:54:29', '2026-01-02 11:54:29'),
(132, 43, 16.000, 'payable', '2025-12-31', 'Blanket_2025', 'Blanket Collection', NULL, 13, NULL, '2026-01-02 11:54:29', '2026-01-02 11:54:29'),
(133, 44, 62.000, 'payable', '2025-12-31', 'Blanket_2025', 'Blanket Collection', NULL, 13, NULL, '2026-01-02 11:54:29', '2026-01-02 11:54:29'),
(134, 45, 84.000, 'payable', '2025-12-31', 'Blanket_2025', 'Blanket Collection', NULL, 13, NULL, '2026-01-02 11:54:29', '2026-01-02 11:54:29'),
(135, 25, 100.000, 'received', '2025-11-01', 'December_2025', 'Monthly Collection', NULL, 7, NULL, '2026-01-03 07:28:29', '2026-01-19 17:24:36'),
(136, 26, 100.000, 'received', '2025-11-01', 'December_2025', 'Monthly Collection', NULL, 7, NULL, '2026-01-03 07:28:29', '2026-01-19 17:24:23'),
(137, 27, 100.000, 'received', '2025-11-01', 'December_2025', 'Monthly Collection', NULL, 7, NULL, '2026-01-03 07:28:29', '2026-01-19 17:25:00'),
(138, 28, 100.000, 'received', '2025-11-01', 'December_2025', 'Monthly Collection', NULL, 7, NULL, '2026-01-03 07:28:29', '2026-01-19 17:24:47'),
(139, 15, 68.000, 'received', '2026-01-14', 'Blanket_2025', 'Blanket Collection', NULL, 10, NULL, '2026-01-14 18:30:58', '2026-01-22 03:17:51'),
(141, 16, 70.000, 'received', '2026-01-14', 'Blanket_2025', 'Blanket Collection', NULL, 10, NULL, '2026-01-14 21:14:44', '2026-01-22 03:17:41'),
(142, 17, 30.000, 'received', '2026-01-14', 'Blanket_2025', 'Blanket Collection', NULL, 10, NULL, '2026-01-14 21:14:44', '2026-01-22 03:17:41'),
(143, 18, 50.000, 'received', '2026-01-14', 'Blanket_2025', 'Blanket Collection', NULL, 10, NULL, '2026-01-14 21:14:44', '2026-01-22 03:17:41'),
(144, 19, 47.000, 'received', '2026-01-14', 'Blanket_2025', 'Blanket Collection', NULL, 10, NULL, '2026-01-14 21:14:44', '2026-01-22 03:17:41'),
(145, 20, 16.000, 'received', '2026-01-14', 'Blanket_2025', 'Blanket Collection', NULL, 10, NULL, '2026-01-14 21:14:44', '2026-01-22 03:17:41'),
(146, 21, 50.000, 'received', '2026-01-14', 'Blanket_2025', 'Blanket Collection', NULL, 10, NULL, '2026-01-14 21:14:44', '2026-01-22 03:17:41'),
(147, 22, 25.000, 'received', '2026-01-14', 'Blanket_2025', 'Blanket Collection', NULL, 10, NULL, '2026-01-14 21:14:44', '2026-01-22 03:17:41'),
(148, 23, 27.000, 'received', '2026-01-14', 'Blanket_2025', 'Blanket Collection', NULL, 10, NULL, '2026-01-14 21:14:44', '2026-01-22 03:17:41'),
(149, 24, 30.000, 'received', '2026-01-14', 'Blanket_2025', 'Blanket Collection', NULL, 10, NULL, '2026-01-14 21:14:44', '2026-01-22 03:17:41'),
(150, 15, 41.000, 'received', '2026-01-16', 'January_2026', 'Monthly Collection', NULL, 10, NULL, '2026-01-16 18:43:15', '2026-01-21 17:16:30'),
(152, 16, 95.000, 'received', '2026-01-21', 'January_2026', 'Monthly Collection', NULL, 10, NULL, '2026-01-16 18:47:09', '2026-01-21 17:15:12'),
(153, 17, 40.500, 'received', '2026-01-16', 'January_2026', 'Monthly Collection', NULL, 10, NULL, '2026-01-16 18:47:09', '2026-01-21 17:15:12'),
(154, 18, 91.000, 'received', '2026-01-21', 'January_2026', 'Monthly Collection', NULL, 10, NULL, '2026-01-16 18:47:09', '2026-01-21 17:15:12'),
(155, 19, 40.000, 'received', '2026-01-16', 'January_2026', 'Monthly Collection', NULL, 10, NULL, '2026-01-16 18:47:09', '2026-01-21 17:15:12'),
(156, 20, 20.000, 'received', '2026-01-16', 'January_2026', 'Monthly Collection', NULL, 10, NULL, '2026-01-16 18:47:09', '2026-01-21 17:15:12'),
(157, 21, 20.000, 'received', '2026-01-16', 'January_2026', 'Monthly Collection', NULL, 10, NULL, '2026-01-16 18:47:09', '2026-01-21 17:15:12'),
(158, 22, 4.500, 'received', '2026-01-16', 'January_2026', 'Monthly Collection', NULL, 10, NULL, '2026-01-16 18:47:09', '2026-01-21 17:15:12'),
(159, 23, 8.000, 'received', '2026-01-16', 'January_2026', 'Monthly Collection', NULL, 10, NULL, '2026-01-16 18:47:09', '2026-01-21 17:15:12'),
(160, 24, 10.000, 'received', '2026-01-16', 'January_2026', 'Monthly Collection', NULL, 10, NULL, '2026-01-17 06:57:03', '2026-01-21 17:15:12'),
(161, 29, 10.000, 'received', '2026-01-21', 'January_2026', 'Monthly Collection', NULL, 9, NULL, '2026-01-21 05:50:33', '2026-01-21 16:32:42'),
(162, 30, 40.500, 'received', '2026-01-21', 'January_2026', 'Monthly Collection', NULL, 9, NULL, '2026-01-21 05:50:33', '2026-01-21 16:32:36'),
(163, 31, 40.000, 'received', '2026-01-21', 'January_2026', 'Monthly Collection', NULL, 9, NULL, '2026-01-21 05:50:33', '2026-01-21 16:32:25'),
(164, 32, 40.000, 'received', '2026-01-21', 'January_2026', 'Monthly Collection', NULL, 9, NULL, '2026-01-21 05:50:33', '2026-01-21 16:32:30'),
(165, 4, 40.000, 'received', '2026-01-21', 'January_2026', 'Monthly Collection', NULL, 11, NULL, '2026-01-21 07:15:59', '2026-01-22 02:41:58'),
(166, 5, 75.000, 'received', '2026-01-21', 'January_2026', 'Monthly Collection', NULL, 11, NULL, '2026-01-21 07:15:59', '2026-01-22 02:41:58'),
(167, 6, 50.500, 'received', '2026-01-21', 'January_2026', 'Monthly Collection', NULL, 11, NULL, '2026-01-21 07:15:59', '2026-01-22 02:41:58'),
(168, 7, 78.000, 'received', '2026-01-21', 'January_2026', 'Monthly Collection', NULL, 11, NULL, '2026-01-21 07:15:59', '2026-01-22 02:41:58'),
(169, 8, 40.000, 'received', '2026-01-21', 'January_2026', 'Monthly Collection', NULL, 11, NULL, '2026-01-21 07:15:59', '2026-02-10 00:57:10'),
(170, 9, 60.000, 'received', '2026-01-21', 'January_2026', 'Monthly Collection', NULL, 11, NULL, '2026-01-21 07:15:59', '2026-01-22 02:41:58'),
(172, 11, 9.750, 'received', '2026-01-21', 'January_2026', 'Monthly Collection', NULL, 11, NULL, '2026-01-21 07:15:59', '2026-01-22 02:41:58'),
(173, 12, 7.000, 'received', '2026-01-21', 'January_2026', 'Monthly Collection', NULL, 11, NULL, '2026-01-21 07:15:59', '2026-01-22 02:41:58'),
(174, 13, 10.000, 'received', '2026-01-21', 'January_2026', 'Monthly Collection', NULL, 11, NULL, '2026-01-21 07:15:59', '2026-01-22 02:42:36'),
(175, 14, 17.500, 'received', '2026-01-21', 'January_2026', 'Monthly Collection', NULL, 11, NULL, '2026-01-21 07:15:59', '2026-01-22 02:42:36'),
(176, 25, 59.000, 'received', '2026-01-21', 'January_2026', 'Monthly Collection', NULL, 7, NULL, '2026-01-21 16:36:59', '2026-01-21 16:40:48'),
(177, 26, 40.000, 'received', '2026-01-21', 'January_2026', 'Monthly Collection', NULL, 7, NULL, '2026-01-21 16:36:59', '2026-01-21 16:40:48'),
(178, 27, 14.500, 'received', '2026-01-21', 'January_2026', 'Monthly Collection', NULL, 7, NULL, '2026-01-21 16:36:59', '2026-01-21 16:40:48'),
(179, 28, 9.500, 'received', '2026-01-21', 'January_2026', 'Monthly Collection', NULL, 7, NULL, '2026-01-21 16:36:59', '2026-01-21 16:40:48'),
(180, 4, 47.000, 'received', '2025-12-25', 'Blanket_2025', 'Blanket Collection', NULL, 11, NULL, '2026-01-22 04:31:49', '2026-02-10 00:55:19'),
(181, 5, 60.000, 'received', '2025-12-25', 'Blanket_2025', 'Blanket Collection', NULL, 11, NULL, '2026-01-22 04:31:49', '2026-02-10 00:55:19'),
(182, 6, 69.000, 'received', '2025-12-25', 'Blanket_2025', 'Blanket Collection', NULL, 11, NULL, '2026-01-22 04:31:49', '2026-02-10 00:55:19'),
(183, 7, 85.000, 'received', '2025-12-25', 'Blanket_2025', 'Blanket Collection', NULL, 11, NULL, '2026-01-22 04:31:49', '2026-02-10 00:55:19'),
(184, 8, 37.000, 'received', '2025-12-25', 'Blanket_2025', 'Blanket Collection', NULL, 11, NULL, '2026-01-22 04:31:49', '2026-02-10 00:55:19'),
(185, 9, 126.000, 'received', '2025-12-25', 'Blanket_2025', 'Blanket Collection', NULL, 11, NULL, '2026-01-22 04:31:49', '2026-02-10 00:55:19'),
(186, 10, 116.000, 'received', '2025-12-25', 'Blanket_2025', 'Blanket Collection', NULL, 11, NULL, '2026-01-22 04:31:49', '2026-02-10 00:55:19'),
(187, 11, 70.000, 'received', '2025-12-25', 'Blanket_2025', 'Blanket Collection', NULL, 11, NULL, '2026-01-22 04:31:49', '2026-02-10 00:55:19'),
(188, 12, 42.000, 'received', '2025-12-25', 'Blanket_2025', 'Blanket Collection', NULL, 11, NULL, '2026-01-22 04:31:49', '2026-02-10 00:55:19'),
(189, 13, 8.000, 'received', '2025-12-25', 'Blanket_2025', 'Blanket Collection', NULL, 11, NULL, '2026-01-22 04:31:49', '2026-02-10 00:55:19'),
(190, 14, 32.000, 'received', '2025-12-25', 'Blanket_2025', 'Blanket Collection', NULL, 11, NULL, '2026-01-22 04:31:49', '2026-02-10 00:55:31'),
(202, 40, 40.000, 'payable', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 13, NULL, '2026-01-28 07:13:11', '2026-01-28 07:13:11'),
(203, 41, 40.500, 'payable', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 13, NULL, '2026-01-28 07:13:11', '2026-01-28 07:13:11'),
(204, 42, 35.000, 'payable', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 13, NULL, '2026-01-28 07:13:11', '2026-01-28 07:13:11'),
(205, 43, 27.000, 'payable', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 13, NULL, '2026-01-28 07:13:11', '2026-01-28 07:13:11'),
(206, 44, 16.500, 'payable', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 13, NULL, '2026-01-28 07:13:11', '2026-01-28 07:13:11'),
(207, 45, 12.000, 'payable', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 13, NULL, '2026-01-28 07:13:11', '2026-01-28 07:13:11'),
(208, 40, 40.000, 'payable', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 13, NULL, '2026-01-28 07:14:31', '2026-01-28 07:14:31'),
(209, 41, 40.500, 'payable', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 13, NULL, '2026-01-28 07:14:31', '2026-01-28 07:14:31'),
(210, 42, 35.000, 'payable', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 13, NULL, '2026-01-28 07:14:31', '2026-01-28 07:14:31'),
(211, 43, 27.000, 'payable', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 13, NULL, '2026-01-28 07:14:31', '2026-01-28 07:14:31'),
(212, 44, 16.500, 'payable', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 13, NULL, '2026-01-28 07:14:31', '2026-01-28 07:14:31'),
(213, 45, 12.000, 'payable', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 13, NULL, '2026-01-28 07:14:31', '2026-01-28 07:14:31'),
(214, 33, 40.000, 'payable', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 12, NULL, '2026-01-28 17:49:25', '2026-01-28 17:49:25'),
(215, 34, 40.000, 'payable', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 12, NULL, '2026-01-28 17:49:25', '2026-01-28 17:49:25'),
(216, 35, 5.000, 'payable', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 12, NULL, '2026-01-28 17:49:25', '2026-01-28 17:49:25'),
(217, 36, 43.000, 'payable', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 12, NULL, '2026-01-28 17:49:25', '2026-01-28 17:49:25'),
(218, 37, 33.500, 'payable', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 12, NULL, '2026-01-28 17:49:25', '2026-01-28 17:49:25'),
(219, 38, 3.000, 'payable', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 12, NULL, '2026-01-28 17:49:25', '2026-01-28 17:49:25'),
(220, 39, 6.500, 'payable', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 12, NULL, '2026-01-28 17:49:25', '2026-01-28 17:49:25'),
(221, 46, 75.000, 'payable', '2026-01-28', 'January_2026', 'Monthly Collection', NULL, 6, NULL, '2026-01-28 19:09:07', '2026-01-28 19:09:07'),
(222, 47, 42.500, 'payable', '2026-01-28', 'January_2026', 'Monthly Collection', NULL, 6, NULL, '2026-01-28 19:09:07', '2026-01-28 19:09:07'),
(223, 48, 40.000, 'payable', '2026-01-28', 'January_2026', 'Monthly Collection', NULL, 6, NULL, '2026-01-28 19:09:07', '2026-01-28 19:09:07'),
(224, 49, 50.000, 'payable', '2026-01-28', 'January_2026', 'Monthly Collection', NULL, 6, NULL, '2026-01-28 19:09:07', '2026-01-28 19:09:07'),
(225, 50, 21.000, 'payable', '2026-01-28', 'January_2026', 'Monthly Collection', NULL, 6, NULL, '2026-01-28 19:09:07', '2026-01-28 19:09:07'),
(226, 51, 11.000, 'payable', '2026-01-28', 'January_2026', 'Monthly Collection', NULL, 6, NULL, '2026-01-28 19:09:07', '2026-01-28 19:09:07');

-- --------------------------------------------------------

--
-- Table structure for table `collection_terms`
--

CREATE TABLE `collection_terms` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `collection_terms`
--

INSERT INTO `collection_terms` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(15, 'January_2026', 1, '2025-11-06 14:46:35', '2026-01-13 13:39:27'),
(16, 'December_2025', 0, '2025-11-06 14:46:42', '2026-01-13 13:39:33'),
(17, 'Blanket_2025', 1, '2025-12-09 08:07:43', '2025-12-09 08:07:43');

-- --------------------------------------------------------

--
-- Table structure for table `collection_types`
--

CREATE TABLE `collection_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `collection_types`
--

INSERT INTO `collection_types` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(8, 'Blanket Collection', 1, '2025-11-05 13:31:00', '2025-12-09 08:04:42'),
(9, 'Monthly Collection', 1, '2025-11-15 16:17:09', '2025-12-09 08:04:51');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint UNSIGNED NOT NULL,
  `expense_date` date NOT NULL,
  `particulars` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(15,3) NOT NULL,
  `beneficiary` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `application_id` bigint UNSIGNED DEFAULT NULL,
  `entered_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `expense_date`, `particulars`, `amount`, `beneficiary`, `bill_path`, `type`, `application_id`, `entered_by`, `created_at`, `updated_at`) VALUES
(6, '2025-12-09', 'thakkara', 2.000, NULL, 'bills/yZenmHaopmMqjiO2rMs6PMVXhEIfS0AJ16X4YTLH.jpg', 'refreshment', NULL, 3, '2025-12-09 08:27:00', '2025-12-09 08:27:00'),
(7, '2025-12-15', 'Tea exp', 1.400, NULL, 'bills/1iH2TdrqEu3ARADujENchnnrSku4PsNQ2Mi6K3OS.jpg', 'refreshment', NULL, 3, '2025-12-16 03:10:41', '2025-12-16 03:10:41'),
(8, '2025-12-15', 'particulars', 350.000, NULL, 'bills/NcEVurbSnmQTXG2aABF86PJtAoeCZvFjFlRrHnec.png', 'refreshment', NULL, 1, '2025-12-16 08:02:24', '2025-12-16 08:02:24'),
(9, '2025-12-14', 'Test', 0.100, NULL, NULL, 'refreshment', NULL, 3, '2025-12-20 07:04:39', '2025-12-20 07:04:39'),
(10, '2025-12-30', 'test', 10.000, NULL, 'bills/zSegUnRZr89LXbGHjTIHuWaWxxsSTFz3OIyTmjay.png', 'refreshment', NULL, 2, '2025-12-30 09:32:46', '2025-12-30 09:32:46');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `investments`
--

CREATE TABLE `investments` (
  `id` bigint UNSIGNED NOT NULL,
  `investment_date` date NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `income_generated` decimal(15,2) NOT NULL DEFAULT '0.00',
  `status` enum('invested','income_generated','capital_returned') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'invested',
  `returned_amount` decimal(15,2) DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `investments`
--

INSERT INTO `investments` (`id`, `investment_date`, `amount`, `description`, `income_generated`, `status`, `returned_amount`, `created_by`, `created_at`, `updated_at`) VALUES
(2, '2025-12-08', 100.00, 'invested', 30.00, 'capital_returned', 100.00, 1, '2025-12-08 20:12:48', '2025-12-31 01:49:33'),
(3, '2025-12-10', 10.00, '1test', 10.00, 'capital_returned', 20.00, 3, '2025-12-22 02:27:59', '2025-12-22 02:30:25'),
(4, '2025-12-01', 50.00, 'test', 10.00, 'capital_returned', 60.00, 3, '2025-12-22 02:31:24', '2025-12-22 02:35:47'),
(5, '2025-12-04', 100.00, 'Test', 10.00, 'capital_returned', 100.00, 3, '2025-12-24 15:08:04', '2025-12-24 15:08:52'),
(6, '2025-12-02', 150.00, 'Test', 15.00, 'capital_returned', 100.00, 1, '2025-12-31 01:54:11', '2025-12-31 01:54:36'),
(7, '2025-12-01', 200.00, 'Test', 10.00, 'capital_returned', 100.00, 3, '2026-01-01 19:05:55', '2026-01-01 19:09:34'),
(8, '2025-12-01', 1000.00, 'Test', 10.00, 'income_generated', NULL, 5, '2026-01-03 08:06:14', '2026-01-12 13:23:50'),
(9, '2025-12-01', 100.00, 'Test', 0.00, 'invested', NULL, 3, '2026-01-19 16:56:19', '2026-01-19 16:56:19'),
(10, '2026-01-23', 1000.00, 'test', 100.00, 'income_generated', NULL, 1, '2026-01-23 21:29:59', '2026-01-23 21:43:16'),
(11, '2025-12-14', 1000.00, 'Test', 0.00, 'invested', NULL, 5, '2026-02-10 00:28:02', '2026-02-10 00:28:02');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mekhalas`
--

CREATE TABLE `mekhalas` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mekhalas`
--

INSERT INTO `mekhalas` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'East Mekhala', 'East Mekhala', 1, '2025-10-28 12:10:13', '2025-10-28 12:10:13'),
(2, 'West Mekhala', 'West Mekhala', 1, '2025-10-28 12:17:59', '2025-10-28 12:17:59');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2025_10_28_064616_create_areas_table', 1),
(4, '2025_10_28_064616_create_mekhalas_table', 1),
(5, '2025_10_28_064617_create_units_table', 1),
(6, '2025_10_28_064619_create_users_table', 1),
(7, '2025_10_28_064620_create_applications_table', 1),
(8, '2025_10_28_064621_create_collections_table', 1),
(9, '2025_10_28_064622_create_expenses_table', 1),
(10, '2025_10_28_151153_add_mekhala_id_to_areas_table', 2),
(11, '2025_10_28_151325_add_mekhala_id_to_areas_table', 2),
(12, '2025_10_28_161330_update_expenses_type_enum', 3),
(13, '2025_10_28_171728_update_users_type_enum', 4),
(14, '2025_11_05_161014_create_terms_table', 5),
(15, '2025_11_05_161836_create_collection_terms_table', 5),
(16, '2025_11_05_162003_create_collection_types_table', 5),
(17, '2025_11_05_171519_add_role_to_users_table', 6),
(18, '2025_11_05_173648_add_term_type_year_to_collections_table', 7),
(20, '2025_11_09_183927_update_application_categories', 8),
(21, '2025_11_11_165838_update_amount_precision_to_three_decimals', 8),
(22, '2025_11_11_171258_add_bill_path_to_expenses_table', 9),
(24, '2025_11_07_081938_create_investments_table', 10),
(25, '2025_11_14_120124_add_collection_status_to_collections_table', 11),
(26, '2025_11_14_124600_create_application_types_table', 12),
(27, '2025_11_14_124648_update_applications_table_add_type_id', 12),
(28, '2025_11_14_202843_add_unit_area_to_applications_table', 13),
(29, '2025_11_22_205429_add_type_to_units_table', 14),
(30, '2025_12_03_104302_update_application_status_enum', 15),
(31, '2025_12_23_135211_add_forwarded_status_to_collections_table', 16),
(32, '2025_12_29_102209_fix_collection_status_enum_add_center_received', 17),
(33, '2026_01_02_104217_increase_expenses_type_column_length', 18),
(34, '2026_01_03_170901_add_beneficiary_to_expenses_table', 19);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('R3fd8kujwKk2zrkldzi0uZ5FxCKyQP0crLY27PAT', NULL, '94.128.235.149', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:147.0) Gecko/20100101 Firefox/147.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidUJyVmJGUVJ1V0FWamZaUVFDS2lqeW1GRXpJdEZnSXFXM2JjNE5aaCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMzcuMTg0LjExMi4yMDEva2FuaXYvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO319', 1770734393),
('VtUjWPemqxK9lNE9oCM9srtYlScPakAZyb2sU58y', NULL, '37.231.125.85', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:147.0) Gecko/20100101 Firefox/147.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUEpGT1E3WGRNQUoxYVlWbXdldXl6bWNmTnU0M0NaR1lZd1pvUjBXSyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMzcuMTg0LjExMi4yMDEva2FuaXYvbG9naW4iO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1770909307),
('ZnfQlCQWJg2JlzjofPATNochk0Koy6mvWOhV8lpe', NULL, '94.128.235.149', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:147.0) Gecko/20100101 Firefox/147.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoia2J4ZmtLZFc5R2o0ZnBhc0tJZFp0V0RzTVloejBONkR3bFoyZld2cCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1770751503);

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `area_id` bigint UNSIGNED NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `type` enum('IWA','YI','KIG') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'IWA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `area_id`, `description`, `is_active`, `created_at`, `updated_at`, `type`) VALUES
(4, 'Khaithan', 1, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:26:39', 'KIG'),
(5, 'Baidan', 1, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:27:05', 'KIG'),
(6, 'Darul Quran', 1, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:27:23', 'KIG'),
(7, 'Ghazali', 1, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:27:58', 'KIG'),
(8, 'Madeena', 1, NULL, 0, '2025-11-15 08:13:48', '2026-01-21 16:58:14', 'KIG'),
(9, 'Al-Rasheedi', 1, NULL, 1, '2025-11-15 08:13:48', '2026-01-21 16:57:46', 'KIG'),
(10, 'IWA-Khaitan', 1, NULL, 0, '2025-11-15 08:13:48', '2026-02-10 01:02:21', 'IWA'),
(11, 'IWA-Gazzali', 1, NULL, 1, '2025-11-15 08:13:48', '2025-11-15 08:13:48', 'IWA'),
(12, 'IWA-Al Rasheedi', 1, NULL, 1, '2025-11-15 08:13:48', '2025-11-15 08:13:48', 'IWA'),
(13, 'YI-CANARY', 1, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:25:14', 'YI'),
(14, 'YI-NIZAL', 1, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:25:36', 'YI'),
(15, 'Abbassiya', 4, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:30:52', 'KIG'),
(16, 'Balkies', 4, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:32:43', 'KIG'),
(17, 'Hasawi', 4, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:32:28', 'KIG'),
(18, 'Hira', 4, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:32:13', 'KIG'),
(19, 'Jaleeb', 4, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:31:54', 'KIG'),
(20, 'TC', 4, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:31:41', 'KIG'),
(21, 'IWA-Hira', 4, NULL, 1, '2025-11-15 08:13:48', '2025-11-15 08:13:48', 'IWA'),
(22, 'IWA-Jaleeb', 4, NULL, 1, '2025-11-15 08:13:48', '2025-11-15 08:13:48', 'IWA'),
(23, 'IWA-Bilkees', 4, NULL, 1, '2025-11-15 08:13:48', '2025-11-15 08:13:48', 'IWA'),
(24, 'YI-JALEEB', 4, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:31:19', 'YI'),
(25, 'Riggae West', 6, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:28:58', 'KIG'),
(26, 'Riggae East', 6, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:29:15', 'KIG'),
(27, 'IWA-Riggae', 6, NULL, 1, '2025-11-15 08:13:48', '2025-11-15 11:09:57', 'IWA'),
(28, 'YI- Riggae', 6, NULL, 1, '2025-11-15 08:13:48', '2025-11-26 17:15:37', 'YI'),
(29, 'Sharq', 2, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:29:46', 'KIG'),
(30, 'Kuwait City', 2, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:30:00', 'KIG'),
(31, 'Salhiya', 2, NULL, 1, '2025-11-15 08:13:48', '2026-01-21 16:52:23', 'KIG'),
(32, 'Al Shaab', 2, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:30:16', 'KIG'),
(33, 'Salmiya Garden', 5, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:34:21', 'KIG'),
(34, 'Salmiya', 5, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:34:05', 'KIG'),
(35, 'Hawally', 5, NULL, 1, '2025-11-15 08:13:48', '2025-11-23 03:47:51', 'KIG'),
(36, 'Hadi', 5, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:33:45', 'KIG'),
(37, 'YI Salmiya', 5, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:33:21', 'YI'),
(38, 'IWA-Salmiya', 5, NULL, 1, '2025-11-15 08:13:48', '2025-11-15 08:13:48', 'IWA'),
(39, 'IWA-Amman', 5, NULL, 1, '2025-11-15 08:13:48', '2025-11-15 08:13:48', 'IWA'),
(40, 'Abu Haleefa', 7, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:35:22', 'KIG'),
(41, 'Mahboola North', 7, NULL, 1, '2025-11-15 08:13:48', '2025-11-23 03:48:08', 'KIG'),
(42, 'Mahboola South', 7, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:35:06', 'KIG'),
(43, 'YI Abu haleefa', 7, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:34:48', 'YI'),
(44, 'IWA-Mahboola', 7, NULL, 1, '2025-11-15 08:13:48', '2025-11-15 08:13:48', 'IWA'),
(45, 'IWA-Abuhaleefa', 7, NULL, 1, '2025-11-15 08:13:48', '2025-11-15 08:13:48', 'IWA'),
(46, 'Mangaf', 3, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:38:33', 'KIG'),
(47, 'Fahaheel City', 3, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:38:16', 'KIG'),
(48, 'Nadi Fahaheel', 3, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:38:02', 'KIG'),
(49, 'Mangaf West', 3, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:37:44', 'KIG'),
(50, 'YI Fahaheel', 3, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:37:26', 'YI'),
(51, 'YI Mangaf', 3, NULL, 1, '2025-11-15 08:13:48', '2026-01-22 02:35:53', 'YI'),
(52, 'IWA-Mangaf', 3, NULL, 1, '2025-11-15 08:13:48', '2025-11-15 08:13:48', 'IWA'),
(53, 'IWA-Fahaheel', 3, NULL, 1, '2025-11-15 08:13:48', '2025-11-15 08:13:48', 'IWA'),
(54, 'IWA-Khaithan Noor', 1, 'IWA-Khaithan Noor', 1, '2026-01-21 16:50:08', '2026-01-21 16:50:08', 'IWA'),
(55, 'IWA-Khaithan Nadi', 1, 'IWA-Khathan Nadi', 1, '2026-01-21 16:51:55', '2026-02-10 14:14:27', 'IWA'),
(56, 'Madeena Khaithan', 1, 'Madeena Khaithan', 1, '2026-01-21 17:00:02', '2026-02-10 14:14:20', 'KIG');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` enum('admin','area','mekhala','center') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','chairman','treasurer') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_id` bigint UNSIGNED DEFAULT NULL,
  `mekhala_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `user_type`, `role`, `area_id`, `mekhala_id`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'East Mekhala Treasurer', 'emt@yopmail.com', NULL, '$2y$12$JDQbFMjUuxU7NZyr31RFWuzvPt.1eqL6cxRCapp7X1Y99pGpuss2m', 'mekhala', 'treasurer', 3, 1, 1, NULL, '2025-10-28 11:55:40', '2025-11-14 21:35:01'),
(2, 'Center', 'center@yopmail.com', NULL, '$2y$12$IobjQu/kAeBJTn3rrgyz8.CK1XNGhXoN0we/t3YIV6Ix/1PyKr4rS', 'center', 'admin', NULL, NULL, 1, NULL, '2025-10-28 12:01:16', '2025-11-14 21:36:23'),
(3, 'West Mekhala Treasurer', 'wmt@yopmail.com', NULL, '$2y$12$WIxaQdOicGL6nBkogIWs4uGzd7dQtti7LaezH2IQx6bvbdp.fYJKW', 'mekhala', 'treasurer', 3, 2, 1, NULL, '2025-10-28 13:55:09', '2025-11-14 21:36:01'),
(4, 'East Mekhala Chairman', 'emc@yopmail.com', NULL, '$2y$12$tsziMNrxTRxMEJJn4oTkC.lwErxKzKcSvjvv4wUUTq3hbjY2fbYXG', 'mekhala', 'chairman', 1, 1, 1, NULL, '2025-11-05 11:35:48', '2025-11-15 07:58:43'),
(5, 'cuser', 'cuser@yopmail.com', NULL, '$2y$12$05djnuiGirb1u8h40OgIzedEMRVH3EpndHQahZqwHOKSwQuk54I/O', 'center', 'admin', 4, 2, 1, NULL, '2025-11-05 11:42:04', '2025-11-14 21:38:43'),
(6, 'Kaniv-Area-Fahaheel', 'fahaheel@kig.com', NULL, '$2y$12$XFGPJPSNf8VlIODXbX04TeI7UZS0P236.nTxAJ8bsgI5ce2SVESw2', 'area', NULL, 3, 1, 1, NULL, '2025-11-05 12:45:20', '2025-12-30 14:46:37'),
(7, 'Kaniv-Area-Riggae', 'riggae@kig.com', NULL, '$2y$12$eEv8Oq/ITPyVZfePL1vbwuAB2KKdjiIZyQRuURFGX5jqDi7/1yO9K', 'area', NULL, 6, 2, 1, NULL, '2025-11-14 21:40:27', '2025-11-15 14:47:25'),
(8, 'West Mekhala Chairman', 'wmc@yopmail.com', NULL, '$2y$12$.cOUcNKiZF6NZpcjqZCvA..s6UBrXns33Ajq1TXYPJneW2mNOfz7a', 'mekhala', 'chairman', NULL, 2, 1, NULL, '2025-11-15 07:59:36', '2025-11-15 07:59:36'),
(9, 'Kaniv-Area-Kuwait city', 'kuwaitcity@kig.com', NULL, '$2y$12$x8BLnnA2zM0SklNi8Q5kY.p6ftoTip5/OGDfEKeZZFJyrFz7NrOEy', 'area', NULL, 2, 2, 1, NULL, '2025-11-15 10:24:49', '2025-11-15 16:18:28'),
(10, 'Kaniv_Area_Abbasiya', 'abbasiya@kig.com', NULL, '$2y$12$6ha6hni1E1tanqXLEqupluFwOH6eD8.CPGUfgzaIuYjyUs4UJ5qRW', 'area', NULL, 4, 2, 1, NULL, '2025-11-15 14:45:59', '2025-11-15 16:18:03'),
(11, 'Kaniv_Area_Farwaniya', 'farwaniya@kig.com', NULL, '$2y$12$Uo0/a3AagF.wxeQliAzrSu1oKB4ba5n.3hv/ckRM2rgUqV7cG8dVm', 'area', NULL, 1, 2, 1, NULL, '2025-11-15 14:49:20', '2025-11-15 14:49:20'),
(12, 'Kaniv-Area-Salmiya', 'salmiya@kig.com', NULL, '$2y$12$e91TBoyfXNxypZxRY76Cpe6SwgtZlZN60jZj.c4zw1ZYVFaogteq2', 'area', NULL, 5, 1, 1, NULL, '2025-12-22 05:48:19', '2025-12-22 05:48:19'),
(13, 'Kaniv-Area-Abuhaleefa', 'abuhaleefa@kig.com', NULL, '$2y$12$W2LLhPqYjQbzZxrmnVB92.UOyMMwH6uS1MlMbYf0KVgyF463ftDKi', 'area', NULL, 7, 1, 1, NULL, '2025-12-22 05:50:17', '2025-12-22 05:50:17'),
(14, 'Salmiya', 'salmiyauser@kig.com', NULL, '$2y$12$kxd/cH.XsTSYha3Bot0BHOzBYz5SSBQexssX1oY0AECqu4qPfHJ4m', 'area', NULL, 5, 1, 1, NULL, '2026-01-03 11:15:24', '2026-01-03 11:15:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applications`
--
ALTER TABLE `applications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `applications_submitted_by_foreign` (`submitted_by`),
  ADD KEY `applications_reviewed_by_foreign` (`reviewed_by`),
  ADD KEY `applications_application_type_id_foreign` (`application_type_id`),
  ADD KEY `applications_unit_id_foreign` (`unit_id`),
  ADD KEY `applications_area_id_foreign` (`area_id`);

--
-- Indexes for table `application_types`
--
ALTER TABLE `application_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `areas_mekhala_id_foreign` (`mekhala_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `collections_unit_id_foreign` (`unit_id`),
  ADD KEY `collections_entered_by_foreign` (`entered_by`);

--
-- Indexes for table `collection_terms`
--
ALTER TABLE `collection_terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collection_types`
--
ALTER TABLE `collection_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expenses_application_id_foreign` (`application_id`),
  ADD KEY `expenses_entered_by_foreign` (`entered_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `investments`
--
ALTER TABLE `investments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `investments_created_by_foreign` (`created_by`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mekhalas`
--
ALTER TABLE `mekhalas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `units_area_id_foreign` (`area_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_area_id_foreign` (`area_id`),
  ADD KEY `users_mekhala_id_foreign` (`mekhala_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applications`
--
ALTER TABLE `applications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `application_types`
--
ALTER TABLE `application_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;

--
-- AUTO_INCREMENT for table `collection_terms`
--
ALTER TABLE `collection_terms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `collection_types`
--
ALTER TABLE `collection_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investments`
--
ALTER TABLE `investments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mekhalas`
--
ALTER TABLE `mekhalas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_application_type_id_foreign` FOREIGN KEY (`application_type_id`) REFERENCES `application_types` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `applications_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `applications_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `applications_submitted_by_foreign` FOREIGN KEY (`submitted_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `applications_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `areas`
--
ALTER TABLE `areas`
  ADD CONSTRAINT `areas_mekhala_id_foreign` FOREIGN KEY (`mekhala_id`) REFERENCES `mekhalas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `collections`
--
ALTER TABLE `collections`
  ADD CONSTRAINT `collections_entered_by_foreign` FOREIGN KEY (`entered_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `collections_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenses_entered_by_foreign` FOREIGN KEY (`entered_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `investments`
--
ALTER TABLE `investments`
  ADD CONSTRAINT `investments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `units`
--
ALTER TABLE `units`
  ADD CONSTRAINT `units_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_area_id_foreign` FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `users_mekhala_id_foreign` FOREIGN KEY (`mekhala_id`) REFERENCES `mekhalas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
