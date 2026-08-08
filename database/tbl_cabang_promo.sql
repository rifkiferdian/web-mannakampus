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
-- Table structure for table `tbl_cabang_promo`
--

CREATE TABLE `tbl_cabang_promo` (
  `id` int(11) NOT NULL,
  `id_cabang` int(11) NOT NULL,
  `badge` varchar(50) DEFAULT NULL,
  `kategori` varchar(100) DEFAULT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `harga_coret` int(11) DEFAULT NULL,
  `harga_promo` int(11) NOT NULL,
  `foto` varchar(255) DEFAULT 'default-product.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_cabang_promo`
--

INSERT INTO `tbl_cabang_promo` (`id`, `id_cabang`, `badge`, `kategori`, `nama_produk`, `harga_coret`, `harga_promo`, `foto`) VALUES
(1, 1, 'Hemat 15%', 'Minyak Goreng Sawit', 'Minyak Sunco 2 Liter', 38500, 32900, 'minyak.png'),
(2, 1, 'Beli 2 Gratis 1', 'Buah Segar', 'Strawberry Premium', 42000, 34500, 'strawberry.png'),
(3, 1, 'Fresh Deal', 'Buah Segar', 'Jeruk Peras Murni', NULL, 11000, 'jerukperas.png'),
(4, 1, 'Diskon Member', 'Toiletries', 'Downy Pewangi 1,35L', 66300, 59900, 'downy.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_cabang_promo`
--
ALTER TABLE `tbl_cabang_promo`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_cabang_promo`
--
ALTER TABLE `tbl_cabang_promo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
