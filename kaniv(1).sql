-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 15, 2025 at 12:13 AM
-- Server version: 8.0.43-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.22

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
  `front_page_photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passport_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `civil_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('medical_support','financial_support','iqama_visa_residency','ticket') COLLATE utf8mb4_unicode_ci NOT NULL,
  `application_type_id` bigint UNSIGNED DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `approved_amount` decimal(15,3) DEFAULT NULL,
  `approved_date` date DEFAULT NULL,
  `submitted_by` bigint UNSIGNED NOT NULL,
  `reviewed_by` bigint UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `unit_id` bigint UNSIGNED DEFAULT NULL,
  `area_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `front_page_photo`, `name`, `passport_no`, `civil_id`, `mobile_number`, `category`, `application_type_id`, `status`, `approved_amount`, `approved_date`, `submitted_by`, `reviewed_by`, `created_at`, `updated_at`, `unit_id`, `area_id`) VALUES
(1, 'applications/noOSWYvAghe3D1voA0WBbgpmglzIzgr2eYDecYIz.png', 'Applicant1', 'p5123', '290030806169', '+96555436917', 'medical_support', NULL, 'approved', '100.000', '2025-10-28', 1, 1, '2025-10-28 12:15:43', '2025-10-28 13:20:49', NULL, NULL),
(2, 'applications/o8y8BlmCG4qYxQwe5tIXPjK43wLtZti9Ou76eWMx.png', 'Area Application', 'pp123', '290030806168', '94089218', 'medical_support', NULL, 'approved', '100.000', '2025-10-28', 3, 1, '2025-10-28 13:56:19', '2025-10-28 14:29:51', NULL, NULL),
(3, 'applications/WK24RWWfaFhxkqGFqIJY6LRqI843jyoSx59Rcb0n.png', 'applicant test2', 'testpp1235', '290030806165', '51170203', 'medical_support', NULL, 'rejected', NULL, NULL, 3, 1, '2025-10-28 14:20:15', '2025-10-28 14:25:09', NULL, NULL),
(4, 'applications/fduL7QlMCLGi2TLE86uYlcwgYJ9ExmEW8dTJTqBV.png', 'applicant test3', 'testpp1238', '28765432098', '51170203', 'medical_support', NULL, 'pending', NULL, NULL, 1, NULL, '2025-10-28 14:28:29', '2025-10-28 14:28:29', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `application_types`
--

CREATE TABLE `application_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mekhala_id` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `areas`
--

INSERT INTO `areas` (`id`, `name`, `description`, `is_active`, `created_at`, `updated_at`, `mekhala_id`) VALUES
(1, 'Farwaniya', 'Farwaniya', 1, '2025-10-28 12:01:59', '2025-10-28 12:22:17', 1),
(2, 'Kuwait City', 'Kuwait City', 1, '2025-10-28 12:03:26', '2025-10-28 13:02:52', 1),
(3, 'Fahaheel', 'Fahaheel', 1, '2025-10-28 12:05:19', '2025-10-28 12:22:11', 1),
(4, 'Abbasiya', 'Abbasiya', 1, '2025-10-28 12:05:33', '2025-10-28 13:02:59', 2),
(5, 'Salmiya', 'Salmiya', 1, '2025-10-28 12:05:47', '2025-10-28 13:03:06', 2),
(6, 'Reggai', 'Reggai', 1, '2025-10-28 12:06:00', '2025-10-28 13:03:13', 2);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `collection_status` enum('payable','received') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'payable',
  `collection_date` date NOT NULL,
  `term` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` int DEFAULT NULL,
  `entered_by` bigint UNSIGNED NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `collections`
--

INSERT INTO `collections` (`id`, `unit_id`, `amount`, `collection_status`, `collection_date`, `term`, `type`, `year`, `entered_by`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, '10.000', 'payable', '2025-09-01', NULL, NULL, NULL, 1, NULL, '2025-10-28 13:03:56', '2025-10-28 13:03:56'),
(2, 1, '200.000', 'payable', '2025-10-28', NULL, NULL, NULL, 1, NULL, '2025-10-28 13:35:42', '2025-10-28 13:35:42'),
(3, 3, '150.000', 'payable', '2025-10-28', NULL, NULL, NULL, 3, NULL, '2025-10-28 14:22:20', '2025-10-28 14:22:20'),
(4, 2, '180.000', 'payable', '2025-10-26', NULL, NULL, NULL, 1, NULL, '2025-10-28 14:29:21', '2025-10-28 14:29:21'),
(5, 1, '10.000', 'payable', '2025-11-06', 'Quarterly', 'July 2025', 2025, 5, NULL, '2025-11-06 14:22:38', '2025-11-06 14:39:42'),
(6, 2, '20.000', 'payable', '2025-11-06', NULL, NULL, 2025, 5, NULL, '2025-11-06 14:22:38', '2025-11-06 14:22:38'),
(7, 3, '30.000', 'payable', '2025-11-06', NULL, NULL, 2025, 5, NULL, '2025-11-06 14:22:38', '2025-11-06 14:22:38'),
(8, 1, '10.000', 'payable', '2025-11-06', 'Quarterly', 'July 2025', NULL, 5, NULL, '2025-11-06 14:40:43', '2025-11-06 14:40:43'),
(9, 2, '10.000', 'payable', '2025-11-06', 'Quarterly', 'July 2025', NULL, 5, NULL, '2025-11-06 14:40:43', '2025-11-06 14:40:43'),
(10, 3, '30.000', 'payable', '2025-11-06', 'Quarterly', 'July 2025', NULL, 5, NULL, '2025-11-06 14:40:43', '2025-11-06 14:40:43');

-- --------------------------------------------------------

--
-- Table structure for table `collection_terms`
--

CREATE TABLE `collection_terms` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `collection_terms`
--

INSERT INTO `collection_terms` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Monthly', 1, '2025-11-05 13:23:35', '2025-11-05 13:23:35'),
(2, 'Quarterly', 1, '2025-11-05 13:23:35', '2025-11-05 13:23:35'),
(5, 'january', 1, '2025-11-06 14:44:41', '2025-11-06 14:44:41'),
(6, 'February', 1, '2025-11-06 14:45:32', '2025-11-06 14:45:32'),
(7, 'March', 1, '2025-11-06 14:45:38', '2025-11-06 14:45:38'),
(8, 'April', 1, '2025-11-06 14:45:44', '2025-11-06 14:45:44'),
(9, 'May', 1, '2025-11-06 14:45:49', '2025-11-06 14:45:49'),
(10, 'June', 1, '2025-11-06 14:45:54', '2025-11-06 14:45:54'),
(11, 'July', 1, '2025-11-06 14:46:01', '2025-11-06 14:46:01'),
(12, 'August', 1, '2025-11-06 14:46:12', '2025-11-06 14:46:12'),
(13, 'September', 1, '2025-11-06 14:46:20', '2025-11-06 14:46:20'),
(14, 'October', 1, '2025-11-06 14:46:28', '2025-11-06 14:46:28'),
(15, 'November', 1, '2025-11-06 14:46:35', '2025-11-06 14:46:35'),
(16, 'December', 1, '2025-11-06 14:46:42', '2025-11-06 14:46:42');

-- --------------------------------------------------------

--
-- Table structure for table `collection_types`
--

CREATE TABLE `collection_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `collection_types`
--

INSERT INTO `collection_types` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(5, 'July 2025', 1, '2025-11-05 13:26:26', '2025-11-05 13:26:26'),
(6, 'August 2025', 1, '2025-11-05 13:30:28', '2025-11-05 13:30:28'),
(7, 'September 2025', 1, '2025-11-05 13:30:44', '2025-11-05 13:30:44'),
(8, 'October 2025', 1, '2025-11-05 13:31:00', '2025-11-05 13:31:00');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint UNSIGNED NOT NULL,
  `expense_date` date NOT NULL,
  `particulars` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(15,3) NOT NULL,
  `bill_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('application','mekhala','refreshment','miscellaneous') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `application_id` bigint UNSIGNED DEFAULT NULL,
  `entered_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `expense_date`, `particulars`, `amount`, `bill_path`, `type`, `application_id`, `entered_by`, `created_at`, `updated_at`) VALUES
(1, '2025-10-28', 'pariculars', '10.000', NULL, 'refreshment', NULL, 1, '2025-10-28 13:14:18', '2025-10-28 13:14:18'),
(2, '2025-10-28', 'Application payment for Applicant1', '100.000', NULL, 'application', 1, 1, '2025-10-28 13:20:49', '2025-10-28 13:20:49'),
(3, '2025-10-28', 'Application payment for Area Application', '100.000', NULL, 'application', 2, 1, '2025-10-28 14:29:51', '2025-10-28 14:29:51'),
(4, '2025-10-20', 'tea and snacks', '10.000', NULL, 'refreshment', NULL, 1, '2025-10-28 14:30:36', '2025-10-28 14:30:36');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `income_generated` decimal(15,2) NOT NULL DEFAULT '0.00',
  `status` enum('invested','income_generated','capital_returned') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'invested',
  `returned_amount` decimal(15,2) DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
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
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(28, '2025_11_14_202843_add_unit_area_to_applications_table', 13);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('okvcv0cEUU7GSBNsaqzYdyA8p5vchesNIlr0xgDj', 5, '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiQWE0VU5oYnplczR0MDJDOVo2OXNwVURVVmNxZG1hcllYb3ZmZWNkaCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jb2xsZWN0aW9ucy9yZXBvcnQvZHJpbGwtZG93bj9hcmVhX2lkPTMmeWVhcj0yMDI1IjtzOjU6InJvdXRlIjtzOjI4OiJjb2xsZWN0aW9ucy5yZXBvcnQuZHJpbGxkb3duIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NTt9', 1762458216),
('P2VKoOqj1Y8UoPRwbtfeWXvRW1Ardx4VgvsxsHCD', 5, '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoidkxKQXdGMkZaNzlQQ3I5UTd6WFRsejh6eW0zNEVNdzA5ek44VjR0cCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMS9jb2xsZWN0aW9ucy9leHBvcnQ/ZmlsdGVyXzI9bmEiO3M6NToicm91dGUiO3M6MTg6ImNvbGxlY3Rpb25zLmV4cG9ydCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1762360884),
('PYykLJFK5gYIk9JX7D6RVoWUNwPnSskWnhG50qyZ', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia2F2WlpBbnlYVjBSclQ4aXN6NGxEbDQwTFMwYzAxc0lRTXNBUXZmViI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1762712074),
('TkFeKFPHjNrSby7imntoXFT7j8x7XQAmYWK5jEyX', NULL, '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:144.0) Gecko/20100101 Firefox/144.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY3hXZkdLYUNwS01hbE5aNDk1bWVUYVNCSjFJY3l2NllCTXRLQ0hnSSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1762627092);

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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area_id` bigint UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `area_id`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Nadi', 3, 'Nadi Fahaheel', 1, '2025-10-28 12:16:49', '2025-10-28 12:16:49'),
(2, 'City', 3, NULL, 1, '2025-10-28 14:15:35', '2025-10-28 14:15:35'),
(3, 'YI Fahaheel', 3, NULL, 1, '2025-10-28 14:17:07', '2025-10-28 14:17:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` enum('admin','area','mekhala','center') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','chairman','treasurer') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_id` bigint UNSIGNED DEFAULT NULL,
  `mekhala_id` bigint UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `user_type`, `role`, `area_id`, `mekhala_id`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Sabeeha', 'sabeehakpm@gmail.com', NULL, '$2y$12$Fuxl6P1HQS/pucOX/nHn8.y7tHfHH.l6kcC3kO5PxaRkv9D3/.ANe', 'mekhala', NULL, 3, 1, 1, NULL, '2025-10-28 11:55:40', '2025-10-28 14:14:52'),
(2, 'Center', 'center@yopmail.com', NULL, '$2y$12$lh80365Cu0CV7wC8rrYVde16yZLvZPRiHqpe4dVGKDlGM4m5hxjcu', 'admin', NULL, NULL, NULL, 1, NULL, '2025-10-28 12:01:16', '2025-10-28 12:01:16'),
(3, 'Shafi PK', 'shfipkm@gmail.com', NULL, '$2y$12$qgC5ONLffrelKJTo273kP.o7HQY3Qqc5azqCYA8shLThlwZ4OqZrG', 'area', NULL, 3, 1, 1, NULL, '2025-10-28 13:55:09', '2025-10-28 14:15:16'),
(4, 'muser', 'muser@yopmail.com', NULL, '$2y$12$nLnwii2JBkMdrew/baGSouV5watW2Swe8o0seiy.gTITES8NVwJde', 'mekhala', NULL, 1, NULL, 1, NULL, '2025-11-05 11:35:48', '2025-11-05 11:35:48'),
(5, 'cuser', 'cuser@yopmail.com', NULL, '$2y$12$05djnuiGirb1u8h40OgIzedEMRVH3EpndHQahZqwHOKSwQuk54I/O', 'center', NULL, 4, NULL, 1, NULL, '2025-11-05 11:42:04', '2025-11-05 11:42:04'),
(6, 'Area User', 'areauser@yopmail.com', NULL, '$2y$12$2p4pRpDiQqjjOAJnfA0wAOl/zLa2K/xDTXZkb7fI1g1jxUTqpkSGK', 'area', NULL, 3, NULL, 1, NULL, '2025-11-05 12:45:20', '2025-11-05 12:45:20');

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
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `application_types`
--
ALTER TABLE `application_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `collection_terms`
--
ALTER TABLE `collection_terms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `collection_types`
--
ALTER TABLE `collection_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investments`
--
ALTER TABLE `investments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
