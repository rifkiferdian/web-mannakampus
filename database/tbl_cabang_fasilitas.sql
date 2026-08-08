-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2026 at 09:54 AM
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
-- Table structure for table `tbl_cabang_fasilitas`
--

CREATE TABLE `tbl_cabang_fasilitas` (
  `id` int(11) NOT NULL,
  `id_cabang` int(11) NOT NULL,
  `nama_fasilitas` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `icon` varchar(100) DEFAULT 'fa-check'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_cabang_fasilitas`
--

INSERT INTO `tbl_cabang_fasilitas` (`id`, `id_cabang`, `nama_fasilitas`, `deskripsi`, `icon`) VALUES
(1, 1, 'Parkir Luas', 'Kapasitas 100+ Mobil', 'fa-product-hunt'),
(2, 1, 'Mushola', 'Nyaman & Bersih', 'fa-building-o'),
(3, 1, 'ATM Center', 'Berbagai Bank', 'fa-credit-card'),
(4, 1, 'Toilet Bersih', 'Terawat Rutin', 'fa-restroom'),
(5, 1, 'Food Court', 'Kuliner Lezat', 'fa-cutlery');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_cabang_fasilitas`
--
ALTER TABLE `tbl_cabang_fasilitas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_cabang_fasilitas`
--
ALTER TABLE `tbl_cabang_fasilitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
