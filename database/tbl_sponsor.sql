-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2026 at 03:06 AM
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
-- Table structure for table `tbl_sponsor`
--

CREATE TABLE `tbl_sponsor` (
  `id` int(11) NOT NULL,
  `id_program` int(11) NOT NULL,
  `sponsor_name` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sponsor`
--

INSERT INTO `tbl_sponsor` (`id`, `id_program`, `sponsor_name`, `img`) VALUES
(1, 1, 'Bank BRI', 'sponsor1.jpg'),
(2, 1, 'Bank CIMB NIAGA', 'sponsor2.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_sponsor`
--
ALTER TABLE `tbl_sponsor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sponsor_program` (`id_program`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_sponsor`
--
ALTER TABLE `tbl_sponsor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_sponsor`
--
ALTER TABLE `tbl_sponsor`
  ADD CONSTRAINT `fk_sponsor_program` FOREIGN KEY (`id_program`) REFERENCES `tbl_program` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
