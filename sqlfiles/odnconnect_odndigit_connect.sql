-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 22, 2023 at 05:42 PM
-- Server version: 8.0.32
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `odnconnect_odndigit_connect`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessories_masters`
--

CREATE TABLE `accessories_masters` (
  `id` bigint UNSIGNED NOT NULL,
  `accessory_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accessory_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `accessory_type_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `accessory_types`
--

CREATE TABLE `accessory_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` bigint UNSIGNED NOT NULL,
  `log_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` bigint UNSIGNED DEFAULT NULL,
  `causer_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `causer_id` bigint UNSIGNED DEFAULT NULL,
  `properties` json DEFAULT NULL,
  `batch_uuid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `adaptation_masters`
--

CREATE TABLE `adaptation_masters` (
  `id` bigint UNSIGNED NOT NULL,
  `adaptation_type_id` bigint NOT NULL,
  `shoot_adaptation_id` int NOT NULL DEFAULT '0',
  `np_shoot_adaptation_id` int NOT NULL DEFAULT '0',
  `type_of_shoot_id` int NOT NULL DEFAULT '0',
  `cloth_id` int NOT NULL DEFAULT '0',
  `adaptation_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commercial_price` int NOT NULL DEFAULT '0',
  `adaptation_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `adaptation_types`
--

CREATE TABLE `adaptation_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int UNSIGNED NOT NULL,
  `user_id` bigint NOT NULL,
  `cart_id` bigint NOT NULL,
  `address1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postcode` int DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gst_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_num` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access` int NOT NULL DEFAULT '2',
  `status` int NOT NULL DEFAULT '1',
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `allocation`
--

CREATE TABLE `allocation` (
  `id` int UNSIGNED NOT NULL,
  `uploadraw_id` int NOT NULL,
  `user_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `authentication_log`
--

CREATE TABLE `authentication_log` (
  `id` bigint UNSIGNED NOT NULL,
  `authenticatable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `authenticatable_id` bigint UNSIGNED NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `login_at` timestamp NULL DEFAULT NULL,
  `logout_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint UNSIGNED NOT NULL,
  `banner_id` int DEFAULT NULL,
  `sku` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci,
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `billing_addresses`
--

CREATE TABLE `billing_addresses` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT NULL,
  `lot_id` int DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gst_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pan_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_one` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_two` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `default_address` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands_user`
--

CREATE TABLE `brands_user` (
  `id` int NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `brand_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `coupon_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `items_count` int NOT NULL DEFAULT '0',
  `discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sub_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `grand_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping` decimal(10,2) NOT NULL DEFAULT '0.00',
  `checkout_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_guest` int NOT NULL DEFAULT '0',
  `is_active` int NOT NULL DEFAULT '0',
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agreement` int NOT NULL DEFAULT '0',
  `conditions` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_item_models`
--

CREATE TABLE `cart_item_models` (
  `id` bigint UNSIGNED NOT NULL,
  `cart_item_id` bigint NOT NULL,
  `model_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_rule_coupons`
--

CREATE TABLE `cart_rule_coupons` (
  `id` int UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `usage_limit` int UNSIGNED NOT NULL DEFAULT '0',
  `usage_per_customer` int UNSIGNED NOT NULL DEFAULT '0',
  `times_used` int UNSIGNED NOT NULL DEFAULT '0',
  `type` int UNSIGNED NOT NULL DEFAULT '0',
  `is_primary` tinyint(1) NOT NULL DEFAULT '0',
  `expired_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_allocation`
--

CREATE TABLE `catalog_allocation` (
  `id` int UNSIGNED NOT NULL,
  `wrc_id` int UNSIGNED NOT NULL,
  `batch_no` int NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `user_role` smallint NOT NULL DEFAULT '0' COMMENT '0 for cataloger 1 for copy writer',
  `allocated_qty` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_client_approval_rejections`
--

CREATE TABLE `catalog_client_approval_rejections` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_marketplace_credentials`
--

CREATE TABLE `catalog_marketplace_credentials` (
  `id` int NOT NULL,
  `marketplace_id` int NOT NULL COMMENT 'id from marketplace table',
  `commercial_id` int NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_qc_comment`
--

CREATE TABLE `catalog_qc_comment` (
  `id` int UNSIGNED NOT NULL,
  `allocation_id` int NOT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_submissions`
--

CREATE TABLE `catalog_submissions` (
  `id` int UNSIGNED NOT NULL,
  `wrc_id` int UNSIGNED NOT NULL,
  `batch_no` int NOT NULL,
  `submission_date` date NOT NULL,
  `ar_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 for no action , 1 for approved , 2 for rejected',
  `rejection_reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `invoiceNumber` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_time_hash`
--

CREATE TABLE `catalog_time_hash` (
  `id` int UNSIGNED NOT NULL,
  `allocation_id` int NOT NULL,
  `start_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pause_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `task_status` tinyint(1) NOT NULL COMMENT '0 for pending from user, 1 for done by user , 2 for done from QC panel',
  `is_rework` tinyint(1) NOT NULL COMMENT '0 for Not in rework ,1 for task in rework',
  `rework_count` int NOT NULL DEFAULT '0' COMMENT 'counter how many time task rework',
  `spent_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_started` tinyint(1) NOT NULL COMMENT '0 for started , 1 for paused',
  `ini_start_time` datetime NOT NULL COMMENT 'first time start time ',
  `ini_end_time` datetime NOT NULL COMMENT 'first time end time ',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_uploaded_marketplace_counts`
--

CREATE TABLE `catalog_uploaded_marketplace_counts` (
  `id` bigint UNSIGNED NOT NULL,
  `marketplace_id` int NOT NULL,
  `allocation_id` int NOT NULL,
  `approved_Count` int NOT NULL,
  `rejected_Count` int NOT NULL,
  `upload_date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_upload_links`
--

CREATE TABLE `catalog_upload_links` (
  `id` int UNSIGNED NOT NULL,
  `allocation_id` int NOT NULL,
  `final_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `catalog_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `copy_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_wrc_batches`
--

CREATE TABLE `catalog_wrc_batches` (
  `id` bigint UNSIGNED NOT NULL,
  `wrc_id` int NOT NULL,
  `batch_no` int NOT NULL,
  `sku_count` int NOT NULL,
  `prequisites` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_initiate_date` date DEFAULT NULL,
  `work_committed_date` date DEFAULT NULL,
  `invoiceNumber` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catalog_wrc_skus`
--

CREATE TABLE `catalog_wrc_skus` (
  `id` bigint UNSIGNED NOT NULL,
  `sku_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `style` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_of_service` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `wrc_id` int NOT NULL,
  `batch_no` int NOT NULL,
  `batch` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catlog_wrc`
--

CREATE TABLE `catlog_wrc` (
  `id` int UNSIGNED NOT NULL,
  `lot_id` int UNSIGNED NOT NULL,
  `wrc_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modeOfDelivary` int NOT NULL,
  `commercial_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alloacte_to_copy_writer` tinyint(1) NOT NULL COMMENT '0 for not , 1 for allocate',
  `ar_status` tinyint(1) NOT NULL COMMENT 'client approval rejection status , 0 for no action,1 for approval,2 for rejection',
  `rejection_reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_recevied_date` date NOT NULL,
  `missing_info_notify_date` date NOT NULL,
  `missing_info_recived_date` date NOT NULL,
  `confirmation_date` date NOT NULL,
  `work_brief` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku_qty` int NOT NULL,
  `guidelines` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document1` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document2` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_retainer` tinyint(1) NOT NULL COMMENT '0 for not retainer, 1 for retainer',
  `generic_data_format_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_as_per_guidelines` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ch_favorites`
--

CREATE TABLE `ch_favorites` (
  `id` bigint NOT NULL,
  `user_id` bigint NOT NULL,
  `favorite_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ch_messages`
--

CREATE TABLE `ch_messages` (
  `id` bigint NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `from_id` bigint NOT NULL,
  `to_id` bigint NOT NULL,
  `body` varchar(5000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cloth_masters`
--

CREATE TABLE `cloth_masters` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms_pages`
--

CREATE TABLE `cms_pages` (
  `id` int UNSIGNED NOT NULL,
  `url_key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `html_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` text COLLATE utf8mb4_unicode_ci,
  `content` json DEFAULT NULL,
  `layout` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `commercial`
--

CREATE TABLE `commercial` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `brand_id` int UNSIGNED NOT NULL,
  `product_category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flat_shot` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `extra_mood_shot` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `type_of_shoot` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_of_clothing` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` text COLLATE utf8mb4_unicode_ci,
  `main_com` int NOT NULL DEFAULT '0',
  `adaptation_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adaptation_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adaptation_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adaptation_4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adaptation_5` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `specfic_adaptation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commercial_value_per_sku` int NOT NULL,
  `newCommercialId` int NOT NULL DEFAULT '0' COMMENT 'Id of new_commercials Tbl',
  `comercial_c` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `consolidated_lot`
--

CREATE TABLE `consolidated_lot` (
  `id` int UNSIGNED NOT NULL,
  `shoot` tinyint(1) NOT NULL COMMENT '1 for checked 0 for not checked',
  `creative_graphic` tinyint(1) NOT NULL COMMENT '1 for checked 0 for not checked',
  `cataloging` tinyint(1) NOT NULL COMMENT '1 for checked 0 for not checked',
  `editor_lot_check` tinyint DEFAULT '0' COMMENT '1 for check 0 for not checked',
  `user_id` int NOT NULL,
  `brand_id` int NOT NULL,
  `linked_shoot_id` int DEFAULT NULL,
  `linked_creative_id` int DEFAULT NULL,
  `linked_catlog_id` int DEFAULT NULL,
  `linked_editor_lot_id` int DEFAULT NULL,
  `lot_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shoot_form_data` tinyint NOT NULL DEFAULT '0' COMMENT '0 = form not submitted and 1 = form submitted',
  `creative_graphic_form_data` tinyint NOT NULL DEFAULT '0' COMMENT '0 = form not submitted and 1 = form submitted',
  `cataloging_form_data` tinyint NOT NULL DEFAULT '0' COMMENT '0 = form not submitted and 1 = form submitted',
  `editor_lot_form_data` tinyint DEFAULT '0' COMMENT '0 = form not submitted and 1 = form submitted',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupon_codes`
--

CREATE TABLE `coupon_codes` (
  `id` bigint UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `usage_limit` int UNSIGNED NOT NULL DEFAULT '0',
  `usage_per_customer` int UNSIGNED NOT NULL DEFAULT '0',
  `min_order` int UNSIGNED NOT NULL DEFAULT '0',
  `times_used` int UNSIGNED NOT NULL DEFAULT '0',
  `type` int UNSIGNED NOT NULL DEFAULT '0',
  `value` int NOT NULL DEFAULT '0',
  `expired_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `create_commercial`
--

CREATE TABLE `create_commercial` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `brand_id` int UNSIGNED NOT NULL,
  `project_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kind_of_work` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `per_qty_value` int NOT NULL,
  `newCommercialId` int NOT NULL DEFAULT '0' COMMENT 'Id of new_commercials Tbl',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `create_commercial_catalog`
--

CREATE TABLE `create_commercial_catalog` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `brand_id` int UNSIGNED NOT NULL,
  `market_place` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_of_service` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CommercialSKU` int NOT NULL,
  `newCommercialId` int NOT NULL DEFAULT '0' COMMENT 'Id of new_commercials Tbl',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `creative_allocation`
--

CREATE TABLE `creative_allocation` (
  `id` int UNSIGNED NOT NULL,
  `wrc_id` int NOT NULL,
  `user_id` int NOT NULL,
  `allocated_qty` int NOT NULL,
  `batch_no` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `creative_lots`
--

CREATE TABLE `creative_lots` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `brand_id` int UNSIGNED NOT NULL,
  `lot_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `project_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verticle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_bucket` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_initiate_date` date DEFAULT NULL,
  `lot_delivery_days` int DEFAULT NULL,
  `Comitted_initiate_date` date DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linked_lot_id` int DEFAULT NULL,
  `linked_lot_id_add_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `creative_qc_comment`
--

CREATE TABLE `creative_qc_comment` (
  `id` int UNSIGNED NOT NULL,
  `allocation_id` int NOT NULL,
  `comments` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `creative_submissions`
--

CREATE TABLE `creative_submissions` (
  `id` int UNSIGNED NOT NULL,
  `wrc_id` int UNSIGNED NOT NULL,
  `batch_no` int DEFAULT NULL,
  `submission_date` date NOT NULL,
  `Status` int NOT NULL DEFAULT '0' COMMENT '0 for pending 1 for done',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `creative_time_hash`
--

CREATE TABLE `creative_time_hash` (
  `id` int UNSIGNED NOT NULL,
  `allocation_id` int NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `ini_start_time` datetime NOT NULL COMMENT 'first time start time ',
  `ini_end_time` datetime NOT NULL COMMENT 'first time end time ',
  `task_status` tinyint(1) NOT NULL COMMENT '0 for pending from user, 1 for done by user , 2 for done from QC panel',
  `is_rework` tinyint(1) NOT NULL COMMENT '0 for Not in rework ,1 for task in rework',
  `rework_count` int NOT NULL DEFAULT '0' COMMENT 'counter how many time task rework',
  `spent_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pause_time` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `creative_upload_links`
--

CREATE TABLE `creative_upload_links` (
  `id` int UNSIGNED NOT NULL,
  `allocation_id` int NOT NULL,
  `creative_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `copy_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `creative_wrc`
--

CREATE TABLE `creative_wrc` (
  `id` int UNSIGNED NOT NULL,
  `lot_id` int UNSIGNED NOT NULL,
  `wrc_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commercial_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alloacte_to_copy_writer` tinyint(1) NOT NULL COMMENT '0 for not , 1 for allocate',
  `order_qty` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `work_brief` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guidelines` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cw_qc_status` int NOT NULL DEFAULT '0' COMMENT '0 when qc not completed and 1 when qc status completed from qc pannel',
  `qc_status` int NOT NULL DEFAULT '0' COMMENT '0 when qc not completed and 1 when qc status completed from qc pannel',
  `sku_required` int NOT NULL DEFAULT '0' COMMENT '0 for no and 1 for yes',
  `sku_count` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `creative_wrc_batch`
--

CREATE TABLE `creative_wrc_batch` (
  `id` int UNSIGNED NOT NULL,
  `wrc_id` int NOT NULL,
  `batch_no` int NOT NULL COMMENT '0 for not retainer case and other for retainer case',
  `order_qty` int DEFAULT NULL,
  `sku_count` int DEFAULT NULL,
  `work_initiate_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0000-00-00 00:00:00',
  `work_committed_date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0000-00-00 00:00:00',
  `invoice_no` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `creative_wrc_client_approval`
--

CREATE TABLE `creative_wrc_client_approval` (
  `id` int UNSIGNED NOT NULL,
  `wrc_id` int UNSIGNED NOT NULL,
  `batch_no` int DEFAULT NULL,
  `approval_date` date NOT NULL,
  `rejection_date` date DEFAULT NULL,
  `status` int DEFAULT NULL COMMENT '0 for reject , 1 for approve',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `creative_wrc_skus`
--

CREATE TABLE `creative_wrc_skus` (
  `id` int UNSIGNED NOT NULL,
  `sku_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kind_of_work` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wrc_id` int DEFAULT NULL,
  `creative_wrc_batch_no` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dailyCounts`
--

CREATE TABLE `dailyCounts` (
  `id` int NOT NULL,
  `brands` int NOT NULL,
  `Commercials` int NOT NULL,
  `comparebrands` int DEFAULT NULL,
  `lotexist` int NOT NULL,
  `comparecoms` int DEFAULT NULL,
  `wrcexist` int NOT NULL,
  `compareLots` int DEFAULT NULL,
  `Lots` int NOT NULL,
  `Wrcs` int NOT NULL,
  `comparewrcs` int DEFAULT NULL,
  `plannedskus` int NOT NULL,
  `comparepL` int DEFAULT NULL,
  `pendingplan` int NOT NULL,
  `compareWp` int DEFAULT NULL,
  `compareplannedskus` int DEFAULT NULL,
  `comparependingplan` int DEFAULT NULL,
  `pendingsku` int NOT NULL,
  `comparependingsku` int DEFAULT NULL,
  `uploadrawpending` int NOT NULL,
  `compareuploadrawpending` int DEFAULT NULL,
  `shootdone` int NOT NULL,
  `compareshootdone` int DEFAULT NULL,
  `pendallocation` int NOT NULL,
  `pendingfromediting` int NOT NULL,
  `editingcomplete` int NOT NULL,
  `comparependallocation` int DEFAULT NULL,
  `comparependingfromediting` int DEFAULT NULL,
  `qcdone` int NOT NULL,
  `compareeditingcomplete` int DEFAULT NULL,
  `qcpending` int NOT NULL,
  `comapreqcdone` int DEFAULT NULL,
  `submission` int NOT NULL,
  `compareqcpending` int DEFAULT NULL,
  `comparesubmission` int DEFAULT NULL,
  `sdate` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dayplan`
--

CREATE TABLE `dayplan` (
  `id` int UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `studio` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photographer` varchar(110) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stylist` varchar(110) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `makeupartist` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `rawqc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agency` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assistant` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shoot_hour` text COLLATE utf8mb4_unicode_ci,
  `model_available` date DEFAULT NULL,
  `model_charges` int DEFAULT NULL,
  `extra_model_charges` int DEFAULT NULL,
  `assistant_charges` int DEFAULT NULL,
  `stylist_charges` int DEFAULT NULL,
  `makeup_charges` int DEFAULT NULL,
  `photographer_charges` int DEFAULT NULL,
  `shootType` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `editing_allocations`
--

CREATE TABLE `editing_allocations` (
  `id` int UNSIGNED NOT NULL,
  `wrc_id` int UNSIGNED NOT NULL,
  `allocated_qty` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `user_role` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 for Editor',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `editing_submissions`
--

CREATE TABLE `editing_submissions` (
  `id` int UNSIGNED NOT NULL,
  `wrc_id` int UNSIGNED NOT NULL,
  `submission_date` date NOT NULL,
  `ar_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 for pending , 1 for approvad by client , 2 for rejected ',
  `rejection_reason` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `editing_upload_links`
--

CREATE TABLE `editing_upload_links` (
  `id` int UNSIGNED NOT NULL,
  `allocation_id` int NOT NULL,
  `final_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `task_status` tinyint(1) NOT NULL COMMENT '0 for not completed, 1 for completed from user , 2 for submistion done',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `editing_wrcs`
--

CREATE TABLE `editing_wrcs` (
  `id` int UNSIGNED NOT NULL,
  `lot_id` int UNSIGNED NOT NULL,
  `commercial_id` int UNSIGNED NOT NULL,
  `wrc_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `imgQty` int UNSIGNED NOT NULL,
  `documentType` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 for Link, 1 for SKU Sheet',
  `documentUrl` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `work_initiate_date` date DEFAULT NULL,
  `work_committed_date` date DEFAULT NULL,
  `wrc_status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 for acrive, 2 for Wrc Rejected',
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `editors_commercials`
--

CREATE TABLE `editors_commercials` (
  `id` int UNSIGNED NOT NULL,
  `company_id` int UNSIGNED NOT NULL,
  `brand_id` int UNSIGNED NOT NULL,
  `type_of_service` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CommercialPerImage` int UNSIGNED NOT NULL,
  `newCommercialId` int NOT NULL DEFAULT '0' COMMENT 'Id of new_commercials Tbl',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `editor_lots`
--

CREATE TABLE `editor_lots` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int NOT NULL,
  `brand_id` int NOT NULL,
  `lot_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `request_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linked_lot_id` int DEFAULT NULL,
  `linked_lot_id_add_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `editor_submission`
--

CREATE TABLE `editor_submission` (
  `id` int UNSIGNED NOT NULL,
  `sku_id` int NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qc` enum('0','1','2') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT '0' COMMENT '0 => Rejected, 1 => Approved, 2=> Link Generated',
  `adaptation` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `equipments`
--

CREATE TABLE `equipments` (
  `id` int UNSIGNED NOT NULL,
  `equipment_name` varchar(100) DEFAULT NULL,
  `opt_start_date` date DEFAULT NULL,
  `vendor_name` varchar(100) DEFAULT NULL,
  `equipment_cost` int DEFAULT NULL,
  `opt_end_date` date DEFAULT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `updated_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `equipments_plan`
--

CREATE TABLE `equipments_plan` (
  `id` int UNSIGNED NOT NULL,
  `equipment_id` int DEFAULT NULL,
  `plan_id` int DEFAULT NULL,
  `created_at` timestamp(6) NULL DEFAULT NULL,
  `updated_at` timestamp(6) NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int UNSIGNED NOT NULL,
  `question` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `brand_id` int UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_of_service` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `am_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `q1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `q2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `q3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `q4` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `q5_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `q5_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `q5_3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `q6_1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `q6_2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `q6_3` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `q7` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `q8` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flipkart_editing`
--

CREATE TABLE `flipkart_editing` (
  `id` int NOT NULL,
  `lot_id` int NOT NULL,
  `wrc_id` int NOT NULL,
  `imageCount` int NOT NULL,
  `recivedFilename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sentFilename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gender_masters`
--

CREATE TABLE `gender_masters` (
  `id` bigint UNSIGNED NOT NULL,
  `gender_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hair_style_masters`
--

CREATE TABLE `hair_style_masters` (
  `id` bigint UNSIGNED NOT NULL,
  `gender_id` bigint NOT NULL,
  `hair_style_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hair_style_image_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hair_style_image_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hair_style_image_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hair_style_image_4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_formats`
--

CREATE TABLE `image_formats` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `image_types`
--

CREATE TABLE `image_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lots`
--

CREATE TABLE `lots` (
  `id` int UNSIGNED NOT NULL,
  `lot_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `s_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `brand_id` int UNSIGNED NOT NULL,
  `lot_c` text COLLATE utf8mb4_unicode_ci,
  `lot_done` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `inwarding_status` enum('0','1','2') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `status` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `agreement` int NOT NULL DEFAULT '0',
  `conditions` int NOT NULL DEFAULT '0',
  `company` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `grand_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `sub_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `tax_total` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping` decimal(10,2) NOT NULL DEFAULT '0.00',
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checkout_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `inwarding_sheet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `new_order` int NOT NULL DEFAULT '0',
  `verticleType` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shoothandoverDate` date DEFAULT NULL,
  `clientBucket` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping_fullfillment` text COLLATE utf8mb4_unicode_ci,
  `linked_lot_id` int DEFAULT NULL,
  `linked_lot_id_add_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lots_catalog`
--

CREATE TABLE `lots_catalog` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL,
  `brand_id` int UNSIGNED NOT NULL,
  `lot_number` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serviceType` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requestType` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reqReceviedDate` date DEFAULT NULL,
  `imgReceviedDate` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0000-00-00',
  `linked_lot_id` int DEFAULT NULL,
  `linked_lot_id_add_from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lot_status`
--

CREATE TABLE `lot_status` (
  `id` int UNSIGNED NOT NULL,
  `lot_id` int NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `makeup_masters`
--

CREATE TABLE `makeup_masters` (
  `id` bigint UNSIGNED NOT NULL,
  `gender_id` bigint NOT NULL,
  `makeup_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `makeup_image_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `makeup_image_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `makeup_image_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `makeup_image_4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marketplaces`
--

CREATE TABLE `marketplaces` (
  `id` int NOT NULL,
  `marketPlace_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_masters`
--

CREATE TABLE `model_masters` (
  `id` bigint UNSIGNED NOT NULL,
  `gender_id` bigint NOT NULL,
  `type_id` bigint NOT NULL,
  `model_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_bio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `main_size` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `height` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bust` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waist` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shoe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ethnicity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hair_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `eye_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_cover_picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_instagram_profile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_portfolio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_portfolios`
--

CREATE TABLE `model_portfolios` (
  `id` bigint UNSIGNED NOT NULL,
  `model_id` bigint NOT NULL,
  `model_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_types`
--

CREATE TABLE `model_types` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `new_commercials`
--

CREATE TABLE `new_commercials` (
  `id` int UNSIGNED NOT NULL,
  `commCompanyId` int NOT NULL,
  `commBrandId` int NOT NULL,
  `commClientID` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `c_short` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `short_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commshootcheck` tinyint(1) NOT NULL,
  `commcgcheck` tinyint(1) NOT NULL,
  `commcatcheck` tinyint(1) NOT NULL,
  `shootCheckIsDone` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 for no need , 1 for Pending , 2 for Done',
  `cgCheckIsDone` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 for no need , 1 for Pending , 2 for Done',
  `catCheckIsDone` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 for no need , 1 for Pending , 2 for Done',
  `commEditorcheck` tinyint(1) NOT NULL,
  `editorCheckIsDone` tinyint NOT NULL DEFAULT '0' COMMENT '0 for no need , 1 for Pending , 2 for Done',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `package_masters`
--

CREATE TABLE `package_masters` (
  `id` bigint UNSIGNED NOT NULL,
  `type_of_shoot_id` bigint NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `regular_shoot_price` int NOT NULL DEFAULT '0',
  `professional_shoot_price` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `lot_id` bigint NOT NULL,
  `razor_pay_order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `razorpay_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_done` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pose_masters`
--

CREATE TABLE `pose_masters` (
  `id` bigint UNSIGNED NOT NULL,
  `gender_id` bigint NOT NULL,
  `pose_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pose_image_1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pose_image_2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pose_image_3` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pose_image_4` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shootplan`
--

CREATE TABLE `shootplan` (
  `id` int NOT NULL,
  `sku_id` int UNSIGNED NOT NULL,
  `dayplan_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shoot_adaptations`
--

CREATE TABLE `shoot_adaptations` (
  `id` bigint UNSIGNED NOT NULL,
  `adaptation_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adaptation_logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sku`
--

CREATE TABLE `sku` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `brand_id` int UNSIGNED DEFAULT NULL,
  `lot_id` int UNSIGNED NOT NULL,
  `wrc_id` int UNSIGNED DEFAULT NULL,
  `sku_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subcategory` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_of_clothing` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sku_c` text COLLATE utf8mb4_unicode_ci,
  `status` enum('1','0') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_status` text COLLATE utf8mb4_unicode_ci,
  `edt_rejection` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `barcode` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_of_shoot1` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_of_shoot2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_of_shoot3` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_of_shoot4` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_of_shoot` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adaptation1` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sku_status`
--

CREATE TABLE `sku_status` (
  `id` int NOT NULL,
  `sku_id` int NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_at` timestamp(5) NOT NULL DEFAULT CURRENT_TIMESTAMP(5) ON UPDATE CURRENT_TIMESTAMP(5),
  `updated_at` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `staff_permissions`
--

CREATE TABLE `staff_permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `admin_id` bigint NOT NULL,
  `permission_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `submission`
--

CREATE TABLE `submission` (
  `id` int UNSIGNED NOT NULL,
  `wrc_id` int NOT NULL,
  `submission_date` date DEFAULT NULL,
  `firstAngle` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `fullAngle` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tax_rates`
--

CREATE TABLE `tax_rates` (
  `id` bigint UNSIGNED NOT NULL,
  `identifier` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `tax_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `shipping_rate` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `type_of_shoots`
--

CREATE TABLE `type_of_shoots` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uploadraw`
--

CREATE TABLE `uploadraw` (
  `id` int UNSIGNED NOT NULL,
  `sku_id` int NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `client_id` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified` tinyint(1) NOT NULL DEFAULT '0',
  `am_email` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active_status` tinyint(1) NOT NULL DEFAULT '1',
  `dark_mode` tinyint(1) NOT NULL DEFAULT '0',
  `messenger_color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '#2180f3',
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatar.png',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_term` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_verified` tinyint(1) NOT NULL DEFAULT '0',
  `Address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `c_short` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Gst_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verifyToken` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `verification_status` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'avatar.jpg',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `parent_client_id` int DEFAULT '0',
  `dam_enable` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `module_enable` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_otps`
--

CREATE TABLE `user_otps` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `type` int NOT NULL DEFAULT '1',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile_number` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `otp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wrc`
--

CREATE TABLE `wrc` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int DEFAULT NULL,
  `brand_id` int DEFAULT NULL,
  `lot_id` int UNSIGNED NOT NULL,
  `wrc_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commercial_id` int NOT NULL,
  `wrc_c` text COLLATE utf8mb4_unicode_ci,
  `ppt_approval` date DEFAULT NULL,
  `model_approval` date DEFAULT NULL,
  `inward_sheet` date DEFAULT NULL,
  `special_approval` date DEFAULT NULL,
  `edt_rejection` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `initialised` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Invoice_no` varchar(225) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fl_shot` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `mood_shot` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `Client_AR` enum('0','1') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci,
  `fwrc_done` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `fstarted` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `fwrcdone_date` date DEFAULT NULL,
  `fwrcstarted_date` date DEFAULT NULL,
  `submission` enum('1','0') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wrc_status`
--

CREATE TABLE `wrc_status` (
  `id` int UNSIGNED NOT NULL,
  `wrc_id` int DEFAULT NULL,
  `status` enum('1','2','3','4','5','6') COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '1=> Inwarding, 2=> Planning, 3=> Shoot, 4 => Editing, 5=> Quality_Check, 6=> Submission ',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accessories_masters`
--
ALTER TABLE `accessories_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `accessory_types`
--
ALTER TABLE `accessory_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject` (`subject_type`,`subject_id`),
  ADD KEY `causer` (`causer_type`,`causer_id`),
  ADD KEY `activity_log_log_name_index` (`log_name`);

--
-- Indexes for table `adaptation_masters`
--
ALTER TABLE `adaptation_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adaptation_types`
--
ALTER TABLE `adaptation_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD UNIQUE KEY `admins_mobile_number_unique` (`mobile_number`);

--
-- Indexes for table `allocation`
--
ALTER TABLE `allocation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploadraw_id` (`uploadraw_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `authentication_log`
--
ALTER TABLE `authentication_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `authentication_log_authenticatable_type_authenticatable_id_index` (`authenticatable_type`,`authenticatable_id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `billing_addresses`
--
ALTER TABLE `billing_addresses`
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
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_item_models`
--
ALTER TABLE `cart_item_models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_rule_coupons`
--
ALTER TABLE `cart_rule_coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catalog_allocation`
--
ALTER TABLE `catalog_allocation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catalog_client_approval_rejections`
--
ALTER TABLE `catalog_client_approval_rejections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catalog_marketplace_credentials`
--
ALTER TABLE `catalog_marketplace_credentials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `marketPlace` (`marketplace_id`);

--
-- Indexes for table `catalog_qc_comment`
--
ALTER TABLE `catalog_qc_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catalog_submissions`
--
ALTER TABLE `catalog_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catalog_time_hash`
--
ALTER TABLE `catalog_time_hash`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catalog_uploaded_marketplace_counts`
--
ALTER TABLE `catalog_uploaded_marketplace_counts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catalog_upload_links`
--
ALTER TABLE `catalog_upload_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catalog_wrc_batches`
--
ALTER TABLE `catalog_wrc_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catalog_wrc_skus`
--
ALTER TABLE `catalog_wrc_skus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `catlog_wrc`
--
ALTER TABLE `catlog_wrc`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `cloth_masters`
--
ALTER TABLE `cloth_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_pages`
--
ALTER TABLE `cms_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `commercial`
--
ALTER TABLE `commercial`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `consolidated_lot`
--
ALTER TABLE `consolidated_lot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupon_codes`
--
ALTER TABLE `coupon_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `create_commercial`
--
ALTER TABLE `create_commercial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `create_commercial_catalog`
--
ALTER TABLE `create_commercial_catalog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `creative_allocation`
--
ALTER TABLE `creative_allocation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `creative_lots`
--
ALTER TABLE `creative_lots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `creative_lots_brand_id_foreign` (`brand_id`),
  ADD KEY `creative_lots_user_id_foreign` (`user_id`);

--
-- Indexes for table `creative_qc_comment`
--
ALTER TABLE `creative_qc_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `creative_submissions`
--
ALTER TABLE `creative_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `creative_time_hash`
--
ALTER TABLE `creative_time_hash`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `creative_upload_links`
--
ALTER TABLE `creative_upload_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `creative_wrc`
--
ALTER TABLE `creative_wrc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `creative_wrc_batch`
--
ALTER TABLE `creative_wrc_batch`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `creative_wrc_client_approval`
--
ALTER TABLE `creative_wrc_client_approval`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `creative_wrc_skus`
--
ALTER TABLE `creative_wrc_skus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dailyCounts`
--
ALTER TABLE `dailyCounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dayplan`
--
ALTER TABLE `dayplan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `editing_allocations`
--
ALTER TABLE `editing_allocations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `editing_submissions`
--
ALTER TABLE `editing_submissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `editing_upload_links`
--
ALTER TABLE `editing_upload_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `editing_wrcs`
--
ALTER TABLE `editing_wrcs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `editors_commercials`
--
ALTER TABLE `editors_commercials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `editor_lots`
--
ALTER TABLE `editor_lots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `editor_submission`
--
ALTER TABLE `editor_submission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sku_id` (`sku_id`);

--
-- Indexes for table `equipments`
--
ALTER TABLE `equipments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `equipments_plan`
--
ALTER TABLE `equipments_plan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipment_id` (`equipment_id`,`plan_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flipkart_editing`
--
ALTER TABLE `flipkart_editing`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gender_masters`
--
ALTER TABLE `gender_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hair_style_masters`
--
ALTER TABLE `hair_style_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_formats`
--
ALTER TABLE `image_formats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `image_types`
--
ALTER TABLE `image_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lots`
--
ALTER TABLE `lots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `lots_brand_id_foreign` (`brand_id`) USING BTREE,
  ADD KEY `lots_user_id_foreign` (`user_id`);

--
-- Indexes for table `lots_catalog`
--
ALTER TABLE `lots_catalog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lot_status`
--
ALTER TABLE `lot_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `makeup_masters`
--
ALTER TABLE `makeup_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marketplaces`
--
ALTER TABLE `marketplaces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `marketPlace` (`marketPlace_name`);

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
-- Indexes for table `model_masters`
--
ALTER TABLE `model_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_portfolios`
--
ALTER TABLE `model_portfolios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_types`
--
ALTER TABLE `model_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `new_commercials`
--
ALTER TABLE `new_commercials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `package_masters`
--
ALTER TABLE `package_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_user_id_index` (`user_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pose_masters`
--
ALTER TABLE `pose_masters`
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
  ADD KEY `dayplan_id` (`dayplan_id`),
  ADD KEY `sku_id` (`sku_id`);

--
-- Indexes for table `shoot_adaptations`
--
ALTER TABLE `shoot_adaptations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sku`
--
ALTER TABLE `sku`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`,`brand_id`,`lot_id`,`wrc_id`);

--
-- Indexes for table `sku_status`
--
ALTER TABLE `sku_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_permissions`
--
ALTER TABLE `staff_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `submission`
--
ALTER TABLE `submission`
  ADD PRIMARY KEY (`wrc_id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `tax_rates`
--
ALTER TABLE `tax_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `type_of_shoots`
--
ALTER TABLE `type_of_shoots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uploadraw`
--
ALTER TABLE `uploadraw`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sku_id` (`sku_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_otps`
--
ALTER TABLE `user_otps`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wrc`
--
ALTER TABLE `wrc`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wrc_id` (`wrc_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `brand_id` (`brand_id`,`lot_id`,`commercial_id`);

--
-- Indexes for table `wrc_status`
--
ALTER TABLE `wrc_status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accessories_masters`
--
ALTER TABLE `accessories_masters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `accessory_types`
--
ALTER TABLE `accessory_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `adaptation_masters`
--
ALTER TABLE `adaptation_masters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `adaptation_types`
--
ALTER TABLE `adaptation_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `allocation`
--
ALTER TABLE `allocation`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `authentication_log`
--
ALTER TABLE `authentication_log`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `billing_addresses`
--
ALTER TABLE `billing_addresses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands_user`
--
ALTER TABLE `brands_user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_item_models`
--
ALTER TABLE `cart_item_models`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_rule_coupons`
--
ALTER TABLE `cart_rule_coupons`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catalog_allocation`
--
ALTER TABLE `catalog_allocation`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catalog_client_approval_rejections`
--
ALTER TABLE `catalog_client_approval_rejections`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catalog_marketplace_credentials`
--
ALTER TABLE `catalog_marketplace_credentials`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catalog_qc_comment`
--
ALTER TABLE `catalog_qc_comment`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catalog_submissions`
--
ALTER TABLE `catalog_submissions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catalog_time_hash`
--
ALTER TABLE `catalog_time_hash`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catalog_uploaded_marketplace_counts`
--
ALTER TABLE `catalog_uploaded_marketplace_counts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catalog_upload_links`
--
ALTER TABLE `catalog_upload_links`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catalog_wrc_batches`
--
ALTER TABLE `catalog_wrc_batches`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catalog_wrc_skus`
--
ALTER TABLE `catalog_wrc_skus`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catlog_wrc`
--
ALTER TABLE `catlog_wrc`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cloth_masters`
--
ALTER TABLE `cloth_masters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cms_pages`
--
ALTER TABLE `cms_pages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `commercial`
--
ALTER TABLE `commercial`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `consolidated_lot`
--
ALTER TABLE `consolidated_lot`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupon_codes`
--
ALTER TABLE `coupon_codes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `create_commercial`
--
ALTER TABLE `create_commercial`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `create_commercial_catalog`
--
ALTER TABLE `create_commercial_catalog`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `creative_allocation`
--
ALTER TABLE `creative_allocation`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `creative_lots`
--
ALTER TABLE `creative_lots`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `creative_qc_comment`
--
ALTER TABLE `creative_qc_comment`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `creative_submissions`
--
ALTER TABLE `creative_submissions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `creative_time_hash`
--
ALTER TABLE `creative_time_hash`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `creative_upload_links`
--
ALTER TABLE `creative_upload_links`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `creative_wrc`
--
ALTER TABLE `creative_wrc`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `creative_wrc_batch`
--
ALTER TABLE `creative_wrc_batch`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `creative_wrc_client_approval`
--
ALTER TABLE `creative_wrc_client_approval`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `creative_wrc_skus`
--
ALTER TABLE `creative_wrc_skus`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dailyCounts`
--
ALTER TABLE `dailyCounts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dayplan`
--
ALTER TABLE `dayplan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `editing_allocations`
--
ALTER TABLE `editing_allocations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `editing_submissions`
--
ALTER TABLE `editing_submissions`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `editing_upload_links`
--
ALTER TABLE `editing_upload_links`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `editing_wrcs`
--
ALTER TABLE `editing_wrcs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `editors_commercials`
--
ALTER TABLE `editors_commercials`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `editor_lots`
--
ALTER TABLE `editor_lots`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `editor_submission`
--
ALTER TABLE `editor_submission`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `equipments`
--
ALTER TABLE `equipments`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `equipments_plan`
--
ALTER TABLE `equipments_plan`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flipkart_editing`
--
ALTER TABLE `flipkart_editing`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gender_masters`
--
ALTER TABLE `gender_masters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hair_style_masters`
--
ALTER TABLE `hair_style_masters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_formats`
--
ALTER TABLE `image_formats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `image_types`
--
ALTER TABLE `image_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lots`
--
ALTER TABLE `lots`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lots_catalog`
--
ALTER TABLE `lots_catalog`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lot_status`
--
ALTER TABLE `lot_status`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `makeup_masters`
--
ALTER TABLE `makeup_masters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marketplaces`
--
ALTER TABLE `marketplaces`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `model_masters`
--
ALTER TABLE `model_masters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `model_portfolios`
--
ALTER TABLE `model_portfolios`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `model_types`
--
ALTER TABLE `model_types`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `new_commercials`
--
ALTER TABLE `new_commercials`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `package_masters`
--
ALTER TABLE `package_masters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pose_masters`
--
ALTER TABLE `pose_masters`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shootplan`
--
ALTER TABLE `shootplan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shoot_adaptations`
--
ALTER TABLE `shoot_adaptations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sku`
--
ALTER TABLE `sku`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sku_status`
--
ALTER TABLE `sku_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_permissions`
--
ALTER TABLE `staff_permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `submission`
--
ALTER TABLE `submission`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tax_rates`
--
ALTER TABLE `tax_rates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `type_of_shoots`
--
ALTER TABLE `type_of_shoots`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `uploadraw`
--
ALTER TABLE `uploadraw`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_otps`
--
ALTER TABLE `user_otps`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wrc`
--
ALTER TABLE `wrc`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wrc_status`
--
ALTER TABLE `wrc_status`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `creative_lots`
--
ALTER TABLE `creative_lots`
  ADD CONSTRAINT `creative_lots_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `creative_lots_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
