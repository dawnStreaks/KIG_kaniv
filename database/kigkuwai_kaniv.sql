-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 23, 2026 at 12:42 PM
-- Server version: 5.7.44-cll-lve
-- PHP Version: 8.4.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kigkuwai_kaniv`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE `applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `front_page_photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passport_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `civil_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` enum('medical_support','financial_support','iqama_visa_residency','ticket') COLLATE utf8mb4_unicode_ci NOT NULL,
  `application_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `approved_amount` decimal(15,3) DEFAULT NULL,
  `approved_date` date DEFAULT NULL,
  `submitted_by` bigint(20) UNSIGNED NOT NULL,
  `reviewed_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `area_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `front_page_photo`, `name`, `passport_no`, `civil_id`, `mobile_number`, `category`, `application_type_id`, `approved_amount`, `approved_date`, `submitted_by`, `reviewed_by`, `created_at`, `updated_at`, `unit_id`, `area_id`, `status`) VALUES
(25, 'applications/xBfiaUVMYyo6MXSPtEeK2cTlsYVifKseJoDpTsTQ.jpg', 'Jayakrishnan', '000000', '288092909347', '66955495', 'financial_support', 3, 75.000, '2026-01-14', 11, 8, '2026-01-14 08:05:33', '2026-01-14 12:54:09', 7, 1, 'paid'),
(26, 'applications/Pj6xe7YFD87MpSIneJ33VgqkXvbWf36TAFmLn2TT.jpg', 'NISHA MOL', 'ABC', '278010807437', '51676031', 'medical_support', 3, 60.000, '2026-01-27', 10, 8, '2026-01-26 21:40:04', '2026-02-21 12:34:25', 21, 4, 'paid'),
(27, 'applications/VrfnxJaZoa1Hlk4CSqOinZt46Cd5stlrTFkQgS46.jpg', 'MUHAMMED ALI', 'A', '270051105134', '66250841', 'financial_support', 3, 75.000, '2026-01-27', 10, 8, '2026-01-26 21:45:07', '2026-02-21 12:34:30', 18, 4, 'paid'),
(28, 'applications/pMqcxOljQJKmNIIwUdD442O2sfMIph8UKBHPadje.jpg', 'MARY STELLA', 'A', '269052706613', '51617329', 'financial_support', 3, 70.000, '2026-01-27', 10, 8, '2026-01-26 21:47:04', '2026-02-21 12:34:43', 16, 4, 'paid'),
(29, 'applications/sbtZQmjxqjhCD3dNuOSrk0vZ0BTGvRni8eAMZpqm.jpg', 'AHMED NAVEED', '2', '284051805076', '98848643', 'medical_support', 3, 80.000, '2026-01-27', 10, 8, '2026-01-26 21:48:28', '2026-02-21 12:34:48', 16, 4, 'paid'),
(30, 'applications/Ccm8ev5lBYTTBePkmS0TlggBzdQK3p5FGEnuFi6P.jpg', 'RAJEEVAN', '2', '266011605054', '55072986', 'medical_support', 3, 100.000, '2026-01-21', 10, 8, '2026-01-27 17:36:43', '2026-02-21 12:34:51', 17, 4, 'paid'),
(31, 'applications/Ouj9MeBtGkWylRsmxGveMwqbl6Fx1P9vgMxWLb3q.jpg', 'SAMAD KIDARATHIL', 'P4624361', '276052019616', '69643917', 'financial_support', 3, 75.000, '2026-01-31', 13, 4, '2026-01-28 07:27:58', '2026-02-21 15:46:17', 41, 7, 'paid'),
(32, 'applications/Se9NH6lja0b3IXgvAY8Sw11gblREGoSZOoODmfSw.jpg', 'Afsal', 'B6045034', '289121507975', '50186486', 'medical_support', 3, 100.000, '2026-01-31', 13, 4, '2026-01-28 07:36:29', '2026-02-21 15:46:12', 41, 7, 'paid'),
(33, 'applications/KIFcoI8CTEz6g11Rnr1qVRWjeEI2QD7bbPP6Ac5k.jpg', 'BIJU GOPINATH', '.', '281041516138', '67064738', 'medical_support', 3, 100.000, '2026-02-21', 12, 4, '2026-02-02 16:33:16', '2026-02-21 16:09:36', 36, 5, 'paid'),
(34, 'applications/Iw9g164WKPdRBfrjZLfQtIa3NpoDcgW9b23YVjMX.jpg', 'Fathimath Zuhra', 'W8549608', '289070607852', '66108089', 'financial_support', 3, 75.000, '2026-02-21', 12, 4, '2026-02-02 16:39:06', '2026-02-21 16:09:09', 34, 5, 'paid'),
(35, 'applications/gihCpve8SBwaBDqro5LdMwMk2vfi0p4x2pDO92i8.jpg', 'Pramodini', 'Xx', '276031802361', '918921174890', 'ticket', 3, 75.000, '2026-02-21', 11, 8, '2026-02-21 15:21:48', '2026-03-03 18:39:00', 4, 1, 'paid'),
(38, 'applications/OYPj3BRp6ZK6zodu3bFieAnB0wHAgvIOTP6hDLiT.jpg', 'Puravath Muhammed ali', 'Xc', '258042002993', '99235890', 'financial_support', 3, 100.000, '2026-02-21', 11, 8, '2026-02-21 15:35:06', '2026-03-03 18:29:48', 7, 1, 'paid'),
(39, 'applications/5XOKI0Nzunglb8SaI0kx8t0G1KhHrXyAMM7Nh4DK.jpg', 'Sainul Abid', 'Xx', '283010809826', '51375280', 'financial_support', 3, 60.000, '2026-02-21', 11, 8, '2026-02-21 15:36:40', '2026-03-03 18:29:10', 7, 1, 'paid'),
(40, 'applications/zCTA7nGOeFrxwrFn2qYMBfZRFhKzCxFrpfXiDOiP.jpg', 'SMITHA GEORGE', 'ABC', '286120806945', '69924043', 'iqama_visa_residency', 4, 60.000, '2026-02-22', 10, 8, '2026-02-23 00:53:10', '2026-03-03 18:27:12', 21, 4, 'paid'),
(42, 'applications/oVJonuhk1rthcYNyUcDRTLvM693XdxXkPasdK2Fr.jpg', 'RUKEEBI THATTANDAVIDA ASSAINAR', 'ABC', '257112703177', '99017568', 'iqama_visa_residency', 4, 75.000, '2026-02-22', 10, 8, '2026-02-23 00:54:47', '2026-03-03 18:26:36', 22, 4, 'paid'),
(43, 'applications/ZK2X48yVtcCNCaYNQjp17fvDsP6rgdW4oYWarTSl.jpg', 'MARIYAKKUTTY', 'ABC', '261010136732', '65022895', 'iqama_visa_residency', 4, 75.000, '2026-02-22', 10, 8, '2026-02-23 00:56:12', '2026-03-03 18:26:16', 22, 4, 'paid'),
(44, 'applications/dPxbNOtjgcmpdPUMSiCAZ0MEU8jASRFhBucTvkqX.jpg', 'BALKEES', 'ABC', '273052009887', '51486188', 'iqama_visa_residency', 4, 60.000, '2026-02-22', 10, 8, '2026-02-23 00:58:13', '2026-03-03 18:25:49', 15, 4, 'paid'),
(45, 'applications/sdkhRHdvyddUTHgS5PiRZFnPPgi114tLGjGDpcuy.jpg', 'ANNIE THOMMAN DEVASSY THOMMAN', 'ABC', '269041208643', '41208643', 'medical_support', 4, 100.000, '2026-02-22', 10, 8, '2026-02-23 00:59:20', '2026-03-03 18:25:30', 15, 4, 'paid'),
(46, 'applications/ocyR7FpJDsi0xLZbUVENQYcJKHMMLuASiKAMGPHv.jpg', 'ELSAMMA JOB', 'ABC', '270051105187', '51007285', 'financial_support', 4, 50.000, '2026-02-22', 10, 8, '2026-02-23 01:01:03', '2026-03-03 18:25:00', 18, 4, 'paid'),
(47, 'applications/aTQfjx0TugoBXKYnpa3hJxVDgxhD1L8cclxoLjFH.jpg', 'Punnakal Abdul Rahman', 'S5879561', '279031802031', '66390655', 'medical_support', 4, 100.000, '2026-03-04', 9, 8, '2026-03-04 15:04:02', '2026-03-07 22:57:44', 31, 2, 'paid'),
(48, 'applications/lPOfzs00C2wyqeJiLrbdvvmYJsC5cZJrBmD0tZoY.jpg', 'Mohammed Aly', 'W0762240', '275030703324', '8547470389', 'medical_support', 4, 100.000, '2026-03-04', 9, 8, '2026-03-04 15:06:00', '2026-03-07 22:57:38', 31, 2, 'paid'),
(49, 'applications/i0kCvY2U5x6h71GgHkj0jNl809xdTv1uQ7uVLTDJ.jpg', 'Rafeek Puthiyottil', 'X2877410', '276120403653', '8086203842', 'medical_support', 4, 75.000, '2026-03-04', 9, 8, '2026-03-04 15:08:08', '2026-03-07 22:57:35', 30, 2, 'paid'),
(50, 'applications/T4fYdkeP2xjQbxn8G9L7OPUtH5JwqXA5jcHBaNGP.jpg', 'Mohamed Yoosaf', 'M9887168', '277050407281', '60346820', 'iqama_visa_residency', 4, 60.000, '2026-03-04', 9, 8, '2026-03-04 15:11:00', '2026-03-07 22:57:26', 30, 2, 'paid'),
(51, 'applications/rzefymjltHuNDt70bFRjcVWHeClXYKFjBLA7oYVm.jpg', 'Ramesh Kumar', '-', '275051512498', '66061824', 'medical_support', 3, 100.000, '2026-03-09', 6, 4, '2026-03-07 17:01:28', '2026-03-09 15:54:11', 46, 3, 'paid'),
(52, 'applications/gbwdcECI3xBtod9yPCqjfDHWf1ladjEiM0JrYz6w.jpg', 'Abdul Salam', '-', '278010117989', '97866535', 'financial_support', 3, 100.000, '2026-03-09', 6, 4, '2026-03-07 17:03:51', '2026-03-09 15:53:33', 46, 3, 'paid'),
(53, 'applications/l0CVYzaJNaFvh7OenqPtC5LTIjNe0SmGUbLPOKns.jpg', 'Shafeek Abdul Majeed', '-', '287050409999', '8848362664', 'financial_support', 3, 100.000, '2026-03-09', 6, 4, '2026-03-07 17:06:36', '2026-03-09 15:53:26', 50, 3, 'paid'),
(54, 'applications/PmTiS0t5VUJjKz0FsP8Mi9YRAyYiYgQVTLkKelWx.jpg', 'Ajmal Chundan Veetil', '-', '272090403872', '99940875', 'financial_support', 4, 100.000, '2026-03-09', 6, 4, '2026-03-07 17:18:07', '2026-03-09 15:53:18', 48, 3, 'paid'),
(55, 'applications/fRcHQDzFmsIPzlsWUSFw0xUYFKikMxlM0h9CF2yR.jpg', 'Dileep Chandrasekaran', '-', '276052906813', '60698301', 'financial_support', 4, 100.000, '2026-03-09', 6, 4, '2026-03-07 17:20:06', '2026-03-09 15:53:09', 48, 3, 'paid'),
(56, 'applications/OShlGQPIRS4PVyRYcwQMv4K0NxwUTChHBbFZoNEy.jpg', 'Sareena P', '0', '260020701788', '67605930', 'medical_support', 3, 344.800, '2026-03-22', 9, 8, '2026-03-09 13:15:32', '2026-03-22 18:03:28', 30, 2, 'paid'),
(57, 'applications/mjtZqoA2mlpJ0VFNnOpS3w9lgWIP4dwT77jr55UK.jpg', 'Thajudheen', '012', '272052003732', '94090260', 'medical_support', 3, 100.000, '2026-03-22', 9, 8, '2026-03-09 13:17:13', '2026-03-22 18:03:18', 31, 2, 'paid'),
(58, 'applications/VfY8adV3eXYbVwcFq83gD6TYWYZK39sOqgzSzoIo.jpg', 'Asharaf Badar', '0123', '272061704895', '60742528', 'medical_support', 3, 100.000, '2026-03-22', 9, 8, '2026-03-09 13:19:11', '2026-03-22 18:03:07', 29, 2, 'paid'),
(60, 'applications/SYHnaADw3Cw5jDl4YSqediTNsv7nbF5ljLBJKV6W.png', 'SANDHYA JOSE', 'R1377624', '283042606708', '65932746', 'medical_support', 3, 100.000, '2026-03-09', 12, 4, '2026-03-09 16:17:28', '2026-03-09 16:27:27', 33, 5, 'paid'),
(61, 'applications/Xpba2Gdndlp4a8o6KnGmgr0PVt6E39ueOYsC3DKE.jpg', 'Basheer valappil', 'X37886939', '270031506012', '98005575', 'financial_support', 3, 100.000, '2026-03-17', 13, 4, '2026-03-10 17:18:36', '2026-03-17 15:03:22', 42, 7, 'payable'),
(62, 'applications/QCdMP9iG0BCi5tQRESKiNnAeJBNlcdrb03AVizoa.jpg', 'Laila Thajudheen', 'A153750', '260040705022', '00919744350267', 'medical_support', 4, 100.000, '2026-03-16', 13, 4, '2026-03-10 17:22:58', '2026-03-16 14:51:45', 44, 7, 'paid'),
(63, 'applications/OT4droNYPRPA5DMSQB5gXu1LpZpnwnscMmGu4RQs.jpg', 'Saithoon Hameed', 'AH425098', '254041902334', '00917012793610', 'financial_support', 4, 100.000, '2026-03-16', 13, 4, '2026-03-10 17:26:55', '2026-03-16 14:44:10', 45, 7, 'payable'),
(64, 'applications/EHZ0U464chnLqCWiCGFVAYWk1r1EFkaHptngoqkl.jpg', 'Ismail', '-', '289050606553', '69946023', 'financial_support', 3, 75.000, '2026-03-16', 6, 4, '2026-03-12 00:20:49', '2026-03-16 14:49:29', 51, 3, 'paid'),
(66, 'applications/2026/03/HPy7xGOTs941fQIAjG8yuSWcZdEs4esMdoLVJ4ZW.jpg', 'HAMZA KV', '3', '264011001483', '99356750', 'financial_support', 5, 75.000, '2026-03-16', 10, 8, '2026-03-13 15:41:25', '2026-03-18 15:48:47', 15, 4, 'paid'),
(67, 'applications/2026/03/jT9K9YTUPCxYpCGkXPzukhiYAaHT9pKI4Q0zUaPU.jpg', 'Jubairiya Nazeer', '-', '269122904747', '65630623', 'financial_support', 5, 75.000, '2026-03-16', 6, 4, '2026-03-14 23:05:21', '2026-03-16 14:48:28', 49, 3, 'paid'),
(68, 'applications/2026/03/tUbAAok4KrgAfnTLyKl023eaa2NtT8OyOTNaTIsu.jpg', 'Muhammed Shabeeb', '-', '299101804277', '51327515', 'financial_support', 5, 50.000, '2026-03-16', 6, 4, '2026-03-14 23:08:50', '2026-03-16 14:48:18', 51, 3, 'paid'),
(69, 'applications/2026/03/Wj75ROUgl9p149DmOFIogpm2xPh1w5WneXCBNI9j.jpg', 'Pradeesh Thomson', '-', '290052606475', '55148218', 'financial_support', 5, 100.000, '2026-03-16', 6, 4, '2026-03-14 23:13:16', '2026-03-16 14:48:13', 49, 3, 'paid'),
(71, 'applications/2026/03/wLqDu6PWZZSKsbP44lvYNanEMcsUKwfxB7MQXylq.jpg', 'Moahmmed Thoufeeque', '-', '289060902014', '65500568', 'financial_support', 5, 100.000, '2026-03-16', 6, 4, '2026-03-14 23:15:46', '2026-03-16 14:48:05', 50, 3, 'paid'),
(72, 'applications/2026/03/uAt07OGrtsNwkvkvJh3IzULmq1pXnyOpzHn7BJsh.jpg', 'Rauoof K P', 'V3755777', '270030705482', '+91 73565 35471', 'medical_support', 5, 100.000, '2026-03-16', 9, 8, '2026-03-15 14:04:32', '2026-03-18 15:48:38', 30, 2, 'paid'),
(73, 'applications/2026/03/diGSOYauzxkvlYUIBpuX9AU3nInQi9VkMIyMLWG9.png', 'Siyabdullaha', 'Y3520226', '288052813834', '66967706', 'medical_support', 5, 100.000, '2026-03-16', 12, 4, '2026-03-15 16:09:44', '2026-03-16 14:47:21', 35, 5, 'paid'),
(74, 'applications/2026/03/uA9JOtaED67snARIkwt4GLlRN60I66KS5M4Mi2Iw.jpg', 'Ramla MK', 'S9734307', '267021009138', '66389778', 'medical_support', 5, 100.000, '2026-03-16', 12, 4, '2026-03-15 18:21:03', '2026-03-16 14:47:12', 38, 5, 'paid'),
(75, 'applications/2026/03/JUZYTdR8TTfW0MsQCbKJ10eMUsTo7fRDuseSNm11.jpg', 'Talib', 'X', '254060103837', '51180517', 'financial_support', 5, 75.000, '2026-03-16', 11, 8, '2026-03-16 14:15:56', '2026-03-18 15:48:27', 7, 1, 'paid'),
(76, 'applications/2026/03/OWLnl743wPpl4jaPJdnRll6ejuG2DLNnHGafybmo.jpg', 'Noushad', '@', '278053017144', '65757138', 'financial_support', 5, 70.000, '2026-03-16', 11, 8, '2026-03-16 14:19:28', '2026-03-18 15:48:15', 7, 1, 'paid'),
(78, 'applications/2026/03/lEbSqnf2kfE2BU0scFDCeZshjgnXvblEWCyD9NT3.jpg', 'Basheer', '#', '279021402237', '50506882', 'financial_support', 5, 50.000, '2026-03-16', 11, 8, '2026-03-16 14:22:48', '2026-03-18 15:47:35', 7, 1, 'paid'),
(79, 'applications/2026/03/mzcHgR5eNpxhsnrylFSqiSsDhZhvR8YReuIZLlNU.jpg', 'Ali panikaveetil', '$', '277052103628', '8111959892', 'medical_support', 5, 100.000, '2026-03-16', 11, 8, '2026-03-16 14:25:02', '2026-03-18 15:47:24', 9, 1, 'paid'),
(80, 'applications/2026/03/Hp0N1oU3gKJiuZdzQk2sZMBVr2PIWBasULKWjiDc.jpg', 'SHYAM SUNDAR SENOY', 'R0956003', '297022303918', '99302988', 'medical_support', 5, 100.000, '2026-03-17', 13, 4, '2026-03-16 16:30:03', '2026-03-17 15:04:15', 43, 7, 'paid'),
(81, 'applications/2026/03/1EEaVWNeZTtdmzRiJ3c36vuAUZ00FC9tvyQnz2lT.jpg', 'Rajesh Babu', 'Cv', '279042603222', '60078961', 'financial_support', 5, 75.000, '2026-03-16', 11, 8, '2026-03-16 17:07:31', '2026-03-18 15:47:08', 7, 1, 'paid'),
(83, 'applications/2026/03/azTxwIxtKCtIaEWvQgddwDrgjTojRCACZiXpszkI.jpg', 'Mohammed Shibli', '22668', '289492044008', '66152500', 'iqama_visa_residency', 3, 65.000, '2026-03-17', 9, 8, '2026-03-17 15:29:17', '2026-03-17 15:58:56', 30, 2, 'paid'),
(84, 'applications/2026/03/2vKva2JTTyfCc63Xp4ejx1Vq1XAQ6M9hRnbzSPGm.jpg', 'Leena', 'Bv', '287121808357', '51091889', 'financial_support', 5, 50.000, '2026-03-17', 11, 8, '2026-03-17 16:22:39', '2026-03-18 15:45:17', 56, 1, 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `application_types`
--

CREATE TABLE `application_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `application_types`
--

INSERT INTO `application_types` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Nov 2025', 0, '2025-11-14 21:41:07', '2025-12-22 02:57:43'),
(2, 'Dec 2025', 0, '2025-12-22 02:57:38', '2026-02-19 17:51:10'),
(3, 'Jan 2026', 1, '2025-12-22 02:57:56', '2026-03-17 14:10:20'),
(4, 'Feb 2026', 1, '2026-02-21 12:42:37', '2026-03-17 14:11:28'),
(5, 'Mar 2026', 1, '2026-03-11 20:00:34', '2026-03-11 20:00:34');

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `mekhala_id` bigint(20) UNSIGNED DEFAULT NULL
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
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE `collections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,3) NOT NULL,
  `collection_status` enum('payable','received','forwarded','center_received') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'payable',
  `collection_date` date NOT NULL,
  `term` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `entered_by` bigint(20) UNSIGNED NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `collections`
--

INSERT INTO `collections` (`id`, `unit_id`, `amount`, `collection_status`, `collection_date`, `term`, `type`, `year`, `entered_by`, `notes`, `created_at`, `updated_at`) VALUES
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
(168, 7, 81.000, 'received', '2026-02-21', 'January_2026', 'Monthly Collection', NULL, 11, NULL, '2026-01-21 07:15:59', '2026-02-21 13:05:48'),
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
(227, 54, 6.000, 'received', '2026-01-21', 'January_2026', 'Monthly Collection', NULL, 11, NULL, '2026-02-21 13:08:10', '2026-02-21 13:09:39'),
(228, 55, 8.500, 'received', '2026-01-21', 'January_2026', 'Monthly Collection', NULL, 11, NULL, '2026-02-21 13:08:10', '2026-02-21 13:09:39'),
(229, 4, 40.000, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 11, NULL, '2026-02-21 14:53:49', '2026-03-07 23:14:40'),
(230, 5, 74.000, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 11, NULL, '2026-02-21 14:53:49', '2026-03-07 23:14:40'),
(231, 6, 40.000, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 11, NULL, '2026-02-21 14:53:49', '2026-03-07 23:14:40'),
(232, 7, 92.000, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 11, NULL, '2026-02-21 14:53:49', '2026-03-07 23:14:40'),
(233, 9, 64.600, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 11, NULL, '2026-02-21 14:53:49', '2026-03-07 23:14:40'),
(234, 11, 10.500, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 11, NULL, '2026-02-21 14:53:49', '2026-03-07 23:14:40'),
(235, 12, 5.000, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 11, NULL, '2026-02-21 14:53:49', '2026-03-07 23:14:40'),
(236, 13, 7.000, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 11, NULL, '2026-02-21 14:53:49', '2026-03-07 23:14:40'),
(237, 14, 18.500, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 11, NULL, '2026-02-21 14:53:49', '2026-03-07 23:14:40'),
(238, 54, 10.000, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 11, NULL, '2026-02-21 14:53:49', '2026-03-07 23:14:40'),
(239, 55, 12.000, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 11, NULL, '2026-02-21 14:53:49', '2026-03-07 23:15:02'),
(240, 56, 41.000, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 11, NULL, '2026-02-21 14:53:49', '2026-03-07 23:15:02'),
(241, 25, 59.000, 'received', '2026-02-21', 'February_2026', 'Monthly Collection', NULL, 7, NULL, '2026-02-21 15:33:22', '2026-03-07 23:24:10'),
(242, 26, 55.000, 'received', '2026-02-21', 'February_2026', 'Monthly Collection', NULL, 7, NULL, '2026-02-21 15:33:22', '2026-03-07 23:24:10'),
(243, 27, 12.500, 'received', '2026-02-21', 'February_2026', 'Monthly Collection', NULL, 7, NULL, '2026-02-21 15:33:22', '2026-03-07 23:24:10'),
(244, 28, 15.000, 'received', '2026-02-21', 'February_2026', 'Monthly Collection', NULL, 7, NULL, '2026-02-21 15:33:22', '2026-03-07 23:24:10'),
(245, 15, 40.000, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 10, NULL, '2026-02-22 10:32:46', '2026-03-07 23:12:12'),
(246, 16, 45.000, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 10, NULL, '2026-02-22 10:32:46', '2026-03-07 23:12:12'),
(247, 17, 40.250, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 10, NULL, '2026-02-22 10:32:46', '2026-03-07 23:12:12'),
(248, 18, 50.000, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 10, NULL, '2026-02-22 10:32:46', '2026-03-07 23:12:12'),
(249, 19, 21.000, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 10, NULL, '2026-02-22 10:32:46', '2026-03-07 23:12:12'),
(250, 20, 10.000, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 10, NULL, '2026-02-22 10:32:46', '2026-03-07 23:12:12'),
(251, 21, 16.500, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 10, NULL, '2026-02-22 10:32:46', '2026-03-07 23:12:12'),
(252, 22, 10.500, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 10, NULL, '2026-02-22 10:32:46', '2026-03-07 23:12:12'),
(253, 23, 8.500, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 10, NULL, '2026-02-22 10:32:46', '2026-03-07 23:12:12'),
(254, 24, 10.500, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 10, NULL, '2026-02-22 10:32:46', '2026-03-07 23:12:12'),
(266, 29, 10.000, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 9, NULL, '2026-03-02 19:20:48', '2026-03-07 23:22:39'),
(267, 30, 42.000, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 9, NULL, '2026-03-02 19:20:48', '2026-03-07 23:22:39'),
(268, 31, 40.500, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 9, NULL, '2026-03-02 19:20:48', '2026-03-07 23:22:39'),
(269, 32, 40.000, 'received', '2026-02-15', 'February_2026', 'Monthly Collection', NULL, 9, NULL, '2026-03-02 19:20:48', '2026-03-07 23:22:39'),
(278, 46, 75.000, 'received', '2025-12-25', 'Blanket_2025', 'Blanket Collection', NULL, 6, NULL, '2026-03-07 17:31:54', '2026-03-09 15:49:39'),
(279, 47, 66.000, 'received', '2025-12-25', 'Blanket_2025', 'Blanket Collection', NULL, 6, NULL, '2026-03-07 17:31:54', '2026-03-09 15:49:39'),
(280, 48, 112.000, 'received', '2025-12-25', 'Blanket_2025', 'Blanket Collection', NULL, 6, NULL, '2026-03-07 17:31:54', '2026-03-09 15:49:39'),
(281, 49, 166.000, 'received', '2025-12-25', 'Blanket_2025', 'Blanket Collection', NULL, 6, NULL, '2026-03-07 17:31:54', '2026-03-09 15:49:39'),
(282, 50, 29.000, 'received', '2025-12-25', 'Blanket_2025', 'Blanket Collection', NULL, 6, NULL, '2026-03-07 17:31:54', '2026-03-09 15:49:39'),
(283, 51, 29.500, 'received', '2025-12-25', 'Blanket_2025', 'Blanket Collection', NULL, 6, NULL, '2026-03-07 17:31:54', '2026-03-09 15:49:39'),
(284, 52, 81.000, 'received', '2025-12-25', 'Blanket_2025', 'Blanket Collection', NULL, 6, NULL, '2026-03-07 17:31:55', '2026-03-09 15:49:39'),
(285, 53, 44.000, 'received', '2025-12-25', 'Blanket_2025', 'Blanket Collection', NULL, 6, NULL, '2026-03-07 17:31:55', '2026-03-09 15:49:39'),
(286, 46, 400.000, 'received', '2026-03-01', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 6, NULL, '2026-03-07 17:34:27', '2026-03-10 18:04:25'),
(287, 47, 245.000, 'received', '2026-03-01', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 6, NULL, '2026-03-07 17:34:27', '2026-03-10 18:04:25'),
(288, 48, 415.000, 'received', '2026-03-01', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 6, NULL, '2026-03-07 17:34:27', '2026-03-10 18:04:25'),
(289, 49, 375.000, 'received', '2026-03-01', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 6, NULL, '2026-03-07 17:34:27', '2026-03-10 18:04:25'),
(290, 50, 95.000, 'received', '2026-03-01', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 6, NULL, '2026-03-07 17:34:27', '2026-03-10 18:04:45'),
(291, 51, 27.850, 'received', '2026-03-01', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 6, NULL, '2026-03-07 17:34:27', '2026-03-10 18:04:45'),
(292, 52, 116.000, 'received', '2026-03-01', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 6, NULL, '2026-03-07 17:34:27', '2026-03-10 18:04:45'),
(293, 53, 142.700, 'received', '2026-03-01', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 6, NULL, '2026-03-07 17:34:27', '2026-03-10 18:04:45'),
(300, 33, 54.000, 'received', '2026-02-25', 'February_2026', 'Monthly Collection', NULL, 12, NULL, '2026-03-09 16:20:39', '2026-03-22 18:54:30'),
(301, 34, 40.000, 'received', '2026-02-25', 'February_2026', 'Monthly Collection', NULL, 12, NULL, '2026-03-09 16:20:39', '2026-03-22 18:54:30'),
(302, 36, 40.000, 'received', '2026-02-25', 'February_2026', 'Monthly Collection', NULL, 12, NULL, '2026-03-09 16:20:39', '2026-03-22 18:54:30'),
(303, 37, 10.500, 'received', '2026-02-25', 'February_2026', 'Monthly Collection', NULL, 12, NULL, '2026-03-09 16:20:39', '2026-03-22 18:54:30'),
(304, 38, 4.000, 'received', '2026-02-25', 'February_2026', 'Monthly Collection', NULL, 12, NULL, '2026-03-09 16:20:39', '2026-03-22 18:54:30'),
(305, 39, 11.750, 'received', '2026-02-25', 'February_2026', 'Monthly Collection', NULL, 12, NULL, '2026-03-09 16:20:39', '2026-03-22 18:54:30'),
(306, 40, 340.000, 'received', '2026-03-10', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 13, NULL, '2026-03-10 17:49:27', '2026-03-10 18:04:25'),
(307, 41, 546.000, 'received', '2026-03-10', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 13, NULL, '2026-03-10 17:49:27', '2026-03-10 18:04:25'),
(308, 42, 245.000, 'received', '2026-03-10', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 13, NULL, '2026-03-10 17:49:27', '2026-03-10 18:04:25'),
(309, 43, 60.000, 'received', '2026-03-10', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 13, NULL, '2026-03-10 17:49:27', '2026-03-10 18:04:25'),
(310, 44, 154.000, 'received', '2026-03-10', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 13, NULL, '2026-03-10 17:49:27', '2026-03-10 18:04:25'),
(311, 45, 200.000, 'received', '2026-03-10', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 13, NULL, '2026-03-10 17:49:27', '2026-03-10 18:04:25'),
(312, 29, 74.000, 'received', '2026-01-23', 'Blanket_2025', 'Blanket Collection', NULL, 9, NULL, '2026-03-10 18:50:28', '2026-03-11 17:57:46'),
(313, 30, 23.000, 'received', '2026-01-23', 'Blanket_2025', 'Blanket Collection', NULL, 9, NULL, '2026-03-10 18:50:28', '2026-03-11 17:57:46'),
(314, 31, 14.000, 'received', '2026-01-23', 'Blanket_2025', 'Blanket Collection', NULL, 9, NULL, '2026-03-10 18:50:28', '2026-03-11 17:57:46'),
(315, 32, 14.000, 'received', '2026-01-23', 'Blanket_2025', 'Blanket Collection', NULL, 9, NULL, '2026-03-10 18:50:28', '2026-03-11 17:57:46'),
(316, 29, 185.000, 'received', '2026-03-15', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 9, NULL, '2026-03-15 14:00:57', '2026-03-22 18:11:55'),
(317, 30, 90.000, 'received', '2026-03-15', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 9, NULL, '2026-03-15 14:00:57', '2026-03-22 18:11:55'),
(318, 31, 113.450, 'received', '2026-03-15', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 9, NULL, '2026-03-15 14:00:57', '2026-03-22 18:11:55'),
(319, 32, 35.000, 'received', '2026-03-15', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 9, NULL, '2026-03-15 14:00:57', '2026-03-22 18:11:55'),
(320, 29, 13.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 9, NULL, '2026-03-15 14:06:36', '2026-03-15 18:50:58'),
(321, 30, 42.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 9, NULL, '2026-03-15 14:06:36', '2026-03-15 18:50:58'),
(322, 31, 40.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 9, NULL, '2026-03-15 14:06:36', '2026-03-15 18:50:58'),
(323, 32, 40.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 9, NULL, '2026-03-15 14:06:36', '2026-03-15 18:50:58'),
(324, 40, 41.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 13, NULL, '2026-03-15 14:08:50', '2026-03-15 20:10:44'),
(325, 41, 40.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 13, NULL, '2026-03-15 14:08:50', '2026-03-15 20:10:44'),
(326, 42, 40.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 13, NULL, '2026-03-15 14:08:50', '2026-03-15 20:10:44'),
(327, 43, 14.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 13, NULL, '2026-03-15 14:08:50', '2026-03-15 20:10:44'),
(328, 44, 16.250, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 13, NULL, '2026-03-15 14:08:50', '2026-03-15 20:10:44'),
(329, 45, 23.500, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 13, NULL, '2026-03-15 14:08:50', '2026-03-15 20:10:44'),
(330, 33, 545.000, 'received', '2026-03-15', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 12, NULL, '2026-03-15 15:49:49', '2026-03-22 18:26:15'),
(331, 34, 1000.000, 'received', '2026-03-15', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 12, NULL, '2026-03-15 15:49:49', '2026-03-22 18:26:15'),
(332, 35, 55.000, 'received', '2026-03-15', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 12, NULL, '2026-03-15 15:49:49', '2026-03-22 18:26:15'),
(333, 36, 343.750, 'received', '2026-03-15', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 12, NULL, '2026-03-15 15:49:49', '2026-03-22 18:26:15'),
(334, 37, 150.000, 'received', '2026-03-15', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 12, NULL, '2026-03-15 15:49:49', '2026-03-22 18:26:15'),
(335, 38, 555.000, 'received', '2026-03-15', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 12, NULL, '2026-03-15 15:49:49', '2026-03-22 18:26:15'),
(336, 39, 214.050, 'received', '2026-03-15', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 12, NULL, '2026-03-15 15:49:49', '2026-03-22 18:26:15'),
(337, 4, 40.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 11, NULL, '2026-03-15 17:53:32', '2026-03-15 18:50:28'),
(338, 5, 74.500, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 11, NULL, '2026-03-15 17:53:32', '2026-03-15 18:50:28'),
(339, 6, 42.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 11, NULL, '2026-03-15 17:53:32', '2026-03-15 18:50:28'),
(340, 7, 124.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 11, NULL, '2026-03-15 17:53:32', '2026-03-16 00:03:18'),
(341, 9, 67.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 11, NULL, '2026-03-15 17:53:32', '2026-03-15 18:50:28'),
(342, 11, 10.500, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 11, NULL, '2026-03-15 17:53:32', '2026-03-15 18:50:28'),
(343, 12, 10.500, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 11, NULL, '2026-03-15 17:53:32', '2026-03-15 18:50:28'),
(344, 13, 6.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 11, NULL, '2026-03-15 17:53:32', '2026-03-15 18:50:28'),
(345, 14, 17.500, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 11, NULL, '2026-03-15 17:53:32', '2026-03-15 18:50:28'),
(346, 54, 8.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 11, NULL, '2026-03-15 17:53:32', '2026-03-15 18:50:28'),
(347, 55, 12.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 11, NULL, '2026-03-15 17:53:32', '2026-03-22 21:48:05'),
(348, 56, 50.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 11, NULL, '2026-03-15 17:53:32', '2026-03-22 21:48:05'),
(349, 15, 40.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 10, NULL, '2026-03-15 17:53:49', '2026-03-15 18:50:01'),
(350, 16, 40.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 10, NULL, '2026-03-15 17:53:49', '2026-03-15 18:50:01'),
(351, 17, 11.250, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 10, NULL, '2026-03-15 17:53:49', '2026-03-15 18:50:01'),
(352, 18, 42.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 10, NULL, '2026-03-15 17:53:49', '2026-03-15 18:50:01'),
(353, 20, 25.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 10, NULL, '2026-03-15 17:53:49', '2026-03-15 18:50:01'),
(354, 21, 14.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 10, NULL, '2026-03-15 17:53:49', '2026-03-15 18:50:01'),
(355, 22, 12.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 10, NULL, '2026-03-15 17:53:49', '2026-03-15 18:50:01'),
(356, 23, 8.500, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 10, NULL, '2026-03-15 17:53:49', '2026-03-15 18:50:01'),
(357, 24, 9.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 10, NULL, '2026-03-15 17:53:49', '2026-03-15 18:50:01'),
(358, 19, 40.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 10, NULL, '2026-03-15 18:35:48', '2026-03-15 18:50:01'),
(359, 46, 100.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 6, NULL, '2026-03-15 18:40:50', '2026-03-15 21:51:56'),
(360, 47, 33.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 6, NULL, '2026-03-15 18:40:50', '2026-03-15 21:51:56'),
(361, 48, 50.500, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 6, NULL, '2026-03-15 18:40:50', '2026-03-15 21:51:56'),
(362, 49, 52.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 6, NULL, '2026-03-15 18:40:50', '2026-03-15 21:51:56'),
(363, 50, 34.500, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 6, NULL, '2026-03-15 18:40:50', '2026-03-15 21:51:56'),
(364, 51, 13.500, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 6, NULL, '2026-03-15 18:40:50', '2026-03-15 21:51:56'),
(365, 52, 41.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 6, NULL, '2026-03-15 18:40:50', '2026-03-15 21:51:56'),
(366, 53, 8.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 6, NULL, '2026-03-15 18:40:50', '2026-03-15 21:51:56'),
(367, 33, 40.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 12, NULL, '2026-03-15 18:53:11', '2026-03-15 21:33:49'),
(368, 34, 40.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 12, NULL, '2026-03-15 18:53:11', '2026-03-15 21:33:49'),
(369, 36, 51.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 12, NULL, '2026-03-15 18:53:11', '2026-03-15 21:33:49'),
(370, 37, 40.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 12, NULL, '2026-03-15 18:53:11', '2026-03-15 21:33:49'),
(371, 38, 5.000, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 12, NULL, '2026-03-15 18:53:11', '2026-03-15 21:33:49'),
(372, 39, 11.250, 'received', '2026-03-15', 'March_2026', 'Monthly Collection', NULL, 12, NULL, '2026-03-15 18:53:11', '2026-03-15 21:33:49'),
(373, 25, 344.500, 'received', '2026-03-16', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 7, NULL, '2026-03-16 12:06:39', '2026-03-22 18:12:37'),
(374, 26, 210.000, 'received', '2026-03-16', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 7, NULL, '2026-03-16 12:06:39', '2026-03-22 18:12:37'),
(375, 27, 172.000, 'received', '2026-03-16', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 7, NULL, '2026-03-16 12:06:39', '2026-03-22 18:12:37'),
(376, 28, 95.000, 'received', '2026-03-16', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 7, NULL, '2026-03-16 12:06:39', '2026-03-22 18:12:37'),
(377, 4, 165.000, 'received', '2026-03-15', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 11, NULL, '2026-03-16 13:34:34', '2026-03-22 18:14:44'),
(378, 5, 422.000, 'received', '2026-03-15', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 11, NULL, '2026-03-16 13:34:34', '2026-03-22 18:14:44'),
(379, 6, 278.500, 'received', '2026-03-15', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 11, NULL, '2026-03-16 13:34:34', '2026-03-22 18:14:44'),
(380, 7, 350.000, 'received', '2026-03-15', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 11, NULL, '2026-03-16 13:34:34', '2026-03-22 18:14:44'),
(381, 9, 963.000, 'payable', '2026-03-15', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 11, NULL, '2026-03-16 13:34:34', '2026-03-16 13:34:34'),
(382, 11, 185.000, 'received', '2026-03-15', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 11, NULL, '2026-03-16 13:34:34', '2026-03-22 18:14:44'),
(383, 12, 375.700, 'received', '2026-03-15', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 11, NULL, '2026-03-16 13:34:34', '2026-03-22 18:14:44'),
(384, 13, 30.000, 'received', '2026-03-15', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 11, NULL, '2026-03-16 13:34:34', '2026-03-22 18:14:44'),
(385, 14, 52.500, 'received', '2026-03-15', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 11, NULL, '2026-03-16 13:34:34', '2026-03-22 18:14:44'),
(386, 54, 175.000, 'received', '2026-03-15', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 11, NULL, '2026-03-16 13:34:34', '2026-03-22 18:14:44'),
(387, 55, 277.000, 'received', '2026-03-15', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 11, NULL, '2026-03-16 13:34:34', '2026-03-22 18:15:23'),
(388, 56, 650.000, 'received', '2026-03-15', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 11, NULL, '2026-03-16 13:34:34', '2026-03-22 18:15:23'),
(389, 25, 54.000, 'received', '2026-03-17', 'March_2026', 'Monthly Collection', NULL, 7, NULL, '2026-03-17 22:21:50', '2026-03-22 21:46:06'),
(390, 26, 55.000, 'received', '2026-03-17', 'March_2026', 'Monthly Collection', NULL, 7, NULL, '2026-03-17 22:21:50', '2026-03-22 21:46:06'),
(391, 27, 12.000, 'received', '2026-03-17', 'March_2026', 'Monthly Collection', NULL, 7, NULL, '2026-03-17 22:21:50', '2026-03-22 21:46:06'),
(392, 28, 8.000, 'received', '2026-03-17', 'March_2026', 'Monthly Collection', NULL, 7, NULL, '2026-03-17 22:21:50', '2026-03-22 21:46:06'),
(393, 25, 114.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 7, NULL, '2026-03-20 17:43:19', '2026-03-20 17:43:19'),
(394, 26, 217.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 7, NULL, '2026-03-20 17:43:19', '2026-03-20 17:43:19'),
(395, 27, 29.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 7, NULL, '2026-03-20 17:43:19', '2026-03-20 17:43:19'),
(396, 28, 30.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 7, NULL, '2026-03-20 17:43:19', '2026-03-20 19:49:27'),
(397, 15, 305.000, 'received', '2026-03-01', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 10, NULL, '2026-03-21 18:03:59', '2026-03-21 18:17:40'),
(398, 16, 450.000, 'received', '2026-03-01', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 10, NULL, '2026-03-21 18:03:59', '2026-03-21 18:17:40'),
(399, 17, 174.000, 'received', '2026-03-01', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 10, NULL, '2026-03-21 18:03:59', '2026-03-21 18:17:40'),
(400, 18, 480.000, 'received', '2026-03-01', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 10, NULL, '2026-03-21 18:03:59', '2026-03-21 18:17:40'),
(401, 19, 320.000, 'received', '2026-03-01', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 10, NULL, '2026-03-21 18:03:59', '2026-03-21 18:17:40'),
(402, 20, 68.500, 'received', '2026-03-01', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 10, NULL, '2026-03-21 18:03:59', '2026-03-21 18:17:40'),
(403, 21, 123.100, 'received', '2026-03-01', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 10, NULL, '2026-03-21 18:03:59', '2026-03-21 18:17:40'),
(404, 22, 150.000, 'received', '2026-03-01', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 10, NULL, '2026-03-21 18:03:59', '2026-03-21 18:17:40'),
(405, 23, 122.500, 'received', '2026-03-01', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 10, NULL, '2026-03-21 18:03:59', '2026-03-21 18:17:40'),
(406, 24, 213.000, 'received', '2026-03-01', 'Ifthar_2026', 'Ifthar_Kit Collection', NULL, 10, NULL, '2026-03-21 18:03:59', '2026-03-21 18:17:40'),
(407, 15, 282.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 10, NULL, '2026-03-21 18:05:15', '2026-03-21 18:05:15'),
(408, 16, 210.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 10, NULL, '2026-03-21 18:05:15', '2026-03-21 20:29:50'),
(409, 17, 264.500, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 10, NULL, '2026-03-21 18:05:16', '2026-03-21 18:05:16'),
(410, 19, 246.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 10, NULL, '2026-03-21 18:06:39', '2026-03-21 18:06:39'),
(411, 20, 61.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 10, NULL, '2026-03-21 18:06:39', '2026-03-21 18:06:39'),
(412, 24, 173.500, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 10, NULL, '2026-03-21 18:06:39', '2026-03-21 18:06:39'),
(413, 18, 294.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 10, NULL, '2026-03-21 18:09:32', '2026-03-21 18:09:32'),
(414, 40, 40.000, 'received', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 13, NULL, '2026-03-22 08:54:36', '2026-03-22 18:53:55'),
(415, 41, 40.500, 'received', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 13, NULL, '2026-03-22 08:54:36', '2026-03-22 18:53:55'),
(416, 42, 35.000, 'received', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 13, NULL, '2026-03-22 08:54:36', '2026-03-22 18:53:55'),
(417, 43, 27.000, 'received', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 13, NULL, '2026-03-22 08:54:36', '2026-03-22 18:53:55'),
(418, 44, 16.500, 'received', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 13, NULL, '2026-03-22 08:54:36', '2026-03-22 18:53:55'),
(419, 45, 12.000, 'received', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 13, NULL, '2026-03-22 08:54:36', '2026-03-22 18:53:55'),
(420, 40, 40.000, 'received', '2026-02-16', 'February_2026', 'Monthly Collection', NULL, 13, NULL, '2026-03-22 08:57:57', '2026-03-22 18:53:19'),
(421, 41, 40.000, 'received', '2026-02-16', 'February_2026', 'Monthly Collection', NULL, 13, NULL, '2026-03-22 08:57:57', '2026-03-22 18:53:19'),
(422, 42, 44.500, 'received', '2026-02-16', 'February_2026', 'Monthly Collection', NULL, 13, NULL, '2026-03-22 08:57:57', '2026-03-22 18:54:30'),
(423, 43, 20.000, 'received', '2026-02-16', 'February_2026', 'Monthly Collection', NULL, 13, NULL, '2026-03-22 08:57:57', '2026-03-22 18:54:30'),
(424, 44, 18.250, 'received', '2026-02-16', 'February_2026', 'Monthly Collection', NULL, 13, NULL, '2026-03-22 08:57:57', '2026-03-22 18:54:30'),
(425, 45, 19.000, 'received', '2026-02-16', 'February_2026', 'Monthly Collection', NULL, 13, NULL, '2026-03-22 08:57:57', '2026-03-22 18:54:30'),
(426, 40, 52.000, 'received', '2025-12-31', 'Blanket_2025', 'Blanket Collection', NULL, 13, NULL, '2026-03-22 09:01:46', '2026-03-22 18:56:06'),
(427, 41, 25.000, 'received', '2025-12-31', 'Blanket_2025', 'Blanket Collection', NULL, 13, NULL, '2026-03-22 09:01:46', '2026-03-22 18:56:06'),
(428, 42, 42.000, 'received', '2025-12-31', 'Blanket_2025', 'Blanket Collection', NULL, 13, NULL, '2026-03-22 09:01:46', '2026-03-22 18:56:06'),
(429, 43, 16.000, 'received', '2025-12-31', 'Blanket_2025', 'Blanket Collection', NULL, 13, NULL, '2026-03-22 09:01:46', '2026-03-22 18:56:23'),
(430, 44, 62.000, 'received', '2025-12-31', 'Blanket_2025', 'Blanket Collection', NULL, 13, NULL, '2026-03-22 09:01:46', '2026-03-22 18:56:23'),
(431, 45, 84.000, 'received', '2025-12-31', 'Blanket_2025', 'Blanket Collection', NULL, 13, NULL, '2026-03-22 09:01:46', '2026-03-22 18:56:23'),
(432, 46, 75.000, 'received', '2026-01-28', 'January_2026', 'Monthly Collection', NULL, 6, NULL, '2026-03-22 09:07:10', '2026-03-22 18:53:05'),
(433, 47, 42.500, 'received', '2026-01-28', 'January_2026', 'Monthly Collection', NULL, 6, NULL, '2026-03-22 09:07:10', '2026-03-22 18:53:05'),
(434, 48, 40.000, 'received', '2026-01-28', 'January_2026', 'Monthly Collection', NULL, 6, NULL, '2026-03-22 09:07:10', '2026-03-22 18:53:05'),
(435, 49, 50.000, 'received', '2026-01-28', 'January_2026', 'Monthly Collection', NULL, 6, NULL, '2026-03-22 09:07:10', '2026-03-22 18:53:55'),
(436, 50, 21.000, 'received', '2026-01-28', 'January_2026', 'Monthly Collection', NULL, 6, NULL, '2026-03-22 09:07:10', '2026-03-22 18:53:55'),
(437, 51, 11.000, 'received', '2026-01-28', 'January_2026', 'Monthly Collection', NULL, 6, NULL, '2026-03-22 09:07:10', '2026-03-22 18:53:55'),
(438, 46, 100.000, 'received', '2026-03-07', 'February_2026', 'Monthly Collection', NULL, 6, NULL, '2026-03-22 09:11:16', '2026-03-22 18:53:19'),
(439, 47, 40.000, 'received', '2026-03-07', 'February_2026', 'Monthly Collection', NULL, 6, NULL, '2026-03-22 09:11:16', '2026-03-22 18:53:19'),
(440, 48, 44.000, 'received', '2026-03-07', 'February_2026', 'Monthly Collection', NULL, 6, NULL, '2026-03-22 09:11:16', '2026-03-22 18:53:19'),
(441, 49, 52.000, 'received', '2026-03-07', 'February_2026', 'Monthly Collection', NULL, 6, NULL, '2026-03-22 09:11:16', '2026-03-22 18:53:19'),
(442, 50, 26.000, 'received', '2026-03-07', 'February_2026', 'Monthly Collection', NULL, 6, NULL, '2026-03-22 09:11:16', '2026-03-22 18:53:19'),
(443, 51, 15.000, 'received', '2026-03-07', 'February_2026', 'Monthly Collection', NULL, 6, NULL, '2026-03-22 09:11:16', '2026-03-22 18:53:19'),
(444, 52, 37.000, 'received', '2026-03-07', 'February_2026', 'Monthly Collection', NULL, 6, NULL, '2026-03-22 09:11:16', '2026-03-22 18:53:19'),
(445, 53, 8.500, 'received', '2026-03-07', 'February_2026', 'Monthly Collection', NULL, 6, NULL, '2026-03-22 09:11:16', '2026-03-22 18:53:19'),
(446, 33, 125.000, 'received', '2025-12-30', 'Blanket_2025', 'Blanket Collection', NULL, 12, NULL, '2026-03-22 09:15:41', '2026-03-22 18:56:06'),
(447, 34, 122.000, 'received', '2025-12-30', 'Blanket_2025', 'Blanket Collection', NULL, 12, NULL, '2026-03-22 09:15:41', '2026-03-22 18:56:06'),
(448, 35, 4.000, 'received', '2025-12-30', 'Blanket_2025', 'Blanket Collection', NULL, 12, NULL, '2026-03-22 09:15:41', '2026-03-22 18:56:06'),
(449, 36, 50.000, 'received', '2025-12-30', 'Blanket_2025', 'Blanket Collection', NULL, 12, NULL, '2026-03-22 09:15:41', '2026-03-22 18:56:06'),
(450, 37, 28.000, 'received', '2025-12-30', 'Blanket_2025', 'Blanket Collection', NULL, 12, NULL, '2026-03-22 09:15:42', '2026-03-22 18:56:06'),
(451, 38, 182.500, 'received', '2025-12-30', 'Blanket_2025', 'Blanket Collection', NULL, 12, NULL, '2026-03-22 09:15:42', '2026-03-22 18:56:06'),
(452, 39, 138.000, 'received', '2025-12-30', 'Blanket_2025', 'Blanket Collection', NULL, 12, NULL, '2026-03-22 09:15:42', '2026-03-22 18:56:06'),
(453, 33, 40.000, 'received', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 12, NULL, '2026-03-22 09:18:47', '2026-03-22 18:53:05'),
(454, 34, 40.000, 'received', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 12, NULL, '2026-03-22 09:18:47', '2026-03-22 18:53:05'),
(455, 35, 5.000, 'received', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 12, NULL, '2026-03-22 09:18:47', '2026-03-22 18:53:05'),
(456, 36, 43.000, 'received', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 12, NULL, '2026-03-22 09:18:47', '2026-03-22 18:53:05'),
(457, 37, 33.500, 'received', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 12, NULL, '2026-03-22 09:18:47', '2026-03-22 18:53:05'),
(458, 38, 3.000, 'received', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 12, NULL, '2026-03-22 09:18:47', '2026-03-22 18:53:05'),
(459, 39, 6.500, 'received', '2026-01-20', 'January_2026', 'Monthly Collection', NULL, 12, NULL, '2026-03-22 09:18:47', '2026-03-22 18:53:05'),
(460, 25, 126.000, 'received', '2025-12-25', 'Blanket_2025', 'Blanket Collection', NULL, 7, NULL, '2026-03-22 10:50:16', '2026-03-22 18:27:02'),
(461, 26, 50.000, 'received', '2025-12-25', 'Blanket_2025', 'Blanket Collection', NULL, 7, NULL, '2026-03-22 10:50:16', '2026-03-22 18:27:02'),
(462, 27, 31.000, 'received', '2025-12-25', 'Blanket_2025', 'Blanket Collection', NULL, 7, NULL, '2026-03-22 10:50:16', '2026-03-22 18:27:02'),
(463, 28, 10.000, 'received', '2025-12-25', 'Blanket_2025', 'Blanket Collection', NULL, 7, NULL, '2026-03-22 10:50:16', '2026-03-22 18:27:02'),
(464, 40, 211.000, 'received', '2026-03-22', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 13, NULL, '2026-03-22 13:37:17', '2026-03-22 18:29:00'),
(465, 41, 244.000, 'received', '2026-03-22', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 13, NULL, '2026-03-22 13:37:17', '2026-03-22 18:29:00'),
(466, 42, 174.000, 'received', '2026-03-22', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 13, NULL, '2026-03-22 13:37:17', '2026-03-22 18:29:00'),
(467, 43, 92.000, 'received', '2026-03-22', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 13, NULL, '2026-03-22 13:37:17', '2026-03-22 18:29:00'),
(468, 44, 44.000, 'received', '2026-03-22', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 13, NULL, '2026-03-22 13:37:17', '2026-03-22 18:29:00'),
(469, 45, 31.000, 'received', '2026-03-22', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 13, NULL, '2026-03-22 13:37:17', '2026-03-22 18:29:00'),
(470, 29, 54.000, 'payable', '2026-03-23', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 9, NULL, '2026-03-23 08:38:10', '2026-03-23 08:38:10'),
(471, 30, 211.000, 'payable', '2026-03-23', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 9, NULL, '2026-03-23 08:38:10', '2026-03-23 08:38:10'),
(472, 31, 177.000, 'payable', '2026-03-23', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 9, NULL, '2026-03-23 08:38:10', '2026-03-23 08:38:10'),
(473, 32, 70.000, 'payable', '2026-03-23', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 9, NULL, '2026-03-23 08:38:10', '2026-03-23 08:38:10'),
(474, 4, 221.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 11, NULL, '2026-03-23 11:23:07', '2026-03-23 11:23:07'),
(475, 5, 427.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 11, NULL, '2026-03-23 11:23:07', '2026-03-23 11:23:07'),
(476, 6, 278.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 11, NULL, '2026-03-23 11:23:07', '2026-03-23 11:23:07'),
(477, 7, 168.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 11, NULL, '2026-03-23 11:23:07', '2026-03-23 11:23:07'),
(478, 9, 288.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 11, NULL, '2026-03-23 11:23:07', '2026-03-23 11:23:07'),
(479, 11, 38.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 11, NULL, '2026-03-23 11:23:07', '2026-03-23 11:23:07'),
(480, 12, 52.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 11, NULL, '2026-03-23 11:23:07', '2026-03-23 11:23:07'),
(481, 13, 60.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 11, NULL, '2026-03-23 11:23:07', '2026-03-23 11:23:07'),
(482, 14, 115.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 11, NULL, '2026-03-23 11:23:07', '2026-03-23 11:23:07'),
(483, 54, 42.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 11, NULL, '2026-03-23 11:23:07', '2026-03-23 11:23:07'),
(484, 55, 15.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 11, NULL, '2026-03-23 11:23:07', '2026-03-23 11:23:07'),
(485, 56, 186.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 11, NULL, '2026-03-23 11:23:07', '2026-03-23 11:23:07'),
(486, 33, 311.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 12, NULL, '2026-03-23 11:42:34', '2026-03-23 11:42:34'),
(487, 34, 275.500, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 12, NULL, '2026-03-23 11:42:34', '2026-03-23 11:42:34'),
(488, 35, 87.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 12, NULL, '2026-03-23 11:42:34', '2026-03-23 11:42:34'),
(489, 36, 214.500, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 12, NULL, '2026-03-23 11:42:34', '2026-03-23 11:42:34'),
(490, 37, 113.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 12, NULL, '2026-03-23 11:42:34', '2026-03-23 11:42:34'),
(491, 38, 26.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 12, NULL, '2026-03-23 11:42:34', '2026-03-23 11:42:34'),
(492, 39, 73.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 12, NULL, '2026-03-23 11:42:34', '2026-03-23 11:42:34'),
(493, 57, 21.000, 'payable', '2026-03-20', 'Fithr_Zakath_2026', 'Fithr_Zakath', NULL, 12, NULL, '2026-03-23 12:06:26', '2026-03-23 12:06:26');

-- --------------------------------------------------------

--
-- Table structure for table `collection_terms`
--

CREATE TABLE `collection_terms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `collection_type_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `collection_terms`
--

INSERT INTO `collection_terms` (`id`, `name`, `is_active`, `collection_type_id`, `created_at`, `updated_at`) VALUES
(15, 'January_2026', 1, NULL, '2025-11-06 14:46:35', '2026-03-22 08:52:01'),
(16, 'December_2025', 0, NULL, '2025-11-06 14:46:42', '2026-02-19 17:50:12'),
(17, 'Blanket_2025', 1, NULL, '2025-12-09 08:07:43', '2026-03-22 08:51:56'),
(18, 'February_2026', 1, NULL, '2026-02-19 17:50:55', '2026-03-22 08:51:59'),
(19, 'Ifthar_2026', 1, NULL, '2026-02-21 15:37:16', '2026-02-21 15:37:16'),
(20, 'March_2026', 1, NULL, '2026-03-15 14:01:52', '2026-03-15 14:01:52'),
(21, 'Fithr_Zakath_2026', 1, NULL, '2026-03-20 14:43:48', '2026-03-20 14:43:48');

-- --------------------------------------------------------

--
-- Table structure for table `collection_types`
--

CREATE TABLE `collection_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `collection_types`
--

INSERT INTO `collection_types` (`id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(8, 'Blanket Collection', 1, '2025-11-05 13:31:00', '2026-03-22 09:00:08'),
(9, 'Monthly Collection', 1, '2025-11-15 16:17:09', '2025-12-09 08:04:51'),
(10, 'Ifthar_Kit Collection', 1, '2026-02-21 15:39:21', '2026-02-21 15:39:21'),
(11, 'Fithr_Zakath', 1, '2026-03-20 14:43:12', '2026-03-20 14:43:12');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expense_date` date NOT NULL,
  `particulars` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` decimal(15,3) NOT NULL,
  `beneficiary` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paid_by_area_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bill_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `application_id` bigint(20) UNSIGNED DEFAULT NULL,
  `entered_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `expense_date`, `particulars`, `amount`, `beneficiary`, `paid_by_area_id`, `bill_path`, `type`, `application_id`, `entered_by`, `created_at`, `updated_at`) VALUES
(1, '2026-01-21', 'Tea & snacks', 2.400, NULL, NULL, NULL, 'refreshment', NULL, 3, '2026-03-22 18:35:56', '2026-03-22 18:35:56'),
(2, '2026-02-15', 'Tea & snacks', 2.500, NULL, NULL, NULL, 'refreshment', NULL, 3, '2026-03-22 18:37:04', '2026-03-22 18:37:04'),
(3, '2026-03-15', 'Ifthar', 10.500, NULL, NULL, NULL, 'refreshment', NULL, 3, '2026-03-22 18:38:36', '2026-03-22 18:38:36'),
(4, '2026-03-18', 'Ifthar kit delivery & food expenses', 14.000, NULL, NULL, NULL, 'miscellaneous', NULL, 3, '2026-03-22 18:41:41', '2026-03-22 18:41:41');

-- --------------------------------------------------------

--
-- Table structure for table `expense_types`
--

CREATE TABLE `expense_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `id` bigint(20) UNSIGNED NOT NULL,
  `investment_date` date NOT NULL,
  `amount` decimal(15,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `income_generated` decimal(15,2) NOT NULL DEFAULT '0.00',
  `status` enum('invested','income_generated','capital_returned') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'invested',
  `returned_amount` decimal(15,2) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `investments`
--

INSERT INTO `investments` (`id`, `investment_date`, `amount`, `description`, `income_generated`, `status`, `returned_amount`, `created_by`, `created_at`, `updated_at`) VALUES
(14, '2026-01-10', 1000.00, 'Deposit Started on 17/Aug/2025- invested fo 3 months duration 3.25% Profit', 18.35, 'capital_returned', 1000.00, 3, '2026-03-02 15:36:10', '2026-03-02 15:36:56'),
(15, '2026-01-10', 1000.00, 'Deposit Started on 18/Aug/2025', 16.28, 'capital_returned', 1000.00, 3, '2026-03-07 15:01:00', '2026-03-07 15:01:43');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mekhalas`
--

CREATE TABLE `mekhalas` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
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
-- Table structure for table `opening_balance`
--

CREATE TABLE `opening_balance` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(15,3) NOT NULL DEFAULT '0.000',
  `year` int(11) NOT NULL,
  `month` int(11) DEFAULT NULL,
  `mekhala_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `opening_balance`
--

INSERT INTO `opening_balance` (`id`, `amount`, `year`, `month`, `mekhala_id`, `created_at`, `updated_at`) VALUES
(7, 3561.190, 2025, 12, 2, '2026-03-22 13:28:22', '2026-03-22 13:28:22'),
(8, 5604.795, 2025, 12, 1, '2026-03-22 13:28:45', '2026-03-22 13:28:45');

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
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('3n6U48FaSpdjqjaQVSufPgNRvh3Ykfxo6VtkDMHL', NULL, '66.249.93.100', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWjNDQ2ZqVEtWWnIxRjQ1Q2s3dVBiMElxUk91UVBzeE9yS1p0MDVNbiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNzoiaHR0cHM6Ly9rYW5pdi5raWdrdXdhaXQuY29tL2Rhc2hib2FyZCI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM3OiJodHRwczovL2thbml2LmtpZ2t1d2FpdC5jb20vZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjk6ImRhc2hib2FyZCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774250406),
('8fPAuWckQlNfJSXDIQMVxz3owlZPamIElg5Cf7bF', NULL, '188.236.233.193', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiajZUdDVpRHVOampobTk5alFmcmdtdkkzYVczWFQ4WUhPM01vUXhuRCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9rYW5pdi5raWdrdXdhaXQuY29tIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774271838),
('cJaAdSnK2e6YXYZae4wGkTAsCZ6LwCTWbXjM9HoQ', 5, '188.71.209.140', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Mobile/15E148 Safari/604.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMlVMcDQwZEpIMndPZFJRdmVSVjhKUkNnVGVCRDVFUkpGQXpUM2hQaSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHBzOi8va2FuaXYua2lna3V3YWl0LmNvbS9hZG1pbi9hcmVhcyI7czo1OiJyb3V0ZSI7czoxNzoiYWRtaW4uYXJlYXMuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1O30=', 1774251991),
('eOtyN6Alxa1fG4pNzvbm6UMfc3Mtiapck0V4cjrb', 5, '188.236.48.237', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRnB3TkVUQTVpZzNpRWVqQTVWRHppU0hLdzEzR2F1dFV3Mk9mN2NVNCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTQ4OiJodHRwczovL2thbml2LmtpZ2t1d2FpdC5jb20vY29sbGVjdGlvbnM/YW1vdW50PSZkYXRlX2Zyb209JmRhdGVfdG89JnN0YXR1cz0mdGVybT1GaXRocl9aYWthdGhfMjAyNiZ0eXBlPUZpdGhyX1pha2F0aCZ1bml0PSZ1c2VyPUthbml2X0FyZWFfRmFyd2FuaXlhIjtzOjU6InJvdXRlIjtzOjE3OiJjb2xsZWN0aW9ucy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==', 1774284122),
('f2YBfh2pNAWlS7TvsRSURwRoiI2kkQg9KdgTaGii', NULL, '188.236.233.193', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia0RrV3pxWTVqNktNdW9YMkxlbmx0SnR2VkhjMzNPRTl0U2VxZHg1RyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9rYW5pdi5raWdrdXdhaXQuY29tL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774271852),
('iDmYRkRspSd96Y9CVq15aDiKKMatB5aruJfELeFx', 2, '94.128.107.7', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:148.0) Gecko/20100101 Firefox/148.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiRnIwMVR0TGpZU0FUNWdOc3AwR0FabkYzM0ZkMTdBSWltZTltMThRRiI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ5OiJodHRwczovL2thbml2LmtpZ2t1d2FpdC5jb20vYWRtaW4vb3BlbmluZy1iYWxhbmNlIjtzOjU6InJvdXRlIjtzOjIxOiJhZG1pbi5vcGVuaW5nLWJhbGFuY2UiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1774283754),
('iMfiDq53KehgRCSpSB3ZMmN7taJGnH4cxesO0cDz', NULL, '188.236.233.193', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiU2liaDdWR0N2Z0lqRkw3NmhGOUhlWjJjNXNDRUp5VW1vaFd3R245USI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8va2FuaXYua2lna3V3YWl0LmNvbS9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774271838),
('JarDStiyZnO1GNXY7fjRI2L4K6w113chc5IzDLcI', NULL, '188.236.233.193', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiRm9hbGJGR0ZsQWhBV2xDSngxNmRETTZnSEhOSXV1VVZ6eGg0YlJnVyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774271855),
('jYkUUohBTIsyI3OTwzh079i6JRXW7xbqVwXu1zgo', 12, '37.39.197.103', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:148.0) Gecko/20100101 Firefox/148.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiVG1peGxEVzZGbFpiWlVXQnl1dUlLZ2NKUHQ2QnFGQUtoa0VJZ05EeCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjM5OiJodHRwczovL2thbml2LmtpZ2t1d2FpdC5jb20vY29sbGVjdGlvbnMiO3M6NToicm91dGUiO3M6MTc6ImNvbGxlY3Rpb25zLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTI7fQ==', 1774253187),
('NB687qdMgmpHM4TeBK0zlWMgfEVGjd4HKbhiNycx', NULL, '94.128.107.7', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:148.0) Gecko/20100101 Firefox/148.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR2VObXYwcWk5S1BzWmZBU2ozd3ZlWHM1bDJ1MkJSRHZUZzZ2aE5JZyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo1ODoiaHR0cHM6Ly9rYW5pdi5raWdrdXdhaXQuY29tL3JlcG9ydHMvZWFzdC1tZWtoYWxhLWZpbmFuY2lhbCI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjU4OiJodHRwczovL2thbml2LmtpZ2t1d2FpdC5jb20vcmVwb3J0cy9lYXN0LW1la2hhbGEtZmluYW5jaWFsIjtzOjU6InJvdXRlIjtzOjIyOiJyZXBvcnRzLmVhc3QtZmluYW5jaWFsIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774283725),
('noKHP8mkI5LUEXRSfCLlg7tfX1VxyddeYXrbyZmu', NULL, '188.71.251.27', 'Mozilla/5.0 (iPhone; CPU iPhone OS 18_7 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/26.3 Mobile/15E148 Safari/604.1', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTUc2Z3J2TzdyRzRBTjhyNWRodmQ2cVkxTUlwUHZyRlZwVHUxTHRNcyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8va2FuaXYua2lna3V3YWl0LmNvbS9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774268330),
('P3EOmDCbodoyZd9pZPYV9X2GfEoHlbDdK9mTLiN5', NULL, '162.243.4.24', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:59.0) Gecko/20100101 Firefox/59.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieEJhRFVCaWNMNGRUZHEyT1ZIbDJpQTN6Y3JQSGRraU5odWU1WEo0WiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9rYW5pdi5raWdrdXdhaXQuY29tIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774271839),
('Q1XxEcYBP8ZE0iZMIGw16gVSQkLWGSlpDkmNgf99', NULL, '188.236.233.193', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWW5XV1VXR2xXZmJweTZNYmNwNjFTd0tlS3FYNE14OWh2ZmVFTVBwZCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzI6Imh0dHA6Ly9rYW5pdi5raWdrdXdhaXQuY29tL2xvZ2luIjtzOjU6InJvdXRlIjtzOjU6ImxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774271839),
('Ra9aHSh6nkeO4QA4xZD747bo61UyIFxDAEg5k0bB', 11, '37.231.247.152', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiM05kYkY4dGV6QVltd0dLejNXWXZDWHA5THhNdnBmMlYyRVN5S21QMiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NjQ6Imh0dHBzOi8va2FuaXYua2lna3V3YWl0LmNvbS9jb2xsZWN0aW9ucz9wYWdlPTImdHlwZT1GaXRocl9aYWthdGgiO3M6NToicm91dGUiO3M6MTc6ImNvbGxlY3Rpb25zLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTE7fQ==', 1774250610),
('RuB36aQVcMhPe7pg7oF666xWcq3erDcLV4Il0Xrs', NULL, '188.236.233.193', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicUZuUWxrQmt6c29TdzA0RldhazRoOFduRjRlMFJIcGh5Z1pObHQ0NCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly9rYW5pdi5raWdrdXdhaXQuY29tIjtzOjU6InJvdXRlIjtOO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1774271851),
('S6UGRQHJ4a1Zvz46kXJDaXXLV3HHiEttVyawpVC2', 2, '94.128.107.7', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:148.0) Gecko/20100101 Firefox/148.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiU1AyS3ZhdEN5S3hYdUJlZFFMVVd4ZlZHZ3ZyR09yVGRjUW1sMlNNdCI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ2OiJodHRwczovL2thbml2LmtpZ2t1d2FpdC5jb20vcmVwb3J0cy9jb2xsZWN0aW9uIjtzOjU6InJvdXRlIjtzOjE4OiJyZXBvcnRzLmNvbGxlY3Rpb24iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1774275029),
('tbwQ56DfpGorWc9yKOQ8cOCEM1bvM9ryFbP900Zb', NULL, '66.249.93.100', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/138.0.0.0 Mobile Safari/537.36 (compatible; Google-Read-Aloud; +https://support.google.com/webmasters/answer/1061943)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoic1IzTHJWM1VmSThtMDcyRGdlOFVXMjB0SHFMYVRyNmxDMjZ6RVpxUCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHBzOi8va2FuaXYua2lna3V3YWl0LmNvbS9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774250406),
('TDgoIDoHkqPAoOdV7KSIsPuBCpx5pD8zdXkaPPsj', NULL, '185.247.137.147', 'Mozilla/5.0 (compatible; InternetMeasurement/1.0; +https://internet-measurement.com/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUGptVmlyYVJqSFlTcXJ4MUkzUFBnZ0hBb0RPMVgwWUxBcUZ4dDRzcyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly93d3cua2FuaXYua2lna3V3YWl0LmNvbS9sb2dpbiI7czo1OiJyb3V0ZSI7czo1OiJsb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1774262344),
('VM0NsaIhcGti76LDPg2NL7smR99E0ErwrS6DIVPE', NULL, '188.236.233.193', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Mobile Safari/537.36', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSWc5djJkV2JsOWJtb1pvMXkwTXZ4ZDFUbWwxZDJ2MWMwT0w1eEtaRCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1774271845);

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `area_id` bigint(20) UNSIGNED NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
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
(56, 'Madeena Khaithan', 1, 'Madeena Khaithan', 1, '2026-01-21 17:00:02', '2026-02-10 14:14:20', 'KIG'),
(57, 'YI-Hawally', 5, NULL, 1, '2026-03-23 11:45:59', '2026-03-23 11:45:59', 'YI');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type` enum('admin','area','mekhala','center') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','chairman','treasurer') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `area_id` bigint(20) UNSIGNED DEFAULT NULL,
  `mekhala_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
(14, 'Salmiya', 'salmiyauser@kig.com', NULL, '$2y$12$kxd/cH.XsTSYha3Bot0BHOzBYz5SSBQexssX1oY0AECqu4qPfHJ4m', 'area', NULL, 5, 1, 1, NULL, '2026-01-03 11:15:24', '2026-01-03 11:15:24'),
(15, 'Ali Vellarathodi', 'vellarathodia@gmail.com', NULL, '$2y$12$kdtu.dQWLwp5jt.ptyq5EexV1ypRwWxmAcAifHu8AdlGellT2GUEW', 'area', NULL, 7, NULL, 1, NULL, '2026-03-10 17:04:03', '2026-03-10 17:04:03');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `collection_terms_collection_type_id_foreign` (`collection_type_id`);

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
  ADD KEY `expenses_entered_by_foreign` (`entered_by`),
  ADD KEY `paid_by_area_id` (`paid_by_area_id`);

--
-- Indexes for table `expense_types`
--
ALTER TABLE `expense_types`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `opening_balance`
--
ALTER TABLE `opening_balance`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_year_mekhala` (`year`,`mekhala_id`),
  ADD KEY `mekhala_id` (`mekhala_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `application_types`
--
ALTER TABLE `application_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=494;

--
-- AUTO_INCREMENT for table `collection_terms`
--
ALTER TABLE `collection_terms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `collection_types`
--
ALTER TABLE `collection_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `expense_types`
--
ALTER TABLE `expense_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `investments`
--
ALTER TABLE `investments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mekhalas`
--
ALTER TABLE `mekhalas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `opening_balance`
--
ALTER TABLE `opening_balance`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
-- Constraints for table `collection_terms`
--
ALTER TABLE `collection_terms`
  ADD CONSTRAINT `collection_terms_collection_type_id_foreign` FOREIGN KEY (`collection_type_id`) REFERENCES `collection_types` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expenses_application_id_foreign` FOREIGN KEY (`application_id`) REFERENCES `applications` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenses_entered_by_foreign` FOREIGN KEY (`entered_by`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `expenses_ibfk_1` FOREIGN KEY (`paid_by_area_id`) REFERENCES `areas` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `investments`
--
ALTER TABLE `investments`
  ADD CONSTRAINT `investments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `opening_balance`
--
ALTER TABLE `opening_balance`
  ADD CONSTRAINT `opening_balance_ibfk_1` FOREIGN KEY (`mekhala_id`) REFERENCES `mekhalas` (`id`) ON DELETE CASCADE;

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
