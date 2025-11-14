-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 14, 2025 at 11:56 PM
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
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

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
