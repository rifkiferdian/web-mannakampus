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
-- Table structure for table `tbl_program`
--

CREATE TABLE `tbl_program` (
  `id` int(11) NOT NULL,
  `program_name` varchar(255) NOT NULL,
  `year` year(4) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_program`
--

INSERT INTO `tbl_program` (`id`, `program_name`, `year`, `start_date`, `end_date`) VALUES
(1, 'Belanja Luar Biasa Murah Spektakuler ( BLBMS )', '2026', '2026-01-01', '2026-12-31'),
(2, 'Belanja Luar Biasa Murah Spektakuler ( BLBMS )', '2025', '2025-01-01', '2025-12-31'),
(3, 'Belanja Luar Biasa Murah Spektakuler ( BLBMS )', '2024', '2024-01-01', '2024-12-31'),
(4, 'Belanja Luar Biasa Murah Spektakuler ( BLBMS )\r\n', '2023', '2023-01-01', '2023-12-31'),
(5, 'Belanja Luar Biasa Murah Spektakuler ( BLBMS )\r\n', '2022', '2022-01-01', '2022-12-31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_program`
--
ALTER TABLE `tbl_program`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_program`
--
ALTER TABLE `tbl_program`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
