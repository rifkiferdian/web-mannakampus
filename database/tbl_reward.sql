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
-- Table structure for table `tbl_reward`
--

CREATE TABLE `tbl_reward` (
  `id` int(11) NOT NULL,
  `id_periode` int(11) NOT NULL,
  `prize_name` varchar(255) NOT NULL,
  `grand_prize` tinyint(1) DEFAULT 0,
  `img` varchar(255) DEFAULT NULL,
  `qty` int(11) DEFAULT 1,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_reward`
--

INSERT INTO `tbl_reward` (`id`, `id_periode`, `prize_name`, `grand_prize`, `img`, `qty`, `description`) VALUES
(1, 1, 'Sepeda Motor', 1, 'hadiah1.jpg', 2, 'Sepeda Motor Scoppy (Off The Road)'),
(2, 1, 'Iphone 15', 0, 'hadiah2.jpg', 1, 'Iphone 15 / 128GB'),
(3, 1, 'Laptop', 0, 'hadiah3.jpg', 2, 'Laptop ASUS'),
(4, 1, 'Mesin Cuci ', 0, 'hadiah4.jpg', 2, 'Mesin Cuci Samsung'),
(5, 1, 'Pendingin Udara', 0, 'hadiah5.jpg', 4, 'Pendingin Udara Sharp'),
(6, 1, 'Lemari Es', 0, 'hadiah6.jpg', 1, 'Lemari Es Samsung'),
(7, 2, 'Mobil Daihatsu Ayla', 1, 'hadiah7.jpg', 1, 'Mobil Daihatsu Ayla All New Alya 1.0 M MT'),
(8, 2, 'Iphone 15', 0, 'hadiah2.jpg', 1, 'Iphone 15 / 128GB'),
(9, 2, 'Lemari Es', 0, 'hadiah6.jpg', 2, 'Lemari Es Samsung'),
(10, 2, 'TV LED ', 0, 'hadiah8.jpg', 4, 'TV LED Samsung 43\''),
(11, 2, 'Voucher Belanja', 0, 'hadiah9.jpg', 5, 'Voucher Belanja @1Jt'),
(12, 3, 'Rumah Type 48', 1, 'hadiah10.jpg', 1, 'Rumah Type 48 + Furniture \r\nLokasi Kadirojo Sleman'),
(13, 3, 'Iphone 15', 0, 'hadiah2.jpg', 1, 'Iphone 15 / 128GB'),
(14, 3, 'Lemari Es', 0, 'hadiah6.jpg', 2, 'Lemari Es Samsung'),
(15, 3, 'Sepeda Polygon', 0, 'hadiah11.jpg', 2, 'Sepeda Polygon'),
(16, 3, 'Mesin Cuci ', 0, 'hadiah4.jpg', 3, 'Mesin Cuci Samsung'),
(17, 4, 'Mobil Xpander', 1, NULL, 1, 'Mobil Mitsubishi Xpander'),
(18, 4, 'Rumah Type 48', 1, NULL, 1, 'Rumah Type 48 + Furniture \r\nLokasi Kadirojo Sleman'),
(19, 6, 'Sepeda Motor Scoopy', 1, NULL, 1, 'Sepeda Motor Scoopy\r\n'),
(20, 7, 'Lemari Es Samsung', 1, NULL, 1, 'Lemari Es Samsung'),
(21, 8, 'Mesin Cuci Samsung', 1, NULL, 1, 'Mesin Cuci Samsung');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_reward`
--
ALTER TABLE `tbl_reward`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_hadiah_periode` (`id_periode`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_reward`
--
ALTER TABLE `tbl_reward`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_reward`
--
ALTER TABLE `tbl_reward`
  ADD CONSTRAINT `fk_hadiah_periode` FOREIGN KEY (`id_periode`) REFERENCES `tbl_periode` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
