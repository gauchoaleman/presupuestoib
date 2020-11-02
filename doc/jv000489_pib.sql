-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 27, 2020 at 04:24 PM
-- Server version: 10.5.5-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

USE jv000489_pib;	

--
-- Database: `jv000489_pib`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Cliente prueba', '2020-10-16 21:06:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `common_jobs`
--

CREATE TABLE `common_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `paper_price_id` bigint(20) UNSIGNED NOT NULL,
  `leaf_width` double(8,2) NOT NULL,
  `leaf_height` double(8,2) NOT NULL,
  `leaf_qty_per_sheet` int(11) NOT NULL,
  `pose_width_qty` int(11) NOT NULL,
  `pose_height_qty` int(11) NOT NULL,
  `position` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `front_back` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pose_width` int(11) NOT NULL,
  `pose_height` int(11) NOT NULL,
  `copy_qty` int(11) NOT NULL,
  `front_machine` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `back_machine` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_washing_qty` int(11) DEFAULT NULL,
  `front_color_qty` int(11) NOT NULL,
  `back_color_qty` int(11) NOT NULL,
  `pantone_1` int(11) DEFAULT NULL,
  `pantone_2` int(11) DEFAULT NULL,
  `pantone_3` int(11) DEFAULT NULL,
  `pose_qty` int(11) DEFAULT NULL,
  `fold_qty` int(11) DEFAULT NULL,
  `punching_difficulty` int(11) DEFAULT NULL,
  `perforate` tinyint(1) NOT NULL,
  `tracing` tinyint(1) NOT NULL,
  `lac` tinyint(1) NOT NULL,
  `compile` tinyint(1) NOT NULL,
  `various_finishing` double(18,13) NOT NULL,
  `mounting` double(18,13) NOT NULL,
  `shipping` double(18,13) NOT NULL,
  `discount_percentage` int(11) NOT NULL,
  `plus_percentage` int(11) NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `budget_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dollar_price_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `common_jobs`
--

INSERT INTO `common_jobs` (`id`, `paper_price_id`, `leaf_width`, `leaf_height`, `leaf_qty_per_sheet`, `pose_width_qty`, `pose_height_qty`, `position`, `front_back`, `pose_width`, `pose_height`, `copy_qty`, `front_machine`, `back_machine`, `machine_washing_qty`, `front_color_qty`, `back_color_qty`, `pantone_1`, `pantone_2`, `pantone_3`, `pose_qty`, `fold_qty`, `punching_difficulty`, `perforate`, `tracing`, `lac`, `compile`, `various_finishing`, `mounting`, `shipping`, `discount_percentage`, `plus_percentage`, `client_id`, `budget_name`, `dollar_price_id`, `created_at`, `updated_at`) VALUES
(1, 17, 410.00, 220.00, 6, 4, 1, 'lying', 'front_back_width', 200, 100, 1000, 'GTO52', 'GTO46', 3, 4, 1, 123, NULL, NULL, NULL, 3, 2, 1, 0, 1, 1, 0.0000000000000, 0.0000000000000, 0.0000000000000, 0, 0, 1, 'prueba compilar en si', 1, '2020-10-19 21:53:36', NULL),
(2, 17, 410.00, 220.00, 6, 4, 1, 'lying', 'front_back_width', 200, 100, 1000, 'GTO52', 'GTO46', 3, 4, 1, 123, NULL, NULL, NULL, 3, 2, 1, 0, 1, 0, 0.0000000000000, 0.0000000000000, 0.0000000000000, 0, 0, 1, 'prueba compilar en no', 1, '2020-10-19 21:54:15', NULL),
(3, 17, 410.00, 220.00, 6, 4, 1, 'lying', 'front_back_width', 200, 100, 1000, 'GTO52', 'GTO52', 3, 4, 4, NULL, NULL, NULL, NULL, 4, NULL, 0, 0, 0, 1, 0.0000000000000, 0.0000000000000, 0.0000000000000, 0, 0, 1, 'probando precios en variables de clase', 1, '2020-10-19 23:02:25', NULL),
(4, 17, 410.00, 220.00, 6, 4, 1, 'lying', 'front_back_width', 200, 100, 1000, 'GTO52', 'GTO52', 3, 4, 4, NULL, NULL, NULL, NULL, 4, NULL, 0, 0, 0, 1, 0.0000000000000, 0.0000000000000, 0.0000000000000, 0, 0, 1, 'probando precios en variables de clase', 1, '2020-10-19 23:20:03', NULL),
(5, 17, 410.00, 220.00, 6, 4, 1, 'lying', 'front_back_width', 200, 100, 1000, 'GTO52', 'GTO52', 3, 4, 4, NULL, NULL, NULL, NULL, 4, NULL, 0, 0, 0, 1, 0.0000000000000, 0.0000000000000, 0.0000000000000, 0, 0, 1, 'probando precios en variables de clase', 1, '2020-10-19 23:20:42', NULL),
(6, 17, 410.00, 220.00, 6, 4, 1, 'lying', 'front_back_width', 200, 100, 1000, 'GTO52', 'GTO52', 3, 4, 4, NULL, NULL, NULL, NULL, 4, NULL, 0, 0, 0, 1, 0.0000000000000, 0.0000000000000, 0.0000000000000, 0, 0, 1, 'probando precios en variables de clase', 1, '2020-10-19 23:21:33', NULL),
(7, 18, 410.00, 220.00, 6, 4, 1, 'lying', 'front_back_width', 200, 100, 1000, 'GTO52', 'GTO52', 3, 4, 4, 123, 456, 789, NULL, 4, 3, 1, 1, 1, 1, 1.3333333333333, 1.3333333333333, 1.3333333333333, 10, 0, 1, 'Prueba sin variables preseteadas', 1, '2020-10-20 19:58:28', NULL),
(8, 18, 410.00, 220.00, 6, 4, 1, 'lying', 'front_back_width', 200, 100, 1000, 'GTO52', 'GTO52', 3, 4, 4, 123, 456, 789, NULL, 4, 3, 1, 1, 1, 1, 1.3333333333333, 1.3333333333333, 1.3333333333333, 10, 0, 1, 'Prueba sin variables preseteadas', 1, '2020-10-20 20:02:08', NULL),
(9, 3, 475.00, 325.00, 4, 2, 1, 'normal', 'front_back_width', 210, 297, 1000, 'GTO52', 'GTO52', NULL, 4, 4, NULL, NULL, NULL, 2, 2, NULL, 0, 0, 0, 0, 0.0000000000000, 6.6666666666667, 0.0000000000000, 0, 0, 1, 'Prueba con mama', 1, '2020-10-22 22:06:58', NULL),
(10, 3, 475.00, 325.00, 4, 2, 1, 'normal', 'front_back_width', 210, 297, 1000, 'GTO52', 'GTO52', NULL, 4, 4, NULL, NULL, NULL, 2, 2, NULL, 0, 0, 0, 0, 0.0000000000000, 5.9523809523810, 0.0000000000000, 0, 0, 1, 'Prueba con mama', 2, '2020-10-22 22:13:39', NULL),
(11, 3, 475.00, 325.00, 4, 2, 1, 'normal', 'front_back_width', 210, 297, 1000, 'GTO52', 'GTO52', NULL, 4, 4, NULL, NULL, NULL, 2, 2, NULL, 0, 0, 0, 0, 0.0000000000000, 5.9523809523810, 0.0000000000000, 0, 0, 1, 'Prueba con mama', 2, '2020-10-22 22:29:25', NULL),
(12, 17, 410.00, 220.00, 6, 2, 2, 'normal', 'front_back_width', 200, 100, 1000, 'GTO52', 'GTO52', NULL, 4, 4, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0.0000000000000, 0.0000000000000, 0.0000000000000, 0, 0, 1, 'Ctd. de planchas', 2, '2020-10-23 15:03:15', NULL),
(13, 17, 410.00, 220.00, 6, 2, 2, 'normal', 'front_back_width', 200, 100, 1000, 'GTO52', 'GTO52', NULL, 4, 4, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0.0000000000000, 0.0000000000000, 0.0000000000000, 0, 0, 1, 'Ctd. de planchas', 2, '2020-10-23 15:04:30', NULL),
(14, 10, 510.00, 360.00, 4, 1, 1, 'lying', 'normal', 300, 500, 1000, 'GTO52', 'GTO52', NULL, 4, 4, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0.0000000000000, 0.0000000000000, 0.0000000000000, 0, 0, 1, 'Ctd. de planchas', 2, '2020-10-23 15:05:35', NULL),
(15, 17, 410.00, 220.00, 6, 2, 2, 'normal', 'front_back_width', 200, 100, 1000, 'GTO52', 'GTO52', NULL, 4, 4, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0.0000000000000, 0.0000000000000, 0.0000000000000, 0, 0, 1, 'Arreglo impresión', 2, '2020-10-23 15:12:06', NULL),
(16, 17, 410.00, 220.00, 6, 2, 2, 'normal', 'front_back_width', 200, 100, 1000, 'GTO52', 'GTO52', NULL, 4, 4, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0.0000000000000, 0.0000000000000, 0.0000000000000, 0, 0, 1, 'Arreglo impresión', 2, '2020-10-23 15:14:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `dollar_prices`
--

CREATE TABLE `dollar_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `amount` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `dollar_prices`
--

INSERT INTO `dollar_prices` (`id`, `amount`, `created_at`, `updated_at`) VALUES
(1, 75.00, '2020-10-16 20:57:31', NULL),
(2, 84.00, '2020-10-22 22:13:33', NULL);

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
-- Table structure for table `leaf_sizes`
--

CREATE TABLE `leaf_sizes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `leaf_sizes_set_id` bigint(20) UNSIGNED NOT NULL,
  `sheet_width` int(11) NOT NULL,
  `sheet_height` int(11) NOT NULL,
  `leaf_width` int(11) NOT NULL,
  `leaf_height` int(11) NOT NULL,
  `leaf_qty_per_sheet` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leaf_sizes`
--

INSERT INTO `leaf_sizes` (`id`, `leaf_sizes_set_id`, `sheet_width`, `sheet_height`, `leaf_width`, `leaf_height`, `leaf_qty_per_sheet`, `created_at`, `updated_at`) VALUES
(1, 2, 950, 650, 650, 475, 2, NULL, NULL),
(2, 2, 950, 650, 650, 316, 3, NULL, NULL),
(3, 2, 950, 650, 475, 325, 4, NULL, NULL),
(4, 2, 950, 650, 475, 216, 6, NULL, NULL),
(5, 2, 950, 650, 325, 316, 6, NULL, NULL),
(6, 2, 950, 650, 413, 237, 6, NULL, NULL),
(7, 2, 950, 650, 325, 237, 8, NULL, NULL),
(8, 2, 950, 650, 316, 216, 9, NULL, NULL),
(9, 2, 950, 650, 237, 216, 12, NULL, NULL),
(10, 2, 950, 650, 237, 162, 16, NULL, NULL),
(11, 2, 950, 650, 237, 130, 20, NULL, NULL),
(12, 2, 950, 650, 216, 190, 15, NULL, NULL),
(13, 2, 950, 650, 216, 158, 18, NULL, NULL),
(14, 2, 1020, 720, 720, 510, 2, NULL, NULL),
(15, 2, 1020, 720, 720, 340, 3, NULL, NULL),
(16, 2, 1020, 720, 510, 360, 4, NULL, NULL),
(17, 2, 1020, 720, 510, 240, 6, NULL, NULL),
(18, 2, 1020, 720, 360, 340, 6, NULL, NULL),
(19, 2, 1020, 720, 465, 255, 6, NULL, NULL),
(20, 2, 1020, 720, 360, 255, 8, NULL, NULL),
(21, 2, 1020, 720, 340, 240, 9, NULL, NULL),
(22, 2, 1020, 720, 255, 240, 12, NULL, NULL),
(23, 2, 1020, 720, 255, 180, 16, NULL, NULL),
(24, 2, 1020, 720, 255, 144, 20, NULL, NULL),
(25, 2, 1020, 720, 240, 204, 15, NULL, NULL),
(26, 2, 1020, 720, 240, 120, 18, NULL, NULL),
(27, 2, 880, 630, 630, 440, 2, NULL, NULL),
(28, 2, 880, 630, 630, 293, 3, NULL, NULL),
(29, 2, 880, 630, 440, 515, 4, NULL, NULL),
(30, 2, 880, 630, 440, 210, 6, NULL, NULL),
(31, 2, 880, 630, 315, 293, 6, NULL, NULL),
(32, 2, 880, 630, 410, 220, 6, NULL, NULL),
(33, 2, 880, 630, 315, 220, 8, NULL, NULL),
(34, 2, 880, 630, 293, 210, 9, NULL, NULL),
(35, 2, 880, 630, 220, 210, 12, NULL, NULL),
(36, 2, 880, 630, 220, 157, 16, NULL, NULL),
(37, 2, 880, 630, 220, 126, 20, NULL, NULL),
(38, 2, 880, 630, 210, 176, 15, NULL, NULL),
(39, 2, 880, 630, 210, 146, 18, NULL, NULL),
(40, 2, 920, 720, 720, 460, 2, NULL, NULL),
(41, 2, 920, 720, 720, 306, 3, NULL, NULL),
(42, 2, 920, 720, 460, 360, 4, NULL, NULL),
(43, 2, 920, 720, 460, 240, 6, NULL, NULL),
(44, 2, 920, 720, 360, 306, 6, NULL, NULL),
(45, 2, 920, 720, 490, 230, 6, NULL, NULL),
(46, 2, 920, 720, 360, 230, 8, NULL, NULL),
(47, 2, 920, 720, 306, 240, 9, NULL, NULL),
(48, 2, 920, 720, 230, 240, 12, NULL, NULL),
(49, 2, 920, 720, 230, 180, 16, NULL, NULL),
(50, 2, 920, 720, 230, 144, 20, NULL, NULL),
(51, 2, 920, 720, 240, 184, 15, NULL, NULL),
(52, 2, 920, 720, 240, 153, 18, NULL, NULL),
(53, 2, 1100, 740, 740, 550, 2, NULL, NULL),
(54, 2, 1100, 740, 550, 370, 4, NULL, NULL),
(55, 2, 1100, 740, 550, 246, 6, NULL, NULL),
(56, 2, 1100, 740, 366, 370, 6, NULL, NULL),
(57, 2, 1100, 740, 465, 275, 6, NULL, NULL),
(58, 2, 1100, 740, 370, 275, 8, NULL, NULL),
(59, 2, 1100, 740, 366, 246, 9, NULL, NULL),
(60, 2, 1100, 740, 275, 246, 12, NULL, NULL),
(61, 2, 1100, 740, 275, 185, 16, NULL, NULL),
(62, 2, 1100, 740, 275, 148, 20, NULL, NULL),
(63, 2, 1100, 740, 246, 220, 15, NULL, NULL),
(64, 2, 1100, 740, 246, 183, 18, NULL, NULL),
(65, 3, 950, 650, 650, 475, 2, NULL, NULL),
(66, 3, 950, 650, 650, 316, 3, NULL, NULL),
(67, 3, 950, 650, 475, 325, 4, NULL, NULL),
(68, 3, 950, 650, 475, 216, 6, NULL, NULL),
(69, 3, 950, 650, 325, 316, 6, NULL, NULL),
(70, 3, 950, 650, 413, 237, 6, NULL, NULL),
(71, 3, 950, 650, 325, 237, 8, NULL, NULL),
(72, 3, 950, 650, 316, 216, 9, NULL, NULL),
(73, 3, 950, 650, 237, 216, 12, NULL, NULL),
(74, 3, 950, 650, 237, 162, 16, NULL, NULL),
(75, 3, 950, 650, 237, 130, 20, NULL, NULL),
(76, 3, 950, 650, 216, 190, 15, NULL, NULL),
(77, 3, 950, 650, 216, 158, 18, NULL, NULL),
(78, 3, 1020, 720, 720, 510, 2, NULL, NULL),
(79, 3, 1020, 720, 720, 340, 3, NULL, NULL),
(80, 3, 1020, 720, 510, 360, 4, NULL, NULL),
(81, 3, 1020, 720, 510, 240, 6, NULL, NULL),
(82, 3, 1020, 720, 360, 340, 6, NULL, NULL),
(83, 3, 1020, 720, 465, 255, 6, NULL, NULL),
(84, 3, 1020, 720, 360, 255, 8, NULL, NULL),
(85, 3, 1020, 720, 340, 240, 9, NULL, NULL),
(86, 3, 1020, 720, 255, 240, 12, NULL, NULL),
(87, 3, 1020, 720, 255, 180, 16, NULL, NULL),
(88, 3, 1020, 720, 255, 144, 20, NULL, NULL),
(89, 3, 1020, 720, 240, 204, 15, NULL, NULL),
(90, 3, 1020, 720, 240, 120, 18, NULL, NULL),
(91, 3, 880, 630, 630, 440, 2, NULL, NULL),
(92, 3, 880, 630, 630, 293, 3, NULL, NULL),
(93, 3, 880, 630, 440, 315, 4, NULL, NULL),
(94, 3, 880, 630, 440, 210, 6, NULL, NULL),
(95, 3, 880, 630, 315, 293, 6, NULL, NULL),
(96, 3, 880, 630, 410, 220, 6, NULL, NULL),
(97, 3, 880, 630, 315, 220, 8, NULL, NULL),
(98, 3, 880, 630, 293, 210, 9, NULL, NULL),
(99, 3, 880, 630, 220, 210, 12, NULL, NULL),
(100, 3, 880, 630, 220, 157, 16, NULL, NULL),
(101, 3, 880, 630, 220, 126, 20, NULL, NULL),
(102, 3, 880, 630, 210, 176, 15, NULL, NULL),
(103, 3, 880, 630, 210, 146, 18, NULL, NULL),
(104, 3, 920, 720, 720, 460, 2, NULL, NULL),
(105, 3, 920, 720, 720, 306, 3, NULL, NULL),
(106, 3, 920, 720, 460, 360, 4, NULL, NULL),
(107, 3, 920, 720, 460, 240, 6, NULL, NULL),
(108, 3, 920, 720, 360, 306, 6, NULL, NULL),
(109, 3, 920, 720, 490, 230, 6, NULL, NULL),
(110, 3, 920, 720, 360, 230, 8, NULL, NULL),
(111, 3, 920, 720, 306, 240, 9, NULL, NULL),
(112, 3, 920, 720, 230, 240, 12, NULL, NULL),
(113, 3, 920, 720, 230, 180, 16, NULL, NULL),
(114, 3, 920, 720, 230, 144, 20, NULL, NULL),
(115, 3, 920, 720, 240, 184, 15, NULL, NULL),
(116, 3, 920, 720, 240, 153, 18, NULL, NULL),
(117, 3, 1100, 740, 740, 550, 2, NULL, NULL),
(118, 3, 1100, 740, 550, 370, 4, NULL, NULL),
(119, 3, 1100, 740, 550, 246, 6, NULL, NULL),
(120, 3, 1100, 740, 366, 370, 6, NULL, NULL),
(121, 3, 1100, 740, 465, 275, 6, NULL, NULL),
(122, 3, 1100, 740, 370, 275, 8, NULL, NULL),
(123, 3, 1100, 740, 366, 246, 9, NULL, NULL),
(124, 3, 1100, 740, 275, 246, 12, NULL, NULL),
(125, 3, 1100, 740, 275, 185, 16, NULL, NULL),
(126, 3, 1100, 740, 275, 148, 20, NULL, NULL),
(127, 3, 1100, 740, 246, 220, 15, NULL, NULL),
(128, 3, 1100, 740, 246, 183, 18, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `leaf_sizes_sets`
--

CREATE TABLE `leaf_sizes_sets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leaf_sizes_sets`
--

INSERT INTO `leaf_sizes_sets` (`id`, `created_at`, `updated_at`) VALUES
(1, '2020-10-16 21:48:11', NULL),
(2, '2020-10-16 21:48:29', NULL),
(3, '2020-10-22 22:06:23', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `magazine_foil_numbers`
--

CREATE TABLE `magazine_foil_numbers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `magazine_job_id` bigint(20) UNSIGNED NOT NULL,
  `magazine_unique_paper_id` bigint(20) UNSIGNED NOT NULL,
  `foil_number` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `magazine_foil_numbers`
--

INSERT INTO `magazine_foil_numbers` (`id`, `magazine_job_id`, `magazine_unique_paper_id`, `foil_number`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, '2020-10-22 23:05:28', NULL),
(2, 1, 2, 1, '2020-10-22 23:05:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `magazine_jobs`
--

CREATE TABLE `magazine_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pose_width` int(11) NOT NULL,
  `pose_height` int(11) NOT NULL,
  `copy_qty` int(11) NOT NULL,
  `page_qty` int(11) NOT NULL,
  `finishing` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `machine_washing_qty` int(11) DEFAULT NULL,
  `mounting` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shipping` double(18,13) NOT NULL,
  `discount_percentage` int(11) NOT NULL,
  `plus_percentage` int(11) NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `budget_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dollar_price_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `magazine_jobs`
--

INSERT INTO `magazine_jobs` (`id`, `pose_width`, `pose_height`, `copy_qty`, `page_qty`, `finishing`, `machine_washing_qty`, `mounting`, `shipping`, `discount_percentage`, `plus_percentage`, `client_id`, `budget_name`, `dollar_price_id`, `created_at`, `updated_at`) VALUES
(1, 200, 100, 1000, 4, 'Gramp', NULL, 'Easy', 0.0000000000000, 0, 0, 1, 'Prueba compilado', 2, '2020-10-22 23:05:28', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `magazine_unique_papers`
--

CREATE TABLE `magazine_unique_papers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `magazine_job_id` bigint(20) UNSIGNED NOT NULL,
  `paper_price_id` bigint(20) UNSIGNED NOT NULL,
  `leaf_width` double(8,2) NOT NULL,
  `leaf_height` double(8,2) NOT NULL,
  `leaf_qty_per_sheet` int(11) NOT NULL,
  `pose_width_qty` int(11) NOT NULL,
  `pose_height_qty` int(11) NOT NULL,
  `position` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `front_back` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `front_machine` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `back_machine` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `front_color_qty` int(11) NOT NULL,
  `back_color_qty` int(11) NOT NULL,
  `front_pantone` int(11) DEFAULT NULL,
  `back_pantone` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `magazine_unique_papers`
--

INSERT INTO `magazine_unique_papers` (`id`, `magazine_job_id`, `paper_price_id`, `leaf_width`, `leaf_height`, `leaf_qty_per_sheet`, `pose_width_qty`, `pose_height_qty`, `position`, `front_back`, `front_machine`, `back_machine`, `front_color_qty`, `back_color_qty`, `front_pantone`, `back_pantone`, `created_at`, `updated_at`) VALUES
(1, 1, 17, 410.00, 220.00, 6, 1, 2, 'normal', 'normal', 'GTO52', 'GTO52', 4, 4, NULL, NULL, '2020-10-22 23:05:28', NULL),
(2, 1, 44, 410.00, 220.00, 6, 1, 2, 'normal', 'normal', 'GTO46', 'GTO46', 1, 1, NULL, NULL, '2020-10-22 23:05:28', NULL);

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
(1, '2019_08_19_000000_create_failed_jobs_table', 1),
(2, '2020_04_29_201222_create_paper_prices_sets_table', 1),
(3, '2020_04_29_201222_create_paper_sizes_sets_table', 1),
(4, '2020_04_30_200456_create_paper_types_table', 1),
(5, '2020_04_30_200523_create_paper_colors_table', 1),
(6, '2020_04_30_200554_create_paper_prices_table', 1),
(7, '2020_04_30_200554_create_paper_sizes_table', 1),
(8, '2020_05_03_185327_create_dollar_prices_table', 1),
(9, '2020_06_30_171140_create_clients_table', 1),
(11, '2020_10_02_170151_create_magazine_jobs_table', 1),
(12, '2020_10_02_172800_create_magazine_unique_papers_table', 1),
(13, '2020_10_02_182922_create_magazine_foil_numbers_table', 1),
(14, '2020_04_29_201222_create_leaf_sizes_sets_table', 2),
(15, '2020_04_30_200554_create_leaf_sizes_table', 2),
(16, '2020_08_02_125703_create_common_jobs_table', 3),
(17, '2020_10_19_192209_create_work_prices_sets_table', 4),
(18, '2020_10_19_192301_create_work_prices_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `paper_colors`
--

CREATE TABLE `paper_colors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paper_colors`
--

INSERT INTO `paper_colors` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'blanco', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `paper_prices`
--

CREATE TABLE `paper_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `paper_prices_set_id` bigint(20) UNSIGNED NOT NULL,
  `paper_type_id` bigint(20) UNSIGNED NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `paper_color_id` bigint(20) UNSIGNED NOT NULL,
  `sheet_price` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paper_prices`
--

INSERT INTO `paper_prices` (`id`, `paper_prices_set_id`, `paper_type_id`, `width`, `height`, `weight`, `paper_color_id`, `sheet_price`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 950, 650, 90, 1, 0.13, NULL, NULL),
(2, 1, 1, 950, 650, 115, 1, 0.16, NULL, NULL),
(3, 1, 1, 950, 650, 150, 1, 0.21, NULL, NULL),
(4, 1, 1, 950, 650, 170, 1, 0.24, NULL, NULL),
(5, 1, 1, 950, 650, 200, 1, 0.28, NULL, NULL),
(6, 1, 1, 950, 650, 225, 1, 0.33, NULL, NULL),
(7, 1, 1, 950, 650, 300, 1, 0.44, NULL, NULL),
(8, 1, 1, 1020, 720, 90, 1, 0.16, NULL, NULL),
(9, 1, 1, 1020, 720, 115, 1, 0.19, NULL, NULL),
(10, 1, 1, 1020, 720, 150, 1, 0.25, NULL, NULL),
(11, 1, 1, 1020, 720, 170, 1, 0.28, NULL, NULL),
(12, 1, 1, 1020, 720, 200, 1, 0.35, NULL, NULL),
(13, 1, 1, 1020, 720, 225, 1, 0.40, NULL, NULL),
(14, 1, 1, 1020, 720, 300, 1, 0.53, NULL, NULL),
(15, 1, 1, 880, 630, 90, 1, 0.11, NULL, NULL),
(16, 1, 1, 880, 630, 115, 1, 0.15, NULL, NULL),
(17, 1, 1, 880, 630, 150, 1, 0.19, NULL, NULL),
(18, 1, 1, 880, 630, 170, 1, 0.21, NULL, NULL),
(19, 1, 1, 880, 630, 200, 1, 0.27, NULL, NULL),
(20, 1, 1, 880, 630, 225, 1, 0.30, NULL, NULL),
(21, 1, 1, 880, 630, 300, 1, 0.40, NULL, NULL),
(22, 1, 2, 950, 650, 70, 1, 0.09, NULL, NULL),
(23, 1, 2, 950, 650, 80, 1, 0.10, NULL, NULL),
(24, 1, 2, 950, 650, 90, 1, 0.12, NULL, NULL),
(25, 1, 2, 950, 650, 106, 1, 0.15, NULL, NULL),
(26, 1, 2, 950, 650, 118, 1, 0.16, NULL, NULL),
(27, 1, 2, 1020, 720, 70, 1, 0.11, NULL, NULL),
(28, 1, 2, 1020, 720, 80, 1, 0.12, NULL, NULL),
(29, 1, 2, 1020, 720, 90, 1, 0.14, NULL, NULL),
(30, 1, 2, 1020, 720, 106, 1, 0.17, NULL, NULL),
(31, 1, 2, 1020, 720, 118, 1, 0.19, NULL, NULL),
(32, 1, 2, 1100, 740, 70, 1, 0.12, NULL, NULL),
(33, 1, 2, 1100, 740, 80, 1, 0.14, NULL, NULL),
(34, 1, 2, 1100, 740, 90, 1, 0.15, NULL, NULL),
(35, 1, 2, 1100, 740, 106, 1, 0.19, NULL, NULL),
(36, 1, 2, 1100, 740, 118, 1, 0.21, NULL, NULL),
(37, 1, 2, 920, 720, 70, 1, 0.10, NULL, NULL),
(38, 1, 2, 920, 720, 80, 1, 0.11, NULL, NULL),
(39, 1, 2, 920, 720, 90, 1, 0.13, NULL, NULL),
(40, 1, 2, 920, 720, 106, 1, 0.16, NULL, NULL),
(41, 1, 2, 920, 720, 118, 1, 0.17, NULL, NULL),
(42, 1, 2, 880, 630, 70, 1, 0.08, NULL, NULL),
(43, 1, 2, 880, 630, 80, 1, 0.09, NULL, NULL),
(44, 1, 2, 880, 630, 90, 1, 0.11, NULL, NULL),
(45, 1, 2, 880, 630, 106, 1, 0.13, NULL, NULL),
(46, 1, 2, 880, 630, 118, 1, 0.15, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `paper_prices_sets`
--

CREATE TABLE `paper_prices_sets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paper_prices_sets`
--

INSERT INTO `paper_prices_sets` (`id`, `created_at`, `updated_at`) VALUES
(1, '2020-10-16 20:57:02', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `paper_types`
--

CREATE TABLE `paper_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paper_types`
--

INSERT INTO `paper_types` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'ilustración', NULL, NULL),
(2, 'obra', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `work_prices`
--

CREATE TABLE `work_prices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `work_prices_set_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_prices`
--

INSERT INTO `work_prices` (`id`, `work_prices_set_id`, `name`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 'guillotine', 3.00, NULL, NULL),
(2, 1, 'Adast plate', 10.00, NULL, NULL),
(3, 1, 'GTO52 plate', 6.00, NULL, NULL),
(4, 1, 'GTO46 plate', 6.00, NULL, NULL),
(5, 1, 'Adast printing arrangement', 4.40, NULL, NULL),
(6, 1, 'GTO52 printing arrangement', 2.80, NULL, NULL),
(7, 1, 'GTO46 printing arrangement', 2.80, NULL, NULL),
(8, 1, 'machine washing', 5.00, NULL, NULL),
(9, 1, 'cmyk ink', 15.25, NULL, NULL),
(10, 1, 'pantone ink', 35.00, NULL, NULL),
(11, 1, 'folding arrangement', 4.50, NULL, NULL),
(12, 1, 'folding per qty', 4.50, NULL, NULL),
(13, 1, 'punching arrangement', 5.00, NULL, NULL),
(14, 1, 'punching per qty', 5.00, NULL, NULL),
(15, 1, 'break out', 4.00, NULL, NULL),
(16, 1, 'perforating arrangement', 4.00, NULL, NULL),
(17, 1, 'perforating per qty', 4.00, NULL, NULL),
(18, 1, 'tracing arrangement', 4.00, NULL, NULL),
(19, 1, 'tracing per qty', 4.00, NULL, NULL),
(20, 1, 'lac arrangement', 4.40, NULL, NULL),
(21, 1, 'lac per qty', 5.00, NULL, NULL),
(22, 1, 'compile', 4.50, NULL, NULL),
(23, 1, 'Adast printing', 10.00, NULL, NULL),
(24, 1, 'GTO52 printing', 4.00, NULL, NULL),
(25, 1, 'GTO46 printing', 6.00, NULL, NULL),
(26, 2, 'guillotine', 3.00, NULL, NULL),
(27, 2, 'Adast plate', 10.00, NULL, NULL),
(28, 2, 'GTO52 plate', 6.00, NULL, NULL),
(29, 2, 'GTO46 plate', 6.00, NULL, NULL),
(30, 2, 'Adast printing arrangement', 4.40, NULL, NULL),
(31, 2, 'GTO52 printing arrangement', 2.80, NULL, NULL),
(32, 2, 'GTO46 printing arrangement', 2.80, NULL, NULL),
(33, 2, 'machine washing', 5.00, NULL, NULL),
(34, 2, 'cmyk ink', 15.25, NULL, NULL),
(35, 2, 'pantone ink', 35.00, NULL, NULL),
(36, 2, 'folding arrangement', 4.50, NULL, NULL),
(37, 2, 'folding per qty', 4.50, NULL, NULL),
(38, 2, 'punching arrangement', 5.00, NULL, NULL),
(39, 2, 'punching per qty', 5.00, NULL, NULL),
(40, 2, 'break out', 4.00, NULL, NULL),
(41, 2, 'perforating arrangement', 4.00, NULL, NULL),
(42, 2, 'perforating per qty', 4.00, NULL, NULL),
(43, 2, 'tracing arrangement', 4.00, NULL, NULL),
(44, 2, 'tracing per qty', 4.00, NULL, NULL),
(45, 2, 'lac arrangement', 4.40, NULL, NULL),
(46, 2, 'lac per qty', 5.00, NULL, NULL),
(47, 2, 'compile per qty', 4.50, NULL, NULL),
(48, 2, 'Adast printing', 10.00, NULL, NULL),
(49, 2, 'GTO52 printing', 4.00, NULL, NULL),
(50, 2, 'GTO46 printing', 6.00, NULL, NULL),
(51, 3, 'guillotine', 3.00, NULL, NULL),
(52, 3, 'Adast plate', 10.00, NULL, NULL),
(53, 3, 'GTO52 plate', 6.00, NULL, NULL),
(54, 3, 'GTO46 plate', 6.00, NULL, NULL),
(55, 3, 'Adast printing arrangement', 4.40, NULL, NULL),
(56, 3, 'GTO52 printing arrangement', 2.80, NULL, NULL),
(57, 3, 'GTO46 printing arrangement', 2.80, NULL, NULL),
(58, 3, 'machine washing', 5.00, NULL, NULL),
(59, 3, 'cmyk ink', 15.25, NULL, NULL),
(60, 3, 'pantone ink', 35.00, NULL, NULL),
(61, 3, 'folding arrangement', 4.50, NULL, NULL),
(62, 3, 'folding per qty', 4.50, NULL, NULL),
(63, 3, 'punching arrangement', 5.00, NULL, NULL),
(64, 3, 'punching per qty', 5.00, NULL, NULL),
(65, 3, 'break out per qty', 4.00, NULL, NULL),
(66, 3, 'perforating arrangement', 4.00, NULL, NULL),
(67, 3, 'perforating per qty', 4.00, NULL, NULL),
(68, 3, 'tracing arrangement', 4.00, NULL, NULL),
(69, 3, 'tracing per qty', 4.00, NULL, NULL),
(70, 3, 'lac arrangement', 4.40, NULL, NULL),
(71, 3, 'lac per qty', 5.00, NULL, NULL),
(72, 3, 'compile per qty', 4.50, NULL, NULL),
(73, 3, 'Adast printing', 10.00, NULL, NULL),
(74, 3, 'GTO52 printing', 4.00, NULL, NULL),
(75, 3, 'GTO46 printing', 6.00, NULL, NULL),
(76, 4, 'guillotine', 3.00, NULL, NULL),
(77, 4, 'Adast plate', 10.00, NULL, NULL),
(78, 4, 'GTO52 plate', 6.00, NULL, NULL),
(79, 4, 'GTO46 plate', 6.00, NULL, NULL),
(80, 4, 'Adast printing arrangement', 4.40, NULL, NULL),
(81, 4, 'GTO52 printing arrangement', 2.80, NULL, NULL),
(82, 4, 'GTO46 printing arrangement', 2.80, NULL, NULL),
(83, 4, 'machine washing', 5.00, NULL, NULL),
(84, 4, 'cmyk ink kilo', 15.25, NULL, NULL),
(85, 4, 'pantone ink kilo', 35.00, NULL, NULL),
(86, 4, 'folding arrangement', 4.50, NULL, NULL),
(87, 4, 'folding per qty', 4.50, NULL, NULL),
(88, 4, 'punching arrangement', 5.00, NULL, NULL),
(89, 4, 'punching per qty', 5.00, NULL, NULL),
(90, 4, 'break out per qty', 4.00, NULL, NULL),
(91, 4, 'perforating arrangement', 4.00, NULL, NULL),
(92, 4, 'perforating per qty', 4.00, NULL, NULL),
(93, 4, 'tracing arrangement', 4.00, NULL, NULL),
(94, 4, 'tracing per qty', 4.00, NULL, NULL),
(95, 4, 'lac arrangement', 4.40, NULL, NULL),
(96, 4, 'lac per qty', 5.00, NULL, NULL),
(97, 4, 'compile per qty', 4.50, NULL, NULL),
(98, 4, 'Adast printing', 10.00, NULL, NULL),
(99, 4, 'GTO52 printing', 4.00, NULL, NULL),
(100, 4, 'GTO46 printing', 6.00, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `work_prices_sets`
--

CREATE TABLE `work_prices_sets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_prices_sets`
--

INSERT INTO `work_prices_sets` (`id`, `created_at`, `updated_at`) VALUES
(1, '2020-10-19 22:37:06', NULL),
(2, '2020-10-19 22:50:55', NULL),
(3, '2020-10-19 23:07:13', NULL),
(4, '2020-10-19 23:20:33', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `common_jobs`
--
ALTER TABLE `common_jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `common_jobs_paper_price_id_foreign` (`paper_price_id`),
  ADD KEY `common_jobs_client_id_foreign` (`client_id`),
  ADD KEY `common_jobs_dollar_price_id_foreign` (`dollar_price_id`);

--
-- Indexes for table `dollar_prices`
--
ALTER TABLE `dollar_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leaf_sizes`
--
ALTER TABLE `leaf_sizes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leaf_sizes_leaf_sizes_set_id_foreign` (`leaf_sizes_set_id`);

--
-- Indexes for table `leaf_sizes_sets`
--
ALTER TABLE `leaf_sizes_sets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `magazine_foil_numbers`
--
ALTER TABLE `magazine_foil_numbers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `magazine_foil_numbers_magazine_job_id_foreign` (`magazine_job_id`),
  ADD KEY `magazine_foil_numbers_magazine_unique_paper_id_foreign` (`magazine_unique_paper_id`);

--
-- Indexes for table `magazine_jobs`
--
ALTER TABLE `magazine_jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `magazine_jobs_client_id_foreign` (`client_id`),
  ADD KEY `magazine_jobs_dollar_price_id_foreign` (`dollar_price_id`);

--
-- Indexes for table `magazine_unique_papers`
--
ALTER TABLE `magazine_unique_papers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `magazine_unique_papers_paper_price_id_foreign` (`paper_price_id`),
  ADD KEY `magazine_unique_papers_magazine_job_id_foreign` (`magazine_job_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paper_colors`
--
ALTER TABLE `paper_colors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paper_prices`
--
ALTER TABLE `paper_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `paper_prices_paper_prices_set_id_foreign` (`paper_prices_set_id`),
  ADD KEY `paper_prices_paper_type_id_foreign` (`paper_type_id`),
  ADD KEY `paper_prices_paper_color_id_foreign` (`paper_color_id`);

--
-- Indexes for table `paper_prices_sets`
--
ALTER TABLE `paper_prices_sets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paper_types`
--
ALTER TABLE `paper_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_prices`
--
ALTER TABLE `work_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `work_prices_work_prices_set_id_foreign` (`work_prices_set_id`);

--
-- Indexes for table `work_prices_sets`
--
ALTER TABLE `work_prices_sets`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `common_jobs`
--
ALTER TABLE `common_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `dollar_prices`
--
ALTER TABLE `dollar_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leaf_sizes`
--
ALTER TABLE `leaf_sizes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `leaf_sizes_sets`
--
ALTER TABLE `leaf_sizes_sets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `magazine_foil_numbers`
--
ALTER TABLE `magazine_foil_numbers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `magazine_jobs`
--
ALTER TABLE `magazine_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `magazine_unique_papers`
--
ALTER TABLE `magazine_unique_papers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `paper_colors`
--
ALTER TABLE `paper_colors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `paper_prices`
--
ALTER TABLE `paper_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `paper_prices_sets`
--
ALTER TABLE `paper_prices_sets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `paper_types`
--
ALTER TABLE `paper_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `work_prices`
--
ALTER TABLE `work_prices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `work_prices_sets`
--
ALTER TABLE `work_prices_sets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `common_jobs`
--
ALTER TABLE `common_jobs`
  ADD CONSTRAINT `common_jobs_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `common_jobs_dollar_price_id_foreign` FOREIGN KEY (`dollar_price_id`) REFERENCES `dollar_prices` (`id`),
  ADD CONSTRAINT `common_jobs_paper_price_id_foreign` FOREIGN KEY (`paper_price_id`) REFERENCES `paper_prices` (`id`);

--
-- Constraints for table `leaf_sizes`
--
ALTER TABLE `leaf_sizes`
  ADD CONSTRAINT `leaf_sizes_leaf_sizes_set_id_foreign` FOREIGN KEY (`leaf_sizes_set_id`) REFERENCES `leaf_sizes_sets` (`id`);

--
-- Constraints for table `magazine_foil_numbers`
--
ALTER TABLE `magazine_foil_numbers`
  ADD CONSTRAINT `magazine_foil_numbers_magazine_job_id_foreign` FOREIGN KEY (`magazine_job_id`) REFERENCES `magazine_jobs` (`id`),
  ADD CONSTRAINT `magazine_foil_numbers_magazine_unique_paper_id_foreign` FOREIGN KEY (`magazine_unique_paper_id`) REFERENCES `magazine_unique_papers` (`id`);

--
-- Constraints for table `magazine_jobs`
--
ALTER TABLE `magazine_jobs`
  ADD CONSTRAINT `magazine_jobs_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `magazine_jobs_dollar_price_id_foreign` FOREIGN KEY (`dollar_price_id`) REFERENCES `dollar_prices` (`id`);

--
-- Constraints for table `magazine_unique_papers`
--
ALTER TABLE `magazine_unique_papers`
  ADD CONSTRAINT `magazine_unique_papers_magazine_job_id_foreign` FOREIGN KEY (`magazine_job_id`) REFERENCES `magazine_jobs` (`id`),
  ADD CONSTRAINT `magazine_unique_papers_paper_price_id_foreign` FOREIGN KEY (`paper_price_id`) REFERENCES `paper_prices` (`id`);

--
-- Constraints for table `paper_prices`
--
ALTER TABLE `paper_prices`
  ADD CONSTRAINT `paper_prices_paper_color_id_foreign` FOREIGN KEY (`paper_color_id`) REFERENCES `paper_colors` (`id`),
  ADD CONSTRAINT `paper_prices_paper_prices_set_id_foreign` FOREIGN KEY (`paper_prices_set_id`) REFERENCES `paper_prices_sets` (`id`),
  ADD CONSTRAINT `paper_prices_paper_type_id_foreign` FOREIGN KEY (`paper_type_id`) REFERENCES `paper_types` (`id`);

--
-- Constraints for table `work_prices`
--
ALTER TABLE `work_prices`
  ADD CONSTRAINT `work_prices_work_prices_set_id_foreign` FOREIGN KEY (`work_prices_set_id`) REFERENCES `work_prices_sets` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
