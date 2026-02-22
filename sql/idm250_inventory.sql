-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Feb 21, 2026 at 11:27 PM
-- Server version: 8.0.40
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sej84_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `idm250_inventory`
--

CREATE TABLE `idm250_inventory` (
  `unit_id` int NOT NULL,
  `sku_id` int DEFAULT NULL,
  `location` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `idm250_inventory`
--

INSERT INTO `idm250_inventory` (`unit_id`, `sku_id`, `location`) VALUES
(28114990, 589, 'internal'),
(28114991, 589, 'internal'),
(28114992, 589, 'internal'),
(28114993, 589, 'internal'),
(28114994, 589, 'internal'),
(28114995, 589, 'internal'),
(28114996, 589, 'internal'),
(28114997, 589, 'internal'),
(28114998, 589, 'internal'),
(28114999, 589, 'internal'),
(28115000, 589, 'internal'),
(28115001, 589, 'internal'),
(28115002, 589, 'internal'),
(28115003, 589, 'internal'),
(28115004, 445, 'internal'),
(28115005, 445, 'internal'),
(28115006, 445, 'internal'),
(28115007, 445, 'internal'),
(28115008, 445, 'internal'),
(28115009, 445, 'internal'),
(28115010, 445, 'internal'),
(28115011, 445, 'internal'),
(28115012, 445, 'internal'),
(28115013, 445, 'internal'),
(28115014, 445, 'internal'),
(28115015, 445, 'internal'),
(28115016, 445, 'internal'),
(28115017, 445, 'internal'),
(28115018, 445, 'internal'),
(28115019, 452, 'internal'),
(28115020, 452, 'internal'),
(28115021, 452, 'internal'),
(28115022, 452, 'internal'),
(28115023, 452, 'internal'),
(28115024, 452, 'internal'),
(28115025, 452, 'internal'),
(28115026, 452, 'internal'),
(28115027, 452, 'internal'),
(28115028, 452, 'internal'),
(28115029, 452, 'internal'),
(28115030, 452, 'internal'),
(28115031, 452, 'internal'),
(28115032, 452, 'internal'),
(28115033, 452, 'internal'),
(28115034, 734, 'internal'),
(28115035, 734, 'internal'),
(28115036, 734, 'internal'),
(28115037, 734, 'internal'),
(28115038, 734, 'internal');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `idm250_inventory`
--
ALTER TABLE `idm250_inventory`
  ADD PRIMARY KEY (`unit_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `idm250_inventory`
--
ALTER TABLE `idm250_inventory`
  MODIFY `unit_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28115039;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
