-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 31, 2025 at 07:59 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parade`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `config`
--

CREATE TABLE `config` (
  `parade_id` int(11) NOT NULL,
  `weather_url` varchar(255) DEFAULT NULL,
  `zipcode` int(11) DEFAULT NULL,
  `dfp_ad_unit` varchar(255) DEFAULT NULL,
  `google_analytics` varchar(255) DEFAULT NULL,
  `about_text` varchar(255) DEFAULT NULL,
  `location_interval` int(11) DEFAULT NULL,
  `location_url` varchar(255) DEFAULT NULL,
  `home_screen` varchar(255) DEFAULT NULL,
  `schedule_screen` varchar(255) DEFAULT NULL,
  `interstitial_ad` varchar(255) DEFAULT NULL,
  `sponsor_ad` varchar(255) DEFAULT NULL,
  `cox_ad` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `id` int(11) NOT NULL,
  `route_id` int(11) NOT NULL,
  `intersection` varchar(255) NOT NULL,
  `latitude` float(11,8) NOT NULL,
  `longitude` float(11,8) NOT NULL,
  `route_order` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parade`
--

CREATE TABLE `parade` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `date` int(11) NOT NULL DEFAULT 0,
  `start_time` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `floats` int(11) DEFAULT NULL,
  `am_pm` varchar(2) NOT NULL DEFAULT ' ',
  `route_id` int(11) NOT NULL,
  `banner` varchar(255) DEFAULT NULL,
  `sponsor_ad` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pointof_interest`
--

CREATE TABLE `pointof_interest` (
  `id` int(11) NOT NULL,
  `parade_id` int(11) NOT NULL,
  `lat` decimal(10,8) DEFAULT NULL,
  `lon` decimal(10,8) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `category` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `route_id` int(11) NOT NULL,
  `intersection` varchar(255) NOT NULL,
  `latitude` float(11,8) NOT NULL,
  `longitude` double(11,8) NOT NULL,
  `id` int(11) NOT NULL,
  `route_order` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tail_location`
--

CREATE TABLE `tail_location` (
  `id` int(11) NOT NULL,
  `route_id` int(11) NOT NULL,
  `intersection` varchar(255) NOT NULL,
  `latitude` float(11,8) NOT NULL,
  `longitude` float(11,8) NOT NULL,
  `route_order` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `password` varchar(50) NOT NULL,
  `status` char(9) NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `last_activity_idx` (`last_activity`);

--
-- Indexes for table `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`parade_id`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parade`
--
ALTER TABLE `parade`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `route_id` (`route_id`);

--
-- Indexes for table `pointof_interest`
--
ALTER TABLE `pointof_interest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_poi_parade` (`parade_id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tail_location`
--
ALTER TABLE `tail_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parade`
--
ALTER TABLE `parade`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pointof_interest`
--
ALTER TABLE `pointof_interest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tail_location`
--
ALTER TABLE `tail_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pointof_interest`
--
ALTER TABLE `pointof_interest`
  ADD CONSTRAINT `fk_poi_parade` FOREIGN KEY (`parade_id`) REFERENCES `parade` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
