-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2026 at 05:42 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
-- Table structure for table `tbl_promo_event`
--

CREATE TABLE `tbl_promo_event` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `type` varchar(50) NOT NULL,
  `short_description` text NOT NULL,
  `content` mediumtext NOT NULL,
  `image` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `button_text` varchar(100) NOT NULL,
  `button_url` varchar(255) NOT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `status` varchar(30) NOT NULL DEFAULT 'Active',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbl_promo_event`
--

INSERT INTO `tbl_promo_event` (`id`, `title`, `slug`, `type`, `short_description`, `content`, `image`, `location`, `start_date`, `end_date`, `button_text`, `button_url`, `is_featured`, `display_order`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Pembukaan Manna Kampus Condongcatur', 'opening-manna-kampus-condongcatur', 'Store Opening', 'Manna Kampus Condongcatur resmi dibuka Jumat, 31 Juli 2026. Nantikan promo opening, flash sale, spin wheel, dan berbagai produk gratis.', '<p>Manna Kampus Condongcatur resmi dibuka pada <strong>Jumat, 31 Juli 2026</strong>.</p><p>Kunjungi cabang baru kami dan nikmati promo opening, flash sale, spin wheel, free product, serta berbagai kejutan menarik lainnya.</p><p>Jam operasional mulai pukul <strong>08.30 sampai 21.30 WIB</strong>.</p>', 'promo-event-opening-condongcatur.webp', 'Condongcatur, Sleman, Yogyakarta', '2026-07-31', '2026-07-31', 'Lihat Detail', 'promo-event/opening-manna-kampus-condongcatur', 1, 1, 'Active', '2026-07-28 13:12:32', '2026-07-28 13:12:32'),
(2, 'Gebyar Undian Spektakuler 2026', 'gebyar-undian-spektakuler-2026', 'Gebyar Undian', 'Belanja sepanjang 2026 dan raih kesempatan memenangkan rumah, mobil, motor, serta berbagai hadiah elektronik menarik.', '<p>Ikuti <strong>Gebyar Undian Spektakuler Manna Kampus 2026</strong> dengan periode program 1 Januari sampai 31 Desember 2026.</p><p>Hadiah utama meliputi rumah tipe 48 beserta furniture, mobil Daihatsu Ayla, Honda Scoopy, smartphone, laptop, televisi, peralatan rumah tangga, sepeda, dan berbagai hadiah menarik lainnya.</p><p>Simpan bukti transaksi dan ikuti ketentuan program yang berlaku di Manna Kampus.</p>', 'promo-event-gebyar-undian-2026.webp', 'Manna Kampus', '2026-01-01', '2026-12-31', 'Lihat Detail', 'promo-event/gebyar-undian-spektakuler-2026', 1, 2, 'Active', '2026-07-28 13:12:32', '2026-07-28 13:12:32'),
(3, 'Bonus Voucher Belanja Rp50.000', 'bonus-voucher-belanja-50000', 'Promo Pembayaran', 'Dapatkan voucher belanja Rp50.000 untuk transaksi minimum Rp500.000 menggunakan kartu pembayaran pilihan.', '<p>Nikmati <strong>bonus voucher belanja Rp50.000</strong> untuk transaksi minimum Rp500.000 di Manna Kampus.</p><p>Promo berlaku untuk metode pembayaran pilihan dan tidak dapat digabungkan dengan program diskon lainnya. Kuota promo tersedia setiap hari selama periode program.</p>', 'promo-payment-voucher.webp', 'Seluruh outlet Manna Kampus', '2026-07-01', '2026-12-31', 'Lihat Ketentuan', 'promo-event/bonus-voucher-belanja-50000', 1, 1, 'Active', '2026-07-28 14:10:44', '2026-07-28 14:10:44'),
(4, 'Cashback Dompet Digital 10%', 'cashback-dompet-digital-10-persen', 'Promo Pembayaran', 'Bayar menggunakan dompet digital pilihan dan dapatkan cashback 10% hingga Rp75.000.', '<p>Dapatkan <strong>cashback 10% hingga Rp75.000</strong> untuk pembayaran menggunakan dompet digital pilihan.</p><p>Cashback diberikan sesuai ketentuan penyedia pembayaran dan kuota yang tersedia. Pastikan aplikasi pembayaran sudah diperbarui sebelum melakukan transaksi.</p>', 'promo-payment-wallet.webp', 'Seluruh outlet Manna Kampus', '2026-07-01', '2026-12-31', 'Lihat Ketentuan', 'promo-event/cashback-dompet-digital-10-persen', 1, 2, 'Active', '2026-07-28 14:10:44', '2026-07-28 14:10:44'),
(5, 'Potongan Kartu Kredit Rp80.000', 'potongan-kartu-kredit-80000', 'Promo Pembayaran', 'Nikmati potongan langsung Rp80.000 dengan minimum transaksi Rp800.000 menggunakan kartu kredit pilihan.', '<p>Nikmati <strong>potongan langsung Rp80.000</strong> dengan minimum transaksi Rp800.000 menggunakan kartu kredit pilihan.</p><p>Promo berlaku satu kali per nasabah per hari dan mengikuti kuota yang tersedia. Syarat serta ketentuan masing-masing penerbit kartu tetap berlaku.</p>', 'promo-payment-card.webp', 'Seluruh outlet Manna Kampus', '2026-07-01', '2026-12-31', 'Lihat Ketentuan', 'promo-event/potongan-kartu-kredit-80000', 1, 3, 'Active', '2026-07-28 14:10:44', '2026-07-28 14:10:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_promo_event`
--
ALTER TABLE `tbl_promo_event`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_promo_event_slug` (`slug`),
  ADD KEY `idx_promo_event_listing` (`status`,`is_featured`,`end_date`,`display_order`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_promo_event`
--
ALTER TABLE `tbl_promo_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
