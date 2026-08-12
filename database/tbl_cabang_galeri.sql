-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2026 at 06:05 AM
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
-- Table structure for table `tbl_cabang_galeri`
--

CREATE TABLE `tbl_cabang_galeri` (
  `id` int(11) NOT NULL,
  `id_cabang` int(11) NOT NULL,
  `foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_cabang_galeri`
--

INSERT INTO `tbl_cabang_galeri` (`id`, `id_cabang`, `foto`) VALUES
(1, 1, 'galery1.png'),
(2, 1, 'galery2.png'),
(3, 1, 'galery3.png'),
(4, 1, 'galery4.png'),
(5, 1, 'galery5.png'),
(6, 1, 'galery6.png'),
(7, 1, 'mitra-2.png'),
(8, 1, 'galery8.png'),
(9, 1, 'mitra-1.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_cabang_galeri`
--
ALTER TABLE `tbl_cabang_galeri`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_cabang_galeri`
--
ALTER TABLE `tbl_cabang_galeri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
