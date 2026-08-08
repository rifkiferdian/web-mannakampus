-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2026 at 09:55 AM
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
-- Table structure for table `tbl_cabang_video`
--

CREATE TABLE `tbl_cabang_video` (
  `id` int(11) NOT NULL,
  `id_cabang` int(11) NOT NULL,
  `judul_video` varchar(255) NOT NULL,
  `deskripsi_video` text DEFAULT NULL,
  `link_video` varchar(255) NOT NULL,
  `thumbnail` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_cabang_video`
--

INSERT INTO `tbl_cabang_video` (`id`, `id_cabang`, `judul_video`, `deskripsi_video`, `link_video`, `thumbnail`) VALUES
(1, 1, 'Video Profile Manna Kampus', NULL, 'https://www.youtube.com/embed/5sEboTJFKn0?si=NOXOhJdGLTtOGC1V', NULL),
(2, 1, 'Reputable and Profitability', NULL, 'https://www.youtube.com/embed/X8_q4H-0EsA?si=cGDDYCqbJ3qM0wLK', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_cabang_video`
--
ALTER TABLE `tbl_cabang_video`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_cabang_video`
--
ALTER TABLE `tbl_cabang_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
