-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2026 at 03:01 AM
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
-- Table structure for table `tbl_periode`
--

CREATE TABLE `tbl_periode` (
  `id` int(11) NOT NULL,
  `id_program` int(11) NOT NULL,
  `periode_name` varchar(100) NOT NULL,
  `draw_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_periode`
--

INSERT INTO `tbl_periode` (`id`, `id_program`, `periode_name`, `draw_date`) VALUES
(1, 1, 'Periode I', '2026-05-09'),
(2, 1, 'Periode II', '2026-09-05'),
(3, 1, 'Periode III', '2027-01-09'),
(4, 2, 'Periode I', '2025-03-11'),
(5, 2, 'Periode II', '2025-09-30'),
(6, 3, 'Periode I', '2024-01-15'),
(7, 4, 'Periode I', '2023-01-15'),
(8, 5, 'Periode I', '2022-01-15');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_periode`
--
ALTER TABLE `tbl_periode`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_program` (`id_program`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_periode`
--
ALTER TABLE `tbl_periode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_periode`
--
ALTER TABLE `tbl_periode`
  ADD CONSTRAINT `tbl_periode_ibfk_1` FOREIGN KEY (`id_program`) REFERENCES `tbl_program` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
