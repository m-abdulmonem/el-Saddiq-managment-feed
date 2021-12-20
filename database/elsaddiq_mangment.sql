-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2021 at 11:29 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elsaddiq_mangment`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendances`
--

CREATE TABLE `attendances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_exist` tinyint(1) NOT NULL DEFAULT 1,
  `is_holiday` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendances`
--

INSERT INTO `attendances` (`id`, `time_in`, `time_out`, `date`, `details`, `is_exist`, `is_holiday`, `user_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '15:14:50', NULL, '2021-01-24 22:00:00', NULL, 1, 0, 2, NULL, '2021-01-25 13:14:50', '2021-01-25 13:14:50'),
(2, '16:08:51', NULL, '2021-01-24 22:00:00', NULL, 1, 0, 3, NULL, '2021-01-25 14:08:51', '2021-01-25 14:08:51'),
(3, NULL, NULL, '2021-01-25 23:01:36', NULL, 0, 1, 3, NULL, '2021-01-25 23:01:36', '2021-01-25 23:01:36'),
(4, NULL, NULL, '2021-01-29 10:01:00', NULL, 0, 1, 2, NULL, '2021-01-29 10:01:00', '2021-01-29 10:01:00'),
(5, NULL, NULL, '2021-01-29 10:01:00', NULL, 0, 1, 3, NULL, '2021-01-29 10:01:00', '2021-01-29 10:01:00');

-- --------------------------------------------------------

--
-- Table structure for table `balances`
--

CREATE TABLE `balances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `remaining` double(8,2) NOT NULL DEFAULT 0.00,
  `paid` double(8,2) DEFAULT NULL COMMENT 'payment value',
  `type` enum('electricity_bill','water_bill','internet_bill','donation') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_salary` tinyint(1) NOT NULL DEFAULT 0,
  `supplier_bill_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_bill_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `balances_clients`
--

CREATE TABLE `balances_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` int(11) DEFAULT NULL,
  `remaining_amount` double(8,2) DEFAULT NULL,
  `paid` double(8,2) DEFAULT NULL,
  `type` enum('prev_balance','catch','payment','sale','buy','deposit') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_id` bigint(20) UNSIGNED DEFAULT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `balances_clients`
--

INSERT INTO `balances_clients` (`id`, `code`, `remaining_amount`, `paid`, `type`, `notes`, `bill_id`, `booking_id`, `client_id`, `user_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 0.00, 135.00, 'catch', NULL, 1, NULL, 1, 1, NULL, '2021-01-25 15:42:56', '2021-01-25 15:42:56'),
(2, 2, 0.00, 135.00, 'catch', NULL, 2, NULL, 1, 1, NULL, '2021-01-25 18:11:12', '2021-01-25 18:11:12');

-- --------------------------------------------------------

--
-- Table structure for table `balances_suppliers`
--

CREATE TABLE `balances_suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` int(11) DEFAULT NULL,
  `remaining_amount` double(8,2) DEFAULT NULL,
  `paid` double(8,2) DEFAULT NULL,
  `opening_balance` double(8,2) DEFAULT NULL,
  `type` enum('receive','prev_balance','payment','sale','buy','mashal','tip') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bill_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `opening_balance` double(8,2) DEFAULT 0.00,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bills_clients`
--

CREATE TABLE `bills_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` int(11) DEFAULT NULL,
  `discount` double(8,2) DEFAULT NULL,
  `price` double(8,2) DEFAULT NULL,
  `status` enum('draft','loaded','onWay','delivered','canceled') COLLATE utf8mb4_unicode_ci DEFAULT 'draft',
  `quantity` int(11) DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_cash` tinyint(1) NOT NULL DEFAULT 1,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bills_clients`
--

INSERT INTO `bills_clients` (`id`, `code`, `discount`, `price`, `status`, `quantity`, `notes`, `is_cash`, `user_id`, `client_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 135.00, 'delivered', 1, NULL, 1, 1, 1, NULL, '2021-01-25 15:42:56', '2021-01-25 15:42:56'),
(2, 2, NULL, 135.00, 'delivered', 1, NULL, 1, 1, 1, NULL, '2021-01-25 18:11:12', '2021-01-25 18:11:12');

-- --------------------------------------------------------

--
-- Table structure for table `bills_clients_return`
--

CREATE TABLE `bills_clients_return` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bill_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bills_suppliers`
--

CREATE TABLE `bills_suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` int(11) DEFAULT NULL,
  `number` int(11) DEFAULT NULL COMMENT 'this is the the supplier bill number ',
  `driver` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `car_number` int(11) DEFAULT NULL,
  `discount` double(8,2) DEFAULT NULL,
  `price` double(8,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `is_cash` tinyint(1) NOT NULL DEFAULT 1,
  `status` enum('draft','scheduled for shipping','cancelled','accepted','preparing for shipment','ready for shipment','on shipping route','shipped') COLLATE utf8mb4_unicode_ci DEFAULT 'draft',
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bills_suppliers`
--

INSERT INTO `bills_suppliers` (`id`, `code`, `number`, `driver`, `car_number`, `discount`, `price`, `quantity`, `is_cash`, `status`, `notes`, `supplier_id`, `user_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL, NULL, 3750.00, NULL, 0, 'shipped', 'فاتورة الرصيد الافتتاحى', 3, 1, NULL, '2021-01-25 14:45:06', '2021-01-25 14:45:06'),
(2, 2, 1, NULL, NULL, NULL, 7866.00, NULL, 0, 'shipped', 'فاتورة الرصيد الافتتاحى', 4, 1, NULL, '2021-01-25 23:10:27', '2021-01-25 23:10:27'),
(3, 3, 1, NULL, NULL, NULL, 500.00, NULL, 0, 'shipped', 'فاتورة الرصيد الافتتاحى', 2, 1, NULL, '2021-01-25 23:15:04', '2021-01-25 23:15:04'),
(4, 4, 1, NULL, NULL, NULL, 16770.00, NULL, 0, 'shipped', 'فاتورة الرصيد الافتتاحى', 7, 1, NULL, '2021-01-26 12:59:42', '2021-01-26 12:59:42'),
(5, 5, 1, NULL, NULL, NULL, 4320.00, NULL, 0, 'shipped', 'فاتورة الرصيد الافتتاحى', 8, 1, NULL, '2021-01-29 10:08:23', '2021-01-29 10:08:23'),
(6, 6, 1, NULL, NULL, NULL, 5310.00, NULL, 0, 'shipped', 'فاتورة الرصيد الافتتاحى', 1, 1, NULL, '2021-01-29 10:11:49', '2021-01-29 10:11:49'),
(7, 7, 1, NULL, NULL, NULL, 0.00, NULL, 0, 'shipped', 'فاتورة الرصيد الافتتاحى', 9, 1, NULL, '2021-01-29 12:48:18', '2021-01-29 12:48:18'),
(8, 8, 1, NULL, NULL, NULL, 940.00, NULL, 0, 'shipped', 'فاتورة الرصيد الافتتاحى', 10, 1, NULL, '2021-01-29 14:47:00', '2021-01-29 14:47:00'),
(9, 9, 1, NULL, NULL, NULL, 90.00, NULL, 0, 'shipped', 'فاتورة الرصيد الافتتاحى', 11, 1, NULL, '2021-01-29 14:49:45', '2021-01-29 14:49:45'),
(10, 10, 1, NULL, NULL, NULL, 237.50, NULL, 0, 'shipped', 'فاتورة الرصيد الافتتاحى', 12, 1, NULL, '2021-01-29 14:51:47', '2021-01-29 14:51:47');

-- --------------------------------------------------------

--
-- Table structure for table `bills_suppliers_return`
--

CREATE TABLE `bills_suppliers_return` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` int(11) DEFAULT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bill_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_chicks`
--

CREATE TABLE `booking_chicks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `deposit` double(8,2) DEFAULT NULL,
  `is_came` tinyint(1) NOT NULL DEFAULT 0,
  `chick_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `order_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_sms`
--

CREATE TABLE `booking_sms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sms_id` bigint(20) UNSIGNED DEFAULT NULL,
  `booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `send_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catch_purchases`
--

CREATE TABLE `catch_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('cash','bank') COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid` double(8,2) NOT NULL,
  `bill_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_id` bigint(20) UNSIGNED DEFAULT NULL,
  `balance_id` int(11) DEFAULT NULL,
  `bank_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `image`, `name`, `details`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, NULL, 'اعلاف', 'أعلاف دواجن', NULL, '2021-01-25 13:05:33', '2021-01-25 13:05:33'),
(2, NULL, 'ذرة', NULL, NULL, '2021-01-25 23:11:55', '2021-01-25 23:11:55'),
(3, NULL, 'سقايات وعلافات', NULL, NULL, '2021-01-25 23:12:19', '2021-01-25 23:12:19'),
(4, NULL, 'نخالة', NULL, NULL, '2021-01-25 23:12:37', '2021-01-25 23:12:37'),
(5, NULL, 'حبوب', NULL, NULL, '2021-01-25 23:57:10', '2021-01-25 23:57:10'),
(6, NULL, 'اخرى', NULL, NULL, '2021-01-29 14:49:01', '2021-01-29 14:49:01');

-- --------------------------------------------------------

--
-- Table structure for table `chicks`
--

CREATE TABLE `chicks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` enum('ducks','chick','chicken') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'chick',
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chick_alls`
--

CREATE TABLE `chick_alls` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chick_orders`
--

CREATE TABLE `chick_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` double(8,2) DEFAULT NULL,
  `chick_price` double(8,2) DEFAULT NULL,
  `is_came` tinyint(1) NOT NULL DEFAULT 0,
  `chick_id` bigint(20) UNSIGNED DEFAULT NULL,
  `arrived_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chick_prices`
--

CREATE TABLE `chick_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `price` double(8,2) NOT NULL,
  `chick_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_limit` double(8,2) DEFAULT NULL,
  `maximum_repayment_period` int(11) DEFAULT NULL,
  `is_trader` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `code`, `name`, `picture`, `discount`, `address`, `phone`, `credit_limit`, `maximum_repayment_period`, `is_trader`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 221, 'اشرف رمضان', NULL, NULL, 'جميزة بلجاى', '01099647084', 1000.00, 3, 0, NULL, '2021-01-25 15:42:20', '2021-01-25 15:42:20'),
(2, 222, 'محمد صلاح عبد العظيم', NULL, NULL, 'جميزة بلجاى', '01016268021', 1000.00, 3, 0, NULL, '2021-01-25 18:10:44', '2021-01-25 18:10:44'),
(3, 223, 'امال عماد السعيد', NULL, NULL, 'جميزة بلجاى', '01007743853', 2000.00, 3, 1, NULL, '2021-01-25 18:13:58', '2021-01-25 18:13:58'),
(4, 224, 'امانى السيد سعيد', NULL, NULL, 'جميزة بلجاى', '01016374117', 20000.00, 8, 1, NULL, '2021-01-25 18:15:51', '2021-01-25 18:15:51'),
(5, 225, 'مروة محمد الصياد', NULL, NULL, 'بلجاى', '01099839107', 10000.00, 8, 1, NULL, '2021-01-25 18:38:50', '2021-01-25 18:38:50'),
(6, 226, 'سرور مجاهد', NULL, NULL, 'كفر ابو شوارب', NULL, 2000.00, 8, 1, NULL, '2021-01-25 18:41:55', '2021-01-25 18:41:55'),
(7, 227, 'منى ابراهيم الصياد', NULL, NULL, 'بلجاى', '01021774097', 5000.00, 8, 1, NULL, '2021-01-25 18:43:34', '2021-01-25 18:43:34'),
(8, 228, 'ميادة السيد عبد الباسط', NULL, NULL, 'كفر ابو شوارب', '01005449567', 20000.00, 8, 1, NULL, '2021-01-25 18:44:59', '2021-01-25 18:44:59'),
(9, 229, 'رضا عثمان', NULL, NULL, 'عزبة بلجاى', '01001281921', 10000.00, 8, 1, NULL, '2021-01-25 18:48:31', '2021-01-25 18:48:31'),
(10, 2210, 'شيماء العمدة', NULL, NULL, 'جميزة بلجاى', '01093831343', 10000.00, 8, 1, NULL, '2021-01-25 18:49:59', '2021-01-25 18:49:59'),
(11, 2211, 'الطاهرى', NULL, NULL, 'عزبة شاوة', '01282122842', 1000.00, 8, 1, NULL, '2021-01-25 18:54:18', '2021-01-25 18:54:18'),
(12, 2212, 'مشيرة زين', NULL, NULL, 'بلجاى', '01014352473', 2000.00, 8, 1, NULL, '2021-01-25 18:58:07', '2021-01-25 18:58:07'),
(13, 2213, 'غادة عبد العال', NULL, NULL, 'بلجاى', '01066213847', 1000.00, 8, 1, NULL, '2021-01-25 19:01:11', '2021-01-25 19:01:11'),
(14, 2214, 'مسعد الجميل', NULL, NULL, 'كفر ابو شوارب', '01061356579', 5000.00, 8, 1, NULL, '2021-01-25 19:03:19', '2021-01-25 19:03:19'),
(15, 2215, 'نجلاء حشيش', NULL, NULL, 'جميزة بلجاى', NULL, 5000.00, 8, 1, NULL, '2021-01-26 14:47:08', '2021-01-26 14:47:08'),
(16, 2216, 'غزال', NULL, NULL, 'بلجاى', NULL, 2000.00, 8, 1, NULL, '2021-01-26 14:47:44', '2021-01-26 14:47:44'),
(17, 2217, 'وفاء عبد الفتاح', NULL, NULL, 'بلجاى', NULL, 2000.00, 8, 1, NULL, '2021-01-26 14:48:52', '2021-01-26 14:48:52'),
(18, 2218, 'عادل صابر', NULL, NULL, 'عزبة خلف', NULL, 5000.00, 8, 1, NULL, '2021-01-26 14:49:37', '2021-01-26 14:49:37'),
(19, 2219, 'المتولى خليل العيوطى', NULL, NULL, 'جميزة بلجاى', NULL, 10000.00, 8, 1, NULL, '2021-01-26 15:05:18', '2021-01-26 15:05:18'),
(20, 2220, 'هانى المتولى', NULL, NULL, 'بلجاى', NULL, 15000.00, 8, 1, NULL, '2021-01-26 15:05:55', '2021-01-26 15:05:55'),
(21, 2221, 'حرم محمد صلاح عمران', NULL, NULL, 'بلجاى', NULL, 5000.00, 8, 1, NULL, '2021-01-26 15:06:41', '2021-01-26 15:06:41'),
(22, 2222, 'ام شيماء لبيب', NULL, NULL, 'بلجاى', NULL, 5000.00, 8, 1, NULL, '2021-01-26 15:07:44', '2021-01-26 15:07:44'),
(23, 2223, 'على جلال', NULL, NULL, 'السبخا', NULL, 15000.00, 8, 1, NULL, '2021-01-26 15:08:54', '2021-01-26 15:08:54'),
(24, 2224, 'نها حامد', NULL, NULL, 'بلجاى', NULL, 5000.00, 8, 1, NULL, '2021-01-26 15:09:50', '2021-01-26 15:09:50'),
(25, 2225, 'عطا ابو السعد', NULL, NULL, 'بلجاى', NULL, 2000.00, 8, 0, NULL, '2021-01-27 14:24:18', '2021-01-27 14:24:18'),
(26, 2226, 'شعبان راشد', NULL, NULL, 'البقلية', NULL, 20000.00, 8, 0, NULL, '2021-01-27 14:25:53', '2021-01-27 14:25:53'),
(27, 2227, 'اشرف الصاوى', NULL, NULL, 'بلجاى', NULL, 1000.00, 8, 0, NULL, '2021-01-27 14:26:31', '2021-01-27 14:26:31'),
(28, 2228, 'يحيى طه العيوطى', NULL, NULL, 'جميزة بلجاى', NULL, 2000.00, 8, 0, NULL, '2021-01-27 14:27:58', '2021-01-27 14:27:58'),
(29, 2229, 'امانى الغريب توفيق', NULL, NULL, 'بلجاى', NULL, 1000.00, 8, 0, NULL, '2021-01-27 14:30:11', '2021-01-27 14:30:11'),
(30, 2230, 'ام رامى ابو عطا', NULL, NULL, 'بلجاى', NULL, 1000.00, 8, 0, NULL, '2021-01-27 14:31:27', '2021-01-27 14:31:27'),
(31, 2231, 'عبد المجيد محمد عبد المجيد', NULL, NULL, 'بلجاى', NULL, 1000.00, 8, 0, NULL, '2021-01-27 14:32:39', '2021-01-27 14:32:39'),
(32, 2232, 'ثروت خضر', NULL, NULL, 'كفر ابو شوارب', NULL, 1000.00, 8, 0, NULL, '2021-01-27 14:33:32', '2021-01-27 14:33:32'),
(33, 2233, 'احمد السيد رمضان', NULL, NULL, 'جميزة بلجاى', NULL, 5000.00, 8, 0, NULL, '2021-01-27 14:34:29', '2021-01-27 14:34:29'),
(34, 2234, 'احمد صبرى ابو العنين', NULL, NULL, 'البقلية', NULL, 2000.00, 8, 0, NULL, '2021-01-27 14:35:32', '2021-01-27 14:35:32'),
(35, 2235, 'ناء هانى الشحات', NULL, NULL, 'بلجاى', NULL, 1000.00, 8, 0, NULL, '2021-01-27 14:36:20', '2021-01-27 14:36:20'),
(36, 2236, 'حمامة شعبان موسى', NULL, NULL, 'بلجاى', NULL, 1000.00, 8, 0, NULL, '2021-01-27 14:36:56', '2021-01-27 14:36:56'),
(37, 2237, 'ايمان عبد الحميد مصباح', NULL, NULL, 'بلجاى', NULL, 1000.00, 8, 0, NULL, '2021-01-27 14:37:41', '2021-01-27 14:37:41'),
(38, 2238, 'حجاب عوض', NULL, NULL, 'بلجاى', NULL, 2000.00, 8, 0, NULL, '2021-01-27 14:38:19', '2021-01-27 14:38:19'),
(39, 2239, 'احمد رضا العوضى', NULL, NULL, 'عزبة بكر', NULL, 1000.00, 8, 0, NULL, '2021-01-27 14:39:05', '2021-01-27 14:39:05'),
(40, 2240, 'سمير فتحى الرفاعى', NULL, NULL, 'بلجاى', NULL, 1000.00, 8, 0, NULL, '2021-01-27 14:40:04', '2021-01-27 14:40:04'),
(41, 2241, 'فؤاده خيرى صديق', NULL, NULL, 'بلجاى', NULL, 5000.00, 30, 0, NULL, '2021-01-27 14:40:48', '2021-01-27 14:40:48'),
(42, 2242, 'رمضان عيسى الصياد', NULL, NULL, 'بلجاى', NULL, 1000.00, 8, 0, NULL, '2021-01-27 14:41:30', '2021-01-27 14:41:30'),
(43, 2243, 'امانى سعد العيوطى', NULL, NULL, 'جميزة بلجاى', NULL, 10000.00, 8, 0, NULL, '2021-01-27 14:42:41', '2021-01-27 14:42:41'),
(44, 2244, 'احمد على منصور', NULL, NULL, 'عزبة بلجاى', '01060512731', 1000.00, 8, 0, NULL, '2021-01-27 14:43:28', '2021-01-27 14:43:28'),
(45, 2245, 'المتولى ربيع', NULL, NULL, 'جميزة بلجاى', NULL, 1000.00, 8, 0, NULL, '2021-01-27 14:44:04', '2021-01-27 14:44:04'),
(46, 2246, 'المتولى عبورة', NULL, NULL, 'جميزة بلجاى', '01009542947', 1000.00, 8, 0, NULL, '2021-01-27 14:44:59', '2021-01-27 14:44:59'),
(47, 2247, 'نجلاء فتح الله', NULL, NULL, 'بلجاى', '01023366931', 1000.00, 8, 0, NULL, '2021-01-27 14:48:47', '2021-01-27 14:48:47'),
(48, 2248, 'فلة سمير فتحى الرفاعى', NULL, NULL, 'بلجاى', '01028855704', 1000.00, 8, 0, NULL, '2021-01-27 14:49:59', '2021-01-27 14:49:59'),
(49, 2249, 'حسن خطاب', NULL, NULL, 'عزبة بلجاى', NULL, 1000.00, 8, 0, NULL, '2021-01-27 14:50:38', '2021-01-27 14:50:38'),
(50, 2250, 'سامح شلبى', NULL, NULL, 'عزبة بلجاى', NULL, 1000.00, 8, 0, NULL, '2021-01-27 14:51:08', '2021-01-27 14:51:08'),
(51, 2251, 'علية عبد المولى شلبى', NULL, NULL, 'عزبة بلجاى', '01097429753', NULL, NULL, 0, NULL, '2021-01-27 14:51:55', '2021-01-27 14:51:55'),
(52, 2252, 'محمد بدوى', NULL, NULL, 'بلجاى', NULL, 1000.00, 8, 0, NULL, '2021-01-27 14:52:27', '2021-01-27 14:52:27'),
(53, 2253, 'شعبان يوسف', NULL, NULL, 'بلجاى', NULL, 1000.00, 8, 0, NULL, '2021-01-27 14:53:08', '2021-01-27 14:53:08'),
(54, 2254, 'خالد الصيفى', NULL, NULL, 'عزبة تسعين', '01090126981', 1000.00, 8, 0, NULL, '2021-01-27 14:54:06', '2021-01-27 14:54:06'),
(55, 2255, 'احمد سعد سليمان', NULL, NULL, 'جميزة بلجاى', '01553204846', 1000.00, 8, 0, NULL, '2021-01-27 14:54:51', '2021-01-27 14:54:51'),
(56, 2256, 'نادية مصطفى عبد الفتاح المتولى', NULL, NULL, 'بلجاى', '01024549682', 1000.00, 8, 0, NULL, '2021-01-27 14:56:23', '2021-01-27 14:56:23'),
(57, 2257, 'عيد ذكى زاهر', NULL, NULL, 'بلجاى', NULL, 1000.00, 8, 0, NULL, '2021-01-27 14:57:08', '2021-01-27 14:57:08'),
(58, 2258, 'عبده خميس', NULL, NULL, 'بلجاى', NULL, 1000.00, 8, 0, NULL, '2021-01-27 14:57:45', '2021-01-27 14:57:45'),
(59, 2259, 'راوية مجدى بدوى', NULL, NULL, 'بلجاى', NULL, 1000.00, 8, 0, NULL, '2021-01-27 15:00:02', '2021-01-27 15:00:02'),
(60, 2260, 'محمد رمضان مصطفى عبد العاطى', NULL, NULL, 'بلجاى', '01006432445', 1000.00, 8, 0, NULL, '2021-01-27 15:00:50', '2021-01-27 15:00:50'),
(61, 2261, 'نوال السيد قنديل', NULL, NULL, 'جميزة بلجاى', '01060959163', 1000.00, 8, 0, NULL, '2021-01-27 15:01:41', '2021-01-27 15:01:41'),
(62, 2262, 'سمر بلال راشد', NULL, NULL, 'بلجاى', '01004159338', 1000.00, 8, 0, NULL, '2021-01-27 15:02:50', '2021-01-27 15:02:50'),
(63, 2263, 'عاطف عبد العال', NULL, NULL, 'بلجاى', NULL, 1000.00, 8, 0, NULL, '2021-01-27 15:04:17', '2021-01-27 15:04:17'),
(64, 2264, 'احمد عزمى خفاجة', NULL, NULL, 'بلجاى', '01002130440', 1000.00, 8, 0, NULL, '2021-01-27 15:05:31', '2021-01-27 15:05:31'),
(65, 2265, 'ابراهيم ربيع عارف', NULL, NULL, 'بلجاى', '01095763407', 1000.00, 8, 0, NULL, '2021-01-27 15:06:30', '2021-01-27 15:06:30'),
(66, 2266, 'فكية عبد الرحيم', NULL, NULL, 'بلجاى', NULL, 1000.00, 8, 0, NULL, '2021-01-27 15:07:53', '2021-01-27 15:07:53');

-- --------------------------------------------------------

--
-- Table structure for table `clients_products`
--

CREATE TABLE `clients_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double(8,2) DEFAULT NULL,
  `piece_price` double(8,2) DEFAULT NULL,
  `purchase_price` double(8,2) DEFAULT NULL,
  `discount` double(8,2) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bill_id` bigint(20) UNSIGNED DEFAULT NULL,
  `stock_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients_products`
--

INSERT INTO `clients_products` (`id`, `quantity`, `price`, `piece_price`, `purchase_price`, `discount`, `client_id`, `product_id`, `bill_id`, `stock_id`, `user_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 135.00, 135.00, 200.00, NULL, 1, 1, 1, 3, NULL, NULL, '2021-01-25 15:42:56', '2021-01-25 15:42:56'),
(2, 1, 135.00, 135.00, 200.00, NULL, 1, 1, 2, 3, NULL, NULL, '2021-01-25 18:11:12', '2021-01-25 18:11:12');

-- --------------------------------------------------------

--
-- Table structure for table `client_open_balances`
--

CREATE TABLE `client_open_balances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `creditor` double(8,2) DEFAULT NULL,
  `debtor` double(8,2) DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `client_open_balances`
--

INSERT INTO `client_open_balances` (`id`, `creditor`, `debtor`, `client_id`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 1, '2021-01-25 15:42:20', '2021-01-25 15:42:20'),
(2, NULL, NULL, 2, '2021-01-25 18:10:44', '2021-01-25 18:10:44'),
(3, NULL, 975.00, 3, '2021-01-25 18:13:58', '2021-01-25 18:13:58'),
(4, NULL, 18185.00, 4, '2021-01-25 18:15:51', '2021-01-25 18:15:51'),
(5, NULL, 2410.00, 5, '2021-01-25 18:38:50', '2021-01-25 18:38:50'),
(6, NULL, 340.00, 6, '2021-01-25 18:41:55', '2021-01-25 18:41:55'),
(7, NULL, 375.00, 7, '2021-01-25 18:43:34', '2021-01-25 18:43:34'),
(8, NULL, 5293.00, 8, '2021-01-25 18:44:59', '2021-01-25 18:44:59'),
(9, NULL, NULL, 9, '2021-01-25 18:48:31', '2021-01-25 18:48:31'),
(10, NULL, 390.00, 10, '2021-01-25 18:49:59', '2021-01-25 18:49:59'),
(11, NULL, 987.00, 11, '2021-01-25 18:54:18', '2021-01-25 18:54:18'),
(12, NULL, 389.00, 12, '2021-01-25 18:58:07', '2021-01-25 18:58:07'),
(13, NULL, NULL, 13, '2021-01-25 19:01:11', '2021-01-25 19:01:11'),
(14, NULL, 2500.00, 14, '2021-01-25 19:03:19', '2021-01-25 19:03:19'),
(15, NULL, 4500.00, 15, '2021-01-26 14:47:08', '2021-01-26 14:47:08'),
(16, NULL, 245.00, 16, '2021-01-26 14:47:44', '2021-01-26 14:47:44'),
(17, NULL, 1285.00, 17, '2021-01-26 14:48:52', '2021-01-26 14:48:52'),
(18, NULL, 2255.00, 18, '2021-01-26 14:49:37', '2021-01-26 14:49:37'),
(19, NULL, 3215.00, 19, '2021-01-26 15:05:18', '2021-01-26 15:05:18'),
(20, NULL, 7734.00, 20, '2021-01-26 15:05:55', '2021-01-26 15:05:55'),
(21, NULL, NULL, 21, '2021-01-26 15:06:41', '2021-01-26 15:06:41'),
(22, NULL, NULL, 22, '2021-01-26 15:07:45', '2021-01-26 15:07:45'),
(23, NULL, NULL, 23, '2021-01-26 15:08:54', '2021-01-26 15:08:54'),
(24, NULL, 2153.00, 24, '2021-01-26 15:09:50', '2021-01-26 15:09:50'),
(25, NULL, 10.00, 25, '2021-01-27 14:24:18', '2021-01-27 14:24:18'),
(26, NULL, 5067.00, 26, '2021-01-27 14:25:53', '2021-01-27 14:25:53'),
(27, NULL, 618.00, 27, '2021-01-27 14:26:31', '2021-01-27 14:26:31'),
(28, NULL, 285.00, 28, '2021-01-27 14:27:58', '2021-01-27 14:27:58'),
(29, NULL, 90.00, 29, '2021-01-27 14:30:11', '2021-01-27 14:30:11'),
(30, NULL, NULL, 30, '2021-01-27 14:31:27', '2021-01-27 14:31:27'),
(31, NULL, 15.00, 31, '2021-01-27 14:32:39', '2021-01-27 14:32:39'),
(32, NULL, 510.00, 32, '2021-01-27 14:33:32', '2021-01-27 14:33:32'),
(33, NULL, 1083.00, 33, '2021-01-27 14:34:29', '2021-01-27 14:34:29'),
(34, NULL, 772.00, 34, '2021-01-27 14:35:32', '2021-01-27 14:35:32'),
(35, NULL, 185.00, 35, '2021-01-27 14:36:20', '2021-01-27 14:36:20'),
(36, NULL, 150.00, 36, '2021-01-27 14:36:56', '2021-01-27 14:36:56'),
(37, NULL, 300.00, 37, '2021-01-27 14:37:41', '2021-01-27 14:37:41'),
(38, NULL, 795.00, 38, '2021-01-27 14:38:19', '2021-01-27 14:38:19'),
(39, NULL, 5.00, 39, '2021-01-27 14:39:05', '2021-01-27 14:39:05'),
(40, NULL, 5.00, 40, '2021-01-27 14:40:04', '2021-01-27 14:40:04'),
(41, NULL, NULL, 41, '2021-01-27 14:40:48', '2021-01-27 14:40:48'),
(42, NULL, 195.00, 42, '2021-01-27 14:41:30', '2021-01-27 14:41:30'),
(43, NULL, 2440.00, 43, '2021-01-27 14:42:42', '2021-01-27 14:42:42'),
(44, NULL, NULL, 44, '2021-01-27 14:43:28', '2021-01-27 14:43:28'),
(45, NULL, NULL, 45, '2021-01-27 14:44:04', '2021-01-27 14:44:04'),
(46, NULL, NULL, 46, '2021-01-27 14:44:59', '2021-01-27 14:44:59'),
(47, NULL, 20.00, 47, '2021-01-27 14:48:47', '2021-01-27 14:48:47'),
(48, NULL, 370.00, 48, '2021-01-27 14:49:59', '2021-01-27 14:49:59'),
(49, NULL, NULL, 49, '2021-01-27 14:50:38', '2021-01-27 14:50:38'),
(50, NULL, NULL, 50, '2021-01-27 14:51:08', '2021-01-27 14:51:08'),
(51, NULL, 650.00, 51, '2021-01-27 14:51:56', '2021-01-27 14:51:56'),
(52, NULL, NULL, 52, '2021-01-27 14:52:27', '2021-01-27 14:52:27'),
(53, NULL, 950.00, 53, '2021-01-27 14:53:08', '2021-01-27 14:53:08'),
(54, NULL, 195.00, 54, '2021-01-27 14:54:06', '2021-01-27 14:54:06'),
(55, NULL, NULL, 55, '2021-01-27 14:54:51', '2021-01-27 14:54:51'),
(56, NULL, NULL, 56, '2021-01-27 14:56:24', '2021-01-27 14:56:24'),
(57, NULL, 305.00, 57, '2021-01-27 14:57:08', '2021-01-27 14:57:08'),
(58, NULL, 80.00, 58, '2021-01-27 14:57:45', '2021-01-27 14:57:45'),
(59, NULL, 85.00, 59, '2021-01-27 15:00:02', '2021-01-27 15:00:02'),
(60, NULL, NULL, 60, '2021-01-27 15:00:50', '2021-01-27 15:00:50'),
(61, NULL, NULL, 61, '2021-01-27 15:01:41', '2021-01-27 15:01:41'),
(62, NULL, NULL, 62, '2021-01-27 15:02:50', '2021-01-27 15:02:50'),
(63, NULL, 100.00, 63, '2021-01-27 15:04:17', '2021-01-27 15:04:17'),
(64, NULL, 20.00, 64, '2021-01-27 15:05:31', '2021-01-27 15:05:31'),
(65, NULL, 275.00, 65, '2021-01-27 15:06:30', '2021-01-27 15:06:30'),
(66, NULL, 455.00, 66, '2021-01-27 15:07:53', '2021-01-27 15:07:53');

-- --------------------------------------------------------

--
-- Table structure for table `dailies`
--

CREATE TABLE `dailies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_in` timestamp NULL DEFAULT NULL,
  `time_out` timestamp NULL DEFAULT NULL,
  `balance` double(8,2) DEFAULT NULL,
  `net_sales` double(8,2) DEFAULT NULL,
  `inc_dec` double(8,2) DEFAULT NULL COMMENT 'increase or decrease of the daily box balance',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dailies`
--

INSERT INTO `dailies` (`id`, `number`, `time_in`, `time_out`, `balance`, `net_sales`, `inc_dec`, `user_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'DLY-001', '2021-01-25 15:37:02', NULL, NULL, NULL, NULL, 1, NULL, '2021-01-25 15:37:02', '2021-01-25 15:37:02'),
(2, 'DLY-002', '2021-01-25 23:01:43', NULL, NULL, NULL, NULL, 1, NULL, '2021-01-25 23:01:43', '2021-01-25 23:01:43'),
(3, 'DLY-003', '2021-01-26 22:28:14', NULL, NULL, NULL, NULL, 1, NULL, '2021-01-26 22:28:14', '2021-01-26 22:28:14'),
(4, 'DLY-004', '2021-01-28 00:12:07', NULL, NULL, NULL, NULL, 1, NULL, '2021-01-28 00:12:07', '2021-01-28 00:12:07'),
(5, 'DLY-005', '2021-01-29 10:01:08', NULL, NULL, NULL, NULL, 1, NULL, '2021-01-29 10:01:08', '2021-01-29 10:01:08'),
(6, 'DLY-006', '2021-10-31 09:29:46', NULL, NULL, NULL, NULL, 1, NULL, '2021-10-31 09:29:46', '2021-10-31 09:29:46'),
(7, 'DLY-007', '2021-12-15 00:36:19', NULL, NULL, NULL, NULL, 1, NULL, '2021-12-15 00:36:19', '2021-12-15 00:36:19');

-- --------------------------------------------------------

--
-- Table structure for table `discount_products`
--

CREATE TABLE `discount_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `discount` double(8,2) DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bill_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `code`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'EX-1', 'ايجار جرج رضا', NULL, '2021-01-25 19:06:51', '2021-01-25 19:06:51'),
(2, 'EX-2', 'جمعية مروة ب 2000', NULL, '2021-01-25 19:23:00', '2021-01-25 19:23:00'),
(3, 'EX-3', 'جمعية مروة ب 5000', NULL, '2021-01-25 19:23:17', '2021-01-25 19:23:17'),
(4, 'EX-4', 'جمعية غادة السيد عبد الباسط ب 5000', NULL, '2021-01-25 19:23:54', '2021-01-25 19:23:54');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `name`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'مدير', NULL, '2021-01-25 13:05:29', NULL),
(2, 'عامل', NULL, '2021-01-25 13:05:29', NULL),
(3, 'بائع', NULL, '2021-01-25 13:05:29', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `sale_price` double(8,2) NOT NULL,
  `purchase_price` double(8,2) NOT NULL,
  `profit` double(8,2) NOT NULL,
  `for` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock_in` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `medicine_sales`
--

CREATE TABLE `medicine_sales` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double(8,2) DEFAULT NULL,
  `medicine_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `daily_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(1, '0000_00_00_000000_create_websockets_statistics_entries_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_02_12_131428_create_categories_table', 1),
(5, '2020_03_08_180423_create_permission_tables', 1),
(6, '2020_04_23_235853_create_attendances_table', 1),
(7, '2020_04_23_235853_create_balances_clients_table', 1),
(8, '2020_04_23_235853_create_balances_suppliers_table', 1),
(9, '2020_04_23_235853_create_balances_table', 1),
(10, '2020_04_23_235853_create_bills_clients_table', 1),
(11, '2020_04_23_235853_create_bills_suppliers_table', 1),
(12, '2020_04_23_235853_create_clients_products_table', 1),
(13, '2020_04_23_235853_create_clients_table', 1),
(14, '2020_04_23_235853_create_products_prices_table', 1),
(15, '2020_04_23_235853_create_products_stocks_table', 1),
(16, '2020_04_23_235853_create_products_suppliers_table', 1),
(17, '2020_04_23_235853_create_products_table', 1),
(18, '2020_04_23_235853_create_settings_table', 1),
(19, '2020_04_23_235853_create_stocks_table', 1),
(20, '2020_04_23_235853_create_suppliers_table', 1),
(21, '2020_04_23_300000_create_users_table', 1),
(22, '2020_04_24_200000_create_jobs_table', 1),
(23, '2020_05_15_105317_create_units_table', 1),
(24, '2020_06_03_171145_product_supplier_return', 1),
(25, '2020_06_03_195716_bills_suppliers_return', 1),
(26, '2020_06_20_132544_bills_clients_return', 1),
(27, '2020_06_20_132836_products_clients_return', 1),
(28, '2020_08_11_131946_create_chicks_table', 1),
(29, '2020_08_11_134333_create_chick_prices_table', 1),
(30, '2020_08_12_113948_create_chick_orders_table', 1),
(31, '2020_08_12_114803_create_booking_chicks_table', 1),
(32, '2020_08_22_140920_create_sms_table', 1),
(33, '2020_08_23_115321_create_booking_sms_table', 1),
(34, '2020_09_16_143109_create_relationships', 1),
(35, '2020_09_23_122412_create_chick_alls_table', 1),
(36, '2020_12_13_210852_create_discount_product', 1),
(37, '2020_12_15_110742_create_salaries', 1),
(38, '2020_12_15_122433_create_sms_bodies', 1),
(39, '2020_12_18_134810_create_banks_table', 1),
(40, '2020_12_20_134405_create_expenses_table', 1),
(41, '2020_12_21_091914_create_payements_table', 1),
(42, '2020_12_23_224621_create_catch_purchases_table', 1),
(43, '2020_12_26_003100_create_dailies_table', 1),
(44, '2021_01_05_140143_create_notify_expires_table', 1),
(45, '2021_01_07_225403_create_client_open_balances_table', 1),
(46, '2021_01_08_204621_create_supplier_open_balances_table', 1),
(47, '2021_01_09_012030_create_product_open_balances_table', 1),
(48, '2021_01_10_104109_create_medicines_table', 1),
(49, '2021_01_11_160728_create_medicine_sales_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

INSERT INTO `model_has_permissions` (`permission_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 1),
(3, 'App\\Models\\User', 1),
(4, 'App\\Models\\User', 1),
(5, 'App\\Models\\User', 1),
(6, 'App\\Models\\User', 1),
(7, 'App\\Models\\User', 1),
(8, 'App\\Models\\User', 1),
(9, 'App\\Models\\User', 1),
(10, 'App\\Models\\User', 1),
(11, 'App\\Models\\User', 1),
(12, 'App\\Models\\User', 1),
(13, 'App\\Models\\User', 1),
(14, 'App\\Models\\User', 1),
(15, 'App\\Models\\User', 1),
(16, 'App\\Models\\User', 1),
(17, 'App\\Models\\User', 1),
(18, 'App\\Models\\User', 1),
(19, 'App\\Models\\User', 1),
(20, 'App\\Models\\User', 1),
(21, 'App\\Models\\User', 1),
(22, 'App\\Models\\User', 1),
(23, 'App\\Models\\User', 1),
(24, 'App\\Models\\User', 1),
(25, 'App\\Models\\User', 1),
(26, 'App\\Models\\User', 1),
(27, 'App\\Models\\User', 1),
(28, 'App\\Models\\User', 1),
(29, 'App\\Models\\User', 1),
(30, 'App\\Models\\User', 1),
(31, 'App\\Models\\User', 1),
(32, 'App\\Models\\User', 1),
(33, 'App\\Models\\User', 1),
(34, 'App\\Models\\User', 1),
(35, 'App\\Models\\User', 1),
(36, 'App\\Models\\User', 1),
(37, 'App\\Models\\User', 1),
(38, 'App\\Models\\User', 1),
(39, 'App\\Models\\User', 1),
(40, 'App\\Models\\User', 1),
(41, 'App\\Models\\User', 1),
(42, 'App\\Models\\User', 1),
(43, 'App\\Models\\User', 1),
(44, 'App\\Models\\User', 1),
(45, 'App\\Models\\User', 1),
(46, 'App\\Models\\User', 1),
(47, 'App\\Models\\User', 1),
(48, 'App\\Models\\User', 1),
(49, 'App\\Models\\User', 1),
(50, 'App\\Models\\User', 1),
(51, 'App\\Models\\User', 1),
(52, 'App\\Models\\User', 1),
(53, 'App\\Models\\User', 1),
(54, 'App\\Models\\User', 1),
(55, 'App\\Models\\User', 1),
(56, 'App\\Models\\User', 1),
(57, 'App\\Models\\User', 1),
(58, 'App\\Models\\User', 1),
(59, 'App\\Models\\User', 1),
(60, 'App\\Models\\User', 1),
(61, 'App\\Models\\User', 1),
(62, 'App\\Models\\User', 1),
(63, 'App\\Models\\User', 1),
(64, 'App\\Models\\User', 1),
(65, 'App\\Models\\User', 1),
(66, 'App\\Models\\User', 1),
(67, 'App\\Models\\User', 1),
(68, 'App\\Models\\User', 1),
(69, 'App\\Models\\User', 1),
(70, 'App\\Models\\User', 1),
(71, 'App\\Models\\User', 1),
(72, 'App\\Models\\User', 1),
(73, 'App\\Models\\User', 1),
(74, 'App\\Models\\User', 1),
(75, 'App\\Models\\User', 1),
(76, 'App\\Models\\User', 1),
(77, 'App\\Models\\User', 1),
(78, 'App\\Models\\User', 1),
(79, 'App\\Models\\User', 1),
(80, 'App\\Models\\User', 1),
(81, 'App\\Models\\User', 1),
(82, 'App\\Models\\User', 1),
(83, 'App\\Models\\User', 1),
(84, 'App\\Models\\User', 1),
(85, 'App\\Models\\User', 1),
(86, 'App\\Models\\User', 1),
(87, 'App\\Models\\User', 1),
(88, 'App\\Models\\User', 1),
(89, 'App\\Models\\User', 1),
(90, 'App\\Models\\User', 1),
(91, 'App\\Models\\User', 1),
(92, 'App\\Models\\User', 1),
(93, 'App\\Models\\User', 1),
(94, 'App\\Models\\User', 1),
(95, 'App\\Models\\User', 1),
(96, 'App\\Models\\User', 1),
(97, 'App\\Models\\User', 1),
(98, 'App\\Models\\User', 1),
(99, 'App\\Models\\User', 1),
(100, 'App\\Models\\User', 1),
(101, 'App\\Models\\User', 1),
(102, 'App\\Models\\User', 1),
(103, 'App\\Models\\User', 1),
(104, 'App\\Models\\User', 1),
(105, 'App\\Models\\User', 1),
(106, 'App\\Models\\User', 1),
(107, 'App\\Models\\User', 1),
(108, 'App\\Models\\User', 1);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notify_expires`
--

CREATE TABLE `notify_expires` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remaining_days` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `sms_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_stock_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notify_expires`
--

INSERT INTO `notify_expires` (`id`, `text`, `remaining_days`, `quantity`, `is_read`, `user_id`, `sms_id`, `product_stock_id`, `created_at`, `updated_at`) VALUES
(1, 'اوشك المنتج ١ - خلطة حمام الاصدقاء رمضان نور على انتهاء صلاحيتة الكمية المتبقية منه 30 شيكارة', 0, 30, 0, 1, NULL, 1, '2021-01-25 14:45:06', '2021-01-25 14:45:06'),
(2, 'اوشك المنتج ٢ - 21%  عنانى ابراهيم سلطان على انتهاء صلاحيتة الكمية المتبقية منه 19 شيكارة', 0, 19, 0, 1, NULL, 2, '2021-01-25 23:10:27', '2021-01-25 23:10:27'),
(3, 'اوشك المنتج ٣ - ذرة عويجة القائد على انتهاء صلاحيتة الكمية المتبقية منه 2 شيكارة', 0, 2, 0, 1, NULL, 3, '2021-01-25 23:15:05', '2021-01-25 23:15:05'),
(4, 'اوشك المنتج ٤ - 23% القائد على انتهاء صلاحيتة الكمية المتبقية منه 53 شيكارة', 0, 53, 0, 1, NULL, 4, '2021-01-25 23:33:50', '2021-01-25 23:33:50'),
(5, 'اوشك المنتج ٥ - 21% القائد على انتهاء صلاحيتة الكمية المتبقية منه 181 شيكارة', 0, 181, 0, 1, NULL, 5, '2021-01-25 23:37:19', '2021-01-25 23:37:19'),
(6, 'اوشك المنتج ٦ - 19% القائد على انتهاء صلاحيتة الكمية المتبقية منه 41 شيكارة', 0, 41, 0, 1, NULL, 6, '2021-01-25 23:39:58', '2021-01-25 23:39:58'),
(7, 'اوشك المنتج ٧ - 21% شعرية القائد على انتهاء صلاحيتة الكمية المتبقية منه 8 شيكارة', 0, 8, 0, 1, NULL, 7, '2021-01-25 23:50:15', '2021-01-25 23:50:15'),
(8, 'اوشك المنتج ٨ - بط 22% كرامبل القائد على انتهاء صلاحيتة الكمية المتبقية منه 12 شيكارة', 0, 12, 0, 1, NULL, 8, '2021-01-25 23:54:06', '2021-01-25 23:54:06'),
(9, 'اوشك المنتج ٩ - حت خشن القائد على انتهاء صلاحيتة الكمية المتبقية منه 2 شيكارة', 0, 2, 0, 1, NULL, 9, '2021-01-26 00:00:04', '2021-01-26 00:00:04'),
(10, 'اوشك المنتج ١٠ - 21% الاشقاء على انتهاء صلاحيتة الكمية المتبقية منه 86 شيكارة', 0, 86, 0, 1, NULL, 10, '2021-01-26 12:59:43', '2021-01-26 12:59:43'),
(11, 'اوشك المنتج ١١ - %23 الاشقاء على انتهاء صلاحيتة الكمية المتبقية منه 37 شيكارة', 0, 37, 0, 1, NULL, 11, '2021-01-26 13:01:21', '2021-01-26 13:01:21'),
(12, 'اوشك المنتج ١٢ - 23% العنانى على انتهاء صلاحيتة الكمية المتبقية منه 24 شيكارة', 0, 24, 0, 1, NULL, 12, '2021-01-27 20:01:25', '2021-01-27 20:01:25'),
(13, 'اوشك المنتج ١٣ - 19% الاشقاء على انتهاء صلاحيتة الكمية المتبقية منه 8 شيكارة', 0, 8, 0, 1, NULL, 13, '2021-01-27 21:39:30', '2021-01-27 21:39:30'),
(14, 'اوشك المنتج ١٤ - بادى نامى 21% كرامبل الاشقاء على انتهاء صلاحيتة الكمية المتبقية منه 5 شيكارة', 0, 5, 0, 1, NULL, 14, '2021-01-28 06:09:29', '2021-01-28 06:09:29'),
(15, 'اوشك المنتج ١٥ - رده الاصيل على انتهاء صلاحيتة الكمية المتبقية منه 27 شيكارة', 0, 27, 0, 1, NULL, 15, '2021-01-29 10:08:23', '2021-01-29 10:08:23'),
(16, 'اوشك المنتج ١٦ - بياض تجارى البركة على انتهاء صلاحيتة الكمية المتبقية منه 36 شيكارة', 0, 36, 0, 1, NULL, 16, '2021-01-29 10:11:50', '2021-01-29 10:11:50'),
(17, 'اوشك المنتج ١٧ - 21.5 بيلت البركة على انتهاء صلاحيتة الكمية المتبقية منه 38 شيكارة', 0, 38, 1, 1, NULL, 17, '2021-01-29 10:14:58', '2021-01-29 12:52:25'),
(18, 'اوشك المنتج ١٨ - 21.5% بليت القمة على انتهاء صلاحيتة الكمية المتبقية منه  شيكارة', 0, NULL, 1, 1, NULL, 18, '2021-01-29 12:49:25', '2021-01-29 12:51:57'),
(19, 'اوشك المنتج ١٩ - 21.5% كرامبل القمة على انتهاء صلاحيتة الكمية المتبقية منه 4 شيكارة', 0, 4, 0, 1, NULL, 19, '2021-01-29 14:39:17', '2021-01-29 14:39:17'),
(20, 'اوشك المنتج ٢٠ - 23% القمة على انتهاء صلاحيتة الكمية المتبقية منه 2 شيكارة', 0, 2, 0, 1, NULL, 20, '2021-01-29 14:42:01', '2021-01-29 14:42:01'),
(21, 'اوشك المنتج ٢١ - ارانب مكه على انتهاء صلاحيتة الكمية المتبقية منه 8 شيكارة', 0, 8, 0, 1, NULL, 21, '2021-01-29 14:47:01', '2021-01-29 14:47:01'),
(22, 'اوشك المنتج ٢٢ - جير اخرى على انتهاء صلاحيتة الكمية المتبقية منه 20 شيكارة', 0, 20, 0, 1, NULL, 22, '2021-01-29 14:49:46', '2021-01-29 14:49:46'),
(23, 'اوشك المنتج ٢٣ - دش وسط شافعى على انتهاء صلاحيتة الكمية المتبقية منه 2 شيكارة', 0, 2, 0, 1, NULL, 23, '2021-01-29 14:51:48', '2021-01-29 14:51:48'),
(24, 'اوشك المنتج ٢٤ - بسلة اخرى على انتهاء صلاحيتة الكمية المتبقية منه 2 شيكارة', 0, 2, 0, 1, NULL, 24, '2021-01-29 14:52:51', '2021-01-29 14:52:51'),
(25, 'اوشك المنتج ٢٥ - فول اخرى على انتهاء صلاحيتة الكمية المتبقية منه 2 شيكارة', 0, 2, 0, 1, NULL, 25, '2021-01-29 14:54:40', '2021-01-29 14:54:40'),
(26, 'اوشك المنتج ٢٦ - 21% العنانى على انتهاء صلاحيتة الكمية المتبقية منه 10 شيكارة', 0, 10, 0, 1, NULL, 26, '2021-01-29 14:58:01', '2021-01-29 14:58:01'),
(27, 'اوشك المنتج ٢٧ - كسب 11% مكه على انتهاء صلاحيتة الكمية المتبقية منه 11 شيكارة', 0, 11, 0, 1, NULL, 27, '2021-01-29 14:58:58', '2021-01-29 14:58:58'),
(28, 'اوشك المنتج ٢٨ - دش خشن القائد على انتهاء صلاحيتة الكمية المتبقية منه 20 شيكارة', 0, 20, 0, 1, NULL, 28, '2021-01-29 15:00:52', '2021-01-29 15:00:52'),
(29, 'اوشك المنتج ٢٩ - دش وسط القائد على انتهاء صلاحيتة الكمية المتبقية منه 55 شيكارة', 0, 55, 0, 1, NULL, 29, '2021-01-29 15:02:08', '2021-01-29 15:02:08'),
(30, 'اوشك المنتج ٣٠ - ذره حصا الاصدقاء على انتهاء صلاحيتة الكمية المتبقية منه 8 شيكارة', 0, 8, 0, 1, NULL, 30, '2021-01-29 15:04:27', '2021-01-29 15:04:27'),
(31, 'اوشك المنتج ٣١ - 21.5% كرامبل القائد على انتهاء صلاحيتة الكمية المتبقية منه 51 شيكارة', 0, 51, 0, 1, NULL, 31, '2021-01-29 15:06:45', '2021-01-29 15:06:45'),
(32, 'اوشك المنتج ٣٢ - 21.5% بليت الاصدقاء على انتهاء صلاحيتة الكمية المتبقية منه 5 شيكارة', 0, 5, 0, 1, NULL, 32, '2021-01-29 15:07:56', '2021-01-29 15:07:56'),
(33, 'اوشك المنتج ٣٣ - بياض 16% القائد على انتهاء صلاحيتة الكمية المتبقية منه 13 شيكارة', 0, 13, 0, 1, NULL, 33, '2021-01-29 15:09:15', '2021-01-29 15:09:15');

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
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment` enum('cash','cheque') COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_type` enum('expenses','bank_deposit','pay_for_supplier') COLLATE utf8mb4_unicode_ci NOT NULL,
  `paid` double(8,2) NOT NULL,
  `bill_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_bill_id` bigint(20) UNSIGNED DEFAULT NULL,
  `balance_id` int(11) DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bank_id` bigint(20) UNSIGNED DEFAULT NULL,
  `expense_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `name_ar`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'create user', 'إنشاء مشرف', 'web', '2021-01-25 13:05:29', NULL),
(2, 'read user', 'عرض مشرف', 'web', '2021-01-25 13:05:29', NULL),
(3, 'update user', 'تعديل مشرف', 'web', '2021-01-25 13:05:29', NULL),
(4, 'delete user', 'حذف مشرف', 'web', '2021-01-25 13:05:29', NULL),
(5, 'create client', 'إنشاء عميل', 'web', '2021-01-25 13:05:29', NULL),
(6, 'read client', 'عرض عميل', 'web', '2021-01-25 13:05:29', NULL),
(7, 'update client', 'تعديل عميل', 'web', '2021-01-25 13:05:29', NULL),
(8, 'delete client', 'حذف عميل', 'web', '2021-01-25 13:05:30', NULL),
(9, 'create client_bill', 'إنشاء فاتورة عميل', 'web', '2021-01-25 13:05:30', NULL),
(10, 'read client_bill', 'عرض فاتورة عميل', 'web', '2021-01-25 13:05:30', NULL),
(11, 'update client_bill', 'تعديل فاتورة عميل', 'web', '2021-01-25 13:05:30', NULL),
(12, 'delete client_bill', 'حذف فاتورة عميل', 'web', '2021-01-25 13:05:30', NULL),
(13, 'create client_balance', 'إنشاء حساب عميل', 'web', '2021-01-25 13:05:30', NULL),
(14, 'read client_balance', 'عرض حساب عميل', 'web', '2021-01-25 13:05:30', NULL),
(15, 'update client_balance', 'تعديل حساب عميل', 'web', '2021-01-25 13:05:30', NULL),
(16, 'delete client_balance', 'حذف حساب عميل', 'web', '2021-01-25 13:05:30', NULL),
(17, 'create client_graph', 'إنشاء تقرير عميل', 'web', '2021-01-25 13:05:30', NULL),
(18, 'read client_graph', 'عرض تقرير عميل', 'web', '2021-01-25 13:05:30', NULL),
(19, 'update client_graph', 'تعديل تقرير عميل', 'web', '2021-01-25 13:05:30', NULL),
(20, 'delete client_graph', 'حذف تقرير عميل', 'web', '2021-01-25 13:05:30', NULL),
(21, 'create category', 'إنشاء تصنيف', 'web', '2021-01-25 13:05:30', NULL),
(22, 'read category', 'عرض تصنيف', 'web', '2021-01-25 13:05:30', NULL),
(23, 'update category', 'تعديل تصنيف', 'web', '2021-01-25 13:05:30', NULL),
(24, 'delete category', 'حذف تصنيف', 'web', '2021-01-25 13:05:30', NULL),
(25, 'create product', 'إنشاء منتج', 'web', '2021-01-25 13:05:30', NULL),
(26, 'read product', 'عرض منتج', 'web', '2021-01-25 13:05:30', NULL),
(27, 'update product', 'تعديل منتج', 'web', '2021-01-25 13:05:30', NULL),
(28, 'delete product', 'حذف منتج', 'web', '2021-01-25 13:05:30', NULL),
(29, 'create product_history', 'إنشاء سجل المنتج', 'web', '2021-01-25 13:05:30', NULL),
(30, 'read product_history', 'عرض سجل المنتج', 'web', '2021-01-25 13:05:30', NULL),
(31, 'update product_history', 'تعديل سجل المنتج', 'web', '2021-01-25 13:05:30', NULL),
(32, 'delete product_history', 'حذف سجل المنتج', 'web', '2021-01-25 13:05:30', NULL),
(33, 'create product_price_history', 'إنشاء سجل اسعار المنتج', 'web', '2021-01-25 13:05:30', NULL),
(34, 'read product_price_history', 'عرض سجل اسعار المنتج', 'web', '2021-01-25 13:05:30', NULL),
(35, 'update product_price_history', 'تعديل سجل اسعار المنتج', 'web', '2021-01-25 13:05:30', NULL),
(36, 'delete product_price_history', 'حذف سجل اسعار المنتج', 'web', '2021-01-25 13:05:30', NULL),
(37, 'create stock', 'إنشاء المخزن', 'web', '2021-01-25 13:05:30', NULL),
(38, 'read stock', 'عرض المخزن', 'web', '2021-01-25 13:05:30', NULL),
(39, 'update stock', 'تعديل المخزن', 'web', '2021-01-25 13:05:30', NULL),
(40, 'delete stock', 'حذف المخزن', 'web', '2021-01-25 13:05:30', NULL),
(41, 'create supplier', 'إنشاء المورد', 'web', '2021-01-25 13:05:30', NULL),
(42, 'read supplier', 'عرض المورد', 'web', '2021-01-25 13:05:30', NULL),
(43, 'update supplier', 'تعديل المورد', 'web', '2021-01-25 13:05:30', NULL),
(44, 'delete supplier', 'حذف المورد', 'web', '2021-01-25 13:05:31', NULL),
(45, 'create supplier_bill', 'إنشاء فاتورة المورد', 'web', '2021-01-25 13:05:31', NULL),
(46, 'read supplier_bill', 'عرض فاتورة المورد', 'web', '2021-01-25 13:05:31', NULL),
(47, 'update supplier_bill', 'تعديل فاتورة المورد', 'web', '2021-01-25 13:05:31', NULL),
(48, 'delete supplier_bill', 'حذف فاتورة المورد', 'web', '2021-01-25 13:05:31', NULL),
(49, 'create supplier_balance', 'إنشاء حساب المورد', 'web', '2021-01-25 13:05:31', NULL),
(50, 'read supplier_balance', 'عرض حساب المورد', 'web', '2021-01-25 13:05:31', NULL),
(51, 'update supplier_balance', 'تعديل حساب المورد', 'web', '2021-01-25 13:05:31', NULL),
(52, 'delete supplier_balance', 'حذف حساب المورد', 'web', '2021-01-25 13:05:31', NULL),
(53, 'create attendance', 'إنشاء الحضور والإنصراف', 'web', '2021-01-25 13:05:31', NULL),
(54, 'read attendance', 'عرض الحضور والإنصراف', 'web', '2021-01-25 13:05:31', NULL),
(55, 'update attendance', 'تعديل الحضور والإنصراف', 'web', '2021-01-25 13:05:31', NULL),
(56, 'delete attendance', 'حذف الحضور والإنصراف', 'web', '2021-01-25 13:05:31', NULL),
(57, 'create balance', 'إنشاء الحسابات العامة ', 'web', '2021-01-25 13:05:31', NULL),
(58, 'read balance', 'عرض الحسابات العامة ', 'web', '2021-01-25 13:05:31', NULL),
(59, 'update balance', 'تعديل الحسابات العامة ', 'web', '2021-01-25 13:05:31', NULL),
(60, 'delete balance', 'حذف الحسابات العامة ', 'web', '2021-01-25 13:05:31', NULL),
(61, 'create job', 'إنشاء الوظيفة', 'web', '2021-01-25 13:05:31', NULL),
(62, 'read job', 'عرض الوظيفة', 'web', '2021-01-25 13:05:31', NULL),
(63, 'update job', 'تعديل الوظيفة', 'web', '2021-01-25 13:05:31', NULL),
(64, 'delete job', 'حذف الوظيفة', 'web', '2021-01-25 13:05:31', NULL),
(65, 'create chick', 'إنشاء الكتاكيت', 'web', '2021-01-25 13:05:31', NULL),
(66, 'read chick', 'عرض الكتاكيت', 'web', '2021-01-25 13:05:31', NULL),
(67, 'update chick', 'تعديل الكتاكيت', 'web', '2021-01-25 13:05:31', NULL),
(68, 'delete chick', 'حذف الكتاكيت', 'web', '2021-01-25 13:05:31', NULL),
(69, 'create chick_order', 'إنشاء طلبات الكتاكيت', 'web', '2021-01-25 13:05:31', NULL),
(70, 'read chick_order', 'عرض طلبات الكتاكيت', 'web', '2021-01-25 13:05:31', NULL),
(71, 'update chick_order', 'تعديل طلبات الكتاكيت', 'web', '2021-01-25 13:05:32', NULL),
(72, 'delete chick_order', 'حذف طلبات الكتاكيت', 'web', '2021-01-25 13:05:32', NULL),
(73, 'create chick_booking', 'إنشاء حجوزات الكتاكيت', 'web', '2021-01-25 13:05:32', NULL),
(74, 'read chick_booking', 'عرض حجوزات الكتاكيت', 'web', '2021-01-25 13:05:32', NULL),
(75, 'update chick_booking', 'تعديل حجوزات الكتاكيت', 'web', '2021-01-25 13:05:32', NULL),
(76, 'delete chick_booking', 'حذف حجوزات الكتاكيت', 'web', '2021-01-25 13:05:32', NULL),
(77, 'create salary', 'إنشاء المرتبات', 'web', '2021-01-25 13:05:32', NULL),
(78, 'read salary', 'عرض المرتبات', 'web', '2021-01-25 13:05:32', NULL),
(79, 'update salary', 'تعديل المرتبات', 'web', '2021-01-25 13:05:32', NULL),
(80, 'delete salary', 'حذف المرتبات', 'web', '2021-01-25 13:05:32', NULL),
(81, 'create expenses', 'إنشاء المصروفات', 'web', '2021-01-25 13:05:32', NULL),
(82, 'read expenses', 'عرض المصروفات', 'web', '2021-01-25 13:05:32', NULL),
(83, 'update expenses', 'تعديل المصروفات', 'web', '2021-01-25 13:05:32', NULL),
(84, 'delete expenses', 'حذف المصروفات', 'web', '2021-01-25 13:05:32', NULL),
(85, 'create receipts', 'إنشاء المقبوضات', 'web', '2021-01-25 13:05:32', NULL),
(86, 'read receipts', 'عرض المقبوضات', 'web', '2021-01-25 13:05:32', NULL),
(87, 'update receipts', 'تعديل المقبوضات', 'web', '2021-01-25 13:05:32', NULL),
(88, 'delete receipts', 'حذف المقبوضات', 'web', '2021-01-25 13:05:32', NULL),
(89, 'create payments', 'إنشاء المدفوعات ', 'web', '2021-01-25 13:05:32', NULL),
(90, 'read payments', 'عرض المدفوعات ', 'web', '2021-01-25 13:05:32', NULL),
(91, 'update payments', 'تعديل المدفوعات ', 'web', '2021-01-25 13:05:32', NULL),
(92, 'delete payments', 'حذف المدفوعات ', 'web', '2021-01-25 13:05:32', NULL),
(93, 'create banks', 'إنشاء بنوك', 'web', '2021-01-25 13:05:32', NULL),
(94, 'read banks', 'عرض بنوك', 'web', '2021-01-25 13:05:32', NULL),
(95, 'update banks', 'تعديل بنوك', 'web', '2021-01-25 13:05:32', NULL),
(96, 'delete banks', 'حذف بنوك', 'web', '2021-01-25 13:05:32', NULL),
(97, 'create daily', 'إنشاء اليومية', 'web', '2021-01-25 13:05:32', NULL),
(98, 'read daily', 'عرض اليومية', 'web', '2021-01-25 13:05:33', NULL),
(99, 'update daily', 'تعديل اليومية', 'web', '2021-01-25 13:05:33', NULL),
(100, 'delete daily', 'حذف اليومية', 'web', '2021-01-25 13:05:33', NULL),
(101, 'create medicine', 'إنشاء الادوية', 'web', '2021-01-25 13:05:33', NULL),
(102, 'read medicine', 'عرض الادوية', 'web', '2021-01-25 13:05:33', NULL),
(103, 'update medicine', 'تعديل الادوية', 'web', '2021-01-25 13:05:33', NULL),
(104, 'delete medicine', 'حذف الادوية', 'web', '2021-01-25 13:05:33', NULL),
(105, 'create setting', 'إنشاء الادوية', 'web', '2021-01-25 13:05:33', NULL),
(106, 'read setting', 'عرض الادوية', 'web', '2021-01-25 13:05:33', NULL),
(107, 'update setting', 'تعديل الادوية', 'web', '2021-01-25 13:05:33', NULL),
(108, 'delete setting', 'حذف الادوية', 'web', '2021-01-25 13:05:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` double(8,2) DEFAULT NULL,
  `profit` double(8,2) NOT NULL DEFAULT 5.00,
  `discount` double(8,2) DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valid_for` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_printed` tinyint(1) NOT NULL DEFAULT 1,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `code`, `name`, `image`, `weight`, `profit`, `discount`, `notes`, `valid_for`, `is_printed`, `supplier_id`, `category_id`, `user_id`, `unit_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'خلطة حمام ', NULL, 25.00, 10.00, NULL, NULL, NULL, 1, 3, 1, NULL, 1, NULL, '2021-01-25 14:45:06', '2021-01-25 14:45:06'),
(2, 2, '21%  ', NULL, 50.00, 3.00, NULL, NULL, NULL, 1, 4, 1, NULL, 1, NULL, '2021-01-25 23:10:27', '2021-01-25 23:10:27'),
(3, 3, 'ذرة عويجة', NULL, 50.00, 50.00, NULL, NULL, NULL, 1, 2, 2, NULL, 1, NULL, '2021-01-25 23:15:04', '2021-01-25 23:15:04'),
(4, 4, '23%', NULL, 25.00, 5.00, NULL, NULL, NULL, 1, 2, 1, NULL, 1, NULL, '2021-01-25 23:33:48', '2021-01-25 23:33:48'),
(5, 5, '21%', NULL, 25.00, 5.00, 230.00, NULL, NULL, 1, 2, 1, NULL, 1, NULL, '2021-01-25 23:37:18', '2021-01-25 23:37:18'),
(6, 6, '19%', NULL, 25.00, 5.00, 230.00, NULL, NULL, 1, 2, 1, NULL, 1, NULL, '2021-01-25 23:39:56', '2021-01-25 23:39:56'),
(7, 7, '21% شعرية', NULL, 50.00, 5.00, 230.00, NULL, NULL, 1, 2, 1, NULL, 1, NULL, '2021-01-25 23:50:14', '2021-01-25 23:50:14'),
(8, 8, 'بط 22% كرامبل', NULL, 25.00, 5.00, 230.00, NULL, NULL, 1, 2, 1, NULL, 1, NULL, '2021-01-25 23:54:05', '2021-01-25 23:54:05'),
(9, 9, 'حت خشن', NULL, 50.00, 125.00, NULL, NULL, NULL, 1, 2, 1, NULL, 1, NULL, '2021-01-26 00:00:03', '2021-01-26 00:00:03'),
(10, 10, '21%', NULL, 25.00, 5.00, 250.00, NULL, NULL, 1, 7, 1, NULL, 1, NULL, '2021-01-26 12:59:42', '2021-01-26 12:59:42'),
(11, 11, '%23', NULL, 25.00, 5.00, 250.00, NULL, NULL, 1, 7, 1, NULL, 1, NULL, '2021-01-26 13:01:19', '2021-01-26 13:01:19'),
(12, 12, '23%', NULL, 50.00, 5.00, 240.00, NULL, NULL, 1, 4, 1, NULL, 1, NULL, '2021-01-27 20:01:24', '2021-01-27 20:01:24'),
(13, 13, '19%', NULL, 25.00, 5.00, 250.00, NULL, NULL, 1, 7, 1, NULL, 1, NULL, '2021-01-27 21:39:28', '2021-01-27 21:39:28'),
(14, 14, 'بادى نامى 21% كرامبل', NULL, 25.00, 3.00, NULL, NULL, NULL, 1, 7, 1, NULL, 1, NULL, '2021-01-28 06:09:28', '2021-01-28 06:09:28'),
(15, 15, 'رده', NULL, 40.00, 5.00, NULL, NULL, NULL, 1, 8, 4, NULL, 1, NULL, '2021-01-29 10:08:23', '2021-01-29 10:08:23'),
(16, 16, 'بياض تجارى', NULL, 25.00, 7.00, 200.00, NULL, NULL, 1, 1, 1, NULL, 1, NULL, '2021-01-29 10:11:49', '2021-01-29 10:11:49'),
(17, 17, '21.5 بيلت', NULL, 25.00, 5.00, 200.00, NULL, NULL, 1, 1, 2, NULL, 1, NULL, '2021-01-29 10:14:57', '2021-01-29 10:14:57'),
(18, 18, '21.5% بليت', NULL, 10.00, 5.00, 250.00, NULL, NULL, 1, 9, 1, NULL, 1, NULL, '2021-01-29 12:48:18', '2021-01-29 12:48:18'),
(19, 19, '21.5% كرامبل', NULL, 10.00, 5.00, 250.00, NULL, NULL, 1, 9, 1, NULL, 1, NULL, '2021-01-29 14:39:16', '2021-01-29 14:39:16'),
(20, 20, '23%', NULL, 25.00, 5.00, 250.00, NULL, NULL, 1, 9, 1, NULL, 1, NULL, '2021-01-29 14:42:00', '2021-01-29 14:42:00'),
(21, 21, 'ارانب', NULL, 25.00, 10.00, NULL, NULL, NULL, 1, 10, 1, NULL, 1, NULL, '2021-01-29 14:47:00', '2021-01-29 14:47:00'),
(22, 22, 'جير', NULL, 25.00, 6.00, NULL, NULL, NULL, 1, 11, 6, NULL, 1, NULL, '2021-01-29 14:49:45', '2021-01-29 14:49:45'),
(23, 23, 'دش وسط', NULL, 25.00, 5.00, NULL, NULL, NULL, 1, 12, 2, NULL, 1, NULL, '2021-01-29 14:51:47', '2021-01-29 14:51:47'),
(24, 24, 'بسلة', NULL, 25.00, 5.00, 0.00, NULL, NULL, 1, 11, 5, NULL, 1, NULL, '2021-01-29 14:52:51', '2021-01-29 14:52:51'),
(25, 25, 'فول', NULL, 25.00, 75.00, NULL, NULL, NULL, 1, 11, 5, NULL, 1, NULL, '2021-01-29 14:54:39', '2021-01-29 14:54:39'),
(26, 26, '21%', NULL, 25.00, 5.00, 240.00, NULL, NULL, 1, 4, 1, NULL, 1, NULL, '2021-01-29 14:58:00', '2021-01-29 14:58:00'),
(27, 27, 'كسب 11%', NULL, 50.00, 10.00, NULL, NULL, NULL, 1, 10, 1, NULL, 1, NULL, '2021-01-29 14:58:57', '2021-01-29 14:58:57'),
(28, 28, 'دش خشن', NULL, 25.00, 5.00, 20.00, NULL, NULL, 1, 2, 2, NULL, 1, NULL, '2021-01-29 15:00:51', '2021-01-29 15:00:51'),
(29, 29, 'دش وسط', NULL, 25.00, 5.00, 20.00, NULL, NULL, 1, 2, 2, NULL, 1, NULL, '2021-01-29 15:02:08', '2021-01-29 15:02:08'),
(30, 30, 'ذره حصا', NULL, 25.00, 5.00, 20.00, NULL, NULL, 1, 3, 2, NULL, 1, NULL, '2021-01-29 15:04:26', '2021-01-29 15:04:26'),
(31, 31, '21.5% كرامبل', NULL, 25.00, 5.00, 240.00, NULL, NULL, 1, 2, 1, NULL, 1, NULL, '2021-01-29 15:06:44', '2021-01-29 15:06:44'),
(32, 32, '21.5% بليت', NULL, 25.00, 5.00, 240.00, NULL, NULL, 1, 3, 1, NULL, 1, NULL, '2021-01-29 15:07:55', '2021-01-29 15:07:55'),
(33, 33, 'بياض 16%', NULL, 25.00, 5.00, 240.00, NULL, NULL, 1, 2, 1, NULL, 1, NULL, '2021-01-29 15:09:14', '2021-01-29 15:09:14');

-- --------------------------------------------------------

--
-- Table structure for table `products_clients_return`
--

CREATE TABLE `products_clients_return` (
  `id` int(10) UNSIGNED NOT NULL,
  `quantity` double(8,2) NOT NULL,
  `price` double(8,2) DEFAULT NULL,
  `piece_price` double(8,2) DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bill_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `stock_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products_prices`
--

CREATE TABLE `products_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `price` double(8,2) DEFAULT NULL,
  `sale_price` double(8,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_cheaper` tinyint(1) DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bill_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `finished_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products_stocks`
--

CREATE TABLE `products_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ton_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `piece_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sale_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` double(8,2) DEFAULT NULL,
  `min_quantity` double(8,2) DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bill_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `stock_id` bigint(20) UNSIGNED DEFAULT NULL,
  `expired_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_stocks`
--

INSERT INTO `products_stocks` (`id`, `ton_price`, `piece_price`, `sale_price`, `quantity`, `min_quantity`, `notes`, `user_id`, `bill_id`, `product_id`, `stock_id`, `expired_at`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, '5000', '200', '135', 23.00, NULL, NULL, NULL, 1, 1, 3, '2021-01-25 18:11:12', NULL, '2021-01-25 14:45:06', '2021-01-25 18:11:12'),
(2, '8200', '410', '420', 39.00, NULL, NULL, NULL, 2, 2, 1, '2021-01-28 06:00:49', NULL, '2021-01-25 23:10:27', '2021-01-25 23:10:27'),
(3, '5000', '100', '300', 2.00, NULL, NULL, NULL, 3, 3, 1, '2021-01-25 23:15:04', NULL, '2021-01-25 23:15:04', '2021-01-25 23:15:04'),
(4, '8000', '320', '195', 53.00, NULL, NULL, NULL, 3, 4, 4, '2021-01-25 23:33:49', NULL, '2021-01-25 23:33:49', '2021-01-25 23:33:49'),
(5, '7900', '316', '195', 181.00, NULL, NULL, NULL, 3, 5, 4, '2021-01-25 23:37:18', NULL, '2021-01-25 23:37:18', '2021-01-25 23:37:18'),
(6, '7800', '312', '195', 41.00, NULL, NULL, NULL, 3, 6, 4, '2021-01-25 23:39:57', NULL, '2021-01-25 23:39:57', '2021-01-25 23:39:57'),
(7, '7900', '158', '195', 8.00, NULL, NULL, NULL, 3, 7, 4, '2021-01-25 23:50:14', NULL, '2021-01-25 23:50:14', '2021-01-25 23:50:14'),
(8, '7200', '288', '180', 12.00, NULL, NULL, NULL, 3, 8, 4, '2021-01-25 23:54:05', NULL, '2021-01-25 23:54:05', '2021-01-25 23:54:05'),
(9, '7500', '150', '500', 2.00, NULL, NULL, NULL, 3, 9, 4, '2021-01-26 00:00:03', NULL, '2021-01-26 00:00:03', '2021-01-26 00:00:03'),
(10, '7900', '197.5', '195', 86.00, NULL, NULL, NULL, 4, 10, 1, '2021-01-28 05:46:20', NULL, '2021-01-26 12:59:42', '2021-01-26 12:59:42'),
(11, '8000', '200', '195', 37.00, NULL, NULL, NULL, 4, 11, 1, '2021-01-28 05:45:54', NULL, '2021-01-26 13:01:20', '2021-01-26 13:01:20'),
(12, '8300', '166', '420', 24.00, NULL, NULL, NULL, 2, 12, 2, '2021-01-27 20:01:24', NULL, '2021-01-27 20:01:24', '2021-01-27 20:01:24'),
(13, '7800', '312', '195', 8.00, NULL, NULL, NULL, 4, 13, 2, '2021-01-27 21:39:28', NULL, '2021-01-27 21:39:28', '2021-01-27 21:39:28'),
(14, '7500', '300', '190', 5.00, NULL, NULL, NULL, 4, 14, 2, '2021-01-28 06:09:28', NULL, '2021-01-28 06:09:28', '2021-01-28 06:09:28'),
(15, '4000', '100', '165', 27.00, NULL, NULL, NULL, 5, 15, 3, '2021-01-29 10:08:23', NULL, '2021-01-29 10:08:23', '2021-01-29 10:08:23'),
(16, '5900', '236', '150', 36.00, NULL, NULL, NULL, 6, 16, 3, '2021-01-29 10:11:49', NULL, '2021-01-29 10:11:49', '2021-01-29 10:11:49'),
(17, '7500', '300', '190', 38.00, NULL, NULL, NULL, 6, 17, 3, '2021-01-29 10:14:57', NULL, '2021-01-29 10:14:57', '2021-01-29 10:14:57'),
(18, '7500', '750', '95', 12.00, NULL, NULL, NULL, 7, 18, 2, '2021-01-29 13:00:03', NULL, '2021-01-29 12:48:18', '2021-01-29 12:48:18'),
(19, '7500', '750', '95', 4.00, NULL, NULL, NULL, 7, 19, 2, '2021-01-29 14:39:16', NULL, '2021-01-29 14:39:16', '2021-01-29 14:39:16'),
(20, '8000', '320', '195', 2.00, NULL, NULL, NULL, 7, 20, 2, '2021-01-29 14:42:00', NULL, '2021-01-29 14:42:00', '2021-01-29 14:42:00'),
(21, '4700', '188', '130', 8.00, NULL, NULL, NULL, 8, 21, 2, '2021-01-29 14:47:00', NULL, '2021-01-29 14:47:00', '2021-01-29 14:47:00'),
(22, '180', '7.2', '15', 20.00, NULL, NULL, NULL, 9, 22, 2, '2021-01-29 14:49:45', NULL, '2021-01-29 14:49:45', '2021-01-29 14:49:45'),
(23, '4750', '190', '125', 2.00, NULL, NULL, NULL, 10, 23, 3, '2021-01-29 14:51:47', NULL, '2021-01-29 14:51:47', '2021-01-29 14:51:47'),
(24, '8000', '320', '250', 2.00, NULL, NULL, NULL, 9, 24, 2, '2021-01-29 14:52:51', NULL, '2021-01-29 14:52:51', '2021-01-29 14:52:51'),
(25, '7000', '280', '250', 2.00, NULL, NULL, NULL, 9, 25, 2, '2021-01-29 14:54:39', NULL, '2021-01-29 14:54:39', '2021-01-29 14:54:39'),
(26, '8240', '329.6', '205', 10.00, NULL, NULL, NULL, 2, 26, 5, '2021-01-29 14:58:00', NULL, '2021-01-29 14:58:00', '2021-01-29 14:58:00'),
(27, '3000', '60', '160', 11.00, NULL, NULL, NULL, 8, 27, 2, '2021-01-29 14:58:57', NULL, '2021-01-29 14:58:57', '2021-01-29 14:58:57'),
(28, '4840', '193.6', '125', 20.00, NULL, NULL, NULL, 3, 28, 2, '2021-01-29 15:00:51', NULL, '2021-01-29 15:00:51', '2021-01-29 15:00:51'),
(29, '4840', '193.6', '125', 55.00, NULL, NULL, NULL, 3, 29, 2, '2021-01-29 15:02:08', NULL, '2021-01-29 15:02:08', '2021-01-29 15:02:08'),
(30, '4840', '193.6', '125', 8.00, NULL, NULL, NULL, 1, 30, 2, '2021-01-29 15:04:26', NULL, '2021-01-29 15:04:26', '2021-01-29 15:04:26'),
(31, '7500', '300', '190', 51.00, NULL, NULL, NULL, 3, 31, 2, '2021-01-29 15:06:44', NULL, '2021-01-29 15:06:44', '2021-01-29 15:06:44'),
(32, '7500', '300', '190', 5.00, NULL, NULL, NULL, 1, 32, 2, '2021-01-29 15:07:55', NULL, '2021-01-29 15:07:55', '2021-01-29 15:07:55'),
(33, '6600', '264', '170', 13.00, NULL, NULL, NULL, 3, 33, 2, '2021-01-29 15:09:14', NULL, '2021-01-29 15:09:14', '2021-01-29 15:09:14');

-- --------------------------------------------------------

--
-- Table structure for table `products_suppliers`
--

CREATE TABLE `products_suppliers` (
  `id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `piece_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bill_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_suppliers`
--

INSERT INTO `products_suppliers` (`id`, `quantity`, `price`, `piece_price`, `notes`, `product_id`, `bill_id`, `user_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 750, '5000', '200', NULL, 1, 1, NULL, NULL, '2021-01-25 14:45:06', '2021-01-25 14:45:06'),
(2, 39, '8200', '410', NULL, 2, 2, NULL, NULL, '2021-01-25 23:10:27', '2021-01-25 23:10:27'),
(3, 100, '5000', '100', NULL, 3, 3, NULL, NULL, '2021-01-25 23:15:05', '2021-01-25 23:15:05'),
(4, 1325, '8000', '320', NULL, 4, 3, NULL, NULL, '2021-01-25 23:33:49', '2021-01-25 23:33:49'),
(5, 4525, '7900', '316', NULL, 5, 3, NULL, NULL, '2021-01-25 23:37:18', '2021-01-25 23:37:18'),
(6, 1025, '7800', '312', NULL, 6, 3, NULL, NULL, '2021-01-25 23:39:57', '2021-01-25 23:39:57'),
(7, 400, '7900', '158', NULL, 7, 3, NULL, NULL, '2021-01-25 23:50:14', '2021-01-25 23:50:14'),
(8, 300, '7200', '288', NULL, 8, 3, NULL, NULL, '2021-01-25 23:54:05', '2021-01-25 23:54:05'),
(9, 100, '7500', '150', NULL, 9, 3, NULL, NULL, '2021-01-26 00:00:03', '2021-01-26 00:00:03'),
(10, 2150, '7900', '312', NULL, 10, 4, NULL, NULL, '2021-01-26 12:59:42', '2021-01-26 12:59:42'),
(11, 925, '8000', '356', NULL, 11, 4, NULL, NULL, '2021-01-26 13:01:20', '2021-01-26 13:01:20'),
(12, 1200, '8300', '166', NULL, 12, 2, NULL, NULL, '2021-01-27 20:01:24', '2021-01-27 20:01:24'),
(13, 200, '7800', '312', NULL, 13, 4, NULL, NULL, '2021-01-27 21:39:29', '2021-01-27 21:39:29'),
(14, 125, '7500', '300', NULL, 14, 4, NULL, NULL, '2021-01-28 06:09:28', '2021-01-28 06:09:28'),
(15, 1080, '4000', '100', NULL, 15, 5, NULL, NULL, '2021-01-29 10:08:23', '2021-01-29 10:08:23'),
(16, 900, '5900', '236', NULL, 16, 6, NULL, NULL, '2021-01-29 10:11:49', '2021-01-29 10:11:49'),
(17, 950, '7500', '300', NULL, 17, 6, NULL, NULL, '2021-01-29 10:14:57', '2021-01-29 10:14:57'),
(18, 12, '7500', '750', NULL, 18, 7, NULL, NULL, '2021-01-29 12:48:18', '2021-01-29 12:48:18'),
(19, 40, '7500', '750', NULL, 19, 7, NULL, NULL, '2021-01-29 14:39:16', '2021-01-29 14:39:16'),
(20, 50, '8000', '320', NULL, 20, 7, NULL, NULL, '2021-01-29 14:42:00', '2021-01-29 14:42:00'),
(21, 200, '4700', '188', NULL, 21, 8, NULL, NULL, '2021-01-29 14:47:00', '2021-01-29 14:47:00'),
(22, 500, '180', '7.2', NULL, 22, 9, NULL, NULL, '2021-01-29 14:49:45', '2021-01-29 14:49:45'),
(23, 50, '4750', '190', NULL, 23, 10, NULL, NULL, '2021-01-29 14:51:47', '2021-01-29 14:51:47'),
(24, 50, '8000', '320', NULL, 24, 9, NULL, NULL, '2021-01-29 14:52:51', '2021-01-29 14:52:51'),
(25, 50, '7000', '280', NULL, 25, 9, NULL, NULL, '2021-01-29 14:54:39', '2021-01-29 14:54:39'),
(26, 250, '8240', '329.6', NULL, 26, 2, NULL, NULL, '2021-01-29 14:58:00', '2021-01-29 14:58:00'),
(27, 550, '3000', '60', NULL, 27, 8, NULL, NULL, '2021-01-29 14:58:57', '2021-01-29 14:58:57'),
(28, 500, '4840', '193.6', NULL, 28, 3, NULL, NULL, '2021-01-29 15:00:51', '2021-01-29 15:00:51'),
(29, 1375, '4840', '193.6', NULL, 29, 3, NULL, NULL, '2021-01-29 15:02:08', '2021-01-29 15:02:08'),
(30, 200, '4840', '193.6', NULL, 30, 1, NULL, NULL, '2021-01-29 15:04:26', '2021-01-29 15:04:26'),
(31, 1275, '7500', '300', NULL, 31, 3, NULL, NULL, '2021-01-29 15:06:44', '2021-01-29 15:06:44'),
(32, 125, '7500', '300', NULL, 32, 1, NULL, NULL, '2021-01-29 15:07:55', '2021-01-29 15:07:55'),
(33, 325, '6600', '264', NULL, 33, 3, NULL, NULL, '2021-01-29 15:09:14', '2021-01-29 15:09:14');

-- --------------------------------------------------------

--
-- Table structure for table `products_suppliers_return`
--

CREATE TABLE `products_suppliers_return` (
  `id` int(10) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `piece_price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bill_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_open_balances`
--

CREATE TABLE `product_open_balances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `creditor` double(8,2) DEFAULT NULL,
  `debtor` double(8,2) DEFAULT NULL,
  `product_stock_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE `salaries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `salary` double(8,2) DEFAULT NULL,
  `increase` double(8,2) DEFAULT NULL,
  `discount` double(8,2) DEFAULT NULL,
  `notes` double(8,2) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name_ar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `manger` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lang` enum('') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('open','closed','maintenance') COLLATE utf8mb4_unicode_ci DEFAULT 'maintenance',
  `paginate` int(11) NOT NULL DEFAULT 10,
  `maintenance_message` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `maintenance_start_at` timestamp NULL DEFAULT NULL,
  `maintenance_end_at` timestamp NULL DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fb` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tw` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `android_app_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ios_app_link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_products_alert` int(11) DEFAULT NULL,
  `time_in` time DEFAULT NULL,
  `time_out` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `deleted_at`, `name_ar`, `name_en`, `address`, `manger`, `logo`, `icon`, `lang`, `email`, `description`, `keywords`, `status`, `paginate`, `maintenance_message`, `maintenance_start_at`, `maintenance_end_at`, `phone`, `fb`, `tw`, `android_app_link`, `ios_app_link`, `min_products_alert`, `time_in`, `time_out`, `created_at`, `updated_at`) VALUES
(1, NULL, 'مؤسسة الصديق للاعلاف', NULL, 'قرية بلجاى مركز المنصورة - الدقهلية', 'إدارة: الشيخ عبد المنعم خيرى وولده محمد', NULL, NULL, NULL, NULL, NULL, NULL, 'maintenance', 10, NULL, NULL, NULL, '01003871444 - 01099647084', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-01-25 13:05:33', '2021-01-25 13:05:33');

-- --------------------------------------------------------

--
-- Table structure for table `sms`
--

CREATE TABLE `sms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remaining_balance` double(8,2) NOT NULL,
  `message_price` double(8,2) NOT NULL,
  `network` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `error_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `send_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sms_bodies`
--

CREATE TABLE `sms_bodies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `code`, `name`, `address`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'STK-001', 'مخزن 1', 'بلجاى', NULL, '2021-01-25 13:05:33', '2021-01-25 13:05:33'),
(2, 'STK-002', 'مخزن 2', 'بلجاى', NULL, '2021-01-25 13:05:33', '2021-01-25 13:05:33'),
(3, 'STK-003', 'مخزن 3', 'بلجاى', NULL, '2021-01-25 13:05:33', '2021-01-25 13:05:33'),
(4, 'STK-004', 'مخزن 4', 'بلجاى', NULL, '2021-01-25 23:29:48', '2021-01-25 23:29:48'),
(5, 'STK-005', 'مخزن 5', 'بلجاى', NULL, '2021-01-25 23:30:01', '2021-01-25 23:30:01'),
(6, 'STK-006', 'مخزن 6', 'عزبة بلجاى', NULL, '2021-01-25 23:30:27', '2021-01-25 23:30:27');

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` int(11) DEFAULT NULL,
  `my_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `logo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` double(8,2) DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `suppliers`
--

INSERT INTO `suppliers` (`id`, `code`, `my_code`, `name`, `logo`, `discount`, `phone`, `address`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 24, '10527', 'البركة', NULL, 250.00, '16541564', 'جمصة', NULL, NULL, NULL),
(2, 28, '2073', 'القائد', NULL, 150.00, '12144714', 'المنصورة', NULL, NULL, NULL),
(3, 3, NULL, 'الاصدقاء', NULL, NULL, '01060666150', 'برق العز', NULL, '2021-01-25 14:42:22', '2021-01-25 23:16:46'),
(4, 4, NULL, 'العنانى', NULL, NULL, '01010163094', 'دماص', NULL, '2021-01-25 23:07:52', '2021-01-25 23:16:21'),
(5, 4, NULL, 'ابراهيم سلطان', NULL, NULL, '01010163094', 'دماص', '2021-01-25 23:08:16', '2021-01-25 23:07:52', '2021-01-25 23:08:16'),
(6, 4, NULL, 'ابراهيم سلطان', NULL, NULL, '01010163094', 'دماص', '2021-01-25 23:08:13', '2021-01-25 23:07:52', '2021-01-25 23:08:13'),
(7, 5, NULL, 'الاشقاء', NULL, 250.00, '01060666543', 'ميت العامل', NULL, '2021-01-26 12:56:53', '2021-01-26 12:56:53'),
(8, 6, NULL, 'الاصيل', NULL, NULL, '0103871444', 'السنبلاوين', NULL, '2021-01-29 10:06:15', '2021-01-29 10:06:15'),
(9, 7, NULL, 'القمة', NULL, 250.00, '01000005352', 'طنطا', NULL, '2021-01-29 12:41:40', '2021-01-29 12:41:40'),
(10, 8, NULL, 'مكه', NULL, NULL, '01006712023', 'العاشر من رمضان', NULL, '2021-01-29 14:46:06', '2021-01-29 14:46:06'),
(11, 9, NULL, 'اخرى', NULL, NULL, '010', 'بلجاى', NULL, '2021-01-29 14:47:57', '2021-01-29 14:47:57'),
(12, 10, NULL, 'شافعى', NULL, NULL, '010', 'السنبلاوين', NULL, '2021-01-29 14:50:24', '2021-01-29 14:50:24'),
(13, 11, NULL, 'سوبر ستار', NULL, NULL, '010', 'نقيطة', NULL, '2021-01-29 15:13:35', '2021-01-29 15:13:35');

-- --------------------------------------------------------

--
-- Table structure for table `supplier_open_balances`
--

CREATE TABLE `supplier_open_balances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `creditor` double(8,2) DEFAULT NULL,
  `debtor` double(8,2) DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier_open_balances`
--

INSERT INTO `supplier_open_balances` (`id`, `creditor`, `debtor`, `supplier_id`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 3, '2021-01-25 14:42:22', '2021-01-25 14:42:22'),
(2, NULL, NULL, 4, '2021-01-25 23:07:53', '2021-01-25 23:07:53'),
(3, NULL, NULL, 6, '2021-01-25 23:07:53', '2021-01-25 23:07:53'),
(4, NULL, NULL, 5, '2021-01-25 23:07:53', '2021-01-25 23:07:53'),
(5, 13000.00, NULL, 7, '2021-01-26 12:56:53', '2021-01-26 12:56:53'),
(6, 70640.00, NULL, 2, '2021-01-26 22:58:28', '2021-01-26 22:58:28'),
(7, NULL, NULL, 8, '2021-01-29 10:06:15', '2021-01-29 10:06:15'),
(8, NULL, NULL, 9, '2021-01-29 12:41:40', '2021-01-29 12:41:40'),
(9, NULL, NULL, 10, '2021-01-29 14:46:06', '2021-01-29 14:46:06'),
(10, NULL, NULL, 11, '2021-01-29 14:47:57', '2021-01-29 14:47:57'),
(11, NULL, NULL, 12, '2021-01-29 14:50:24', '2021-01-29 14:50:24'),
(12, NULL, NULL, 13, '2021-01-29 15:13:35', '2021-01-29 15:13:35');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `symbol` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `query` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `name`, `value`, `symbol`, `query`, `min`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'طن', 1000, 'طن', '*', 'ك', NULL, NULL, NULL),
(2, 'قطعة', 1, 'ق', NULL, NULL, NULL, NULL, NULL),
(3, 'كيس', 1, 'كيس', NULL, NULL, NULL, NULL, NULL),
(4, 'علبة', 1, 'ع', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `salary` double(8,2) DEFAULT 0.00,
  `salary_type` enum('monthly','weekly','daily') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credit_limit` double(8,2) DEFAULT NULL,
  `discount_limit` double(8,2) DEFAULT NULL,
  `holidays` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `device_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_id` bigint(20) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `code`, `name`, `username`, `email`, `password`, `phone`, `address`, `picture`, `salary`, `salary_type`, `credit_limit`, `discount_limit`, `holidays`, `is_active`, `device_token`, `job_id`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'ma-admin Admin', 'admin', 'ma-admin@example.com', '$2y$10$B8gMCNwNzAC5c6HCGuL0YuRZR/HZWuzmWS0oRhS8pKiOgt2zK74pm', '01099647084', 'بلجاى', NULL, 100.00, 'daily', NULL, NULL, 'الجمعة', 1, NULL, 1, NULL, '2021-01-25 13:05:29', NULL),
(2, 1254, 'احمد الكيلانى', 'الكيلانى', 'a@a.com', '$2y$10$zR0e5g1gd1SP/5HN5VXJk.OyHEtvpisM6osekTT6LL4.kIISwHoW6', '63485464134', 'عزبة خلف', NULL, 300.00, 'monthly', NULL, NULL, 'الجمعة', 1, NULL, 3, NULL, '2021-01-25 13:05:29', NULL),
(3, 3, 'كريم محمد', 'karim', 'karim@gmal.com', '$2y$10$KnrNn9YcZ0OfQNtBXMiArOZPO.gHV7CLvov4GBgX9kOSgqBRhqOni', '01064213074', 'جميزة بلجاى', '0', 60.00, 'daily', NULL, NULL, 'الجمعة,الثلاثاء', 1, NULL, 2, NULL, '2021-01-25 13:17:35', '2021-01-25 13:17:35');

-- --------------------------------------------------------

--
-- Table structure for table `websockets_statistics_entries`
--

CREATE TABLE `websockets_statistics_entries` (
  `id` int(10) UNSIGNED NOT NULL,
  `app_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `peak_connection_count` int(11) NOT NULL,
  `websocket_message_count` int(11) NOT NULL,
  `api_message_count` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendances`
--
ALTER TABLE `attendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendances_user_id_foreign` (`user_id`);

--
-- Indexes for table `balances`
--
ALTER TABLE `balances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `balances_supplier_bill_id_foreign` (`supplier_bill_id`),
  ADD KEY `balances_client_bill_id_foreign` (`client_bill_id`),
  ADD KEY `balances_user_id_foreign` (`user_id`);

--
-- Indexes for table `balances_clients`
--
ALTER TABLE `balances_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `balances_clients_bill_id_foreign` (`bill_id`),
  ADD KEY `balances_clients_booking_id_foreign` (`booking_id`),
  ADD KEY `balances_clients_client_id_foreign` (`client_id`),
  ADD KEY `balances_clients_user_id_foreign` (`user_id`);

--
-- Indexes for table `balances_suppliers`
--
ALTER TABLE `balances_suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `balances_suppliers_bill_id_foreign` (`bill_id`),
  ADD KEY `balances_suppliers_order_id_foreign` (`order_id`),
  ADD KEY `balances_suppliers_supplier_id_foreign` (`supplier_id`),
  ADD KEY `balances_suppliers_user_id_foreign` (`user_id`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bills_clients`
--
ALTER TABLE `bills_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bills_clients_user_id_foreign` (`user_id`),
  ADD KEY `bills_clients_client_id_foreign` (`client_id`);

--
-- Indexes for table `bills_clients_return`
--
ALTER TABLE `bills_clients_return`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bills_clients_return_client_id_foreign` (`client_id`),
  ADD KEY `bills_clients_return_bill_id_foreign` (`bill_id`),
  ADD KEY `bills_clients_return_user_id_foreign` (`user_id`);

--
-- Indexes for table `bills_suppliers`
--
ALTER TABLE `bills_suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bills_suppliers_supplier_id_foreign` (`supplier_id`),
  ADD KEY `bills_suppliers_user_id_foreign` (`user_id`);

--
-- Indexes for table `bills_suppliers_return`
--
ALTER TABLE `bills_suppliers_return`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bills_suppliers_return_supplier_id_foreign` (`supplier_id`),
  ADD KEY `bills_suppliers_return_bill_id_foreign` (`bill_id`),
  ADD KEY `bills_suppliers_return_user_id_foreign` (`user_id`);

--
-- Indexes for table `booking_chicks`
--
ALTER TABLE `booking_chicks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_chicks_chick_id_foreign` (`chick_id`),
  ADD KEY `booking_chicks_client_id_foreign` (`client_id`),
  ADD KEY `booking_chicks_order_id_foreign` (`order_id`),
  ADD KEY `booking_chicks_user_id_foreign` (`user_id`);

--
-- Indexes for table `booking_sms`
--
ALTER TABLE `booking_sms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_sms_sms_id_foreign` (`sms_id`),
  ADD KEY `booking_sms_booking_id_foreign` (`booking_id`),
  ADD KEY `booking_sms_client_id_foreign` (`client_id`);

--
-- Indexes for table `catch_purchases`
--
ALTER TABLE `catch_purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `catch_purchases_bill_id_foreign` (`bill_id`),
  ADD KEY `catch_purchases_invoice_id_foreign` (`invoice_id`),
  ADD KEY `catch_purchases_bank_id_foreign` (`bank_id`),
  ADD KEY `catch_purchases_user_id_foreign` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chicks`
--
ALTER TABLE `chicks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chicks_supplier_id_foreign` (`supplier_id`),
  ADD KEY `chicks_user_id_foreign` (`user_id`);

--
-- Indexes for table `chick_alls`
--
ALTER TABLE `chick_alls`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chick_orders`
--
ALTER TABLE `chick_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chick_orders_chick_id_foreign` (`chick_id`),
  ADD KEY `chick_orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `chick_prices`
--
ALTER TABLE `chick_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chick_prices_chick_id_foreign` (`chick_id`),
  ADD KEY `chick_prices_user_id_foreign` (`user_id`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `clients_products`
--
ALTER TABLE `clients_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `clients_products_client_id_foreign` (`client_id`),
  ADD KEY `clients_products_product_id_foreign` (`product_id`),
  ADD KEY `clients_products_bill_id_foreign` (`bill_id`),
  ADD KEY `clients_products_stock_id_foreign` (`stock_id`),
  ADD KEY `clients_products_user_id_foreign` (`user_id`);

--
-- Indexes for table `client_open_balances`
--
ALTER TABLE `client_open_balances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_open_balances_client_id_foreign` (`client_id`);

--
-- Indexes for table `dailies`
--
ALTER TABLE `dailies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `dailies_user_id_foreign` (`user_id`);

--
-- Indexes for table `discount_products`
--
ALTER TABLE `discount_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `discount_products_product_id_foreign` (`product_id`),
  ADD KEY `discount_products_bill_id_foreign` (`bill_id`),
  ADD KEY `discount_products_user_id_foreign` (`user_id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `jobs_name_unique` (`name`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medicine_sales`
--
ALTER TABLE `medicine_sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `medicine_sales_medicine_id_foreign` (`medicine_id`),
  ADD KEY `medicine_sales_user_id_foreign` (`user_id`),
  ADD KEY `medicine_sales_daily_id_foreign` (`daily_id`);

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
-- Indexes for table `notify_expires`
--
ALTER TABLE `notify_expires`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notify_expires_user_id_foreign` (`user_id`),
  ADD KEY `notify_expires_sms_id_foreign` (`sms_id`),
  ADD KEY `notify_expires_product_stock_id_foreign` (`product_stock_id`);

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
  ADD KEY `payments_bill_id_foreign` (`bill_id`),
  ADD KEY `payments_client_bill_id_foreign` (`client_bill_id`),
  ADD KEY `payments_supplier_id_foreign` (`supplier_id`),
  ADD KEY `payments_bank_id_foreign` (`bank_id`),
  ADD KEY `payments_expense_id_foreign` (`expense_id`),
  ADD KEY `payments_client_id_foreign` (`client_id`),
  ADD KEY `payments_user_id_foreign` (`user_id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_supplier_id_foreign` (`supplier_id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_user_id_foreign` (`user_id`),
  ADD KEY `products_unit_id_foreign` (`unit_id`);

--
-- Indexes for table `products_clients_return`
--
ALTER TABLE `products_clients_return`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_clients_return_client_id_foreign` (`client_id`),
  ADD KEY `products_clients_return_product_id_foreign` (`product_id`),
  ADD KEY `products_clients_return_bill_id_foreign` (`bill_id`),
  ADD KEY `products_clients_return_user_id_foreign` (`user_id`),
  ADD KEY `products_clients_return_stock_id_foreign` (`stock_id`);

--
-- Indexes for table `products_prices`
--
ALTER TABLE `products_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_prices_product_id_foreign` (`product_id`),
  ADD KEY `products_prices_bill_id_foreign` (`bill_id`),
  ADD KEY `products_prices_user_id_foreign` (`user_id`);

--
-- Indexes for table `products_stocks`
--
ALTER TABLE `products_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_stocks_user_id_foreign` (`user_id`),
  ADD KEY `products_stocks_bill_id_foreign` (`bill_id`),
  ADD KEY `products_stocks_product_id_foreign` (`product_id`),
  ADD KEY `products_stocks_stock_id_foreign` (`stock_id`);

--
-- Indexes for table `products_suppliers`
--
ALTER TABLE `products_suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_suppliers_product_id_foreign` (`product_id`),
  ADD KEY `products_suppliers_bill_id_foreign` (`bill_id`),
  ADD KEY `products_suppliers_user_id_foreign` (`user_id`);

--
-- Indexes for table `products_suppliers_return`
--
ALTER TABLE `products_suppliers_return`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_suppliers_return_product_id_foreign` (`product_id`),
  ADD KEY `products_suppliers_return_bill_id_foreign` (`bill_id`),
  ADD KEY `products_suppliers_return_user_id_foreign` (`user_id`);

--
-- Indexes for table `product_open_balances`
--
ALTER TABLE `product_open_balances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_open_balances_product_stock_id_foreign` (`product_stock_id`),
  ADD KEY `product_open_balances_product_id_foreign` (`product_id`);

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
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `salaries_user_id_foreign` (`user_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sms`
--
ALTER TABLE `sms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sms_client_id_foreign` (`client_id`),
  ADD KEY `sms_supplier_id_foreign` (`supplier_id`),
  ADD KEY `sms_user_id_foreign` (`user_id`);

--
-- Indexes for table `sms_bodies`
--
ALTER TABLE `sms_bodies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sms_bodies_user_id_foreign` (`user_id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier_open_balances`
--
ALTER TABLE `supplier_open_balances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supplier_open_balances_supplier_id_foreign` (`supplier_id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_job_id_foreign` (`job_id`);

--
-- Indexes for table `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendances`
--
ALTER TABLE `attendances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `balances`
--
ALTER TABLE `balances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `balances_clients`
--
ALTER TABLE `balances_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `balances_suppliers`
--
ALTER TABLE `balances_suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bills_clients`
--
ALTER TABLE `bills_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bills_clients_return`
--
ALTER TABLE `bills_clients_return`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bills_suppliers`
--
ALTER TABLE `bills_suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `bills_suppliers_return`
--
ALTER TABLE `bills_suppliers_return`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_chicks`
--
ALTER TABLE `booking_chicks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_sms`
--
ALTER TABLE `booking_sms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catch_purchases`
--
ALTER TABLE `catch_purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `chicks`
--
ALTER TABLE `chicks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chick_alls`
--
ALTER TABLE `chick_alls`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chick_orders`
--
ALTER TABLE `chick_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chick_prices`
--
ALTER TABLE `chick_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `clients_products`
--
ALTER TABLE `clients_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `client_open_balances`
--
ALTER TABLE `client_open_balances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `dailies`
--
ALTER TABLE `dailies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `discount_products`
--
ALTER TABLE `discount_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `medicine_sales`
--
ALTER TABLE `medicine_sales`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `notify_expires`
--
ALTER TABLE `notify_expires`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `products_clients_return`
--
ALTER TABLE `products_clients_return`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products_prices`
--
ALTER TABLE `products_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products_stocks`
--
ALTER TABLE `products_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `products_suppliers`
--
ALTER TABLE `products_suppliers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `products_suppliers_return`
--
ALTER TABLE `products_suppliers_return`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_open_balances`
--
ALTER TABLE `product_open_balances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sms`
--
ALTER TABLE `sms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_bodies`
--
ALTER TABLE `sms_bodies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `supplier_open_balances`
--
ALTER TABLE `supplier_open_balances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `websockets_statistics_entries`
--
ALTER TABLE `websockets_statistics_entries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendances`
--
ALTER TABLE `attendances`
  ADD CONSTRAINT `attendances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `balances`
--
ALTER TABLE `balances`
  ADD CONSTRAINT `balances_client_bill_id_foreign` FOREIGN KEY (`client_bill_id`) REFERENCES `bills_clients` (`id`),
  ADD CONSTRAINT `balances_supplier_bill_id_foreign` FOREIGN KEY (`supplier_bill_id`) REFERENCES `bills_suppliers` (`id`),
  ADD CONSTRAINT `balances_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `balances_clients`
--
ALTER TABLE `balances_clients`
  ADD CONSTRAINT `balances_clients_bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `bills_clients` (`id`),
  ADD CONSTRAINT `balances_clients_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `booking_chicks` (`id`),
  ADD CONSTRAINT `balances_clients_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `balances_clients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `balances_suppliers`
--
ALTER TABLE `balances_suppliers`
  ADD CONSTRAINT `balances_suppliers_bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `bills_suppliers` (`id`),
  ADD CONSTRAINT `balances_suppliers_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `chick_orders` (`id`),
  ADD CONSTRAINT `balances_suppliers_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `balances_suppliers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `bills_clients`
--
ALTER TABLE `bills_clients`
  ADD CONSTRAINT `bills_clients_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `bills_clients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `bills_clients_return`
--
ALTER TABLE `bills_clients_return`
  ADD CONSTRAINT `bills_clients_return_bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `bills_clients` (`id`),
  ADD CONSTRAINT `bills_clients_return_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `bills_clients_return_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `bills_suppliers`
--
ALTER TABLE `bills_suppliers`
  ADD CONSTRAINT `bills_suppliers_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `bills_suppliers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `bills_suppliers_return`
--
ALTER TABLE `bills_suppliers_return`
  ADD CONSTRAINT `bills_suppliers_return_bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `bills_suppliers` (`id`),
  ADD CONSTRAINT `bills_suppliers_return_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `bills_suppliers_return_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `booking_chicks`
--
ALTER TABLE `booking_chicks`
  ADD CONSTRAINT `booking_chicks_chick_id_foreign` FOREIGN KEY (`chick_id`) REFERENCES `chicks` (`id`),
  ADD CONSTRAINT `booking_chicks_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `booking_chicks_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `chick_orders` (`id`),
  ADD CONSTRAINT `booking_chicks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `booking_sms`
--
ALTER TABLE `booking_sms`
  ADD CONSTRAINT `booking_sms_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `booking_chicks` (`id`),
  ADD CONSTRAINT `booking_sms_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `booking_sms_sms_id_foreign` FOREIGN KEY (`sms_id`) REFERENCES `sms` (`id`);

--
-- Constraints for table `catch_purchases`
--
ALTER TABLE `catch_purchases`
  ADD CONSTRAINT `catch_purchases_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`),
  ADD CONSTRAINT `catch_purchases_bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `bills_suppliers` (`id`),
  ADD CONSTRAINT `catch_purchases_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `bills_clients` (`id`),
  ADD CONSTRAINT `catch_purchases_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `chicks`
--
ALTER TABLE `chicks`
  ADD CONSTRAINT `chicks_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `chicks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `chick_orders`
--
ALTER TABLE `chick_orders`
  ADD CONSTRAINT `chick_orders_chick_id_foreign` FOREIGN KEY (`chick_id`) REFERENCES `chicks` (`id`),
  ADD CONSTRAINT `chick_orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `chick_prices`
--
ALTER TABLE `chick_prices`
  ADD CONSTRAINT `chick_prices_chick_id_foreign` FOREIGN KEY (`chick_id`) REFERENCES `chicks` (`id`),
  ADD CONSTRAINT `chick_prices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `clients_products`
--
ALTER TABLE `clients_products`
  ADD CONSTRAINT `clients_products_bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `bills_clients` (`id`),
  ADD CONSTRAINT `clients_products_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `clients_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `clients_products_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`),
  ADD CONSTRAINT `clients_products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `client_open_balances`
--
ALTER TABLE `client_open_balances`
  ADD CONSTRAINT `client_open_balances_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);

--
-- Constraints for table `dailies`
--
ALTER TABLE `dailies`
  ADD CONSTRAINT `dailies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `discount_products`
--
ALTER TABLE `discount_products`
  ADD CONSTRAINT `discount_products_bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `bills_clients` (`id`),
  ADD CONSTRAINT `discount_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `discount_products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `medicine_sales`
--
ALTER TABLE `medicine_sales`
  ADD CONSTRAINT `medicine_sales_daily_id_foreign` FOREIGN KEY (`daily_id`) REFERENCES `dailies` (`id`),
  ADD CONSTRAINT `medicine_sales_medicine_id_foreign` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`),
  ADD CONSTRAINT `medicine_sales_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

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
-- Constraints for table `notify_expires`
--
ALTER TABLE `notify_expires`
  ADD CONSTRAINT `notify_expires_product_stock_id_foreign` FOREIGN KEY (`product_stock_id`) REFERENCES `products_stocks` (`id`),
  ADD CONSTRAINT `notify_expires_sms_id_foreign` FOREIGN KEY (`sms_id`) REFERENCES `sms` (`id`),
  ADD CONSTRAINT `notify_expires_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_bank_id_foreign` FOREIGN KEY (`bank_id`) REFERENCES `banks` (`id`),
  ADD CONSTRAINT `payments_bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `bills_suppliers` (`id`),
  ADD CONSTRAINT `payments_client_bill_id_foreign` FOREIGN KEY (`client_bill_id`) REFERENCES `bills_clients_return` (`id`),
  ADD CONSTRAINT `payments_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `payments_expense_id_foreign` FOREIGN KEY (`expense_id`) REFERENCES `expenses` (`id`),
  ADD CONSTRAINT `payments_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `products_unit_id_foreign` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  ADD CONSTRAINT `products_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products_clients_return`
--
ALTER TABLE `products_clients_return`
  ADD CONSTRAINT `products_clients_return_bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `bills_clients_return` (`id`),
  ADD CONSTRAINT `products_clients_return_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `products_clients_return_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `products_clients_return_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`),
  ADD CONSTRAINT `products_clients_return_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products_prices`
--
ALTER TABLE `products_prices`
  ADD CONSTRAINT `products_prices_bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `bills_suppliers` (`id`),
  ADD CONSTRAINT `products_prices_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `products_prices_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products_stocks`
--
ALTER TABLE `products_stocks`
  ADD CONSTRAINT `products_stocks_bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `bills_suppliers` (`id`),
  ADD CONSTRAINT `products_stocks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `products_stocks_stock_id_foreign` FOREIGN KEY (`stock_id`) REFERENCES `stocks` (`id`),
  ADD CONSTRAINT `products_stocks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products_suppliers`
--
ALTER TABLE `products_suppliers`
  ADD CONSTRAINT `products_suppliers_bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `bills_suppliers` (`id`),
  ADD CONSTRAINT `products_suppliers_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `products_suppliers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `products_suppliers_return`
--
ALTER TABLE `products_suppliers_return`
  ADD CONSTRAINT `products_suppliers_return_bill_id_foreign` FOREIGN KEY (`bill_id`) REFERENCES `bills_suppliers` (`id`),
  ADD CONSTRAINT `products_suppliers_return_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `products_suppliers_return_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `product_open_balances`
--
ALTER TABLE `product_open_balances`
  ADD CONSTRAINT `product_open_balances_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `product_open_balances_product_stock_id_foreign` FOREIGN KEY (`product_stock_id`) REFERENCES `products_stocks` (`id`);

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `salaries`
--
ALTER TABLE `salaries`
  ADD CONSTRAINT `salaries_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sms`
--
ALTER TABLE `sms`
  ADD CONSTRAINT `sms_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `sms_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `sms_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `sms_bodies`
--
ALTER TABLE `sms_bodies`
  ADD CONSTRAINT `sms_bodies_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `supplier_open_balances`
--
ALTER TABLE `supplier_open_balances`
  ADD CONSTRAINT `supplier_open_balances_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_job_id_foreign` FOREIGN KEY (`job_id`) REFERENCES `jobs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
