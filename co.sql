-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Aug 30, 2021 at 04:15 PM
-- Server version: 5.7.32
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `connect`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint(20) UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `activity_log`
--

INSERT INTO `activity_log` (`id`, `log_name`, `description`, `subject_type`, `event`, `subject_id`, `causer_type`, `causer_id`, `properties`, `batch_uuid`, `created_at`, `updated_at`) VALUES
(1, 'default', 'created', 'App\\Models\\User', 'created', 63, 'App\\Models\\User', 2, '[]', NULL, '2021-08-09 04:13:51', '2021-08-09 04:13:51'),
(2, 'default', 'created', 'App\\Models\\User', 'created', 64, 'App\\Models\\User', 2, '[]', NULL, '2021-08-09 04:15:39', '2021-08-09 04:15:39'),
(3, 'default', 'deleted', 'App\\Models\\User', 'deleted', 64, 'App\\Models\\User', 2, '[]', NULL, '2021-08-09 04:17:20', '2021-08-09 04:17:20'),
(4, 'default', 'updated', 'App\\Models\\User', 'updated', 63, 'App\\Models\\User', 2, '[]', NULL, '2021-08-09 04:17:42', '2021-08-09 04:17:42'),
(5, 'default', 'created', 'App\\Models\\Brands', 'created', 17, 'App\\Models\\User', 2, '[]', NULL, '2021-08-09 04:22:33', '2021-08-09 04:22:33'),
(6, 'default', 'deleted', 'App\\Models\\Brands', 'deleted', 17, 'App\\Models\\User', 2, '[]', NULL, '2021-08-09 04:23:07', '2021-08-09 04:23:07'),
(7, 'default', 'deleted', 'App\\Models\\Brands', 'deleted', 12, 'App\\Models\\User', 2, '[]', NULL, '2021-08-09 04:26:02', '2021-08-09 04:26:02'),
(8, 'default', 'updated', 'App\\Models\\User', 'updated', 2, 'App\\Models\\User', 2, '[]', NULL, '2021-08-09 04:26:22', '2021-08-09 04:26:22'),
(9, 'default', 'updated', 'App\\Models\\User', 'updated', 2, 'App\\Models\\User', 2, '[]', NULL, '2021-08-09 05:32:36', '2021-08-09 05:32:36'),
(10, 'default', 'updated', 'App\\Models\\User', 'updated', 2, 'App\\Models\\User', 2, '[]', NULL, '2021-08-09 05:33:08', '2021-08-09 05:33:08'),
(11, 'default', 'deleted', 'App\\Models\\Brands', 'deleted', 7, 'App\\Models\\User', 2, '[]', NULL, '2021-08-09 05:36:54', '2021-08-09 05:36:54'),
(12, 'default', 'created', 'App\\Models\\Brands', 'created', 18, 'App\\Models\\User', 2, '[]', NULL, '2021-08-09 05:37:12', '2021-08-09 05:37:12'),
(13, 'default', 'created', 'App\\Models\\Commercials', 'created', 33, 'App\\Models\\User', 2, '[]', NULL, '2021-08-09 05:40:18', '2021-08-09 05:40:18'),
(14, 'default', 'created', 'App\\Models\\allocation', 'created', 149, 'App\\Models\\User', 2, '[]', NULL, '2021-08-10 00:49:27', '2021-08-10 00:49:27'),
(15, 'default', 'created', 'App\\Models\\allocation', 'created', 150, 'App\\Models\\User', 2, '[]', NULL, '2021-08-10 00:49:27', '2021-08-10 00:49:27'),
(16, 'default', 'created', 'App\\Models\\allocation', 'created', 151, 'App\\Models\\User', 2, '[]', NULL, '2021-08-10 00:49:27', '2021-08-10 00:49:27'),
(17, 'default', 'created', 'App\\Models\\allocation', 'created', 152, 'App\\Models\\User', 2, '[]', NULL, '2021-08-10 00:49:27', '2021-08-10 00:49:27'),
(18, 'default', 'created', 'App\\Models\\allocation', 'created', 153, 'App\\Models\\User', 2, '[]', NULL, '2021-08-10 00:49:27', '2021-08-10 00:49:27'),
(19, 'default', 'created', 'App\\Models\\planDate', 'created', 100, 'App\\Models\\User', 2, '[]', NULL, '2021-08-10 00:50:37', '2021-08-10 00:50:37'),
(20, 'default', 'created', 'App\\Models\\planDate', 'created', 101, 'App\\Models\\User', 2, '[]', NULL, '2021-08-10 00:50:37', '2021-08-10 00:50:37'),
(21, 'default', 'updated', 'App\\Models\\Skus', 'updated', 130, 'App\\Models\\User', 2, '[]', NULL, '2021-08-13 05:55:40', '2021-08-13 05:55:40'),
(22, 'default', 'updated', 'App\\Models\\User', 'updated', 2, 'App\\Models\\User', 2, '[]', NULL, '2021-08-13 06:31:01', '2021-08-13 06:31:01'),
(23, 'default', 'updated', 'App\\Models\\User', 'updated', 2, 'App\\Models\\User', 2, '[]', NULL, '2021-08-13 06:32:27', '2021-08-13 06:32:27'),
(24, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 164, 'App\\Models\\User', 58, '[]', NULL, '2021-08-13 06:44:24', '2021-08-13 06:44:24'),
(25, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 165, 'App\\Models\\User', 58, '[]', NULL, '2021-08-13 06:44:24', '2021-08-13 06:44:24'),
(26, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 166, 'App\\Models\\User', 58, '[]', NULL, '2021-08-13 06:44:25', '2021-08-13 06:44:25'),
(27, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 167, 'App\\Models\\User', 58, '[]', NULL, '2021-08-13 06:44:25', '2021-08-13 06:44:25'),
(28, 'default', 'created', 'App\\Models\\Skus', 'created', 137, 'App\\Models\\User', 2, '[]', NULL, '2021-08-14 04:48:29', '2021-08-14 04:48:29'),
(29, 'default', 'updated', 'App\\Models\\Wrc', 'updated', 50, 'App\\Models\\User', 2, '[]', NULL, '2021-08-14 04:48:29', '2021-08-14 04:48:29'),
(30, 'default', 'created', 'App\\Models\\Skus', 'created', 138, 'App\\Models\\User', 2, '[]', NULL, '2021-08-14 04:48:29', '2021-08-14 04:48:29'),
(31, 'default', 'created', 'App\\Models\\Skus', 'created', 139, 'App\\Models\\User', 2, '[]', NULL, '2021-08-14 04:48:29', '2021-08-14 04:48:29'),
(32, 'default', 'created', 'App\\Models\\Skus', 'created', 140, 'App\\Models\\User', 2, '[]', NULL, '2021-08-14 04:48:29', '2021-08-14 04:48:29'),
(33, 'default', 'created', 'App\\Models\\Skus', 'created', 141, 'App\\Models\\User', 2, '[]', NULL, '2021-08-14 04:48:29', '2021-08-14 04:48:29'),
(34, 'default', 'created', 'App\\Models\\Skus', 'created', 142, 'App\\Models\\User', 2, '[]', NULL, '2021-08-14 04:48:29', '2021-08-14 04:48:29'),
(35, 'default', 'created', 'App\\Models\\Skus', 'created', 143, 'App\\Models\\User', 2, '[]', NULL, '2021-08-14 04:48:29', '2021-08-14 04:48:29'),
(36, 'default', 'updated', 'App\\Models\\User', 'updated', 2, 'App\\Models\\User', 2, '[]', NULL, '2021-08-15 06:56:20', '2021-08-15 06:56:20'),
(37, 'default', 'updated', 'App\\Models\\User', 'updated', 2, 'App\\Models\\User', 2, '[]', NULL, '2021-08-15 06:56:35', '2021-08-15 06:56:35'),
(38, 'default', 'updated', 'App\\Models\\Skus', 'updated', 30, 'App\\Models\\User', 2, '[]', NULL, '2021-08-20 04:52:52', '2021-08-20 04:52:52'),
(39, 'default', 'created', 'App\\Models\\uploadraw', 'created', 152, 'App\\Models\\User', 2, '[]', NULL, '2021-08-20 04:53:06', '2021-08-20 04:53:06'),
(40, 'default', 'created', 'App\\Models\\uploadraw', 'created', 153, 'App\\Models\\User', 2, '[]', NULL, '2021-08-20 04:53:06', '2021-08-20 04:53:06'),
(41, 'default', 'updated', 'App\\Models\\Skus', 'updated', 50, 'App\\Models\\User', 2, '[]', NULL, '2021-08-20 04:53:25', '2021-08-20 04:53:25'),
(42, 'default', 'created', 'App\\Models\\uploadraw', 'created', 154, 'App\\Models\\User', 2, '[]', NULL, '2021-08-20 04:53:33', '2021-08-20 04:53:33'),
(43, 'default', 'created', 'App\\Models\\uploadraw', 'created', 155, 'App\\Models\\User', 2, '[]', NULL, '2021-08-20 04:53:33', '2021-08-20 04:53:33'),
(44, 'default', 'created', 'App\\Models\\uploadraw', 'created', 156, 'App\\Models\\User', 2, '[]', NULL, '2021-08-20 04:53:34', '2021-08-20 04:53:34'),
(45, 'default', 'updated', 'App\\Models\\User', 'updated', 2, 'App\\Models\\User', 2, '[]', NULL, '2021-08-24 09:07:52', '2021-08-24 09:07:52'),
(46, 'default', 'updated', 'App\\Models\\User', 'updated', 2, 'App\\Models\\User', 2, '[]', NULL, '2021-08-24 09:10:08', '2021-08-24 09:10:08'),
(47, 'default', 'created', 'App\\Models\\Skus', 'created', 144, 'App\\Models\\User', 2, '[]', NULL, '2021-08-24 10:05:09', '2021-08-24 10:05:09'),
(48, 'default', 'updated', 'App\\Models\\Wrc', 'updated', 52, 'App\\Models\\User', 2, '[]', NULL, '2021-08-24 10:05:09', '2021-08-24 10:05:09'),
(49, 'default', 'created', 'App\\Models\\Skus', 'created', 145, 'App\\Models\\User', 2, '[]', NULL, '2021-08-24 10:05:09', '2021-08-24 10:05:09'),
(50, 'default', 'created', 'App\\Models\\Skus', 'created', 146, 'App\\Models\\User', 2, '[]', NULL, '2021-08-24 10:05:09', '2021-08-24 10:05:09'),
(51, 'default', 'created', 'App\\Models\\Skus', 'created', 147, 'App\\Models\\User', 2, '[]', NULL, '2021-08-24 10:05:09', '2021-08-24 10:05:09'),
(52, 'default', 'created', 'App\\Models\\Skus', 'created', 148, 'App\\Models\\User', 2, '[]', NULL, '2021-08-24 10:05:09', '2021-08-24 10:05:09'),
(53, 'default', 'created', 'App\\Models\\Skus', 'created', 149, 'App\\Models\\User', 2, '[]', NULL, '2021-08-24 10:05:09', '2021-08-24 10:05:09'),
(54, 'default', 'created', 'App\\Models\\Skus', 'created', 150, 'App\\Models\\User', 2, '[]', NULL, '2021-08-24 10:05:09', '2021-08-24 10:05:09'),
(55, 'default', 'created', 'App\\Models\\Skus', 'created', 151, 'App\\Models\\User', 2, '[]', NULL, '2021-08-24 10:05:09', '2021-08-24 10:05:09'),
(56, 'default', 'created', 'App\\Models\\Skus', 'created', 152, 'App\\Models\\User', 2, '[]', NULL, '2021-08-24 10:05:09', '2021-08-24 10:05:09'),
(57, 'default', 'created', 'App\\Models\\Skus', 'created', 153, 'App\\Models\\User', 2, '[]', NULL, '2021-08-24 10:05:09', '2021-08-24 10:05:09'),
(58, 'default', 'created', 'App\\Models\\User', 'created', 65, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 01:41:44', '2021-08-25 01:41:44'),
(59, 'default', 'created', 'App\\Models\\Brands', 'created', 19, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 01:43:00', '2021-08-25 01:43:00'),
(60, 'default', 'created', 'App\\Models\\Brands_user', 'created', 154, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 01:44:12', '2021-08-25 01:44:12'),
(61, 'default', 'created', 'App\\Models\\Commercials', 'created', 34, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 01:47:10', '2021-08-25 01:47:10'),
(62, 'default', 'created', 'App\\Models\\Lots', 'created', 74, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 01:48:39', '2021-08-25 01:48:39'),
(63, 'default', 'updated', 'App\\Models\\Lots', 'updated', 74, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 01:48:39', '2021-08-25 01:48:39'),
(64, 'default', 'created', 'App\\Models\\Wrc', 'created', 53, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 01:50:11', '2021-08-25 01:50:11'),
(65, 'default', 'created', 'App\\Models\\Wrc', 'created', 54, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 01:50:45', '2021-08-25 01:50:45'),
(66, 'default', 'created', 'App\\Models\\Skus', 'created', 154, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 01:54:10', '2021-08-25 01:54:10'),
(67, 'default', 'updated', 'App\\Models\\Wrc', 'updated', 53, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 01:54:10', '2021-08-25 01:54:10'),
(68, 'default', 'created', 'App\\Models\\Skus', 'created', 155, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 01:54:10', '2021-08-25 01:54:10'),
(69, 'default', 'created', 'App\\Models\\Skus', 'created', 156, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 01:54:10', '2021-08-25 01:54:10'),
(70, 'default', 'created', 'App\\Models\\Skus', 'created', 157, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 01:54:10', '2021-08-25 01:54:10'),
(71, 'default', 'created', 'App\\Models\\Skus', 'created', 158, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 01:54:10', '2021-08-25 01:54:10'),
(72, 'default', 'created', 'App\\Models\\Skus', 'created', 159, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 01:54:10', '2021-08-25 01:54:10'),
(73, 'default', 'created', 'App\\Models\\Skus', 'created', 160, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 01:54:10', '2021-08-25 01:54:10'),
(74, 'default', 'created', 'App\\Models\\Skus', 'created', 161, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 01:54:10', '2021-08-25 01:54:10'),
(75, 'default', 'created', 'App\\Models\\Skus', 'created', 162, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 01:54:10', '2021-08-25 01:54:10'),
(76, 'default', 'created', 'App\\Models\\Skus', 'created', 163, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 01:54:10', '2021-08-25 01:54:10'),
(77, 'default', 'created', 'App\\Models\\Skus', 'created', 164, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 01:54:10', '2021-08-25 01:54:10'),
(78, 'default', 'created', 'App\\Models\\Skus', 'created', 165, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 01:54:10', '2021-08-25 01:54:10'),
(79, 'default', 'created', 'App\\Models\\Dayplan', 'created', 19, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:01:36', '2021-08-25 02:01:36'),
(80, 'default', 'created', 'App\\Models\\planDate', 'created', 102, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:14:32', '2021-08-25 02:14:32'),
(81, 'default', 'created', 'App\\Models\\planDate', 'created', 103, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:14:32', '2021-08-25 02:14:32'),
(82, 'default', 'created', 'App\\Models\\planDate', 'created', 104, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:14:32', '2021-08-25 02:14:32'),
(83, 'default', 'created', 'App\\Models\\planDate', 'created', 105, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:14:32', '2021-08-25 02:14:32'),
(84, 'default', 'created', 'App\\Models\\planDate', 'created', 106, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:14:32', '2021-08-25 02:14:32'),
(85, 'default', 'created', 'App\\Models\\planDate', 'created', 107, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:14:32', '2021-08-25 02:14:32'),
(86, 'default', 'created', 'App\\Models\\planDate', 'created', 108, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:14:32', '2021-08-25 02:14:32'),
(87, 'default', 'created', 'App\\Models\\planDate', 'created', 109, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:14:32', '2021-08-25 02:14:32'),
(88, 'default', 'created', 'App\\Models\\planDate', 'created', 110, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:14:32', '2021-08-25 02:14:32'),
(89, 'default', 'created', 'App\\Models\\planDate', 'created', 111, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:14:32', '2021-08-25 02:14:32'),
(90, 'default', 'created', 'App\\Models\\planDate', 'created', 112, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:14:32', '2021-08-25 02:14:32'),
(91, 'default', 'created', 'App\\Models\\planDate', 'created', 113, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:14:32', '2021-08-25 02:14:32'),
(92, 'default', 'updated', 'App\\Models\\planDate', 'updated', 102, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:16:18', '2021-08-25 02:16:18'),
(93, 'default', 'updated', 'App\\Models\\planDate', 'updated', 103, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:16:18', '2021-08-25 02:16:18'),
(94, 'default', 'updated', 'App\\Models\\planDate', 'updated', 104, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:16:18', '2021-08-25 02:16:18'),
(95, 'default', 'updated', 'App\\Models\\planDate', 'updated', 105, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:16:18', '2021-08-25 02:16:18'),
(96, 'default', 'updated', 'App\\Models\\Skus', 'updated', 158, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:19:02', '2021-08-25 02:19:02'),
(97, 'default', 'updated', 'App\\Models\\Skus', 'updated', 158, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:19:13', '2021-08-25 02:19:13'),
(98, 'default', 'updated', 'App\\Models\\Skus', 'updated', 159, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:19:54', '2021-08-25 02:19:54'),
(99, 'default', 'created', 'App\\Models\\uploadraw', 'created', 157, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:20:30', '2021-08-25 02:20:30'),
(100, 'default', 'created', 'App\\Models\\uploadraw', 'created', 158, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:20:33', '2021-08-25 02:20:33'),
(101, 'default', 'created', 'App\\Models\\uploadraw', 'created', 159, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:20:40', '2021-08-25 02:20:40'),
(102, 'default', 'created', 'App\\Models\\uploadraw', 'created', 160, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:20:40', '2021-08-25 02:20:40'),
(103, 'default', 'created', 'App\\Models\\uploadraw', 'created', 161, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:20:41', '2021-08-25 02:20:41'),
(104, 'default', 'created', 'App\\Models\\uploadraw', 'created', 162, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:20:41', '2021-08-25 02:20:41'),
(105, 'default', 'created', 'App\\Models\\uploadraw', 'created', 163, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:20:45', '2021-08-25 02:20:45'),
(106, 'default', 'created', 'App\\Models\\uploadraw', 'created', 164, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:20:45', '2021-08-25 02:20:45'),
(107, 'default', 'created', 'App\\Models\\uploadraw', 'created', 165, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:20:45', '2021-08-25 02:20:45'),
(108, 'default', 'updated', 'App\\Models\\Skus', 'updated', 160, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:21:29', '2021-08-25 02:21:29'),
(109, 'default', 'created', 'App\\Models\\uploadraw', 'created', 166, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:21:40', '2021-08-25 02:21:40'),
(110, 'default', 'created', 'App\\Models\\uploadraw', 'created', 167, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:21:40', '2021-08-25 02:21:40'),
(111, 'default', 'created', 'App\\Models\\uploadraw', 'created', 168, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:21:41', '2021-08-25 02:21:41'),
(112, 'default', 'created', 'App\\Models\\uploadraw', 'created', 169, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:21:41', '2021-08-25 02:21:41'),
(113, 'default', 'created', 'App\\Models\\uploadraw', 'created', 170, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:21:42', '2021-08-25 02:21:42'),
(114, 'default', 'created', 'App\\Models\\uploadraw', 'created', 171, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:21:42', '2021-08-25 02:21:42'),
(115, 'default', 'created', 'App\\Models\\uploadraw', 'created', 172, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:21:43', '2021-08-25 02:21:43'),
(116, 'default', 'created', 'App\\Models\\uploadraw', 'created', 173, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:21:43', '2021-08-25 02:21:43'),
(117, 'default', 'created', 'App\\Models\\uploadraw', 'created', 174, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:21:43', '2021-08-25 02:21:43'),
(118, 'default', 'created', 'App\\Models\\uploadraw', 'created', 175, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:21:43', '2021-08-25 02:21:43'),
(119, 'default', 'updated', 'App\\Models\\Skus', 'updated', 161, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:23:37', '2021-08-25 02:23:37'),
(120, 'default', 'created', 'App\\Models\\uploadraw', 'created', 176, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:23:56', '2021-08-25 02:23:56'),
(121, 'default', 'created', 'App\\Models\\uploadraw', 'created', 177, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:23:56', '2021-08-25 02:23:56'),
(122, 'default', 'created', 'App\\Models\\uploadraw', 'created', 178, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:23:57', '2021-08-25 02:23:57'),
(123, 'default', 'created', 'App\\Models\\uploadraw', 'created', 179, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:23:57', '2021-08-25 02:23:57'),
(124, 'default', 'created', 'App\\Models\\uploadraw', 'created', 180, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:23:57', '2021-08-25 02:23:57'),
(125, 'default', 'created', 'App\\Models\\uploadraw', 'created', 181, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:23:57', '2021-08-25 02:23:57'),
(126, 'default', 'created', 'App\\Models\\uploadraw', 'created', 182, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:23:58', '2021-08-25 02:23:58'),
(127, 'default', 'created', 'App\\Models\\uploadraw', 'created', 183, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:23:58', '2021-08-25 02:23:58'),
(128, 'default', 'created', 'App\\Models\\uploadraw', 'created', 184, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:23:58', '2021-08-25 02:23:58'),
(129, 'default', 'created', 'App\\Models\\uploadraw', 'created', 185, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:23:58', '2021-08-25 02:23:58'),
(130, 'default', 'updated', 'App\\Models\\Skus', 'updated', 162, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:25:43', '2021-08-25 02:25:43'),
(131, 'default', 'created', 'App\\Models\\uploadraw', 'created', 186, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:25:49', '2021-08-25 02:25:49'),
(132, 'default', 'created', 'App\\Models\\uploadraw', 'created', 187, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:25:49', '2021-08-25 02:25:49'),
(133, 'default', 'created', 'App\\Models\\uploadraw', 'created', 188, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:25:51', '2021-08-25 02:25:51'),
(134, 'default', 'updated', 'App\\Models\\Skus', 'updated', 154, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:26:16', '2021-08-25 02:26:16'),
(135, 'default', 'created', 'App\\Models\\uploadraw', 'created', 189, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:26:25', '2021-08-25 02:26:25'),
(136, 'default', 'created', 'App\\Models\\uploadraw', 'created', 190, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:26:25', '2021-08-25 02:26:25'),
(137, 'default', 'created', 'App\\Models\\uploadraw', 'created', 191, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:26:26', '2021-08-25 02:26:26'),
(138, 'default', 'created', 'App\\Models\\uploadraw', 'created', 192, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:26:26', '2021-08-25 02:26:26'),
(139, 'default', 'created', 'App\\Models\\uploadraw', 'created', 193, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:26:27', '2021-08-25 02:26:27'),
(140, 'default', 'created', 'App\\Models\\allocation', 'created', 154, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(141, 'default', 'created', 'App\\Models\\allocation', 'created', 155, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(142, 'default', 'created', 'App\\Models\\allocation', 'created', 156, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(143, 'default', 'created', 'App\\Models\\allocation', 'created', 157, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(144, 'default', 'created', 'App\\Models\\allocation', 'created', 158, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(145, 'default', 'created', 'App\\Models\\allocation', 'created', 159, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(146, 'default', 'created', 'App\\Models\\allocation', 'created', 160, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(147, 'default', 'created', 'App\\Models\\allocation', 'created', 161, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(148, 'default', 'created', 'App\\Models\\allocation', 'created', 162, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(149, 'default', 'created', 'App\\Models\\allocation', 'created', 163, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(150, 'default', 'created', 'App\\Models\\allocation', 'created', 164, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(151, 'default', 'created', 'App\\Models\\allocation', 'created', 165, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(152, 'default', 'created', 'App\\Models\\allocation', 'created', 166, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(153, 'default', 'created', 'App\\Models\\allocation', 'created', 167, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(154, 'default', 'created', 'App\\Models\\allocation', 'created', 168, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(155, 'default', 'created', 'App\\Models\\allocation', 'created', 169, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(156, 'default', 'created', 'App\\Models\\allocation', 'created', 170, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(157, 'default', 'created', 'App\\Models\\allocation', 'created', 171, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(158, 'default', 'created', 'App\\Models\\allocation', 'created', 172, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(159, 'default', 'created', 'App\\Models\\allocation', 'created', 173, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(160, 'default', 'created', 'App\\Models\\allocation', 'created', 174, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(161, 'default', 'created', 'App\\Models\\allocation', 'created', 175, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(162, 'default', 'created', 'App\\Models\\allocation', 'created', 176, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(163, 'default', 'created', 'App\\Models\\allocation', 'created', 177, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(164, 'default', 'created', 'App\\Models\\allocation', 'created', 178, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(165, 'default', 'created', 'App\\Models\\allocation', 'created', 179, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(166, 'default', 'created', 'App\\Models\\allocation', 'created', 180, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(167, 'default', 'created', 'App\\Models\\allocation', 'created', 181, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(168, 'default', 'created', 'App\\Models\\allocation', 'created', 182, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(169, 'default', 'created', 'App\\Models\\allocation', 'created', 183, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(170, 'default', 'created', 'App\\Models\\allocation', 'created', 184, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(171, 'default', 'created', 'App\\Models\\allocation', 'created', 185, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(172, 'default', 'created', 'App\\Models\\allocation', 'created', 186, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(173, 'default', 'created', 'App\\Models\\allocation', 'created', 187, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(174, 'default', 'created', 'App\\Models\\allocation', 'created', 188, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(175, 'default', 'created', 'App\\Models\\allocation', 'created', 189, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(176, 'default', 'created', 'App\\Models\\allocation', 'created', 190, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(177, 'default', 'updated', 'App\\Models\\User', 'updated', 2, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 02:41:50', '2021-08-25 02:41:50'),
(178, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 168, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 02:45:21', '2021-08-25 02:45:21'),
(179, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 169, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 02:45:21', '2021-08-25 02:45:21'),
(180, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 170, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 02:45:21', '2021-08-25 02:45:21'),
(181, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 171, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 02:45:21', '2021-08-25 02:45:21'),
(182, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 172, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 02:45:22', '2021-08-25 02:45:22'),
(183, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 173, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 02:45:47', '2021-08-25 02:45:47'),
(184, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 174, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 02:45:47', '2021-08-25 02:45:47'),
(185, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 175, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 02:45:48', '2021-08-25 02:45:48'),
(186, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 176, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 02:45:48', '2021-08-25 02:45:48'),
(187, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 177, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 02:45:49', '2021-08-25 02:45:49'),
(188, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 178, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 02:45:49', '2021-08-25 02:45:49'),
(189, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 179, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 02:45:50', '2021-08-25 02:45:50'),
(190, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 180, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 02:45:50', '2021-08-25 02:45:50'),
(191, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 181, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 02:45:51', '2021-08-25 02:45:51'),
(192, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 182, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 02:45:59', '2021-08-25 02:45:59'),
(193, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 183, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 02:45:59', '2021-08-25 02:45:59'),
(194, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 184, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 02:45:59', '2021-08-25 02:45:59'),
(195, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 185, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 02:45:59', '2021-08-25 02:45:59'),
(196, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 186, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 02:46:00', '2021-08-25 02:46:00'),
(197, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 187, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 02:46:00', '2021-08-25 02:46:00'),
(198, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 188, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 02:46:01', '2021-08-25 02:46:01'),
(199, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 189, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 02:46:01', '2021-08-25 02:46:01'),
(200, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 190, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 02:46:01', '2021-08-25 02:46:01'),
(201, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 191, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 02:46:01', '2021-08-25 02:46:01'),
(202, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 192, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 03:48:59', '2021-08-25 03:48:59'),
(203, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 193, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 03:48:59', '2021-08-25 03:48:59'),
(204, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 194, 'App\\Models\\User', 58, '[]', NULL, '2021-08-25 03:49:00', '2021-08-25 03:49:00'),
(205, 'default', 'created', 'App\\Models\\Commercials', 'created', 35, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 06:03:21', '2021-08-25 06:03:21'),
(206, 'default', 'created', 'App\\Models\\Commercials', 'created', 36, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 06:03:54', '2021-08-25 06:03:54'),
(207, 'default', 'created', 'App\\Models\\Lots', 'created', 75, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 06:11:27', '2021-08-25 06:11:27'),
(208, 'default', 'updated', 'App\\Models\\Lots', 'updated', 75, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 06:11:27', '2021-08-25 06:11:27'),
(209, 'default', 'created', 'App\\Models\\Wrc', 'created', 55, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 06:21:44', '2021-08-25 06:21:44'),
(210, 'default', 'created', 'App\\Models\\Wrc', 'created', 56, 'App\\Models\\User', 2, '[]', NULL, '2021-08-25 06:21:56', '2021-08-25 06:21:56'),
(211, 'default', 'updated', 'App\\Models\\User', 'updated', 2, 'App\\Models\\User', 2, '[]', NULL, '2021-08-27 02:06:38', '2021-08-27 02:06:38'),
(212, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 195, 'App\\Models\\User', 58, '[]', NULL, '2021-08-27 02:12:35', '2021-08-27 02:12:35'),
(213, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 196, 'App\\Models\\User', 58, '[]', NULL, '2021-08-27 02:12:36', '2021-08-27 02:12:36'),
(214, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 197, 'App\\Models\\User', 58, '[]', NULL, '2021-08-27 02:12:37', '2021-08-27 02:12:37'),
(215, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 198, 'App\\Models\\User', 58, '[]', NULL, '2021-08-27 02:12:37', '2021-08-27 02:12:37'),
(216, 'default', 'created', 'App\\Models\\editorSubmission', 'created', 199, 'App\\Models\\User', 58, '[]', NULL, '2021-08-27 02:12:38', '2021-08-27 02:12:38'),
(217, 'default', 'updated', 'App\\Models\\Skus', 'updated', 103, 'App\\Models\\User', 2, '[]', NULL, '2021-08-27 04:50:22', '2021-08-27 04:50:22'),
(218, 'default', 'created', 'App\\Models\\uploadraw', 'created', 194, 'App\\Models\\User', 2, '[]', NULL, '2021-08-27 04:50:31', '2021-08-27 04:50:31'),
(219, 'default', 'updated', 'App\\Models\\Skus', 'updated', 104, 'App\\Models\\User', 2, '[]', NULL, '2021-08-27 04:50:37', '2021-08-27 04:50:37'),
(220, 'default', 'created', 'App\\Models\\uploadraw', 'created', 195, 'App\\Models\\User', 2, '[]', NULL, '2021-08-27 04:50:45', '2021-08-27 04:50:45'),
(221, 'default', 'updated', 'App\\Models\\Skus', 'updated', 131, 'App\\Models\\User', 2, '[]', NULL, '2021-08-27 04:52:28', '2021-08-27 04:52:28'),
(222, 'default', 'created', 'App\\Models\\uploadraw', 'created', 196, 'App\\Models\\User', 2, '[]', NULL, '2021-08-27 04:52:36', '2021-08-27 04:52:36'),
(223, 'default', 'created', 'App\\Models\\uploadraw', 'created', 197, 'App\\Models\\User', 2, '[]', NULL, '2021-08-27 04:52:50', '2021-08-27 04:52:50'),
(224, 'default', 'updated', 'App\\Models\\Skus', 'updated', 118, 'App\\Models\\User', 2, '[]', NULL, '2021-08-27 04:53:03', '2021-08-27 04:53:03'),
(225, 'default', 'created', 'App\\Models\\uploadraw', 'created', 198, 'App\\Models\\User', 2, '[]', NULL, '2021-08-27 04:53:12', '2021-08-27 04:53:12'),
(226, 'default', 'updated', 'App\\Models\\Skus', 'updated', 119, 'App\\Models\\User', 2, '[]', NULL, '2021-08-27 04:53:16', '2021-08-27 04:53:16'),
(227, 'default', 'created', 'App\\Models\\uploadraw', 'created', 199, 'App\\Models\\User', 2, '[]', NULL, '2021-08-27 04:53:41', '2021-08-27 04:53:41'),
(228, 'default', 'created', 'App\\Models\\uploadraw', 'created', 200, 'App\\Models\\User', 2, '[]', NULL, '2021-08-27 04:53:41', '2021-08-27 04:53:41'),
(229, 'default', 'created', 'App\\Models\\uploadraw', 'created', 201, 'App\\Models\\User', 2, '[]', NULL, '2021-08-27 04:53:43', '2021-08-27 04:53:43'),
(230, 'default', 'created', 'App\\Models\\User', 'created', 66, 'App\\Models\\User', 2, '[]', NULL, '2021-08-28 08:29:31', '2021-08-28 08:29:31'),
(231, 'default', 'updated', 'App\\Models\\User', 'updated', 2, 'App\\Models\\User', 2, '[]', NULL, '2021-08-28 08:29:47', '2021-08-28 08:29:47');

-- --------------------------------------------------------

--
-- Table structure for table `allocation`
--

CREATE TABLE `allocation` (
  `id` int(10) UNSIGNED NOT NULL,
  `uploadraw_id` int(11) NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `allocation`
--

INSERT INTO `allocation` (`id`, `uploadraw_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 33, '6', '2021-06-28 21:05:45', '2021-06-28 21:05:45'),
(2, 25, '6', '2021-06-28 21:05:45', '2021-06-28 21:05:45'),
(3, 29, '6', '2021-06-28 21:05:45', '2021-06-28 21:05:45'),
(4, 21, '6', '2021-06-28 21:05:45', '2021-06-28 21:05:45'),
(5, 34, '6', '2021-06-28 21:05:45', '2021-06-28 21:05:45'),
(6, 26, '6', '2021-06-28 21:05:45', '2021-06-28 21:05:45'),
(7, 30, '6', '2021-06-28 21:05:45', '2021-06-28 21:05:45'),
(8, 22, '6', '2021-06-28 21:05:45', '2021-06-28 21:05:45'),
(9, 27, '6', '2021-06-28 21:05:45', '2021-06-28 21:05:45'),
(10, 31, '6', '2021-06-28 21:05:45', '2021-06-28 21:05:45'),
(11, 23, '6', '2021-06-28 21:05:45', '2021-06-28 21:05:45'),
(12, 19, '6', '2021-06-28 21:05:45', '2021-06-28 21:05:45'),
(13, 32, '6', '2021-06-28 21:05:45', '2021-06-28 21:05:45'),
(14, 24, '6', '2021-06-28 21:05:45', '2021-06-28 21:05:45'),
(15, 28, '6', '2021-06-28 21:05:45', '2021-06-28 21:05:45'),
(16, 20, '6', '2021-06-28 21:05:45', '2021-06-28 21:05:45'),
(17, 2, '6', '2021-06-28 21:06:00', '2021-06-28 21:06:00'),
(18, 49, '6', '2021-06-28 21:06:00', '2021-06-28 21:06:00'),
(19, 3, '6', '2021-06-28 21:06:00', '2021-06-28 21:06:00'),
(20, 47, '6', '2021-06-28 21:06:00', '2021-06-28 21:06:00'),
(21, 1, '6', '2021-06-28 21:06:00', '2021-06-28 21:06:00'),
(22, 48, '6', '2021-06-28 21:06:00', '2021-06-28 21:06:00'),
(23, 12, '6', '2021-06-28 21:06:00', '2021-06-28 21:06:00'),
(24, 7, '6', '2021-06-28 21:06:00', '2021-06-28 21:06:00'),
(25, 13, '6', '2021-06-28 21:06:00', '2021-06-28 21:06:00'),
(26, 8, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(27, 4, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(28, 10, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(29, 9, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(30, 5, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(31, 11, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(32, 6, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(33, 45, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(34, 46, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(35, 44, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(36, 53, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(37, 50, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(38, 54, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(39, 51, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(40, 52, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(41, 12, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(42, 7, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(43, 13, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(44, 8, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(45, 4, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(46, 10, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(47, 9, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(48, 5, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(49, 11, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(50, 6, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(51, 45, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(52, 46, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(53, 44, '6', '2021-06-28 21:06:01', '2021-06-28 21:06:01'),
(54, 16, '6', '2021-07-04 10:07:55', '2021-07-04 10:07:55'),
(55, 17, '6', '2021-07-04 10:07:55', '2021-07-04 10:07:55'),
(56, 18, '6', '2021-07-04 10:07:55', '2021-07-04 10:07:55'),
(57, 14, '6', '2021-07-04 10:07:55', '2021-07-04 10:07:55'),
(58, 15, '6', '2021-07-04 10:07:55', '2021-07-04 10:07:55'),
(59, 38, '6', '2021-07-04 10:08:10', '2021-07-04 10:08:10'),
(60, 43, '6', '2021-07-04 10:08:10', '2021-07-04 10:08:10'),
(61, 39, '6', '2021-07-04 10:08:10', '2021-07-04 10:08:10'),
(62, 35, '6', '2021-07-04 10:08:10', '2021-07-04 10:08:10'),
(63, 40, '6', '2021-07-04 10:08:10', '2021-07-04 10:08:10'),
(64, 36, '6', '2021-07-04 10:08:10', '2021-07-04 10:08:10'),
(65, 41, '6', '2021-07-04 10:08:10', '2021-07-04 10:08:10'),
(66, 37, '6', '2021-07-04 10:08:10', '2021-07-04 10:08:10'),
(67, 42, '6', '2021-07-04 10:08:10', '2021-07-04 10:08:10'),
(68, 71, '6', '2021-07-07 04:31:50', '2021-07-07 04:31:50'),
(69, 69, '6', '2021-07-07 04:31:50', '2021-07-07 04:31:50'),
(70, 72, '6', '2021-07-07 04:31:50', '2021-07-07 04:31:50'),
(71, 70, '6', '2021-07-07 04:31:50', '2021-07-07 04:31:50'),
(72, 68, '11', '2021-07-07 05:00:53', '2021-07-07 05:00:53'),
(73, 66, '11', '2021-07-07 05:00:53', '2021-07-07 05:00:53'),
(74, 67, '11', '2021-07-07 05:00:53', '2021-07-07 05:00:53'),
(75, 74, '6', '2021-07-09 01:58:58', '2021-07-09 01:58:58'),
(76, 75, '6', '2021-07-09 01:58:58', '2021-07-09 01:58:58'),
(77, 76, '6', '2021-07-09 01:58:58', '2021-07-09 01:58:58'),
(78, 78, '6', '2021-07-09 01:58:58', '2021-07-09 01:58:58'),
(79, 73, '6', '2021-07-09 01:58:58', '2021-07-09 01:58:58'),
(80, 77, '6', '2021-07-09 01:58:58', '2021-07-09 01:58:58'),
(81, 79, '6', '2021-07-09 01:58:58', '2021-07-09 01:58:58'),
(82, 80, '6', '2021-07-09 01:58:58', '2021-07-09 01:58:58'),
(83, 84, '6', '2021-07-09 01:58:58', '2021-07-09 01:58:58'),
(84, 81, '6', '2021-07-09 01:58:58', '2021-07-09 01:58:58'),
(85, 82, '6', '2021-07-09 01:58:58', '2021-07-09 01:58:58'),
(86, 83, '6', '2021-07-09 01:58:58', '2021-07-09 01:58:58'),
(87, 87, '6', '2021-07-19 00:43:38', '2021-07-19 00:43:38'),
(88, 88, '6', '2021-07-19 00:43:38', '2021-07-19 00:43:38'),
(89, 85, '6', '2021-07-19 00:43:38', '2021-07-19 00:43:38'),
(90, 86, '6', '2021-07-19 00:43:38', '2021-07-19 00:43:38'),
(91, 96, '58', '2021-07-27 01:31:18', '2021-07-27 01:31:18'),
(92, 89, '58', '2021-07-27 01:31:18', '2021-07-27 01:31:18'),
(93, 93, '58', '2021-07-27 01:31:18', '2021-07-27 01:31:18'),
(94, 97, '58', '2021-07-27 01:31:18', '2021-07-27 01:31:18'),
(95, 90, '58', '2021-07-27 01:31:18', '2021-07-27 01:31:18'),
(96, 94, '58', '2021-07-27 01:31:18', '2021-07-27 01:31:18'),
(97, 91, '58', '2021-07-27 01:31:18', '2021-07-27 01:31:18'),
(98, 95, '58', '2021-07-27 01:31:18', '2021-07-27 01:31:18'),
(99, 92, '58', '2021-07-27 01:31:18', '2021-07-27 01:31:18'),
(100, 103, '58', '2021-07-27 01:31:18', '2021-07-27 01:31:18'),
(101, 100, '58', '2021-07-27 01:31:41', '2021-07-27 01:31:41'),
(102, 101, '58', '2021-07-27 01:31:41', '2021-07-27 01:31:41'),
(103, 98, '58', '2021-07-27 01:31:41', '2021-07-27 01:31:41'),
(104, 102, '58', '2021-07-27 01:31:41', '2021-07-27 01:31:41'),
(105, 99, '58', '2021-07-27 01:31:41', '2021-07-27 01:31:41'),
(106, 109, '6', '2021-07-28 02:40:53', '2021-07-28 02:40:53'),
(107, 110, '6', '2021-07-28 02:40:53', '2021-07-28 02:40:53'),
(108, 111, '6', '2021-07-28 02:40:53', '2021-07-28 02:40:53'),
(109, 104, '6', '2021-07-28 02:40:53', '2021-07-28 02:40:53'),
(110, 112, '6', '2021-07-28 02:40:53', '2021-07-28 02:40:53'),
(111, 113, '6', '2021-07-28 02:40:53', '2021-07-28 02:40:53'),
(112, 105, '6', '2021-07-28 02:40:53', '2021-07-28 02:40:53'),
(113, 106, '6', '2021-07-28 02:40:53', '2021-07-28 02:40:53'),
(114, 107, '6', '2021-07-28 02:40:53', '2021-07-28 02:40:53'),
(115, 108, '6', '2021-07-28 02:40:53', '2021-07-28 02:40:53'),
(116, 117, '6', '2021-07-28 02:40:53', '2021-07-28 02:40:53'),
(117, 118, '6', '2021-07-28 02:40:53', '2021-07-28 02:40:53'),
(118, 114, '6', '2021-07-28 02:40:53', '2021-07-28 02:40:53'),
(119, 115, '6', '2021-07-28 02:40:53', '2021-07-28 02:40:53'),
(120, 116, '6', '2021-07-28 02:40:53', '2021-07-28 02:40:53'),
(121, 124, '6', '2021-07-28 02:41:25', '2021-07-28 02:41:25'),
(122, 125, '6', '2021-07-28 02:41:25', '2021-07-28 02:41:25'),
(123, 126, '6', '2021-07-28 02:41:25', '2021-07-28 02:41:25'),
(124, 119, '6', '2021-07-28 02:41:25', '2021-07-28 02:41:25'),
(125, 127, '6', '2021-07-28 02:41:25', '2021-07-28 02:41:25'),
(126, 120, '6', '2021-07-28 02:41:25', '2021-07-28 02:41:25'),
(127, 121, '6', '2021-07-28 02:41:25', '2021-07-28 02:41:25'),
(128, 122, '6', '2021-07-28 02:41:25', '2021-07-28 02:41:25'),
(129, 123, '6', '2021-07-28 02:41:25', '2021-07-28 02:41:25'),
(130, 132, '6', '2021-07-28 02:41:25', '2021-07-28 02:41:25'),
(131, 133, '6', '2021-07-28 02:41:25', '2021-07-28 02:41:25'),
(132, 134, '6', '2021-07-28 02:41:25', '2021-07-28 02:41:25'),
(133, 135, '6', '2021-07-28 02:41:25', '2021-07-28 02:41:25'),
(134, 128, '6', '2021-07-28 02:41:25', '2021-07-28 02:41:25'),
(135, 136, '6', '2021-07-28 02:41:25', '2021-07-28 02:41:25'),
(136, 129, '6', '2021-07-28 02:41:25', '2021-07-28 02:41:25'),
(137, 137, '6', '2021-07-28 02:41:25', '2021-07-28 02:41:25'),
(138, 130, '6', '2021-07-28 02:41:25', '2021-07-28 02:41:25'),
(139, 131, '6', '2021-07-28 02:41:25', '2021-07-28 02:41:25'),
(140, 143, '58', '2021-07-28 02:41:41', '2021-07-28 02:41:41'),
(141, 144, '58', '2021-07-28 02:41:41', '2021-07-28 02:41:41'),
(142, 145, '58', '2021-07-28 02:41:41', '2021-07-28 02:41:41'),
(143, 146, '58', '2021-07-28 02:41:41', '2021-07-28 02:41:41'),
(144, 141, '58', '2021-07-28 02:41:41', '2021-07-28 02:41:41'),
(145, 142, '58', '2021-07-28 02:41:41', '2021-07-28 02:41:41'),
(146, 138, '58', '2021-07-28 02:41:41', '2021-07-28 02:41:41'),
(147, 139, '58', '2021-07-28 02:41:41', '2021-07-28 02:41:41'),
(148, 140, '58', '2021-07-28 02:41:41', '2021-07-28 02:41:41'),
(149, 147, '6', '2021-08-10 00:49:27', '2021-08-10 00:49:27'),
(150, 148, '6', '2021-08-10 00:49:27', '2021-08-10 00:49:27'),
(151, 149, '6', '2021-08-10 00:49:27', '2021-08-10 00:49:27'),
(152, 150, '6', '2021-08-10 00:49:27', '2021-08-10 00:49:27'),
(153, 151, '6', '2021-08-10 00:49:27', '2021-08-10 00:49:27'),
(154, 157, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(155, 165, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(156, 158, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(157, 159, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(158, 160, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(159, 161, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(160, 162, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(161, 163, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(162, 164, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(163, 173, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(164, 166, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(165, 174, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(166, 167, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(167, 175, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(168, 168, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(169, 169, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(170, 170, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(171, 171, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(172, 172, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(173, 181, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(174, 182, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(175, 183, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(176, 176, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(177, 184, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(178, 177, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(179, 185, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(180, 178, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(181, 179, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(182, 180, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(183, 189, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(184, 190, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(185, 191, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(186, 192, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(187, 193, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(188, 186, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(189, 187, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14'),
(190, 188, '58', '2021-08-25 02:29:14', '2021-08-25 02:29:14');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `short_name`, `created_at`, `updated_at`) VALUES
(1, 'Google', 'GO', '2021-02-19 07:36:29', '2021-02-19 07:36:29'),
(2, 'Facebook', 'FB', '2021-02-19 07:36:40', '2021-02-19 07:36:40'),
(3, 'levis', 'LV', '2021-02-19 07:37:03', '2021-02-19 07:37:03'),
(4, 'Mnz', 'MN', '2021-02-21 05:57:35', '2021-02-21 05:57:35'),
(5, 'Odn', 'ON', '2021-02-22 03:46:58', '2021-02-22 03:46:58'),
(6, 'Pepe', 'PE', '2021-02-22 03:47:05', '2021-02-22 03:47:05'),
(8, 'Nike', 'NK', '2021-02-22 03:47:34', '2021-02-22 03:47:34'),
(9, 'Titan', 'TI', '2021-02-22 03:47:44', '2021-02-22 03:47:44'),
(10, 'bata', 'BA', '2021-02-22 03:47:47', '2021-02-22 03:47:47'),
(11, 'TATA', 'TA', '2021-02-22 03:47:56', '2021-02-22 03:47:56'),
(14, 'Twitter', 'Tw', '2021-02-26 08:08:03', '2021-02-26 08:08:03'),
(15, 'BLUE', 'BU', '2021-03-01 04:51:23', '2021-03-01 04:51:23'),
(16, 'Demo', 'DM', '2021-07-09 00:50:58', '2021-07-09 00:50:58'),
(18, 'sahil', 'SHA', '2021-08-09 05:37:12', '2021-08-09 05:37:12'),
(19, 'OpenDN', 'opdn', '2021-08-25 01:43:00', '2021-08-25 01:43:00');

-- --------------------------------------------------------

--
-- Table structure for table `brands_user`
--

CREATE TABLE `brands_user` (
  `id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `brand_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands_user`
--

INSERT INTO `brands_user` (`id`, `user_id`, `brand_id`, `created_at`, `updated_at`) VALUES
(13, 14, 2, '2021-02-21 03:55:29', '2021-02-21 03:55:29'),
(14, 14, 1, '2021-02-21 03:55:29', '2021-02-21 03:55:29'),
(17, 2, 4, '2021-02-21 05:58:04', '2021-02-21 05:58:04'),
(24, 15, 3, '2021-02-22 01:47:48', '2021-02-22 01:47:48'),
(25, 15, 1, '2021-02-22 01:47:48', '2021-02-22 01:47:48'),
(26, 13, 4, '2021-02-22 01:50:08', '2021-02-22 01:50:08'),
(27, 13, 3, '2021-02-22 01:50:08', '2021-02-22 01:50:08'),
(28, 13, 2, '2021-02-22 01:50:08', '2021-02-22 01:50:08'),
(34, 16, 4, '2021-02-22 03:45:39', '2021-02-22 03:45:39'),
(35, 16, 3, '2021-02-22 03:45:39', '2021-02-22 03:45:39'),
(36, 16, 2, '2021-02-22 03:45:39', '2021-02-22 03:45:39'),
(37, 16, 1, '2021-02-22 03:45:39', '2021-02-22 03:45:39'),
(38, 11, 11, '2021-02-22 03:48:21', '2021-02-22 03:48:21'),
(39, 11, 10, '2021-02-22 03:48:21', '2021-02-22 03:48:21'),
(40, 11, 9, '2021-02-22 03:48:21', '2021-02-22 03:48:21'),
(41, 10, 7, '2021-02-22 03:48:38', '2021-02-22 03:48:38'),
(42, 10, 6, '2021-02-22 03:48:38', '2021-02-22 03:48:38'),
(43, 9, 3, '2021-02-22 03:49:07', '2021-02-22 03:49:07'),
(44, 9, 2, '2021-02-22 03:49:07', '2021-02-22 03:49:07'),
(45, 7, 2, '2021-02-22 03:49:17', '2021-02-22 03:49:17'),
(46, 6, 3, '2021-02-22 03:52:58', '2021-02-22 03:52:58'),
(47, 5, 9, '2021-02-22 03:53:04', '2021-02-22 03:53:04'),
(51, 18, 7, '2021-02-24 09:01:34', '2021-02-24 09:01:34'),
(52, 18, 5, '2021-02-24 09:01:34', '2021-02-24 09:01:34'),
(77, 20, 12, '2021-02-25 04:34:04', '2021-02-25 04:34:04'),
(78, 20, 11, '2021-02-25 04:34:04', '2021-02-25 04:34:04'),
(79, 20, 9, '2021-02-25 04:34:04', '2021-02-25 04:34:04'),
(80, 20, 7, '2021-02-25 04:34:04', '2021-02-25 04:34:04'),
(81, 20, 5, '2021-02-25 04:34:04', '2021-02-25 04:34:04'),
(82, 20, 4, '2021-02-25 04:34:04', '2021-02-25 04:34:04'),
(83, 22, 12, '2021-02-25 04:45:45', '2021-02-25 04:45:45'),
(84, 22, 11, '2021-02-25 04:45:45', '2021-02-25 04:45:45'),
(85, 22, 9, '2021-02-25 04:45:45', '2021-02-25 04:45:45'),
(86, 22, 7, '2021-02-25 04:45:45', '2021-02-25 04:45:45'),
(87, 22, 6, '2021-02-25 04:45:45', '2021-02-25 04:45:45'),
(88, 22, 5, '2021-02-25 04:45:45', '2021-02-25 04:45:45'),
(89, 22, 4, '2021-02-25 04:45:45', '2021-02-25 04:45:45'),
(90, 22, 3, '2021-02-25 04:45:45', '2021-02-25 04:45:45'),
(91, 22, 2, '2021-02-25 04:45:45', '2021-02-25 04:45:45'),
(92, 22, 1, '2021-02-25 04:45:45', '2021-02-25 04:45:45'),
(115, 23, 12, '2021-02-27 05:25:37', '2021-02-27 05:25:37'),
(116, 23, 10, '2021-02-27 05:25:37', '2021-02-27 05:25:37'),
(117, 23, 5, '2021-02-27 05:25:37', '2021-02-27 05:25:37'),
(118, 23, 4, '2021-02-27 05:25:37', '2021-02-27 05:25:37'),
(119, 23, 3, '2021-02-27 05:25:37', '2021-02-27 05:25:37'),
(126, 26, 14, '2021-02-28 09:48:03', '2021-02-28 09:48:03'),
(127, 26, 12, '2021-02-28 09:48:03', '2021-02-28 09:48:03'),
(128, 26, 11, '2021-02-28 09:48:03', '2021-02-28 09:48:03'),
(137, 29, 11, '2021-03-04 02:11:30', '2021-03-04 02:11:30'),
(138, 29, 2, '2021-03-04 02:11:30', '2021-03-04 02:11:30'),
(139, 29, 1, '2021-03-04 02:11:30', '2021-03-04 02:11:30'),
(141, 51, 16, '2021-07-20 12:49:12', '2021-07-20 12:49:12'),
(142, 51, 15, '2021-07-20 12:49:12', '2021-07-20 12:49:12'),
(143, 51, 14, '2021-07-20 12:49:12', '2021-07-20 12:49:12'),
(150, 62, 16, '2021-08-05 12:36:29', '2021-08-05 12:36:29'),
(151, 62, 15, '2021-08-05 12:36:29', '2021-08-05 12:36:29'),
(152, 64, 16, '2021-08-09 04:16:58', '2021-08-09 04:16:58'),
(153, 64, 15, '2021-08-09 04:16:58', '2021-08-09 04:16:58'),
(154, 65, 19, '2021-08-25 01:44:12', '2021-08-25 01:44:12');

-- --------------------------------------------------------

--
-- Table structure for table `ch_favorites`
--

CREATE TABLE `ch_favorites` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `favorite_id` bigint(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ch_favorites`
--

INSERT INTO `ch_favorites` (`id`, `user_id`, `favorite_id`, `created_at`, `updated_at`) VALUES
(6197002, 2, 5, '2021-05-04 22:17:46', '2021-05-04 22:17:46'),
(35638540, 2, 26, '2021-05-05 00:09:50', '2021-05-05 00:09:50'),
(81796097, 2, 21, '2021-05-04 22:17:49', '2021-05-04 22:17:49'),
(95292517, 21, 2, '2021-05-04 23:55:32', '2021-05-04 23:55:32');

-- --------------------------------------------------------

--
-- Table structure for table `ch_messages`
--

CREATE TABLE `ch_messages` (
  `id` bigint(20) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_id` bigint(20) NOT NULL,
  `to_id` bigint(20) NOT NULL,
  `body` varchar(5000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ch_messages`
--

INSERT INTO `ch_messages` (`id`, `type`, `from_id`, `to_id`, `body`, `attachment`, `seen`, `created_at`, `updated_at`) VALUES
(1629994787, 'user', 6, 5, 'hi', NULL, 0, '2021-07-18 23:12:01', '2021-07-18 23:12:01'),
(1630652112, 'user', 21, 26, 'hi', NULL, 0, '2021-05-05 00:06:13', '2021-05-05 00:06:13'),
(1672975579, 'user', 2, 21, '', '97e566ad-d277-4731-9dca-48e7ff312247.jpg,A_Informative-1.jpg', 1, '2021-05-04 23:54:28', '2021-05-04 23:54:29'),
(1704596091, 'user', 2, 5, 'hi bud', NULL, 0, '2021-05-04 22:08:34', '2021-05-04 22:08:34'),
(1865745666, 'user', 2, 21, 'hello', NULL, 1, '2021-05-04 23:54:16', '2021-05-04 23:54:17'),
(1907259743, 'user', 2, 5, 'hi nishant', NULL, 0, '2021-05-04 22:07:23', '2021-05-04 22:07:23'),
(2223514160, 'user', 21, 2, 'hi', NULL, 1, '2021-05-04 23:55:26', '2021-05-04 23:59:52'),
(2276438123, 'user', 21, 2, 'hey', NULL, 1, '2021-05-04 22:09:47', '2021-05-04 22:09:47'),
(2354192901, 'user', 2, 21, '', 'a1851a98-7a9d-4fb9-8222-3cd386388ae7.gif,ODN-Website-GIF-V5-Mobile.gif', 1, '2021-05-04 22:14:33', '2021-05-04 22:14:50'),
(2369925980, 'user', 2, 2, 'hi', NULL, 1, '2021-05-04 22:17:20', '2021-05-04 22:17:20'),
(2373825610, 'user', 2, 26, 'hello', NULL, 0, '2021-05-05 00:05:33', '2021-05-05 00:05:33'),
(2391954519, 'user', 2, 21, 'whats up bro', NULL, 1, '2021-05-04 22:22:46', '2021-05-04 22:22:47'),
(2448407253, 'user', 2, 21, 'hello', NULL, 1, '2021-05-04 22:09:24', '2021-05-04 22:09:42'),
(2600789783, 'user', 2, 21, 'well see you in office', NULL, 1, '2021-05-04 22:11:55', '2021-05-04 22:12:23');

-- --------------------------------------------------------

--
-- Table structure for table `commercial`
--

CREATE TABLE `commercial` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `brand_id` int(10) UNSIGNED NOT NULL,
  `product_category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_of_shoot` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_of_clothing` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` text COLLATE utf8mb4_unicode_ci,
  `adaptation_1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adaptation_2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adaptation_3` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adaptation_4` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adaptation_5` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commercial_value_per_sku` int(11) NOT NULL,
  `comercial_c` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `commercial`
--

INSERT INTO `commercial` (`id`, `user_id`, `brand_id`, `product_category`, `type_of_shoot`, `type_of_clothing`, `gender`, `adaptation_1`, `adaptation_2`, `adaptation_3`, `adaptation_4`, `adaptation_5`, `commercial_value_per_sku`, `comercial_c`, `created_at`, `updated_at`) VALUES
(1, 20, 7, 'Option 2', 'product_shoot', 'option 5', 'option 3', 'option 3', 'option 1', 'option 4', 'option 4', '2', 348756, '', '2021-03-01 01:29:24', '2021-03-01 01:29:24'),
(2, 20, 7, 'Option 2', 'product_shoot', 'option 5', 'option 3', 'option 3', 'option 1', 'option 4', 'option 4', '2', 348756, '', '2021-03-01 01:38:44', '2021-03-01 01:38:44'),
(3, 15, 1, 'Men Casual - Table top', 'product_shoot', 'Topwear', 'Kidswear', 'Myntra', 'Myntra Premium', 'Flipkart Standard', 'Flipkart Standard', 'Flipkart Premium', 7329, '', '2021-03-01 03:03:20', '2021-03-01 03:03:20'),
(4, 23, 5, 'Bags/Wallets/Face Mask/Socks & Other Accessories', 'product_shoot', 'Topwear', 'Female', 'Flipkart MP', 'Brand Site', 'Flipkart MP', 'Brand Site', 'Flipkart Standard', 3456, '', '2021-03-01 03:24:35', '2021-03-01 03:24:35'),
(5, 24, 2, 'Bags/Wallets/Face Mask/Socks & Other Accessories', 'product_shoot', 'Mix', 'Female', 'Flipkart MP', 'Flipkart MP', 'Flipkart Standard', 'Flipkart MP', 'Flipkart Standard', 345, '', '2021-03-01 04:18:59', '2021-03-01 04:18:59'),
(6, 24, 8, 'Bags/Wallets/Face Mask/Socks & Other Accessories', 'product_shoot', 'Sets', 'Kidswear', 'Flipkart Premium', 'Flipkart MP', 'Flipkart Standard', 'Flipkart Standard', 'Flipkart Standard', 2354, '', '2021-03-01 04:20:00', '2021-03-01 04:20:00'),
(7, 23, 5, 'Bags/Wallets/Other Accessories (Face Masks)', 'product_shoot', 'Topwear', 'Male', 'Jabong', 'Nykaa', 'Nykaa Fashion', 'Nykaa Fashion', 'Nykaa Fashion', 554, '', '2021-03-01 04:20:37', '2021-03-01 04:20:37'),
(8, 27, 15, 'Athleisure', 'product_shoot', 'Topwear', 'Male', 'Flipkart Standard', 'Flipkart MP', 'Brand Site', 'Flipkart Premium', 'Flipkart Premium', 4354, '', '2021-03-01 04:57:06', '2021-03-01 04:57:06'),
(9, 27, 15, 'Dupattas', 'product_shoot', 'Mix', 'Female', 'Flipkart Premium', 'Flipkart Premium', 'Flipkart MP', 'Flipkart Premium', 'Flipkart Premium', 300, '', '2021-03-01 05:25:27', '2021-03-01 05:25:27'),
(10, 27, 15, 'Men Casual Model shoot', 'product_shoot', 'Bottomwear', 'Male', 'Brand Site', 'Amazon', 'Brand Site', 'Flipkart MP', 'Flipkart Premium', 3432, '', '2021-03-01 05:49:38', '2021-03-01 05:49:38'),
(11, 27, 15, 'Bags/Wallets/Face Mask/Socks & Other Accessories', 'product_shoot', 'Topwear', 'Female', 'Flipkart MP', 'Flipkart MP', 'Flipkart Premium', 'Flipkart MP', 'Flipkart MP', 8966, '', '2021-03-01 19:59:22', '2021-03-01 19:59:22'),
(12, 24, 8, 'Athleisure', 'product_shoot', 'Sets', 'Male', 'Flipkart Premium', 'Flipkart MP', 'Flipkart Premium', 'Flipkart MP', 'Flipkart Standard', 12123, '', '2021-03-01 20:25:33', '2021-03-01 20:25:33'),
(13, 27, 14, 'Athleisure', 'product_shoot', 'Mix', 'Female', 'Flipkart MP', 'Flipkart Standard', 'Flipkart Standard', 'Flipkart Premium', 'Flipkart Premium', 123, '', '2021-03-01 20:29:28', '2021-03-01 20:29:28'),
(14, 27, 14, 'Bags/Wallets/Face Mask/Socks & Other Accessories', 'product_shoot', 'Mix', 'Female', 'Flipkart Standard', 'Flipkart Standard', 'Flipkart Standard', 'Flipkart Standard', 'Flipkart Premium', 123, '', '2021-03-01 20:35:33', '2021-03-01 20:35:33'),
(15, 27, 14, 'Bags/Wallets/Other Accessories (Face Masks)', 'product_shoot', 'Topwear', 'Female', 'Flipkart Standard', 'Flipkart MP', 'Flipkart Standard', 'Flipkart MP', 'Flipkart Standard', 1234, '', '2021-03-01 20:37:24', '2021-03-01 20:37:24'),
(16, 29, 1, 'Athleisure', 'product_shoot', 'Topwear', 'Male', 'Flipkart Standard', 'Flipkart Premium', 'Flipkart MP', 'Brand Site', 'Myntra', 987, '', '2021-03-02 07:06:37', '2021-03-02 07:06:37'),
(17, 29, 1, 'Bags/Wallets/Face Mask/Socks & Other Accessories', 'product_shoot', 'Mix', 'Kidswear', 'Flipkart Standard', 'Flipkart Premium', 'Nykaa', 'Hopscotch', 'Nykaa Fashion', 899, '', '2021-03-02 07:07:35', '2021-03-02 07:07:35'),
(18, 29, 11, 'Athleisure', 'product_shoot', 'Topwear', 'Kidswear', 'Flipkart Premium', 'Flipkart Standard', 'Flipkart Premium', 'Flipkart Premium', 'Flipkart Premium', 675, '', '2021-03-04 02:13:30', '2021-03-04 02:13:30'),
(19, 29, 11, 'Bags/Wallets/Other Accessories (Face Masks)', 'product_shoot', 'Mix', 'Female', 'Myntra Premium', 'Myntra', 'Limeroad', 'Jabong', 'Flipkart Standard', 457, '', '2021-03-04 02:16:01', '2021-03-04 02:16:01'),
(20, 29, 1, 'Bags/Wallets/Other Accessories (Face Masks)', 'product_shoot', 'Topwear', 'Female', 'Flipkart Standard', 'Flipkart Standard', 'Jabong', 'Brand Site', 'Flipkart Standard', 7897, '', '2021-03-08 21:42:29', '2021-03-08 21:42:29'),
(21, 29, 1, 'Athleisure', 'catalog_videos', 'Sets', 'Kidswear', 'Jio Mart', 'Jio Mart', 'Nykaa', 'Big Basket', 'Hopscotch', 899, '', '2021-03-09 19:51:33', '2021-03-09 19:51:33'),
(22, 23, 10, 'Athleisure', 'product_shoot', 'Bottomwear', 'Female', 'Brand Site', 'Flipkart MP', 'Jabong', 'Jabong', 'Flipkart MP', 98743, NULL, '2021-03-18 06:21:04', '2021-03-18 06:21:04'),
(23, 23, 10, 'Bags/Wallets/Face Mask/Socks & Other Accessories', 'table_top_shoot', 'Topwear', 'Female', 'Flipkart Standard', 'Flipkart Standard', 'Flipkart MP', 'Paytm', 'Jabong', 2344, NULL, '2021-03-31 04:55:09', '2021-03-31 04:55:09'),
(24, 29, 2, 'Athleisure', 'premium_shoot', 'Sets', 'Female', 'Flipkart MP', 'Jabong', 'Brand Site', 'Flipkart Premium', 'Flipkart MP', 1234, NULL, '2021-03-31 05:00:19', '2021-03-31 05:00:19'),
(25, 29, 2, 'Bags/Wallets/Face Mask/Socks & Other Accessories', 'premium_shoot', 'Topwear', 'Female', 'Flipkart Premium', 'Jabong', 'Jabong', 'Myntra', 'Amazon', 334, NULL, '2021-03-31 05:01:53', '2021-03-31 05:01:53'),
(26, 23, 4, 'Athleisure', 'extra_mood_shot', 'Topwear', 'Male', 'Limeroad', 'Myntra Premium', 'Flipkart Standard', 'Myntra', 'Myntra', 1234, NULL, '2021-03-31 05:09:43', '2021-03-31 05:09:43'),
(27, 23, 4, 'Bags/Wallets/Face Mask/Socks & Other Accessories', 'hanger_shoot', 'Mix', 'Kidswear', 'Limeroad', 'Flipkart Standard', 'Limeroad', 'Jabong', 'Flipkart Standard', 123, NULL, '2021-03-31 05:22:48', '2021-03-31 05:22:48'),
(28, 23, 4, 'Bags/Wallets/Face Mask/Socks & Other Accessories', 'hanger_shoot', 'Topwear', 'Kidswear', 'Flipkart Premium', 'Jabong', 'Flipkart Standard', 'Flipkart Premium', 'Flipkart Premium', 232, NULL, '2021-03-31 06:47:31', '2021-03-31 06:47:31'),
(29, 23, 4, 'Bags/Wallets/Face Mask/Socks & Other Accessories', 'product_shoot_with_model', 'Mix', 'Female', 'Jabong', 'Flipkart Standard', 'Flipkart MP', 'Myntra', 'Jabong', 3455, NULL, '2021-03-31 07:02:22', '2021-03-31 07:02:22'),
(30, 23, 4, 'Bags/Wallets/Other Accessories', 'premium_shoot', 'Topwear', 'Kidswear', 'Flipkart MP', 'Flipkart MP', 'Flipkart MP', 'Flipkart MP', 'Amazon', 343, NULL, '2021-03-31 07:03:06', '2021-03-31 07:03:06'),
(31, 51, 16, 'food_products', 'product_shoot', 'Sets', 'Male', 'brand_site', 'amazon', 'myntra_premium', 'ajio', 'first_cry', 499, NULL, '2021-07-09 00:58:28', '2021-07-09 00:58:28'),
(32, 51, 16, 'bags/wallets/other_accessories_(socks)', 'product_shoot_with_model', 'Topwear', 'Male', 'brand_site', 'amazon', 'myntra', 'myntra', 'ajio', 500, NULL, '2021-07-09 00:59:59', '2021-07-09 00:59:59'),
(33, 51, 16, 'Bags/Wallets/Facemask/Socks & Other Accessories', 'product_shoot_with_model', 'Topwear', 'Female', 'Myntra', 'Amazon', 'Myntra', 'Amazon', 'Amazon', 664, NULL, '2021-08-09 05:40:18', '2021-08-09 05:40:18'),
(34, 65, 19, 'Dupattas', 'premium_shoot', 'Topwear', 'Female', 'Amazon', 'Flipkart', 'Myntra', 'Myntra_premium', 'Ajio', 567, NULL, '2021-08-25 01:47:10', '2021-08-25 01:47:10'),
(35, 65, 19, 'Bags/Wallets/Facemask/Socks & Other Accessories', 'premium_shoot', 'Sets', 'Female', 'Nykaa', 'Flipkart', 'Myntra', 'Brand Site', 'Myntra', 563, NULL, '2021-08-25 06:03:20', '2021-08-25 06:03:20'),
(36, 65, 19, 'Bags/Wallets/Facemask/Socks & Other Accessories', 'product_shoot_with_model', 'Bottomwear', 'Female', 'Amazon', 'Myntra_premium', 'Myntra', 'Brand Site', 'Ajio', 5667, NULL, '2021-08-25 06:03:54', '2021-08-25 06:03:54');

-- --------------------------------------------------------

--
-- Table structure for table `dayplan`
--

CREATE TABLE `dayplan` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `studio` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photographer` varchar(110) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stylist` varchar(110) COLLATE utf8mb4_unicode_ci NOT NULL,
  `makeupartist` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rawqc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `agency` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `assistant` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dayplan`
--

INSERT INTO `dayplan` (`id`, `date`, `studio`, `photographer`, `stylist`, `makeupartist`, `rawqc`, `model`, `agency`, `assistant`, `created_at`, `updated_at`) VALUES
(1, '2021-03-08', 'Mukta Studio', 'safdc', 'esr', 'dsfg', 'asdffg', 'fdghh', 'fgh', 'fghrt', '2021-03-27 03:29:12', '2021-03-27 03:29:12'),
(2, '2021-03-03', 'Mukta Studio', 'sdf', 'fdvc', 'df', 'sdf', 'dvxc', 'dv', 'fvc', '2021-03-27 03:34:39', '2021-03-27 03:34:39'),
(3, '2021-03-03', 'Mukta Studio', 'sdf', 'fdvc', 'df', 'sdf', 'dvxc', 'dv', 'fvc', '2021-03-27 03:34:56', '2021-03-27 03:34:56'),
(4, '2021-03-03', 'Mukta Studio', 'sdf', 'fdvc', 'df', 'sdf', 'dvxc', 'dv', 'fvc', '2021-03-27 03:43:54', '2021-03-27 03:43:54'),
(5, '2021-03-03', 'Mukta Studio', 'sdf', 'fdvc', 'df', 'sdf', 'dvxc', 'dv', 'fvc', '2021-03-27 03:44:15', '2021-03-27 03:44:15'),
(6, '2021-03-03', 'Mukta Studio', 'sdf', 'fdvc', 'df', 'sdf', 'dvxc', 'dv', 'fvc', '2021-03-27 03:44:53', '2021-03-27 03:44:53'),
(7, '2021-03-02', 'Yashraj Studio', 'hfg', 'nb', 'nbv', 'yh', ',mnvb', 'hgf', 'bnvc', '2021-03-27 03:51:16', '2021-03-27 03:51:16'),
(8, '2021-03-09', 'Others', 'jhfv', 'jghfh', 'nj6', 'oiuytr', 'hjkv', 'dfh5r', ',jhgc', '2021-03-27 03:57:17', '2021-03-27 03:57:17'),
(9, '2021-03-24', 'Yashraj Studio', 'sadfsdf', 'dsfsdgdf', 'fdgfbcbvfctg', 'rtrgftyh', 'tfdhghg', 'sdgf', 'sdfhgc', '2021-03-27 04:26:01', '2021-03-27 04:26:01'),
(10, '2021-03-24', 'RK Studio', 'ihvdfn', 'oijhwfd', 'ndcbdfr', 'dsfhuerf', 'eafdn', 'dscx', 'dvxc', '2021-03-27 04:37:50', '2021-03-27 04:37:50'),
(11, '2021-03-16', 'Yashraj Studio', 'photo', 'friend', 'from', 'uytr', 'jhes', 'hyt', 'fgjyh', '2021-03-27 07:45:19', '2021-03-27 07:45:19'),
(12, '2021-03-17', 'Yashraj Studio', 'the', 'grow', 'bsjdnfxc', 'ejknsdfvn', 'jnksdf', 'jisdfjbv', 'jiohjsdfc', '2021-03-27 08:00:44', '2021-03-27 08:00:44'),
(13, '2021-03-17', 'Mukta Studio', 'sahil', 'sahil', 'sahil', 'sahil', 'sahil', 'sahil', 'sahil', '2021-03-30 03:10:57', '2021-03-30 03:10:57'),
(14, '2021-03-30', 'Yashraj Studio', 'dty', 'tgd', 'ytyh', 'iygh', 'tegh', 'yhgf', 'yhndv', '2021-04-04 06:37:34', '2021-04-04 06:37:34'),
(15, '2021-04-29', 'Others', 'karan', 'minal', 'nina', 'rakesh', 'sahil', 'ODN', 'ajay', '2021-04-15 06:01:14', '2021-04-15 06:01:14'),
(18, '2021-08-06', 'Yashraj Studio', 'bcv', 'nbvcv', 'jhg', 'ytrd', 'hjgtyr', 'ngcf', 'hgf', '2021-08-05 10:39:20', '2021-08-05 10:39:20'),
(19, '2021-08-26', 'Delhi Studio 1', 'anand', 'Sneha', 'ravi', 'jaun', 'NM', 'jn', 'Kamal', '2021-08-25 02:01:36', '2021-08-25 02:01:36');

-- --------------------------------------------------------

--
-- Table structure for table `editor_submission`
--

CREATE TABLE `editor_submission` (
  `id` int(10) UNSIGNED NOT NULL,
  `sku_id` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qc` enum('0','1','2') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '0 => Rejected, 1 => Approved, 2=> Link Generated',
  `adaptation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `editor_submission`
--

INSERT INTO `editor_submission` (`id`, `sku_id`, `filename`, `qc`, `adaptation`, `created_at`, `updated_at`) VALUES
(1, 98, '76768f-r10_1.png', '1', 'Flipkart Standard', '2021-07-04 10:42:25', '2021-07-04 10:42:25'),
(2, 84, '76768f-r6_7.jpeg', '1', 'Limeroad', '2021-07-04 10:52:48', '2021-07-04 10:52:48'),
(3, 88, '76768f-r10_1.png', '1', 'Limeroad', '2021-07-04 10:52:54', '2021-07-04 10:52:54'),
(5, 22, '76768f-r6_7.jpeg', '1', 'Flipkart MP', '2021-07-04 11:19:06', '2021-07-04 11:19:06'),
(6, 26, '76768f-r10_2.png', '1', 'Flipkart MP', '2021-07-04 11:19:13', '2021-07-04 11:19:13'),
(7, 26, '76768f-r10_1.png', '1', 'Flipkart MP', '2021-07-04 11:40:03', '2021-07-04 11:40:03'),
(8, 98, '76768f-r10_1.png', '1', 'Paytm', '2021-07-05 01:23:05', '2021-07-05 01:23:05'),
(9, 94, '76768f-r6_7.jpeg', '1', 'Paytm', '2021-07-05 01:23:10', '2021-07-05 01:23:10'),
(10, 98, '76768f-r10_1.png', '1', 'Flipkart MP', '2021-07-05 03:10:31', '2021-07-05 03:10:31'),
(11, 98, '76768f-r10_1.png', '1', 'Flipkart MP', '2021-07-05 03:18:54', '2021-07-05 03:18:54'),
(12, 94, '76768f-r6_7.jpeg', '1', 'Flipkart MP', '2021-07-05 03:18:54', '2021-07-05 03:18:54'),
(13, 98, '76768f-r10_1.png', '1', 'Flipkart MP', '2021-07-05 03:20:07', '2021-07-05 03:20:07'),
(14, 94, '76768f-r6_7.jpeg', '1', 'Flipkart MP', '2021-07-05 03:20:07', '2021-07-05 03:20:07'),
(15, 98, '76768f-r10_1.png', '1', 'Flipkart MP', '2021-07-05 03:20:21', '2021-07-05 03:20:21'),
(16, 94, '76768f-r6_7.jpeg', '1', 'Flipkart MP', '2021-07-05 03:20:21', '2021-07-05 03:20:21'),
(17, 98, '76768f-r10_1.png', '1', 'Flipkart MP', '2021-07-05 03:21:45', '2021-07-05 03:21:45'),
(18, 94, '76768f-r6_7.jpeg', '1', 'Flipkart MP', '2021-07-05 03:21:45', '2021-07-05 03:21:45'),
(19, 88, '76768f-r10_1.png', '1', 'Jabong', '2021-07-05 03:30:38', '2021-07-05 03:30:38'),
(20, 88, '76768f-r10_1.png', '1', 'Jabong', '2021-07-05 03:31:14', '2021-07-05 03:31:14'),
(21, 88, '76768f-r10_1.png', '1', 'Jabong', '2021-07-05 03:31:46', '2021-07-05 03:31:46'),
(22, 84, '76768f-r6_7.jpeg', '1', 'Jabong', '2021-07-05 03:32:00', '2021-07-05 03:32:00'),
(23, 88, '76768f-r10_1.png', '1', 'Jabong', '2021-07-05 03:32:00', '2021-07-05 03:32:00'),
(24, 84, '76768f-r6_7.jpeg', '1', 'Jabong', '2021-07-05 03:32:49', '2021-07-05 03:32:49'),
(25, 88, '76768f-r10_1.png', '1', 'Jabong', '2021-07-05 03:33:50', '2021-07-05 03:33:50'),
(26, 84, '76768f-r6_7.jpeg', '1', 'Jabong', '2021-07-05 03:33:50', '2021-07-05 03:33:50'),
(27, 84, '76768f-r6_1.jpeg', '1', 'Jabong', '2021-07-05 03:33:53', '2021-07-05 03:33:53'),
(28, 84, '76768f-r6_3.jpeg', '1', 'Jabong', '2021-07-05 03:33:53', '2021-07-05 03:33:53'),
(29, 83, '76768f-r5_7.jpeg', '1', 'Jabong', '2021-07-05 03:33:55', '2021-07-05 03:33:55'),
(30, 88, '76768f-r10_1.png', '1', 'Flipkart Standard', '2021-07-06 03:20:23', '2021-07-06 03:20:23'),
(31, 84, '76768f-r6_7.jpeg', '1', 'Flipkart Standard', '2021-07-06 03:20:23', '2021-07-06 03:20:23'),
(32, 84, '76768f-r6_1.jpeg', '1', 'Flipkart Standard', '2021-07-06 03:20:24', '2021-07-06 03:20:24'),
(33, 84, '76768f-r6_3.jpeg', '1', 'Flipkart Standard', '2021-07-06 03:20:24', '2021-07-06 03:20:24'),
(34, 83, '76768f-r5_7.jpeg', '1', 'Flipkart Standard', '2021-07-06 03:20:24', '2021-07-06 03:20:24'),
(35, 115, 'Demo1-3_1.jpeg', '1', 'brand_site', '2021-07-09 02:06:57', '2021-07-09 02:06:57'),
(36, 115, 'Demo1-3_2.jpeg', '1', 'brand_site', '2021-07-09 02:06:57', '2021-07-09 02:06:57'),
(37, 115, 'Demo1-3_3.jpeg', '1', 'brand_site', '2021-07-09 02:06:58', '2021-07-09 02:06:58'),
(38, 115, 'Demo1-3_4.jpeg', '1', 'brand_site', '2021-07-09 02:06:58', '2021-07-09 02:06:58'),
(39, 116, 'Demo1-4_1.jpeg', '1', 'brand_site', '2021-07-09 02:08:33', '2021-07-09 02:08:33'),
(40, 116, 'Demo1-4_2.jpeg', '1', 'brand_site', '2021-07-09 02:08:33', '2021-07-09 02:08:33'),
(41, 116, 'Demo1-4_3.jpeg', '1', 'brand_site', '2021-07-09 02:08:35', '2021-07-09 02:08:35'),
(42, 116, 'Demo1-4_4.jpeg', '1', 'brand_site', '2021-07-09 02:08:35', '2021-07-09 02:08:35'),
(43, 116, 'Demo1-4_5.jpeg', '1', 'brand_site', '2021-07-09 02:08:36', '2021-07-09 02:08:36'),
(44, 116, 'Demo1-4_1.jpeg', '1', 'amazon', '2021-07-09 02:12:51', '2021-07-09 02:12:51'),
(45, 116, 'Demo1-4_2.jpeg', '1', 'amazon', '2021-07-09 02:12:51', '2021-07-09 02:12:51'),
(46, 116, 'Demo1-4_3.jpeg', '1', 'amazon', '2021-07-09 02:12:52', '2021-07-09 02:12:52'),
(47, 116, 'Demo1-4_4.jpeg', '1', 'amazon', '2021-07-09 02:12:52', '2021-07-09 02:12:52'),
(48, 116, 'Demo1-4_5.jpeg', '1', 'amazon', '2021-07-09 02:12:54', '2021-07-09 02:12:54'),
(49, 26, '76768f-r10_1.png', '1', 'Brand Site', '2021-07-17 12:32:41', '2021-07-17 12:32:41'),
(50, 22, '76768f-r6_7.jpeg', '1', 'Brand Site', '2021-07-17 12:32:41', '2021-07-17 12:32:41'),
(51, 22, '76768f-r6_1.jpeg', '1', 'Brand Site', '2021-07-17 12:32:41', '2021-07-17 12:32:41'),
(52, 22, '76768f-r6_3.jpeg', '1', 'Brand Site', '2021-07-17 12:32:41', '2021-07-17 12:32:41'),
(53, 21, '76768f-r5_7.jpeg', '1', 'Brand Site', '2021-07-17 12:32:42', '2021-07-17 12:32:42'),
(54, 26, '76768f-r10_1.png', '1', 'Flipkart MP', '2021-07-17 12:34:57', '2021-07-17 12:34:57'),
(55, 22, '76768f-r6_7.jpeg', '1', 'Flipkart MP', '2021-07-17 12:34:57', '2021-07-17 12:34:57'),
(56, 22, '76768f-r6_1.jpeg', '1', 'Flipkart MP', '2021-07-17 12:34:58', '2021-07-17 12:34:58'),
(57, 22, '76768f-r6_3.jpeg', '1', 'Flipkart MP', '2021-07-17 12:34:58', '2021-07-17 12:34:58'),
(58, 26, '76768f-r10_1.png', '1', 'Flipkart MP', '2021-07-17 12:35:00', '2021-07-17 12:35:00'),
(59, 22, '76768f-r6_7.jpeg', '1', 'Flipkart MP', '2021-07-17 12:35:00', '2021-07-17 12:35:00'),
(60, 22, '76768f-r6_1.jpeg', '1', 'Flipkart MP', '2021-07-17 12:35:01', '2021-07-17 12:35:01'),
(61, 22, '76768f-r6_3.jpeg', '1', 'Flipkart MP', '2021-07-17 12:35:01', '2021-07-17 12:35:01'),
(62, 115, 'Demo1-3_1.jpeg', '1', 'brand_site', '2021-07-19 00:52:13', '2021-07-19 00:52:13'),
(63, 115, 'Demo1-3_2.jpeg', '1', 'brand_site', '2021-07-19 00:52:13', '2021-07-19 00:52:13'),
(64, 115, 'Demo1-3_3.jpeg', '1', 'brand_site', '2021-07-19 00:52:14', '2021-07-19 00:52:14'),
(65, 115, 'Demo1-3_6.jpg', '1', 'brand_site', '2021-07-19 00:52:14', '2021-07-19 00:52:14'),
(66, 115, 'Demo1-3_7.jpeg', '1', 'brand_site', '2021-07-19 00:52:15', '2021-07-19 00:52:15'),
(67, 116, 'Demo1-4_1.jpeg', '1', 'brand_site', '2021-07-19 00:52:32', '2021-07-19 00:52:32'),
(68, 116, 'Demo1-4_2.jpeg', '1', 'brand_site', '2021-07-19 00:52:32', '2021-07-19 00:52:32'),
(69, 116, 'Demo1-4_3.jpeg', '1', 'brand_site', '2021-07-19 00:52:33', '2021-07-19 00:52:33'),
(70, 116, 'Demo1-4_4.jpeg', '1', 'brand_site', '2021-07-19 00:52:33', '2021-07-19 00:52:33'),
(71, 116, 'Demo1-4_5.jpeg', '1', 'brand_site', '2021-07-19 00:52:34', '2021-07-19 00:52:34'),
(72, 117, 'Demo1-5_1.jpeg', '1', 'brand_site', '2021-07-19 00:52:45', '2021-07-19 00:52:45'),
(73, 117, 'Demo1-5_2.jpeg', '1', 'brand_site', '2021-07-19 00:52:45', '2021-07-19 00:52:45'),
(74, 117, 'Demo1-5_3.jpeg', '1', 'brand_site', '2021-07-19 00:52:46', '2021-07-19 00:52:46'),
(75, 117, 'Demo1-5_4.jpeg', '1', 'brand_site', '2021-07-19 00:52:46', '2021-07-19 00:52:46'),
(76, 21, '76768f-r5_1.png', '1', 'Brand Site', '2021-07-27 01:42:16', '2021-07-27 01:42:16'),
(77, 21, '76768f-r5_2.jpeg', '1', 'Brand Site', '2021-07-27 01:42:16', '2021-07-27 01:42:16'),
(78, 21, '76768f-r5_3.jpeg', '1', 'Brand Site', '2021-07-27 01:42:17', '2021-07-27 01:42:17'),
(79, 21, '76768f-r5_4.jpeg', '1', 'Brand Site', '2021-07-27 01:42:17', '2021-07-27 01:42:17'),
(80, 21, '76768f-r5_5.jpeg', '1', 'Brand Site', '2021-07-27 01:42:18', '2021-07-27 01:42:18'),
(81, 52, '76768f-r14_1.jpg', '1', 'Brand Site', '2021-07-27 01:42:38', '2021-07-27 01:42:38'),
(82, 52, '76768f-r14_2.jpg', '1', 'Brand Site', '2021-07-27 01:42:38', '2021-07-27 01:42:38'),
(83, 52, '76768f-r14_3.jpg', '1', 'Brand Site', '2021-07-27 01:42:40', '2021-07-27 01:42:40'),
(84, 52, '76768f-r14_4.jpeg', '1', 'Brand Site', '2021-07-27 01:42:40', '2021-07-27 01:42:40'),
(85, 52, '76768f-r14_5.jpg', '1', 'Brand Site', '2021-07-27 01:42:41', '2021-07-27 01:42:41'),
(86, 52, '76768f-r14_6.jpg', '1', 'Brand Site', '2021-07-27 01:42:41', '2021-07-27 01:42:41'),
(87, 52, '76768f-r14_7.jpg', '1', 'Brand Site', '2021-07-27 01:42:42', '2021-07-27 01:42:42'),
(88, 52, '76768f-r14_8.jpg', '1', 'Brand Site', '2021-07-27 01:42:42', '2021-07-27 01:42:42'),
(89, 52, '76768f-r14_9.jpeg', '1', 'Brand Site', '2021-07-27 01:42:43', '2021-07-27 01:42:43'),
(90, 52, '76768f-r14_10.png', '1', 'Brand Site', '2021-07-27 01:42:43', '2021-07-27 01:42:43'),
(91, 52, '76768f-r14_2.jpg', '1', 'Jabong', '2021-07-27 02:00:13', '2021-07-27 02:00:13'),
(92, 52, '76768f-r14_3.jpg', '1', 'Jabong', '2021-07-27 02:00:15', '2021-07-27 02:00:15'),
(93, 52, '76768f-r14_4.jpeg', '1', 'Jabong', '2021-07-27 02:00:15', '2021-07-27 02:00:15'),
(94, 52, '76768f-r14_5.jpg', '1', 'Jabong', '2021-07-27 02:00:17', '2021-07-27 02:00:17'),
(95, 52, '76768f-r14_6.jpg', '1', 'Jabong', '2021-07-27 02:00:17', '2021-07-27 02:00:17'),
(96, 52, '76768f-r14_7.jpg', '1', 'Jabong', '2021-07-27 02:00:17', '2021-07-27 02:00:17'),
(97, 52, '76768f-r14_8.jpg', '1', 'Jabong', '2021-07-27 02:00:17', '2021-07-27 02:00:17'),
(98, 52, '76768f-r14_9.jpeg', '1', 'Jabong', '2021-07-27 02:00:18', '2021-07-27 02:00:18'),
(99, 52, '76768f-r14_10.png', '1', 'Jabong', '2021-07-27 02:00:18', '2021-07-27 02:00:18'),
(100, 21, '76768f-r5_3.jpeg', '1', 'Jabong', '2021-07-27 02:00:44', '2021-07-27 02:00:44'),
(101, 21, '76768f-r5_4.jpeg', '1', 'Jabong', '2021-07-27 02:00:44', '2021-07-27 02:00:44'),
(102, 21, '76768f-r5_5.jpeg', '1', 'Jabong', '2021-07-27 02:00:45', '2021-07-27 02:00:45'),
(103, 21, '76768f-r5_1.png', '1', 'Jabong', '2021-07-27 02:00:45', '2021-07-27 02:00:45'),
(104, 21, '76768f-r5_2.jpeg', '1', 'Jabong', '2021-07-27 02:00:46', '2021-07-27 02:00:46'),
(105, 21, '76768f-r5_3.jpeg', '1', 'Jabong', '2021-07-27 02:00:46', '2021-07-27 02:00:46'),
(106, 21, '76768f-r5_4.jpeg', '1', 'Jabong', '2021-07-27 02:00:47', '2021-07-27 02:00:47'),
(107, 21, '76768f-r5_5.jpeg', '1', 'Jabong', '2021-07-27 02:00:47', '2021-07-27 02:00:47'),
(108, 21, '76768f-r5_1.png', '1', 'Jabong', '2021-07-27 02:00:48', '2021-07-27 02:00:48'),
(109, 21, '76768f-r5_2.jpeg', '1', 'Jabong', '2021-07-27 02:00:48', '2021-07-27 02:00:48'),
(110, 126, '76768f-r11_1.png', '1', 'brand_site', '2021-07-28 02:47:25', '2021-07-28 02:47:25'),
(111, 126, '76768f-r11_2.jpeg', '1', 'brand_site', '2021-07-28 02:47:25', '2021-07-28 02:47:25'),
(112, 126, '76768f-r11_3.jpeg', '1', 'brand_site', '2021-07-28 02:47:26', '2021-07-28 02:47:26'),
(113, 126, '76768f-r11_4.jpeg', '1', 'brand_site', '2021-07-28 02:47:26', '2021-07-28 02:47:26'),
(114, 126, '76768f-r11_5.jpeg', '1', 'brand_site', '2021-07-28 02:47:27', '2021-07-28 02:47:27'),
(115, 126, '76768f-r11_6.jpeg', '1', 'brand_site', '2021-07-28 02:47:27', '2021-07-28 02:47:27'),
(116, 126, '76768f-r11_7.jpeg', '1', 'brand_site', '2021-07-28 02:47:27', '2021-07-28 02:47:27'),
(117, 126, '76768f-r11_8.png', '1', 'brand_site', '2021-07-28 02:47:27', '2021-07-28 02:47:27'),
(118, 126, '76768f-r11_9.jpeg', '1', 'brand_site', '2021-07-28 02:47:28', '2021-07-28 02:47:28'),
(119, 127, '76768f-r12_1.jpeg', '1', 'brand_site', '2021-07-28 02:48:02', '2021-07-28 02:48:02'),
(120, 127, '76768f-r12_2.jpeg', '1', 'brand_site', '2021-07-28 02:48:02', '2021-07-28 02:48:02'),
(121, 127, '76768f-r12_3.jpeg', '1', 'brand_site', '2021-07-28 02:48:02', '2021-07-28 02:48:02'),
(122, 127, '76768f-r12_4.png', '1', 'brand_site', '2021-07-28 02:48:02', '2021-07-28 02:48:02'),
(123, 127, '76768f-r12_5.jpeg', '1', 'brand_site', '2021-07-28 02:48:03', '2021-07-28 02:48:03'),
(124, 127, '76768f-r12_6.jpeg', '1', 'brand_site', '2021-07-28 02:48:03', '2021-07-28 02:48:03'),
(125, 127, '76768f-r12_7.jpeg', '1', 'brand_site', '2021-07-28 02:48:04', '2021-07-28 02:48:04'),
(126, 127, '76768f-r12_8.jpeg', '1', 'brand_site', '2021-07-28 02:48:04', '2021-07-28 02:48:04'),
(127, 127, '76768f-r12_9.png', '1', 'brand_site', '2021-07-28 02:48:04', '2021-07-28 02:48:04'),
(128, 127, '76768f-r12_10.jpeg', '1', 'brand_site', '2021-07-28 02:48:04', '2021-07-28 02:48:04'),
(129, 128, '76768f-r13_1.jpeg', '1', 'brand_site', '2021-07-28 02:48:11', '2021-07-28 02:48:11'),
(130, 128, '76768f-r13_2.jpeg', '1', 'brand_site', '2021-07-28 02:48:11', '2021-07-28 02:48:11'),
(131, 128, '76768f-r13_3.jpg', '1', 'brand_site', '2021-07-28 02:48:11', '2021-07-28 02:48:11'),
(132, 129, '76768f-r14_1.png', '1', 'brand_site', '2021-07-28 02:48:23', '2021-07-28 02:48:23'),
(133, 129, '76768f-r14_2.jpeg', '1', 'brand_site', '2021-07-28 02:48:23', '2021-07-28 02:48:23'),
(134, 129, '76768f-r14_3.png', '1', 'brand_site', '2021-07-28 02:48:24', '2021-07-28 02:48:24'),
(135, 129, '76768f-r14_4.png', '1', 'brand_site', '2021-07-28 02:48:24', '2021-07-28 02:48:24'),
(136, 129, '76768f-r14_5.png', '1', 'brand_site', '2021-07-28 02:48:24', '2021-07-28 02:48:24'),
(137, 129, '76768f-r14_6.jpeg', '1', 'brand_site', '2021-07-28 02:48:24', '2021-07-28 02:48:24'),
(138, 126, '76768f-r11_1.png', '1', 'ajio', '2021-07-28 02:50:44', '2021-07-28 02:50:44'),
(139, 126, '76768f-r11_2.jpeg', '1', 'ajio', '2021-07-28 02:50:44', '2021-07-28 02:50:44'),
(140, 126, '76768f-r11_3.jpeg', '1', 'ajio', '2021-07-28 02:50:44', '2021-07-28 02:50:44'),
(141, 126, '76768f-r11_4.jpeg', '1', 'ajio', '2021-07-28 02:50:44', '2021-07-28 02:50:44'),
(142, 126, '76768f-r11_5.jpeg', '1', 'ajio', '2021-07-28 02:50:45', '2021-07-28 02:50:45'),
(143, 126, '76768f-r11_6.jpeg', '1', 'ajio', '2021-07-28 02:50:45', '2021-07-28 02:50:45'),
(144, 126, '76768f-r11_7.jpeg', '1', 'ajio', '2021-07-28 02:50:46', '2021-07-28 02:50:46'),
(145, 126, '76768f-r11_8.png', '1', 'ajio', '2021-07-28 02:50:46', '2021-07-28 02:50:46'),
(146, 126, '76768f-r11_9.jpeg', '1', 'ajio', '2021-07-28 02:50:47', '2021-07-28 02:50:47'),
(147, 127, '76768f-r12_1.jpeg', '1', 'ajio', '2021-07-28 02:50:52', '2021-07-28 02:50:52'),
(148, 127, '76768f-r12_2.jpeg', '1', 'ajio', '2021-07-28 02:50:52', '2021-07-28 02:50:52'),
(149, 127, '76768f-r12_3.jpeg', '1', 'ajio', '2021-07-28 02:50:53', '2021-07-28 02:50:53'),
(150, 127, '76768f-r12_4.png', '1', 'ajio', '2021-07-28 02:50:53', '2021-07-28 02:50:53'),
(151, 127, '76768f-r12_5.jpeg', '1', 'ajio', '2021-07-28 02:50:54', '2021-07-28 02:50:54'),
(152, 127, '76768f-r12_6.jpeg', '1', 'ajio', '2021-07-28 02:50:54', '2021-07-28 02:50:54'),
(153, 127, '76768f-r12_7.jpeg', '1', 'ajio', '2021-07-28 02:50:55', '2021-07-28 02:50:55'),
(154, 127, '76768f-r12_8.jpeg', '1', 'ajio', '2021-07-28 02:50:55', '2021-07-28 02:50:55'),
(155, 127, '76768f-r12_9.png', '1', 'ajio', '2021-07-28 02:50:55', '2021-07-28 02:50:55'),
(156, 127, '76768f-r12_10.jpeg', '1', 'ajio', '2021-07-28 02:50:55', '2021-07-28 02:50:55'),
(157, 128, '76768f-r13_1.jpeg', '1', 'ajio', '2021-07-28 02:51:00', '2021-07-28 02:51:00'),
(158, 128, '76768f-r13_2.jpeg', '1', 'ajio', '2021-07-28 02:51:00', '2021-07-28 02:51:00'),
(159, 128, '76768f-r13_3.jpg', '1', 'ajio', '2021-07-28 02:51:00', '2021-07-28 02:51:00'),
(160, 128, '76768f-r13_1.jpeg', '1', 'brand_site', '2021-07-28 05:03:17', '2021-07-28 05:03:17'),
(161, 128, '76768f-r13_2.jpeg', '1', 'brand_site', '2021-07-28 05:03:17', '2021-07-28 05:03:17'),
(162, 128, '76768f-r13_3.jpg', '1', 'brand_site', '2021-07-28 05:03:17', '2021-07-28 05:03:17'),
(163, 128, '76768f-r13_4.jpg', '1', 'brand_site', '2021-07-28 05:03:36', '2021-07-28 05:03:36'),
(164, 125, '76768f-r10_1.jpeg', '1', 'brand_site', '2021-08-13 06:44:24', '2021-08-13 06:44:24'),
(165, 125, '76768f-r10_2.jpeg', '1', 'brand_site', '2021-08-13 06:44:24', '2021-08-13 06:44:24'),
(166, 125, '76768f-r10_3.jpeg', '1', 'brand_site', '2021-08-13 06:44:25', '2021-08-13 06:44:25'),
(167, 125, '76768f-r10_4.png', '1', 'brand_site', '2021-08-13 06:44:25', '2021-08-13 06:44:25'),
(168, 154, 'opendn2_1.jpg', '1', 'Amazon', '2021-08-25 02:45:21', '2021-08-25 02:45:21'),
(169, 154, 'opendn2_2.jpg', '1', 'Amazon', '2021-08-25 02:45:21', '2021-08-25 02:45:21'),
(170, 154, 'opendn2_3.jpg', '1', 'Amazon', '2021-08-25 02:45:21', '2021-08-25 02:45:21'),
(171, 154, 'opendn2_4.jpg', '1', 'Amazon', '2021-08-25 02:45:21', '2021-08-25 02:45:21'),
(172, 154, 'opendn2_5.jpg', '1', 'Amazon', '2021-08-25 02:45:22', '2021-08-25 02:45:22'),
(173, 159, 'opendn6_1.jpg', '1', 'Amazon', '2021-08-25 02:45:47', '2021-08-25 02:45:47'),
(174, 159, 'opendn6_2.jpg', '1', 'Amazon', '2021-08-25 02:45:47', '2021-08-25 02:45:47'),
(175, 159, 'opendn6_3.jpg', '1', 'Amazon', '2021-08-25 02:45:48', '2021-08-25 02:45:48'),
(176, 159, 'opendn6_4.jpg', '1', 'Amazon', '2021-08-25 02:45:48', '2021-08-25 02:45:48'),
(177, 159, 'opendn6_5.jpg', '1', 'Amazon', '2021-08-25 02:45:49', '2021-08-25 02:45:49'),
(178, 159, 'opendn6_6.jpg', '1', 'Amazon', '2021-08-25 02:45:49', '2021-08-25 02:45:49'),
(179, 159, 'opendn6_7.jpg', '1', 'Amazon', '2021-08-25 02:45:50', '2021-08-25 02:45:50'),
(180, 159, 'opendn6_8.jpg', '1', 'Amazon', '2021-08-25 02:45:50', '2021-08-25 02:45:50'),
(181, 159, 'opendn6_9.jpg', '1', 'Amazon', '2021-08-25 02:45:51', '2021-08-25 02:45:51'),
(182, 161, 'opendn8_1.jpg', '1', 'Amazon', '2021-08-25 02:45:59', '2021-08-25 02:45:59'),
(183, 161, 'opendn8_2.jpg', '1', 'Amazon', '2021-08-25 02:45:59', '2021-08-25 02:45:59'),
(184, 161, 'opendn8_3.jpg', '1', 'Amazon', '2021-08-25 02:45:59', '2021-08-25 02:45:59'),
(185, 161, 'opendn8_4.jpg', '1', 'Amazon', '2021-08-25 02:45:59', '2021-08-25 02:45:59'),
(186, 161, 'opendn8_5.jpg', '1', 'Amazon', '2021-08-25 02:46:00', '2021-08-25 02:46:00'),
(187, 161, 'opendn8_6.jpg', '1', 'Amazon', '2021-08-25 02:46:00', '2021-08-25 02:46:00'),
(188, 161, 'opendn8_7.jpg', '1', 'Amazon', '2021-08-25 02:46:01', '2021-08-25 02:46:01'),
(189, 161, 'opendn8_8.jpg', '1', 'Amazon', '2021-08-25 02:46:01', '2021-08-25 02:46:01'),
(190, 161, 'opendn8_9.jpg', '1', 'Amazon', '2021-08-25 02:46:01', '2021-08-25 02:46:01'),
(191, 161, 'opendn8_10.jpg', '1', 'Amazon', '2021-08-25 02:46:01', '2021-08-25 02:46:01'),
(192, 154, 'opendn2_1.jpg', '1', 'Flipkart', '2021-08-25 03:48:59', '2021-08-25 03:48:59'),
(193, 154, 'opendn2_2.jpg', '1', 'Flipkart', '2021-08-25 03:48:59', '2021-08-25 03:48:59'),
(194, 154, 'opendn2_3.jpg', '1', 'Flipkart', '2021-08-25 03:49:00', '2021-08-25 03:49:00'),
(195, 154, 'opendn2_1.jpg', '1', 'Amazon', '2021-08-27 02:12:35', '2021-08-27 02:12:35'),
(196, 154, 'opendn2_2.jpg', '1', 'Amazon', '2021-08-27 02:12:36', '2021-08-27 02:12:36'),
(197, 154, 'opendn2_3.jpg', '1', 'Amazon', '2021-08-27 02:12:37', '2021-08-27 02:12:37'),
(198, 154, 'opendn2_4.jpg', '1', 'Amazon', '2021-08-27 02:12:37', '2021-08-27 02:12:37'),
(199, 154, 'opendn2_5.jpg', '1', 'Amazon', '2021-08-27 02:12:38', '2021-08-27 02:12:38');

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
-- Table structure for table `lots`
--

CREATE TABLE `lots` (
  `id` int(10) UNSIGNED NOT NULL,
  `lot_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `s_type` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `brand_id` int(10) UNSIGNED NOT NULL,
  `lot_c` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lots`
--

INSERT INTO `lots` (`id`, `lot_id`, `s_type`, `user_id`, `brand_id`, `lot_c`, `status`, `created_at`, `updated_at`) VALUES
(19, 'ODN24022021MJTAMS19', 'MS', 11, 11, NULL, NULL, '2021-02-24 10:26:43', '2021-02-24 10:26:43'),
(20, 'ODN24022021MJTAMS20', 'MS', 11, 11, NULL, NULL, '2021-02-24 10:27:11', '2021-02-24 10:27:11'),
(21, 'ODN24022021JNLVES21', 'ES', 15, 3, NULL, NULL, '2021-02-24 10:40:06', '2021-02-24 10:40:06'),
(22, 'ODN24022021-YHFBCA22', 'CA', 14, 2, NULL, NULL, '2021-02-24 10:44:24', '2021-02-24 10:44:24'),
(23, 'ODN24022021-YHFBCA23', 'CA', 14, 2, NULL, NULL, '2021-02-24 10:44:42', '2021-02-24 10:44:42'),
(25, 'ODN26022021-PECA25', 'CA', 22, 6, NULL, NULL, '2021-02-25 19:12:16', '2021-02-25 19:12:16'),
(26, 'ODN26022021-PECA26', 'CA', 22, 6, NULL, NULL, '2021-02-25 19:13:35', '2021-02-25 19:13:35'),
(27, 'ODN26022021-MJTICA27', 'CA', 11, 9, NULL, NULL, '2021-02-25 19:43:37', '2021-02-25 19:43:37'),
(30, 'ODN26022021-JNLVCA30', 'CA', 15, 3, NULL, NULL, '2021-02-25 20:36:34', '2021-02-25 20:36:34'),
(31, 'ODN26022021-JNLVCA31', 'CA', 15, 3, NULL, NULL, '2021-02-25 20:37:02', '2021-02-25 20:37:02'),
(32, 'ODN26022021-TICA32', 'CA', 22, 9, NULL, NULL, '2021-02-25 20:37:51', '2021-02-25 20:37:51'),
(34, 'ODN26022021-MNMS34', 'MS', 23, 4, NULL, NULL, '2021-02-26 00:11:41', '2021-02-26 00:11:41'),
(36, 'ODN26022021-NODTICA36', 'CA', 5, 9, NULL, NULL, '2021-02-26 00:13:27', '2021-02-26 00:13:27'),
(38, 'ODN26022021-MSNKMS38', 'MS', 23, 8, NULL, NULL, '2021-02-26 00:36:57', '2021-02-26 04:47:11'),
(39, 'ODN26022021-TAMS39', 'MS', 22, 11, NULL, NULL, '2021-02-26 08:19:03', '2021-02-26 08:19:03'),
(40, 'ODN26022021-MSNKMS40', 'MS', 23, 8, NULL, NULL, '2021-02-26 08:31:49', '2021-02-26 08:31:49'),
(41, 'ODN27022021-MSMNMS41', 'MS', 23, 4, NULL, NULL, '2021-02-27 01:21:23', '2021-02-27 01:21:23'),
(45, 'ODN28022021-MSBAMS45', 'MS', 23, 10, NULL, NULL, '2021-02-28 08:26:50', '2021-02-28 08:26:50'),
(50, 'ODN02032021-WPTAMS50', 'MS', 26, 11, NULL, NULL, '2021-03-01 21:21:07', '2021-03-01 21:21:07'),
(51, 'ODN02032021-AZGOES51', 'ES', 29, 1, NULL, NULL, '2021-03-02 07:03:47', '2021-03-02 07:03:47'),
(52, 'ODN04032021-AZTACA52', 'CA', 29, 11, NULL, NULL, '2021-03-04 02:14:11', '2021-03-04 02:14:11'),
(56, 'ODN22032021-KLMNCA56', 'CA', 16, 4, NULL, NULL, '2021-03-14 05:40:20', '2021-03-22 06:30:44'),
(58, 'ODN16032021-ES58', 'ES', 22, 4, NULL, NULL, '2021-03-15 23:55:08', '2021-03-15 23:55:08'),
(60, 'ODN22032021-LVMS60', 'MS', 23, 3, NULL, NULL, '2021-03-22 05:29:41', '2021-03-22 05:29:41'),
(62, 'ODN22032021-TAES62', 'ES', 29, 11, NULL, NULL, '2021-03-22 05:30:59', '2021-03-22 05:30:59'),
(63, 'ODN22032021-GOES63', 'ES', 29, 1, NULL, NULL, '2021-03-22 05:31:20', '2021-03-22 05:31:20'),
(64, 'ODN22032021-MNES64', 'ES', 23, 4, NULL, NULL, '2021-03-22 05:31:40', '2021-03-22 05:31:40'),
(67, 'ODN22032021-MNCA67', 'CA', 23, 4, NULL, NULL, '2021-03-22 06:24:37', '2021-03-22 06:24:37'),
(70, 'ODN30032021-MSLVMC70', 'MC', 23, 3, NULL, NULL, '2021-03-30 08:08:35', '2021-03-30 08:08:35'),
(72, 'ODN09072021-DEMO1DMES72', 'ES', 51, 16, NULL, NULL, '2021-07-09 01:04:10', '2021-07-09 01:04:10'),
(73, 'ODN05082021-DEMO1DMCA73', 'CA', 51, 16, NULL, NULL, '2021-08-05 06:51:02', '2021-08-05 06:51:02'),
(74, 'ODN25082021-OPopdnCA74', 'CA', 65, 19, NULL, NULL, '2021-08-25 01:48:39', '2021-08-25 01:48:39'),
(75, 'ODN25082021-OPopdnCA75', 'CA', 65, 19, NULL, NULL, '2021-08-25 06:11:27', '2021-08-25 06:11:27');

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
(9, '2021_01_14_103403_add_delete_to_users_table', 2),
(11, '2021_01_22_094322_add_status_to_users_table', 4),
(42, '2014_10_12_000000_create_users_table', 5),
(43, '2014_10_12_100000_create_password_resets_table', 5),
(44, '2019_08_19_000000_create_failed_jobs_table', 5),
(45, '2020_12_23_112114_create_permission_tables', 5),
(46, '2021_01_14_104654_add_delete1_to_users_table', 5),
(47, '2021_02_10_082209_create_brands_table', 6),
(48, '2021_02_10_083111_create_brands_table', 7),
(49, '2021_02_19_064835_brands', 8),
(50, '2021_02_19_080044_brands', 9),
(51, '2021_02_19_083830_brands', 10),
(52, '2021_02_19_120725_brands', 11),
(53, '2021_02_19_124258_brands', 12),
(54, '2021_02_20_084249_lots', 13),
(55, '2021_02_20_085217_lots', 14),
(56, '2021_02_24_072023_lots', 15),
(57, '2021_02_24_123641_lots', 16),
(58, '2021_02_27_131952_commercials', 17),
(59, '2021_03_03_075230_wrc', 18),
(60, '2021_03_06_044658_wrc_table', 19),
(61, '2021_03_06_053351_wrc', 20),
(62, '2021_03_06_060355_sku', 21),
(63, '2021_03_17_124708_day_plan', 22),
(64, '2021_03_17_124915_shootplan', 22),
(65, '2021_04_23_165132_allocate', 23),
(66, '2021_04_23_165228_editors', 23),
(67, '2021_04_25_064416_uploadraw', 24),
(68, '2021_04_25_065412_uploadraw', 25),
(69, '2019_09_22_192348_create_messages_table', 26),
(70, '2019_10_16_211433_create_favorites_table', 26),
(71, '2019_10_18_223259_add_avatar_to_users', 26),
(72, '2019_10_20_211056_add_messenger_color_to_users', 26),
(73, '2019_10_22_000539_add_dark_mode_to_users', 26),
(74, '2019_10_25_214038_add_active_status_to_users', 26),
(75, '2021_06_29_023321_allocations', 27),
(76, '2021_07_02_111225_submission', 28),
(77, '2021_07_04_161106_editor_submmision', 29),
(78, '2021_08_09_081158_create_activity_log_table', 30),
(79, '2021_08_09_081159_add_event_column_to_activity_log_table', 30),
(80, '2021_08_09_081200_add_batch_uuid_column_to_activity_log_table', 30);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(11, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3),
(2, 'App\\Models\\User', 4),
(11, 'App\\Models\\User', 5),
(9, 'App\\Models\\User', 6),
(1, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 8),
(5, 'App\\Models\\User', 9),
(11, 'App\\Models\\User', 10),
(9, 'App\\Models\\User', 11),
(8, 'App\\Models\\User', 12),
(7, 'App\\Models\\User', 13),
(6, 'App\\Models\\User', 14),
(14, 'App\\Models\\User', 15),
(3, 'App\\Models\\User', 16),
(3, 'App\\Models\\User', 17),
(3, 'App\\Models\\User', 18),
(6, 'App\\Models\\User', 19),
(2, 'App\\Models\\User', 20),
(12, 'App\\Models\\User', 21),
(12, 'App\\Models\\User', 22),
(12, 'App\\Models\\User', 23),
(11, 'App\\Models\\User', 24),
(12, 'App\\Models\\User', 25),
(12, 'App\\Models\\User', 26),
(12, 'App\\Models\\User', 27),
(12, 'App\\Models\\User', 28),
(5, 'App\\Models\\User', 29),
(1, 'App\\Models\\User', 30),
(1, 'App\\Models\\User', 31),
(1, 'App\\Models\\User', 32),
(1, 'App\\Models\\User', 33),
(1, 'App\\Models\\User', 34),
(1, 'App\\Models\\User', 35),
(1, 'App\\Models\\User', 36),
(1, 'App\\Models\\User', 37),
(1, 'App\\Models\\User', 38),
(1, 'App\\Models\\User', 39),
(1, 'App\\Models\\User', 40),
(1, 'App\\Models\\User', 41),
(1, 'App\\Models\\User', 42),
(1, 'App\\Models\\User', 43),
(1, 'App\\Models\\User', 44),
(1, 'App\\Models\\User', 45),
(1, 'App\\Models\\User', 46),
(1, 'App\\Models\\User', 47),
(6, 'App\\Models\\User', 48),
(1, 'App\\Models\\User', 49),
(12, 'App\\Models\\User', 50),
(12, 'App\\Models\\User', 51),
(1, 'App\\Models\\User', 52),
(2, 'App\\Models\\User', 53),
(3, 'App\\Models\\User', 54),
(5, 'App\\Models\\User', 55),
(6, 'App\\Models\\User', 56),
(8, 'App\\Models\\User', 57),
(9, 'App\\Models\\User', 58),
(14, 'App\\Models\\User', 59),
(2, 'App\\Models\\User', 60),
(12, 'App\\Models\\User', 61),
(12, 'App\\Models\\User', 62),
(12, 'App\\Models\\User', 63),
(12, 'App\\Models\\User', 64),
(12, 'App\\Models\\User', 65),
(11, 'App\\Models\\User', 66);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(2, 'create Lots & Wrcs', 'web', '2021-01-25 02:26:13', '2021-01-25 02:26:13'),
(3, 'Raise GRN', 'web', '2021-01-25 02:26:45', '2021-01-25 02:26:45'),
(4, 'Upload SKU\'s', 'web', '2021-01-25 02:27:04', '2021-01-25 02:27:04'),
(5, 'CS/BG/MA', 'web', '2021-01-25 02:30:04', '2021-01-25 02:30:04'),
(6, 'Submissions', 'web', '2021-01-25 02:30:37', '2021-01-25 02:30:37'),
(7, 'Raw Images', 'web', '2021-01-25 02:32:35', '2021-01-25 02:32:35'),
(8, 'Allocation', 'web', '2021-01-25 02:32:56', '2021-01-25 02:32:56'),
(9, 'Edit Images', 'web', '2021-01-25 02:33:10', '2021-01-25 02:33:10'),
(10, 'All Images', 'web', '2021-01-25 02:33:48', '2021-01-25 02:33:48'),
(11, 'Comments', 'web', '2021-01-25 02:33:57', '2021-01-25 02:33:57'),
(12, 'Approval/Rework/Reject', 'web', '2021-01-25 02:34:49', '2021-01-25 02:34:49'),
(13, 'View Lot\'s & Wrc\'s', 'web', '2021-01-25 02:35:39', '2021-01-25 02:35:39'),
(14, 'Quality Check', 'web', '2021-01-25 02:36:45', '2021-01-25 02:36:45'),
(15, 'Create & Edit Clients', 'web', '2021-01-25 02:40:00', '2021-01-25 02:40:00'),
(16, 'Logs', 'web', '2021-01-25 02:40:35', '2021-01-25 02:40:35'),
(17, 'Create, Edit, Delete All Users', 'web', '2021-01-25 02:41:22', '2021-01-25 02:41:22'),
(18, 'Edit Lot\'s & Wrc\'s', 'web', '2021-01-25 02:42:22', '2021-01-25 02:42:22'),
(19, 'Payments', 'web', '2021-01-25 03:00:03', '2021-01-25 03:00:03'),
(20, 'Everything', 'web', '2021-01-25 03:00:46', '2021-01-25 03:00:46'),
(21, 'View Only', 'web', '2021-01-25 03:07:42', '2021-01-25 03:07:42'),
(22, 'Read only', 'web', '2021-01-25 03:08:27', '2021-01-25 03:08:27'),
(25, 'Upload Raw images', 'web', '2021-01-28 06:26:03', '2021-01-28 06:26:03'),
(26, 'Payments1', 'web', '2021-07-09 00:46:58', '2021-07-09 00:46:58'),
(27, 'Report', 'web', '2021-08-25 04:19:28', '2021-08-25 04:19:28');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Commercials', 'web', '2021-01-25 02:48:08', '2021-01-25 02:48:08'),
(2, 'Inwarding', 'web', '2021-01-25 02:48:42', '2021-01-25 02:48:42'),
(3, 'Account Management', 'web', '2021-01-25 02:49:52', '2021-01-25 02:49:52'),
(5, 'Admin', 'web', '2021-01-25 02:53:05', '2021-01-25 02:53:05'),
(6, 'Editor TL', 'web', '2021-01-25 02:54:06', '2021-01-25 02:54:06'),
(7, 'VQC', 'web', '2021-01-25 02:56:11', '2021-01-25 02:56:11'),
(8, 'Qc', 'web', '2021-01-25 02:58:02', '2021-01-25 02:58:02'),
(9, 'Editors', 'web', '2021-01-25 02:59:22', '2021-01-25 02:59:22'),
(11, 'Super Admin', 'web', '2021-01-25 03:02:15', '2021-01-25 03:02:15'),
(12, 'Client', 'web', '2021-01-25 03:08:53', '2021-01-25 03:08:53'),
(14, 'Studio', 'web', '2021-01-28 06:26:34', '2021-01-28 06:26:34');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(2, 1),
(13, 1),
(15, 1),
(3, 2),
(4, 2),
(5, 3),
(6, 3),
(13, 3),
(8, 5),
(10, 5),
(11, 5),
(13, 5),
(8, 6),
(10, 6),
(13, 6),
(8, 7),
(10, 7),
(13, 7),
(14, 7),
(10, 8),
(11, 8),
(12, 8),
(13, 8),
(14, 8),
(7, 9),
(9, 9),
(2, 11),
(3, 11),
(4, 11),
(5, 11),
(6, 11),
(7, 11),
(8, 11),
(9, 11),
(10, 11),
(11, 11),
(12, 11),
(13, 11),
(14, 11),
(15, 11),
(16, 11),
(17, 11),
(18, 11),
(19, 11),
(20, 11),
(21, 12),
(22, 12),
(7, 14),
(25, 14);

-- --------------------------------------------------------

--
-- Table structure for table `shootplan`
--

CREATE TABLE `shootplan` (
  `id` int(11) NOT NULL,
  `sku_id` int(10) UNSIGNED NOT NULL,
  `dayplan_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `shootplan`
--

INSERT INTO `shootplan` (`id`, `sku_id`, `dayplan_id`, `created_at`, `updated_at`) VALUES
(1, 1, 15, '2021-04-13 05:51:52', '2021-04-18 09:16:13'),
(2, 2, 15, '2021-04-13 05:51:52', '2021-04-19 06:38:36'),
(3, 3, 14, '2021-04-13 05:52:25', '2021-04-19 06:37:38'),
(4, 4, 14, '2021-04-13 05:52:25', '2021-04-19 06:37:38'),
(5, 5, 14, '2021-04-13 05:52:25', '2021-04-19 06:40:21'),
(6, 6, 2, '2021-04-13 05:52:25', '2021-04-13 05:52:25'),
(7, 7, 2, '2021-04-13 05:52:25', '2021-04-13 05:52:25'),
(8, 8, 2, '2021-04-13 05:52:25', '2021-04-13 05:52:25'),
(9, 9, 2, '2021-04-13 05:52:25', '2021-04-13 05:52:25'),
(10, 10, 2, '2021-04-13 05:52:25', '2021-04-13 05:52:25'),
(11, 21, 3, '2021-04-15 01:14:05', '2021-04-15 01:14:05'),
(12, 22, 3, '2021-04-15 01:14:05', '2021-04-15 01:14:05'),
(13, 23, 3, '2021-04-15 01:14:05', '2021-04-15 01:14:05'),
(14, 24, 11, '2021-04-15 01:15:24', '2021-04-15 01:15:24'),
(15, 25, 11, '2021-04-15 01:15:24', '2021-04-15 01:15:24'),
(16, 26, 13, '2021-04-15 01:45:10', '2021-04-15 01:45:10'),
(17, 27, 13, '2021-04-15 01:45:10', '2021-04-15 01:45:10'),
(18, 28, 13, '2021-04-15 01:45:10', '2021-04-15 01:45:10'),
(19, 29, 13, '2021-04-15 01:45:10', '2021-04-15 01:45:10'),
(20, 31, 11, '2021-04-15 05:27:00', '2021-04-15 05:27:00'),
(21, 67, 10, '2021-04-15 05:30:28', '2021-04-15 05:30:28'),
(22, 68, 10, '2021-04-15 05:30:28', '2021-04-15 05:30:28'),
(23, 69, 10, '2021-04-15 05:30:28', '2021-04-15 05:30:28'),
(24, 70, 10, '2021-04-15 05:30:28', '2021-04-15 05:30:28'),
(25, 71, 10, '2021-04-15 05:30:28', '2021-04-15 05:30:28'),
(26, 72, 10, '2021-04-15 05:30:28', '2021-04-15 05:30:28'),
(27, 30, 15, '2021-04-15 05:33:37', '2021-04-19 06:43:27'),
(28, 32, 5, '2021-04-15 05:33:37', '2021-04-19 06:44:26'),
(29, 43, 1, '2021-04-15 05:33:37', '2021-04-18 09:18:17'),
(30, 44, 8, '2021-04-15 05:33:37', '2021-04-15 05:33:37'),
(31, 46, 8, '2021-04-15 05:33:37', '2021-04-15 05:33:37'),
(32, 47, 8, '2021-04-15 05:33:37', '2021-04-15 05:33:37'),
(33, 48, 8, '2021-04-15 05:33:37', '2021-04-15 05:33:37'),
(34, 58, 8, '2021-04-15 05:37:36', '2021-04-15 05:37:36'),
(35, 59, 8, '2021-04-15 05:37:36', '2021-04-15 05:37:36'),
(36, 45, 8, '2021-04-15 05:38:16', '2021-04-15 05:38:16'),
(37, 49, 8, '2021-04-15 05:38:16', '2021-04-15 05:38:16'),
(38, 83, 15, '2021-04-15 06:01:43', '2021-04-15 06:01:43'),
(39, 84, 15, '2021-04-15 06:01:43', '2021-04-15 06:01:43'),
(40, 86, 15, '2021-04-18 09:10:23', '2021-04-18 09:10:23'),
(41, 87, 15, '2021-04-18 09:10:23', '2021-04-18 09:10:23'),
(42, 50, 15, '2021-04-19 01:34:45', '2021-04-19 01:34:45'),
(43, 85, 13, '2021-04-19 06:44:53', '2021-04-19 06:44:53'),
(44, 88, 13, '2021-04-20 09:45:05', '2021-04-20 09:45:05'),
(45, 89, 12, '2021-04-20 09:45:25', '2021-04-20 09:45:25'),
(46, 53, 1, '2021-04-26 11:17:44', '2021-04-26 11:17:44'),
(47, 90, 1, '2021-04-26 11:18:45', '2021-04-26 11:18:45'),
(48, 91, 1, '2021-04-26 11:19:01', '2021-04-26 11:19:01'),
(49, 92, 1, '2021-04-26 11:19:12', '2021-04-26 11:19:12'),
(50, 51, 1, '2021-04-26 11:22:12', '2021-04-26 11:22:12'),
(51, 52, 2, '2021-04-26 11:22:29', '2021-04-26 11:22:29'),
(52, 54, 1, '2021-04-26 11:22:47', '2021-04-26 11:22:47'),
(53, 93, 14, '2021-05-02 00:46:34', '2021-05-02 00:46:34'),
(54, 94, 14, '2021-05-02 00:47:24', '2021-05-02 00:47:24'),
(55, 95, 14, '2021-05-02 00:48:02', '2021-05-02 00:48:02'),
(56, 96, 14, '2021-05-02 00:49:54', '2021-05-02 00:49:54'),
(57, 97, 14, '2021-05-02 00:51:21', '2021-05-02 00:51:21'),
(58, 98, 14, '2021-05-02 00:52:02', '2021-05-02 00:52:02'),
(59, 99, 14, '2021-05-02 00:53:19', '2021-05-02 00:53:19'),
(60, 100, 14, '2021-05-02 00:53:19', '2021-05-02 00:53:19'),
(61, 101, 14, '2021-05-02 00:53:19', '2021-05-02 00:53:19'),
(62, 102, 14, '2021-05-02 00:53:19', '2021-05-02 00:53:19'),
(63, 103, 14, '2021-05-02 00:53:19', '2021-05-02 00:53:19'),
(64, 104, 14, '2021-05-02 00:53:19', '2021-05-02 00:53:19'),
(65, 105, 14, '2021-05-02 00:53:19', '2021-05-02 00:53:19'),
(66, 106, 14, '2021-05-02 00:53:19', '2021-05-02 00:53:19'),
(67, 107, 14, '2021-05-02 00:53:19', '2021-05-02 00:53:19'),
(68, 108, 14, '2021-05-02 00:53:19', '2021-05-02 00:53:19'),
(69, 109, 14, '2021-05-02 00:53:19', '2021-05-02 00:53:19'),
(70, 110, 14, '2021-05-02 00:53:19', '2021-05-02 00:53:19'),
(71, 111, 14, '2021-05-02 00:53:19', '2021-05-02 00:53:19'),
(72, 112, 14, '2021-05-02 00:53:19', '2021-05-02 00:53:19'),
(73, 61, 1, '2021-07-06 11:26:48', '2021-07-06 11:26:48'),
(74, 113, 16, '2021-07-09 01:29:41', '2021-07-09 01:29:41'),
(75, 114, 16, '2021-07-09 01:29:41', '2021-07-09 01:29:41'),
(76, 115, 17, '2021-07-09 01:30:08', '2021-07-09 01:30:08'),
(77, 116, 17, '2021-07-09 01:30:09', '2021-07-09 01:30:09'),
(78, 117, 17, '2021-07-09 01:30:09', '2021-07-09 01:30:09'),
(79, 118, 15, '2021-07-09 01:30:35', '2021-07-09 01:30:35'),
(80, 119, 15, '2021-07-09 01:30:35', '2021-07-09 01:30:35'),
(81, 55, 13, '2021-07-27 01:21:21', '2021-07-27 01:22:23'),
(82, 56, 13, '2021-07-27 01:21:21', '2021-07-27 01:22:23'),
(83, 57, 13, '2021-07-27 01:21:21', '2021-07-27 01:22:23'),
(84, 60, 13, '2021-07-27 01:21:21', '2021-07-27 01:22:23'),
(85, 62, 17, '2021-07-27 01:21:21', '2021-07-27 01:21:21'),
(86, 63, 17, '2021-07-27 01:21:21', '2021-07-27 01:21:21'),
(87, 64, 17, '2021-07-27 01:21:21', '2021-07-27 01:21:21'),
(88, 65, 17, '2021-07-27 01:21:21', '2021-07-27 01:21:21'),
(89, 66, 17, '2021-07-27 01:21:21', '2021-07-27 01:21:21'),
(90, 120, 13, '2021-07-28 02:30:55', '2021-07-28 02:32:38'),
(91, 121, 13, '2021-07-28 02:30:55', '2021-07-28 02:32:38'),
(92, 122, 13, '2021-07-28 02:30:55', '2021-07-28 02:32:38'),
(93, 123, 13, '2021-07-28 02:30:55', '2021-07-28 02:32:38'),
(94, 124, 13, '2021-07-28 02:30:55', '2021-07-28 02:32:38'),
(95, 125, 17, '2021-07-28 02:30:55', '2021-07-28 02:30:55'),
(96, 126, 17, '2021-07-28 02:30:55', '2021-07-28 02:30:55'),
(97, 127, 17, '2021-07-28 02:30:55', '2021-07-28 02:30:55'),
(98, 128, 17, '2021-07-28 02:30:55', '2021-07-28 02:30:55'),
(99, 129, 17, '2021-07-28 02:30:55', '2021-07-28 02:30:55'),
(100, 130, 18, '2021-08-10 00:50:37', '2021-08-10 00:50:37'),
(101, 131, 18, '2021-08-10 00:50:37', '2021-08-10 00:50:37'),
(102, 154, 18, '2021-08-25 02:14:32', '2021-08-25 02:16:18'),
(103, 155, 18, '2021-08-25 02:14:32', '2021-08-25 02:16:18'),
(104, 156, 18, '2021-08-25 02:14:32', '2021-08-25 02:16:18'),
(105, 157, 18, '2021-08-25 02:14:32', '2021-08-25 02:16:18'),
(106, 158, 19, '2021-08-25 02:14:32', '2021-08-25 02:14:32'),
(107, 159, 19, '2021-08-25 02:14:32', '2021-08-25 02:14:32'),
(108, 160, 19, '2021-08-25 02:14:32', '2021-08-25 02:14:32'),
(109, 161, 19, '2021-08-25 02:14:32', '2021-08-25 02:14:32'),
(110, 162, 19, '2021-08-25 02:14:32', '2021-08-25 02:14:32'),
(111, 163, 19, '2021-08-25 02:14:32', '2021-08-25 02:14:32'),
(112, 164, 19, '2021-08-25 02:14:32', '2021-08-25 02:14:32'),
(113, 165, 19, '2021-08-25 02:14:32', '2021-08-25 02:14:32');

-- --------------------------------------------------------

--
-- Table structure for table `sku`
--

CREATE TABLE `sku` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `brand_id` int(10) UNSIGNED NOT NULL,
  `lot_id` int(10) UNSIGNED NOT NULL,
  `wrc_id` int(10) UNSIGNED NOT NULL,
  `sku_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subcategory` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_c` text COLLATE utf8mb4_unicode_ci,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sku`
--

INSERT INTO `sku` (`id`, `user_id`, `brand_id`, `lot_id`, `wrc_id`, `sku_code`, `brand`, `gender`, `category`, `subcategory`, `sku_c`, `status`, `created_at`, `updated_at`) VALUES
(1, 27, 15, 51, 36, '76768f-r5', 'male1', 'google1', 'hero1', 'helmet1', NULL, '1', '2021-03-08 21:10:02', '2021-06-28 21:27:10'),
(2, 27, 15, 51, 36, '76768f-r6', 'male2', 'google2', 'hero2', 'helmet2', NULL, NULL, '2021-03-08 21:10:02', '2021-03-08 21:10:02'),
(3, 27, 15, 51, 36, '76768f-r7', 'male3', 'google3', 'hero3', 'helmet3', NULL, NULL, '2021-03-08 21:10:02', '2021-03-08 21:10:02'),
(4, 27, 15, 51, 36, '76768f-r8', 'male4', 'google4', 'hero4', 'helmet4', NULL, NULL, '2021-03-08 21:10:02', '2021-03-08 21:10:02'),
(5, 27, 15, 51, 36, '76768f-r9', 'male5', 'google5', 'hero5', 'helmet5', NULL, NULL, '2021-03-08 21:10:02', '2021-03-08 21:10:02'),
(6, 27, 15, 51, 36, '76768f-r10', 'male6', 'google6', 'hero6', 'helmet6', NULL, NULL, '2021-03-08 21:10:02', '2021-03-08 21:10:02'),
(7, 27, 15, 51, 36, '76768f-r11', 'male7', 'google7', 'hero7', 'helmet7', NULL, NULL, '2021-03-08 21:10:02', '2021-03-08 21:10:02'),
(8, 27, 15, 51, 36, '76768f-r12', 'male8', 'google8', 'hero8', 'helmet8', NULL, NULL, '2021-03-08 21:10:02', '2021-03-08 21:10:02'),
(9, 27, 15, 51, 36, '76768f-r13', 'male9', 'google9', 'hero9', 'helmet9', NULL, NULL, '2021-03-08 21:10:02', '2021-03-08 21:10:02'),
(10, 27, 15, 51, 36, '76768f-r14', 'male10', 'google10', 'hero10', 'helmet10', NULL, NULL, '2021-03-08 21:10:02', '2021-03-08 21:10:02'),
(11, 29, 1, 51, 26, '76768f-r5', 'male1', 'google1', 'hero1', 'helmet1', NULL, NULL, '2021-03-09 07:39:25', '2021-03-09 07:39:25'),
(12, 29, 1, 51, 26, '76768f-r6', 'male2', 'google2', 'hero2', 'helmet2', NULL, NULL, '2021-03-09 07:39:25', '2021-03-09 07:39:25'),
(13, 29, 1, 51, 26, '76768f-r7', 'male3', 'google3', 'hero3', 'helmet3', NULL, NULL, '2021-03-09 07:39:25', '2021-03-09 07:39:25'),
(14, 29, 1, 51, 26, '76768f-r8', 'male4', 'google4', 'hero4', 'helmet4', NULL, NULL, '2021-03-09 07:39:25', '2021-03-09 07:39:25'),
(15, 29, 1, 51, 26, '76768f-r9', 'male5', 'google5', 'hero5', 'helmet5', NULL, NULL, '2021-03-09 07:39:25', '2021-03-09 07:39:25'),
(16, 29, 1, 51, 26, '76768f-r10', 'male6', 'google6', 'hero6', 'helmet6', NULL, NULL, '2021-03-09 07:39:25', '2021-03-09 07:39:25'),
(17, 29, 1, 51, 26, '76768f-r11', 'male7', 'google7', 'hero7', 'helmet7', NULL, NULL, '2021-03-09 07:39:25', '2021-03-09 07:39:25'),
(18, 29, 1, 51, 26, '76768f-r12', 'male8', 'google8', 'hero8', 'helmet8', NULL, NULL, '2021-03-09 07:39:25', '2021-03-09 07:39:25'),
(19, 29, 1, 51, 26, '76768f-r13', 'male9', 'google9', 'hero9', 'helmet9', NULL, NULL, '2021-03-09 07:39:25', '2021-03-09 07:39:25'),
(20, 29, 1, 51, 26, '76768f-r14', 'male10', 'google10', 'hero10', 'helmet10', NULL, NULL, '2021-03-09 07:39:25', '2021-03-09 07:39:25'),
(21, 23, 10, 45, 39, '76768f-r5', 'male1', 'google1', 'hero1', 'helmet1', NULL, NULL, '2021-03-18 06:24:42', '2021-03-18 06:24:42'),
(22, 23, 10, 45, 39, '76768f-r6', 'male2', 'google2', 'hero2', 'helmet2', NULL, NULL, '2021-03-18 06:24:42', '2021-03-18 06:24:42'),
(23, 23, 10, 45, 39, '76768f-r7', 'male3', 'google3', 'hero3', 'helmet3', NULL, NULL, '2021-03-18 06:24:42', '2021-03-18 06:24:42'),
(24, 23, 10, 45, 39, '76768f-r8', 'male4', 'google4', 'hero4', 'helmet4', NULL, NULL, '2021-03-18 06:24:42', '2021-03-18 06:24:42'),
(25, 23, 10, 45, 39, '76768f-r9', 'male5', 'google5', 'hero5', 'helmet5', NULL, NULL, '2021-03-18 06:24:42', '2021-03-18 06:24:42'),
(26, 23, 10, 45, 39, '76768f-r10', 'male6', 'google6', 'hero6', 'helmet6', NULL, NULL, '2021-03-18 06:24:42', '2021-03-18 06:24:42'),
(27, 23, 10, 45, 39, '76768f-r5', 'male1', 'google1', 'hero1', 'helmet1', NULL, NULL, '2021-03-18 06:24:47', '2021-03-18 06:24:47'),
(28, 23, 10, 45, 39, '76768f-r6', 'male2', 'google2', 'hero2', 'helmet2', NULL, NULL, '2021-03-18 06:24:47', '2021-03-18 06:24:47'),
(29, 23, 10, 45, 39, '76768f-r7', 'male3', 'google3', 'hero3', 'helmet3', NULL, NULL, '2021-03-18 06:24:47', '2021-03-18 06:24:47'),
(30, 23, 10, 45, 39, '76768f-r8', 'male4', 'google4', 'hero4', 'helmet4', NULL, '1', '2021-03-18 06:24:47', '2021-08-20 04:52:52'),
(31, 23, 10, 45, 39, '76768f-r9', 'male5', 'google5', 'hero5', 'helmet5', NULL, NULL, '2021-03-18 06:24:47', '2021-03-18 06:24:47'),
(32, 23, 10, 45, 39, '76768f-r10', 'male6', 'google6', 'hero6', 'helmet6', NULL, NULL, '2021-03-18 06:24:47', '2021-03-18 06:24:47'),
(33, 29, 1, 51, 40, '76768f-r5', 'male1', 'google1', 'hero1', 'helmet1', NULL, NULL, '2021-03-23 08:41:33', '2021-03-23 08:41:33'),
(34, 29, 1, 51, 40, '76768f-r6', 'male2', 'google2', 'hero2', 'helmet2', NULL, NULL, '2021-03-23 08:41:33', '2021-03-23 08:41:33'),
(35, 29, 1, 51, 40, '76768f-r7', 'male3', 'google3', 'hero3', 'helmet3', NULL, NULL, '2021-03-23 08:41:33', '2021-03-23 08:41:33'),
(36, 29, 1, 51, 40, '76768f-r8', 'male4', 'google4', 'hero4', 'helmet4', NULL, NULL, '2021-03-23 08:41:33', '2021-03-23 08:41:33'),
(37, 29, 1, 51, 40, '76768f-r9', 'male5', 'google5', 'hero5', 'helmet5', NULL, NULL, '2021-03-23 08:41:33', '2021-03-23 08:41:33'),
(38, 29, 1, 51, 40, '76768f-r10', 'male6', 'google6', 'hero6', 'helmet6', NULL, NULL, '2021-03-23 08:41:33', '2021-03-23 08:41:33'),
(39, 29, 1, 51, 40, '76768f-r11', 'male7', 'google7', 'hero7', 'helmet7', NULL, NULL, '2021-03-23 08:41:33', '2021-03-23 08:41:33'),
(40, 29, 1, 51, 40, '76768f-r12', 'male8', 'google8', 'hero8', 'helmet8', NULL, NULL, '2021-03-23 08:41:33', '2021-03-23 08:41:33'),
(41, 29, 1, 51, 40, '76768f-r13', 'male9', 'google9', 'hero9', 'helmet9', NULL, NULL, '2021-03-23 08:41:33', '2021-03-23 08:41:33'),
(42, 29, 1, 51, 40, '76768f-r14', 'male10', 'google10', 'hero10', 'helmet10', NULL, NULL, '2021-03-23 08:41:33', '2021-03-23 08:41:33'),
(43, 23, 10, 45, 39, '76768f-r5', 'male1', 'google1', 'hero1', 'helmet1', NULL, '1', '2021-04-01 04:13:42', '2021-05-02 23:58:55'),
(44, 23, 10, 45, 39, '76768f-r6', 'male2', 'google2', 'hero2', 'helmet2', NULL, NULL, '2021-04-01 04:13:42', '2021-04-01 04:13:42'),
(45, 23, 10, 45, 39, '76768f-r7', 'male3', 'google3', 'hero3', 'helmet3', NULL, NULL, '2021-04-01 04:13:42', '2021-04-01 04:13:42'),
(46, 23, 10, 45, 39, '76768f-r8', 'male4', 'google4', 'hero4', 'helmet4', NULL, NULL, '2021-04-01 04:13:42', '2021-04-01 04:13:42'),
(47, 23, 10, 45, 39, '76768f-r9', 'male5', 'google5', 'hero5', 'helmet5', NULL, NULL, '2021-04-01 04:13:42', '2021-04-01 04:13:42'),
(48, 23, 10, 45, 39, '76768f-r10', 'male6', 'google6', 'hero6', 'helmet6', NULL, NULL, '2021-04-01 04:13:42', '2021-04-01 04:13:42'),
(49, 23, 10, 45, 39, '76768f-r11', 'male7', 'google7', 'hero7', 'helmet7', NULL, NULL, '2021-04-01 04:13:42', '2021-04-01 04:13:42'),
(50, 23, 10, 45, 39, '76768f-r12', 'male8', 'google8', 'hero8', 'helmet8', NULL, '1', '2021-04-01 04:13:42', '2021-08-20 04:53:25'),
(51, 23, 10, 45, 39, '76768f-r13', 'male9', 'google9', 'hero9', 'helmet9', NULL, '1', '2021-04-01 04:13:42', '2021-05-02 03:35:39'),
(52, 23, 10, 45, 39, '76768f-r14', 'male10', 'google10', 'hero10', 'helmet10', NULL, NULL, '2021-04-01 04:13:42', '2021-04-01 04:13:42'),
(53, 23, 10, 45, 39, '76768f-r5', 'male1', 'google1', 'hero1', 'helmet1', NULL, '1', '2021-04-01 04:14:39', '2021-05-02 12:14:29'),
(54, 23, 10, 45, 39, '76768f-r6', 'male2', 'google2', 'hero2', 'helmet2', NULL, '1', '2021-04-01 04:14:39', '2021-05-05 00:16:24'),
(55, 23, 10, 45, 39, '76768f-r7', 'male3', 'google3', 'hero3', 'helmet3', NULL, NULL, '2021-04-01 04:14:39', '2021-04-01 04:14:39'),
(56, 23, 10, 45, 39, '76768f-r8', 'male4', 'google4', 'hero4', 'helmet4', NULL, NULL, '2021-04-01 04:14:39', '2021-04-01 04:14:39'),
(57, 23, 10, 45, 39, '76768f-r9', 'male5', 'google5', 'hero5', 'helmet5', NULL, NULL, '2021-04-01 04:14:39', '2021-04-01 04:14:39'),
(58, 23, 10, 45, 39, '76768f-r10', 'male6', 'google6', 'hero6', 'helmet6', NULL, NULL, '2021-04-01 04:14:39', '2021-04-01 04:14:39'),
(59, 23, 10, 45, 39, '76768f-r11', 'male7', 'google7', 'hero7', 'helmet7', NULL, NULL, '2021-04-01 04:14:39', '2021-04-01 04:14:39'),
(60, 23, 10, 45, 39, '76768f-r12', 'male8', 'google8', 'hero8', 'helmet8', NULL, NULL, '2021-04-01 04:14:39', '2021-04-01 04:14:39'),
(61, 23, 10, 45, 39, '76768f-r13', 'male9', 'google9', 'hero9', 'helmet9', NULL, NULL, '2021-04-01 04:14:39', '2021-04-01 04:14:39'),
(62, 23, 10, 45, 39, '76768f-r14', 'male10', 'google10', 'hero10', 'helmet10', NULL, '1', '2021-04-01 04:14:39', '2021-07-27 01:24:27'),
(63, 23, 10, 45, 39, '76768f-r5', 'male1', 'google1', 'hero1', 'helmet1', NULL, '1', '2021-04-01 04:14:52', '2021-07-27 01:25:50'),
(64, 23, 10, 45, 39, '76768f-r6', 'male2', 'google2', 'hero2', 'helmet2', NULL, NULL, '2021-04-01 04:14:53', '2021-04-01 04:14:53'),
(65, 23, 10, 45, 39, '76768f-r7', 'male3', 'google3', 'hero3', 'helmet3', NULL, NULL, '2021-04-01 04:14:53', '2021-04-01 04:14:53'),
(66, 23, 10, 45, 39, '76768f-r8', 'male4', 'google4', 'hero4', 'helmet4', NULL, NULL, '2021-04-01 04:14:53', '2021-04-01 04:14:53'),
(67, 23, 10, 45, 39, '76768f-r9', 'male5', 'google5', 'hero5', 'helmet5', NULL, NULL, '2021-04-01 04:14:53', '2021-04-01 04:14:53'),
(68, 23, 10, 45, 39, '76768f-r10', 'male6', 'google6', 'hero6', 'helmet6', NULL, NULL, '2021-04-01 04:14:53', '2021-04-01 04:14:53'),
(69, 23, 10, 45, 39, '76768f-r11', 'male7', 'google7', 'hero7', 'helmet7', NULL, NULL, '2021-04-01 04:14:53', '2021-04-01 04:14:53'),
(70, 23, 10, 45, 39, '76768f-r12', 'male8', 'google8', 'hero8', 'helmet8', NULL, NULL, '2021-04-01 04:14:53', '2021-04-01 04:14:53'),
(71, 23, 10, 45, 39, '76768f-r13', 'male9', 'google9', 'hero9', 'helmet9', NULL, NULL, '2021-04-01 04:14:53', '2021-04-01 04:14:53'),
(72, 23, 10, 45, 39, '76768f-r14', 'male10', 'google10', 'hero10', 'helmet10', NULL, NULL, '2021-04-01 04:14:53', '2021-04-01 04:14:53'),
(73, 29, 1, 51, 29, '76768f-r5', 'male1', 'google1', 'hero1', 'helmet1', NULL, NULL, '2021-04-01 04:15:12', '2021-04-01 04:15:12'),
(74, 29, 1, 51, 29, '76768f-r6', 'male2', 'google2', 'hero2', 'helmet2', NULL, NULL, '2021-04-01 04:15:12', '2021-04-01 04:15:12'),
(75, 29, 1, 51, 29, '76768f-r7', 'male3', 'google3', 'hero3', 'helmet3', NULL, NULL, '2021-04-01 04:15:12', '2021-04-01 04:15:12'),
(76, 29, 1, 51, 29, '76768f-r8', 'male4', 'google4', 'hero4', 'helmet4', NULL, NULL, '2021-04-01 04:15:12', '2021-04-01 04:15:12'),
(77, 29, 1, 51, 29, '76768f-r9', 'male5', 'google5', 'hero5', 'helmet5', NULL, NULL, '2021-04-01 04:15:12', '2021-04-01 04:15:12'),
(78, 29, 1, 51, 29, '76768f-r10', 'male6', 'google6', 'hero6', 'helmet6', NULL, NULL, '2021-04-01 04:15:12', '2021-04-01 04:15:12'),
(79, 29, 1, 51, 29, '76768f-r11', 'male7', 'google7', 'hero7', 'helmet7', NULL, NULL, '2021-04-01 04:15:12', '2021-04-01 04:15:12'),
(80, 29, 1, 51, 29, '76768f-r12', 'male8', 'google8', 'hero8', 'helmet8', NULL, NULL, '2021-04-01 04:15:12', '2021-04-01 04:15:12'),
(81, 29, 1, 51, 29, '76768f-r13', 'male9', 'google9', 'hero9', 'helmet9', NULL, NULL, '2021-04-01 04:15:12', '2021-04-01 04:15:12'),
(82, 29, 1, 51, 29, '76768f-r14', 'male10', 'google10', 'hero10', 'helmet10', NULL, NULL, '2021-04-01 04:15:12', '2021-04-01 04:15:12'),
(83, 23, 4, 67, 41, '76768f-r5', 'male1', 'google1', 'hero1', 'helmet1', NULL, '1', '2021-04-15 05:55:08', '2021-07-06 11:43:17'),
(84, 23, 4, 67, 41, '76768f-r6', 'male2', 'google2', 'hero2', 'helmet2', NULL, '1', '2021-04-15 05:55:08', '2021-07-06 11:39:48'),
(85, 23, 4, 67, 41, '76768f-r7', 'male3', 'google3', 'hero3', 'helmet3', NULL, NULL, '2021-04-15 05:55:08', '2021-04-15 05:55:08'),
(86, 23, 4, 67, 41, '76768f-r8', 'male4', 'google4', 'hero4', 'helmet4', NULL, '1', '2021-04-15 05:55:08', '2021-07-06 11:45:23'),
(87, 23, 4, 67, 41, '76768f-r9', 'male5', 'google5', 'hero5', 'helmet5', NULL, '1', '2021-04-15 05:55:08', '2021-07-06 11:46:57'),
(88, 23, 4, 67, 41, '76768f-r10', 'male6', 'google6', 'hero6', 'helmet6', NULL, NULL, '2021-04-15 05:55:08', '2021-04-15 05:55:08'),
(89, 23, 4, 67, 41, '76768f-r11', 'male7', 'google7', 'hero7', 'helmet7', NULL, NULL, '2021-04-15 05:55:08', '2021-04-15 05:55:08'),
(90, 23, 4, 67, 41, '76768f-r12', 'male8', 'google8', 'hero8', 'helmet8', NULL, '1', '2021-04-15 05:55:08', '2021-05-02 12:29:04'),
(91, 23, 4, 67, 41, '76768f-r13', 'male9', 'google9', 'hero9', 'helmet9', NULL, '1', '2021-04-15 05:55:08', '2021-05-02 12:13:53'),
(92, 23, 4, 67, 41, '76768f-r14', 'male10', 'google10', 'hero10', 'helmet10', NULL, '1', '2021-04-15 05:55:08', '2021-05-02 12:58:45'),
(93, 23, 10, 45, 43, '76768f-r5', 'male1', 'google1', 'hero1', 'helmet1', NULL, NULL, '2021-05-02 00:44:06', '2021-05-02 00:44:06'),
(94, 23, 10, 45, 43, '76768f-r6', 'male2', 'google2', 'hero2', 'helmet2', NULL, NULL, '2021-05-02 00:44:06', '2021-05-02 00:44:06'),
(95, 23, 10, 45, 43, '76768f-r7', 'male3', 'google3', 'hero3', 'helmet3', NULL, NULL, '2021-05-02 00:44:06', '2021-05-02 00:44:06'),
(96, 23, 10, 45, 43, '76768f-r8', 'male4', 'google4', 'hero4', 'helmet4', NULL, NULL, '2021-05-02 00:44:06', '2021-05-02 00:44:06'),
(97, 23, 10, 45, 43, '76768f-r9', 'male5', 'google5', 'hero5', 'helmet5', NULL, '1', '2021-05-02 00:44:06', '2021-05-03 01:19:17'),
(98, 23, 10, 45, 43, '76768f-r10', 'male6', 'google6', 'hero6', 'helmet6', NULL, NULL, '2021-05-02 00:44:06', '2021-05-02 00:44:06'),
(99, 23, 10, 45, 43, '76768f-r11', 'male7', 'google7', 'hero7', 'helmet7', NULL, NULL, '2021-05-02 00:44:06', '2021-05-02 00:44:06'),
(100, 23, 10, 45, 43, '76768f-r12', 'male8', 'google8', 'hero8', 'helmet8', NULL, NULL, '2021-05-02 00:44:06', '2021-05-02 00:44:06'),
(101, 23, 10, 45, 43, '76768f-r13', 'male9', 'google9', 'hero9', 'helmet9', NULL, NULL, '2021-05-02 00:44:06', '2021-05-02 00:44:06'),
(102, 23, 10, 45, 43, '76768f-r14', 'male10', 'google10', 'hero10', 'helmet10', NULL, NULL, '2021-05-02 00:44:06', '2021-05-02 00:44:06'),
(103, 23, 10, 45, 44, '76768f-r5', 'male1', 'google1', 'hero1', 'helmet1', NULL, '1', '2021-05-02 00:44:25', '2021-08-27 04:50:22'),
(104, 23, 10, 45, 44, '76768f-r6', 'male2', 'google2', 'hero2', 'helmet2', NULL, '1', '2021-05-02 00:44:25', '2021-08-27 04:50:37'),
(105, 23, 10, 45, 44, '76768f-r7', 'male3', 'google3', 'hero3', 'helmet3', NULL, NULL, '2021-05-02 00:44:25', '2021-05-02 00:44:25'),
(106, 23, 10, 45, 44, '76768f-r8', 'male4', 'google4', 'hero4', 'helmet4', NULL, NULL, '2021-05-02 00:44:25', '2021-05-02 00:44:25'),
(107, 23, 10, 45, 44, '76768f-r9', 'male5', 'google5', 'hero5', 'helmet5', NULL, NULL, '2021-05-02 00:44:25', '2021-05-02 00:44:25'),
(108, 23, 10, 45, 44, '76768f-r10', 'male6', 'google6', 'hero6', 'helmet6', NULL, NULL, '2021-05-02 00:44:25', '2021-05-02 00:44:25'),
(109, 23, 10, 45, 44, '76768f-r11', 'male7', 'google7', 'hero7', 'helmet7', NULL, NULL, '2021-05-02 00:44:25', '2021-05-02 00:44:25'),
(110, 23, 10, 45, 44, '76768f-r12', 'male8', 'google8', 'hero8', 'helmet8', NULL, NULL, '2021-05-02 00:44:25', '2021-05-02 00:44:25'),
(111, 23, 10, 45, 44, '76768f-r13', 'male9', 'google9', 'hero9', 'helmet9', NULL, NULL, '2021-05-02 00:44:25', '2021-05-02 00:44:25'),
(112, 23, 10, 45, 44, '76768f-r14', 'male10', 'google10', 'hero10', 'helmet10', NULL, NULL, '2021-05-02 00:44:25', '2021-05-02 00:44:25'),
(113, 51, 16, 72, 45, 'Demo1-1', 'male1', 'Demo1', 'hero1', 'helmet1', NULL, NULL, '2021-07-09 01:18:06', '2021-07-09 01:18:06'),
(114, 51, 16, 72, 45, 'Demo1-2', 'male2', 'Demo1', 'hero2', 'helmet2', NULL, NULL, '2021-07-09 01:18:06', '2021-07-09 01:18:06'),
(115, 51, 16, 72, 45, 'Demo1-3', 'male3', 'Demo1', 'hero3', 'helmet3', NULL, '1', '2021-07-09 01:18:06', '2021-07-09 01:47:29'),
(116, 51, 16, 72, 45, 'Demo1-4', 'male4', 'Demo1', 'hero4', 'helmet4', 'Cloths not fit', '1', '2021-07-09 01:18:06', '2021-07-09 01:52:36'),
(117, 51, 16, 72, 45, 'Demo1-5', 'male5', 'Demo1', 'hero5', 'helmet5', 'fititng issue', '1', '2021-07-09 01:18:06', '2021-07-19 00:40:27'),
(118, 51, 16, 72, 45, 'Demo1-6', 'male6', 'Demo1', 'hero6', 'helmet6', NULL, '1', '2021-07-09 01:18:06', '2021-08-27 04:53:03'),
(119, 51, 16, 72, 45, 'Demo1-7', 'male7', 'Demo1', 'hero7', 'helmet7', NULL, '1', '2021-07-09 01:18:06', '2021-08-27 04:53:16'),
(120, 51, 16, 72, 46, '76768f-r5', 'male1', 'google1', 'hero1', 'helmet1', NULL, NULL, '2021-07-28 02:29:19', '2021-07-28 02:29:19'),
(121, 51, 16, 72, 46, '76768f-r6', 'male2', 'google2', 'hero2', 'helmet2', NULL, NULL, '2021-07-28 02:29:19', '2021-07-28 02:29:19'),
(122, 51, 16, 72, 46, '76768f-r7', 'male3', 'google3', 'hero3', 'helmet3', NULL, NULL, '2021-07-28 02:29:19', '2021-07-28 02:29:19'),
(123, 51, 16, 72, 46, '76768f-r8', 'male4', 'google4', 'hero4', 'helmet4', NULL, NULL, '2021-07-28 02:29:19', '2021-07-28 02:29:19'),
(124, 51, 16, 72, 46, '76768f-r9', 'male5', 'google5', 'hero5', 'helmet5', NULL, NULL, '2021-07-28 02:29:19', '2021-07-28 02:29:19'),
(125, 51, 16, 72, 46, '76768f-r10', 'male6', 'google6', 'hero6', 'helmet6', 'article not fit', '1', '2021-07-28 02:29:19', '2021-07-29 06:18:25'),
(126, 51, 16, 72, 46, '76768f-r11', 'male7', 'google7', 'hero7', 'helmet7', NULL, '1', '2021-07-28 02:29:19', '2021-07-28 02:35:25'),
(127, 51, 16, 72, 46, '76768f-r12', 'male8', 'google8', 'hero8', 'helmet8', NULL, '1', '2021-07-28 02:29:19', '2021-07-28 02:38:16'),
(128, 51, 16, 72, 46, '76768f-r13', 'male9', 'google9', 'hero9', 'helmet9', NULL, '1', '2021-07-28 02:29:19', '2021-07-28 02:38:37'),
(129, 51, 16, 72, 46, '76768f-r14', 'male10', 'google10', 'hero10', 'helmet10', NULL, '1', '2021-07-28 02:29:19', '2021-07-28 02:38:50'),
(130, 51, 16, 72, 46, 'Hostflow1', 'male1', 'google1', 'hero1', 'helmet1', NULL, '1', '2021-08-05 10:38:26', '2021-08-13 05:55:40'),
(131, 51, 16, 72, 46, 'Hostflow2', 'male2', 'google2', 'hero2', 'helmet2', NULL, '1', '2021-08-05 10:38:26', '2021-08-27 04:52:28'),
(132, 51, 16, 72, 46, 'Hostflow3', 'male3', 'google3', 'hero3', 'helmet3', NULL, NULL, '2021-08-05 10:38:26', '2021-08-05 10:38:26'),
(133, 51, 16, 72, 46, 'Hostflow4', 'male4', 'google4', 'hero4', 'helmet4', NULL, NULL, '2021-08-05 10:38:26', '2021-08-05 10:38:26'),
(134, 51, 16, 72, 46, 'Hostflow5', 'male5', 'google5', 'hero5', 'helmet5', NULL, NULL, '2021-08-05 10:38:26', '2021-08-05 10:38:26'),
(135, 51, 16, 72, 46, 'Hostflow6', 'male6', 'google6', 'hero6', 'helmet6', NULL, NULL, '2021-08-05 10:38:26', '2021-08-05 10:38:26'),
(136, 51, 16, 72, 46, 'Hostflow7', 'male7', 'google7', 'hero7', 'helmet7', NULL, NULL, '2021-08-05 10:38:26', '2021-08-05 10:38:26'),
(137, 51, 16, 73, 50, 'Hostflow1', 'male1', 'google1', 'hero1', 'helmet1', NULL, NULL, '2021-08-14 04:48:29', '2021-08-14 04:48:29'),
(138, 51, 16, 73, 50, 'Hostflow2', 'male2', 'google2', 'hero2', 'helmet2', NULL, NULL, '2021-08-14 04:48:29', '2021-08-14 04:48:29'),
(139, 51, 16, 73, 50, 'Hostflow3', 'male3', 'google3', 'hero3', 'helmet3', NULL, NULL, '2021-08-14 04:48:29', '2021-08-14 04:48:29'),
(140, 51, 16, 73, 50, 'Hostflow4', 'male4', 'google4', 'hero4', 'helmet4', NULL, NULL, '2021-08-14 04:48:29', '2021-08-14 04:48:29'),
(141, 51, 16, 73, 50, 'Hostflow5', 'male5', 'google5', 'hero5', 'helmet5', NULL, NULL, '2021-08-14 04:48:29', '2021-08-14 04:48:29'),
(142, 51, 16, 73, 50, 'Hostflow6', 'male6', 'google6', 'hero6', 'helmet6', NULL, NULL, '2021-08-14 04:48:29', '2021-08-14 04:48:29'),
(143, 51, 16, 73, 50, 'Hostflow7', 'male7', 'google7', 'hero7', 'helmet7', NULL, NULL, '2021-08-14 04:48:29', '2021-08-14 04:48:29'),
(144, 51, 16, 72, 52, '76768f-r5', 'male1', 'google1', 'hero1', 'helmet1', NULL, NULL, '2021-08-24 10:05:09', '2021-08-24 10:05:09'),
(145, 51, 16, 72, 52, '76768f-r6', 'male2', 'google2', 'hero2', 'helmet2', NULL, NULL, '2021-08-24 10:05:09', '2021-08-24 10:05:09'),
(146, 51, 16, 72, 52, '76768f-r7', 'male3', 'google3', 'hero3', 'helmet3', NULL, NULL, '2021-08-24 10:05:09', '2021-08-24 10:05:09'),
(147, 51, 16, 72, 52, '76768f-r8', 'male4', 'google4', 'hero4', 'helmet4', NULL, NULL, '2021-08-24 10:05:09', '2021-08-24 10:05:09'),
(148, 51, 16, 72, 52, '76768f-r9', 'male5', 'google5', 'hero5', 'helmet5', NULL, NULL, '2021-08-24 10:05:09', '2021-08-24 10:05:09'),
(149, 51, 16, 72, 52, '76768f-r10', 'male6', 'google6', 'hero6', 'helmet6', NULL, NULL, '2021-08-24 10:05:09', '2021-08-24 10:05:09'),
(150, 51, 16, 72, 52, '76768f-r11', 'male7', 'google7', 'hero7', 'helmet7', NULL, NULL, '2021-08-24 10:05:09', '2021-08-24 10:05:09'),
(151, 51, 16, 72, 52, '76768f-r12', 'male8', 'google8', 'hero8', 'helmet8', NULL, NULL, '2021-08-24 10:05:09', '2021-08-24 10:05:09'),
(152, 51, 16, 72, 52, '76768f-r13', 'male9', 'google9', 'hero9', 'helmet9', NULL, NULL, '2021-08-24 10:05:09', '2021-08-24 10:05:09'),
(153, 51, 16, 72, 52, '76768f-r14', 'male10', 'google10', 'hero10', 'helmet10', NULL, NULL, '2021-08-24 10:05:09', '2021-08-24 10:05:09'),
(154, 65, 19, 74, 53, 'opendn2', 'male1', 'google1', 'hero1', 'helmet1', NULL, '1', '2021-08-25 01:54:10', '2021-08-25 02:26:16'),
(155, 65, 19, 74, 53, 'opendn1', 'male2', 'google2', 'hero2', 'helmet2', NULL, NULL, '2021-08-25 01:54:10', '2021-08-25 01:54:10'),
(156, 65, 19, 74, 53, 'opendn3', 'male3', 'google3', 'hero3', 'helmet3', NULL, NULL, '2021-08-25 01:54:10', '2021-08-25 01:54:10'),
(157, 65, 19, 74, 53, 'opendn4', 'male4', 'google4', 'hero4', 'helmet4', NULL, NULL, '2021-08-25 01:54:10', '2021-08-25 01:54:10'),
(158, 65, 19, 74, 53, 'opendn5', 'male5', 'google5', 'hero5', 'helmet5', 'not fit', '0', '2021-08-25 01:54:10', '2021-08-25 02:19:13'),
(159, 65, 19, 74, 53, 'opendn6', 'male6', 'google6', 'hero6', 'helmet6', NULL, '1', '2021-08-25 01:54:10', '2021-08-25 02:19:54'),
(160, 65, 19, 74, 53, 'opendn7', 'male7', 'google7', 'hero7', 'helmet7', NULL, '1', '2021-08-25 01:54:10', '2021-08-25 02:21:29'),
(161, 65, 19, 74, 53, 'opendn8', 'male8', 'google8', 'hero8', 'helmet8', NULL, '1', '2021-08-25 01:54:10', '2021-08-25 02:23:37'),
(162, 65, 19, 74, 53, 'opendn9', 'male9', 'google9', 'hero9', 'helmet9', NULL, '1', '2021-08-25 01:54:10', '2021-08-25 02:25:43'),
(163, 65, 19, 74, 53, 'opendn10', 'male10', 'google10', 'hero10', 'helmet10', NULL, NULL, '2021-08-25 01:54:10', '2021-08-25 01:54:10'),
(164, 65, 19, 74, 53, 'opendn11', 'google10', 'google10', 'google10', 'google10', NULL, NULL, '2021-08-25 01:54:10', '2021-08-25 01:54:10'),
(165, 65, 19, 74, 53, 'opendn12', 'google10', 'google10', 'google10', 'google10', NULL, NULL, '2021-08-25 01:54:10', '2021-08-25 01:54:10');

-- --------------------------------------------------------

--
-- Table structure for table `uploadraw`
--

CREATE TABLE `uploadraw` (
  `id` int(10) UNSIGNED NOT NULL,
  `sku_id` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `uploadraw`
--

INSERT INTO `uploadraw` (`id`, `sku_id`, `filename`, `created_at`, `updated_at`) VALUES
(1, 51, '1.jpeg', '2021-05-02 03:14:38', '2021-05-02 03:14:38'),
(2, 51, '2.jpg', '2021-05-02 03:15:11', '2021-05-02 03:15:11'),
(3, 51, '3.jpg', '2021-05-02 03:15:55', '2021-05-02 03:15:55'),
(4, 53, '1.jpeg', '2021-05-02 12:19:47', '2021-05-02 12:19:47'),
(5, 53, '2.jpg', '2021-05-02 12:19:47', '2021-05-02 12:19:47'),
(6, 53, '3.jpeg', '2021-05-02 12:19:47', '2021-05-02 12:19:47'),
(7, 53, '4.jpg', '2021-05-02 12:27:25', '2021-05-02 12:27:25'),
(8, 53, '5.jpg', '2021-05-02 12:27:27', '2021-05-02 12:27:27'),
(9, 53, '6.jpg', '2021-05-02 12:27:28', '2021-05-02 12:27:28'),
(10, 53, '7.jpg', '2021-05-02 12:27:29', '2021-05-02 12:27:29'),
(11, 53, '8.jpg', '2021-05-02 12:27:30', '2021-05-02 12:27:30'),
(12, 53, '9.jpg', '2021-05-02 12:27:32', '2021-05-02 12:27:32'),
(13, 53, '10.jpg', '2021-05-02 12:27:37', '2021-05-02 12:27:37'),
(14, 90, '1.jpg', '2021-05-02 12:31:42', '2021-05-02 12:31:42'),
(15, 90, '2.jpg', '2021-05-02 12:31:42', '2021-05-02 12:31:42'),
(16, 90, '3.jpg', '2021-05-02 12:31:42', '2021-05-02 12:31:42'),
(17, 90, '4.jpg', '2021-05-02 12:31:42', '2021-05-02 12:31:42'),
(18, 90, '5.jpg', '2021-05-02 12:31:42', '2021-05-02 12:31:42'),
(19, 92, '1.jpg', '2021-05-02 12:58:52', '2021-05-02 12:58:52'),
(20, 92, '2.jpg', '2021-05-02 12:58:52', '2021-05-02 12:58:52'),
(21, 92, '3.jpg', '2021-05-02 12:58:53', '2021-05-02 12:58:53'),
(22, 92, '4.jpg', '2021-05-02 12:58:53', '2021-05-02 12:58:53'),
(23, 92, '5.jpg', '2021-05-02 12:58:53', '2021-05-02 12:58:53'),
(24, 92, '6.jpg', '2021-05-02 12:58:53', '2021-05-02 12:58:53'),
(25, 92, '7.jpg', '2021-05-02 12:58:53', '2021-05-02 12:58:53'),
(26, 92, '8.jpg', '2021-05-02 12:58:53', '2021-05-02 12:58:53'),
(27, 92, '9.jpg', '2021-05-02 12:58:58', '2021-05-02 12:58:58'),
(28, 92, '10.jpg', '2021-05-02 12:58:58', '2021-05-02 12:58:58'),
(29, 92, '11.jpg', '2021-05-02 12:58:59', '2021-05-02 12:58:59'),
(30, 92, '12.jpg', '2021-05-02 12:58:59', '2021-05-02 12:58:59'),
(31, 92, '13.jpg', '2021-05-02 12:59:00', '2021-05-02 12:59:00'),
(32, 92, '14.jpg', '2021-05-02 12:59:00', '2021-05-02 12:59:00'),
(33, 92, '15.jpg', '2021-05-02 12:59:00', '2021-05-02 12:59:00'),
(34, 92, '16.jpg', '2021-05-02 12:59:00', '2021-05-02 12:59:00'),
(35, 97, '1.jpg', '2021-05-03 01:19:28', '2021-05-03 01:19:28'),
(36, 97, '2.jpg', '2021-05-03 01:19:28', '2021-05-03 01:19:28'),
(37, 97, '3.jpg', '2021-05-03 01:19:28', '2021-05-03 01:19:28'),
(38, 97, '4.png', '2021-05-03 01:19:28', '2021-05-03 01:19:28'),
(39, 97, '5.png', '2021-05-03 01:19:41', '2021-05-03 01:19:41'),
(40, 97, '6.png', '2021-05-03 01:19:46', '2021-05-03 01:19:46'),
(41, 97, '7.png', '2021-05-03 01:19:54', '2021-05-03 01:19:54'),
(42, 97, '8.png', '2021-05-03 01:19:54', '2021-05-03 01:19:54'),
(43, 97, '9.png', '2021-05-03 01:19:54', '2021-05-03 01:19:54'),
(44, 43, '1.png', '2021-05-05 00:14:52', '2021-05-05 00:14:52'),
(45, 43, '2.png', '2021-05-05 00:14:52', '2021-05-05 00:14:52'),
(46, 43, '3.png', '2021-05-05 00:14:52', '2021-05-05 00:14:52'),
(47, 51, '1.png', '2021-05-05 00:15:25', '2021-05-05 00:15:25'),
(48, 51, '2.png', '2021-05-05 00:15:25', '2021-05-05 00:15:25'),
(49, 51, '3.png', '2021-05-05 00:15:26', '2021-05-05 00:15:26'),
(50, 54, '1.jpeg', '2021-05-05 00:16:38', '2021-05-05 00:16:38'),
(51, 54, '2.jpg', '2021-05-05 00:16:38', '2021-05-05 00:16:38'),
(52, 54, '3.jpg', '2021-05-05 00:16:38', '2021-05-05 00:16:38'),
(53, 54, '4.jpeg', '2021-05-05 00:16:38', '2021-05-05 00:16:38'),
(54, 54, '5.jpg', '2021-05-05 00:16:38', '2021-05-05 00:16:38'),
(55, 1, '76768f-r5_1.png', '2021-06-28 21:27:17', '2021-06-28 21:27:17'),
(56, 1, '76768f-r5_1.jpeg', '2021-06-29 04:52:36', '2021-06-29 04:52:36'),
(57, 1, '76768f-r5_2.jpeg', '2021-06-29 04:53:12', '2021-06-29 04:53:12'),
(58, 1, '76768f-r5_1.jpeg', '2021-07-02 01:17:59', '2021-07-02 01:17:59'),
(59, 1, '76768f-r5_2.jpeg', '2021-07-02 01:21:36', '2021-07-02 01:21:36'),
(60, 1, '76768f-r5_3.jpeg', '2021-07-02 01:22:39', '2021-07-02 01:22:39'),
(61, 1, '76768f-r5_4.jpg', '2021-07-02 01:22:46', '2021-07-02 01:22:46'),
(62, 1, '76768f-r5_5.jpeg', '2021-07-02 02:02:29', '2021-07-02 02:02:29'),
(63, 1, '76768f-r5_6.jpeg', '2021-07-02 02:04:54', '2021-07-02 02:04:54'),
(64, 1, '76768f-r5_7.jpeg', '2021-07-02 02:06:14', '2021-07-02 02:06:14'),
(65, 1, '76768f-r5_8.jpeg', '2021-07-02 02:11:54', '2021-07-02 02:11:54'),
(66, 84, '76768f-r6_1.jpeg', '2021-07-06 11:39:58', '2021-07-06 11:39:58'),
(67, 84, '76768f-r6_2.jpeg', '2021-07-06 11:39:58', '2021-07-06 11:39:58'),
(68, 84, '76768f-r6_3.png', '2021-07-06 11:39:59', '2021-07-06 11:39:59'),
(69, 87, '76768f-r9_1.jpeg', '2021-07-06 11:50:18', '2021-07-06 11:50:18'),
(70, 87, '76768f-r9_2.jpeg', '2021-07-06 11:50:18', '2021-07-06 11:50:18'),
(71, 87, '76768f-r9_3.jpeg', '2021-07-06 11:50:18', '2021-07-06 11:50:18'),
(72, 87, '76768f-r9_4.jpeg', '2021-07-06 11:50:18', '2021-07-06 11:50:18'),
(73, 115, 'Demo1-3_1.jpeg', '2021-07-09 01:47:48', '2021-07-09 01:47:48'),
(74, 115, 'Demo1-3_2.jpeg', '2021-07-09 01:47:48', '2021-07-09 01:47:48'),
(75, 115, 'Demo1-3_3.jpeg', '2021-07-09 01:47:49', '2021-07-09 01:47:49'),
(76, 115, 'Demo1-3_4.jpeg', '2021-07-09 01:47:49', '2021-07-09 01:47:49'),
(77, 115, 'Demo1-3_5.jpeg', '2021-07-09 01:47:51', '2021-07-09 01:47:51'),
(78, 115, 'Demo1-3_6.jpg', '2021-07-09 01:47:51', '2021-07-09 01:47:51'),
(79, 115, 'Demo1-3_7.jpeg', '2021-07-09 01:51:37', '2021-07-09 01:51:37'),
(80, 116, 'Demo1-4_1.jpeg', '2021-07-09 01:52:55', '2021-07-09 01:52:55'),
(81, 116, 'Demo1-4_2.jpeg', '2021-07-09 01:52:55', '2021-07-09 01:52:55'),
(82, 116, 'Demo1-4_3.jpeg', '2021-07-09 01:52:57', '2021-07-09 01:52:57'),
(83, 116, 'Demo1-4_4.jpeg', '2021-07-09 01:52:57', '2021-07-09 01:52:57'),
(84, 116, 'Demo1-4_5.jpeg', '2021-07-09 01:52:58', '2021-07-09 01:52:58'),
(85, 117, 'Demo1-5_1.jpeg', '2021-07-19 00:40:45', '2021-07-19 00:40:45'),
(86, 117, 'Demo1-5_2.jpeg', '2021-07-19 00:40:45', '2021-07-19 00:40:45'),
(87, 117, 'Demo1-5_3.jpeg', '2021-07-19 00:40:47', '2021-07-19 00:40:47'),
(88, 117, 'Demo1-5_4.jpeg', '2021-07-19 00:40:47', '2021-07-19 00:40:47'),
(89, 62, '76768f-r14_1.jpg', '2021-07-27 01:24:51', '2021-07-27 01:24:51'),
(90, 62, '76768f-r14_2.jpg', '2021-07-27 01:24:59', '2021-07-27 01:24:59'),
(91, 62, '76768f-r14_3.jpg', '2021-07-27 01:25:04', '2021-07-27 01:25:04'),
(92, 62, '76768f-r14_4.jpeg', '2021-07-27 01:25:18', '2021-07-27 01:25:18'),
(93, 62, '76768f-r14_5.jpg', '2021-07-27 01:25:18', '2021-07-27 01:25:18'),
(94, 62, '76768f-r14_6.jpg', '2021-07-27 01:25:19', '2021-07-27 01:25:19'),
(95, 62, '76768f-r14_7.jpg', '2021-07-27 01:25:25', '2021-07-27 01:25:25'),
(96, 62, '76768f-r14_8.jpg', '2021-07-27 01:25:25', '2021-07-27 01:25:25'),
(97, 62, '76768f-r14_9.jpeg', '2021-07-27 01:25:27', '2021-07-27 01:25:27'),
(98, 63, '76768f-r5_1.png', '2021-07-27 01:26:08', '2021-07-27 01:26:08'),
(99, 63, '76768f-r5_2.jpeg', '2021-07-27 01:26:08', '2021-07-27 01:26:08'),
(100, 63, '76768f-r5_3.jpeg', '2021-07-27 01:26:08', '2021-07-27 01:26:08'),
(101, 63, '76768f-r5_4.jpeg', '2021-07-27 01:26:08', '2021-07-27 01:26:08'),
(102, 63, '76768f-r5_5.jpeg', '2021-07-27 01:26:09', '2021-07-27 01:26:09'),
(103, 62, '76768f-r14_10.png', '2021-07-27 01:26:56', '2021-07-27 01:26:56'),
(104, 116, 'Demo1-4_1.jpeg', '2021-07-27 11:24:39', '2021-07-27 11:24:39'),
(105, 116, 'Demo1-4_2.jpeg', '2021-07-27 11:24:39', '2021-07-27 11:24:39'),
(106, 116, 'Demo1-4_3.jpeg', '2021-07-27 11:24:39', '2021-07-27 11:24:39'),
(107, 116, 'Demo1-4_4.png', '2021-07-27 11:24:39', '2021-07-27 11:24:39'),
(108, 116, 'Demo1-4_5.jpeg', '2021-07-27 11:24:40', '2021-07-27 11:24:40'),
(109, 116, 'Demo1-4_6.jpeg', '2021-07-27 11:24:41', '2021-07-27 11:24:41'),
(110, 116, 'Demo1-4_7.jpeg', '2021-07-27 11:24:41', '2021-07-27 11:24:41'),
(111, 116, 'Demo1-4_8.jpeg', '2021-07-27 11:24:41', '2021-07-27 11:24:41'),
(112, 116, 'Demo1-4_9.png', '2021-07-27 11:24:41', '2021-07-27 11:24:41'),
(113, 116, 'Demo1-4_10.jpeg', '2021-07-27 11:24:42', '2021-07-27 11:24:42'),
(114, 115, 'Demo1-3_1.jpeg', '2021-07-27 11:24:51', '2021-07-27 11:24:51'),
(115, 115, 'Demo1-3_2.jpeg', '2021-07-27 11:24:51', '2021-07-27 11:24:51'),
(116, 115, 'Demo1-3_3.jpeg', '2021-07-27 11:24:52', '2021-07-27 11:24:52'),
(117, 115, 'Demo1-3_4.png', '2021-07-27 11:24:52', '2021-07-27 11:24:52'),
(118, 115, 'Demo1-3_5.jpeg', '2021-07-27 11:24:52', '2021-07-27 11:24:52'),
(119, 126, '76768f-r11_1.png', '2021-07-28 02:36:11', '2021-07-28 02:36:11'),
(120, 126, '76768f-r11_2.jpeg', '2021-07-28 02:36:23', '2021-07-28 02:36:23'),
(121, 126, '76768f-r11_3.jpeg', '2021-07-28 02:36:23', '2021-07-28 02:36:23'),
(122, 126, '76768f-r11_4.jpeg', '2021-07-28 02:36:24', '2021-07-28 02:36:24'),
(123, 126, '76768f-r11_5.jpeg', '2021-07-28 02:36:24', '2021-07-28 02:36:24'),
(124, 126, '76768f-r11_6.jpeg', '2021-07-28 02:36:25', '2021-07-28 02:36:25'),
(125, 126, '76768f-r11_7.jpeg', '2021-07-28 02:36:25', '2021-07-28 02:36:25'),
(126, 126, '76768f-r11_8.png', '2021-07-28 02:37:51', '2021-07-28 02:37:51'),
(127, 126, '76768f-r11_9.jpeg', '2021-07-28 02:37:51', '2021-07-28 02:37:51'),
(128, 127, '76768f-r12_1.jpeg', '2021-07-28 02:38:24', '2021-07-28 02:38:24'),
(129, 127, '76768f-r12_2.jpeg', '2021-07-28 02:38:24', '2021-07-28 02:38:24'),
(130, 127, '76768f-r12_3.jpeg', '2021-07-28 02:38:25', '2021-07-28 02:38:25'),
(131, 127, '76768f-r12_4.png', '2021-07-28 02:38:25', '2021-07-28 02:38:25'),
(132, 127, '76768f-r12_5.jpeg', '2021-07-28 02:38:26', '2021-07-28 02:38:26'),
(133, 127, '76768f-r12_6.jpeg', '2021-07-28 02:38:26', '2021-07-28 02:38:26'),
(134, 127, '76768f-r12_7.jpeg', '2021-07-28 02:38:26', '2021-07-28 02:38:26'),
(135, 127, '76768f-r12_8.jpeg', '2021-07-28 02:38:26', '2021-07-28 02:38:26'),
(136, 127, '76768f-r12_9.png', '2021-07-28 02:38:27', '2021-07-28 02:38:27'),
(137, 127, '76768f-r12_10.jpeg', '2021-07-28 02:38:27', '2021-07-28 02:38:27'),
(138, 128, '76768f-r13_1.jpeg', '2021-07-28 02:38:45', '2021-07-28 02:38:45'),
(139, 128, '76768f-r13_2.jpeg', '2021-07-28 02:38:45', '2021-07-28 02:38:45'),
(140, 128, '76768f-r13_3.jpg', '2021-07-28 02:38:45', '2021-07-28 02:38:45'),
(141, 129, '76768f-r14_1.png', '2021-07-28 02:38:58', '2021-07-28 02:38:58'),
(142, 129, '76768f-r14_2.jpeg', '2021-07-28 02:38:58', '2021-07-28 02:38:58'),
(143, 129, '76768f-r14_3.png', '2021-07-28 02:38:58', '2021-07-28 02:38:58'),
(144, 129, '76768f-r14_4.png', '2021-07-28 02:38:58', '2021-07-28 02:38:58'),
(145, 129, '76768f-r14_5.png', '2021-07-28 02:38:59', '2021-07-28 02:38:59'),
(146, 129, '76768f-r14_6.jpeg', '2021-07-28 02:38:59', '2021-07-28 02:38:59'),
(147, 125, '76768f-r10_1.png', '2021-07-29 06:18:39', '2021-07-29 06:18:39'),
(148, 125, '76768f-r10_2.jpeg', '2021-07-29 06:18:39', '2021-07-29 06:18:39'),
(149, 125, '76768f-r10_3.jpeg', '2021-07-29 06:18:39', '2021-07-29 06:18:39'),
(150, 125, '76768f-r10_4.jpeg', '2021-07-29 06:18:39', '2021-07-29 06:18:39'),
(151, 125, '76768f-r10_5.jpeg', '2021-07-29 06:18:40', '2021-07-29 06:18:40'),
(152, 30, '76768f-r8_1.jpg', '2021-08-20 04:53:06', '2021-08-20 04:53:06'),
(153, 30, '76768f-r8_2.jpg', '2021-08-20 04:53:06', '2021-08-20 04:53:06'),
(154, 50, '76768f-r12_1.jpg', '2021-08-20 04:53:33', '2021-08-20 04:53:33'),
(155, 50, '76768f-r12_2.jpg', '2021-08-20 04:53:33', '2021-08-20 04:53:33'),
(156, 50, '76768f-r12_3.jpg', '2021-08-20 04:53:34', '2021-08-20 04:53:34'),
(157, 159, 'opendn6_1.jpg', '2021-08-25 02:20:30', '2021-08-25 02:20:30'),
(158, 159, 'opendn6_2.jpg', '2021-08-25 02:20:33', '2021-08-25 02:20:33'),
(159, 159, 'opendn6_3.jpg', '2021-08-25 02:20:40', '2021-08-25 02:20:40'),
(160, 159, 'opendn6_4.jpg', '2021-08-25 02:20:40', '2021-08-25 02:20:40'),
(161, 159, 'opendn6_5.jpg', '2021-08-25 02:20:41', '2021-08-25 02:20:41'),
(162, 159, 'opendn6_6.jpg', '2021-08-25 02:20:41', '2021-08-25 02:20:41'),
(163, 159, 'opendn6_7.jpg', '2021-08-25 02:20:45', '2021-08-25 02:20:45'),
(164, 159, 'opendn6_8.jpg', '2021-08-25 02:20:45', '2021-08-25 02:20:45'),
(165, 159, 'opendn6_9.jpg', '2021-08-25 02:20:45', '2021-08-25 02:20:45'),
(166, 160, 'opendn7_1.jpg', '2021-08-25 02:21:40', '2021-08-25 02:21:40'),
(167, 160, 'opendn7_2.jpg', '2021-08-25 02:21:40', '2021-08-25 02:21:40'),
(168, 160, 'opendn7_3.jpg', '2021-08-25 02:21:41', '2021-08-25 02:21:41'),
(169, 160, 'opendn7_4.jpg', '2021-08-25 02:21:41', '2021-08-25 02:21:41'),
(170, 160, 'opendn7_5.jpg', '2021-08-25 02:21:42', '2021-08-25 02:21:42'),
(171, 160, 'opendn7_6.jpg', '2021-08-25 02:21:42', '2021-08-25 02:21:42'),
(172, 160, 'opendn7_7.jpg', '2021-08-25 02:21:42', '2021-08-25 02:21:42'),
(173, 160, 'opendn7_8.jpg', '2021-08-25 02:21:43', '2021-08-25 02:21:43'),
(174, 160, 'opendn7_9.jpg', '2021-08-25 02:21:43', '2021-08-25 02:21:43'),
(175, 160, 'opendn7_10.jpg', '2021-08-25 02:21:43', '2021-08-25 02:21:43'),
(176, 161, 'opendn8_1.jpg', '2021-08-25 02:23:56', '2021-08-25 02:23:56'),
(177, 161, 'opendn8_2.jpg', '2021-08-25 02:23:56', '2021-08-25 02:23:56'),
(178, 161, 'opendn8_3.jpg', '2021-08-25 02:23:57', '2021-08-25 02:23:57'),
(179, 161, 'opendn8_4.jpg', '2021-08-25 02:23:57', '2021-08-25 02:23:57'),
(180, 161, 'opendn8_5.jpg', '2021-08-25 02:23:57', '2021-08-25 02:23:57'),
(181, 161, 'opendn8_6.jpg', '2021-08-25 02:23:57', '2021-08-25 02:23:57'),
(182, 161, 'opendn8_7.jpg', '2021-08-25 02:23:58', '2021-08-25 02:23:58'),
(183, 161, 'opendn8_8.jpg', '2021-08-25 02:23:58', '2021-08-25 02:23:58'),
(184, 161, 'opendn8_9.jpg', '2021-08-25 02:23:58', '2021-08-25 02:23:58'),
(185, 161, 'opendn8_10.jpg', '2021-08-25 02:23:58', '2021-08-25 02:23:58'),
(186, 162, 'opendn9_1.jpg', '2021-08-25 02:25:49', '2021-08-25 02:25:49'),
(187, 162, 'opendn9_2.jpg', '2021-08-25 02:25:49', '2021-08-25 02:25:49'),
(188, 162, 'opendn9_3.jpg', '2021-08-25 02:25:51', '2021-08-25 02:25:51'),
(189, 154, 'opendn2_1.jpg', '2021-08-25 02:26:25', '2021-08-25 02:26:25'),
(190, 154, 'opendn2_2.jpg', '2021-08-25 02:26:25', '2021-08-25 02:26:25'),
(191, 154, 'opendn2_3.jpg', '2021-08-25 02:26:26', '2021-08-25 02:26:26'),
(192, 154, 'opendn2_4.jpg', '2021-08-25 02:26:26', '2021-08-25 02:26:26'),
(193, 154, 'opendn2_5.jpg', '2021-08-25 02:26:27', '2021-08-25 02:26:27'),
(194, 103, '76768f-r5_1.jpg', '2021-08-27 04:50:31', '2021-08-27 04:50:31'),
(195, 104, '76768f-r6_1.jpg', '2021-08-27 04:50:45', '2021-08-27 04:50:45'),
(196, 131, 'Hostflow2_1.jpg', '2021-08-27 04:52:36', '2021-08-27 04:52:36'),
(197, 130, 'Hostflow1_1.jpg', '2021-08-27 04:52:50', '2021-08-27 04:52:50'),
(198, 118, 'Demo1-6_1.jpg', '2021-08-27 04:53:12', '2021-08-27 04:53:12'),
(199, 119, 'Demo1-7_1.jpg', '2021-08-27 04:53:41', '2021-08-27 04:53:41'),
(200, 119, 'Demo1-7_2.jpg', '2021-08-27 04:53:41', '2021-08-27 04:53:41'),
(201, 119, 'Demo1-7_3.jpg', '2021-08-27 04:53:43', '2021-08-27 04:53:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(20) UNSIGNED NOT NULL,
  `client_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `am_email` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active_status` tinyint(1) NOT NULL DEFAULT '0',
  `dark_mode` tinyint(1) NOT NULL DEFAULT '0',
  `messenger_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#2180f3',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatar.png',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `c_short` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Gst_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verifyToken` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_status` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatar.jpg',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `client_id`, `name`, `email`, `am_email`, `active_status`, `dark_mode`, `messenger_color`, `avatar`, `email_verified_at`, `password`, `phone`, `Address`, `Company`, `c_short`, `Gst_number`, `verifyToken`, `verification_status`, `status`, `photo`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'ODN001', 'Super Sm', 'syedzair96@gmail.com', NULL, 0, 0, '#673AB7', '0278f50f-1627-49d6-88c5-9d6c76019a50.jpg', NULL, '$2y$10$Xx9ML2HO49YUsgx6vD.iNuW3r/BEEcJ1MVGQFk9LG0KpN5oSOK9T2', '7838563793', 'tyhgbgb vb hgdhgbfbtyhrdtfgb', 'Odn Digital | innovative content Creators', 'ON', '6324dgvjxcsart45 fcuk', NULL, 1, 1, '1615383375.jpg', '1P4D5tzwYJa8fmV66xwKXu7YMZDaYDamZoDUz10UkLjQLNsaANSRjpinZe4Q', '2021-01-25 03:14:45', '2021-08-24 09:10:34', NULL),
(3, 'ODN002', 'Ayan', 'ayan.a@odndigital.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$Eq1uwtWuMnCTxRRGDXbG6.u.7tjq66cdjKF0l7Q47yLXGI/..6mG6', '9910456957', 'Heritage Max', 'ODN Digital', 'ON1', 'None', NULL, 1, 1, 'avatar.jpg', NULL, '2021-01-25 03:21:32', '2021-01-25 07:57:37', NULL),
(5, 'ODN0812', 'Nishant', 'nishant.kumar@odndigital.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$n0l2Ow9V0saRgvJ89J2OQ.tODUaHK2f2.o1GttYcl9aKCQvTn8Dr6', '098765432', 'ASJKH', 'odn', 'NOD', 'ASKJ098JHBNAS', NULL, 1, 1, '1611819934.jpg', NULL, '2021-01-27 01:38:39', '2021-02-22 03:53:04', NULL),
(6, 'ODN_003', 'Hussnain', 'hasnain.b@odndigital.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$HxUqERR2b1EDkVQ4sBRj5uEsFVWZhfF1EnPnw2XjyHgmIRhCrwRPq', '0987654321', 'NONE', 'ODN', 'MD', 'NONE', 'j1mhkkAoGAntwLsGTeiyg6lTQLmoHf1CXcfog7Ib', NULL, 1, 'avatar.jpg', NULL, '2021-01-28 00:24:44', '2021-02-22 03:52:58', NULL),
(7, 'Odn_004', 'Neetu Bansal', 'accounts@odndigital.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$aZAnI0w8dPvepRqyWmAXde48ieYxy0awBiajB0D4MeUD2BeRkxj/K', '0987654321', 'None', 'NONE', 'HD', 'none', 'FtKna5SxkfopKDCyDGhpw31PoFisNF1kpDVM7y3B', NULL, 1, 'avatar.jpg', NULL, '2021-01-28 06:13:07', '2021-02-22 03:49:17', NULL),
(9, 'ODN_006', 'Kumar Udaar', 'kumar.udaar@odndigital.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$GahO6S71v2yEgj58ll4IS.tbgyyzEHyuTB59SHpSE9uX4dbt227oi', '0987654321', 'None', 'ODN', 'TH', 'None', NULL, 1, 1, 'avatar.jpg', NULL, '2021-01-28 06:17:05', '2021-02-22 03:49:07', NULL),
(10, 'ODN_007', 'Nr Mahajan', 'narinder.mahajan@odndigital.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$z7B/hpHXtUSCZj7hZGIIO.aR/aTGUPR3zBwmla37zDR1hkxSsj2bS', '0912987762', 'None', 'ODN', 'WG', 'None', NULL, 1, 1, 'avatar.jpg', NULL, '2021-01-28 06:22:11', '2021-02-22 03:48:38', NULL),
(11, 'ODN_008', 'narendra kumar', 'narendrakumarodndigital@gmail.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$C3ibWriZ6JMtg0JC6X8OJ.lSGdpzhCbPm1OgIIeay5pCVwkNeYAVm', '0865654232', 'NONE', 'ODN', 'MJ', 'NONE', 'MWCSVGotx98LjXtIz5hCFFx5TZgwc6vcjB6hr4vh', NULL, 1, 'avatar.jpg', NULL, '2021-01-28 06:34:44', '2021-02-22 03:48:21', NULL),
(12, 'ODN_0010', 'Vanjul', 'vanjul.a@odndigital.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$ShX5iYtPIqEzFvEk1uUCEuHnQfX.B6ROIa9K.WaxhpQXiwQzPZEN.', '0987543271', 'NONE', 'ODN', 'TFG', 'NONE', '7kyiwhKsPETOoBwT6pt4SDh4ei24uEmx8h18P3zm', NULL, 1, 'avatar.jpg', NULL, '2021-01-28 06:36:32', '2021-02-09 02:38:30', '2021-02-09 02:38:30'),
(13, 'ODN_0011', 'Vanjul', 'vanjul.avqc@odndigital.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$h56c8EBxQTU35KFILcueVuLcuj3anH5CuLnbP91TCB4xz7KM8XXSO', '0982673232', 'NONE', 'ODN', 'RGK', 'NONE', 'yTUjiUEJ15x6BgT8VNaHkrAy7PHPunbBElvAoZF9', NULL, 1, 'avatar.jpg', NULL, '2021-01-28 06:37:54', '2021-02-22 01:50:08', NULL),
(14, 'ODN_0012', 'Sandeep', 'sandeep.n@odndigital.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$fU/KFCpfM3z8R/vvJxn50.asui1kdsLsB/pp5lPyvSvxkR4EtJAnW', '098963234', 'NONE', 'ODN', 'YH', 'NONE', 'nhJR7OnqfWJ2u5i4M058xqsP1ffYsRsGL25RtejR', NULL, 1, 'avatar.jpg', NULL, '2021-01-28 06:39:28', '2021-01-28 06:39:28', NULL),
(15, 'ODN_0013', 'Keshav', 'studio@odndigital.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$YxUHH/Rtme7ylcgtQmkPx.hLC9k0LOcr3Umt4NG0v3X6CalDul.dy', '9072786324', 'NONE', 'ODN', 'JN', 'NONE', 'DFeXn8zupTbegBAxySC3Me9snIq1yoOiOGaXJe96', NULL, 1, 'avatar.jpg', NULL, '2021-01-28 06:43:46', '2021-01-28 06:43:46', NULL),
(16, 'Odn_0014', 'Astha', 'aastha.m@odndigital.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$fnQuWaP9qWqKPYuKYxXMpuT.qEaR1q/WBScKQ0qzRDuq5Zf.K2GpO', '873257898', 'NONE', 'ODN', 'KL', 'NONE', 'IhJrT3w5tCwX0cm0tOxVsImaFhXeUAf7VapIgSxm', NULL, 1, 'avatar.jpg', NULL, '2021-01-28 06:55:32', '2021-02-21 02:36:27', NULL),
(17, 'ODN_012', 'hina', 'hina.n@gmail.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$ML8kjq6lY7WsgHw3.ubGeev70eC4Ihu8VOAkNcFCc/h1nQO0sR/P6', '987238646', 'NONE', 'odn digital', 'YH', 'NONE', '6NalWeAn6gU8cIMJEZjZtXzOqaIp7SWk91dx5qgM', NULL, 1, 'avatar.jpg', NULL, '2021-02-09 02:48:05', '2021-02-12 01:25:39', '2021-02-12 01:25:39'),
(18, 'odn_98721', 'Kamkshi', 'kamakshi.a@odndigital.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$UCQS78GcPv1m7xJahQLhOulkPOqzGvPv.LoaWBSNOJi7Jh4O0u1a2', '0897233284', 'NOne', 'odn Digital', 'RG', 'None', NULL, 1, 1, 'avatar.jpg', NULL, '2021-02-22 06:05:48', '2021-02-23 09:15:22', NULL),
(20, 'odn2213', 'Zuhair', 'Zuhair@gmail.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$.G/T.CoXUtX4sBDLZGNdBuI.sucLBr8R1ksCjkG8BUET1HqKsxfLW', '7838563793', 'asj', 'odn', NULL, 'None', 'iPKoBvUqXn6TIDF1eCv4Za1yU9HICCm3idUJx1Kk', NULL, 1, 'avatar.jpg', NULL, '2021-02-25 04:32:42', '2021-02-25 04:32:42', NULL),
(21, 'Odn_29103', 'ZAIRRQW', 'smzair123@gmail.com', NULL, 1, 1, '#2196F3', 'fa64c976-4c87-40de-96ff-e8938a82fb49.jpg', NULL, '$2y$10$b3yUJT80IqYYBn2EpBEYLO114GiffXdxY5zUGe2rHD.doRppKDm7K', 'NOne', 'j-3/17 murti wali gali', 'NOne', NULL, 'None', 'eogGB7zREbBIcnI8JlutCA5BXkIYI5SzadcyA1Bi', NULL, 1, 'avatar.jpg', NULL, '2021-02-25 04:35:28', '2021-05-05 00:06:27', NULL),
(22, 'ODN_0122', 'SDGB', 'sdvd@gmail.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$jE//5d8/PsFWwQ/lixMcsOOrm6Sw/TUvf0Uh2VkkwSsMnIDnJrYPe', 'none', 'J-3hehd', 'none', NULL, 'none', 'sJYRpn4zAFfXWfZ8PLBgiC1pmsFXbYzqkoNvfnfq', NULL, 1, 'avatar.jpg', NULL, '2021-02-25 04:45:15', '2021-02-25 04:45:15', NULL),
(23, 'Odn_129', 'Prerit', 'prerit@gmail.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$70GqzSdmSCPQFTQR.nDqH./7a.CdhliLMrmjCokszR6tbKrZEdXua', '0987654322', 'None', 'Misree', 'MS', 'None', 'Aslt8acsXYTkmkfcI8MKaIdufQWijgpHdBR6u4CI', NULL, 1, 'avatar.jpg', NULL, '2021-02-26 00:09:53', '2021-02-26 00:35:58', NULL),
(26, 'Odn_9828', 'sahil', 'sahilmohammad91@gmail.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, 'd6fb7a49346575eb27073943df60f492', '7838563793', 'None', 'wEBp', 'WP', 'nONE', 'VgKXQ1dQnj1lqnnFMAhnMO3982BfTxuAx88CkpnA', NULL, 1, 'avatar.jpg', NULL, '2021-02-27 06:26:38', '2021-02-27 06:26:38', NULL),
(29, 'Odn_0007', 'Prerit', 'prrtsingh1@gmail.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, 'qxVp6OHm', '987654321', 'None', 'Amazon', 'AZ', 'None', 'BAsxSMDi4CZNtOyDPBOY4yiHEmAuhu3BCfzX5Oqb', NULL, 1, 'avatar.jpg', NULL, '2021-03-02 07:00:05', '2021-03-02 07:00:05', NULL),
(49, 'ODN-2913', 'Fthrq', 'treesthe01@gmail.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, 'eyJpdiI6IlJSMXJoR20yZC9obzBZYU1tdFdNcVE9PSIsInZhbHVlIjoiSTRXR0duMElzQmhkaE5qTXdDcXg5QT09IiwibWFjIjoiNjRmYmRkNjViOTU5OTYxODhiMWMxMjI4M2Q2ZWE0Y2U0NGJmNGM2YjAzZmI2MGMxODFiYzJkYTZkM2M3ZGRkNiJ9', '8763224378', 'NONE', 'TEEQ', 'THF', 'NONE', '8BDvBtLqo5LY366vxoY479D0o0weOWWK4HFwZH7V', NULL, 1, 'avatar.jpg', NULL, '2021-03-30 03:08:42', '2021-03-30 03:08:42', NULL),
(50, 'Demo', 'Demo', 'demo@gmail.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$qud/xLbfl2T9T3F7h41BneP/n2O7.EfizXqrQqUSevPrgQSw/3YkS', '987612532', 'demo', 'Demo', 'DEMO', 'demo', 'rZJJ3iRNLVn4qYQcMoUO2wbAUfbHFFzaHrgLxKSA', NULL, 1, 'avatar.jpg', NULL, '2021-07-07 06:03:54', '2021-07-07 06:03:54', NULL),
(51, 'Demo1', 'Demo1', 'Demo1@gmail.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$9mhanWNTT2CJwbuwWpchSOe860EyDAqEKd/3OWruz2Yb.wtlxM3pi', '07838563793', 'Demo1', 'Demo1', 'DEMO1', 'Demo1', 'L5Bq0ogEXiOkul93yyHw8uUwv6aW4wOX51sooLMe', NULL, 1, 'avatar.jpg', NULL, '2021-07-09 00:50:08', '2021-07-09 00:50:08', NULL),
(52, 'commercial@ODN', 'commercial', 'commercial@odndigital.com', NULL, 1, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$oiFGBxLbhfqYMlIsdDTyLOlQFdCaYT193eKjstnv0.2SgsVmIKqhi', '0987654321', 'none', 'ODN', 'ONM', 'none', 'fz94JZgmnAJliuCyJfdvPL4KCVgTRIcFMm0OliO4', NULL, 1, 'avatar.jpg', NULL, '2021-07-27 00:43:50', '2021-08-06 06:08:05', NULL),
(53, 'inward@ODN', 'inwarding', 'inward@odndigital.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$ZrOxs7dkXkd5vqsNOK5n2O2ZZmlr1Hg75OUheL/QwyrsH1wkBwA6K', '0987654321', 'none', 'none', 'ODNM', 'none', 'pW6V6HPoz3sySMWRhy6fF90W8GVjpwSEy2iTENtE', NULL, 1, 'avatar.jpg', NULL, '2021-07-27 00:46:07', '2021-07-27 00:46:07', NULL),
(54, 'AM@ODN', 'AM', 'am@odndigital.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$wtvkNHsv292xqUGUPvvUeemY6vdxpq1sJQbvEDfvUjdixkVAMbgd.', '0987654321', 'NONE', 'NONE', 'OFFN', 'NONE', 'cNJ2TNdZdkWuFiQZH8Oyv9B25r5Td9R26Jwtmb0t', NULL, 1, 'avatar.jpg', NULL, '2021-07-27 00:46:49', '2021-07-27 00:46:49', NULL),
(55, 'Admin@ODN', 'Admin', 'admin@odndigital.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$P.Wu1jLSPVyPqNwtO8Wm3eL0SovFRNR7xaRzjE1weNYegWgacsSuq', '0987654321', 'NONE', 'NOne', 'odnmf', 'none', 'CsjuiyFkekFENAs8dxiz2wKNm549tao73lu628YJ', NULL, 1, 'avatar.jpg', NULL, '2021-07-27 00:47:48', '2021-07-27 00:47:48', NULL),
(56, 'ETL@ODN', 'editor', 'editortl@odndigital.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$Fdaz5a1QBKE.03Ihw4Nog.eWLYrwS4OR0Dc.X1HtOSUqNOOJ.DbP.', '0987654321', 'NONE', 'NONE', 'DONJD', 'NONE', 'qUSmN2s14bdGVmNclfsV9OZSHS9Sg6T4JMkiYdd0', NULL, 1, 'avatar.jpg', NULL, '2021-07-27 00:48:47', '2021-07-27 00:48:47', NULL),
(57, 'QC@ODN', 'QC', 'qc@odndigital.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$ss6RhdzK9VHjQhy.51Aw0OzXPz.rSZkgRWNUAFFRKJBPszfmkOxWW', '0987654321', 'NONE', 'NONE', 'ODNE', 'NONE', 'w7cLBRAxgNR36vb8Xk8WJmBRKVsIJa95xZOrvBLs', NULL, 1, 'avatar.jpg', NULL, '2021-07-27 00:50:13', '2021-07-27 00:50:13', NULL),
(58, 'Editor@ODN', 'Editor', 'editor@odndigigtal.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$lR2oxYnRbQny.MXBXVxmw.IU0OdMK.VZCz73zZWJ8pE.g14j5ORTO', '098764321', 'NONE', 'NONE', 'OKHB', 'NONE', 'SraxH9pNuCXsHUjuYm4EXECMJcb5t1Ma5HjTMuVH', NULL, 1, 'avatar.jpg', NULL, '2021-07-27 00:50:57', '2021-07-27 00:50:57', NULL),
(59, 'Studio@ODN', 'STUDIO', 'studioupload@odndigital.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$IPbHcAifVeE8oTBY/CJ9KeItgnGuukWjhh0HlN3wp6HPObGAGu82e', '0987654321', 'none', 'none', 'NDIHF', 'none', '5p2DO1DjlYJfW74QERaOzncYOWbDmZixTuUiepXA', NULL, 1, 'avatar.jpg', NULL, '2021-07-27 00:52:10', '2021-07-27 00:52:10', NULL),
(60, 'ODN', 'syed', 'sye@gmail.com', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$ZKs6ijk6KnthYrNwt6bHNetBCrk/FKZtaaMd7A4VUrIb5fHdAZGZS', '0987651243', NULL, 'odn', 'ODN', NULL, 'ge32IFiOShIQHyxfNiNtKE49yVw8aGkgU5IbbUae', NULL, 1, 'avatar.jpg', NULL, '2021-07-27 10:42:32', '2021-07-27 10:42:32', NULL),
(61, 'WAOIDNS', 'jn', 'Sfb@GMAIL.COM', NULL, 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$3kCQYSjN.QfS8gSKpmMTu.YcoX5sOmOR6pSeMdsX7Mb7d5Gv6JKWO', '9823R724', NULL, 'ADBSB', 'SDBUSDF', NULL, '9fiqcmvzrRPDfqq9IlpgPCPrfi5itK45qYgzH4OB', NULL, 1, 'avatar.jpg', NULL, '2021-07-27 10:48:53', '2021-07-27 10:48:53', NULL),
(62, 'hui87', 'jhgv', 'nn@gmail.com', 'ayan.a@odndigital.com', 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$G6Tmz7ntgTPEVBJQW3ZjMeAyTdMJtc4IB2hnw873RObJlCpWW2dUy', '0908786543421', 'hgf', 'hihu', 'hn', '09iu8y7tftij', 'ulHjUndJM1WmRmXVE2rrOlDj4at7nNkwJLyiSknv', NULL, 1, 'avatar.jpg', NULL, '2021-08-05 12:16:20', '2021-08-05 12:36:29', NULL),
(63, '82hend`', 'HELLO', 'smzair@gmail.com', 'kamakshi.a@odndigital.com', 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$dtwgVBNKK73uH7BlLRrEluHhAuLO7CcrDwDRnoH2qCjjcOgngQZPq', '9876543210', 'NJDKSC X', 'THSN', 'UHEIHD', 'SD JCX', 'do4OzAXgdOHGFPh1WGYS1ETTpiK4JOSfuw98yMVe', NULL, 1, 'avatar.jpg', NULL, '2021-08-09 04:13:51', '2021-08-09 04:17:42', NULL),
(64, '89wyhdscb', 'UEHIF', 'CS@gmail.com', 'am@odndigital.com', 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$Tj7vTy1n9iDXcol4gHA8D.fXWTDuHYL1iiCcoqbH1E.vU2r3Tq3ie', '0987654321', 'shcxui892', 'oF', 'NDV', '09u8y7ghbjkvg', '1mJ2jkJ5cDkTMslDkbX0pzb41d80jrZaaVBs2wHu', NULL, 1, 'avatar.jpg', NULL, '2021-08-09 04:15:39', '2021-08-09 04:17:20', '2021-08-09 04:17:20'),
(65, 'ODN9834', 'Vishal', 'vishal@gmail.com', 'aastha.m@odndigital.com', 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$rImEiXfhzJYZgdPl2n0ale0NTiq6RPko5MLHupMZq1MpFeQQ/Zkki', '0987654321', 'none', 'Opendn', 'OP', 'none', 'NV7NaY951v7IrkWmQBOEdbCvAHwA6rFAInvXtg9k', NULL, 1, 'avatar.jpg', NULL, '2021-08-25 01:41:44', '2021-08-25 01:41:44', NULL),
(66, 'bs82e', 'bbnh', 'nh@gmail.com', 'kamakshi.a@odndigital.com', 0, 0, '#2180f3', 'avatar.png', NULL, '$2y$10$M8QnEksuDOPAogHxXDh0h.saK30cn4rWH40zreKIHvzRBJ7kY7xv.', '0987865123', 'wdbajs', 'Syed', 'SD', 'sdjbc', 'MFqKuIWWeE6oKgH7LpfP6jLzaRMglqtgsl5TFGrk', NULL, 1, 'avatar.jpg', NULL, '2021-08-28 08:29:31', '2021-08-28 08:29:31', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wrc`
--

CREATE TABLE `wrc` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `brand_id` int(255) DEFAULT NULL,
  `lot_id` int(10) UNSIGNED NOT NULL,
  `wrc_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commercial_id` int(11) NOT NULL,
  `wrc_c` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wrc`
--

INSERT INTO `wrc` (`id`, `user_id`, `brand_id`, `lot_id`, `wrc_id`, `commercial_id`, `wrc_c`, `status`, `created_at`, `updated_at`) VALUES
(7, 12, 11, 51, 'AZGOES51-A', 16, NULL, NULL, '2021-03-08 03:22:46', '2021-03-08 03:22:46'),
(8, 23, 22, 49, 'BFBUES49-A', 10, NULL, NULL, '2021-03-08 03:27:58', '2021-03-08 03:27:58'),
(10, 32, 8, 49, 'BFBUCA53-A', 9, NULL, NULL, '2021-03-08 03:32:34', '2021-03-08 03:32:34'),
(12, 8, 9, 51, 'AZGOES51-B', 16, NULL, NULL, '2021-03-08 03:43:31', '2021-03-08 03:43:31'),
(13, 9, 12, 51, 'AZGOES51-C', 17, NULL, NULL, '2021-03-08 03:49:36', '2021-03-08 03:49:36'),
(14, 4, 2, 51, 'AZGOES51-D', 17, NULL, NULL, '2021-03-08 03:50:29', '2021-03-08 03:50:29'),
(15, 12, 3, 51, 'AZGOES51-E', 17, NULL, NULL, '2021-03-08 03:51:53', '2021-03-08 03:51:53'),
(16, 3, 5, 51, 'AZGOES51-F', 17, NULL, NULL, '2021-03-08 03:54:58', '2021-03-08 03:54:58'),
(18, NULL, NULL, 51, 'AZGOES51-G', 16, NULL, NULL, '2021-03-08 03:55:55', '2021-03-08 03:55:55'),
(19, NULL, NULL, 51, 'AZGOES51-H', 17, NULL, NULL, '2021-03-08 04:27:38', '2021-03-08 04:27:38'),
(20, NULL, NULL, 49, 'BFBUES49-C', 11, NULL, NULL, '2021-03-08 04:28:03', '2021-03-08 04:28:03'),
(21, NULL, NULL, 49, 'BFBUES49-D', 10, NULL, NULL, '2021-03-08 04:28:31', '2021-03-08 04:28:31'),
(22, NULL, NULL, 51, 'AZGOES51-I', 17, NULL, NULL, '2021-03-08 04:29:10', '2021-03-08 04:29:10'),
(23, NULL, NULL, 51, 'AZGOES51-J', 17, NULL, NULL, '2021-03-08 04:30:57', '2021-03-08 04:30:57'),
(24, NULL, NULL, 49, 'BFBUES49-E', 10, NULL, NULL, '2021-03-08 04:34:00', '2021-03-08 04:34:00'),
(25, NULL, NULL, 49, 'BFBUES49-F', 10, NULL, NULL, '2021-03-08 04:35:05', '2021-03-08 04:35:05'),
(26, NULL, NULL, 51, 'AZGOES51-K', 16, NULL, 'ready_for_plan', '2021-03-09 07:36:37', '2021-03-09 07:36:37'),
(28, NULL, NULL, 51, 'AZGOES51-L', 16, NULL, NULL, '2021-03-09 20:09:14', '2021-03-09 20:09:14'),
(29, NULL, NULL, 51, 'AZGOES51-M', 20, NULL, 'ready_for_plan', '2021-03-09 20:11:04', '2021-03-09 20:11:04'),
(30, NULL, NULL, 51, 'AZGOES51-N', 21, NULL, NULL, '2021-03-09 20:11:48', '2021-03-09 20:11:48'),
(31, 29, 1, 51, 'AZGOES51-O', 17, NULL, NULL, '2021-03-10 05:06:47', '2021-03-10 05:06:47'),
(32, 29, 11, 52, 'AZTACA52-A', 19, NULL, NULL, '2021-03-10 05:08:27', '2021-03-10 05:08:27'),
(33, 29, 1, 51, 'AZGOES51-P', 16, NULL, NULL, '2021-03-10 05:10:02', '2021-03-10 05:10:02'),
(34, 29, 11, 52, 'AZTACA52-B', 18, NULL, NULL, '2021-03-10 05:20:42', '2021-03-10 05:20:42'),
(35, 29, 1, 51, 'AZGOES51-Q', 17, NULL, NULL, '2021-03-10 05:26:25', '2021-03-10 05:26:25'),
(36, 29, 1, 51, 'AZGOES51-R', 17, NULL, 'ready_for_plan', '2021-03-10 05:33:31', '2021-03-10 05:33:31'),
(37, 27, 15, 49, 'BFBUES49-G', 9, NULL, NULL, '2021-03-10 05:36:36', '2021-03-10 05:36:36'),
(38, 29, 1, 51, 'AZGOES51-S', 20, NULL, NULL, '2021-03-18 05:06:43', '2021-03-18 05:06:43'),
(39, 23, 10, 45, 'MSBAMS45-A', 22, NULL, 'ready_for_plan', '2021-03-18 06:24:14', '2021-03-18 06:24:14'),
(40, 29, 1, 51, 'AZGOES51-T', 21, NULL, NULL, '2021-03-23 08:39:42', '2021-03-23 08:39:42'),
(41, 23, 4, 67, 'MSMNCA67-A', 27, NULL, 'ready_for_plan', '2021-04-01 06:03:41', '2021-04-01 06:03:41'),
(42, 29, 11, 62, 'AZTAES62-A', 19, NULL, NULL, '2021-04-15 05:42:21', '2021-04-15 05:42:21'),
(43, 23, 10, 45, 'MSBAMS45-B', 23, NULL, 'ready_for_plan', '2021-05-02 00:43:26', '2021-05-02 00:43:26'),
(44, 23, 10, 45, 'MSBAMS45-C', 22, NULL, 'ready_for_plan', '2021-05-02 00:43:40', '2021-05-02 00:43:40'),
(45, 51, 16, 72, 'DEMO1DMES72-A', 31, NULL, 'ready_for_plan', '2021-07-09 01:09:41', '2021-07-09 01:18:06'),
(46, 51, 16, 72, 'DEMO1DMES72-B', 32, NULL, 'ready_for_plan', '2021-07-09 01:10:23', '2021-07-28 02:29:19'),
(47, 51, 16, 73, 'DEMO1DMCA73-A', 31, NULL, NULL, '2021-08-05 06:59:17', '2021-08-05 06:59:17'),
(48, 51, 16, 73, 'DEMO1DMCA73-B', 32, NULL, NULL, '2021-08-05 07:02:16', '2021-08-05 07:02:16'),
(49, 51, 16, 73, 'DEMO1DMCA73-C', 31, NULL, NULL, '2021-08-05 07:02:25', '2021-08-05 07:02:25'),
(50, 51, 16, 73, 'DEMO1DMCA73-D', 32, NULL, 'ready_for_plan', '2021-08-05 07:02:37', '2021-08-14 04:48:29'),
(51, 51, 16, 73, 'DEMO1DMCA73-E', 31, NULL, NULL, '2021-08-05 07:03:18', '2021-08-05 07:03:18'),
(52, 51, 16, 72, 'DEMO1DMES72-C', 32, NULL, 'ready_for_plan', '2021-08-05 07:04:41', '2021-08-24 10:05:09'),
(53, 65, 19, 74, 'OPopdnCA74-A', 34, NULL, 'ready_for_plan', '2021-08-25 01:50:11', '2021-08-25 01:54:10'),
(54, 65, 19, 74, 'OPopdnCA74-B', 34, NULL, NULL, '2021-08-25 01:50:45', '2021-08-25 01:50:45'),
(55, 65, 19, 74, 'OPopdnCA74-C', 36, NULL, NULL, '2021-08-25 06:21:43', '2021-08-25 06:21:43'),
(56, 65, 19, 74, 'OPopdnCA74-D', 34, NULL, NULL, '2021-08-25 06:21:56', '2021-08-25 06:21:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indexes for table `allocation`
--
ALTER TABLE `allocation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_name_unique` (`name`);

--
-- Indexes for table `brands_user`
--
ALTER TABLE `brands_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brands_user_brand_id_foreign` (`brand_id`),
  ADD KEY `brands_user_user_id_foreign` (`user_id`);

--
-- Indexes for table `ch_favorites`
--
ALTER TABLE `ch_favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ch_messages`
--
ALTER TABLE `ch_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commercial`
--
ALTER TABLE `commercial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `dayplan`
--
ALTER TABLE `dayplan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `editor_submission`
--
ALTER TABLE `editor_submission`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `lots`
--
ALTER TABLE `lots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lots_brand_id_foreign` (`brand_id`) USING BTREE,
  ADD KEY `lots_user_id_foreign` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `shootplan`
--
ALTER TABLE `shootplan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `dayplan_id` (`dayplan_id`);

--
-- Indexes for table `sku`
--
ALTER TABLE `sku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploadraw`
--
ALTER TABLE `uploadraw`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wrc`
--
ALTER TABLE `wrc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wrc_id` (`wrc_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=232;

--
-- AUTO_INCREMENT for table `allocation`
--
ALTER TABLE `allocation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=191;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `brands_user`
--
ALTER TABLE `brands_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `commercial`
--
ALTER TABLE `commercial`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `dayplan`
--
ALTER TABLE `dayplan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `editor_submission`
--
ALTER TABLE `editor_submission`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lots`
--
ALTER TABLE `lots`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `shootplan`
--
ALTER TABLE `shootplan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT for table `sku`
--
ALTER TABLE `sku`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=166;

--
-- AUTO_INCREMENT for table `uploadraw`
--
ALTER TABLE `uploadraw`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `wrc`
--
ALTER TABLE `wrc`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `lots`
--
ALTER TABLE `lots`
  ADD CONSTRAINT `lots_brand_id_foreign ` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lots_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
