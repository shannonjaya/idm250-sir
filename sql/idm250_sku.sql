-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 01, 2026 at 09:18 PM
-- Server version: 10.6.22-MariaDB-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.23

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
-- Table structure for table `idm250_sku`
--

CREATE TABLE `idm250_sku` (
  `id` int(11) NOT NULL,
  `ficha` int(11) DEFAULT NULL,
  `sku` varchar(12) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `uom_primary` varchar(24) DEFAULT NULL,
  `piece_count` int(11) DEFAULT NULL,
  `length_inches` decimal(10,0) DEFAULT NULL,
  `width_inches` decimal(10,0) DEFAULT NULL,
  `height_inches` decimal(10,0) DEFAULT NULL,
  `weight_lbs` decimal(10,0) DEFAULT NULL,
  `assembly` tinyint(1) DEFAULT NULL,
  `rate` decimal(10,0) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `idm250_sku`
--

INSERT INTO `idm250_sku` (`id`, `ficha`, `sku`, `description`, `uom_primary`, `piece_count`, `length_inches`, `width_inches`, `height_inches`, `weight_lbs`, `assembly`, `rate`) VALUES
(1, 452, '1720823-0567', 'BIRCH YEL FAS 6/4 RGH KD 10FT', 'PALLET', 95, '120', '44', '34', '3120', 0, '18'),
(2, 163, '1720824-0891', 'HEMLOCK DIM 2X8X14FT #2BTR STD', 'BUNDLE', 160, '168', '40', '29', '2975', 0, '15'),
(3, 589, '1720825-0234', 'ASH WHT FAS 4/4 RGH KD 9-11FT', 'PALLET', 110, '132', '46', '40', '3541', 0, '16'),
(4, 734, '1720826-0412', 'MDF ULTRALT C1-- 2440X1220X18MM', 'BUNDLE', 85, '96', '48', '52', '4251', 0, '13'),
(5, 298, '1720827-0178', 'CHERRY BLK SEL 5/4 RGH KD 8FT', 'PALLET', 70, '96', '42', '26', '1980', 0, '21'),
(6, 641, '1720828-0923', 'REDWOOD CLR VG 2X4X10FT KD HRT', 'BUNDLE', 225, '120', '38', '32', '2431', 0, '20'),
(7, 812, '1720829-0056', 'PARTICLEBOARD IND 3/4X49X97', 'PALLET', 60, '97', '49', '45', '3890', 0, '12'),
(8, 445, '1720830-0789', 'ALDER RED SEL 4/4 RGH KD 8-10FT', 'BUNDLE', 140, '120', '40', '30', '2181', 0, '18'),
(9, 127, '1720831-0345', 'WHITE OAK QS 4/4 RGH KD 10FT', 'PALLET', 65, '120', '48', '38', '2891', 0, '22'),
(10, 568, '1720832-0612', 'SOUTHERN PINE PT 4X4X12FT GC', 'BUNDLE', 130, '144', '44', '48', '5120', 0, '13'),
(11, 452, '1720823-0567', 'BIRCH YEL FAS 6/4 RGH KD 10FT', 'PALLET', 95, '120', '44', '34', '3120', 0, '18'),
(12, 163, '1720824-0891', 'HEMLOCK DIM 2X8X14FT #2BTR STD', 'BUNDLE', 160, '168', '40', '29', '2975', 0, '15'),
(13, 589, '1720825-0234', 'ASH WHT FAS 4/4 RGH KD 9-11FT', 'PALLET', 110, '132', '46', '40', '3541', 0, '16'),
(14, 734, '1720826-0412', 'MDF ULTRALT C1-- 2440X1220X18MM', 'BUNDLE', 85, '96', '48', '52', '4251', 0, '13'),
(15, 298, '1720827-0178', 'CHERRY BLK SEL 5/4 RGH KD 8FT', 'PALLET', 70, '96', '42', '26', '1980', 0, '21'),
(16, 641, '1720828-0923', 'REDWOOD CLR VG 2X4X10FT KD HRT', 'BUNDLE', 225, '120', '38', '32', '2431', 0, '20'),
(17, 812, '1720829-0056', 'PARTICLEBOARD IND 3/4X49X97', 'PALLET', 60, '97', '49', '45', '3890', 0, '12'),
(18, 445, '1720830-0789', 'ALDER RED SEL 4/4 RGH KD 8-10FT', 'BUNDLE', 140, '120', '40', '30', '2181', 0, '18'),
(19, 127, '1720831-0345', 'WHITE OAK QS 4/4 RGH KD 10FT', 'PALLET', 65, '120', '48', '38', '2891', 0, '22'),
(20, 568, '1720832-0612', 'SOUTHERN PINE PT 4X4X12FT GC', 'BUNDLE', 130, '144', '44', '48', '5120', 0, '13'),
(21, 152, '1720853-0430', 'PINE SELECT 1X6X10FT S4S', 'BUNDLE', 260, '120', '36', '28', '2050', 0, '19'),
(22, 619, '1720854-0444', 'WALNUT 4/4 KD 8-12FT', 'PALLET', 75, '144', '48', '32', '2450', 0, '13'),
(23, 943, '1720855-0458', 'DOUGLAS FIR 2X8X14FT #2', 'BUNDLE', 105, '168', '48', '40', '4200', 0, '17'),
(24, 378, '1720856-0472', 'CEDAR 1X4X8FT CLR S4S', 'BUNDLE', 350, '96', '36', '24', '1800', 0, '20'),
(25, 731, '1720857-0486', 'BIRCH PLY 3/4X5X5', 'PALLET', 42, '60', '60', '48', '2950', 0, '18'),
(26, 206, '1720858-0500', 'MAPLE HARD 4/4 FAS KD 10-14FT', 'PALLET', 105, '168', '48', '40', '3950', 0, '18'),
(27, 568, '1720859-0514', 'PINE #2 2X12X10FT KD', 'BUNDLE', 90, '120', '48', '44', '3800', 0, '16'),
(28, 821, '1720860-0528', 'ASH 4/4 FAS KD 9FT', 'PALLET', 125, '108', '48', '38', '3400', 0, '18'),
(29, 289, '1720861-0542', 'SPRUCE 2X10X12FT #2', 'BUNDLE', 100, '144', '48', '40', '4000', 0, '15'),
(30, 662, '1720862-0556', 'CEDAR WRC 2X6X10FT CLR', 'BUNDLE', 160, '120', '36', '30', '2400', 0, '21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `idm250_sku`
--
ALTER TABLE `idm250_sku`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `idm250_sku`
--
ALTER TABLE `idm250_sku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
