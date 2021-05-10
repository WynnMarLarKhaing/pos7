-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 10, 2021 at 08:47 AM
-- Server version: 5.7.33-cll-lve
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `auntylay_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE `receipts` (
  `receipt_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `sum_total` int(11) DEFAULT NULL,
  `order_type` int(2) DEFAULT NULL,
  `save_type` int(2) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `receipts`
--

INSERT INTO `receipts` (`receipt_id`, `customer_id`, `sum_total`, `order_type`, `save_type`, `created_at`, `updated_at`) VALUES
(1, 14, 5199, 1, 2, '2021-05-09 11:55:38', '2021-05-09 11:55:38'),
(2, 31, 15115, 1, 2, '2021-05-09 12:03:27', '2021-05-09 12:03:27'),
(3, 31, 16075, 1, 2, '2021-05-09 13:16:48', '2021-05-09 13:16:48'),
(4, 31, 16075, 1, 2, '2021-05-09 13:16:48', '2021-05-09 13:16:48'),
(5, 31, 15930, 1, 2, '2021-05-09 15:19:59', '2021-05-09 15:19:59'),
(6, 31, 2630, 1, 2, '2021-05-09 15:45:43', '2021-05-09 15:45:43'),
(7, 24, 48836, 1, 2, '2021-05-09 16:07:30', '2021-05-09 16:07:30'),
(8, 24, 48836, 1, 2, '2021-05-09 16:07:31', '2021-05-09 16:07:31'),
(9, 5, 38802, 1, 2, '2021-05-09 16:19:58', '2021-05-09 16:19:58'),
(10, 36, 21826, 1, 2, '2021-05-09 16:24:20', '2021-05-09 16:24:20'),
(11, 31, 119286, 1, 2, '2021-05-09 17:00:16', '2021-05-09 17:00:16'),
(12, 31, 3910, 1, 2, '2021-05-09 18:22:03', '2021-05-09 18:22:03'),
(13, 31, 6250, 1, 2, '2021-05-10 07:42:57', '2021-05-10 07:42:57'),
(14, 31, 10820, 1, 2, '2021-05-10 07:45:56', '2021-05-10 07:45:56'),
(15, 31, 4260, 1, 2, '2021-05-10 07:53:25', '2021-05-10 07:53:25'),
(16, 34, 22917, 1, 2, '2021-05-10 08:08:57', '2021-05-10 08:08:57'),
(17, 31, 11693, 1, 2, '2021-05-10 08:29:52', '2021-05-10 08:29:52'),
(18, 31, 34331, 1, 2, '2021-05-10 08:48:06', '2021-05-10 08:48:06'),
(19, 31, 1924, 1, 2, '2021-05-10 08:59:31', '2021-05-10 08:59:31'),
(20, 31, 9165, 1, 2, '2021-05-10 09:01:31', '2021-05-10 09:01:31'),
(21, 31, 16412, 1, 2, '2021-05-10 10:16:14', '2021-05-10 10:16:14'),
(22, 31, 2584, 1, 2, '2021-05-10 10:19:24', '2021-05-10 10:19:24'),
(23, 31, 2445, 1, 2, '2021-05-10 10:33:22', '2021-05-10 10:33:22'),
(24, 12, 15266, 1, 2, '2021-05-10 11:04:09', '2021-05-10 11:04:09'),
(25, 39, 2920, 1, 2, '2021-05-10 11:20:52', '2021-05-10 11:20:52'),
(26, 31, 0, 1, 2, '2021-05-10 11:41:59', '2021-05-10 11:41:59'),
(27, 7, 4300, 1, 2, '2021-05-10 13:02:00', '2021-05-10 13:02:00'),
(28, 16, 10200, 1, 1, '2021-05-10 13:05:35', '2021-05-10 13:05:35'),
(29, 16, 307250, 1, 2, '2021-05-10 13:06:51', '2021-05-10 13:06:51'),
(30, 39, 9000, 1, 1, '2021-05-10 13:13:32', '2021-05-10 13:13:32'),
(31, 39, 14629, 1, 2, '2021-05-10 13:40:55', '2021-05-10 13:40:55'),
(32, 39, 21418, 1, 2, '2021-05-10 13:59:51', '2021-05-10 13:59:51'),
(33, 14, 76024, 1, 2, '2021-05-10 14:04:49', '2021-05-10 14:04:49'),
(34, 34, 64948, 1, 2, '2021-05-10 14:27:15', '2021-05-10 14:27:15'),
(35, 37, 39964, 1, 2, '2021-05-10 14:36:05', '2021-05-10 14:36:05'),
(36, 39, 5780, 1, 2, '2021-05-10 14:39:33', '2021-05-10 14:39:33'),
(37, 39, 8934, 1, 2, '2021-05-10 14:47:16', '2021-05-10 14:47:16'),
(38, 36, 65602, 1, 2, '2021-05-10 15:30:28', '2021-05-10 15:30:28'),
(39, 31, 1292, 1, 2, '2021-05-10 15:33:55', '2021-05-10 15:33:55');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
