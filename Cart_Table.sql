-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 03, 2024 at 04:35 PM
-- Server version: 8.0.40-0ubuntu0.20.04.1
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cs2team37_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `Cart Table`
--

CREATE TABLE `Cart Table` (
  `basket_id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `total_price` decimal(10,0) NOT NULL,
  `added_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Cart Table`
--
ALTER TABLE `Cart Table`
  ADD PRIMARY KEY (`basket_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Cart Table`
--
ALTER TABLE `Cart Table`
  MODIFY `basket_id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Cart Table`
--
ALTER TABLE `Cart Table`
  ADD CONSTRAINT `Cart Table_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users Table` (`User_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `Cart Table_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `Products Table` (`Products_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
