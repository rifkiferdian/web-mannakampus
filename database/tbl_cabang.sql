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
-- Table structure for table `tbl_cabang`
--

CREATE TABLE `tbl_cabang` (
  `id` int(11) NOT NULL,
  `nama_cabang` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `jam_operasional` varchar(100) DEFAULT 'Buka · 08.00 - 21.30',
  `kontak` varchar(50) DEFAULT NULL,
  `badge_tipe` varchar(50) DEFAULT 'SUPERMARKET',
  `foto` varchar(255) DEFAULT 'default.jpg',
  `link_maps` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_cabang`
--

INSERT INTO `tbl_cabang` (`id`, `nama_cabang`, `alamat`, `jam_operasional`, `kontak`, `badge_tipe`, `foto`, `link_maps`) VALUES
(1, 'Manna Kampus 1 - Babarsari', 'Jl. Raya Solo - Yogyakarta No.KM. 7, Janti, Caturtunggal, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281', '08.30 - 21.30', '(0274)485288', 'SUPERMARKET', 'default.jpg', 'https://www.google.com/maps/place/Manna+Kampus+(Mirota+Kampus)+Babarsari/@-7.7831891,110.4119663,17z/data=!3m1!4b1!4m6!3m5!1s0x2e7a59eccfaf2939:0x2935e0ad5dd1cbe1!8m2!3d-7.7831891!4d110.4145412!16s%2Fg%2F1hc250dm1?entry=ttu&g_ep=EgoyMDI2MDgwNS4xIKXMDSoASAFQAw%3D%3D'),
(2, 'Manna Kampus 2 - C. Simanjuntak', 'Jl. C. Simanjuntak No.70, Terban, Kec. Gondokusuman, Kota Yogyakarta, Daerah Istimewa Yogyakarta 55223', '08.30 - 21.30', '(0274)561254', 'SUPERMARKET', 'default.jpg', 'https://www.google.com/maps/place/Manna+Kampus+(Mirota+Kampus+2)+Simanjuntak/@-7.7763551,110.3359266,13z/data=!4m10!1m2!2m1!1smanna+kampus!3m6!1s0x2e7a5835bdc19b13:0x2102f0914d826e06!8m2!3d-7.7763611!4d110.3745514!15sCgxtYW5uYSBrYW1wdXNaDiIMbWFubmEga2FtcHVzkgEUZGlzY291bnRfc3VwZXJtYXJrZXTgAQA!16s%2Fg%2F1tydqc6j?entry=ttu&g_ep=EgoyMDI2MDgwNS4xIKXMDSoASAFQAw%3D%3D'),
(3, 'Manna Kampus 3 - Menteri Supeno', 'Jl. Menteri Supeno No.38, Sorosutan, Kec. Umbulharjo, Kota Yogyakarta, Daerah Istimewa Yogyakarta 55162', '08.30 - 21.30', '(0274)386797', 'SUPERMARKET', 'default.jpg', 'https://www.google.com/maps/place/Manna+Kampus+(Mirota+Kampus)+Menteri+Supeno/@-7.7763591,110.3359267,13z/data=!4m10!1m2!2m1!1sManna+Kampus+(Mirota+Kampus+3)+supeno!3m6!1s0x2e7a570ab4e0b811:0x219de4d7bce6d757!8m2!3d-7.816267!4d110.379443!15sCiVNYW5uYSBLYW1wdXMgKE1pcm90YSBLYW1wdXMgMykgc3VwZW5vWiUiI21hbm5hIGthbXB1cyBtaXJvdGEga2FtcHVzIDMgc3VwZW5vkgELc3VwZXJtYXJrZXSaASNDaFpEU1VoTk1HOW5TMFZKUTBGblNVUXRaMDFmVFU5bkVBReABAPoBBAgkECw!16s%2Fg%2F1hm53r88z?entry=ttu&g_ep=EgoyMDI2MDgwNS4xIKXMDSoASAFQAw%3D%3D'),
(4, 'Manna Kampus 4 - Palagan', 'Jl. Palagan Tentara Pelajar No.31, Mudal, Sariharjo, Kec. Ngaglik, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55581', '08.30 - 21.30', '(0274)869990', 'SUPERMARKET', 'default.jpg', 'https://www.google.com/maps/place/Manna+Kampus+Palagan/@-7.7763551,110.3359266,13z/data=!3m1!5s0x2e7a58e00e633fcf:0x42d74f86dff812c7!4m10!1m2!2m1!1smanna+kampus!3m6!1s0x2e7a58e31a9c9eab:0x39d6a6018023142b!8m2!3d-7.7342609!4d110.3774034!15sCgxtYW5uYSBrYW1wdXNaDiIMbWFubmEga2FtcHVzkgELc3VwZXJtYXJrZXTgAQA!16s%2Fg%2F12hmcsdn1?entry=ttu&g_ep=EgoyMDI2MDgwNS4xIKXMDSoASAFQAw%3D%3D'),
(5, 'Manna Kampus 5 - Godean', 'Jl. Godean No.KM. 2.8, Kembang, Ngestiharjo, Kec. Kasihan, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55184', '08.30 - 21.30', '(0274)565612', 'SUPERMARKET', 'default.jpg', 'https://www.google.com/maps/place/Manna+Kampus+(Mirota+Kampus)+Godean/@-7.7763551,110.3359266,13z/data=!4m10!1m2!2m1!1smanna+kampus!3m6!1s0x2e7a59f02af0d11d:0x8b9783ed062b3931!8m2!3d-7.7808817!4d110.3498191!15sCgxtYW5uYSBrYW1wdXNaDiIMbWFubmEga2FtcHVzkgEUZGlzY291bnRfc3VwZXJtYXJrZXTgAQA!16s%2Fg%2F1td8n6n7?entry=ttu&g_ep=EgoyMDI2MDgwNS4xIKXMDSoASAFQAw%3D%3D'),
(6, 'Manna Kampus 6 - Imogiri Timur', 'Jl. Imogiri Tim. No.KM. 7, Grojogan, Wirokerten, Kec. Banguntapan, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55194', '08.00 - 21.30', '(0274)4285579', 'SUPERMARKET', 'default.jpg', 'https://www.google.com/maps/place/Manna+Kampus+(Mirota+Kampus)+Imogiri+Timur/@-7.7763551,110.3359266,13z/data=!4m10!1m2!2m1!1smanna+kampus!3m6!1s0x2e7a57b15cfb7e83:0x775553aa3fe92258!8m2!3d-7.8442059!4d110.3910584!15sCgxtYW5uYSBrYW1wdXNaDiIMbWFubmEga2FtcHVzkgELc3VwZXJtYXJrZXTgAQA!16s%2Fg%2F11mk5zpj6r?entry=ttu&g_ep=EgoyMDI2MDgwNS4xIKXMDSoASAFQAw%3D%3D'),
(7, 'Manna Kampus 7 - Keloran', 'Jl. Keloran, Senggotan, Tirtonirmolo, Kec. Kasihan, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55184', '08.30 - 21.30', '(0274)5060059', 'SUPERMARKET', 'default.jpg', 'https://www.google.com/maps/place/Manna+Kampus+(Mirota+Kampus)+Keloran+Bugisan/@-7.7763551,110.3359266,13z/data=!4m10!1m2!2m1!1smanna+kampus!3m6!1s0x2e7a57005596960f:0x49c05215c95a4804!8m2!3d-7.824246!4d110.3467563!15sCgxtYW5uYSBrYW1wdXNaDiIMbWFubmEga2FtcHVzkgEFc3RvcmXgAQA!16s%2Fg%2F11vk4qwwj_?entry=ttu&g_ep=EgoyMDI2MDgwNS4xIKXMDSoASAFQAw%3D%3D'),
(8, 'Manna Kampus 8 - Condong Catur', 'Jl. Rajawali Raya No.46, Manukan, Condongcatur, Kec. Depok, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55283', '08.00 - 21.30', '(0274)881371', 'SUPERMARKET', 'default.jpg', 'https://www.google.com/maps/place/Manna+Kampus+Condongcatur/@-7.7763551,110.3359266,13z/data=!4m10!1m2!2m1!1smanna+kampus!3m6!1s0x2e7a590079b4bea3:0x30c1626240146782!8m2!3d-7.7466513!4d110.399451!15sCgxtYW5uYSBrYW1wdXOSAQtzdXBlcm1hcmtldOABAA!16s%2Fg%2F11nqxmnhbf?entry=ttu&g_ep=EgoyMDI2MDgwNS4xIKXMDSoASAFQAw%3D%3D'),
(9, 'Manna Kampus Mini 1 - Pelemsewu', 'Jl. Pelemsewu No.C 1, Pandes, Panggungharjo, Kec. Sewon, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55188', '08.00 - 21.00', '', 'MINIMARKET', 'default.jpg', 'https://www.google.com/maps/place/Manna+Kampus+(Mirota+Kampus)+Mini+Pelemsewu/@-7.7763551,110.3359266,13z/data=!4m10!1m2!2m1!1smanna+kampus!3m6!1s0x2e7a57305ff74c1d:0xb9ff5018ad116cda!8m2!3d-7.8414052!4d110.3595943!15sCgxtYW5uYSBrYW1wdXNaDiIMbWFubmEga2FtcHVzkgENZ3JvY2VyeV9zdG9yZeABAA!16s%2Fg%2F11jp_b1d1w?entry=ttu&g_ep=EgoyMDI2MDgwNS4xIKXMDSoASAFQAw%3D%3D'),
(10, 'Manna Kampus Mini 2 - Diro', 'Jl. Bantul No.8, Diro, Pendowoharjo, Kec. Sewon, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55186', '08.00 - 21.30', '0895363202050', 'MINIMARKET', 'default.jpg', 'https://www.google.com/maps/place/Manna+Kampus+(Mirota+Kampus)+Mini+Diro/@-7.8618494,110.3048701,13z/data=!4m10!1m2!2m1!1smanna+kampus!3m6!1s0x2e7a57833a10f765:0x26f32593afaf5438!8m2!3d-7.8618494!4d110.339889!15sCgxtYW5uYSBrYW1wdXNaDiIMbWFubmEga2FtcHVzkgERY29udmVuaWVuY2Vfc3RvcmXgAQA!16s%2Fg%2F11r0w5n37v?entry=ttu&g_ep=EgoyMDI2MDgwNS4xIKXMDSoASAFQAw%3D%3D'),
(11, 'Manna Kampus Mini 3 - Minomartani', 'Jl. Kakap Raya, RT.019/RW.004, Mladangan, Minomartani, Kec. Ngaglik, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55581', 'Buka · 07.00 - 21.00', '082326151301', 'MINIMARKET', 'default.jpg', 'https://www.google.com/maps/place/Manna+Kampus+(Mirota+Kampus)+Mini+Minomartani/@-7.7763551,110.3359266,13z/data=!4m10!1m2!2m1!1smanna+kampus!3m6!1s0x2e7a59534c3d453b:0x1a8c7aa94e067f10!8m2!3d-7.7403528!4d110.4084285!15sCgxtYW5uYSBrYW1wdXNaDiIMbWFubmEga2FtcHVzkgERY29udmVuaWVuY2Vfc3RvcmXgAQA!16s%2Fg%2F11rjz301dd?entry=ttu&g_ep=EgoyMDI2MDgwNS4xIKXMDSoASAFQAw%3D%3D');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_cabang`
--
ALTER TABLE `tbl_cabang`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_cabang`
--
ALTER TABLE `tbl_cabang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
