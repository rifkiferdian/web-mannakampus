-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2026 at 04:57 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_manna_kampus`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_flyer`
--

CREATE TABLE `tbl_flyer` (
  `id` int(11) NOT NULL,
  `cabang_id` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_flyer`
--

INSERT INTO `tbl_flyer` (`id`, `cabang_id`, `photo`) VALUES
(1, 1, 'promo-1.jpg'),
(2, 1, 'promo-2.jpg'),
(3, 1, 'promo-3.jpg'),
(4, 2, 'promo-1.jpg'),
(5, 3, 'promo-2.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_flyer`
--
ALTER TABLE `tbl_flyer`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_flyer_cabang` (`cabang_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_flyer`
--
ALTER TABLE `tbl_flyer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_flyer`
--
ALTER TABLE `tbl_flyer`
  ADD CONSTRAINT `fk_flyer_cabang` FOREIGN KEY (`cabang_id`) REFERENCES `tbl_cabang` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
