-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2025 at 04:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `weather_data`
--

CREATE TABLE `weather_data` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `temperature` double(8,2) NOT NULL,
  `humidity` double(8,2) NOT NULL,
  `rainfall` double(8,2) NOT NULL,
  `solar_radiation` double(8,2) NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `weather_data`
--

INSERT INTO `weather_data` (`id`, `date`, `temperature`, `humidity`, `rainfall`, `solar_radiation`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, '2025-05-26', 29.40, 90.00, 0.00, 0.00, -6.55892801, 107.79632807, '2025-05-26 08:44:03', '2025-05-26 08:44:03'),
(2, '2025-05-28', 31.70, 76.00, 0.00, 0.00, -6.55892801, 107.79632807, '2025-05-27 19:39:29', '2025-05-27 19:39:29'),
(20, '2025-05-29', 31.86, 85.00, 0.00, 0.00, -6.55892801, 107.79632807, '2025-05-29 04:05:58', '2025-05-29 04:05:58'),
(548, '2025-06-03', 30.38, 82.00, 0.00, 0.00, -6.57616900, 107.75861400, '2025-06-03 03:36:48', '2025-06-03 03:36:48'),
(549, '2025-06-03', 30.51, 83.00, 0.00, 0.00, -6.56617378, 107.82735357, '2025-06-03 03:37:08', '2025-06-03 03:37:08'),
(564, '2025-06-05', 32.50, 75.00, 0.00, 0.00, -6.56617378, 107.82735357, '2025-06-05 01:19:57', '2025-06-05 01:19:57'),
(568, '2025-06-08', 30.14, 71.00, 0.00, 0.00, -6.57616900, 107.75859100, '2025-06-08 04:52:36', '2025-06-08 12:13:01'),
(569, '2025-06-11', 29.11, 84.00, 0.00, 0.00, -6.57616900, 107.75859100, '2025-06-11 15:01:48', '2025-06-11 15:53:51'),
(570, '2025-06-12', 29.73, 75.00, 0.00, 0.00, -6.57616900, 107.75859100, '2025-06-11 18:28:47', '2025-06-11 18:28:47'),
(571, '2025-06-13', 30.99, 69.00, 0.00, 0.00, -6.57616900, 107.75859100, '2025-06-12 18:39:06', '2025-06-12 18:39:06');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `weather_data`
--
ALTER TABLE `weather_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `weather_data_date_latitude_longitude_unique` (`date`,`latitude`,`longitude`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `weather_data`
--
ALTER TABLE `weather_data`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=572;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
