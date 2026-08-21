-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2026 at 03:21 AM
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
-- Table structure for table `tbl_photo`
--

CREATE TABLE `tbl_photo` (
  `photo_id` int(11) NOT NULL,
  `photo_caption` varchar(255) NOT NULL,
  `photo_name` varchar(255) NOT NULL,
  `p_category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_photo`
--

INSERT INTO `tbl_photo` (`photo_id`, `photo_caption`, `photo_name`, `p_category_id`) VALUES
(8, 'Photo 1', 'photo-8.jpg', 1),
(9, 'Photo 2', 'photo-9.jpg', 1),
(10, 'Photo 3', 'photo-10.jpg', 1),
(11, 'Photo 4', 'photo-11.jpg', 2),
(12, 'Photo 5', 'photo-12.jpg', 2),
(13, 'Photo 6', 'photo-13.jpg', 2),
(14, 'Photo 7', 'photo-14.jpg', 2),
(15, 'Photo 8', 'photo-15.jpg', 3),
(16, 'Photo 9', 'photo-16.jpg', 3),
(17, 'Photo 10', 'photo-17.jpg', 3),
(18, 'Photo 11', 'photo-18.jpg', 3),
(19, 'Photo 12', 'photo-19.jpg', 1),
(20, 'Social Photo 1', 'social1.png', 4),
(21, 'Social Photo 2', 'social2.png', 4),
(22, 'Social Photo 3', 'social3.png', 4),
(23, 'Social Photo 4', 'social4.png', 4),
(24, 'Social Photo 5', 'social5.png', 4),
(25, 'Social Photo 6', 'social6.png', 4),
(26, 'Social Photo 7', 'social2.png', 4),
(27, 'Social Photo 8', 'social1.png', 4),
(28, 'BLBMS Photo 1', 'photo-28.png', 5),
(29, 'BLBMS Photo 2', 'photo-29.png', 5),
(30, 'BLBMS Photo 3', 'photo-30.png', 5),
(31, 'BLBMS Photo 4', 'photo-31.png', 5),
(32, 'BLBMS Photo 5', 'photo-32.png', 5),
(33, 'BLBMS Photo 6', 'photo-33.png', 5),
(34, 'BLBMS Photo 7', 'photo-34.png', 5),
(36, 'BLBMS Photo 8', 'photo-36.png', 5),
(37, 'BLBMS Photo 9', 'photo-37.png', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_photo`
--
ALTER TABLE `tbl_photo`
  ADD PRIMARY KEY (`photo_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_photo`
--
ALTER TABLE `tbl_photo`
  MODIFY `photo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
