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
-- Table structure for table `tbl_winners`
--

CREATE TABLE `tbl_winners` (
  `id` int(11) NOT NULL,
  `id_periode` int(11) NOT NULL,
  `id_reward` int(11) NOT NULL,
  `winners_name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `member_number` varchar(255) NOT NULL,
  `testimonial` text DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_winners`
--

INSERT INTO `tbl_winners` (`id`, `id_periode`, `id_reward`, `winners_name`, `photo`, `address`, `member_number`, `testimonial`, `description`) VALUES
(65, 1, 1, 'Budi Santoso', 'winner_1.jpg', 'Sleman, DI Yogyakarta', '001707931669', 'Alhamdulillah dapet motor dari Manna Kampus! Berkah belanja bulanan.', 'Pemenang Sepeda Motor Scoopy (Off The Road) - Periode I'),
(66, 1, 1, 'Siti Aminah', 'winner_2.jpg', 'Bantul, DI Yogyakarta', '001854210982', 'Sangat tidak menyangka bisa bawa pulang motor Scoopy. Terima kasih Manna Kampus!', 'Pemenang Sepeda Motor Scoopy (Off The Road) - Periode I'),
(67, 1, 2, 'Agus Setiawan', 'winner_10.jpeg', 'Kota Yogyakarta, DI Yogyakarta', '001933041255', 'iPhone 15 nya beneran riil no tipu-tipu! Pelayanan pengambilan hadiah sangat ramah.', 'Pemenang Iphone 15 / 128GB - Periode I'),
(68, 1, 3, 'Dewi Lestari', 'winner_8.jpeg', 'Kulon Progo, DI Yogyakarta', '001209847113', 'Laptop ASUS nya berguna banget buat kuliah anak saya. Sukses selalu Manna Kampus.', 'Pemenang Laptop ASUS - Periode I'),
(69, 1, 3, 'Eko Prasetyo', 'winner_8.jpeg', 'Gunungkidul, DI Yogyakarta', '001477290184', 'Rejeki belanja sembako dapet laptop gratis. Seneng banget!', 'Pemenang Laptop ASUS - Periode I'),
(70, 1, 4, 'Rina Wijaya', 'winner_9.jpeg', 'Sleman, DI Yogyakarta', '001601938221', 'Mesin cuci Samsung nya sangat membantu urusan rumah tangga.', 'Pemenang Mesin Cuci Samsung - Periode I'),
(71, 1, 4, 'Ahmad Fauzi', 'winner_9.jpeg', 'Klaten, Jawa Tengah', '001388402910', 'Proses klaim cepat dan tidak ada pungutan biaya sama sekali.', 'Pemenang Mesin Cuci Samsung - Periode I'),
(72, 1, 5, 'Sri Wahyuni', 'winner_7.jpeg', 'Bantul, DI Yogyakarta', '001155928374', 'AC Sharp nya bikin rumah dapet suasana adem pas musim kemarau.', 'Pemenang Pendingin Udara Sharp - Periode I'),
(73, 1, 5, 'Bambang Hariyanto', 'winner_7.jpeg', 'Kota Yogyakarta, DI Yogyakarta', '001720391823', 'Manna Kampus tempat belanja langganan yang selalu bagi-bagi hadiah keren.', 'Pemenang Pendingin Udara Sharp - Periode I'),
(74, 1, 5, 'Nur Hidayah', 'winner_7.jpeg', 'Sleman, DI Yogyakarta', '001899120485', 'Awalnya ditelepon gak percaya, ternyata pas ke kantornya beneran dapet AC!', 'Pemenang Pendingin Udara Sharp - Periode I'),
(75, 1, 5, 'Dedi Kurniawan', 'winner_7.jpeg', 'Magelang, Jawa Tengah', '001233849102', 'Terima kasih Manna Kampus atas pendingin udaranya.', 'Pemenang Pendingin Udara Sharp - Periode I'),
(76, 1, 6, 'Titi Rahayu', 'winner_6.jpg', 'Bantul, DI Yogyakarta', '001544839201', 'Kulkas baru buat awetin stok bahan makanan seminggu. Mantap!', 'Pemenang Lemari Es Samsung - Periode I'),
(87, 3, 12, 'Hadi Sucipto', 'winner_12.jpg', 'Sleman, DI Yogyakarta', '001811029384', 'Gak menyangka menang Grand Prize Rumah di Kadirojo Sleman! Manna Kampus Rumah Belanja Terpercaya!', 'Pemenang Grand Prize Rumah Type 48 + Furniture - Periode III'),
(88, 3, 13, 'Endang Sri', 'winner_10.jpeg', 'Gunungkidul, DI Yogyakarta', '001455938201', 'Akhirnya kesampaian punya HP impian berkat undian BLBMS!', 'Pemenang Iphone 15 / 128GB - Periode III'),
(89, 3, 14, 'Rudy Hermawan', 'winner_6.jpg', 'Kota Yogyakarta, DI Yogyakarta', '001922830192', 'Kulkas Samsung nya bekerja dengan baik. Terima kasih tim Manna Kampus.', 'Pemenang Lemari Es Samsung - Periode III'),
(90, 3, 14, 'Yuni Kartika', 'winner_6.jpg', 'Bantul, DI Yogyakarta', '001277391029', 'Pelayanan dari pendaftaran kupon sampai klaim hadiah sangat memuaskan.', 'Pemenang Lemari Es Samsung - Periode III'),
(91, 3, 15, 'Suryadi', 'winner_4.jpg', 'Sleman, DI Yogyakarta', '001633920184', 'Sepeda Polygon keren buat dipake gowes tiap hari minggu.', 'Pemenang Sepeda Polygon - Periode III'),
(92, 3, 15, 'Ratna Sari', 'winner_4.jpg', 'Kulon Progo, DI Yogyakarta', '001144830192', 'Sepedanya langsung dipake sama anak sekolah. Terima kasih banyak!', 'Pemenang Sepeda Polygon - Periode III'),
(93, 3, 16, 'Dono Martono', 'winner_9.jpeg', 'Kota Yogyakarta, DI Yogyakarta', '001588291029', 'Dapet mesin cuci Samsung automatis. Hasil belanja di Manna Kampus berbuah manis.', 'Pemenang Mesin Cuci Samsung - Periode III'),
(94, 3, 16, 'Wulan Dari', 'winner_9.jpeg', 'Sleman, DI Yogyakarta', '001366920193', 'Sangat bersyukur menang hadiah di periode penutup BLBMS.', 'Pemenang Mesin Cuci Samsung - Periode III'),
(95, 3, 16, 'Gatot Subroto', 'winner_9.jpeg', 'Bantul, DI Yogyakarta', '001799201938', 'Mesin cuci nya canggih dan hemat listrik. Sukses selalu buat Manna Kampus.', 'Pemenang Mesin Cuci Samsung - Periode III'),
(96, 3, 11, 'Siti Rahmah', 'winner_5.jpg', 'Magelang, Jawa Tengah', '001222930192', 'Penutupan tahun yang manis dapet voucher belanja 1 juta rupiah.', 'Pemenang Voucher Belanja @1Jt - Periode III'),
(97, 4, 17, 'Amaylia', 'winner_13.jpg', 'Bantul', '001458745962', 'Alhamdulilah', 'Pemenang Mobil Xpander - Periode I 2025'),
(98, 4, 18, 'Sunarsi', 'winner_12.jpg', 'Wonogiri', '001421536984', 'Alhamdulilah ya', 'Pemenang Rumah Type 48 - Periode I 2025'),
(99, 6, 19, 'Ajeng', 'winner_1.jpg', 'Bantul, Yogyakarta', '015248795214', 'Masyaallah chan', 'Pemenang Sepeda Motor Scoopy - Periode I 2024'),
(100, 7, 20, 'Junet', 'winner_6.jpg', 'Bantul, Yogyakarta', '012548796521', 'Terimakasih Manna Kampus', 'Pemenang Lemari Es Samsung - Periode I 2023'),
(101, 8, 21, 'Mas Rifki', 'winner_9.jpeg', 'Kalasan, Yogyakarta', '012548963214', 'Arigato Manna Kampus', 'Pemenang Mesin Cuci Samsung - Periode I 2022');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_winners`
--
ALTER TABLE `tbl_winners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_winners_periode` (`id_periode`),
  ADD KEY `fk_winners_reward` (`id_reward`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_winners`
--
ALTER TABLE `tbl_winners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_winners`
--
ALTER TABLE `tbl_winners`
  ADD CONSTRAINT `fk_winners_periode` FOREIGN KEY (`id_periode`) REFERENCES `tbl_periode` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_winners_reward` FOREIGN KEY (`id_reward`) REFERENCES `tbl_reward` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
